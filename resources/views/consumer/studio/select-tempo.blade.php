@extends('layouts.app')

@section('content')

<div class="h-full flex flex-col items-center justify-center -mt-8" x-data="{ 
    selectedTempo: 'slow',
    tempos: {
        'slow': { min: 20, max: 60, current: 30, title: 'Very slow', subtitle: '20-60 BPM' },
        'moderate': { min: 60, max: 90, current: 75, title: 'Slow to moderate', subtitle: '60-90 BPM' },
        'middle': { min: 90, max: 120, current: 105, title: 'Moderate (Middle range)', subtitle: '90-120 BPM' }
    }
}">
    <div class="w-full max-w-[1050px] border border-gray-800/40 rounded-[32px] p-10 md:p-14 bg-[#1b1c20]/60 backdrop-blur-xl shadow-2xl relative overflow-hidden flex flex-col">
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
                <h1 class="text-[42px] font-bold text-[#4D61FF] tracking-tight">Select your tempo</h1>
            </div>
            <p class="text-[18px] text-gray-400 font-medium max-w-2xl leading-relaxed">
                Choose your creative pace
            </p>
        </div>

        {{-- Selection area with global scroll if needed --}}
        <div class="space-y-6 relative z-10 overflow-y-auto max-h-[500px] pr-4 custom-scrollbar">
            <template x-for="(tempo, key) in tempos" :key="key">
                <div 
                    @click="selectedTempo = key"
                    :class="selectedTempo === key ? 'border-[#4D61FF] bg-[#4D61FF]/5' : 'border-white/5 bg-[#161719] hover:border-white/10'"
                    class="p-8 rounded-[24px] border-2 transition-all duration-300 cursor-pointer group"
                >
                    <div class="flex items-start gap-6 mb-8">
                        <div class="w-12 h-12 rounded-xl bg-white/5 flex items-center justify-center transition-colors group-hover:bg-[#4D61FF]/10">
                            <svg class="w-6 h-6 text-[#4D61FF]" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-white text-[22px] font-bold tracking-tight mb-1" x-text="tempo.title"></h3>
                            <p class="text-[15px] text-gray-500 font-medium" x-text="tempo.subtitle"></p>
                        </div>
                    </div>

                    <div class="space-y-4" @click.stop>
                        <p class="text-[13px] text-gray-500 font-bold uppercase tracking-widest">Or select manually from <span x-text="tempo.subtitle"></span></p>
                        
                        <div class="relative py-4">
                            <input 
                                type="range" 
                                :min="tempo.min" 
                                :max="tempo.max" 
                                x-model="tempos[key].current"
                                class="w-full h-2 bg-gray-800 rounded-full appearance-none cursor-pointer accent-[#4D61FF]"
                            >
                            <div class="flex justify-between mt-4">
                                <span class="text-[#4D61FF] font-bold text-[14px] font-mono"><span x-text="tempos[key].current"></span> BPM</span>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        {{-- Action Button --}}
        <div class="pt-10 relative z-10">
            <button class="w-full py-6 rounded-[18px] bg-[#4D61FF] hover:bg-[#3d4ed9] text-white font-bold text-[19px] transition-all duration-300 shadow-xl shadow-[#4D61FF]/20 active:scale-[0.99] tracking-wide">
                Create
            </button>
        </div>
    </div>
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #333; border-radius: 10px; }
    
    input[type=range] {
        -webkit-appearance: none;
        width: 100%;
        background: transparent;
    }
    input[type=range]:focus { outline: none; }
    input[type=range]::-webkit-slider-thumb {
        -webkit-appearance: none;
        height: 24px;
        width: 24px;
        border-radius: 50%;
        background: #4D61FF;
        cursor: pointer;
        margin-top: -8px; 
        box-shadow: 0 0 10px rgba(77, 97, 255, 0.5);
        border: 4px solid #161719;
    }
    input[type=range]::-webkit-slider-runnable-track {
        width: 100%;
        height: 8px;
        cursor: pointer;
        background: #222;
        border-radius: 4px;
    }
</style>

@endsection
