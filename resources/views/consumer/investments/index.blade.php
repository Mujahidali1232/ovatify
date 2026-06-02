@extends('layouts.app')

@section('content')

    {{-- Header --}}
    <div class="mb-10">
        <h2 class="text-magenta text-5xl font-black mb-1">Explore</h2>
        <h1 class="text-6xl font-black text-white leading-tight">Your Investments</h1>
    </div>

    {{-- Category Filters --}}
    <div class="flex gap-3 mb-10 flex-wrap">
        @foreach(['Beats', 'Vocals', 'Loops', 'Bundles', 'Bundles', 'Bundles', 'Bundles'] as $item)
            <button
                class="px-6 py-2.5 rounded-full text-xs font-bold transition
                {{ $loop->first ? 'category-pill-blue shadow-lg shadow-blue-900/20' : 'bg-[#252525] border border-gray-700 text-gray-400 hover:border-magenta hover:text-magenta' }}">
                {{ $item }}
            </button>
        @endforeach
    </div>

    {{-- Investment Summary --}}
    <div class="flex justify-between items-end mb-12">
        <div>
            <p class="text-[11px] font-bold text-gray-500 uppercase tracking-widest mb-1">Total Investment value</p>
            <p class="text-4xl font-black text-white">${{ number_format($totalInvested, 2) }}</p>
        </div>
        <div class="text-right">
            <p class="text-[11px] font-bold text-gray-500 uppercase tracking-widest mb-1">Total Earnings</p>
            <p class="text-4xl font-black text-white">${{ number_format($totalEarned, 2) }}</p>
        </div>
    </div>

    {{-- Section Title --}}
    <h3 class="text-2xl font-black text-white mb-6">Investments</h3>

    {{-- Investment Cards --}}
    <div class="space-y-6">
        @foreach($investments as $investment)
            @php 
                $track = $investment->asset->songGeneration; 
                // Calculate ownership percentage based on blocks
                $totalBlocks = $investment->asset->total_blocks ?? 100;
                $ownership = ($investment->blocks_purchased / $totalBlocks) * 100;
            @endphp
            <a href="{{ route('consumer.investments.track.details', $investment->id) }}" class="block p-8 rounded-[2rem] bg-[#252525] border border-indigo-500/30 group hover:border-indigo-500 transition-all duration-300">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h4 class="text-xl font-bold text-white mb-1">{{ $track->title }} - By {{ $track->user->username }}</h4>
                        <p class="text-[11px] font-bold text-gray-500">{{ $track->title }} - By {{ $track->user->username }}</p>
                    </div>
                </div>

                <div class="flex justify-between items-end">
                    <div class="space-y-1">
                        <p class="text-sm font-bold text-white">Smart Contract</p>
                        <p class="text-[11px] font-black text-magenta">ROI: 50%+</p>
                    </div>
                    <div class="text-right space-y-1">
                        <p class="text-[11px] font-black text-magenta">{{ sprintf('%02d', $ownership) }}% Ownership</p>
                        <p class="text-[11px] font-bold text-gray-500 uppercase tracking-tight">Total Invest: <span class="text-magenta">${{ number_format($investment->investment_amount) }}</span></p>
                    </div>
                </div>
            </a>
        @endforeach
        @if($investments->isEmpty())
             <div class="py-20 text-center text-gray-500 bg-[#252525] rounded-3xl border border-gray-800/50">
                 <p class="text-xl font-bold mb-2">No investments in your portfolio yet</p>
                 <a href="{{ route('consumer.dashboard.index') }}" class="text-magenta hover:underline">Start Investing</a>
             </div>
        @endif
    </div>
    </div>

@endsection