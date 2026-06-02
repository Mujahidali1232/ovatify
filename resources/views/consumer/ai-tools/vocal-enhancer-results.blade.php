@extends('layouts.app')

@section('content')

<div class="h-full flex flex-col items-center justify-start pt-10" x-data="{ 
    isPlaying: false,
    showSuccess: false,
    progress: 0,
    waveformBars: Array.from({length: 60}, () => Math.floor(Math.random() * 60) + 20),
    togglePlay() {
        this.isPlaying = !this.isPlaying;
        if (this.isPlaying) {
            this.interval = setInterval(() => {
                this.progress = (this.progress + 1) % 100;
            }, 1000);
        } else {
            clearInterval(this.interval);
        }
    }
}">
    <div class="w-full max-w-[1000px] bg-[#111111] rounded-[24px] p-8 md:p-14 border border-white/5 shadow-2xl relative overflow-hidden">
        
        {{-- Success Modal Overlay --}}
        <div x-show="showSuccess" x-cloak class="absolute inset-0 z-50 flex items-center justify-center p-6">
            <div class="absolute inset-0 bg-black/80 backdrop-blur-sm"></div>
            <div class="bg-[#1E1E1E] rounded-[32px] p-10 max-w-[440px] w-full relative z-10 border border-white/5 shadow-2xl text-center transform transition-all scale-100">
                {{-- Success Icon --}}
                <div class="relative w-32 h-32 mx-auto mb-8">
                    <div class="absolute inset-0 bg-[#FF00FF] rounded-full blur-[30px] opacity-20 animate-pulse"></div>
                    <div class="relative w-full h-full bg-[#FF00FF] rounded-full flex items-center justify-center shadow-lg shadow-[#FF00FF]/40">
                        <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" stroke-width="4" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                </div>

                <h3 class="text-white text-[28px] font-bold mb-3 tracking-tight">Your Track has been saved!</h3>
                <p class="text-white/60 text-[16px] mb-10">You can access it in your projects</p>
                
                <div class="space-y-4">
                    <button @click="window.location.href='{{ route('consumer.studio.upload-partial') }}'" class="w-full py-5 bg-[#4D61FF] hover:bg-[#3d4ed9] text-white font-bold rounded-[14px] text-[17px] transition-all transform active:scale-[0.98] shadow-lg shadow-[#4D61FF]/20">
                        Upload another track
                    </button>
                    <button @click="window.location.href='{{ route('consumer.dashboard.index') }}'" class="w-full py-5 bg-transparent border border-white/20 text-white font-bold rounded-[14px] text-[17px] hover:bg-white/5 transition-all">
                        Back to home
                    </button>
                </div>
            </div>
        </div>

        {{-- Header Section --}}
        <div class="flex items-center gap-4 mb-10 relative z-10">
            <a href="{{ url()->previous() }}" class="text-[#4D61FF] hover:text-white transition-colors">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
            </a>
            <h1 class="text-[32px] font-semibold text-[#4D61FF]">Vocal Enhancer</h1>
        </div>

        <div class="space-y-12 relative z-10">
            {{-- Track Info Area --}}
            <div class="space-y-4">
                <h3 class="text-white text-[20px] font-bold">Lorem Ipsum</h3>
                <p class="text-gray-500 text-[14px]">beat.waw - 120 BPM - 2.3 MB</p>
                
                {{-- Waveform Player --}}
                <div class="bg-[#161719] rounded-[18px] p-6 border border-white/5">
                    <div class="flex items-center gap-6">
                        <button @click="togglePlay" class="w-12 h-12 rounded-full bg-[#FF00FF] flex items-center justify-center text-white flex-shrink-0 transition-transform active:scale-90">
                            <template x-if="!isPlaying">
                                <svg class="w-6 h-6 ml-1" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                            </template>
                            <template x-if="isPlaying">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/></svg>
                            </template>
                        </button>
                        
                        <div class="flex-1 flex items-center gap-[3px] h-12">
                            <template x-for="(height, index) in waveformBars" :key="index">
                                <div 
                                    class="flex-1 bg-[#4D61FF] rounded-full transition-all duration-300"
                                    :style="`height: ${height}%; opacity: ${index < (progress * 0.6) ? '1' : '0.3'}`"
                                ></div>
                            </template>
                        </div>
                        <span class="text-white/40 text-[12px] font-medium">02:00</span>
                    </div>
                </div>
            </div>

            {{-- What changes were made --}}
            <div class="space-y-4">
                <h3 class="text-white text-[18px] font-bold">What changes were made?</h3>
                <ul class="space-y-2">
                    <li class="flex items-center gap-3 text-white/80 text-[15px]">
                        <div class="w-1.5 h-1.5 rounded-full bg-white/40"></div>
                        Applied R&B Female Vocal with Energetic Mood.
                    </li>
                </ul>
            </div>

            {{-- Action Buttons --}}
            <div class="space-y-4">
                <button @click="window.location.href='{{ route('consumer.ai-tools.vocal-enhancer') }}'" class="w-full py-5 bg-transparent border border-[#4D61FF]/40 text-white font-bold rounded-[14px] text-[18px] hover:bg-white/5 transition-all block text-center">
                    Re-run with different settings
                </button>
                <button @click="showSuccess = true" class="w-full py-5 bg-[#4D61FF] hover:bg-[#3d4ed9] text-white font-bold rounded-[14px] text-[18px] transition-all transform active:scale-[0.98] shadow-lg shadow-[#4D61FF]/20">
                    Save my track
                </button>
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
