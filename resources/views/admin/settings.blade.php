@extends('layouts.admin')
@section('title', 'Settings')
@section('page_title', 'Settings')

@section('content')
@if(session('info'))
    <div class="mb-6 bg-blue-500/10 border border-blue-500/20 text-blue-300 px-4 py-3 rounded-xl text-sm">
        <i class="fa-solid fa-circle-info mr-2"></i> {{ session('info') }}
    </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    {{-- ACCOUNT SECURITY --}}
    <div class="lg:col-span-2 admin-card p-6">
        <div class="flex items-center gap-3 mb-2">
            <i class="fa-solid fa-shield-halved text-accent"></i>
            <h3 class="font-semibold text-lg">Account Security</h3>
        </div>
        <p class="text-xs text-white/40 mb-6">Change your administrator credentials. Both actions require your current password for confirmation.</p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- CHANGE USERNAME --}}
            <form method="POST" action="{{ route('admin.account.username') }}" class="space-y-4">
                @csrf
                <h4 class="text-sm font-semibold text-white/80 flex items-center gap-2 mb-2">
                    <i class="fa-solid fa-user text-white/40 text-xs"></i> Change Username
                </h4>

                <div>
                    <label class="block text-[10px] uppercase tracking-widest text-white/40 mb-1">Current username</label>
                    <input type="text" value="{{ auth()->user()->username }}" disabled
                           class="w-full bg-[#0F0F0F]/60 border border-white/5 rounded-lg px-3 py-2.5 text-sm text-white/50">
                </div>

                <div>
                    <label class="block text-[10px] uppercase tracking-widest text-white/40 mb-1">New username</label>
                    <input type="text" name="username" required minlength="3" maxlength="50"
                           value="{{ old('username') }}"
                           placeholder="e.g. ovatify_admin"
                           class="w-full bg-[#0F0F0F] border border-white/10 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-accent">
                    @error('username')<p class="text-xs text-red-400 mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-[10px] uppercase tracking-widest text-white/40 mb-1">Current password</label>
                    <input type="password" name="current_password" required autocomplete="current-password"
                           class="w-full bg-[#0F0F0F] border border-white/10 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-accent">
                    @error('current_password')<p class="text-xs text-red-400 mt-1">{{ $message }}</p>@enderror
                </div>

                <button type="submit" class="w-full bg-accent text-white px-4 py-2.5 rounded-lg text-sm font-semibold hover:opacity-90 transition-opacity">
                    Update Username
                </button>
            </form>

            {{-- CHANGE PASSWORD --}}
            <form method="POST" action="{{ route('admin.account.password') }}" class="space-y-4">
                @csrf
                <h4 class="text-sm font-semibold text-white/80 flex items-center gap-2 mb-2">
                    <i class="fa-solid fa-key text-white/40 text-xs"></i> Change Password
                </h4>

                <div>
                    <label class="block text-[10px] uppercase tracking-widest text-white/40 mb-1">Current password</label>
                    <input type="password" name="current_password" required autocomplete="current-password"
                           class="w-full bg-[#0F0F0F] border border-white/10 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-accent">
                    @error('current_password')<p class="text-xs text-red-400 mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-[10px] uppercase tracking-widest text-white/40 mb-1">New password</label>
                    <input type="password" name="new_password" required minlength="8" autocomplete="new-password"
                           class="w-full bg-[#0F0F0F] border border-white/10 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-accent">
                    @error('new_password')<p class="text-xs text-red-400 mt-1">{{ $message }}</p>@enderror
                    <p class="text-[10px] text-white/30 mt-1">Min 8 characters. Cannot match current or previous password.</p>
                </div>

                <div>
                    <label class="block text-[10px] uppercase tracking-widest text-white/40 mb-1">Confirm new password</label>
                    <input type="password" name="new_password_confirmation" required minlength="8" autocomplete="new-password"
                           class="w-full bg-[#0F0F0F] border border-white/10 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-accent">
                </div>

                <button type="submit" class="w-full bg-accent text-white px-4 py-2.5 rounded-lg text-sm font-semibold hover:opacity-90 transition-opacity">
                    Update Password
                </button>
            </form>
        </div>
    </div>

    {{-- GENERAL CONFIG (existing — cosmetic placeholder until persisted) --}}
    <form action="{{ route('admin.settings.update') }}" method="POST" class="admin-card p-6 lg:col-span-2">
        @csrf
        <div class="flex items-center gap-3 mb-6">
            <i class="fa-solid fa-sliders text-accent"></i>
            <h3 class="font-semibold text-lg">General</h3>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-[10px] uppercase tracking-widest text-white/40 mb-1">Site Name</label>
                <input type="text" name="site_name" value="Ovatify"
                       class="w-full bg-[#0F0F0F] border border-white/10 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-accent">
            </div>
            <div>
                <label class="block text-[10px] uppercase tracking-widest text-white/40 mb-1">Support Email</label>
                <input type="email" name="support_email" value="support@ovatify.com"
                       class="w-full bg-[#0F0F0F] border border-white/10 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-accent">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
            <div>
                <label class="block text-[10px] uppercase tracking-widest text-white/40 mb-1">Platform Transaction Fee (%)</label>
                <input type="number" name="transaction_fee" value="8" min="0" max="100" step="0.1"
                       class="w-full bg-[#0F0F0F] border border-white/10 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-accent">
            </div>
            <div>
                <label class="block text-[10px] uppercase tracking-widest text-white/40 mb-1">Minimum Payout Amount ($)</label>
                <input type="number" name="min_payout" value="50" min="0" step="1"
                       class="w-full bg-[#0F0F0F] border border-white/10 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-accent">
            </div>
        </div>

        <div class="flex justify-end mt-6">
            <button type="submit" class="bg-accent text-white px-6 py-2.5 rounded-lg text-sm font-semibold hover:opacity-90">
                Save Settings
            </button>
        </div>
        <p class="text-[10px] text-white/30 mt-3">General settings will be persisted to a settings table in a future release.</p>
    </form>
</div>
@endsection
