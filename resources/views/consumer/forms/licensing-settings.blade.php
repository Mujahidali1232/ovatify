@extends('layouts.app')

@section('content')

<div class="h-full flex flex-col items-center justify-start pt-10" x-data="{ 
    selectedDuration: 'Lifetime',
    types: {
        personal: true,
        commercial: false,
        youtube: false,
        sync: false
    }
}">
    <div class="w-full max-w-[1000px] bg-[#111111] rounded-[24px] p-8 md:p-14 border border-white/5 shadow-2xl relative overflow-hidden">
        
        {{-- Header Section --}}
        <div class="flex items-center gap-4 mb-2 relative z-10">
            <a href="{{ url()->previous() }}" class="text-[#4D61FF] hover:text-white transition-colors">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
            </a>
            <h1 class="text-[32px] font-semibold text-[#4D61FF]">Set up License</h1>
        </div>
        <p class="text-white/80 text-[18px] mb-12 pl-11">Define how others can legally use your track</p>

        <div class="space-y-10 relative z-10">
            {{-- License Title --}}
            <div class="space-y-4">
                <label class="text-white text-[16px] font-medium">License Title</label>
                <div class="bg-[#161719] rounded-[14px] border border-white/5 px-6 py-4">
                    <input type="text" placeholder="Enter license title" class="bg-transparent border-none outline-none w-full text-white placeholder-gray-600 font-medium">
                </div>
            </div>

            {{-- License Types --}}
            <div class="space-y-4">
                <label class="text-white text-[16px] font-medium">License Types</label>
                <div class="flex flex-wrap gap-8">
                    @foreach([
                        'personal' => 'Personal Use',
                        'commercial' => 'Commercial Use',
                        'youtube' => 'YouTube Monetization',
                        'sync' => 'Sync Licensing (for ads, TV, etc.)'
                    ] as $key => $label)
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="checkbox" x-model="types.{{ $key }}" class="hidden">
                            <div class="w-6 h-6 rounded border-2 transition-all flex items-center justify-center"
                                 :class="types.{{ $key }} ? 'bg-[#4D61FF] border-[#4D61FF]' : 'border-white/20 group-hover:border-white/40'">
                                <svg x-show="types.{{ $key }}" class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                            </div>
                            <span class="text-white/60 text-[14px] font-medium group-hover:text-white transition-colors">{{ $label }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- Set Price --}}
                <div class="space-y-4">
                    <label class="text-white text-[16px] font-medium">Set Price per License</label>
                    <div class="bg-[#161719] rounded-[14px] border border-white/5 px-6 py-4">
                        <input type="text" placeholder="e.g. $5" class="bg-transparent border-none outline-none w-full text-white placeholder-gray-600 font-medium">
                    </div>
                </div>

                {{-- License Duration --}}
                <div class="space-y-4">
                    <label class="text-white text-[16px] font-medium">License Duration</label>
                    <div class="flex gap-2">
                        @foreach(['1 Year', '5 Years', '8 Years', 'Lifetime'] as $duration)
                            <div 
                                @click="selectedDuration = '{{ $duration }}'"
                                :class="selectedDuration === '{{ $duration }}' ? 'bg-white/10 text-white border-white/20' : 'bg-white/5 text-gray-500 border-transparent'"
                                class="flex-1 py-3 text-center rounded-[8px] border cursor-pointer font-bold transition-all text-[11px] uppercase tracking-wider"
                            >
                                {{ $duration }}
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Write smart contract --}}
            <div class="space-y-4">
                <label class="text-white text-[16px] font-medium">Write smart contract</label>
                <div class="bg-[#161719] rounded-[16px] border border-white/5 overflow-hidden">
                    {{-- Toolbar --}}
                    <div class="flex items-center gap-8 px-6 py-4 border-b border-white/5 bg-white/2">
                        <button class="text-white hover:text-[#4D61FF] transition-colors"><span class="font-bold text-lg">B</span></button>
                        <button class="text-white hover:text-[#4D61FF] transition-colors"><span class="italic font-serif text-lg">I</span></button>
                        <button class="text-white hover:text-[#4D61FF] transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
                        </button>
                        <button class="text-white hover:text-[#4D61FF] transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h7"/></svg>
                        </button>
                    </div>
                    {{-- Editor Area --}}
                    <div class="p-8 min-h-[120px]">
                        <p class="text-white font-bold text-[14px]">1. Grant of Rights</p>
                    </div>
                </div>
            </div>

            {{-- Action Button --}}
            <div class="pt-6">
                <button @click="window.location.href='{{ route('consumer.forms.review-license') }}'" class="w-full py-5 bg-[#4D61FF] hover:bg-[#3d4ed9] text-white font-bold rounded-[14px] text-[18px] transition-all transform active:scale-[0.98] shadow-lg shadow-[#4D61FF]/20">
                    Generate, Preview License
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<style>
    [x-cloak] { display: none !important; }
</style>
@endpush