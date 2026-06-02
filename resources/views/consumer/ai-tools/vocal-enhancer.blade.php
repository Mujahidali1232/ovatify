@extends('layouts.app')

@section('content')

<div class="h-full flex flex-col items-center justify-start pt-10" x-data="{ 
    isPlaying: false,
    isEnhancing: false,
    progress: 0,
    vocalOption: 'Generate new vocals',
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
    },
    runEnhancer() {
        this.isEnhancing = true;
        {{-- For demo purposes, we can stay in this state or redirect after a delay --}}
    }
}">
    <div class="w-full max-w-[1000px] bg-[#111111] rounded-[24px] p-8 md:p-14 border border-white/5 shadow-2xl relative overflow-hidden">
        
        {{-- Loading Overlay --}}
        <div x-show="isEnhancing" x-cloak class="absolute inset-0 z-50 flex items-center justify-center">
            <div class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>
            <div class="bg-[#222222] rounded-[16px] p-10 max-w-[400px] w-full relative z-10 border border-white/5 shadow-2xl transform transition-all">
                <h3 class="text-[#4D61FF] text-[22px] font-bold mb-2">Enhancing vocals...</h3>
                <p class="text-white/60 text-[15px]">This might take 20-40 seconds depending on your track.</p>
                
                {{-- Optional: Add a small animated loader --}}
                <div class="mt-6 h-1 w-full bg-white/5 rounded-full overflow-hidden">
                    <div class="h-full bg-[#4D61FF] animate-[loading_2s_ease-in-out_infinite] w-1/3 rounded-full"></div>
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

        <div class="space-y-10 relative z-10">
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

            {{-- Vocal Configuration --}}
            <div class="space-y-8">
                {{-- Dropdown --}}
                <div class="space-y-4">
                    <label class="text-white text-[16px] font-medium">Do you want to generate new vocals or enhance existing ones?</label>
                    <div class="relative">
                        <select x-model="vocalOption" class="w-full bg-[#161719] border border-[#4D61FF]/30 rounded-[14px] px-6 py-4 text-white appearance-none outline-none focus:border-[#4D61FF] transition-all cursor-pointer font-medium">
                            <option>Generate new vocals</option>
                            <option>Enhance existing vocals</option>
                        </select>
                        <div class="absolute right-6 top-1/2 -translate-y-1/2 pointer-events-none text-gray-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"/></svg>
                        </div>
                    </div>
                </div>

                {{-- Textarea --}}
                <div class="space-y-4">
                    <div class="bg-[#161719] rounded-[18px] border border-white/5 p-2">
                        <textarea 
                            placeholder="Describe your vocal style (e.g. soulful, robotic, airy)" 
                            class="w-full bg-transparent border-none outline-none p-6 text-white placeholder-gray-600 min-h-[160px] resize-none font-medium"
                        ></textarea>
                    </div>
                </div>

                {{-- Vocal Type Select --}}
                <div class="space-y-4">
                    <label class="text-white text-[16px] font-medium">Select Vocal type</label>
                    <div class="h-px bg-white/5 w-full"></div>
                </div>
            </div>

            {{-- Action Button --}}
            <div class="pt-2">
                <button @click="runEnhancer" class="w-full py-5 bg-[#4D61FF] hover:bg-[#3d4ed9] text-white font-bold rounded-[14px] text-[18px] transition-all transform active:scale-[0.98] shadow-lg shadow-[#4D61FF]/20">
                    Run Vocal Enhancer
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes loading {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(300%); }
    }
</style>

@endsection

@push('scripts')
<style>
    [x-cloak] { display: none !important; }
</style>
@endpush
