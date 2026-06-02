@extends('layouts.app')

@section('content')

@php 
    $asset = $track->marketplaceAssets->first();
    $valuation = $asset->total_valuation ?? 10000;
    $totalBlocks = $asset->ownership_blocks ?? 100;
    $remainingBlocks = $asset->remaining_blocks ?? 50;
    $soldBlocks = $totalBlocks - $remainingBlocks;
    $percentSold = $totalBlocks > 0 ? round(($soldBlocks / $totalBlocks) * 100) : 5;
    $pricePerBlock = $asset->price_per_block ?? 50;
@endphp

<div class="max-w-[1000px] mx-auto pb-20">
    {{-- Header --}}
    <div class="flex items-center gap-4 mb-12">
        <a href="{{ url()->previous() }}" class="text-[#4D61FF] hover:text-white transition-colors duration-200">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
        </a>
        <h1 class="text-[32px] font-bold text-[#4D61FF] tracking-tight">Invest in this Track</h1>
    </div>

    {{-- Artist & Main Info --}}
    <div class="flex flex-col lg:flex-row gap-10 mb-12">
        <div class="flex-1">
            {{-- Author Info --}}
            <div class="flex items-center gap-6 mb-10">
                <div class="relative">
                    <img src="{{ $track->user->profile_image ? asset('storage/' . $track->user->profile_image) : 'https://i.pravatar.cc/100?u=' . $track->user->id }}" alt="Avatar" class="w-20 h-20 rounded-full object-cover border-2 border-white/10 p-1">
                    <div class="absolute bottom-0 right-0 w-6 h-6 bg-magenta rounded-full border-2 border-[#1A1A1A] flex items-center justify-center">
                        <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                    </div>
                </div>
                <div>
                    <h2 class="text-[24px] font-bold text-white tracking-tight">{{ $track->user->username ?? 'John Smith' }}</h2>
                    <p class="text-[15px] text-gray-400 font-medium">{{ $track->user->role ?? 'POP Music Expert' }}</p>
                </div>
            </div>

            {{-- Audio Wave Card --}}
            <div class="relative w-full h-[160px] rounded-[24px] overflow-hidden mb-10 bg-gradient-to-br from-[#1b1c20] to-[#121214] border border-white/5 shadow-2xl group flex items-center px-8">
                <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-10"></div>
                
                {{-- Play Button --}}
                <button class="relative z-10 w-16 h-16 rounded-full bg-magenta flex items-center justify-center shadow-[0_0_25px_rgba(255,0,255,0.4)] transition-transform group-hover:scale-105">
                    <svg class="w-7 h-7 text-white ml-1" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z" /></svg>
                </button>

                {{-- Waveform --}}
                <div class="flex-1 px-8 flex items-center gap-[4px] h-14">
                    @foreach([40,20,60,30,50,80,40,90,100,70,80,50,40,60,30,50,80,40,90,100,70,80,50,40,60,30,50,80,40,90] as $h)
                        <div class="w-[3px] rounded-full {{ $loop->index < 12 ? 'bg-magenta' : 'bg-white/20' }}" style="height: {{ $h }}%;"></div>
                    @endforeach
                </div>

                <span class="text-white text-[20px] font-bold tracking-wider">02:00</span>
            </div>
        </div>

        {{-- Summary Stats --}}
        <div class="w-full lg:w-[320px] bg-[#1b1c20] border border-white/10 rounded-[24px] p-8 flex flex-col justify-center shadow-xl">
            <div class="space-y-6">
                <div class="flex justify-between items-center text-white">
                    <span class="text-gray-400 font-medium">Valuation</span>
                    <span class="text-[18px] font-bold">${{ number_format($valuation) }}</span>
                </div>
                <div class="flex justify-between items-center text-white">
                    <span class="text-gray-400 font-medium">Available</span>
                    <span class="text-[18px] font-bold">{{ $percentSold }}%</span>
                </div>
                <div class="flex justify-between items-center text-white">
                    <span class="text-gray-400 font-medium">Price</span>
                    <span class="text-[18px] font-bold text-magenta">$000</span>
                </div>
                <div class="flex justify-between items-center text-white">
                    <span class="text-gray-400 font-medium">ROI</span>
                    <span class="text-[18px] font-bold">Lorem ipsum</span>
                </div>
            </div>
            
            <div class="mt-8 pt-6 border-t border-white/5">
                <div class="w-full bg-white/5 h-2 rounded-full overflow-hidden">
                    <div class="bg-magenta h-full" style="width: {{ $percentSold }}%"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Smart Contract Terms --}}
    <div class="bg-[#1b1c20]/50 border border-white/5 rounded-[24px] p-10 mb-10">
        <h3 class="text-[20px] font-bold text-white mb-6 tracking-tight">Smart Contract Terms</h3>
        <ul class="space-y-4">
            <li class="flex items-center gap-4 text-gray-300">
                <div class="w-1.5 h-1.5 rounded-full bg-magenta"></div>
                <span class="text-[16px]">Ownership is permanent and non-revocable.</span>
            </li>
            <li class="flex items-center gap-4 text-gray-300">
                <div class="w-1.5 h-1.5 rounded-full bg-magenta"></div>
                <span class="text-[16px]">Royalties are paid monthly to your wallet.</span>
            </li>
            <li class="flex items-center gap-4 text-gray-300">
                <div class="w-1.5 h-1.5 rounded-full bg-magenta"></div>
                <span class="text-[16px]">Enforced via Ethereum-based smart contract.</span>
            </li>
        </ul>
    </div>

    {{-- Wallet Footer --}}
    <div class="flex justify-between items-center px-6 py-6 border border-white/5 rounded-[18px] bg-[#111111]/30">
        <div class="flex items-center gap-4">
            <h4 class="text-gray-400 font-medium">Connected Wallet</h4>
            <span class="text-white font-bold tracking-wider">0x71C...492</span>
        </div>
        <a href="{{ route('consumer.wallet.connect') }}" class="text-[#4D61FF] font-bold hover:text-white transition-colors">Change</a>
    </div>

    {{-- Trigger Modal for demo --}}
    <div class="mt-12 text-center">
        <button @click="$dispatch('open-success-modal', { type: 'investment' })" class="px-12 py-4 rounded-full bg-magenta text-white font-bold text-[17px] hover:shadow-[0_0_25px_rgba(255,0,255,0.4)] transition-all active:scale-95 uppercase tracking-wide">
            Finalize Investment
        </button>
    </div>
</div>

@endsection