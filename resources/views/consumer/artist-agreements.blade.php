@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto mb-20 pr-4">
    {{-- Header --}}
    <div class="flex items-center gap-4 mb-10">
        <a href="{{ url()->previous() }}" class="text-[#5c67ff] hover:text-[#4b55e6] transition bg-transparent outline-none flex items-center group">
            <svg class="w-7 h-7 mr-3 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            <h1 class="text-[32px] font-semibold tracking-tight text-[#5c67ff]">Standard Artist Agreement</h1>
        </a>
    </div>

    {{-- Agreement Content Box --}}
    <div class="bg-[#1b1c20] rounded-xl border border-white/5 p-8 shadow-2xl">
        {{-- Top Section --}}
        <div class="flex justify-between items-start mb-10">
            <div>
                <h2 class="text-[26px] font-bold text-white mb-2">Standard Artist Agreement</h2>
                <p class="text-[14px] text-gray-400 font-medium">Category: Artist - Type: Legal Agreement</p>
            </div>
            <button class="w-[48px] h-[48px] rounded-full border border-[#5c67ff]/40 flex items-center justify-center text-[#5c67ff] hover:bg-[#5c67ff] hover:text-white transition-all duration-300 shadow-lg shadow-[#5c67ff]/10">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
            </button>
        </div>

        {{-- Legal Text --}}
        <div class="space-y-6 text-[14px] text-gray-300 leading-relaxed font-sans pr-10">
            <div>
                <h3 class="font-bold text-[14px] text-white mb-2">1. Grant of Rights</h3>
                <p>The Artist grants the Producer/Label the non-exclusive right to record, distribute, and promote the musical works created under this agreement.</p>
            </div>

            <div>
                <h3 class="font-bold text-[14px] text-white mb-2">2. Compensation & Royalties</h3>
                <p class="mb-3">Royalties shall be split as follows:</p>
                <ul class="list-disc pl-5 mb-0.5 space-y-0.5">
                    <li>Artist: [Insert %]</li>
                    <li>Producer/Label: [Insert %]</li>
                </ul>
                <p class="pl-5">Payments will be made quarterly via [Preferred Payment Method].</p>
            </div>

            <div>
                <h3 class="font-bold text-[14px] text-white mb-2">3. Ownership & Copyright</h3>
                <p>The copyright of the composition and master recording will be shared equally unless otherwise stated in writing.</p>
            </div>

            <div>
                <h3 class="font-bold text-[14px] text-white mb-2">4. Creative Control</h3>
                <p>Both parties agree to maintain open communication regarding changes, releases, or public performances.</p>
            </div>

            <div>
                <h3 class="font-bold text-[15px] text-white mb-2">5. Term & Termination</h3>
                <p>This agreement is valid for [Insert Duration], and either party may terminate it with a 30-day written notice.</p>
            </div>
        </div>

        {{-- Footer Buttons --}}
        <div class="mt-16 space-y-4">
            <button @click="window.history.back()" class="w-full bg-[#5c67ff] hover:bg-[#4b55e6] text-white font-bold text-[17px] py-5 rounded-[12px] transition-all duration-300 shadow-xl shadow-[#5c67ff]/20 active:scale-[0.98] flex items-center justify-center">
                Proceed
            </button>
            <button @click="window.history.back()" class="w-full bg-transparent border border-white/10 hover:border-white/30 text-white font-bold text-[17px] py-5 rounded-[12px] transition-all duration-300 active:scale-[0.98] flex items-center justify-center">
                Back to track
            </button>
        </div>
    </div>
</div>

@endsection