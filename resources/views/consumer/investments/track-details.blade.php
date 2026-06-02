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
        <a href="{{ route('consumer.investments.index') }}" class="text-indigo-500 hover:text-indigo-400">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <h1 class="text-3xl font-black text-indigo-500">View Track Details</h1>
    </div>

    @php 
        $track = $investment->asset->songGeneration; 
        $totalBlocks = $investment->asset->total_blocks ?? 100;
        $ownership = ($investment->blocks_purchased / $totalBlocks) * 100;
    @endphp

    <div class="max-w-4xl">
        <!-- ========== Creator Section ========== -->
        <section class="flex items-center gap-5 mb-10">
            <div class="w-16 h-16 rounded-full overflow-hidden border-2 border-magenta/20">
                <img src="{{ $track->user->profile_image ? asset('storage/' . $track->user->profile_image) : 'https://i.pravatar.cc/100?u=' . $track->user->id }}" alt="Creator" class="w-full h-full object-cover">
            </div>
            <div>
                <h2 class="text-2xl font-black text-white">{{ $track->user->username }}</h2>
                <p class="text-xs font-bold text-gray-500 uppercase tracking-widest">POP Music Expert</p>
            </div>
        </section>

        <!-- ================= Audio Player ================= -->
        <div class="mb-12">
            <x-audio :link="$track->file ? asset('storage/' . $track->file) : asset('images/audio.mp3')" />
        </div>

        <!-- ========== Investment Details Section ========== -->
        <section class="mb-12">
            <h3 class="text-2xl font-black text-white mb-8 border-b border-gray-800 pb-4">Investment Details</h3>
            
            <div class="space-y-6 max-w-xl">
                <div class="flex justify-between items-center bg-[#1A1A1A] p-1 rounded-lg">
                    <span class="text-gray-400 font-bold">Smart Contract ID</span>
                    <span class="text-gray-300 font-mono text-sm">#{{ str_pad($investment->id, 9, '0', STR_PAD_LEFT) }}</span>
                </div>

                <div class="flex justify-between items-center">
                    <span class="text-gray-400 font-bold">License Type</span>
                    <span class="text-gray-300">Personal</span>
                </div>

                <div class="flex justify-between items-center">
                    <span class="text-gray-400 font-bold">Date Licensed</span>
                    <span class="text-gray-300">{{ $investment->created_at->format('F d, Y') }}</span>
                </div>

                <div class="flex justify-between items-center">
                    <span class="text-gray-400 font-bold">Price Paid</span>
                    <span class="text-gray-300">${{ number_format($investment->investment_amount) }}</span>
                </div>

                <div class="flex justify-between items-center">
                    <span class="text-gray-400 font-bold">Ownership</span>
                    <span class="text-gray-300">{{ sprintf('%02d', $ownership) }}% of track revenue</span>
                </div>

                <div class="flex justify-between items-center">
                    <span class="text-gray-400 font-bold">Investment Status</span>
                    <span class="text-[#22C55E] font-black uppercase tracking-tighter">Active</span>
                </div>
            </div>
        </section>

        <!-- Licensing Section -->
        <section class="max-w-xl">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-black text-white">Licensing</h2>
                <div class="px-4 py-1.5 rounded-lg border-2 border-indigo-500/30 text-white font-black">
                    $19
                </div>
            </div>

            <!-- Document Card -->
            <div class="bg-[#1A1A1A] rounded-2xl p-6 flex justify-between items-center border border-gray-800/50">
                <div class="flex items-center gap-3 text-gray-300">
                    <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    <span class="font-bold">Standard Agreement.pdf</span>
                </div>
                <a href="{{ route('consumer.investments.artist.agreements', $track->id) }}" class="text-indigo-500 hover:text-indigo-400 transition font-black text-sm uppercase tracking-widest">
                    View
                </a>
            </div>
        </section>
    </div>

@endsection

