<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Create New Password | Ovatify</title>
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen bg-[#0f0f10] text-white flex items-center justify-center">

    <div class="w-full max-w-6xl px-10 grid grid-cols-1 md:grid-cols-2 gap-10 items-center">

        <!-- LEFT SIDE -->
        <div>
            <!-- Brand -->
            <h1 class="text-purple-500 text-lg font-bold tracking-wide mb-6">
                Ovatify
            </h1>

            <h2 class="text-2xl font-semibold text-fuchsia-500 mb-2">
                Create new password
            </h2>

            <p class="text-sm text-white-400 mb-6 mt-16">
                Create Your New Password
            </p>

            <!-- Password Input -->
            <div class="mb-4" style="position:relative;">
                <input type="password" id="cp_password" name="password" placeholder="********"
                    class="w-full bg-[#1a1a1d] border border-[#2a2a2e]
                       rounded-lg py-3
                       text-sm text-gray-200
                       placeholder-gray-500
                       focus:outline-none focus:ring-2 focus:ring-blue-500"
                    style="padding-left:16px; padding-right:46px;" />

                <!-- Eye toggle -->
                <button type="button"
                    onclick="(function(b){var i=document.getElementById('cp_password');var hide=i.type==='text';i.type=hide?'password':'text';b.querySelector('.eye-on').style.display=hide?'none':'inline-block';b.querySelector('.eye-off').style.display=hide?'inline-block':'none';})(this)"
                    style="position:absolute; right:12px; top:50%; transform:translateY(-50%); background:transparent; border:0; color:#9ca3af; cursor:pointer; padding:4px; line-height:1;"
                    aria-label="Show password">
                    <svg width="16" height="16" class="eye-off" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" style="display:inline-block;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <svg width="16" height="16" class="eye-on" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" style="display:none;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18M10.477 10.477a3 3 0 104.243 4.243M9.88 4.24A10.95 10.95 0 0112 4c4.478 0 8.268 2.943 9.542 7a10.974 10.974 0 01-4.255 5.31M6.617 6.617A10.97 10.97 0 002.458 12c1.274 4.057 5.064 7 9.542 7 1.21 0 2.376-.215 3.456-.61" />
                    </svg>
                </button>
            </div>

            <!-- Remember Me -->
            <div class="flex items-center mb-6">
                <input type="checkbox" checked
                    class="w-4 h-4 rounded border-[#3f3f46]
                       bg-[#1a1a1d] text-blue-600
                       focus:ring-blue-500">
                <label class="ml-2 text-xs text-gray-400">
                    Remember me
                </label>
            </div>

            <!-- Buttons -->
            <div class="space-y-4 w-full">
                <button onclick="showSuccessModal()" type="button"
                    class="w-full py-3 rounded-lg
                       bg-blue-600 hover:bg-blue-500
                       text-sm font-medium transition">
                    Create
                </button>

                <button onclick="window.location.href='{{ route('login') }}'"
                    class="w-full py-3 rounded-lg
                       border border-[#3f3f46]
                       text-sm text-gray-300
                       hover:bg-[#1c1c1f] transition">
                    Back
                </button>
            </div>
        </div>

        <!-- RIGHT SIDE (ILLUSTRATION) -->
        <div class="hidden md:flex items-center justify-center relative">

            <!-- Illustration -->
            <img src="{{ asset('images/createpass.PNG') }}" alt="Create Password Illustration"
                class="relative z-10 max-w-md" />

        </div>

    </div>

    <!-- SUCCESS MODAL -->
    <div id="successModal"
        class="fixed inset-0 bg-black/70 backdrop-blur-sm
           hidden items-center justify-center z-50">

        <div
            class="bg-[#1a1a1d] rounded-2xl
                px-10 py-12
                text-center
                max-w-md w-full
                animate-fadeIn">

            <!-- Icon -->
            <div
                class="relative mx-auto mb-6 w-28 h-28
                    rounded-full bg-fuchsia-600
                    flex items-center justify-center">

                <!-- Floating dots -->
                <span class="absolute -top-2 -left-2 w-3 h-3 bg-fuchsia-500 rounded-full"></span>
                <span class="absolute top-4 -right-3 w-2 h-2 bg-fuchsia-500 rounded-full"></span>
                <span class="absolute bottom-3 -left-3 w-2.5 h-2.5 bg-fuchsia-500 rounded-full"></span>

                <!-- Shield Check -->
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" stroke-width="2.5"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 2l7 4v6c0 5-3.5 9-7 10
                         -3.5-1-7-5-7-10V6l7-4z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4" />
                </svg>
            </div>

            <!-- Text -->
            <h2 class="text-xl font-semibold mb-2">
                Congratulations!
            </h2>

            <p class="text-sm text-gray-400 mb-8">
                Your account is ready to use.
                You will be redirected to the Home page in a few seconds..
            </p>

            <!-- Loader -->
            <div class="flex justify-center">
                <div
                    class="w-10 h-10 border-4 border-fuchsia-500
                        border-t-transparent rounded-full animate-spin">
                </div>
            </div>

        </div>
    </div>

    <script>
        function showSuccessModal() {
            const modal = document.getElementById('successModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            // Redirect after 3.5 seconds
            setTimeout(() => {
                window.location.href = "{{ route('login') }}";
            }, 3500);
        }
    </script>


</body>

</html>
