@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto mb-20 px-4">
    {{-- Header --}}
    <div class="flex items-center gap-4 mb-12">
        <a href="{{ url()->previous() }}" class="text-[#5c67ff] hover:text-[#4b55e6] transition bg-transparent outline-none flex items-center group">
            <svg class="w-8 h-8 mr-3 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            <h1 class="text-[36px] font-bold tracking-tight text-[#5c67ff]">View recommendations</h1>
        </a>
    </div>

    {{-- Grid Content --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-x-6 gap-y-12">
        @foreach(range(1, 12) as $i)
            <div class="group cursor-pointer">
                {{-- Image Container --}}
                <div class="relative aspect-square rounded-[24px] overflow-hidden mb-5 border border-white/5 shadow-2xl group-hover:border-[#5c67ff]/30 transition-all duration-500">
                    <img src="https://picsum.photos/600/600?random={{ $i + 150 }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                    
                    {{-- Hover Overlay --}}
                    <div class="absolute inset-0 bg-[#5c67ff]/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                </div>

                {{-- Item Details --}}
                <div class="flex justify-between items-start px-1">
                    <div>
                        <h4 class="text-white font-bold text-[17px] leading-tight mb-2 group-hover:text-[#5c67ff] transition-colors">Lorem Ipsum</h4>
                        <div class="space-y-1">
                            <p class="text-gray-500 text-[11px] uppercase font-black tracking-wider">1000 X 1000</p>
                            <p class="text-gray-500 text-[11px] uppercase font-black tracking-wider">Standard License</p>
                        </div>
                    </div>
                    <div class="text-white font-bold text-[18px]">
                        $20
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

@endsection
