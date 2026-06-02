@extends('layouts.app')

@section('content')

<div class="h-full flex flex-col justify-start pt-12 px-12" x-data="{ 
        isPlaying: false,
        progress: 0,
        interval: null,
        waveformBars: [40, 60, 30, 80, 50, 40, 70, 90, 40, 30, 60, 80, 50, 40, 70, 30, 50, 60, 40, 80, 70, 50, 40, 60, 30, 80, 50, 40, 70, 90, 40, 30, 60, 80, 50, 40, 70, 30, 50, 60, 40, 80, 70, 50, 40, 60, 30, 80, 50, 40, 70, 90, 40, 30, 60, 80, 50, 40, 70, 30, 50, 60, 40, 80],
        
        isDragging: false,
        isUploading: false,
        fileName: '',
        
        togglePlay() {
            this.isPlaying = !this.isPlaying;
            if (this.isPlaying) {
                this.interval = setInterval(() => {
                    this.progress = (this.progress + 1) % 100;
                }, 500);
            } else {
                clearInterval(this.interval);
            }
        },

        handleDrop(e) {
            this.isDragging = false;
            let files = e.dataTransfer.files;
            if(files.length > 0) {
                this.uploadFile(files[0]);
            }
        },
        handleFileSelect(e) {
            let files = e.target.files;
            if(files.length > 0) {
                this.uploadFile(files[0]);
            }
        },
        uploadFile(file) {
            this.fileName = file.name;
            this.isUploading = true;
            setTimeout(() => {
                this.isUploading = false;
            }, 2000);
        }
    }">
    
    <div class="w-full max-w-[900px]">
        
        {{-- Header Section --}}
        <div class="mb-10">
            <div class="flex items-center gap-4 mb-4">
                <a href="{{ url()->previous() }}" class="text-[#4D61FF] hover:text-magenta transition-colors">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="19" y1="12" x2="5" y2="12"></line>
                        <polyline points="12 19 5 12 12 5"></polyline>
                    </svg>
                </a>
                <h1 class="text-[32px] tracking-tight font-semibold text-[#4D61FF]">Create your session</h1>
            </div>
            <p class="text-white/70 text-[18px] leading-relaxed max-w-[800px]">Start by adding a cover, title, and a quick overview to set the tone for your project</p>
        </div>

        <div class="space-y-10">
            
            {{-- Track Info Area --}}
            <div class="space-y-4">
                <div>
                    <h3 class="text-white text-[20px] font-medium tracking-tight">Lorem Ipsum</h3>
                    <p class="text-white/50 text-[14px] mt-0.5 font-medium">beat.waw - 120 BPM - 2.3 MB</p>
                </div>
                
                {{-- Waveform Player --}}
                <div class="bg-[#121212] rounded-[8px] p-6 pb-12 relative border border-white/5">
                    <div class="flex items-center gap-6">
                        <button @click="togglePlay" class="w-12 h-12 rounded-full border-[2px] border-magenta flex items-center justify-center text-magenta flex-shrink-0 transition-all hover:bg-magenta/10 active:scale-95">
                            <template x-if="!isPlaying">
                                <svg class="w-5 h-5 ml-0.5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                            </template>
                            <template x-if="isPlaying">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/></svg>
                            </template>
                        </button>
                        
                        <div class="flex-1 flex items-end gap-[3px] h-[40px]">
                            <template x-for="(height, index) in waveformBars" :key="index">
                                <div 
                                    class="flex-1 bg-[#1E297D] rounded-full transition-all duration-300"
                                    :style="`height: ${height}%; opacity: ${index < (progress * 0.64) ? '1' : '0.4'}`"
                                ></div>
                            </template>
                        </div>
                    </div>
                    <span class="absolute bottom-3 right-6 text-[#555555] text-[12px] font-medium tracking-wider">02:00</span>
                </div>
            </div>

            {{-- Audio/Cover Upload Area --}}
            <div 
                @dragover.prevent="isDragging = true"
                @dragleave.prevent="isDragging = false"
                @drop.prevent="handleDrop"
                @click="$refs.fileInput.click()"
                :class="isDragging ? 'border-magenta bg-magenta/5' : 'border-[#1E297D]/60 bg-transparent hover:bg-white/[0.02]'"
                class="w-full aspect-[21/10] border-[1px] border-dashed rounded-[10px] flex flex-col items-center justify-center cursor-pointer transition-all group relative overflow-hidden"
            >
                <input type="file" x-ref="fileInput" @change="handleFileSelect" class="hidden" accept="image/*,audio/*">
                
                <template x-if="!isUploading && !fileName">
                    <div class="flex flex-col items-center">
                        <div class="w-12 h-12 mb-4 flex items-center justify-center text-white/40 group-hover:text-white/60 transition-colors">
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                                <circle cx="8.5" cy="8.5" r="1.5"/>
                                <polyline points="21 15 16 10 5 21"/>
                            </svg>
                        </div>
                        <span class="text-white/50 font-normal text-[16px] tracking-wide">Upload your audio track</span>
                    </div>
                </template>

                <template x-if="isUploading">
                    <div class="flex flex-col items-center w-full px-20">
                        <div class="w-full h-1 bg-white/10 rounded-full overflow-hidden mb-6">
                            <div class="h-full bg-magenta animate-progress-fast"></div>
                        </div>
                        <span class="text-[#4D61FF] font-medium text-[16px] animate-pulse">Uploading <span x-text="fileName" class="text-white"></span>...</span>
                    </div>
                </template>
                
                <template x-if="!isUploading && fileName">
                    <div class="flex flex-col items-center">
                        <div class="w-16 h-16 rounded-full bg-[#1E297D]/20 flex items-center justify-center mb-4 text-[#4D61FF] border border-[#1E297D]/40">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <span class="text-white font-medium text-[16px]">File selected: <span x-text="fileName" class="text-[#4D61FF] truncate max-w-[300px] inline-block align-bottom"></span></span>
                    </div>
                </template>
            </div>

            {{-- Action Button --}}
            <div class="pt-4">
                <a href="{{ route('consumer.studio.customize-track') }}" class="w-full py-4 bg-transparent border border-white/20 text-white font-medium rounded-[8px] text-[18px] hover:bg-white/5 transition-all block text-center tracking-wide">
                    Continue
                </a>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<style>
    [x-cloak] { display: none !important; }
    
    @keyframes progress-fast {
        0% { width: 0%; }
        100% { width: 100%; }
    }
    .animate-progress-fast {
        animation: progress-fast 2s ease-in-out infinite;
    }
</style>
@endpush