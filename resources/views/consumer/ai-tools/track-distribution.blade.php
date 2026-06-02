@extends('layouts.app')

@section('content')

    {{-- Header with Back Button --}}
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ url()->previous() }}" class="text-accent hover:text-accent/80">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </a>
        <h1 class="text-2xl font-bold text-accent">Track Distribution</h1>
    </div>

    {{-- Track Result Card --}}
    <div class="p-6 rounded-xl bg-[#252525] mb-8">
        <div class="flex items-center gap-6 mb-8">
            {{-- CD / Vinyl Style Representation --}}
            <div class="w-32 h-32 relative flex-shrink-0">
                <div
                    class="w-full h-full rounded-full border-4 border-gray-800 bg-gradient-to-br from-[#1A1A1A] to-[#333] flex items-center justify-center shadow-2xl relative overflow-hidden">
                    <div class="absolute inset-0 bg-accent bg-opacity-10 animate-pulse"></div>
                    <div class="w-8 h-8 rounded-full bg-white opacity-10"></div>
                    <img src="https://i.pravatar.cc/128?img=5"
                        class="absolute inset-0 w-full h-full object-cover opacity-30 mix-blend-overlay">
                </div>
                {{-- Album Cover Decoration --}}
                <div
                    class="absolute -bottom-2 -right-2 w-12 h-12 rounded bg-accent/20 flex items-center justify-center border border-accent/30 backdrop-blur-sm">
                    <svg class="w-6 h-6 text-accent" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M8 5v14l11-7z" />
                    </svg>
                </div>
            </div>

            <div>
                <h2 class="text-xl font-bold mb-1">Reflection</h2>
                <p class="text-sm text-gray-500 mb-4">Luna Beats · Pop · 02:45</p>

                <div class="flex gap-4">
                    {{-- Distribution Platforms --}}
                    <div
                        class="flex items-center gap-2 px-3 py-1.5 rounded-full bg-green-500/10 text-green-400 text-xs border border-green-500/20">
                        <i class="fab fa-spotify"></i>
                        Spotify
                    </div>
                    <div
                        class="flex items-center gap-2 px-3 py-1.5 rounded-full bg-red-500/10 text-red-400 text-xs border border-red-500/20">
                        <i class="fab fa-apple"></i>
                        Apple Music
                    </div>
                    <div
                        class="flex items-center gap-2 px-3 py-1.5 rounded-full bg-blue-500/10 text-blue-400 text-xs border border-blue-500/20">
                        <i class="fab fa-amazon"></i>
                        Amazon Music
                    </div>
                </div>
            </div>
        </div>

        {{-- Status Steps --}}
        <div class="space-y-4">
            <div class="flex items-center gap-3">
                <div class="w-5 h-5 rounded-full bg-green-500 flex items-center justify-center">
                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <span class="text-sm text-gray-300 font-medium">Metadata validation complete</span>
            </div>
            <div class="flex items-center gap-3">
                <div class="w-5 h-5 rounded-full bg-accent flex items-center justify-center animate-pulse">
                    <div class="w-1.5 h-1.5 rounded-full bg-white"></div>
                </div>
                <span class="text-sm text-white font-medium">Submitting to stores...</span>
            </div>
            <div class="flex items-center gap-3 opacity-40">
                <div class="w-5 h-5 rounded-full bg-gray-600 flex items-center justify-center"></div>
                <span class="text-sm text-gray-400">Review (estimated 48-72h)</span>
            </div>
        </div>
    </div>

    {{-- Confirmation Section --}}
    <div class="p-6 rounded-xl bg-accent/5 border border-accent/20 text-center">
        <h3 class="text-sm font-semibold mb-2">Track distributed successfully!</h3>
        <p class="text-xs text-gray-400 mb-6 max-w-sm mx-auto">Your track is now being processed and will be available on
            all major streaming platforms shortly.</p>

        <div class="flex gap-4">
            <button class="flex-1 py-3 rounded-lg bg-accent text-white text-sm font-medium hover:bg-accent/90 transition">
                View on QmeMarketplace
            </button>
            <button
                class="flex-1 py-3 rounded-lg bg-[#252525] border border-gray-600 text-white text-sm font-medium hover:bg-[#303030] transition">
                Home
            </button>
        </div>
    </div>

@endsection