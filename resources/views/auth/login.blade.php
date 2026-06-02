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
                Login to get started
            </h2>

            <!-- Form -->
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Email / Username -->
                <div>
                    <label class="block text-sm mb-2 text-gray-300">Email or Username</label>
                    <input type="text" name="email" value="{{ old('email') }}" placeholder="Email or Username" required
                        class="w-full bg-[#1c1c1c] border border-[#2a2a2a] rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500" />
                    @error('email')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-sm mb-2 text-gray-300">Password</label>
                    <div style="position:relative;">
                        <input type="password" name="password" id="login_password" placeholder="Password" required
                            class="w-full bg-[#1c1c1c] border border-[#2a2a2a] rounded-lg py-3 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500"
                            style="padding-left:16px; padding-right:46px;" />
                        <button type="button"
                            onclick="(function(b){var i=document.getElementById('login_password');var hide=i.type==='text';i.type=hide?'password':'text';b.querySelector('.eye-on').style.display=hide?'none':'inline-block';b.querySelector('.eye-off').style.display=hide?'inline-block':'none';})(this)"
                            style="position:absolute; right:12px; top:50%; transform:translateY(-50%); background:transparent; border:0; color:#9ca3af; cursor:pointer; padding:4px; line-height:1;"
                            aria-label="Show password" title="Show / hide password">
                            <i class="fa-solid fa-eye eye-off" style="display:inline-block;"></i>
                            <i class="fa-solid fa-eye-slash eye-on" style="display:none;"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Forgot -->
                <div class="text-right">
                    <a href="{{ route('forgot.password') }}" class="text-sm text-purple-400 hover:underline">
                        Forgot password?
                    </a>
                </div>

                <!-- Login Button -->
                <button type="submit"
                    class="w-full bg-purple-600 hover:bg-purple-700 transition rounded-lg py-3 font-bold uppercase tracking-wider">
                    Login
                </button>
            </form>

            <!-- Signup -->
            <p class="mt-6 text-center text-sm text-gray-400">
                Don’t have an account?
                <a href="{{ route('register') }}" class="text-purple-400 font-bold hover:underline">Sign up</a>
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
