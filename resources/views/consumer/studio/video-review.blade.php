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
                <h1 class="text-[42px] font-bold text-[#4D61FF] tracking-tight">Review Your Video</h1>
            </div>
            <p class="text-[18px] text-gray-400 font-medium max-w-2xl leading-relaxed">
                Review your video to set your video for further actions
            </p>
        </div>

        <div class="h-px bg-white/5 w-full mb-10"></div>

        {{-- Video Review Content --}}
        <div class="space-y-10 relative z-10">
            {{-- Video Preview --}}
            <div class="relative w-full aspect-video rounded-[28px] bg-black/40 border-2 border-white/5 overflow-hidden group shadow-inner">
                {{-- Play Button Overlay --}}
                <div class="absolute inset-0 flex items-center justify-center">
                    <button class="w-20 h-20 flex items-center justify-center rounded-full bg-magenta shadow-[0_0_30px_rgba(255,0,255,0.4)] opacity-95 transition-all duration-300 transform group-hover:scale-110">
                        <svg class="w-10 h-10 text-white ml-1.5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M8 5v14l11-7z" />
                        </svg>
                    </button>
                </div>

                {{-- Mock Video Thumbnail/Placeholder --}}
                <img src="https://picsum.photos/1200/800?random=video-preview" class="w-full h-full object-cover opacity-30">
                
                {{-- Progress Bar --}}
                <div class="absolute bottom-0 left-0 right-0 h-1.5 bg-white/10">
                    <div class="h-full bg-magenta w-1/3 rounded-r-full shadow-[0_0_10px_rgba(255,0,255,0.5)]"></div>
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
