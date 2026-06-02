@extends('layouts.app')

<style>
    .wave-bar {
        width: 3px;
        background: rgba(139, 92, 246, 0.25);
        border-radius: 2px;
        transition: height 0.1s ease, background-color 0.1s ease;
        pointer-events: none;
        min-height: 4px;
    }

    .wave-bar.active {
        background: linear-gradient(to top, #8B5CF6, #22D3EE);
    }

    .progress-slider {
        appearance: none;
        width: 100%;
        height: 4px;
        background: rgba(139, 92, 246, 0.2);
        border-radius: 2px;
        cursor: pointer;
        outline: none;
    }

    .progress-slider::-webkit-slider-thumb {
        appearance: none;
        width: 12px;
        height: 12px;
        background: #8B5CF6;
        border-radius: 50%;
        cursor: pointer;
        box-shadow: 0 0 8px rgba(139, 92, 246, 0.5);
    }

    .progress-slider::-moz-range-thumb {
        width: 12px;
        height: 12px;
        background: #8B5CF6;
        border-radius: 50%;
        cursor: pointer;
        border: none;
        box-shadow: 0 0 8px rgba(139, 92, 246, 0.5);
    }

    .progress-slider::-moz-range-track {
        background: none;
        border: none;
    }

    .volume-slider {
        appearance: none;
        width: 100px;
        height: 4px;
        background: rgba(139, 92, 246, 0.2);
        border-radius: 2px;
        cursor: pointer;
        outline: none;
    }

    .volume-slider::-webkit-slider-thumb {
        appearance: none;
        width: 10px;
        height: 10px;
        background: #8B5CF6;
        border-radius: 50%;
        cursor: pointer;
    }

    .volume-slider::-moz-range-thumb {
        width: 10px;
        height: 10px;
        background: #8B5CF6;
        border-radius: 50%;
        cursor: pointer;
        border: none;
    }

    .control-btn {
        transition: all 0.2s ease;
    }

    .control-btn:hover {
        transform: scale(1.05);
    }

    .control-btn:active {
        transform: scale(0.95);
    }
</style>

@section('content')

    {{-- Header with Back Button --}}
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('consumer.my.tracks') }}" class="text-indigo-500 hover:text-indigo-400">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <h1 class="text-3xl font-black text-indigo-500">View Track Details</h1>
    </div>

    <div class="max-w-4xl">
        <!-- ========== Creator Section ========== -->
        <section class="flex items-center gap-5 mb-10">
            <div class="w-16 h-16 rounded-full overflow-hidden border-2 border-magenta/20">
                <img src="{{ $track->user->profile_image ? asset('storage/' . $track->user->profile_image) : 'https://i.pravatar.cc/100?u=' . $track->user->id }}" alt="Creator Avatar" class="w-full h-full object-cover">
            </div>
            <div>
                <h2 class="text-2xl font-black text-white">{{ $track->user->username }}</h2>
                <p class="text-xs font-bold text-gray-500 uppercase tracking-widest">Creator Account</p>
            </div>
        </section>

        <!-- ================= Audio Player ================= -->
        <div class="mb-12">
            <x-audio :link="$track->file ? asset('storage/' . $track->file) : asset('images/audio.mp3')" />
        </div>

        <!-- ========== Description Section ========== -->
        <section class="mb-12 space-y-4">
            <h3 class="text-2xl font-black text-white">Description</h3>
            <p class="text-gray-400 text-sm leading-relaxed max-w-2xl">
                {{ $track->description ?? $track->overview ?? 'No description available for this track.' }}
            </p>
        </section>

        <!-- ========== Metadata Section ========== -->
        @php $asset = $track->marketplaceAssets->where('sale_type', 'investment')->first(); @endphp
        <section class="grid grid-cols-3 gap-12 mb-16 max-w-2xl">
            <div class="space-y-1">
                <h4 class="text-sm font-bold text-white">Total blocks</h4>
                <p class="text-xs text-gray-500">{{ $asset->total_blocks ?? 100 }}</p>
            </div>
            <div class="space-y-1">
                <h4 class="text-sm font-bold text-white">Remaining Blocks</h4>
                <p class="text-xs text-gray-500">{{ ($asset->total_blocks ?? 100) - ($asset->sold_blocks ?? 0) }}</p>
            </div>
            <div class="space-y-1">
                <h4 class="text-sm font-bold text-white">Price per block</h4>
                <p class="text-xs text-gray-500">${{ number_format($asset->price ?? 0, 2) }}</p>
            </div>
        </section>

        <!-- Buttons -->
        <div class="space-y-4 max-w-2xl">
            <button
                class="w-full bg-indigo-600 hover:brightness-110 text-white font-black py-5 rounded-2xl transition shadow-lg shadow-indigo-900/20">
                Download Track
            </button>
            <a href="{{ route('consumer.my.tracks.agreements', $track->id) }}"
                class="block w-full text-center border-2 border-gray-800 hover:border-gray-600 text-white font-black py-5 rounded-2xl transition">
                View agreement
            </a>
        </div>
    </div>

@endsection
