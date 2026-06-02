@extends('layouts.app')

@section('content')

    {{-- Header with Back Button --}}
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ url()->previous() }}" class="text-accent hover:text-accent/80">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </a>
        <h1 class="text-2xl font-bold text-accent">List on QmeMarketplace</h1>
    </div>

    <div class="max-w-2xl mx-auto">
        <div class="bg-[#252525] rounded-3xl p-10 shadow-2xl text-center space-y-10">
            {{-- Progress Graphic --}}
            <div class="flex justify-center items-center gap-4">
                <div
                    class="w-16 h-16 rounded-2xl bg-accent/20 flex items-center justify-center text-accent text-2xl font-bold">
                    1</div>
                <div class="w-12 h-0.5 bg-accent/20"></div>
                <div
                    class="w-16 h-16 rounded-2xl bg-accent flex items-center justify-center text-white text-2xl font-bold shadow-lg shadow-accent/20">
                    2</div>
                <div class="w-12 h-0.5 bg-gray-700"></div>
                <div
                    class="w-16 h-16 rounded-2xl bg-gray-800 flex items-center justify-center text-gray-500 text-2xl font-bold">
                    3</div>
            </div>

            <div>
                <h2 class="text-2xl font-black mb-4">You're almost there!</h2>
                <p class="text-gray-400 text-sm leading-relaxed max-w-sm mx-auto">
                    Please review your listing details one last time. Once published, your track will be visible to
                    thousands of potential investors and buyers.
                </p>
            </div>

            {{-- Summary Card --}}
            <div class="bg-[#1A1A1A] rounded-2xl p-6 text-left border border-gray-700">
                <div class="flex items-center gap-4 mb-6 pb-6 border-b border-gray-700">
                    <img src="https://picsum.photos/80/80" class="w-16 h-16 rounded-xl">
                    <div>
                        <h4 class="font-bold text-lg">Reflection</h4>
                        <p class="text-xs text-accent">By Luna Beats</p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-y-4">
                    <div>
                        <span class="text-[10px] text-gray-500 uppercase block">License Price</span>
                        <span class="text-sm font-bold">$29.00</span>
                    </div>
                    <div>
                        <span class="text-[10px] text-gray-500 uppercase block">Investment</span>
                        <span class="text-sm font-bold">10% Available</span>
                    </div>
                    <div>
                        <span class="text-[10px] text-gray-500 uppercase block">Category</span>
                        <span class="text-sm font-bold">Pop R&B</span>
                    </div>
                    <div>
                        <span class="text-[10px] text-gray-500 uppercase block">Visibility</span>
                        <span class="text-sm font-bold text-green-400">Public</span>
                    </div>
                </div>
            </div>

            <div class="space-y-4">
                <button
                    class="w-full py-5 rounded-2xl bg-accent text-white font-bold text-lg hover:shadow-[0_0_25px_rgba(255,0,255,0.4)] transition">
                    Publish Listing
                </button>
                <button class="w-full py-3 text-sm text-gray-500 hover:text-white transition">
                    Save as draft and exit
                </button>
            </div>
        </div>
    </div>

@endsection