<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SignupRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\VerificationCode;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Services\SmsService;
use App\Mail\VerificationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Exception;

class AuthController extends Controller
{
    protected int $otpLength = 4;
    protected int $otpTTLMinutes = 5;

    public function signup(SignupRequest $request, SmsService $smsService)
    {
        $data = $request->validated();

        DB::beginTransaction();
        try {
            $user = User::create([
                'username' => $data['username'],
                'phone' => $data['phone'] ?? null,
                'email' => $data['email'] ?? null,
                'password' => $data['password'],
                'role' => $data['role'] ?? 'consumer',
                'is_verified' => false,
            ]);

            $type = $data['email'] ? 'email' : ($data['phone'] ? 'phone' : null);
            $code = null;

            if ($type) {
                $code = $this->generateCode($this->otpLength);

                VerificationCode::create([
                    'user_id' => $user->id,
                    'code' => $code,
                    'type' => $type,
                    'expires_at' => Carbon::now()->addMinutes($this->otpTTLMinutes)
                ]);
            }

            DB::commit();

            if ($type) {
                try {
                    if ($type === 'email') {
                        Log::info("Attempting to send verification email to: " . $user->email);
                        Mail::to($user->email)->send(new VerificationMail($user, $code));
                        Log::info("Verification email sent successfully to: " . $user->email);
                    } else {
                        $msg = "Your verification code is: {$code}";
                        $smsService->send($user->phone, $msg);
                    }
                } catch (\Exception $e) {
                    Log::error('Failed to send verification code during signup: ' . $e->getMessage());
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'User created. Verification code sent to your email.',
                'requires_verification' => true,
                'user_id' => $user->id,
                'email' => $user->email,
                'data' => UserResource::collection(collect([$user])),
                'verification_code' => config('app.debug') ? $code : null,
            ], 201);

        } catch (Exception $e) {
            if (DB::transactionLevel() > 0) {
                DB::rollBack();
            }
            Log::error('Signup error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Signup failed', 'error' => $e->getMessage()], 500);
        }
    }

    public function login(LoginRequest $request, SmsService $smsService)
    {
        $credentials = $request->validated();
        $user = User::where('email', $credentials['login'])
            ->orWhere('username', $credentials['login'])
            ->orWhere('phone', $credentials['login'])
            ->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response()->json(['success' => false, 'message' => 'Invalid email or password'], 401);
        }

        if (!$user->is_active) {
            return response()->json(['success' => false, 'message' => 'Account inactive'], 403);
        }

        if (!$user->is_verified) {
            $code = $this->reissueOtp($user, $smsService);

            return response()->json([
                'success' => false,
                'requires_verification' => true,
                'message' => 'Account not verified. A new verification code has been sent.',
                'user_id' => $user->id,
                'email' => $user->email,
                'verification_code' => config('app.debug') ? $code : null,
            ], 403);
        }

        return response()->json([
            'success' => true,
            'message' => 'Login successfully.',
            'role' => $user->role,
            'token' => $user->createToken('auth_token')->plainTextToken,
            'user' => new UserResource($user),
        ]);
    }

    protected function reissueOtp(User $user, SmsService $smsService): ?string
    {
        $type = $user->email ? 'email' : ($user->phone ? 'phone' : null);
        if (!$type) {
            return null;
        }

        VerificationCode::where('user_id', $user->id)
            ->where('type', $type)
            ->where('used', false)
            ->update(['used' => true]);

        $code = $this->generateCode($this->otpLength);

        VerificationCode::create([
            'user_id' => $user->id,
            'code' => $code,
            'type' => $type,
            'expires_at' => Carbon::now()->addMinutes($this->otpTTLMinutes),
        ]);

        try {
            if ($type === 'email') {
                Mail::to($user->email)->send(new VerificationMail($user, $code));
                Log::info("Verification email re-issued to: {$user->email}");
            } else {
                $smsService->send($user->phone, "Your verification code is: {$code}");
            }
        } catch (\Exception $e) {
            Log::error('Failed to re-issue OTP: ' . $e->getMessage());
        }

        return $code;
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['success' => true, 'message' => 'Logged out.']);
    }

    protected function generateCode(int $len = 4): string
    {
        return (string) random_int(10 ** ($len - 1), (10 ** $len) - 1);
    }
}
