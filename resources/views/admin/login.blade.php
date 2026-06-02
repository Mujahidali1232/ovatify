<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ovatify Admin — Login</title>
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background:
                radial-gradient(circle at 20% 30%, rgba(255, 0, 255, 0.08), transparent 40%),
                radial-gradient(circle at 80% 70%, rgba(0, 180, 255, 0.05), transparent 40%),
                #0F0F0F;
        }
        .glow { box-shadow: 0 0 80px -10px rgba(255, 0, 255, 0.25); }
    </style>
</head>
<body class="text-white font-inter min-h-screen flex items-center justify-center px-4">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-accent tracking-tight">Ovatify</h1>
            <p class="text-xs uppercase tracking-widest text-white/40 mt-2 font-medium">Admin Panel</p>
        </div>

        <div class="bg-[#1A1A1A] border border-white/10 rounded-2xl p-8 glow">
            <h2 class="text-xl font-semibold mb-1">Sign in</h2>
            <p class="text-sm text-gray-500 mb-6">Use your administrator credentials.</p>

            @if(session('error'))
                <div class="mb-4 bg-red-500/10 border border-red-500/20 text-red-400 px-3 py-2.5 rounded-lg text-sm">
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 bg-red-500/10 border border-red-500/20 text-red-400 px-3 py-2.5 rounded-lg text-sm">
                    @foreach($errors->all() as $err) <div>{{ $err }}</div> @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs uppercase tracking-wider text-white/50 mb-2">Email</label>
                    <input type="email" name="email" required autofocus value="{{ old('email') }}"
                           class="w-full bg-[#0F0F0F] border border-white/10 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-accent transition-colors"
                           placeholder="admin@ovatify.com">
                </div>

                <div>
                    <label class="block text-xs uppercase tracking-wider text-white/50 mb-2">Password</label>
                    <div style="position:relative;">
                        <input type="password" name="password" id="admin_password" required
                               class="w-full bg-[#0F0F0F] border border-white/10 rounded-lg py-3 text-sm focus:outline-none focus:border-accent transition-colors"
                               style="padding-left:16px; padding-right:46px;"
                               placeholder="••••••••">
                        <button type="button" id="admin_password_toggle"
                                onclick="(function(b){var i=document.getElementById('admin_password');var hide=i.type==='text';i.type=hide?'password':'text';b.querySelector('.eye-on').style.display=hide?'none':'inline-block';b.querySelector('.eye-off').style.display=hide?'inline-block':'none';})(this)"
                                style="position:absolute; right:12px; top:50%; transform:translateY(-50%); background:transparent; border:0; color:rgba(255,255,255,0.4); cursor:pointer; padding:4px; line-height:1;"
                                aria-label="Show password" title="Show / hide password">
                            <i class="fa-solid fa-eye eye-off" style="display:inline-block;"></i>
                            <i class="fa-solid fa-eye-slash eye-on" style="display:none;"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="w-full bg-accent hover:bg-accent/90 text-white font-semibold py-3 rounded-lg transition-colors mt-6">
                    Sign in
                </button>
            </form>

            <p class="text-[11px] text-white/30 text-center mt-6">
                Authorized personnel only. All activity is logged.
            </p>
        </div>
    </div>
</body>
</html>
