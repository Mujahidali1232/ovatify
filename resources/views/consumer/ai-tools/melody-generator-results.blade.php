@extends('layouts.app')

@section('content')

<div class="h-full flex flex-col justify-start pt-10 px-8" x-data="{ 
        isPlaying: false,
        showMelody: false,
        showSuccess: false,
        progress: 0,
        interval: null,
        waveformBars: Array.from({length: 64}, () => Math.floor(Math.random() * 60) + 20),
        
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
    
    <div class="w-full max-w-[800px] mx-auto border border-white/5 bg-[#141414] rounded-[16px] p-8 relative">
        
        {{-- Success Modal Overlay --}}
        <div x-show="showSuccess" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-[#000000]/70 backdrop-blur-[2px]"></div>
            <div class="bg-[#242426] rounded-[24px] p-10 pb-8 max-w-[420px] w-full relative z-10 shadow-2xl text-center transform transition-all scale-100 flex flex-col items-center">
                
                {{-- Success Graphic --}}
                <div class="relative w-32 h-32 mx-auto mb-6 flex justify-center items-center">
                    {{-- Sparkle Dots --}}
                    <div class="absolute top-[10%] left-[20%] w-2.5 h-2.5 bg-[#FF00FF] rounded-full"></div>
                    <div class="absolute top-[25%] right-[10%] w-3 h-3 bg-[#FF00FF] rounded-full"></div>
                    <div class="absolute bottom-[40%] left-[5%] w-1.5 h-1.5 bg-[#FF00FF] rounded-full"></div>
                    <div class="absolute bottom-[20%] right-[15%] w-1 h-1 bg-[#FF00FF] rounded-full"></div>
                    <div class="absolute bottom-[10%] left-[35%] w-2 h-2 bg-[#FF00FF] rounded-full"></div>
                    
                    {{-- Main Magenta Circle --}}
                    <div class="relative w-24 h-24 bg-[#FF00FF] rounded-full flex items-center justify-center shadow-lg shadow-[#FF00FF]/40 z-10">
                        {{-- Inner White Check Icon --}}
                        <div class="w-10 h-10 bg-white rounded-[10px] flex items-center justify-center">
                            <svg class="w-6 h-6 text-[#FF00FF]" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <h3 class="text-white text-[20px] font-bold mb-2 tracking-wide">Your Track has been saved!</h3>
                <p class="text-white/70 text-[13px] font-medium mb-10">You can access it in your projects</p>
                
                <div class="space-y-4 w-full">
                    <button @click="window.location.href='{{ route('consumer.studio.upload-partial') }}'" class="w-full py-3.5 bg-[#4D61FF] hover:bg-[#4D61FF]/90 text-white font-semibold rounded-full text-[14px] transition-all transform active:scale-[0.98]">
                        Upload another track
                    </button>
                    <button @click="window.location.href='{{ route('consumer.dashboard.index') }}'" class="w-full py-3.5 bg-transparent border border-white/20 hover:bg-white/[0.02] text-white font-semibold rounded-full text-[14px] transition-all transform active:scale-[0.98]">
                        Back to home
                    </button>
                </div>
            </div>
        </div>

        {{-- Header Section --}}
        <div class="mb-8">
            <div class="flex items-center gap-3">
                <a href="{{ url()->previous() }}" class="text-[#4D61FF] hover:text-white transition-colors">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="19" y1="12" x2="5" y2="12"></line>
                        <polyline points="12 19 5 12 12 5"></polyline>
                    </svg>
                </a>
                <h1 class="text-[24px] tracking-wide font-medium text-[#4D61FF]">Melody Generating</h1>
            </div>
        </div>

        <div class="space-y-8">
            
            {{-- Track Info Area --}}
            <div class="space-y-3">
                <div>
                    <h3 class="text-white text-[16px] font-medium tracking-wide">Lorem Ipsum</h3>
                    <p class="text-white/60 text-[12px] mt-0.5">beat.waw - 120 BPM - 2.3 MB</p>
                </div>
                
                {{-- Waveform Player --}}
                <div class="bg-[#202022] rounded-[8px] p-5 pb-8 relative shadow-inner">
                    <div class="flex items-center gap-5">
                        <button @click="togglePlay" class="w-10 h-10 rounded-full border-[2px] border-[#d90bb3] flex items-center justify-center text-[#d90bb3] flex-shrink-0 transition-transform active:scale-90 hover:bg-[#d90bb3]/10">
                            <template x-if="!isPlaying">
                                <svg class="w-4 h-4 ml-0.5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                            </template>
                            <template x-if="isPlaying">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/></svg>
                            </template>
                        </button>
                        
                        <div class="flex-1 flex items-center gap-[2px] h-[36px]">
                            <template x-for="(height, index) in waveformBars" :key="index">
                                <div 
                                    class="flex-1 bg-[#4D61FF] rounded-full transition-all duration-300"
                                    :style="`height: ${height}%; opacity: ${index < (progress * 0.64) ? '1' : '0.4'}`"
                                ></div>
                            </template>
                        </div>
                    </div>
                    <span class="absolute bottom-2 right-5 text-white/50 text-[10px] font-medium">02:00</span>
                </div>
            </div>

            {{-- Confirmation & Collapsible --}}
            <div class="space-y-4 pt-2">
                <p class="text-white/90 text-[14px] font-medium">Melody added to your project seccessfully</p>
                
                <div>
                    <div @click="showMelody = !showMelody" class="bg-[#18181A] rounded-[6px] px-4 py-4 border border-white/5 flex items-center justify-between cursor-pointer hover:bg-white/[0.02] transition-all group">
                        <h3 class="text-white/80 text-[13px] font-medium transition-colors">Your Generated Melody</h3>
                        <svg class="w-4 h-4 text-[#4D61FF] transition-transform duration-300" :class="showMelody ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                    
                    <div x-show="showMelody" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="bg-[#1E1E20] rounded-b-[6px] p-5 border-x border-b border-white/5 -mt-1 pt-4">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-white/50 text-[13px]">Melody Preview</span>
                            <button class="text-[#4D61FF] text-[13px] hover:underline font-medium">Download MIDI</button>
                        </div>
                        <div class="h-24 w-full bg-white/5 rounded-[8px] border border-white/5 flex items-center justify-center">
                            <span class="text-white/20 text-[12px]">Piano Roll / Waveform Preview</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Action Button --}}
            <div class="pt-10">
                <button @click="showSuccess = true" class="w-full py-4 bg-[#4D61FF] hover:bg-[#4D61FF]/90 text-white font-medium rounded-[8px] text-[15px] transition-all block text-center">
                    Save to my projects
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
