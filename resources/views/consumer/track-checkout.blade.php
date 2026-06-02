@extends('layouts.app')

@section('content')

    <div class="max-w-[1000px] mx-auto mb-20">
        {{-- Header --}}
        <div class="flex items-center gap-4 mb-10">
            <a href="{{ url()->previous() }}"
                class="text-[#4D61FF] hover:text-white transition-colors duration-200 flex items-center group">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"
                    stroke-linecap="round" stroke-linejoin="round"
                    class="mr-4 transition-transform group-hover:-translate-x-1">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                <h1 class="text-[34px] font-bold tracking-tight text-[#4D61FF]">License Track</h1>
            </a>
        </div>

        <div class="bg-[#1A1A1A] border border-white/5 rounded-[32px] p-10 md:p-14 shadow-2xl relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-[#4D61FF]/5 rounded-full blur-[100px] -mr-32 -mt-32"></div>

            <h2 class="text-[26px] font-bold text-white mb-10 relative z-10">Order summary</h2>

            {{-- Order Card --}}
            <div class="flex flex-col md:flex-row gap-10 mb-12 relative z-10">
                {{-- Image Preview --}}
                <div
                    class="w-full md:w-[240px] aspect-square rounded-[24px] overflow-hidden border border-white/10 shadow-lg">
                    <img src="https://picsum.photos/600/600?random=license-img" class="w-full h-full object-cover">
                </div>

                {{-- Details --}}
                <div class="flex-1 flex flex-col justify-between py-2">
                    <div>
                        <h3 class="text-white text-[28px] font-bold mb-4 tracking-tight">Title of the image</h3>

                        <div class="flex items-center gap-3 mb-8">
                            <img src="https://i.pravatar.cc/40?u=johna" class="w-8 h-8 rounded-full border border-white/20">
                            <div class="flex flex-col">
                                <span class="text-white font-bold text-[14px] leading-tight">Johna Smith</span>
                                <span class="text-gray-500 text-[10px] font-medium">View profile</span>
                            </div>
                        </div>
                    </div>

                    {{-- Stats Grid --}}
                    <div class="grid grid-cols-2 md:grid-cols-5 gap-6 pt-6 border-t border-white/5">
                        <div class="space-y-2">
                            <div class="flex items-center gap-2 text-[#4D61FF]">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m4-4l-5 5m11-1v4m0 0h-4m-4-4l5 5" />
                                </svg>
                                <span class="text-gray-500 text-[10px] font-bold uppercase tracking-wider">Resolution</span>
                            </div>
                            <p class="text-white font-bold text-[13px]">1600x1600</p>
                        </div>
                        <div class="space-y-2">
                            <div class="flex items-center gap-2 text-[#4D61FF]">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <span class="text-gray-500 text-[10px] font-bold uppercase tracking-wider">Format &
                                    Size</span>
                            </div>
                            <p class="text-white font-bold text-[13px]">PNG - 10 MB</p>
                        </div>
                        <div class="space-y-2">
                            <div class="flex items-center gap-2 text-[#4D61FF]">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="text-gray-500 text-[10px] font-bold uppercase tracking-wider">Upload
                                    date</span>
                            </div>
                            <p class="text-white font-bold text-[13px]">Nov 8, 2025</p>
                        </div>
                        <div class="space-y-2 pt-1">
                            <span
                                class="text-gray-500 text-[10px] font-bold uppercase tracking-wider block mb-1">Type:</span>
                            <p class="text-white font-bold text-[13px]">Photo</p>
                        </div>
                        <div class="space-y-2 pt-1">
                            <span
                                class="text-gray-500 text-[10px] font-bold uppercase tracking-wider block mb-1">Orientation:</span>
                            <p class="text-white font-bold text-[13px]">Square</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Payment Section --}}
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-white text-[20px] font-bold">Enter your credit card</h3>
                    <span class="text-white text-[28px] font-black tracking-tight">$29.00</span>
                </div>

                {{-- Form Fields --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <input type="text" placeholder="Name"
                        class="w-full bg-[#222226] border border-white/5 rounded-[16px] py-5 px-8 text-white placeholder-gray-500 focus:ring-2 focus:ring-[#4D61FF]/40 outline-none transition-all font-medium text-[16px]">
                    <input type="text" placeholder="Credit Card No"
                        class="w-full bg-[#222226] border border-white/5 rounded-[16px] py-5 px-8 text-white placeholder-gray-500 focus:ring-2 focus:ring-[#4D61FF]/40 outline-none transition-all font-medium text-[16px]">
                    <input type="text" placeholder="Expiry"
                        class="w-full bg-[#222226] border border-white/5 rounded-[16px] py-5 px-8 text-white placeholder-gray-500 focus:ring-2 focus:ring-[#4D61FF]/40 outline-none transition-all font-medium text-[16px]">
                    <input type="text" placeholder="CVV"
                        class="w-full bg-[#222226] border border-white/5 rounded-[16px] py-5 px-8 text-white placeholder-gray-500 focus:ring-2 focus:ring-[#4D61FF]/40 outline-none transition-all font-medium text-[16px]">
                </div>

                {{-- Save Card --}}
                <div class="flex items-center gap-3 mb-12">
                    <div class="relative">
                        <input type="checkbox" id="save-card-track" class="peer h-6 w-6 opacity-0 absolute cursor-pointer">
                        <div
                            class="h-6 w-6 border-2 border-white/10 rounded-md bg-[#222226] peer-checked:bg-[#4D61FF] peer-checked:border-[#4D61FF] transition-all">
                        </div>
                        <svg class="absolute top-1 left-1 w-4 h-4 text-white opacity-0 peer-checked:opacity-100 transition-opacity pointer-events-none"
                            fill="none" stroke="currentColor" stroke-width="4" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <label for="save-card-track"
                        class="text-gray-400 text-[15px] font-medium cursor-pointer hover:text-white transition-colors">Save
                        card for future purchases</label>
                </div>

                {{-- Action Buttons --}}
                <div class="flex flex-col gap-5">
                    <button @click="$dispatch('open-success-modal', { type: 'license' })"
                        class="w-full bg-[#4D61FF] hover:bg-[#3d4ed9] text-white font-bold text-[19px] py-6 rounded-[18px] transition-all duration-300 shadow-xl shadow-[#4D61FF]/20 active:scale-[0.98]">
                        Confirm & Pay
                    </button>
                    <button @click="window.history.back()"
                        class="w-full bg-transparent border border-gray-800 hover:border-gray-600 text-gray-400 hover:text-white font-bold text-[19px] py-6 rounded-[18px] transition-all duration-300 active:scale-[0.98]">
                        Back to track
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection