@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto mb-20 px-4" x-data="{ selectedBlock: 1 }">
    {{-- Header --}}
    <div class="flex items-center gap-4 mb-10">
        <a href="{{ url()->previous() }}" class="text-[#5c67ff] hover:text-[#4b55e6] transition bg-transparent outline-none flex items-center group">
            <svg class="w-7 h-7 mr-3 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            <h1 class="text-[32px] font-bold tracking-tight text-[#5c67ff]">Invest in product</h1>
        </a>
    </div>

    <div class="space-y-8">
        {{-- Order Summary Card --}}
        <div class="bg-[#1b1b1f] border border-white/5 rounded-[32px] p-8">
            <h2 class="text-[22px] font-bold text-white mb-6">Order summary</h2>
            <div class="flex flex-col md:flex-row items-center gap-6">
                <div class="w-[full] md:w-[140px] aspect-square rounded-[16px] overflow-hidden border border-white/5 shadow-lg">
                    <img src="https://picsum.photos/400/400?random=image-invest" class="w-full h-full object-cover">
                </div>
                <div class="flex-1">
                    <h3 class="text-white text-[20px] font-bold mb-3">Title of the image</h3>
                    <div class="flex items-center gap-2 mb-6">
                        <img src="https://i.pravatar.cc/32?u=artist" class="w-6 h-6 rounded-full border border-white/10">
                        <span class="text-white font-bold text-[13px]">Johna Smith</span>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-5 gap-4 opacity-70">
                        <div>
                            <p class="text-gray-500 text-[8px] uppercase font-bold mb-1">Resolution</p>
                            <p class="text-white font-bold text-[11px]">1600x1600</p>
                        </div>
                        <div>
                            <p class="text-gray-500 text-[8px] uppercase font-bold mb-1">Format & Size</p>
                            <p class="text-white font-bold text-[11px]">PNG - 10 MB</p>
                        </div>
                        <div>
                            <p class="text-gray-500 text-[8px] uppercase font-bold mb-1">Upload date</p>
                            <p class="text-white font-bold text-[11px]">Nov 8, 2025</p>
                        </div>
                        <div>
                            <p class="text-gray-500 text-[8px] uppercase font-bold mb-1">Type</p>
                            <p class="text-white font-bold text-[11px]">Photo</p>
                        </div>
                        <div>
                            <p class="text-gray-500 text-[8px] uppercase font-bold mb-1">Orientation</p>
                            <p class="text-white font-bold text-[11px]">Square</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Investment Summary --}}
        <div class="bg-[#1b1b1f] border border-white/5 rounded-[32px] p-10">
            <h2 class="text-[24px] font-bold text-white mb-8">Investment Summary</h2>
            
            <div class="flex justify-between items-center mb-4">
                <span class="text-gray-400 font-bold text-[15px]">Track Valuation</span>
                <span class="text-white font-bold text-[18px]">$10,000</span>
            </div>

            {{-- Progress Bar --}}
            <div class="relative w-full h-1.5 bg-white/5 rounded-full mb-4">
                <div class="absolute top-0 left-0 h-full w-1/2 bg-[#5c67ff] rounded-full shadow-[0_0_10px_rgba(92,103,255,0.5)]"></div>
            </div>

            <div class="flex justify-between items-center text-[13px] font-bold uppercase tracking-wider">
                <span class="text-gray-400">50% Already Sold</span>
                <span class="text-white">50 out of 100 left</span>
            </div>
        </div>

        {{-- ROI Blocks Grid --}}
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-4">
            @foreach([10, 20, 30, 40, 40, 40, 40] as $percent)
                <button @click="selectedBlock = {{ $loop->index }}" 
                    :class="selectedBlock === {{ $loop->index }} ? 'border-[#5c67ff] bg-[#1b1b1f]/80 shadow-[0_4px_20px_rgba(92,103,255,0.1)]' : 'border-white/5 bg-[#1b1b1f]/50'"
                    class="p-4 rounded-[12px] border text-center transition-all duration-300 hover:border-[#5c67ff]/40">
                    <p class="text-white font-bold text-[13px] mb-2"><span class="text-[14px]">{{ $percent }}%</span> for</p>
                    <p class="text-white font-black text-[15px] mb-1">$000</p>
                    <p class="text-gray-500 text-[9px] uppercase font-bold">Est. ROI</p>
                </button>
            @endforeach
        </div>

        {{-- Smart Contact Summary (Mockup spelling) --}}
        <button class="w-full bg-[#1b1b1f] border border-white/5 rounded-[20px] p-8 flex justify-between items-center group hover:border-[#5c67ff]/30 transition-all">
            <span class="text-white font-bold text-[17px]">Smart contact summary</span>
            <svg class="w-6 h-6 text-[#5c67ff] transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
            </svg>
        </button>

        {{-- T&C --}}
        <p class="text-center text-gray-500 text-[14px]">
            By continuing, you agree to our <a href="#" class="text-[#5c67ff] font-bold hover:underline">Terms & Conditions</a>
        </p>

        {{-- Action Button --}}
        <a href="{{ route('consumer.marketplace.image.checkout') }}" class="block w-full bg-[#5c67ff] hover:bg-[#4b55e6] text-white text-center font-bold text-[18px] py-6 rounded-[14px] transition-all duration-300 shadow-2xl shadow-[#5c67ff]/20 active:scale-[0.98]">
            Proceed to checkout
        </a>
    </div>
</div>

@endsection
