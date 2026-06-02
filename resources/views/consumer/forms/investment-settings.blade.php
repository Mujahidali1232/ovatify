@extends('layouts.app')

@section('content')

<div class="h-full flex flex-col items-center justify-start pt-10">
    <div class="w-full max-w-[1000px] bg-[#111111] rounded-[24px] p-8 md:p-14 border border-white/5 shadow-2xl relative overflow-hidden">
        
        {{-- Header Section --}}
        <div class="flex items-center gap-4 mb-2 relative z-10">
            <a href="{{ url()->previous() }}" class="text-[#4D61FF] hover:text-white transition-colors">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
            </a>
            <h1 class="text-[32px] font-semibold text-[#4D61FF]">Set Investment Terms</h1>
        </div>
        <p class="text-white/80 text-[18px] mb-12 pl-11">Define pricing, ownership blocks, and revenue share details</p>

        <div class="space-y-10 relative z-10">
            {{-- Cover Art Upload --}}
            <div class="w-full aspect-[2/1] border-2 border-dashed border-[#4D61FF]/20 rounded-[24px] bg-[#161719]/50 flex flex-col items-center justify-center cursor-pointer hover:bg-[#161719] hover:border-[#4D61FF]/40 transition-all group">
                <div class="w-16 h-16 rounded-full bg-white/5 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-white/40" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <span class="text-white/60 font-medium">Upload your cover art</span>
            </div>

            {{-- Investment Inputs Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-10">
                {{-- Total Track Valuation --}}
                <div class="space-y-4">
                    <label class="text-white text-[16px] font-medium">Total Track Valuation</label>
                    <div class="bg-[#161719] rounded-[14px] border border-white/5 px-6 py-4">
                        <input type="text" placeholder="Enter track valuation" class="bg-transparent border-none outline-none w-full text-white placeholder-gray-600 font-medium">
                    </div>
                </div>

                {{-- Ownership block --}}
                <div class="space-y-4">
                    <label class="text-white text-[16px] font-medium">Ownership block</label>
                    <div class="bg-[#161719] rounded-[14px] border border-white/5 px-6 py-4">
                        <input type="text" placeholder="e.g. 5%" class="bg-transparent border-none outline-none w-full text-white placeholder-gray-600 font-medium">
                    </div>
                </div>

                {{-- Price per block --}}
                <div class="space-y-4">
                    <label class="text-white text-[16px] font-medium">Price per block</label>
                    <div class="bg-[#161719] rounded-[14px] border border-white/5 px-6 py-4">
                        <input type="text" placeholder="e.g. $5" class="bg-transparent border-none outline-none w-full text-white placeholder-gray-600 font-medium">
                    </div>
                </div>

                {{-- Set max availability blocks --}}
                <div class="space-y-4">
                    <label class="text-white text-[16px] font-medium">Set max availability blocks</label>
                    <div class="bg-[#161719] rounded-[14px] border border-white/5 px-6 py-4">
                        <input type="text" placeholder="e.g. 20" class="bg-transparent border-none outline-none w-full text-white placeholder-gray-600 font-medium">
                    </div>
                </div>
            </div>

            {{-- Action Button --}}
            <div class="pt-6">
                <button @click="window.location.href='{{ route('consumer.studio.studio-completion-v3') }}'" class="w-full py-5 bg-[#4D61FF] hover:bg-[#3d4ed9] text-white font-bold rounded-[14px] text-[18px] transition-all transform active:scale-[0.98] shadow-lg shadow-[#4D61FF]/20">
                    Publish for Investment
                </button>
            </div>
        </div>
    </div>
</div>

@endsection