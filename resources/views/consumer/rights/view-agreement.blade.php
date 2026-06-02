@extends('layouts.app')

@section('content')

<div class="h-full flex flex-col items-center justify-start pt-10">
    <div class="w-full max-w-[1100px] bg-[#111111] rounded-[24px] p-8 md:p-14 border border-white/5 shadow-2xl relative overflow-hidden">
        
        {{-- Header Section --}}
        <div class="flex items-center gap-4 mb-10 relative z-10">
            <a href="{{ url()->previous() }}" class="text-[#4D61FF] hover:text-white transition-colors">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
            </a>
            <h1 class="text-[32px] font-semibold text-[#4D61FF]">Standard Artist Agreement</h1>
        </div>

        <div class="space-y-12 relative z-10 px-4">
            {{-- Document Header --}}
            <div class="flex items-start justify-between">
                <div>
                    <h2 class="text-white text-[28px] font-bold mb-2">Standard Artist Agreement</h2>
                    <p class="text-gray-500 text-[14px]">Category: Artist - Type: Legal Agreement</p>
                </div>
                <button class="w-12 h-12 rounded-full border border-[#4D61FF]/40 flex items-center justify-center text-[#4D61FF] hover:bg-[#4D61FF] hover:text-white transition-all">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                        <polyline points="7 10 12 15 17 10"></polyline>
                        <line x1="12" y1="15" x2="12" y2="3"></line>
                    </svg>
                </button>
            </div>

            <div class="h-px bg-white/5 w-full"></div>

            {{-- Document Content --}}
            <div class="space-y-10 max-h-[600px] overflow-y-auto custom-scrollbar pr-6 text-gray-300">
                
                {{-- 1. Grant of Rights --}}
                <div class="space-y-3">
                    <h4 class="text-white font-bold text-[16px]">1. Grant of Rights</h4>
                    <p class="text-[14px] leading-relaxed">
                        The Artist grants the Producer/Label the non-exclusive right to record, distribute, and promote the musical works created under this agreement.
                    </p>
                </div>

                {{-- 2. Compensation & Royalties --}}
                <div class="space-y-3">
                    <h4 class="text-white font-bold text-[16px]">2. Compensation & Royalties</h4>
                    <div class="text-[14px] leading-relaxed">
                        Royalties shall be split as follows:
                        <ul class="list-disc ml-5 mt-2 space-y-2">
                            <li>Artist: [Insert %]</li>
                            <li>Producer/Label: [Insert %]</li>
                        </ul>
                        <p class="mt-3">Payments will be made quarterly via [Preferred Payment Method].</p>
                    </div>
                </div>

                {{-- 3. Ownership & Copyright --}}
                <div class="space-y-3">
                    <h4 class="text-white font-bold text-[16px]">3. Ownership & Copyright</h4>
                    <p class="text-[14px] leading-relaxed">
                        The copyright of the composition and master recording will be shared equally unless otherwise stated in writing.
                    </p>
                </div>

                {{-- 4. Creative Control --}}
                <div class="space-y-3">
                    <h4 class="text-white font-bold text-[16px]">4. Creative Control</h4>
                    <p class="text-[14px] leading-relaxed">
                        Both parties agree to maintain open communication regarding changes, releases, or public performances.
                    </p>
                </div>

                {{-- 5. Term & Termination --}}
                <div class="space-y-3">
                    <h4 class="text-white font-bold text-[16px]">5. Term & Termination</h4>
                    <p class="text-[14px] leading-relaxed">
                        This agreement is valid for [Insert Duration], and either party may terminate it with a 30-day written notice.
                    </p>
                </div>

                {{-- 6. Signatures --}}
                <div class="space-y-6 pt-6">
                    <h4 class="text-white font-bold text-[16px]">6. Signatures</h4>
                    <p class="text-[14px]">By signing below, both parties agree to the terms outlined above.</p>
                    
                    <div class="space-y-4 pt-4">
                        <div class="flex items-end gap-3">
                            <span class="text-[14px]">Artist Signature:</span>
                            <div class="flex-1 border-b border-gray-600 mb-1"></div>
                        </div>
                        <div class="flex items-end gap-3">
                            <span class="text-[14px]">Producer/Label Signature:</span>
                            <div class="flex-1 border-b border-gray-600 mb-1"></div>
                        </div>
                        <div class="flex items-end gap-3 max-w-[200px]">
                            <span class="text-[14px]">Date:</span>
                            <div class="flex-1 border-b border-gray-600 mb-1"></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.02);
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: rgba(77, 97, 255, 0.3);
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: rgba(77, 97, 255, 0.5);
    }
</style>

@endsection
