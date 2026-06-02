@extends('layouts.app')

@section('content')

<div class="h-full flex flex-col items-center justify-center -mt-10">
    <div class="w-full max-w-[1000px] border border-gray-800/40 rounded-[32px] p-10 md:p-14 bg-[#1b1c20]/60 backdrop-blur-xl shadow-2xl relative overflow-hidden">
        {{-- Background glow --}}
        <div class="absolute top-0 right-0 w-80 h-80 bg-[#4D61FF]/5 rounded-full blur-[120px] -mr-40 -mt-40"></div>
        
        {{-- Header --}}
        <div class="mb-12 relative z-10">
            <div class="flex items-center gap-6 mb-6">
                <a href="{{ url()->previous() }}" class="text-[#4D61FF] hover:text-white transition-colors duration-200">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="19" y1="12" x2="5" y2="12"></line>
                        <polyline points="12 19 5 12 12 5"></polyline>
                    </svg>
                </a>
                <h1 class="text-[42px] font-bold text-[#4D61FF] tracking-tight">Review Your Image/Illustration</h1>
            </div>
            <p class="text-[18px] text-gray-400 font-medium max-w-2xl leading-relaxed">
                Review to set your it for further actions
            </p>
        </div>

        <div class="h-px bg-white/5 w-full mb-10"></div>

        {{-- Image Review Content --}}
        <div class="space-y-10 relative z-10">
            {{-- Image Preview Area --}}
            <div class="flex flex-col items-start gap-8">
                {{-- Mock Image Icon/Placeholder --}}
                <div class="relative w-72 h-72 flex items-center justify-center">
                    {{-- Multiple overlapping card silhouettes to match screenshot icon --}}
                    <div class="absolute w-56 h-56 border-2 border-white/20 rounded-[24px] transform -translate-x-6 -translate-y-6"></div>
                    <div class="relative w-56 h-56 border-2 border-white/40 rounded-[24px] bg-[#161719] flex items-center justify-center overflow-hidden">
                        {{-- Icon parts inside --}}
                        <div class="absolute top-12 right-12 w-6 h-6 border-2 border-white/40 rounded-full"></div>
                        <div class="absolute bottom-0 left-0 w-full h-24 border-t-2 border-white/40 bg-white/5">
                            <div class="absolute bottom-0 left-10 w-32 h-32 border-2 border-white/40 rotate-45 transform translate-y-20"></div>
                            <div class="absolute bottom-0 right-4 w-24 h-24 border-2 border-white/40 rotate-45 transform translate-y-16"></div>
                        </div>
                    </div>
                </div>

                {{-- File Metadata --}}
                <div class="space-y-1">
                    <h3 class="text-white font-bold text-[22px] tracking-tight">Image.png</h3>
                    <p class="text-gray-500 font-medium text-[16px]">145 KB</p>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex flex-col gap-5 pt-4">
                <button class="w-full py-6 rounded-[18px] bg-[#4D61FF] hover:bg-[#3d4ed9] text-white font-bold text-[19px] transition-all duration-300 shadow-xl shadow-[#4D61FF]/20 active:scale-[0.99] tracking-wide">
                    Approve to continue
                </button>
                <button @click="window.history.back()" class="w-full py-6 rounded-[18px] border border-gray-700 text-gray-400 hover:text-white font-bold text-[19px] transition-all duration-300 active:scale-[0.99] tracking-wide">
                    Back
                </button>
            </div>
        </div>
    </div>
</div>

@endsection
