<div x-data="{ open: false, type: 'investment' }" x-show="open"
    @open-success-modal.window="open = true; type = $event.detail.type || 'investment'"
    class="fixed inset-0 z-50 flex items-center justify-center p-4"
    style="display: none;"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 scale-95"
    x-transition:enter-end="opacity-100 scale-100">
    {{-- Overlay --}}
    <div @click="open = false" class="absolute inset-0 bg-black/85 backdrop-blur-sm"></div>

    {{-- Modal Content --}}
    <div class="relative bg-[#1b1c20] border border-white/10 rounded-[2.5rem] w-full max-w-[440px] p-10 md:p-14 shadow-3xl text-center overflow-visible">
        {{-- Success Icon Container with floating dots --}}
        <div class="relative w-36 h-36 mx-auto mb-10">
            {{-- Floating Dots - Matching screenshot positions --}}
            <div class="absolute -top-3 left-1/4 w-3.5 h-3.5 rounded-full bg-magenta"></div>
            <div class="absolute top-1/2 -left-6 w-1.5 h-1.5 rounded-full bg-magenta/60"></div>
            <div class="absolute -bottom-4 right-1/3 w-2 h-2 rounded-full bg-magenta/80"></div>
            <div class="absolute top-1/4 -right-5 w-2.5 h-2.5 rounded-full bg-magenta"></div>
            <div class="absolute bottom-4 -right-4 w-1.5 h-1.5 rounded-full bg-magenta/40"></div>
            <div class="absolute top-0 right-0 w-2 h-2 rounded-full bg-magenta/30"></div>
            <div class="absolute -bottom-2 -left-2 w-2 h-2 rounded-full bg-magenta/50"></div>
            
            {{-- Main Circle --}}
            <div class="w-full h-full rounded-full bg-magenta flex items-center justify-center shadow-[0_0_50px_rgba(255,0,255,0.35)] relative z-10 transition-transform hover:scale-105 duration-500">
                <div class="w-14 h-14 rounded-2xl bg-white flex items-center justify-center shadow-lg">
                    <svg class="w-9 h-9 text-magenta" fill="none" stroke="currentColor" stroke-width="4.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
            </div>
            
            {{-- Pulse effect --}}
            <div class="absolute inset-0 rounded-full bg-magenta/20 animate-ping"></div>
        </div>

        {{-- Content --}}
        <h2 class="text-[26px] font-bold mb-4 text-white leading-tight tracking-tight px-4"
            x-text="type === 'investment' ? 'You now own 5% of this track\'s royalties' : (type === 'payment' ? 'Purchase Successful' : (type === 'license' ? 'License Successful' : 'Success!'))">
        </h2>
        <p class="text-[15px] text-gray-400 mb-12 leading-relaxed px-2"
            x-text="type === 'investment' ? 'Your track is now available in your library!' : ((type === 'payment' || type === 'license') ? 'Your asset is now available in your library!' : 'Process completed successfully.')">
        </p>

        {{-- Actions --}}
        <div class="space-y-4">
            <button @click="open = false" 
                class="block w-full py-5 rounded-full bg-[#5c67ff] text-white font-bold text-[17px] hover:bg-[#4b55e6] transition-all duration-300 shadow-lg shadow-[#5c67ff]/20 active:scale-[0.98]">
                <span x-text="(type === 'payment' || type === 'license') ? 'Explore more images' : 'Explore more music'"></span>
            </button>
            
            <button @click="open = false" 
                class="block w-full py-5 rounded-full bg-[#2a2b2f] border border-white/10 text-white font-bold text-[17px] hover:bg-[#34353a] transition-all duration-300 active:scale-[0.98]">
                Back to home
            </button>
        </div>
    </div>
</div>

@push('scripts')
<style>
    @keyframes ping {
        75%, 100% {
            transform: scale(1.4);
            opacity: 0;
        }
    }
    .animate-ping {
        animation: ping 2s cubic-bezier(0, 0, 0.2, 1) infinite;
    }
</style>
@endpush