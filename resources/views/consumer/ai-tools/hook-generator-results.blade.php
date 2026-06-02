@extends('layouts.app')

@section('content')

<div class="h-full flex flex-col justify-start pt-12 px-12" x-data="{ 
        isPlaying: false,
        progress: 0,
        interval: null,
        isAccordionOpen: false,
        showSaveSuccess: false,
        waveformBars: [40, 60, 30, 80, 50, 40, 70, 90, 40, 30, 60, 80, 50, 40, 70, 30, 50, 60, 40, 80, 70, 50, 40, 60, 30, 80, 50, 40, 70, 90, 40, 30, 60, 80, 50, 40, 70, 30, 50, 60, 40, 80, 70, 50, 40, 60, 30, 80, 50, 40, 70, 90, 40, 30, 60, 80, 50, 40, 70, 30, 50, 60, 40, 80],
        
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
            <div class="flex items-center gap-4">
                <a href="{{ route('consumer.ai-tools.hook-generator') }}" class="text-[#4D61FF] hover:text-magenta transition-colors">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="19" y1="12" x2="5" y2="12"></line>
                        <polyline points="12 19 5 12 12 5"></polyline>
                    </svg>
                </a>
                <h1 class="text-[32px] tracking-tight font-semibold text-[#4D61FF]">Hook Generator</h1>
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
                    <div class="flex items-center gap-6" :class="{ 'opacity-30': showSaveSuccess }">
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
                    <span class="absolute bottom-3 right-6 text-[#555555] text-[12px] font-medium tracking-wider" :class="{ 'opacity-30': showSaveSuccess }">02:00</span>
                </div>
            </div>

            {{-- Results Area --}}
            <div class="space-y-6" :class="{ 'opacity-30 pointer-events-none': showSaveSuccess }">
                <p class="text-white text-[15px] font-medium">Hooks added to your project successfully</p>
                
                {{-- Generated Hooks Accordion --}}
                <div class="bg-[#121212] rounded-[8px] border border-white/5 overflow-hidden">
                    <button @click="isAccordionOpen = !isAccordionOpen" class="w-full flex items-center justify-between p-6 text-white/90 hover:bg-white/[0.02] transition-colors">
                        <span class="text-[15px] font-medium tracking-wide">Your Generated hooks</span>
                        <svg class="w-5 h-5 transition-transform duration-300" :class="isAccordionOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    
                    <div x-show="isAccordionOpen" x-collapse class="px-6 pb-6 space-y-4">
                        <div class="h-px bg-white/5 w-full"></div>
                        <div class="space-y-3">
                            <p class="text-white/60 text-[14px] leading-relaxed italic">
                                Hook 1: [Generated Hook Content Hidden]
                            </p>
                            <p class="text-white/60 text-[14px] leading-relaxed italic">
                                Hook 2: [Generated Hook Content Hidden]
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Action Button --}}
            <div class="pt-8">
                <button @click="showSaveSuccess = true" class="w-full py-5 bg-[#171A3B] text-[#4D61FF] font-semibold rounded-[8px] text-[18px] tracking-wide transition-all shadow-xl block text-center border border-[#1E297D]/30" :class="{ 'opacity-30 pointer-events-none': showSaveSuccess }">
                    Save to my projects
                </button>
            </div>
        </div>
    </div>

    {{-- Save Success Modal --}}
    <div x-show="showSaveSuccess" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/85 backdrop-blur-sm" @click="showSaveSuccess = false"></div>
        
        <div class="relative bg-[#1b1c20] border border-white/10 rounded-[2.5rem] w-full max-w-[440px] p-10 md:p-14 shadow-3xl text-center overflow-visible"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100">
            
            {{-- Success Icon Container --}}
            <div class="relative w-36 h-36 mx-auto mb-10">
                {{-- Floating Dots --}}
                <div class="absolute -top-3 left-1/4 w-3.5 h-3.5 rounded-full bg-magenta"></div>
                <div class="absolute top-1/2 -left-6 w-1.5 h-1.5 rounded-full bg-magenta/60"></div>
                <div class="absolute -bottom-4 right-1/3 w-2 h-2 rounded-full bg-magenta/80"></div>
                <div class="absolute top-1/4 -right-5 w-2.5 h-2.5 rounded-full bg-magenta"></div>
                <div class="absolute bottom-4 -right-4 w-1.5 h-1.5 rounded-full bg-magenta/40"></div>
                
                {{-- Main Circle --}}
                <div class="w-full h-full rounded-full bg-magenta flex items-center justify-center shadow-[0_0_50px_rgba(255,0,255,0.3)] relative z-10">
                    <div class="w-14 h-14 rounded-2xl bg-white flex items-center justify-center shadow-lg">
                        <svg class="w-9 h-9 text-magenta" fill="none" stroke="currentColor" stroke-width="4.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                </div>
            </div>

            <h2 class="text-[26px] font-bold mb-4 text-white leading-tight tracking-tight">Your Track has been saved!</h2>
            <p class="text-[15px] text-gray-400 mb-12 leading-relaxed px-2">You can access it in your projects</p>

            <div class="space-y-4">
                <a href="{{ route('consumer.ai-tools.hook-generator') }}" 
                    class="block w-full py-5 rounded-full bg-[#5c67ff] text-white font-bold text-[17px] hover:bg-[#4b55e6] transition-all duration-300 shadow-lg shadow-[#5c67ff]/20 active:scale-[0.98]">
                    Upload another track
                </a>
                
                <a href="{{ route('consumer.dashboard.index') }}" 
                    class="block w-full py-5 rounded-full bg-[#1b1c20] border border-white/10 text-white font-bold text-[17px] hover:bg-white/[0.05] transition-all duration-300 active:scale-[0.98]">
                    Back to home
                </a>
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
