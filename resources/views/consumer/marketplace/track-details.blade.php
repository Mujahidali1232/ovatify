@extends('layouts.app')

@section('content')

    {{-- Header with Back Button --}}
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ url()->previous() }}" class="text-accent hover:text-accent/80">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </a>
        <h1 class="text-2xl font-bold text-accent">Track Details</h1>
    </div>

    {{-- Audio Player Section --}}
    <div class="p-8 rounded-2xl bg-[#252525] mb-8 relative overflow-hidden">
        {{-- Background Decoration --}}
        <div class="absolute top-0 right-0 w-64 h-64 bg-accent/10 rounded-full blur-3xl -mr-32 -mt-32"></div>

        <div class="relative z-10">
            <div class="flex items-center gap-8 mb-10">
                <div class="w-40 h-40 rounded-2xl overflow-hidden shadow-2xl relative group">
                    <img src="https://picsum.photos/400/400?random=2" class="w-full h-full object-cover">
                    <div
                        class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                        <button class="w-12 h-12 rounded-full bg-accent text-white flex items-center justify-center">
                            <svg class="w-6 h-6 ml-1" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M8 5v14l11-7z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div>
                    <h2 class="text-3xl font-bold mb-2">Summer Melodies</h2>
                    <div class="flex items-center gap-3 mb-6">
                        <img src="https://i.pravatar.cc/32?img=12" class="w-8 h-8 rounded-full border border-accent">
                        <span class="text-lg font-medium">Luna Beats</span>
                    </div>
                    <div class="flex gap-4">
                        <span
                            class="px-3 py-1 rounded-full bg-gray-800 text-[10px] uppercase font-bold text-gray-400">Pop</span>
                        <span class="px-3 py-1 rounded-full bg-gray-800 text-[10px] uppercase font-bold text-gray-400">120
                            BPM</span>
                        <span class="px-3 py-1 rounded-full bg-gray-800 text-[10px] uppercase font-bold text-gray-400">D
                            Minor</span>
                    </div>
                </div>
            </div>

            {{-- Progress Slider --}}
            <div class="space-y-2 mb-4">
                <div class="relative h-2 bg-gray-800 rounded-full">
                    <div class="absolute top-0 left-0 h-full bg-accent rounded-full" style="width: 45%"></div>
                    <div
                        class="absolute top-1/2 -translate-y-1/2 left-[45%] w-4 h-4 rounded-full bg-white shadow-lg border-2 border-accent">
                    </div>
                </div>
                <div class="flex justify-between text-[10px] text-gray-500 font-mono">
                    <span>01:12</span>
                    <span>02:45</span>
                </div>
            </div>

            {{-- Controls --}}
            <div class="flex items-center justify-center gap-8">
                <button class="text-gray-400 hover:text-white transition"><i class="fas fa-random"></i></button>
                <button class="text-gray-400 hover:text-white transition"><i
                        class="fas fa-step-backward text-xl"></i></button>
                <button
                    class="w-16 h-16 rounded-full bg-accent text-white flex items-center justify-center hover:scale-105 transition shadow-lg shadow-accent/20">
                    <i class="fas fa-pause text-2xl"></i>
                </button>
                <button class="text-gray-400 hover:text-white transition"><i
                        class="fas fa-step-forward text-xl"></i></button>
                <button class="text-gray-400 hover:text-white transition"><i class="fas fa-redo"></i></button>
            </div>
        </div>
    </div>

    {{-- Purchase/Invest Options --}}
    <div class="grid grid-cols-2 gap-6">
        {{-- Marketplace License --}}
        <div class="p-6 rounded-2xl bg-[#252525] border border-gray-700 hover:border-accent/40 transition">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h3 class="font-bold text-lg">Purchase License</h3>
                    <p class="text-xs text-gray-500">Get 100% royalty free license</p>
                </div>
                <span class="text-2xl font-bold text-accent">$29</span>
            </div>
            <button class="w-full py-4 rounded-xl bg-accent text-white font-bold text-sm hover:opacity-90 transition">
                Add to cart
            </button>
        </div>

        {{-- Invest Option --}}
        <div class="p-6 rounded-2xl bg-[#252525] border border-gray-700 hover:border-purple-400/40 transition">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h3 class="font-bold text-lg">Invest in royalties</h3>
                    <p class="text-xs text-gray-500">Own share of streaming royalties</p>
                </div>
                <span class="text-2xl font-bold text-purple-400">10% Available</span>
            </div>
            <button class="w-full py-4 rounded-xl bg-purple-500 text-white font-bold text-sm hover:opacity-90 transition">
                Invest Now
            </button>
        </div>
    </div>

@endsection