@extends('layouts.app')

@section('content')

@php
    $rawAvatar = (string) ($user->profile_image ?? '');
    if (!empty($rawAvatar)) {
        if (str_starts_with($rawAvatar, 'http')) {
            $avatar = $rawAvatar;
        } elseif (str_starts_with($rawAvatar, 'theme/') || str_starts_with($rawAvatar, 'images/')) {
            $avatar = url('/' . ltrim($rawAvatar, '/'));
        } else {
            $avatar = asset('storage/' . ltrim($rawAvatar, '/'));
        }
    } else {
        $avatar = 'https://ui-avatars.com/api/?name=' . urlencode($user->username) . '&background=FF00FF&color=fff';
    }
@endphp

<div class="h-full flex flex-col justify-start pt-12 px-12">

    <div class="w-full max-w-[900px] bg-[#141414] border border-white/5 rounded-[12px] overflow-hidden shadow-2xl">

        {{-- Profile Header Section --}}
        <div class="p-10 border-b border-white/[0.03]">
            <div class="flex items-center gap-6">
                {{-- Avatar --}}
                <div class="relative group">
                    <img src="{{ $avatar }}"
                         alt="Profile Avatar"
                         class="w-24 h-24 rounded-full object-cover border-[3px] border-white/5 group-hover:border-magenta/40 transition-all duration-300">
                </div>

                <div>
                    <h1 class="text-[32px] tracking-tight font-semibold text-white">{{ $user->username }}</h1>
                    <p class="text-white/40 text-[18px] font-medium tracking-wide mt-1">
                        {{ ucfirst($user->role ?? 'Consumer') }}
                        @if($user->is_verified)
                            <span class="ml-2 text-magenta" title="Verified"><i class="fa-solid fa-circle-check"></i></span>
                        @endif
                    </p>
                    @if($user->bio)
                        <p class="text-white/60 text-[14px] mt-2">{{ $user->bio }}</p>
                    @endif
                </div>
            </div>

            {{-- Upload Avatar --}}
            <form class="mt-6 flex flex-col sm:flex-row sm:items-center gap-3"
                  method="POST"
                  action="{{ route('consumer.profile.avatar.update') }}"
                  enctype="multipart/form-data">
                @csrf
                <input type="file" name="avatar" accept="image/*"
                       class="block w-full sm:w-auto text-sm text-white/70 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-magenta file:text-white file:cursor-pointer hover:file:opacity-90">
                <button type="submit"
                        class="bg-magenta text-white px-5 py-2 rounded-lg text-sm font-semibold hover:opacity-90 transition-opacity">
                    Upload Image
                </button>
            </form>

            @error('avatar')
                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>

        {{-- Profile Details Section --}}
        <div class="p-10 pb-16">
            <h2 class="text-[20px] font-bold text-white mb-10 tracking-tight">Profile Details</h2>

            <div class="space-y-8 max-w-[800px]">
                {{-- Username --}}
                <div class="flex justify-between items-center pb-2 border-b border-white/[0.02]">
                    <span class="text-white/40 text-[16px] font-medium tracking-wide">Name</span>
                    <span class="text-white/80 text-[16px] font-semibold tracking-wide">{{ $user->username }}</span>
                </div>

                {{-- Email --}}
                <div class="flex justify-between items-center pb-2 border-b border-white/[0.02]">
                    <span class="text-white/40 text-[16px] font-medium tracking-wide">Email</span>
                    <span class="text-white/80 text-[16px] font-semibold tracking-wide">{{ $user->email ?: '—' }}</span>
                </div>

                {{-- Phone No --}}
                <div class="flex justify-between items-center pb-2 border-b border-white/[0.02]">
                    <span class="text-white/40 text-[16px] font-medium tracking-wide">Phone No</span>
                    <span class="text-white/80 text-[16px] font-semibold tracking-wide">{{ $user->phone ?: 'Not set' }}</span>
                </div>

                {{-- Status --}}
                <div class="flex justify-between items-center pb-2 border-b border-white/[0.02]">
                    <span class="text-white/40 text-[16px] font-medium tracking-wide">Status</span>
                    <span class="text-white/80 text-[16px] font-semibold tracking-wide">{{ ucfirst($user->role ?? 'Consumer') }}</span>
                </div>

                {{-- Total Amount Invested --}}
                <div class="flex justify-between items-center pb-2">
                    <span class="text-white/40 text-[16px] font-medium tracking-wide">Total Amount Invested</span>
                    <span class="text-white/80 text-[16px] font-semibold tracking-wide">${{ number_format((float) $totalInvested, 2) }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<style>
    body {
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }
</style>
@endpush
