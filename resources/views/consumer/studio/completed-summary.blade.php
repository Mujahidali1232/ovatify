@extends('layouts.app')

@section('content')

<div class="h-full flex flex-col items-center justify-start pt-10" x-data="{ 
    isPlaying: false,
    progress: 45,
    tempo: 90,
    togglePlay() {
        this.isPlaying = !this.isPlaying;
    }
}">
    <div class="w-full max-w-[1000px] bg-[#111111] rounded-[24px] p-8 md:p-14 border border-white/5 shadow-2xl relative overflow-hidden">
        
        {{-- Header Section --}}
        <div class="flex items-center gap-4 mb-10 relative z-10">
            <a href="{{ url()->previous() }}" class="text-[#4D61FF] hover:text-white transition-colors">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
            </a>
            <h1 class="text-[32px] font-semibold text-[#4D61FF]">Completed Mixed Summary</h1>
        </div>

        <div class="space-y-12 relative z-10">
            {{-- Track Info & Player --}}
            <div class="space-y-6">
                <div>
                    <p class="text-gray-500 text-[14px] font-bold mb-1">Track Name</p>
                    <h2 class="text-white text-[24px] font-bold tracking-tight">Reflection</h2>
                </div>

                <div class="p-8 rounded-[24px] bg-[#161719] border border-white/5">
                    <div class="flex items-center gap-6">
                        <button @click="togglePlay()" class="w-14 h-14 flex-shrink-0 flex items-center justify-center rounded-full bg-magenta text-white hover:scale-105 transition-transform">
                            <template x-if="!isPlaying"><svg class="w-7 h-7 ml-1" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg></template>
                            <template x-if="isPlaying"><svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/></svg></template>
                        </button>
                        <div class="flex-1 h-14 flex items-center justify-between gap-[2px] relative overflow-hidden">
                            @for($i = 0; $i < 70; $i++)
                                <div class="w-0.5 bg-[#4D61FF] rounded-full opacity-30" style="height: {{ rand(30, 80) }}%;"></div>
                            @endfor
                            <div class="absolute inset-0 flex items-center gap-[2px] overflow-hidden transition-all duration-300" :style="`width: ${progress}%` ">
                                @for($i = 0; $i < 70; $i++)
                                    <div class="w-0.5 bg-[#4D61FF] rounded-full flex-shrink-0" style="height: {{ rand(30, 80) }}%;"></div>
                                @endfor
                            </div>
                        </div>
                        <span class="text-gray-500 font-mono text-[11px]">02:00</span>
                    </div>
                </div>
            </div>

            {{-- Track Tempo --}}
            <div class="space-y-6">
                <div class="flex items-center justify-between">
                    <h3 class="text-white text-[20px] font-bold">Your track Tempo</h3>
                    <div class="flex gap-6">
                        <button class="text-[#4D61FF] hover:underline text-[15px] font-medium">Remix again</button>
                        <button class="text-[#4D61FF] hover:underline text-[15px] font-medium">Approve mix</button>
                    </div>
                </div>
                <div class="space-y-4">
                    <div class="relative h-2 w-full bg-white/5 rounded-full overflow-hidden">
                        <div class="absolute left-0 top-0 h-full bg-[#4D61FF]/40" style="width: 50%"></div>
                        <div class="absolute left-1/2 -ml-2 top-1/2 -mt-2 w-4 h-4 rounded-full bg-[#4D61FF] border-2 border-[#111111] shadow-[0_0_10px_rgba(77,97,255,0.6)]"></div>
                    </div>
                    <div class="flex justify-end">
                        <span class="text-gray-500 font-mono text-[11px] font-bold uppercase tracking-widest">50 BPM</span>
                    </div>
                </div>
            </div>

            {{-- Metadata Review --}}
            <div class="space-y-6">
                <h3 class="text-white text-[20px] font-bold">Metadata Review</h3>
                <div class="flex flex-wrap gap-3">
                    <div class="px-6 py-3 rounded-full border border-[#4D61FF]/30 bg-[#4D61FF]/5 text-white text-[14px] font-bold">R&B</div>
                    @for($i = 0; $i < 4; $i++)
                        <div class="px-6 py-3 rounded-full border border-white/10 bg-white/5 text-white text-[14px] font-medium">90 BPM</div>
                    @endfor
                </div>
            </div>

            {{-- Agreement Templates --}}
            <div class="space-y-6">
                <div class="flex items-center justify-between">
                    <h3 class="text-white text-[20px] font-bold">Agreement Templates</h3>
                    <button class="text-[#4D61FF] hover:underline text-[15px] font-medium">Upload template</button>
                </div>
            </div>

            {{-- Action Button --}}
            <div class="pt-10">
                <button @click="window.location.href='{{ route('consumer.studio.studio-completion') }}'" class="w-full py-6 rounded-[18px] bg-[#4D61FF] hover:bg-[#3d4ed9] text-white font-bold text-[20px] transition-all transform active:scale-[0.99] shadow-xl shadow-[#4D61FF]/20">
                    Proceed, Publish Project
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<style>
    .bg-magenta { background-color: #FF00FF; }
    [x-cloak] { display: none !important; }
</style>
@endpush
