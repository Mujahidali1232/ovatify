@extends('layouts.app')

@section('content')

<div class="h-full flex flex-col justify-start pt-12 px-12" x-data="{ 
        isPlaying: false,
        progress: 0,
        analysisProgress: 0,
        interval: null,
        analysisInterval: null,
        waveformBars: [40, 60, 30, 80, 50, 40, 70, 90, 40, 30, 60, 80, 50, 40, 70, 30, 50, 60, 40, 80, 70, 50, 40, 60, 30, 80, 50, 40, 70, 90, 40, 30, 60, 80, 50, 40, 70, 30, 50, 60, 40, 80, 70, 50, 40, 60, 30, 80, 50, 40, 70, 90, 40, 30, 60, 80, 50, 40, 70, 30, 50, 60, 40, 80],
        
        init() {
            this.analysisInterval = setInterval(() => {
                this.analysisProgress += 0.5;
                if (this.analysisProgress >= 100) {
                    clearInterval(this.analysisInterval);
                    window.location.href = '{{ route('consumer.ai-tools.genre-matcher-results') }}';
                }
            }, 30);
        },
        togglePlay() {
            this.isPlaying = !this.isPlaying;
            if (this.isPlaying) {
                this.interval = setInterval(() => {
                    this.progress = (this.progress + 1) % 100;
                }, 500);
            } else {
                clearInterval(this.interval);
            }
        }
    }">
    
    <div class="w-full max-w-[900px]">
        
        {{-- Header Section --}}
        <div class="mb-10">
            <div class="flex items-center gap-4 mb-4">
                <a href="{{ url()->previous() }}" class="text-[#4D61FF] hover:text-magenta transition-colors">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="19" y1="12" x2="5" y2="12"></line>
                        <polyline points="12 19 5 12 12 5"></polyline>
                    </svg>
                </a>
                <h1 class="text-[32px] tracking-tight font-semibold text-[#4D61FF]">Genre Matcher</h1>
            </div>
        </div>

        <div class="space-y-10">
            
            {{-- Track Info Area --}}
            <div class="space-y-4">
                <div>
                    <h3 class="text-white text-[20px] font-medium tracking-tight">Lorem Ipsum</h3>
                    <p class="text-white/50 text-[14px] mt-0.5 font-medium">beat.waw - 120 BPM - 2.3 MB</p>
                </div>
                
                {{-- Waveform Player --}}
                <div class="bg-[#121212] rounded-[8px] p-6 pb-12 relative border border-white/5">
                    <div class="flex items-center gap-6">
                        <button @click="togglePlay" class="w-12 h-12 rounded-full border-[2px] border-magenta flex items-center justify-center text-magenta flex-shrink-0 transition-all hover:bg-magenta/10 active:scale-95">
                            <template x-if="!isPlaying">
                                <svg class="w-5 h-5 ml-0.5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                            </template>
                            <template x-if="isPlaying">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/></svg>
                            </template>
                        </button>
                        
                        <div class="flex-1 flex items-end gap-[3px] h-[40px]">
                            <template x-for="(height, index) in waveformBars" :key="index">
                                <div 
                                    class="flex-1 bg-[#1E297D] rounded-full transition-all duration-300"
                                    :style="`height: ${height}%; opacity: ${index < (progress * 0.64) ? '1' : '0.4'}`"
                                ></div>
                            </template>
                        </div>
                    </div>
                    <span class="absolute bottom-3 right-6 text-[#555555] text-[12px] font-medium tracking-wider">02:00</span>
                </div>
            </div>

            {{-- Analysis Progress Area --}}
            <div class="bg-[#121212] rounded-[8px] p-8 border border-white/5 space-y-4">
                <p class="text-white/70 text-[15px] font-medium tracking-wide">Analyzing Your Track...</p>
                <div class="h-1.5 w-full bg-white/5 rounded-full overflow-hidden">
                    <div class="h-full bg-indigo-600 transition-all duration-300" :style="`width: ${analysisProgress}%`"></div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<style>
    [x-cloak] { display: none !important; }
</style>
@endpush