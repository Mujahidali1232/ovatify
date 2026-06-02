@extends('layouts.app')

@section('content')

<div class="h-full flex flex-col justify-start pt-10 px-8" x-data="{ 
        isPlaying: false,
        isGenerating: false,
        progress: 0,
        interval: null,
        selectedGenre: 'POP',
        selectedStyle: 'Chill & Smooth',
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
        },
        runGenerator() {
            this.isGenerating = true;
            setTimeout(() => {
                window.location.href = '{{ route('consumer.ai-tools.melody-generator-results') }}';
            }, 2500);
        }
    }">
    
    <div class="w-full max-w-[800px] mx-auto border border-white/5 bg-[#141414] rounded-[16px] p-8">
        
        {{-- Loading Overlay --}}
        <div x-show="isGenerating" x-cloak class="fixed inset-0 z-50 flex items-center justify-center">
            <div class="absolute inset-0 bg-[#000000]/60 backdrop-blur-[2px]"></div>
            <div class="bg-[#242426] rounded-[8px] p-6 max-w-[420px] w-full relative z-10 shadow-2xl flex flex-col justify-center">
                <h3 class="text-[#4D61FF] text-[16px] font-semibold tracking-wide mb-1.5">Generating Melody...</h3>
                <p class="text-white/80 text-[13px] font-medium">This might take 20-40 seconds depending on your track.</p>
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
                <h1 class="text-[24px] tracking-wide font-medium text-[#4D61FF]">Melody Generator</h1>
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

            {{-- Configuration Form --}}
            <div class="space-y-6 pt-2">
                {{-- Select Genre --}}
                <div class="space-y-3">
                    <label class="text-white/90 text-[14px] font-medium">Select Genre</label>
                    <div class="relative">
                        <select x-model="selectedGenre" class="w-full bg-[#18181A] border border-[#4D61FF]/40 rounded-[6px] px-4 py-3.5 text-white/80 text-[13px] appearance-none outline-none focus:border-[#4D61FF] transition-all cursor-pointer">
                            <option>POP</option>
                            <option>R&B</option>
                            <option>Hip-Hop</option>
                            <option>Rock</option>
                            <option>Lo-Fi</option>
                        </select>
                        <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-white/50">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                        </div>
                    </div>
                </div>

                <div class="h-px w-full bg-white/5 my-2"></div>

                {{-- Melody Style --}}
                <div class="space-y-3">
                    <label class="text-white/90 text-[14px] font-medium">Melody Style</label>
                    <div class="flex flex-wrap gap-2.5">
                        <template x-for="style in ['Chill & Smooth', 'Uplifting & Catchy', 'Dark', 'Hip-Hop']">
                            <button 
                                @click="selectedStyle = style"
                                :class="selectedStyle === style ? 'border-[#4D61FF] bg-[#4D61FF]/10 text-white' : 'bg-[#18181A] border-white/5 text-white/60 hover:text-white/90 hover:bg-white/[0.02]'"
                                class="px-5 py-2.5 rounded-[4px] border border-[1px] text-[13px] font-medium transition-all transform active:scale-95"
                                x-text="style"
                            ></button>
                        </template>
                    </div>
                </div>
            </div>

            {{-- Action Button --}}
            <div class="pt-6">
                <button @click="runGenerator" class="w-full py-4 bg-[#4D61FF] hover:bg-[#4D61FF]/90 text-white font-medium rounded-[8px] text-[15px] transition-all block text-center shadow-lg shadow-[#4D61FF]/20">
                    Generate Melody
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