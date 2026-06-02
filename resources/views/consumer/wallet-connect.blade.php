@extends('layouts.app')

@section('content')
<div class="h-full flex flex-col items-center justify-center -mt-10">
    <div class="w-full max-w-[900px] border border-gray-800/60 rounded-[24px] p-10 md:p-16 bg-[#111111]/40 backdrop-blur-xl shadow-2xl">
        {{-- Header --}}
        <div class="flex items-center gap-6 mb-14">
            <a href="{{ url()->previous() }}" class="text-[#4D61FF] hover:text-white transition-colors duration-200">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
            </a>
            <h1 class="text-[38px] font-bold text-[#4D61FF] tracking-tight">Select your Wallet to connect</h1>
        </div>

        {{-- Wallet Options --}}
        <div class="space-y-6 mb-20">
            {{-- MetaMask - Active/Highlighted state as per screenshot --}}
            <button class="w-full bg-[#1b1c20] hover:bg-[#25262a] transition-all duration-300 border-2 border-[#4D61FF] rounded-[14px] px-8 py-8 flex items-center text-left focus:outline-none shadow-[0_0_30px_rgba(77,97,255,0.15)] group relative overflow-hidden">
                <span class="text-white text-[20px] font-medium tracking-wide z-10">Connect with MetaMask</span>
                <div class="absolute inset-0 bg-gradient-to-r from-[#4D61FF]/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            </button>

            {{-- WalletConnect --}}
            <button class="w-full bg-[#1b1c20] hover:bg-[#25262a] transition-all duration-300 border border-gray-800 rounded-[14px] px-8 py-8 flex items-center text-left focus:outline-none group relative overflow-hidden">
                <span class="text-white text-[20px] font-medium tracking-wide z-10">Connect with WalletConnect</span>
                <div class="absolute inset-0 bg-white/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            </button>
        </div>

        {{-- Bottom Actions --}}
        <div class="space-y-4">
            <button class="w-full bg-[#4D61FF] hover:bg-[#3d4ed9] text-white font-bold text-[19px] py-6 rounded-[14px] transition-all duration-300 shadow-xl shadow-[#4D61FF]/20 flex items-center justify-center uppercase tracking-wide">
                Connect wallet
            </button>

            <button class="w-full bg-transparent border border-gray-700/60 hover:border-gray-500 text-white/80 hover:text-white font-bold text-[19px] py-6 rounded-[14px] transition-all duration-300 flex items-center justify-center uppercase tracking-wide">
                Back
            </button>
        </div>
    </div>
</div>

@push('scripts')
<style>
    /* Premium background refinement */
    body {
        background: radial-gradient(circle at 50% 50%, #1a1a1a 0%, #111111 100%);
    }
</style>
@endpush
@endsection
