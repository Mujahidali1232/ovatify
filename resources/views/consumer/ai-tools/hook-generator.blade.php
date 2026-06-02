@extends('layouts.app')

@section('content')

<div class="h-full flex flex-col justify-start pt-12 px-12" x-data="{ 
        isPlaying: false,
        isGenerating: false,
        progress: 0,
        interval: null,
        selectedGenre: 'POP',
        selectedMood: 'Chill & Smooth',
        optionalIdeas: '',
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
        },
        runGenerator() {
            this.isGenerating = true;
            setTimeout(() => {
                window.location.href = '{{ route('consumer.ai-tools.hook-generator-results') }}';
            }, 3000);
        }
    }">
    
    <div class="w-full max-w-[900px]">
        
        {{-- Header Section --}}
        <div class="mb-10">
            <div class="flex items-center gap-4">
                <a href="{{ url()->previous() }}" class="text-[#4D61FF] hover:text-magenta transition-colors">
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

            {{-- Configuration Form --}}
            <div class="space-y-8">
                {{-- Select Genre --}}
                <div class="space-y-3">
                    <label class="text-[#555555] text-[14px] font-semibold uppercase tracking-wider">Select Genre</label>
                    <div class="relative">
                        <select x-model="selectedGenre" class="w-full bg-[#1A1A1A] border border-[#1E297D]/60 rounded-[4px] px-5 py-4 text-white/90 text-[15px] appearance-none outline-none focus:border-[#1E297D] transition-all cursor-pointer">
                            <option>POP</option>
                            <option>R&B</option>
                            <option>Hip-Hop</option>
                            <option>Rock</option>
                            <option>Lo-Fi</option>
                        </select>
                        <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-[#555555]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                        </div>
                    </div>
                </div>

                {{-- Mood Selection --}}
                <div class="space-y-3">
                    <label class="text-[#555555] text-[14px] font-semibold uppercase tracking-wider">Mood</label>
                    <div class="flex flex-wrap gap-3">
                        <template x-for="mood in ['Chill & Smooth', 'Uplifting & Catchy', 'Dark', 'Hip-Hop']">
                            <button 
                                @click="selectedMood = mood"
                                :class="selectedMood === mood ? 'border-[#1E297D] bg-[#1E297D]/10 text-white' : 'bg-[#18181A] border-white/5 text-[#555555] hover:text-white/90'"
                                class="px-6 py-3 rounded-[4px] border border-[1px] text-[14px] font-medium transition-all transform active:scale-95"
                                x-text="mood"
                            ></button>
                        </template>
                    </div>
                </div>

                {{-- Optional Ideas --}}
                <div class="space-y-3">
                    <label class="text-[#555555] text-[14px] font-semibold uppercase tracking-wider">Optional Ideas</label>
                    <textarea 
                        x-model="optionalIdeas"
                        placeholder="Ocean waves, summer etc"
                        class="w-full bg-[#121212] border border-white/5 focus:border-[#1E297D]/40 rounded-[4px] p-5 text-[15px] text-white/90 placeholder:text-[#333333] h-[120px] resize-none outline-none transition-colors"
                    ></textarea>
                </div>
            </div>

            {{-- Action Button --}}
            <div class="pt-4">
                <button @click="runGenerator" class="w-full py-5 bg-[#171A3B] hover:bg-[#1C204A] text-[#4D61FF] font-semibold rounded-[4px] text-[18px] tracking-wide transition-all shadow-xl active:scale-[0.99] border border-[#1E297D]/30">
                    Generate Hook
                </button>
            </div>
        </div>
    </div>

    {{-- Loading Overlay --}}
    <div x-show="isGenerating" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center">
        <div class="absolute inset-0 bg-black/80 backdrop-blur-[4px]"></div>
        <div class="bg-[#242426] rounded-[8px] p-8 max-w-[480px] w-full relative z-10 shadow-2xl border border-white/5">
            <h3 class="text-[#4D61FF] text-[18px] font-bold tracking-tight mb-2">Generating Hooks...</h3>
            <p class="text-white/70 text-[14px] leading-relaxed">This might take 20–40 seconds depending on your track.</p>
            
            <div class="mt-6 h-1 w-full bg-white/5 rounded-full overflow-hidden">
                <div class="h-full bg-[#4D61FF] animate-pulse-fast w-1/3"></div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<style>
    [x-cloak] { display: none !important; }
    
    @keyframes pulse-fast {
        0%, 100% { transform: translateX(-100%); }
        50% { transform: translateX(300%); }
    }
    .animate-pulse-fast {
        animation: pulse-fast 2s infinite ease-in-out;
    }
</style>
@endpush
sh