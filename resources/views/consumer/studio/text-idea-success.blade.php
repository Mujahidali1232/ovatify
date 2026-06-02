@extends('layouts.app')

@section('content')

<div class="h-full flex flex-col items-center justify-center -mt-10">
    <div class="w-full max-w-[1000px] border border-gray-800/40 rounded-[32px] p-10 md:p-14 bg-[#1b1c20]/60 backdrop-blur-xl shadow-2xl relative overflow-hidden">
        {{-- Background glow --}}
        <div class="absolute top-0 right-0 w-80 h-80 bg-[#4D61FF]/5 rounded-full blur-[120px] -mr-40 -mt-40"></div>
        
        {{-- Header --}}
        <div class="mb-12 relative z-10 flex items-center justify-between">
            <h1 class="text-[36px] font-bold text-white tracking-tight">Your text idea</h1>
            <a href="{{ route('consumer.studio.record') }}" class="text-[#4D61FF] font-bold text-[18px] hover:text-white transition-colors">Edit</a>
        </div>

        <div class="h-px bg-white/5 w-full mb-10"></div>

        {{-- Success Content --}}
        <div class="space-y-12 relative z-10">
            {{-- Text Box --}}
            <div class="p-8 rounded-[24px] bg-[#161719] border border-white/5 min-h-[160px]">
                <p class="text-gray-400 font-medium text-[16px] leading-[1.6]">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum
                </p>
            </div>

            {{-- More Ideas Section --}}
            <div class="space-y-8">
                <div class="flex items-center gap-4">
                    <h2 class="text-white text-[24px] font-bold tracking-tight">Want to add more ideas?</h2>
                </div>
                <div class="h-px bg-white/5 w-full"></div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <a href="{{ route('consumer.studio.upload') }}" class="w-full py-5 rounded-[14px] border border-gray-800 text-white font-bold text-[17px] hover:bg-white/5 transition-all text-center">
                        Upload Document
                    </a>
                    <a href="{{ route('consumer.studio.record') }}" class="w-full py-5 rounded-[14px] border border-gray-800 text-white font-bold text-[17px] hover:bg-white/5 transition-all text-center">
                        Record Audio
                    </a>
                </div>
            </div>

            {{-- Final Actions --}}
            <div class="flex flex-col gap-5 pt-10">
                <button class="w-full py-6 rounded-[18px] bg-[#4D61FF] hover:bg-[#3d4ed9] text-white font-bold text-[19px] transition-all duration-300 shadow-xl shadow-[#4D61FF]/20 active:scale-[0.99] tracking-wide">
                    Approve to continue
                </button>
                <button @click="window.history.back()" class="w-full py-6 rounded-[18px] border border-gray-700 text-gray-400 hover:text-white font-bold text-[19px] transition-all duration-300 active:scale-[0.99] tracking-wide">
                    Back
                </button>
            </div>
        </div>
    </div>
</div>

@endsection
