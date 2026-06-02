@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto h-full flex flex-col pt-4" x-data="{ selectedLicense: 'personal' }">
    {{-- Header --}}
    <div class="flex items-center gap-4 mb-10">
        <a href="{{ url()->previous() }}" class="text-[#5c67ff] hover:text-[#4b55e6] transition bg-transparent outline-none flex items-center group">
            <svg class="w-7 h-7 mr-3 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            <h1 class="text-[32px] font-semibold tracking-tight text-[#5c67ff]">Select type of license</h1>
        </a>
    </div>

    {{-- License Options --}}
    <div class="space-y-5 mb-auto">
        {{-- Personal License --}}
        <button @click="selectedLicense = 'personal'" 
            :class="selectedLicense === 'personal' ? 'border-[#5c67ff]/60 bg-[#1b1c20] shadow-[0_4px_20px_rgba(92,103,255,0.05)]' : 'border-white/5 bg-[#1b1c20]'"
            class="w-full transition duration-200 border rounded-2xl p-7 flex items-center text-left focus:outline-none">
            <span class="text-white text-[18px] font-medium tracking-wide leading-none">Personal license</span>
        </button>

        {{-- Commercial License --}}
        <button @click="selectedLicense = 'commercial'" 
            :class="selectedLicense === 'commercial' ? 'border-[#5c67ff]/60 bg-[#1b1c20] shadow-[0_4px_20px_rgba(92,103,255,0.05)]' : 'border-white/5 bg-[#1b1c20]'"
            class="w-full transition duration-200 border rounded-2xl p-7 flex items-center text-left focus:outline-none">
            <span class="text-white text-[18px] font-medium tracking-wide leading-none">Commercial license</span>
        </button>

        {{-- Sync License --}}
        <button @click="selectedLicense = 'sync'" 
            :class="selectedLicense === 'sync' ? 'border-[#5c67ff]/60 bg-[#1b1c20] shadow-[0_4px_20px_rgba(92,103,255,0.05)]' : 'border-white/5 bg-[#1b1c20]'"
            class="w-full transition duration-200 border rounded-2xl p-7 flex items-center text-left focus:outline-none">
            <span class="text-white text-[18px] font-medium tracking-wide leading-none">Sync license</span>
        </button>
    </div>

    {{-- Bottom Actions --}}
    <div class="mt-12 space-y-4 pb-10">
        <button class="w-full bg-[#5c67ff] hover:bg-[#4b55e6] text-white font-semibold text-[17px] py-5 rounded-[8px] transition-all duration-300 shadow-lg shadow-[#5c67ff]/25 active:scale-[0.99] flex items-center justify-center">
            Proceed
        </button>

        <button @click="window.history.back()" class="w-full bg-transparent border border-white/15 hover:border-white/30 text-white font-semibold text-[17px] py-5 rounded-[8px] transition-all duration-300 active:scale-[0.99] flex items-center justify-center">
            Back to track
        </button>
    </div>
</div>

@push('scripts')
<style>
    /* Premium feel refinements */
    body {
        background-color: #121212 !important;
    }
    aside {
        background-color: #0f0f0f !important;
    }
</style>
@endpush
@endsection
