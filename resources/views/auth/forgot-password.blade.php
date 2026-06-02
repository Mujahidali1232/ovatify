<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Forgot Password | Ovatify</title>
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen bg-[#0f0f10] flex items-center justify-center text-white">

    <div class="w-full max-w-md">

        <!-- Logo / Brand -->
        <div class="text-center mb-10">
            <h1 class="text-purple-500 text-lg font-bold tracking-wide mb-6">
            Ovatify
        </h1>
            <h2 class="text-2xl font-semibold text-[#d946ef] mb-4">
                Forgot Password
            </h2>
            <p class="mt-2 text-sm text-white-300">
                Select which contact details should we use to reset your password
            </p>
        </div>

        <!-- Options -->
        <div class="space-y-4">

            <!-- SMS Option -->
            <label
                class="flex items-center gap-4 p-4 rounded-xl
                       bg-[#1a1a1d] border border-transparent
                       hover:border-blue-500 cursor-pointer transition">
                <div class="flex items-center justify-center w-10 h-10 rounded-full bg-[#232327]">
                    <!-- Chat Icon --> 
                    <img src="https://www.svgrepo.com/show/525761/chat-round-dots.svg" class="w-5 h-5">
                </div>

                <div>
                    <p class="text-xs text-blue-400 mb-1">via SMS:</p>
                    <p class="text-sm font-medium text-gray-200">+1 111 ***** 99</p>
                </div>

                <input type="radio" name="method" class="hidden">
            </label>

            <!-- Email Option -->
            <label
                class="flex items-center gap-4 p-4 rounded-xl
                       bg-[#1a1a1d] border border-transparent
                       hover:border-blue-500 cursor-pointer transition">
                <div class="flex items-center justify-center w-10 h-10 rounded-full bg-[#232327]">
                    <!-- Mail Icon -->
                    <svg class="w-5 h-7 text-blue-500" fill="none" stroke="currentColor" stroke-width="1.8"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l9 6 9-6m-18 8h18V8H3v8z" />
                    </svg>
                </div>

                <div>
                    <p class="text-xs text-blue-400 mb-1">via Email:</p>
                    <p class="text-sm font-medium text-gray-200">
                        ***ey@yourdomain.com
                    </p>
                </div>

                <input type="radio" name="method" class="hidden">
            </label>

        </div>

        <!-- Buttons -->
        <div class="mt-20 space-y-4">

            <button
                class="w-full py-3 rounded-lg
                       bg-blue-600 hover:bg-blue-500
                       text-sm font-medium transition">
                Continue
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

</body>

</html>
