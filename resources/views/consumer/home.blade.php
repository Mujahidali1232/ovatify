@extends('layouts.app')

@section('content')

    {{-- Header --}}
    <div class="flex justify-between items-start mb-10">
        <div>
            <h2 class="text-magenta text-5xl font-black mb-1">Hey!</h2>
            <h1 class="text-6xl font-black text-white leading-tight">Explore content</h1>
        </div>

        <a href="{{ route('consumer.creator.dashboard') }}"
            class="text-magenta text-sm font-black uppercase tracking-widest hover:brightness-110 transition-all mt-4">
            Become a creator
        </a>
    </div>

    {{-- Search --}}
    <div class="mb-10">
        <div class="relative max-w-2xl group">
            <div class="absolute left-6 top-1/2 -translate-y-1/2 flex items-center justify-center pointer-events-none z-20">
                <svg class="w-5 h-5 text-magenta group-focus-within:text-magenta transition-colors" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input type="text" placeholder="Search song"
                class="w-full bg-[#1A1A1A] border border-gray-800/50 rounded-xl pr-6 py-3.5 text-sm text-white placeholder:text-gray-600 focus:outline-none focus:ring-1 focus:ring-magenta/20 focus:border-magenta/40 transition-all shadow-2xl"
                style="padding-left: 70px !important;">
        </div>
    </div>

    {{-- Category Filters --}}
    <div class="flex gap-3 mb-10 flex-wrap overflow-x-auto pb-2 scrollbar-none" x-data="{ activeCategory: 'Beats' }">
        @foreach(['Beats', 'Vocals', 'Loops', 'Bundles', 'Presets', 'Samples'] as $item)
            <button
                @click="activeCategory = '{{ $item }}'"
                :class="activeCategory === '{{ $item }}' ? 'category-pill-magenta shadow-lg shadow-magenta/20 scale-105' : 'bg-[#252525] border border-gray-700 text-gray-400 hover:border-magenta hover:text-magenta'"
                class="px-8 py-3 rounded-full text-xs font-bold transition-all duration-300 active:scale-95 whitespace-nowrap">
                {{ $item }}
            </button>
        @endforeach

        <div class="w-full mt-12">
            {{-- Beats Content (Featured Drops) --}}
            <div x-show="activeCategory === 'Beats'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                <h3 class="text-xl font-black mb-8">Featured Drops</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-16">
                    @foreach($featuredDrops as $track)
                        <a href="{{ route('consumer.dashboard.track.details', $track->id) }}" class="rounded-2xl overflow-hidden group/card block border border-white/5 hover:border-magenta/20 transition-all shadow-2xl"
                            style="background: linear-gradient(135deg, rgba(30, 20, 50, 0.9) 0%, rgba(20, 10, 40, 0.95) 100%);">
                            <div class="relative h-48 p-4 flex flex-col justify-between track-card-bg group">
                                <div class="flex justify-center flex-1 items-center">
                                    <div class="h-14 w-14 flex items-center justify-center rounded-full bg-magenta/20 border border-magenta/40 backdrop-blur-md group-hover/card:scale-110 transition-all duration-500 shadow-[0_0_20px_rgba(255,0,255,0.3)]">
                                        <svg class="w-7 h-7 text-white ml-0.5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z" /></svg>
                                    </div>
                                </div>
                                <div class="flex items-end justify-center gap-0.5 h-10">
                                    @foreach([30, 45, 35, 55, 30, 42, 50, 38, 48, 30, 40, 52, 35, 45, 38, 50, 32, 44, 48, 30] as $h)
                                        <div class="w-1 rounded-full bg-magenta/60 group-hover/card:bg-magenta transition-colors" style="height: {{ $h / 2 }}px;"></div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="p-5 bg-[#1F1F1F]">
                                <div class="flex justify-between items-start mb-3">
                                    <div>
                                        <h4 class="font-bold text-white text-[15px] mb-1">{{ $track->title }}</h4>
                                        <p class="text-[11px] text-gray-500 font-medium uppercase tracking-widest">{{ $track->overview ?? 'Acoustic | Warm' }}</p>
                                    </div>
                                    <span class="text-[15px] font-black text-magenta">${{ $track->marketplaceAssets->first()->price ?? '19' }}</span>
                                </div>
                                <div class="flex items-center gap-3 pt-3 border-t border-white/5">
                                    <img src="{{ $track->user->profile_image ? asset('storage/' . $track->user->profile_image) : 'https://ui-avatars.com/api/?name='.urlencode($track->user->username).'&background=FF00FF&color=fff' }}" alt="Artist" class="w-6 h-6 rounded-full border border-white/10">
                                    <span class="text-xs text-gray-400 font-semibold">{{ $track->user->username }}</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                    @if($featuredDrops->isEmpty())
                        <div class="col-span-full py-20 text-center text-gray-500 bg-[#16161C] border border-dashed border-white/5 rounded-2xl">
                            <i class="fa-solid fa-music text-4xl mb-4 opacity-20"></i>
                            <p class="font-bold">No beats discovered yet.</p>
                        </div>
                    @endif
                </div>

                <h3 class="text-xl font-black mb-8">Invest in music</h3>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    @foreach($investmentAssets as $track)
                        @php $asset = $track->marketplaceAssets->where('sale_type', 'investment')->first(); @endphp
                        <a href="{{ route('consumer.dashboard.invest.track', $track->id) }}"
                            class="rounded-3xl overflow-hidden flex bg-[#1A1B23] border border-white/5 hover:border-magenta/20 transition-all duration-500 group block shadow-3xl">
                            <div class="w-48 h-48 flex-shrink-0 relative track-card-bg">
                                <div class="absolute inset-0 bg-black/20 group-hover:bg-transparent transition-colors"></div>
                                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 flex h-12 w-12 items-center justify-center rounded-full bg-magenta border border-white/20 shadow-[0_0_30px_rgba(255,0,255,0.4)] group-hover:scale-110 transition-all duration-500 z-10">
                                    <svg class="w-6 h-6 text-white ml-0.5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z" /></svg>
                                </div>
                            </div>
                            <div class="flex-1 p-8 flex flex-col justify-center">
                                <div class="flex justify-between items-start mb-2">
                                    <h4 class="text-2xl font-black text-white leading-tight">{{ $track->title }}</h4>
                                    <span class="text-[12px] font-black bg-[#22C55E]/10 text-[#22C55E] border border-[#22C55E]/20 px-4 py-1.5 rounded-full uppercase tracking-tighter shadow-lg">ROI {{ $asset->roi ?? '12%' }}</span>
                                </div>
                                <p class="text-[12px] text-gray-500 font-bold mb-6 uppercase tracking-widest">
                                    {{ $asset->total_blocks ?? 100 }} Blocks Total | <span class="text-magenta">{{ ($asset->total_blocks ?? 100) - ($asset->blocks_sold ?? 0) }} Left</span>
                                </p>
                                <div class="flex items-center gap-4">
                                    <div class="flex -space-x-2">
                                        @foreach(range(1,3) as $i)
                                            <img src="https://i.pravatar.cc/32?u={{ $i + $track->id }}" class="w-8 h-8 rounded-full border-2 border-[#1A1B23]">
                                        @endforeach
                                    </div>
                                    <span class="text-xs text-gray-500 font-bold">+14 investors</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- Placeholder for other categories --}}
            <template x-if="activeCategory !== 'Beats'">
                <div class="py-24 text-center" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
                    <div class="w-32 h-32 bg-magenta/5 border border-magenta/10 rounded-full flex items-center justify-center mx-auto mb-8 shadow-[0_0_50px_rgba(255,0,255,0.05)]">
                        <i :class="{
                            'fa-solid fa-microphone': activeCategory === 'Vocals',
                            'fa-solid fa-rotate-right': activeCategory === 'Loops',
                            'fa-solid fa-box-open': activeCategory === 'Bundles',
                            'fa-solid fa-sliders': activeCategory === 'Presets',
                            'fa-solid fa-compact-disc': activeCategory === 'Samples',
                        }" class="text-4xl text-magenta/40"></i>
                    </div>
                    <h3 class="text-2xl font-black text-white mb-2" x-text="'Explore ' + activeCategory"></h3>
                    <p class="text-gray-500 font-medium">Coming soon to the marketplace. Stay tuned!</p>
                </div>
            </template>
        </div>
    </div>

@endsection