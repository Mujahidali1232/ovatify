@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto mb-20 px-4">
    {{-- Header --}}
    <div class="flex items-center gap-4 mb-10">
        <a href="{{ url()->previous() }}" class="text-[#5c67ff] hover:text-[#4b55e6] transition bg-transparent outline-none flex items-center group">
            <svg class="w-7 h-7 mr-3 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            <h1 class="text-[32px] font-bold tracking-tight text-[#5c67ff]">Invest in product</h1>
        </a>
    </div>

    <div class="bg-[#1b1b1f] border border-white/5 rounded-[32px] p-10 shadow-2xl">
        <h2 class="text-[22px] font-bold text-white mb-8">Order summary</h2>

        {{-- Item Card --}}
        <div class="flex flex-col md:flex-row items-center gap-8 mb-12 pb-12 border-b border-white/5">
            <div class="w-full md:w-[160px] aspect-square rounded-[20px] overflow-hidden border border-white/10 shadow-xl">
                <img src="https://picsum.photos/400/400?random=investment-summary" class="w-full h-full object-cover">
            </div>
            <div class="flex-1">
                <h3 class="text-white text-[24px] font-bold mb-3">Title of the image</h3>
                <div class="flex items-center gap-3 mb-6">
                    <img src="https://i.pravatar.cc/32?u=johnasmith" class="w-7 h-7 rounded-full border border-white/10">
                    <div class="flex flex-col">
                        <span class="text-white font-bold text-[14px] leading-tight">Johna Smith</span>
                        <span class="text-gray-500 text-[10px]">View profile</span>
                    </div>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-5 gap-6 opacity-60">
                    <div>
                        <p class="text-gray-500 text-[9px] uppercase font-bold mb-1">Resolution</p>
                        <p class="text-white font-bold text-[12px]">1600x1600</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-[9px] uppercase font-bold mb-1">Format & Size</p>
                        <p class="text-white font-bold text-[12px]">PNG - 10 MB</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-[9px] uppercase font-bold mb-1">Upload date</p>
                        <p class="text-white font-bold text-[12px]">Nov 8, 2025</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-[9px] uppercase font-bold mb-1">Type</p>
                        <p class="text-white font-bold text-[12px]">Photo</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-[9px] uppercase font-bold mb-1">Orientation</p>
                        <p class="text-white font-bold text-[12px]">Square</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Investment Details Rows --}}
        <div class="space-y-5 mb-10">
            <div class="flex justify-between items-center text-[15px] font-bold">
                <span class="text-gray-400">Investment Amount</span>
                <span class="text-white">$00</span>
            </div>
            <div class="flex justify-between items-center text-[15px] font-bold">
                <span class="text-gray-400">Ownership Stake</span>
                <span class="text-white">00%</span>
            </div>
            <div class="flex justify-between items-center text-[15px] font-bold">
                <span class="text-gray-400">Projected Monthly ROI</span>
                <span class="text-white">$000</span>
            </div>
            <div class="flex justify-between items-center text-[15px] font-bold">
                <span class="text-gray-400">Royalty Type</span>
                <span class="text-white">Lorem ipsum</span>
            </div>
        </div>

        {{-- Progress Bar --}}
        <div class="bg-[#1b1c20] rounded-[20px] p-6 mb-10 border border-white/5">
            <div class="flex justify-between items-center mb-4">
                <span class="text-white font-bold text-[17px]">00% funded</span>
            </div>
            <div class="w-full h-1.5 bg-white/5 rounded-full overflow-hidden">
                <div class="h-full w-[10%] bg-[#5c67ff] rounded-full shadow-[0_0_10px_rgba(92,103,255,0.4)]"></div>
            </div>
        </div>

        {{-- Smart Contract Terms --}}
        <div class="bg-[#1b1c20] rounded-[24px] p-8 mb-10 border border-white/5">
            <h3 class="text-white font-bold text-[18px] mb-6">Smart Contract Terms</h3>
            <ul class="space-y-4">
                <li class="flex items-center gap-3 text-gray-400 font-medium text-[15px]">
                    <div class="w-1.5 h-1.5 rounded-full bg-[#5c67ff]"></div>
                    Ownership is permanent and non-revocable.
                </li>
                <li class="flex items-center gap-3 text-gray-400 font-medium text-[15px]">
                    <div class="w-1.5 h-1.5 rounded-full bg-[#5c67ff]"></div>
                    Royalties are paid monthly to your wallet.
                </li>
                <li class="flex items-center gap-3 text-gray-400 font-medium text-[15px]">
                    <div class="w-1.5 h-1.5 rounded-full bg-[#5c67ff]"></div>
                    Enforced via Ethereum-based smart contract.
                </li>
            </ul>
        </div>

        {{-- Connected Wallet --}}
        @php $walletConnected = false; @endphp
        <div class="pt-8 border-t border-white/5">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-white font-bold text-[17px]">Connected Wallet</h3>
                @if($walletConnected)
                    <a href="{{ route('consumer.wallet.connect') }}" class="text-[#5c67ff] font-bold text-[15px] hover:underline">Change</a>
                @else
                    <a href="{{ route('consumer.wallet.connect') }}" class="text-[#5c67ff] font-bold text-[15px] hover:underline">Connect</a>
                @endif
            </div>
            
            <div class="flex justify-between items-center">
                @if($walletConnected)
                    <span class="text-gray-500 font-medium text-[15px]">MetaMask Address</span>
                    <span class="text-white font-mono text-[15px] tracking-wider">0xAB12...cE72</span>
                @else
                    <span class="text-gray-500 italic font-medium text-[14px]">Connect your wallet to proceed</span>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
