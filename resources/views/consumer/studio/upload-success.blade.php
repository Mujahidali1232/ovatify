@extends('layouts.app')

@section('content')

<div class="h-full flex flex-col items-center justify-start pt-10" x-data="{ 
    isPlaying: false,
    progress: 0,
    interval: null,
    togglePlay() {
        this.isPlaying = !this.isPlaying;
        if (this.isPlaying) {
            this.interval = setInterval(() => {
                if (this.progress >= 100) {
                    this.isPlaying = false;
                    clearInterval(this.interval);
                    this.progress = 0;
                } else {
                    this.progress += 0.5;
                }
            }, 50);
        } else {
            clearInterval(this.interval);
        }
    }
}">
    <div class="w-full max-w-[1000px] bg-[#111111] rounded-[24px] p-8 md:p-14 border border-white/5 shadow-2xl overflow-hidden relative">
        {{-- Background glow --}}
        <div class="absolute top-0 right-0 w-80 h-80 bg-[#4D61FF]/5 rounded-full blur-[120px] -mr-40 -mt-40"></div>
        
        {{-- Header --}}
        <div class="flex items-center gap-4 mb-10 relative z-10">
            <a href="{{ url()->previous() }}" class="text-[#4D61FF] hover:text-white transition-colors">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
            </a>
            <h1 class="text-[32px] font-semibold text-[#4D61FF]">Files Uploaded Successfully</h1>
        </div>

        <div class="space-y-10 relative z-10">
            {{-- Your file idea --}}
            <div class="space-y-4">
                <h3 class="text-white text-[18px] font-medium">Your file idea</h3>
                <div class="p-6 rounded-[16px] bg-[#161719] border border-white/5">
                    <h4 class="text-white font-bold text-[16px] mb-1">My Music file</h4>
                    <p class="text-gray-500 text-[14px]">beat.wav • 120 BPM • 3.2 MB</p>
                </div>
            </div>

            {{-- Your recorded audio --}}
            <div class="space-y-4">
                <h3 class="text-white text-[18px] font-medium">Your recorded audio</h3>
                <div class="bg-[#161719] rounded-[16px] p-6 border border-white/5 relative">
                    <div class="flex items-center gap-6">
                        <button @click="togglePlay()" class="w-12 h-12 flex-shrink-0 flex items-center justify-center rounded-full bg-magenta text-white hover:scale-105 transition-transform">
                            <template x-if="!isPlaying"><svg class="w-6 h-6 ml-0.5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg></template>
                            <template x-if="isPlaying"><svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/></svg></template>
                        </button>
                        
                        <div class="flex-1 h-12 flex items-center justify-between gap-[2px] relative overflow-hidden">
                            @for($i = 0; $i < 70; $i++)
                                <div class="w-0.5 bg-[#4D61FF] rounded-full opacity-30" style="height: {{ rand(20, 80) }}%;"></div>
                            @endfor
                            <div class="absolute inset-0 flex items-center gap-[2px] overflow-hidden pointer-events-none" :style="`width: ${progress}%` ">
                                @for($i = 0; $i < 70; $i++)
                                    <div class="w-0.5 bg-[#4D61FF] rounded-full flex-shrink-0" style="height: {{ rand(20, 80) }}%;"></div>
                                @endfor
                            </div>
                        </div>
                    </div>
                    <div class="absolute bottom-3 right-6">
                        <span class="text-gray-600 font-mono text-[10px]">02:00</span>
                    </div>
                </div>
            </div>

            {{-- Your text idea --}}
            <div class="space-y-4">
                <h3 class="text-white text-[18px] font-medium">Your text idea</h3>
                <div class="p-6 rounded-[16px] bg-[#161719] border border-white/5">
                    <p class="text-gray-400 text-[14px] leading-relaxed">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum
                    </p>
                </div>
            </div>

            {{-- Action Button --}}
            <div class="pt-6">
                <a href="{{ route('consumer.studio.customize-track') }}" class="w-full py-5 bg-[#4D61FF] hover:bg-[#3d4ed9] text-white font-bold rounded-[14px] text-[18px] transition-all transform active:scale-[0.98] block text-center shadow-lg shadow-[#4D61FF]/20">
                    Approve to continue
                </a>
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
