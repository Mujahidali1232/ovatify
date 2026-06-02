@extends('layouts.app')

@section('content')

<div class="h-full flex flex-col items-center justify-start pt-10" x-data="{ 
    isPlaying: false,
    isEditing: false,
    progress: 0,
    lyrics: `[Verse 1]\n\nWoke up to a sky painted gold\nChasing dreams that I've been told\nFears behind and hopes ahead\nRunning free with no regret\n\n[Chorus]\n\nLight it up, let the fire fly\nWe're the stars in the midnight sky\nHearts beat loud like a battle cry\nTonight's the night we learn to fly`,
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
        
        {{-- Header Section --}}
        <div class="flex items-center gap-4 mb-4 relative z-10">
            <a href="{{ url()->previous() }}" class="text-[#4D61FF] hover:text-white transition-colors">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
            </a>
            <h1 class="text-[32px] font-semibold text-[#4D61FF]">Finalize Lyric</h1>
        </div>

        <div class="space-y-10 relative z-10 px-4">
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

            {{-- Generated Lyrics Section --}}
            <div class="space-y-6">
                <div class="flex items-center justify-between border-b border-white/5 pb-4">
                    <h3 class="text-white text-[18px] font-bold">Your Generated Lyrics</h3>
                    <button @click="isEditing = !isEditing" class="text-[#4D61FF] text-[14px] font-medium hover:underline">
                        <span x-text="isEditing ? 'Save' : 'Edit'">Edit</span>
                    </button>
                </div>
                
                <div class="bg-[#161719] rounded-[24px] p-8 border border-white/5 min-h-[300px]">
                    <div x-show="!isEditing" class="text-white/80 text-[15px] leading-relaxed whitespace-pre-line" x-text="lyrics">
                        [Verse 1]
                        
                        Woke up to a sky painted gold
                        Chasing dreams that I've been told
                        Fears behind and hopes ahead
                        Running free with no regret
                        
                        [Chorus]
                        
                        Light it up, let the fire fly
                        We're the stars in the midnight sky
                        Hearts beat loud like a battle cry
                        Tonight's the night we learn to fly
                    </div>
                    <textarea 
                        x-show="isEditing" 
                        x-model="lyrics"
                        class="w-full bg-transparent border-none text-white/90 text-[15px] leading-relaxed outline-none min-h-[300px] resize-none focus:ring-0 appearance-none"
                    ></textarea>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="space-y-4">
                <button @click="window.location.href='{{ route('consumer.ai-tools.lyric-generator-summary') }}'" class="w-full py-5 bg-[#4D61FF] hover:bg-[#3d4ed9] text-white font-bold rounded-[14px] text-[18px] transition-all transform active:scale-[0.98] shadow-lg shadow-[#4D61FF]/20">
                    Save & Continue
                </button>
                <button @click="window.location.href='{{ route('consumer.ai-tools.lyric-generator') }}'" class="w-full py-5 bg-transparent border border-white/20 text-white font-bold rounded-[14px] text-[18px] hover:bg-white/5 transition-all block text-center">
                    Generate again
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
