<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Exception;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $loginField = filter_var($credentials['email'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if (Auth::attempt([$loginField => $credentials['email'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();

            /** @var User $user */
            $user = Auth::user();

            if ($user->role === 'admin') {
                return redirect()->intended(route('admin.dashboard'));
            }

            return redirect()->intended(route('consumer.dashboard.index'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'username' => 'required|string|unique:users,username|max:255',
            'email' => 'required|string|email|unique:users,email|max:255',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|in:admin,creator,artist,consumer',
        ]);

        $user = User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'role' => $data['role'],
        ]);

        Auth::login($user);

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('consumer.dashboard.index');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    /**
     * Redirect to Social Provider
     */
    public function redirectToProvider($provider)
    {
        if (!in_array($provider, ['google', 'facebook'])) {
            return redirect()->route('login')->with('error', 'Invalid social provider');
        }

        return Socialite::driver($provider)->redirect();
    }

    /**
     * Handle Social Provider Callback
     */
    public function handleProviderCallback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();
            return $this->loginOrCreateSocialUser($socialUser, $provider);
        } catch (Exception $e) {
            return redirect()->route('login')->with('error', 'Social login failed: ' . $e->getMessage());
        }
    }

    /**
     * Firebase Social Login (Web)
     */
    public function firebaseLogin(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
            'provider' => 'required|string|in:google,facebook,firebase'
        ]);

        try {
            $token = $request->token;
            $tokenParts = explode('.', $token);

            if (count($tokenParts) !== 3) {
                throw new Exception("Invalid token format");
            }

            $payload = json_decode(base64_decode($tokenParts[1]), true);

            if (!$payload || (!isset($payload['user_id']) && !isset($payload['sub']))) {
                throw new Exception("Invalid token payload");
            }

            // Map to social user structure
            $id = $payload['user_id'] ?? $payload['sub'];
            $email = $payload['email'] ?? null;
            $name = $payload['name'] ?? 'Social User';
            $avatar = $payload['picture'] ?? null;

            // Create a fake socialite user for internal logic
            $socialUser = new \Laravel\Socialite\Two\User();
            $socialUser->map([
                'id' => $id,
                'name' => $name,
                'email' => $email,
                'avatar' => $avatar,
            ]);

            return $this->loginOrCreateSocialUser($socialUser, $request->provider);

        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 401);
        }
    }

    protected function loginOrCreateSocialUser($socialUser, $provider)
    {
        $user = User::where($provider . '_id', $socialUser->getId())
            ->orWhere('email', $socialUser->getEmail())
            ->first();

        if ($user) {
            // Update provider ID if missing
            if ($provider === 'google' && !$user->google_id) {
                $user->update(['google_id' => $socialUser->getId(), 'is_google' => true]);
            } elseif ($provider === 'facebook' && !$user->facebook_id) {
                $user->update(['facebook_id' => $socialUser->getId(), 'is_facebook' => true]);
            }
        } else {
            // Create user
            $user = User::create([
                'username' => $socialUser->getName() ?? Str::random(10),
                'email' => $socialUser->getEmail(),
                'password' => bcrypt(Str::random(16)),
                'role' => 'creator', // Default
                'profile_image' => $socialUser->getAvatar(),
                'google_id' => $provider === 'google' ? $socialUser->getId() : null,
                'is_google' => $provider === 'google',
                'facebook_id' => $provider === 'facebook' ? $socialUser->getId() : null,
                'is_facebook' => $provider === 'facebook',
            ]);
        }

        Auth::login($user);
        request()->session()->regenerate();

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'redirect' => $user->role === 'admin' ? route('admin.dashboard') : route('consumer.dashboard.index')
            ]);
        }

        if ($user->role === 'admin') {
            return redirect()->intended(route('admin.dashboard'));
        }

        return redirect()->intended(route('consumer.dashboard.index'));
    }
}
