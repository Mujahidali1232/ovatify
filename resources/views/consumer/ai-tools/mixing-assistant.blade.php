@extends('layouts.app')

@section('content')

    {{-- Header with Back Button --}}
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ url()->previous() }}" class="text-accent hover:text-accent/80">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </a>
        <h1 class="text-2xl font-bold text-accent">AI Mixing Assistant</h1>
    </div>

    {{-- Track Info --}}
    <div class="mb-6">
        <h2 class="text-lg font-semibold">Lorem Ipsum</h2>
        <p class="text-sm text-gray-400">beat.wav - 120 BPM - 2.3 MB</p>
    </div>

    {{-- Audio Player --}}
    <div class="p-6 rounded-xl bg-[#252525] mb-6">
        <div class="flex items-center gap-4">
            {{-- Play Button --}}
            <button
                class="flex h-12 w-12 items-center justify-center rounded-full bg-accent/20 hover:bg-accent/30 transition">
                <svg class="w-6 h-6 text-accent ml-1" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M8 5v14l11-7z" />
                </svg>
            </button>

            {{-- Waveform --}}
            <div class="flex-1 flex items-center justify-center gap-0.5 h-12">
                @foreach([20, 35, 25, 45, 20, 32, 40, 28, 38, 20, 30, 42, 25, 35, 28, 40, 22, 34, 38, 20, 35, 25, 45, 20, 32, 40, 28, 38, 20, 30, 42, 25, 35, 28, 40, 22, 34, 38, 20, 35, 25, 45, 20, 32, 40, 28, 38, 20, 30] as $h)
                    <div class="w-1 rounded-full bg-[#4155B1]" style="height: {{ $h }}px;"></div>
                @endforeach
            </div>

            {{-- Duration --}}
            <span class="text-sm text-gray-400">02:00</span>
        </div>
    </div>

    {{-- Analyzing Progress --}}
    <div class="p-6 rounded-xl bg-[#252525]">
        <p class="text-sm text-gray-300 mb-3">Analyzing Your Track...</p>
        <div class="w-full h-2 bg-gray-700 rounded-full overflow-hidden">
            <div class="h-full bg-gradient-to-r from-[#4D61FF] to-accent animate-progress rounded-full"></div>
        </div>
    </div>

@endsection