<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Resources\UserResource;
use Illuminate\Support\Str;

class SocialAuthController extends Controller
{
    /**
     * Redirect the user to the social provider's authentication page.
     */
    public function redirectToProvider($provider)
    {
        if (!in_array($provider, ['google', 'facebook'])) {
            return response()->json(['error' => 'Invalid provider'], 400);
        }

        return Socialite::driver($provider)->stateless()->redirect();
    }

    /**
     * Handle the provider callback.
     */
    public function handleProviderCallback($provider)
    {
        try {
            if (!in_array($provider, ['google', 'facebook'])) {
                return response()->json(['error' => 'Invalid provider'], 400);
            }

            $socialUser = Socialite::driver($provider)->stateless()->user();

            return $this->loginOrCreateUser($socialUser, $provider);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Login failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Authenticate using a social token from the frontend.
     */
    public function socialLogin(Request $request)
    {
        $request->validate([
            'provider' => 'required|string|in:google,facebook,firebase', // added firebase as a possible string if they pass it
            'token' => 'required|string',
        ]);

        $provider = $request->provider;
        $token = $request->token;

        try {
            $payload = null;
            // Split the JWT ID token into parts
            $tokenParts = explode('.', $token);

            if (count($tokenParts) === 3) {
                // Decode the payload
                $payload = json_decode(base64_decode($tokenParts[1]), true);
            } else {
                // Fallback for concatenated (dot-less) tokens
                $offset = 0;
                while (($pos = strpos($token, 'eyJ', $offset)) !== false) {
                    $offset = $pos + 3;
                    $substr = substr($token, $pos);
                    for ($i = strlen($substr); $i > 10; $i--) {
                        $chunk = substr($substr, 0, $i);
                        $pad = strlen($chunk) % 4;
                        $padded = $chunk . str_repeat('=', $pad == 0 ? 0 : 4 - $pad);
                        $decoded = base64_decode($padded, true);
                        if ($decoded && substr($decoded, 0, 1) === '{' && substr($decoded, -1) === '}') {
                            $json = json_decode($decoded, true);
                            if ($json && (isset($json['user_id']) || isset($json['sub']))) {
                                $payload = $json;
                                break 2;
                            }
                        }
                    }
                }
            }

            if (!$payload || (!isset($payload['user_id']) && !isset($payload['sub']))) {
                throw new Exception('Invalid Firebase ID token format or missing required payload data.');
            }

            // Extract user information from the Firebase ID Token payload
            // Firebase uses 'user_id' typically, Google might just use 'sub'
            $id = $payload['user_id'] ?? $payload['sub'];
            $email = $payload['email'] ?? null;
            $name = $payload['name'] ?? 'User';
            $avatar = $payload['picture'] ?? null;

            // Create a pseudo Socialite user object so we don't have to change the loginOrCreateUser logic
            $socialUser = new \Laravel\Socialite\Two\User();
            $socialUser->map([
                'id' => $id,
                'nickname' => $name,
                'name' => $name,
                'email' => $email,
                'avatar' => $avatar,
            ]);

            return $this->loginOrCreateUser($socialUser, $provider);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Authentication failed: ' . $e->getMessage()
            ], 401);
        }
    }

    /**
     * Helper to login or create the user.
     */
    protected function loginOrCreateUser($socialUser, $provider)
    {
        $user = null;

        // Try to find the user by provider ID first
        if ($provider === 'google') {
            $user = User::where('google_id', $socialUser->getId())->first();
        } elseif ($provider === 'facebook') {
            $user = User::where('facebook_id', $socialUser->getId())->first();
        }

        // If not found by provider ID, try to find by email (if email is provided)
        if (!$user && $socialUser->getEmail()) {
            $user = User::where('email', $socialUser->getEmail())->first();
        }

        if ($user) {
            // Update provider ID if not set; promote to verified since the provider attested the identity.
            $updateData = [];
            if ($provider === 'google' && !$user->google_id) {
                $updateData['google_id'] = $socialUser->getId();
                $updateData['is_google'] = true;
            } elseif ($provider === 'facebook' && !$user->facebook_id) {
                $updateData['facebook_id'] = $socialUser->getId();
                $updateData['is_facebook'] = true;
            }
            if (!$user->is_verified) {
                $updateData['is_verified'] = true;
            }
            if ($socialUser->getEmail() && is_null($user->email_verified_at)) {
                $updateData['email_verified_at'] = now();
            }
            if (!empty($updateData)) {
                $user->update($updateData);
                $user->refresh();
            }
        } else {
            // Create a new user. Social-provider sign-up implies the email is already verified.
            $user = User::create([
                'username' => $socialUser->getNickname() ?? $socialUser->getName() ?? Str::random(10),
                'email' => $socialUser->getEmail(),
                'password' => bcrypt(Str::random(16)), // Dummy password
                'google_id' => $provider === 'google' ? $socialUser->getId() : null,
                'facebook_id' => $provider === 'facebook' ? $socialUser->getId() : null,
                'is_google' => $provider === 'google',
                'is_facebook' => $provider === 'facebook',
                'profile_image' => $socialUser->getAvatar(),
                'role' => 'consumer',
                'is_verified' => true,
            ]);

            if ($socialUser->getEmail()) {
                $user->email_verified_at = now();
                $user->save();
            }
        }

        $token = $user->createToken('social_login')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Successfully authenticated',
            'token' => $token,
            'user' => new UserResource($user),
        ]);
    }
}
