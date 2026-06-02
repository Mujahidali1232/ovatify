@extends('layouts.app')

@section('content')

<div class="h-full flex flex-col items-center justify-start pt-10">
    <div class="w-full max-w-[1000px] bg-[#111111] rounded-[24px] p-8 md:p-14 border border-white/5 shadow-2xl relative overflow-hidden">
        
        {{-- Header Section --}}
        <div class="flex items-center gap-4 mb-10 relative z-10">
            <a href="{{ url()->previous() }}" class="text-[#4D61FF] hover:text-white transition-colors">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
            </a>
            <h1 class="text-[32px] font-semibold text-[#4D61FF]">Review License</h1>
        </div>

        <div class="space-y-12 relative z-10">
            {{-- License Summary --}}
            <div class="p-8 rounded-[24px] bg-[#161719] border border-white/5 space-y-6">
                <h3 class="text-white text-[18px] font-bold border-b border-white/5 pb-4">License summary</h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-500 font-medium">License Title</span>
                        <span class="text-white font-bold">Lorem</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-500 font-medium">Rate per license</span>
                        <span class="text-white font-bold">Lorem</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-500 font-medium">License Duration</span>
                        <span class="text-white font-bold">Lorem</span>
                    </div>
                </div>
            </div>

            {{-- Rights Description --}}
            <div class="space-y-4">
                <h3 class="text-white text-[18px] font-bold">Rights Description</h3>
                <div class="p-8 rounded-[24px] bg-[#161719] border border-white/5 space-y-8 max-h-[400px] overflow-y-auto custom-scrollbar">
                    {{-- 1. Grant of Rights --}}
                    <div class="space-y-3">
                        <h4 class="text-white font-bold text-[15px]">1. Grant of Rights</h4>
                        <p class="text-gray-400 text-[14px] leading-relaxed">
                            The Artist grants the Producer/Label the non-exclusive right to record, distribute, and promote the musical works created under this agreement.
                        </p>
                    </div>

                    {{-- 2. Compensation & Royalties --}}
                    <div class="space-y-3">
                        <h4 class="text-white font-bold text-[15px]">2. Compensation & Royalties</h4>
                        <p class="text-gray-400 text-[14px] leading-relaxed">
                            Royalties shall be split as follows:
                            <ul class="list-disc ml-5 mt-2 space-y-1">
                                <li>Artist: [Insert %]</li>
                                <li>Producer/Label: [Insert %]</li>
                            </ul>
                            <span class="block mt-2 font-medium">Payments will be made quarterly via [Preferred Payment Method].</span>
                        </p>
                    </div>

                    {{-- 3. Ownership & Copyright --}}
                    <div class="space-y-3">
                        <h4 class="text-white font-bold text-[15px]">3. Ownership & Copyright</h4>
                        <p class="text-gray-400 text-[14px] leading-relaxed">
                            The copyright of the composition and master recording will be shared equally unless otherwise stated in writing.
                        </p>
                    </div>

                    {{-- 4. Creative Control --}}
                    <div class="space-y-3">
                        <h4 class="text-white font-bold text-[15px]">4. Creative Control</h4>
                        <p class="text-gray-400 text-[14px] leading-relaxed">
                            Both parties agree to maintain open communication regarding changes, releases, or public performances.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Action Button --}}
            <div class="pt-4">
                <button @click="window.location.href='{{ route('consumer.studio.studio-completion-v4') }}'" class="w-full py-6 rounded-[18px] bg-[#4D61FF] hover:bg-[#3d4ed9] text-white font-bold text-[20px] transition-all transform active:scale-[0.99] shadow-xl shadow-[#4D61FF]/20">
                    Publish License
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
