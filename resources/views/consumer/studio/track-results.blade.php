@extends('layouts.app')

@section('content')

<div class="h-full flex flex-col items-center justify-center -mt-8" x-data="{ 
    isPlaying: false,
    progress: 0,
    interval: null,
    togglePlay() {
        this.isPlaying = !this.isPlaying;
        if (this.isPlaying) {
            this.interval = setInterval(() => {
                this.progress = (this.progress + 1) % 120; // 2 minutes = 120 seconds
            }, 1000);
        } else {
            clearInterval(this.interval);
        }
    },
    formatTime(seconds) {
        const m = Math.floor(seconds / 60);
        const s = seconds % 60;
        return `${m.toString().padStart(2, '0')}:${s.toString().padStart(2, '0')}`;
    }
}">
    <div class="w-full max-w-[1050px] border border-gray-800/40 rounded-[32px] p-10 md:p-14 bg-[#1b1c20]/60 backdrop-blur-xl shadow-2xl relative overflow-hidden">
        {{-- Background glow --}}
        <div class="absolute top-0 right-0 w-80 h-80 bg-[#4D61FF]/5 rounded-full blur-[120px] -mr-40 -mt-40"></div>
        
        {{-- Header --}}
        <div class="mb-10 relative z-10">
            <div class="flex items-center gap-6 mb-6">
                <a href="{{ url()->previous() }}" class="text-[#4D61FF] hover:text-white transition-colors duration-200">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="19" y1="12" x2="5" y2="12"></line>
                        <polyline points="12 19 5 12 12 5"></polyline>
                    </svg>
                </a>
                <h1 class="text-[42px] font-bold text-[#4D61FF] tracking-tight">Here is your track</h1>
            </div>
            <p class="text-[18px] text-gray-400 font-medium max-w-2xl leading-relaxed">
                Based on your selections, here is what we have created for you
            </p>
        </div>

        <div class="h-px bg-white/5 w-full mb-12"></div>

        {{-- Content Area --}}
        <div class="space-y-12 relative z-10">
            {{-- Track Metadata --}}
            <div class="space-y-2">
                <span class="text-gray-500 text-[14px] font-bold uppercase tracking-widest">Track Name</span>
                <h2 class="text-white text-[32px] font-bold tracking-tight">Reflection</h2>
            </div>

            {{-- Audio Player Card --}}
            <div class="p-8 rounded-[24px] bg-[#161719] border border-white/5 shadow-inner">
                <div class="flex items-center gap-6">
                    {{-- Play/Pause Button --}}
                    <button 
                        @click="togglePlay()"
                        class="w-16 h-16 flex items-center justify-center rounded-full bg-magenta shadow-[0_0_20px_rgba(255,0,255,0.3)] transition-all hover:scale-105 active:scale-95"
                    >
                        <template x-if="!isPlaying">
                            <svg class="w-8 h-8 text-white ml-1" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z" /></svg>
                        </template>
                        <template x-if="isPlaying">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z" /></svg>
                        </template>
                    </button>

                    {{-- Waveform --}}
                    <div class="flex-1 h-16 flex items-center gap-[2.5px] relative">
                        {{-- Static Background Waveform --}}
                        <div class="absolute inset-0 flex items-center gap-[2.5px]">
                            @for($i = 0; $i < 60; $i++)
                                <div class="w-[3px] bg-white/10 rounded-full" style="height: {{ rand(30, 90) }}%;"></div>
                            @endfor
                        </div>
                        {{-- Active Progress Waveform --}}
                        <div class="absolute inset-0 flex items-center gap-[2.5px] overflow-hidden transition-all duration-300" :style="`width: ${progress * (100/120)}%` ">
                            @for($i = 0; $i < 60; $i++)
                                <div class="w-[3px] bg-[#4D61FF] rounded-full" style="height: {{ rand(30, 90) }}%;"></div>
                            @endfor
                        </div>
                        
                        {{-- Time Overlay --}}
                        <div class="absolute bottom-[-24px] right-0">
                            <span class="text-gray-500 font-mono text-[13px] font-bold" x-text="formatTime(progress)"></span>
                            <span class="text-gray-500 font-mono text-[13px] font-bold"> / 02:00</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex flex-col gap-5 pt-10">
                <a href="{{ route('consumer.ai-tools.track-mixing') }}" class="w-full py-6 rounded-[18px] bg-[#4D61FF] hover:bg-[#3d4ed9] text-white font-bold text-[19px] transition-all duration-300 shadow-xl shadow-[#4D61FF]/20 active:scale-[0.99] tracking-wide text-center">
                    Approve raw track to continue to mixing
                </a>
                <button @click="window.history.back()" class="w-full py-6 rounded-[18px] border border-gray-700 text-gray-400 hover:text-white font-bold text-[19px] transition-all duration-300 active:scale-[0.99] tracking-wide">
                    Edit track
                </button>
            </div>
        </div>
    </div>
</div>

@endsection
