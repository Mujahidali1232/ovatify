<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Verification | Ovatify</title>
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen bg-[#121212] flex items-center justify-center text-white">

    <div class="w-full max-w-md text-center px-6">

        <!-- Logo -->
        <h1 class="text-purple-500 text-lg font-bold tracking-wide mb-6">
            Ovatify
        </h1>

        <!-- Title -->
        <h2 class="text-2xl font-semibold text-[#d946ef] mb-4">
            Forgot Password
        </h2>

        <!-- Subtitle -->
        <p class="text-lg text-white-300 mb-8">
            Code has been send to +1 111 ******99
        </p>

        <!-- OTP Inputs -->
        <div class="flex justify-center gap-4 mb-12">

            @for ($i = 0; $i < 4; $i++)
                <input type="text" maxlength="1" value="0"
                    class="w-12 h-12 text-center text-lg font-semibold
                           bg-[#18181b] border border-[#27272a]
                           rounded-lg focus:outline-none
                           focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500" />
            @endfor

        </div>

        <!-- Verify Button -->
        <button
            class="w-full bg-[#4f5dff] hover:bg-[#4350e6]
                   transition rounded-lg py-3 mb-4 mt-20
                   text-sm font-medium">
            Verify
        </button>

        <!-- Back Button -->
        <button
             onclick="window.location.href='{{ route('login') }}'"
            class="w-full border border-[#3f3f46]
                   rounded-lg py-3
                   text-sm text-gray-300
                   hover:bg-[#1c1c1f] transition">
            Back
        </button>

    </div>

</body>

</html>
