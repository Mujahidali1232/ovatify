@extends('layouts.app')

@section('content')

<div class="max-w-[950px] mx-auto mb-20">
    {{-- Header --}}
    <div class="flex items-center gap-4 mb-10">
        <a href="{{ url()->previous() }}" class="text-[#4D61FF] hover:text-white transition-colors duration-200 flex items-center group">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="mr-4 transition-transform group-hover:-translate-x-1">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            <h1 class="text-[34px] font-bold tracking-tight text-[#4D61FF]">Buy product</h1>
        </a>
    </div>

    <div class="bg-[#1A1A1A] border border-white/5 rounded-[40px] p-10 md:p-14 shadow-2xl relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-[#4D61FF]/5 rounded-full blur-[100px] -mr-32 -mt-32"></div>
        
        <h2 class="text-[28px] font-bold text-white mb-10 relative z-10">Order summary</h2>

        {{-- Order Card --}}
        <div class="flex flex-col md:flex-row gap-8 mb-12 relative z-10">
            {{-- Image Preview --}}
            <div class="w-full md:w-[220px] aspect-square rounded-[24px] overflow-hidden border border-white/10 shadow-lg">
                <img src="https://picsum.photos/600/600?random=checkout-img" class="w-full h-full object-cover">
            </div>

            {{-- Details --}}
            <div class="flex-1 flex flex-col justify-between py-2">
                <div>
                    <h3 class="text-white text-[28px] font-bold mb-4 tracking-tight">Title of the image</h3>
                    
                    <div class="flex items-center gap-3 mb-8">
                        <img src="https://i.pravatar.cc/40?u=artist" class="w-8 h-8 rounded-full border border-white/20">
                        <span class="text-gray-400 font-medium">Johna Smith</span>
                    </div>
                </div>

                <div class="flex flex-wrap items-center justify-between gap-6 pb-2">
                    <div class="flex gap-12">
                        <div>
                            <span class="text-gray-500 text-[11px] font-bold uppercase tracking-widest block mb-2">Type:</span>
                            <span class="text-white font-bold text-[15px]">Photo</span>
                        </div>
                        <div>
                            <span class="text-gray-500 text-[11px] font-bold uppercase tracking-widest block mb-2">Orientation:</span>
                            <span class="text-white font-bold text-[15px]">Square</span>
                        </div>
                    </div>
                    
                    <div>
                        <span class="text-white text-[32px] font-black tracking-tight">$29.00</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Form Fields --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12 relative z-10">
            <input type="text" placeholder="Name" class="w-full bg-[#222226] border border-white/5 rounded-[16px] py-5 px-8 text-white placeholder-gray-500 focus:ring-2 focus:ring-[#4D61FF]/40 outline-none transition-all font-medium text-[16px]">
            <input type="text" placeholder="Credit Card No" class="w-full bg-[#222226] border border-white/5 rounded-[16px] py-5 px-8 text-white placeholder-gray-500 focus:ring-2 focus:ring-[#4D61FF]/40 outline-none transition-all font-medium text-[16px]">
            <input type="text" placeholder="Expiry" class="w-full bg-[#222226] border border-white/5 rounded-[16px] py-5 px-8 text-white placeholder-gray-500 focus:ring-2 focus:ring-[#4D61FF]/40 outline-none transition-all font-medium text-[16px]">
            <input type="text" placeholder="CVV" class="w-full bg-[#222226] border border-white/5 rounded-[16px] py-5 px-8 text-white placeholder-gray-500 focus:ring-2 focus:ring-[#4D61FF]/40 outline-none transition-all font-medium text-[16px]">
        </div>

        {{-- Action Buttons --}}
        <div class="flex flex-col gap-5 pt-8 border-t border-white/5 relative z-10">
            <button @click="$dispatch('open-success-modal', { type: 'payment' })" class="w-full bg-[#4D61FF] hover:bg-[#3d4ed9] text-white font-bold text-[19px] py-6 rounded-[18px] transition-all duration-300 shadow-xl shadow-[#4D61FF]/20 active:scale-[0.98]">
                Confirm & Pay
            </button>
            <button class="w-full bg-transparent border border-gray-800 hover:border-gray-600 text-gray-400 hover:text-white font-bold text-[19px] py-6 rounded-[18px] transition-all duration-300 active:scale-[0.98]">
                Back to image
            </button>
        </div>
    </div>
</div>

@endsection
