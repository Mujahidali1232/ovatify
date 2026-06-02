<div x-data="{ open: false }" x-show="open" @open-wallet-modal.window="open = true"
    class="fixed inset-0 z-50 flex items-center justify-center p-4">
    {{-- Overlay --}}
    <div @click="open = false" class="absolute inset-0 bg-black/70 backdrop-blur-sm"></div>

    {{-- Modal Content --}}
    <div class="relative bg-[#1A1A1A] border border-gray-800 rounded-3xl w-full max-w-md p-8 shadow-2xl">
        <button @click="open = false" class="absolute top-6 right-6 text-gray-500 hover:text-white transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <h2 class="text-2xl font-black mb-2 text-center">Connect Wallet</h2>
        <p class="text-sm text-center text-gray-500 mb-10">Choose how you want to connect. There are several wallet
            providers.</p>

        <div class="space-y-4">
            {{-- MetaMask --}}
            <button
                class="w-full p-5 rounded-2xl bg-[#252525] border border-gray-700 flex items-center gap-4 hover:border-accent/40 hover:bg-accent/5 transition group">
                <div
                    class="w-12 h-12 rounded-xl bg-[#1A1A1A] flex items-center justify-center group-hover:bg-accent/20 transition">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/3/36/MetaMask_Alpha_software_logo.svg"
                        class="w-8 h-8">
                </div>
                <div class="text-left">
                    <h4 class="font-bold text-white">MetaMask</h4>
                    <p class="text-[10px] text-gray-500">Connect to your MetaMask Wallet</p>
                </div>
                <i class="fas fa-chevron-right ml-auto text-gray-600 group-hover:text-accent"></i>
            </button>

            {{-- WalletConnect --}}
            <button
                class="w-full p-5 rounded-2xl bg-[#252525] border border-gray-700 flex items-center gap-4 hover:border-accent/40 hover:bg-accent/5 transition group">
                <div
                    class="w-12 h-12 rounded-xl bg-[#1A1A1A] flex items-center justify-center group-hover:bg-accent/20 transition">
                    <img src="https://raw.githubusercontent.com/WalletConnect/walletconnect-assets/master/Logo/Blue%20(Default)/Logo.svg"
                        class="w-8 h-8">
                </div>
                <div class="text-left">
                    <h4 class="font-bold text-white">WalletConnect</h4>
                    <p class="text-[10px] text-gray-500">Scan with WalletConnect to connect</p>
                </div>
                <i class="fas fa-chevron-right ml-auto text-gray-600 group-hover:text-accent"></i>
            </button>
        </div>

        <p class="mt-10 text-[10px] text-center text-gray-600">
            By connecting a wallet, you agree to Ovatify's <a href="#" class="text-accent underline">Terms of
                Service</a> and <a href="#" class="text-accent underline">Privacy Policy</a>.
        </p>
    </div>
</div>