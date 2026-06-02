@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mb-20 pr-4" x-data="{ showWalletSelect: false }">
    <div x-show="!showWalletSelect">
    {{-- Header --}}
    <div class="flex items-center gap-4 mb-10">
        <a href="{{ route('consumer.marketplace.index') }}" class="text-[#5c67ff] hover:text-[#4b55e6] transition bg-transparent outline-none flex items-center">
            <svg class="w-6 h-6 mr-3 border-b-2 border-transparent hover:border-[#4b55e6]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            <h1 class="text-[28px] font-medium tracking-wide">View Track Details</h1>
        </a>
    </div>

    {{-- Author Info --}}
    <div class="flex items-center gap-5 mb-10">
        <img src="{{ $track->user->profile_image ? asset('storage/' . $track->user->profile_image) : 'https://i.pravatar.cc/100?u=' . $track->user->id }}" alt="Avatar" class="w-16 h-16 rounded-full object-cover">
        <div>
            <h2 class="text-[20px] font-semibold text-white">{{ $track->user->username ?? 'John Smith' }}</h2>
            <p class="text-sm text-gray-400 mt-1">{{ $track->user->role ?? 'POP Music Expert' }}</p>
        </div>
    </div>

    {{-- Audio Player Card --}}
    <div class="relative w-full h-[120px] rounded-2xl overflow-hidden mb-12 bg-gradient-to-r from-[#210f36] to-[#0f1123]" style="border: 1px solid rgba(255,255,255,0.05);">
        {{-- Background wave --}}
        <div class="absolute inset-0 opacity-60 bg-cover bg-center mix-blend-screen" style="background-image: url('data:image/svg+xml,%3Csvg width=\'100%25\' height=\'100%25\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cpath d=\'M0 70 Q 250 20, 500 70 T 1000 70\' stroke=\'rgba(249, 0, 255, 0.5)\' fill=\'none\' stroke-width=\'3\'/%3E%3Cpath d=\'M0 90 Q 250 160, 500 90 T 1000 90\' stroke=\'rgba(92, 103, 255, 0.5)\' fill=\'none\' stroke-width=\'2\'/%3E%3C/svg%3E');"></div>
        
        <div class="absolute inset-0 flex items-center justify-between px-6 z-10 w-full">
            <div class="flex items-center gap-4 flex-1 pr-6">
                {{-- Play button --}}
                <button class="w-[52px] h-[52px] flex flex-shrink-0 items-center justify-center rounded-full bg-[#1b1029] shadow-[0_0_20px_rgba(249,0,255,0.15)] border border-white/5 hover:scale-105 transition">
                    <svg class="w-5 h-5 text-[#f900ff] ml-1" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M8 5v14l11-7z" />
                    </svg>
                </button>
                
                {{-- Simulated Waveform --}}
                <div class="flex flex-1 items-center justify-between gap-[3px] opacity-90 h-10 overflow-hidden px-2">
                    @foreach([30,15,40,25,35,45,20,50,60,30,80,60,100,70,80,90,50,45,75,40,55,30,80,60,40,80,60,40,50,45,75,40,55,30,15,40,25,35,40,60] as $h)
                        <div class="w-[3px] rounded-sm bg-gradient-to-t {{ $loop->index < 20 ? 'from-[#f900ff] to-[#5c67ff]' : 'from-[#5c67ff]/40 to-[#5c67ff]/40' }}" style="height: {{ $h }}%;"></div>
                    @endforeach
                </div>
            </div>
            
            <span class="text-white font-medium text-lg tracking-wide drop-shadow-md">02:00</span>
        </div>
    </div>

    {{-- Description --}}
    <div class="mb-10">
        <h3 class="text-[22px] font-semibold text-white mb-4">Description</h3>
        <p class="text-[13px] text-gray-400 leading-relaxed text-justify">
            {{ $track->description ?: 'Lorem ipsum dolor sit amet consectetur. Gravida morbi cras scelerisque tortor etiam dignissim tincidunt pharetra consequat. Diam ac blandit a in pellentesque egestas. Vel consequat sed id eget semper neque risus neque odio. In morbi nisi facilisi faucibus cursus felis faucibus nisi. Odio lectus at dictum ullamcorper sodales semper fames venenatis arcu. Ultricies molestie placerat scelerisque id mattis hendrerit odio et. Porttitor penatibus rhoncus sit odio at eu magna. Dui lectus aenean viverra molestie etiam lacus ullamcorper.' }}
        </p>
    </div>

    @php 
        $investAsset = $track->marketplaceAssets->where('sale_type', 'investment')->first(); 
        $saleAsset = $track->marketplaceAssets->where('sale_type', 'sale')->first();
        $licenseAsset = $track->marketplaceAssets->where('sale_type', 'license')->first();
        
        // If there are no assets defined yet, we'll show the buttons exactly as in the new screenshot for UI demonstration
        $showDemo = !$investAsset && !$saleAsset && !$licenseAsset;
    @endphp

    {{-- Investment Box (From previous screenshot) --}}
    @if($investAsset)
        <div class="bg-[#1b1c20] rounded-xl border border-white/5 mb-8 overflow-hidden">
            <div class="flex justify-between items-center p-6 border-b border-white/10">
                <h4 class="text-[15px] text-white font-medium">Want to invest?</h4>
                <a href="{{ route('consumer.dashboard.invest.track', $track->id) }}" class="text-[#5c67ff] text-[13px] hover:underline">Invest now</a>
            </div>
            <div class="p-6 space-y-4">
                <p class="text-[13px] text-white"><span class="text-gray-400 inline-block font-medium min-w-[140px]">Total Blocks:</span> {{ $investAsset->ownership_blocks ?? 100 }}</p>
                <p class="text-[13px] text-white"><span class="text-gray-400 inline-block font-medium min-w-[140px]">Remaining Blocks:</span> {{ $investAsset->remaining_blocks ?? 75 }}</p>
                <p class="text-[13px] text-white"><span class="text-gray-400 inline-block font-medium min-w-[140px]">Price per Block:</span> ${{ $investAsset->price_per_block ?? 50 }}</p>
            </div>
        </div>
    @endif
    
    </div> {{-- End !showWalletSelect view --}}

    {{-- Wallet Selection View --}}
    <div x-show="showWalletSelect" x-cloak class="min-h-[400px]">
        {{-- Header --}}
        <div class="flex items-center gap-4 mb-10">
            <button @click="showWalletSelect = false" class="text-[#5c67ff] hover:text-[#4b55e6] transition bg-transparent outline-none flex items-center group">
                <svg class="w-7 h-7 mr-3 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <h1 class="text-[32px] font-semibold tracking-tight text-[#5c67ff]">Select your Wallet to connect</h1>
            </button>
        </div>

        {{-- Wallet Options --}}
        <div class="space-y-5 mb-20">
            <button @click="window.location.href='{{ route('consumer.dashboard.track.checkout', $track->id) }}'" class="w-full bg-[#1b1c20] hover:bg-[#25262a] transition border border-[#5c67ff]/40 rounded-2xl p-7 flex items-center text-left shadow-[0_4px_20px_rgba(92,103,255,0.05)] focus:ring-1 focus:ring-[#5c67ff]">
                <span class="text-white text-[18px] font-medium tracking-wide">Connect with MetaMask</span>
            </button>
            <button @click="window.location.href='{{ route('consumer.dashboard.track.checkout', $track->id) }}'" class="w-full bg-[#1b1c20] hover:bg-[#25262a] transition border border-white/5 rounded-2xl p-7 flex items-center text-left focus:ring-1 focus:ring-[#5c67ff]">
                <span class="text-white text-[18px] font-medium tracking-wide">Connect with WalletConnect</span>
            </button>
        </div>
    </div>

    <div class="space-y-4 pt-10">
        {{-- Buy Action Button --}}
        @if($saleAsset || $investAsset || $showDemo)
            <button @click="showWalletSelect = true" class="w-full bg-[#5c67ff] hover:bg-[#4b55e6] text-white font-semibold text-[17px] py-5 rounded-[8px] transition-all duration-300 shadow-lg shadow-[#5c67ff]/25 active:scale-[0.99] flex items-center justify-center">
                Buy now
            </button>
        @endif

        {{-- License Action Button --}}
        @if($licenseAsset || $showDemo)
            <a href="{{ route('consumer.license.selection') }}" class="w-full bg-transparent border border-white/15 hover:border-white/30 text-white font-semibold text-[17px] py-5 rounded-[8px] transition-all duration-300 active:scale-[0.99] flex items-center justify-center">
                License Track
            </a>
        @endif
    </div>
</div>
@endsection
