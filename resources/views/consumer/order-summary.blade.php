@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mb-20">
    {{-- Header --}}
    <div class="flex items-center gap-4 mb-10">
        <a href="{{ url()->previous() }}" class="text-[#5c67ff] hover:text-[#4b55e6] transition bg-transparent outline-none flex items-center group">
            <svg class="w-7 h-7 mr-3 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            <h1 class="text-[32px] font-semibold tracking-tight text-[#5c67ff]">Invest in Track</h1>
        </a>
    </div>

    <div class="bg-[#1b1c21]/50 border border-white/5 rounded-[24px] p-10 shadow-2xl backdrop-blur-sm">
        <h2 class="text-[26px] font-bold text-white mb-8">Order Summary</h2>

        {{-- Order Card --}}
        <div class="bg-[#1b1c21] border border-[#5c67ff]/20 rounded-2xl p-4 flex items-center mb-10 group hover:border-[#5c67ff]/40 transition-colors">
            <div class="w-16 h-16 rounded-xl overflow-hidden mr-4">
                <img src="{{ $track->cover_image ? asset('storage/' . $track->cover_image) : 'https://picsum.photos/200/200?random=' . $track->id }}" class="w-full h-full object-cover">
            </div>
            <div class="flex-1">
                <h3 class="text-white font-bold text-[16px]">{{ $track->title ?? 'Night Vibes' }}</h3>
                <p class="text-gray-400 text-[13px]">By {{ $track->user->username ?? 'Alex M.' }}</p>
            </div>
            <div class="text-white font-bold text-[18px]">
                ${{ number_format($price ?? 29, 2) }}
            </div>
        </div>

        {{-- Subtotal --}}
        <div class="flex justify-between items-center mb-12 border-b border-white/5 pb-8">
            <span class="text-white text-[18px] font-bold">Subtotal</span>
            <span class="text-white text-[18px] font-bold">${{ number_format($price ?? 29, 2) }}</span>
        </div>

        {{-- Payment Form --}}
        <div class="space-y-6">
            <div>
                <input type="text" placeholder="Name" class="w-full bg-[#1b1c21] border border-white/5 rounded-xl py-5 px-6 text-white placeholder-gray-500 focus:outline-none focus:border-[#5c67ff]/50 transition-colors">
            </div>
            <div>
                <input type="text" placeholder="Credit Card No" class="w-full bg-[#1b1c21] border border-white/5 rounded-xl py-5 px-6 text-white placeholder-gray-500 focus:outline-none focus:border-[#5c67ff]/50 transition-colors font-mono">
            </div>
            <div class="grid grid-cols-2 gap-6">
                <input type="text" placeholder="Expiry" class="w-full bg-[#1b1c21] border border-white/5 rounded-xl py-5 px-6 text-white placeholder-gray-500 focus:outline-none focus:border-[#5c67ff]/50 transition-colors">
                <input type="text" placeholder="CVV" class="w-full bg-[#1b1c21] border border-white/5 rounded-xl py-5 px-6 text-white placeholder-gray-500 focus:outline-none focus:border-[#5c67ff]/50 transition-colors">
            </div>

            <div class="flex items-center gap-3 pt-2">
                <div class="relative flex items-center">
                    <input type="checkbox" id="save-card" class="w-6 h-6 rounded-md bg-[#1b1c21] border-white/10 text-[#5c67ff] focus:ring-[#5c67ff]/20">
                </div>
                <label for="save-card" class="text-gray-400 text-[14px] cursor-pointer">Save card for future purchases</label>
            </div>
        </div>

        {{-- Buttons --}}
        <div class="mt-16 space-y-4">
            <button @click="$dispatch('open-success-modal', { type: 'payment' })" class="w-full bg-[#5c67ff] hover:bg-[#4b55e6] text-white font-bold text-[17px] py-5 rounded-[12px] transition-all duration-300 shadow-xl shadow-[#5c67ff]/20 active:scale-[0.98]">
                Confirm & Pay
            </button>
            <button @click="window.history.back()" class="w-full bg-transparent border border-white/15 hover:border-white/30 text-white font-bold text-[17px] py-5 rounded-[12px] transition-all duration-300 active:scale-[0.98]">
                Back to track
            </button>
        </div>
    </div>
</div>

@push('scripts')
<style>
    input::placeholder {
        font-weight: 500;
    }
</style>
@endpush
@endsection
