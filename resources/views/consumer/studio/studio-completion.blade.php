@extends('layouts.app')

@section('content')

<div class="h-full flex flex-col items-center justify-start pt-10" x-data="{ 
    selectedOption: 'earning',
    options: {
        'earning': '{{ route('consumer.forms.set-for-sale') }}',
        'invest': '{{ route('consumer.forms.investment-settings') }}',
        'legal': '{{ route('consumer.forms.licensing-settings') }}'
    }
}">
    <div class="w-full max-w-[900px] bg-[#111111] rounded-[24px] p-8 md:p-14 border border-white/5 shadow-2xl relative overflow-hidden">
        
        {{-- Header Section --}}
        <div class="flex items-center gap-4 mb-4 relative z-10">
            <a href="{{ url()->previous() }}" class="text-[#4D61FF] hover:text-white transition-colors">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
            </a>
            <h1 class="text-[32px] font-semibold text-[#4D61FF]">Congratulations, track is ready!</h1>
        </div>
        <p class="text-white text-[18px] mb-10 pl-11">What would you like to do now?</p>

        <div class="space-y-4 mb-14 relative z-10">
            {{-- Option 1: Earning --}}
            <div @click="selectedOption = 'earning'" 
                 :class="selectedOption === 'earning' ? 'border-[#4D61FF] bg-[#4D61FF]/5' : 'border-white/5 bg-[#161719]'"
                 class="p-6 rounded-[16px] border-2 cursor-pointer transition-all duration-200 group">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-lg bg-white/5 flex items-center justify-center group-hover:bg-[#4D61FF]/10 transition-colors">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-white text-[15px] font-medium leading-none mb-2">Start earning right away</h3>
                    </div>
                </div>
            </div>

            {{-- Option 2: Invest --}}
            <div @click="selectedOption = 'invest'" 
                 :class="selectedOption === 'invest' ? 'border-[#4D61FF] bg-[#4D61FF]/5' : 'border-white/5 bg-[#161719]'"
                 class="p-6 rounded-[16px] border-2 cursor-pointer transition-all duration-200 group">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-lg bg-white/5 flex items-center justify-center group-hover:bg-[#4D61FF]/10 transition-colors">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-white text-[15px] font-medium leading-none mb-2">Get others to invest and share growth.</h3>
                    </div>
                </div>
            </div>

            {{-- Option 3: Legal --}}
            <div @click="selectedOption = 'legal'" 
                 :class="selectedOption === 'legal' ? 'border-[#4D61FF] bg-[#4D61FF]/5' : 'border-white/5 bg-[#161719]'"
                 class="p-6 rounded-[16px] border-2 cursor-pointer transition-all duration-200 group">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-lg bg-white/5 flex items-center justify-center group-hover:bg-[#4D61FF]/10 transition-colors">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A3.323 3.323 0 0010.605 7.043 3.323 3.323 0 009 6c-1.343 0-2.545.412-3.618 1.114A3.323 3.323 0 005 6c-1.343 0-2.545.412-3.618 1.114A3.323 3.323 0 001 6v12c0 1.343 1.202 2.427 2.682 2.427a3.323 3.323 0 013.318 1.18c.312.385.6.818.847 1.285.228.43.432.89.608 1.378.176.488.33.99.46.155m0-18.427c.13-.835.284-1.637.46-2.125.176-.488.38-.948.608-1.378a3.323 3.323 0 01.847-1.285 3.323 3.323 0 013.318-1.18c1.48 0 2.682-1.084 2.682-2.427V6z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-white text-[15px] font-medium leading-none mb-2">Let brands and creators use legally</h3>
                    </div>
                </div>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="space-y-4">
            <button @click="window.location.href = options[selectedOption]" 
                    class="w-full py-5 bg-[#4D61FF] hover:bg-[#3d4ed9] text-white font-bold rounded-[14px] text-[18px] transition-all transform active:scale-[0.98] shadow-lg shadow-[#4D61FF]/20">
                Continue
            </button>
            <a href="{{ route('consumer.dashboard.index') }}" 
               class="w-full py-5 bg-transparent border border-white/20 text-white font-bold rounded-[14px] text-[18px] hover:bg-white/5 transition-all block text-center">
                Save, Back to home
            </a>
        </div>

    </div>
</div>

@endsection

@push('scripts')
<style>
    [x-cloak] { display: none !important; }
</style>
@endpush
