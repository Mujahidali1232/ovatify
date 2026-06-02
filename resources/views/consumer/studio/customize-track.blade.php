@extends('layouts.app')

@section('content')

<div class="h-full flex flex-col items-center justify-center -mt-8" x-data="{ 
    instrumental: 'solo',
    genre: 'pop' 
}">
    <div class="w-full max-w-[1050px] border border-gray-800/40 rounded-[32px] p-10 md:p-14 bg-[#1b1c20]/60 backdrop-blur-xl shadow-2xl relative overflow-hidden">
        {{-- Background glow --}}
        <div class="absolute top-0 right-0 w-80 h-80 bg-[#4D61FF]/5 rounded-full blur-[120px] -mr-40 -mt-40"></div>
        
        {{-- Header --}}
        <div class="mb-10 relative z-10">
            <div class="flex items-center gap-6 mb-6">
                <a href="{{ url()->previous() }}" class="text-[#4D61FF] hover:text-white transition-colors duration-200">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="19" y1="12" x2="5" y2="12"></line>
                        <polyline points="12 19 5 12 12 5"></polyline>
                    </svg>
                </a>
                <h1 class="text-[42px] font-bold text-[#4D61FF] tracking-tight">Customize Your Track</h1>
            </div>
            <p class="text-[18px] text-gray-400 font-medium max-w-2xl leading-relaxed">
                Tell us more about your style so we can shape your idea better.
            </p>
        </div>

        {{-- Configuration Form --}}
        <div class="space-y-12 relative z-10">
            {{-- Instrumental/Acapella --}}
            <div class="space-y-6">
                <h3 class="text-white text-[20px] font-bold tracking-tight pb-3 border-b border-white/5">Instrumental/Acapella</h3>
                <div class="flex flex-wrap gap-4">
                    @foreach([
                        'solo' => 'Solo singer',
                        'duet' => 'Duet',
                        'group' => 'Group/Band',
                        'score' => 'Background score'
                    ] as $value => $label)
                        <button 
                            @click="instrumental = '{{ $value }}'"
                            :class="instrumental === '{{ $value }}' ? 'border-[#4D61FF] bg-[#4D61FF]/5 text-white' : 'border-white/5 bg-[#161719] text-gray-400 hover:border-white/10'"
                            class="px-8 py-4 rounded-[12px] border-2 font-bold text-[15px] transition-all duration-200"
                        >
                            {{ $label }}
                        </button>
                    @endforeach
                </div>
            </div>

            {{-- Music Genre --}}
            <div class="space-y-6">
                <h3 class="text-white text-[20px] font-bold tracking-tight pb-3 border-b border-white/5">Music Genre</h3>
                <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-2 gap-4">
                    @foreach([
                        'pop' => 'POP',
                        'rock' => 'Rock',
                        'hiphop' => 'Hip-Hop',
                        'rnb' => 'R&B',
                        'edm' => 'EDM',
                        'jazz' => 'Jazz',
                        'classical' => 'Classical',
                        'reggae' => 'Reggae'
                    ] as $value => $label)
                        <button 
                            @click="genre = '{{ $value }}'"
                            :class="genre === '{{ $value }}' ? 'border-[#4D61FF] bg-[#4D61FF]/5 text-white' : 'border-white/5 bg-[#161719] text-gray-400 hover:border-white/10'"
                            class="w-full py-5 rounded-[12px] border-2 font-bold text-[16px] transition-all duration-200 tracking-wide"
                        >
                            {{ $label }}
                        </button>
                    @endforeach
                </div>
            </div>

            {{-- Action Button --}}
            <div class="pt-8">
                <button class="w-full py-6 rounded-[18px] bg-[#4D61FF] hover:bg-[#3d4ed9] text-white font-bold text-[19px] transition-all duration-300 shadow-xl shadow-[#4D61FF]/20 active:scale-[0.99] tracking-wide">
                    Continue
                </button>
            </div>
        </div>
    </div>
</div>

@endsection
