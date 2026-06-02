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

            {{-- Editor Section --}}
            <div class="bg-[#161719] rounded-[24px] border border-white/5 overflow-hidden">
                {{-- Toolbar --}}
                <div class="flex items-center gap-12 px-10 py-5 border-b border-white/5">
                    <button class="text-white hover:text-[#4D61FF] transition-colors"><span class="font-bold text-lg">B</span></button>
                    <button class="text-white hover:text-[#4D61FF] transition-colors"><span class="italic font-serif text-lg">I</span></button>
                    <button class="text-white hover:text-[#4D61FF] transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                    <button class="text-white hover:text-[#4D61FF] transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h7"/></svg>
                    </button>
                </div>

                {{-- Editable Area --}}
                <div class="p-10 max-h-[500px] overflow-y-auto custom-scrollbar text-gray-300">
                    <div contenteditable="true" class="outline-none space-y-8 focus:ring-0">
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
                    </div>
                </div>
            </div>

            {{-- Action Button --}}
            <div class="pt-2">
                <button @click="window.location.href='{{ route('consumer.rights.index') }}'" class="w-full py-6 rounded-[18px] bg-[#4D61FF] hover:bg-[#3d4ed9] text-white font-bold text-[18px] transition-all transform active:scale-[0.99] shadow-xl shadow-[#4D61FF]/20">
                    Save & Continue
                </button>
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
