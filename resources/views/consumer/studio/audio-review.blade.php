@extends('layouts.app')

@section('content')

<div class="h-full flex flex-col items-center justify-start pt-10" x-data="{ 
    isPlaying: false,
    progress: 0,
    totalDuration: 120,
    interval: null,
    togglePlay() {
        this.isPlaying = !this.isPlaying;
        if (this.isPlaying) {
            this.interval = setInterval(() => {
                if (this.progress >= 100) {
                    this.isPlaying = false;
                    clearInterval(this.interval);
                    this.progress = 0;
                } else {
                    this.progress += 0.5;
                }
            }, 50);
        } else {
            clearInterval(this.interval);
        }
    }
}">
    <div class="w-full max-w-[900px] bg-[#111111] rounded-[24px] p-8 md:p-14 border border-white/5 shadow-2xl">
        
        {{-- Header Section --}}
        <div class="mb-10">
            <h1 class="text-[32px] font-semibold text-white">Your recorded audio</h1>
        </div>

        {{-- Main Waveform Player --}}
        <div class="bg-[#181818] rounded-[16px] p-6 mb-12 border border-white/5 relative">
            <div class="flex items-center gap-6">
                <button @click="togglePlay()" class="w-14 h-14 flex-shrink-0 flex items-center justify-center rounded-full bg-magenta text-white hover:scale-105 transition-transform shadow-[0_0_20px_rgba(255,0,255,0.2)]">
                    <template x-if="!isPlaying">
                        <svg class="w-7 h-7 ml-1" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                    </template>
                    <template x-if="isPlaying">
                        <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/></svg>
                    </template>
                </button>
                
                <div class="flex-1 h-16 flex items-center justify-between gap-[3px] relative overflow-hidden">
                    @for($i = 0; $i < 65; $i++)
                        <div class="w-0.5 bg-[#4D61FF] rounded-full opacity-30" 
                             style="height: {{ rand(20, 80) }}%;"></div>
                    @endfor
                    
                    {{-- Progress Overlay --}}
                    <div class="absolute inset-0 flex items-center gap-[3px] overflow-hidden pointer-events-none transition-all duration-100" 
                         :style="`width: ${progress}%` ">
                        @for($i = 0; $i < 65; $i++)
                            <div class="w-0.5 bg-[#4D61FF] rounded-full flex-shrink-0" 
                                 style="height: {{ rand(20, 80) }}%;"></div>
                        @endfor
                    </div>
                </div>
            </div>
            <div class="absolute bottom-4 right-6">
                <span class="text-gray-500 font-mono text-[11px]">02:00</span>
            </div>
        </div>

        {{-- Add More Ideas Section --}}
        <div class="mb-12">
            <div class="flex items-center gap-4 mb-6">
                <h3 class="text-white text-[18px] font-semibold">Want to add more ideas?</h3>
                <div class="flex-1 h-px bg-white/5"></div>
            </div>
            
            <div class="grid grid-cols-2 gap-4">
                <button class="py-4 border border-white/10 rounded-[12px] text-gray-400 font-medium hover:bg-white/5 hover:text-white transition-all">
                    Upload Document
                </button>
                <button class="py-4 border border-white/10 rounded-[12px] text-gray-400 font-medium hover:bg-white/5 hover:text-white transition-all">
                    Write Idea
                </button>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="space-y-4 pt-4">
            <a href="{{ route('consumer.studio.customize-track') }}" class="w-full py-5 bg-[#4D61FF] hover:bg-[#3d4ed9] text-white font-bold rounded-[14px] text-[18px] transition-all transform active:scale-[0.98] block text-center shadow-lg shadow-[#4D61FF]/20">
                Approve to continue
            </a>
            <button @click="window.history.back()" class="w-full py-5 bg-transparent border border-white/10 text-white font-bold rounded-[14px] text-[18px] hover:bg-white/5 transition-all">
                Record again
            </button>
        </div>

    </div>
</div>

@endsection

@push('scripts')
<style>
    .bg-magenta {
        background-color: #FF00FF;
    }
    .text-magenta {
        color: #FF00FF;
    }
    
    [x-cloak] { display: none !important; }
</style>
@endpush
