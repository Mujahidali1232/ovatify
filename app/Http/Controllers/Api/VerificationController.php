<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Verification\SendCodeRequest;
use App\Http\Requests\Verification\VerifyCodeRequest;
use App\Models\User;
use App\Models\VerificationCode;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Services\SmsService;
use App\Notifications\VerificationCodeNotification;
use Illuminate\Support\Facades\Log;

class VerificationController extends Controller
{
    protected int $otpLength = 4;
    protected int $otpTTLMinutes = 5;

    public function send(SendCodeRequest $request, SmsService $smsService)
    {
        $data = $request->validated();

        $user = null;
        if (!empty($data['email'])) {
            $user = User::where('email', $data['email'])->first();
        } elseif (!empty($data['phone'])) {
            $user = User::where('phone', $data['phone'])->first();
        }

        if (!$user) {
            return response()->json(['success'=>false,'message'=>'User not found'],404);
        }

        DB::beginTransaction();
        try {
            // invalidate previous codes for the same type
            VerificationCode::where('user_id', $user->id)
                ->where('type', $data['type'])
                ->where('used', false)
                ->update(['used' => true]);

            $code = (string) random_int(10**($this->otpLength-1), (10**$this->otpLength)-1);
            $vc = VerificationCode::create([
                'user_id' => $user->id,
                'code' => $code,
                'type' => $data['type'],
                'expires_at' => Carbon::now()->addMinutes($this->otpTTLMinutes)
            ]);

            if ($data['type'] === 'email') {
                Log::info("Attempting to resend verification email to: " . $user->email);
                \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\VerificationMail($user, $code));
                Log::info("Verification email resent successfully to: " . $user->email);
            } else {
                $smsService->send($user->phone, "Your verification code: {$code}");
            }

            DB::commit();
            return response()->json(['success'=>true,'message'=>'Verification code sent.']);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('SendCode error: '.$e->getMessage());
            return response()->json(['success'=>false,'message'=>'Failed to send code'],500);
        }
    }

    public function verify(VerifyCodeRequest $request)
    {
        $data = $request->validated();

        $user = User::where('email', $data['email'])->first();

        $vc = VerificationCode::where('user_id', $user->id)
            ->where('code', $data['code'])
            ->where('used', false)
            ->latest()
            ->first();

        if (!$vc) {
            return response()->json(['success'=>false,'message'=>'Invalid code'], 400);
        }

        if ($vc->isExpired()) {
            return response()->json(['success'=>false,'message'=>'Code expired'], 400);
        }

        DB::beginTransaction();
        try {
            $vc->used = true;
            $vc->save();

            $user = $vc->user;
            if ($vc->type === 'email') {
                $user->email_verified_at = Carbon::now();
            } else {
                $user->phone_verified_at = Carbon::now();
            }
            $user->is_verified = true;
            $user->save();

            $vc->delete();

            $token = $user->createToken('auth_token')->plainTextToken;

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Verified successfully',
                'token' => $token,
                'role' => $user->role,
                'user' => new \App\Http\Resources\UserResource($user),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('VerifyCode error: '.$e->getMessage());
            return response()->json(['success'=>false,'message'=>'Verification failed'],500);
        }
    }
}

