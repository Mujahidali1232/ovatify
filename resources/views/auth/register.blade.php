<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login | Ovatify</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-[#0f0f0f] min-h-screen flex items-center justify-center text-white">

    <div class="w-full max-w-7xl grid grid-cols-1 md:grid-cols-2 gap-12 px-8 py-8 lg:py-12 lg:px-16">

        <!-- LEFT SIDE (FORM) -->
        <div class="flex flex-col justify-center max-w-md">

            <!-- Logo -->
            <h1 class="text-purple-500 text-xl font-semibold mb-2">
                Ovatify
            </h1>

            <h2 class="text-3xl text-purple-400 font-bold mb-8">
                Sign up to get started
            </h2>

            <!-- Form -->
            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <div class="grid grid-cols-2 gap-4">
                    <!-- Username -->
                    <div>
                        <label class="block text-sm mb-2 text-gray-300">Username</label>
                        <input type="text" name="username" value="{{ old('username') }}" placeholder="Username" required
                            class="w-full bg-[#1c1c1c] border border-[#2a2a2a] rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500" />
                        @error('username')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Role -->
                    <div>
                        <label class="block text-sm mb-2 text-gray-300">Role</label>
                        <select name="role" class="w-full bg-[#1c1c1c] border border-[#2a2a2a] rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500 text-gray-300">
                            <option value="creator">Creator</option>
                            <option value="artist">Artist</option>
                            <option value="admin">Admin</option>
                        </select>
                        @error('role')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm mb-2 text-gray-300">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Email address" required
                        class="w-full bg-[#1c1c1c] border border-[#2a2a2a] rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500" />
                    @error('email')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <!-- Password -->
                    <div>
                        <label class="block text-sm mb-2 text-gray-300">Password</label>
                        <div style="position:relative;">
                            <input type="password" name="password" id="reg_password" placeholder="Password" required
                                class="w-full bg-[#1c1c1c] border border-[#2a2a2a] rounded-lg py-3 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500"
                                style="padding-left:16px; padding-right:46px;" />
                            <button type="button"
                                onclick="(function(b){var i=document.getElementById('reg_password');var hide=i.type==='text';i.type=hide?'password':'text';b.querySelector('.eye-on').style.display=hide?'none':'inline-block';b.querySelector('.eye-off').style.display=hide?'inline-block':'none';})(this)"
                                style="position:absolute; right:12px; top:50%; transform:translateY(-50%); background:transparent; border:0; color:#9ca3af; cursor:pointer; padding:4px; line-height:1;"
                                aria-label="Show password">
                                <i class="fa-solid fa-eye eye-off" style="display:inline-block;"></i>
                                <i class="fa-solid fa-eye-slash eye-on" style="display:none;"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label class="block text-sm mb-2 text-gray-300">Confirm</label>
                        <div style="position:relative;">
                            <input type="password" name="password_confirmation" id="reg_password_confirm" placeholder="Confirm" required
                                class="w-full bg-[#1c1c1c] border border-[#2a2a2a] rounded-lg py-3 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500"
                                style="padding-left:16px; padding-right:46px;" />
                            <button type="button"
                                onclick="(function(b){var i=document.getElementById('reg_password_confirm');var hide=i.type==='text';i.type=hide?'password':'text';b.querySelector('.eye-on').style.display=hide?'none':'inline-block';b.querySelector('.eye-off').style.display=hide?'inline-block':'none';})(this)"
                                style="position:absolute; right:12px; top:50%; transform:translateY(-50%); background:transparent; border:0; color:#9ca3af; cursor:pointer; padding:4px; line-height:1;"
                                aria-label="Show password">
                                <i class="fa-solid fa-eye eye-off" style="display:inline-block;"></i>
                                <i class="fa-solid fa-eye-slash eye-on" style="display:none;"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Register Button -->
                <button type="submit"
                    class="w-full bg-purple-600 hover:bg-purple-700 transition rounded-lg py-3 font-bold uppercase tracking-widest mt-4">
                    Create Account
                </button>
            </form>

            <!-- OR -->
            <div class="flex items-center my-6">
                <div class="flex-1 h-px bg-gray-700"></div>
                <span class="px-4 text-gray-400 text-sm font-bold">OR</span>
                <div class="flex-1 h-px bg-gray-700"></div>
            </div>

            <!-- Social Login -->
            <div class="flex gap-4">
                <!-- Google -->
                <button type="button" onclick="loginWithGoogle()" class="flex-1 flex items-center justify-center gap-2 bg-[#1c1c1c] border border-[#2a2a2a] rounded-full py-3 text-xs hover:bg-[#262626] transition font-bold">
                    <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-4 h-4">
                    Google
                </button>
                <!-- Facebook -->
                <button type="button" onclick="loginWithFacebook()" class="flex-1 flex items-center justify-center gap-2 bg-[#1c1c1c] border border-[#2a2a2a] rounded-full py-3 text-xs hover:bg-[#262626] transition font-bold">
                    <img src="https://www.svgrepo.com/show/448224/facebook.svg" class="w-5 h-5">
                    Facebook
                </button>
            </div>

            <script type="module">
                import { initializeApp } from "https://www.gstatic.com/firebasejs/10.8.0/firebase-app.js";
                import { getAuth, GoogleAuthProvider, FacebookAuthProvider, signInWithPopup } from "https://www.gstatic.com/firebasejs/10.8.0/firebase-auth.js";

                const firebaseConfig = {
                    apiKey: "{{ env('FIREBASE_API_KEY') }}",
                    authDomain: "{{ env('FIREBASE_AUTH_DOMAIN') }}",
                    projectId: "{{ env('FIREBASE_PROJECT_ID') }}",
                    storageBucket: "{{ env('FIREBASE_STORAGE_BUCKET') }}",
                    messagingSenderId: "{{ env('FIREBASE_MESSAGING_SENDER_ID') }}",
                    appId: "{{ env('FIREBASE_APP_ID') }}"
                };

                const app = initializeApp(firebaseConfig);
                const auth = getAuth(app);

                window.loginWithGoogle = async () => {
                    const provider = new GoogleAuthProvider();
                    try {
                        const result = await signInWithPopup(auth, provider);
                        const idToken = await result.user.getIdToken();
                        handleFirebaseLogin(idToken, 'google');
                    } catch (error) {
                        console.error(error);
                        alert("Google login failed: " + error.message);
                    }
                };

                window.loginWithFacebook = async () => {
                    const provider = new FacebookAuthProvider();
                    try {
                        const result = await signInWithPopup(auth, provider);
                        const idToken = await result.user.getIdToken();
                        handleFirebaseLogin(idToken, 'facebook');
                    } catch (error) {
                        console.error(error);
                        alert("Facebook login failed: " + error.message);
                    }
                };

                async function handleFirebaseLogin(token, provider) {
                    try {
                        const response = await fetch("{{ route('social.firebase-login') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                "Accept": "application/json"
                            },
                            body: JSON.stringify({ token, provider })
                        });
                        const data = await response.json();
                        if (data.success) {
                            window.location.href = data.redirect;
                        } else {
                            alert(data.message);
                        }
                    } catch (error) {
                        console.error(error);
                        alert("Backend authentication failed");
                    }
                }
            </script>

            <!-- Login Link -->
            <p class="mt-6 text-center text-sm text-gray-400">
                Already have an account?
                <a href="{{ route('login') }}" class="text-purple-400 font-bold hover:underline">Login</a>
            </p>

        </div>

        <!-- RIGHT SIDE (ILLUSTRATION) -->
        <div class="hidden lg:flex items-center justify-center relative">

            <!-- Illustration -->
            <img src="{{ asset('images/login.PNG') }}" alt="Login Illustration"
                class="relative z-10 max-w-md" />

        </div>

    </div>

</body>

</html>
