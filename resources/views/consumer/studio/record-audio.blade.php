@extends('layouts.app')

@section('content')

<div class="h-full flex flex-col items-center justify-center -mt-8" x-data="{ 
    isRecording: false, 
    timer: 0, 
    intervalId: null,
    startTimer() {
        this.isRecording = true;
        this.intervalId = setInterval(() => { this.timer++ }, 1000);
    },
    stopTimer() {
        this.isRecording = false;
        clearInterval(this.intervalId);
        window.location.href = "{{ route('consumer.studio.audio-review') }}";
    },
    formatTime(seconds) {
        const m = Math.floor(seconds / 60);
        const s = seconds % 60;
        return `${m.toString().padStart(2, '0')}:${s.toString().padStart(2, '0')}`;
    }
}">
    <div class="w-full max-w-[1000px] border border-gray-800/40 rounded-[32px] p-10 md:p-14 bg-[#1b1c20]/60 backdrop-blur-xl shadow-2xl relative overflow-hidden flex flex-col min-h-[600px]">
        {{-- Background glow --}}
        <div class="absolute top-0 right-0 w-80 h-80 bg-[#4D61FF]/5 rounded-full blur-[120px] -mr-40 -mt-40"></div>
        
        {{-- Header --}}
        <div class="mb-6 relative z-10">
            <div class="flex items-center gap-6">
                <a href="{{ url()->previous() }}" class="text-[#4D61FF] hover:text-white transition-colors duration-200">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="19" y1="12" x2="5" y2="12"></line>
                        <polyline points="12 19 5 12 12 5"></polyline>
                    </svg>
                </a>
                <h1 class="text-[42px] font-bold text-[#4D61FF] tracking-tight">Record Audio</h1>
            </div>
        </div>

        <div class="h-px bg-white/5 w-full mb-12"></div>

        {{-- Record Interface --}}
        <div class="flex-1 flex flex-col items-center justify-center relative z-10 pb-20">
            {{-- Circular Record Button --}}
            <button 
                @click="isRecording ? stopTimer() : startTimer()"
                class="relative w-72 h-72 rounded-full p-2 flex items-center justify-center transition-all duration-500 group"
                :class="isRecording ? 'scale-110' : 'hover:scale-105'"
            >
                {{-- Gradient Border --}}
                <div class="absolute inset-0 rounded-full bg-gradient-to-tr from-[#FF00FF] via-[#4D61FF] to-[#00FFFF] animate-spin-slow"></div>
                
                {{-- Inner Circle --}}
                <div class="absolute inset-[3px] rounded-full bg-[#1b1c20] flex items-center justify-center flex-col">
                    <span class="text-white text-[22px] font-bold tracking-tight" x-text="isRecording ? 'Stop Recording' : 'Start Recording'"></span>
                    <span x-show="isRecording" x-cloak class="text-magenta font-mono text-[24px] mt-2 font-bold" x-text="formatTime(timer)"></span>
                </div>
            </button>
        </div>

        {{-- Waveform Animation --}}
        <div class="absolute bottom-0 left-0 right-0 px-10 flex items-end justify-center gap-[4px] h-32 overflow-hidden pointer-events-none">
            @for($i = 0; $i < 100; $i++)
                @php $h = rand(10, 80); @endphp
                <div 
                    class="w-[4px] bg-[#4D61FF] rounded-full transition-all duration-300" 
                    :class="isRecording ? 'animate-waveform' : 'opacity-40'"
                    style="height: {{$h}}%; animation-delay: {{$i * 50}}ms"
                ></div>
            @endfor
        </div>
    </div>
</div>

<style>
    @keyframes spin-slow {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    .animate-spin-slow {
        animation: spin-slow 8s linear infinite;
    }
    
    @keyframes waveform {
        0%, 100% { height: 10%; }
        50% { height: 90%; }
    }
    .animate-waveform {
        animation: waveform 1.2s ease-in-out infinite;
    }

    [x-cloak] { display: none !important; }
</style>

@endsection