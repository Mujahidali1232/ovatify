@extends('layouts.app')

@section('content')

<div class="h-full flex flex-col items-center justify-start pt-10" x-data="{ 
    isPlaying: false,
    progress: 38,
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
                    this.progress += 0.3;
                }
            }, 50);
        } else {
            clearInterval(this.interval);
        }
    },
    formatTime(seconds) {
        const m = Math.floor(seconds / 60);
        const s = Math.floor(seconds % 60);
        return `${m.toString().padStart(2, '0')}:${s.toString().padStart(2, '0')}`;
    }
}">
    <div class="w-full max-w-[1000px] bg-[#111111] rounded-[24px] p-8 md:p-12 border border-white/5 shadow-2xl">
        
        {{-- Header Section --}}
        <div class="flex items-center gap-4 mb-10">
            <a href="{{ url()->previous() }}" class="text-[#4D61FF] hover:text-white transition-colors">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
            </a>
            <h1 class="text-[32px] font-semibold text-[#4D61FF]">Track mixing</h1>
        </div>

        <div class="h-px bg-white/5 w-full mb-10"></div>

        {{-- Track Info --}}
        <div class="mb-8">
            <p class="text-gray-500 text-[14px] font-medium mb-1">Track Name</p>
            <h2 class="text-white text-[24px] font-bold">Reflection</h2>
        </div>

        {{-- Main Waveform Player --}}
        <div class="bg-[#181818] rounded-[16px] p-6 mb-12 border border-white/5 relative">
            <div class="flex items-center gap-6">
                <button @click="togglePlay()" class="w-14 h-14 flex-shrink-0 flex items-center justify-center rounded-full bg-magenta text-white hover:scale-105 transition-transform">
                    <template x-if="!isPlaying">
                        <svg class="w-7 h-7 ml-1" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                    </template>
                    <template x-if="isPlaying">
                        <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/></svg>
                    </template>
                </button>
                
                <div class="flex-1 h-16 flex items-center justify-between gap-[2px] relative overflow-hidden">
                    @for($i = 0; $i < 80; $i++)
                        <div class="w-0.5 bg-[#4D61FF] rounded-full opacity-40 hover:opacity-100 transition-opacity" 
                             style="height: {{ rand(20, 80) }}%;"></div>
                    @endfor
                    
                    {{-- Progress Overlay --}}
                    <div class="absolute inset-0 flex items-center gap-[2px] overflow-hidden pointer-events-none" 
                         :style="`width: ${progress}%`">
                        @for($i = 0; $i < 80; $i++)
                            <div class="w-0.5 bg-[#4D61FF] rounded-full flex-shrink-0" 
                                 style="height: {{ rand(20, 80) }}%;"></div>
                        @endfor
                    </div>
                </div>
            </div>
            <div class="absolute bottom-3 right-6">
                <span class="text-gray-500 font-mono text-[12px]">02:00</span>
            </div>
        </div>

        {{-- Multi-Track Mixing Area --}}
        <div class="flex gap-4 mb-12">
            {{-- Labels Sidebar --}}
            <div class="w-20 pt-10 space-y-4">
                <div class="flex flex-col items-center justify-center gap-1 py-4 bg-[#181818] rounded-[12px] border border-white/5 opacity-80 cursor-pointer hover:opacity-100 transition-opacity">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#4D61FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 2v20M2 12h20"/>
                        <circle cx="12" cy="12" r="3" fill="#4D61FF" fill-opacity="0.2"/>
                    </svg>
                    <span class="text-[10px] text-gray-400 font-medium">Tempo</span>
                </div>
                <div class="flex flex-col items-center justify-center gap-1 py-4 bg-[#181818] rounded-[12px] border border-white/5 opacity-80 cursor-pointer hover:opacity-100 transition-opacity">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#4D61FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M11 20H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v7"/>
                        <path d="M16 20a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z"/>
                        <path d="m19 16-2 2-1-1"/>
                    </svg>
                    <span class="text-[10px] text-gray-400 font-medium">Beat</span>
                </div>
                <div class="flex flex-col items-center justify-center gap-1 py-4 bg-[#181818] rounded-[12px] border border-white/5 opacity-80 cursor-pointer hover:opacity-100 transition-opacity">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#4D61FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 2a3 3 0 0 0-3 3v7a3 3 0 0 0 6 0V5a3 3 0 0 0-3-3Z"/>
                        <path d="M19 10v2a7 7 0 0 1-14 0v-2"/>
                        <line x1="12" y1="19" x2="12" y2="22"/>
                    </svg>
                    <span class="text-[10px] text-gray-400 font-medium">Vocals</span>
                </div>
            </div>

            {{-- Tracks Container --}}
            <div class="flex-1 relative">
                {{-- Time Markers --}}
                <div class="flex gap-20 pl-4 mb-4 text-gray-500 font-mono text-[11px]">
                    <span>0</span>
                    <span>5</span>
                    <span>10</span>
                    <span>15</span>
                    <span>20</span>
                </div>

                {{-- Grid/Tracks Background --}}
                <div class="relative bg-[#181818]/30 rounded-[12px] p-4 min-h-[220px] border border-white/5 overflow-hidden">
                    {{-- Vertical Grid Lines --}}
                    <div class="absolute inset-0 flex justify-between px-4 pointer-events-none opacity-5">
                        @for($i = 0; $i < 40; $i++)
                            <div class="w-px h-full bg-white"></div>
                        @endfor
                    </div>

                    {{-- Track 1: Tempo --}}
                    <div class="relative h-14 bg-[#1D2B53] rounded-[8px] mb-4 w-1/2 flex items-center px-4 overflow-hidden border border-[#4D61FF]/30">
                        @for($i = 0; $i < 30; $i++)
                            <div class="w-1 bg-[#4D61FF] rounded-full mx-[1px]" style="height: {{ rand(30, 70) }}%;"></div>
                        @endfor
                    </div>

                    {{-- Track 2: Beat --}}
                    <div class="relative h-14 bg-[#4B1D53] rounded-[8px] mb-4 w-[35%] ml-2 flex items-center px-4 overflow-hidden border border-[#AE4DFF]/30">
                        @for($i = 0; $i < 20; $i++)
                            <div class="w-1 bg-[#AE4DFF] rounded-full mx-[1px]" style="height: {{ rand(30, 70) }}%;"></div>
                        @endfor
                    </div>

                    {{-- Track 3: Vocals --}}
                    <div class="relative h-14 bg-[#1D2B53] rounded-[8px] w-[20%] ml-1 flex items-center px-4 overflow-hidden border border-[#4D61FF]/30">
                        @for($i = 0; $i < 12; $i++)
                            <div class="w-1 bg-[#4D61FF] rounded-full mx-[1px]" style="height: {{ rand(30, 70) }}%;"></div>
                        @endfor
                    </div>

                    {{-- Playhead Cursor --}}
                    <div class="absolute top-0 bottom-0 w-[2px] bg-white shadow-[0_0_10px_white] z-20 pointer-events-none transition-all duration-50" 
                         :style="`left: calc(${progress}% + 16px)`">
                        <div class="w-2 h-2 rounded-full bg-white -ml-[3px]"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <a href="{{ route('consumer.studio.completed-summary') }}" class="w-full py-5 bg-[#4D61FF] hover:bg-[#3d4ed9] text-white font-bold rounded-[14px] text-[18px] transition-all transform active:scale-[0.98] block text-center">
                Approve mix & generate
            </a>
            <button @click="window.history.back()" class="w-full py-5 bg-transparent border border-white/20 text-white font-bold rounded-[14px] text-[18px] hover:bg-white/5 transition-all">
                Back
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

    input[type=range] {
        -webkit-appearance: none;
        width: 100%;
        background: transparent;
    }

    input[type=range]::-webkit-slider-thumb {
        -webkit-appearance: none;
        height: 20px;
        width: 20px;
        border-radius: 50%;
        background: #4D61FF;
        cursor: pointer;
        margin-top: -8px;
        box-shadow: 0 0 10px rgba(77, 97, 255, 0.4);
    }

    input[type=range]::-webkit-slider-runnable-track {
        width: 100%;
        height: 4px;
        cursor: pointer;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 2px;
    }
</style>
@endpush