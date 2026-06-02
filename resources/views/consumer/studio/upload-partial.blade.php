@extends('layouts.app')

@section('content')

<div class="h-full flex flex-col justify-start pt-12 px-12" x-data="{
        isDragging: false,
        isUploading: false,
        fileName: '',
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
        async uploadFile(file) {
            this.fileName = file.name;
            this.isUploading = true;
            
            let formData = new FormData();
            formData.append('file', file);
            formData.append('type', 'audio');
            formData.append('_token', '{{ csrf_token() }}');

            try {
                const response = await fetch('{{ route('consumer.file.upload') }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'Accept': 'application/json'
                    }
                });

                const result = await response.json();

                if (result.success) {
                    // Success! Redirect to completion page
                    window.location.href = '{{ route('consumer.studio.upload-success') }}';
                } else {
                    alert('Upload failed: ' + (result.message || 'Unknown error'));
                    this.isUploading = false;
                }
            } catch (error) {
                console.error('Error uploading file:', error);
                alert('An error occurred during upload. Please try again.');
                this.isUploading = false;
            }
        }
    }">
    
    <div class="w-full max-w-[900px] bg-[#141414] border border-white/5 rounded-[12px] p-10">
        
        {{-- Header Section --}}
        <div class="mb-10">
            <h1 class="text-[32px] tracking-tight font-semibold text-[#4D61FF]">Upload partial track</h1>
        </div>

        <div class="space-y-12">
            {{-- Audio Upload Area --}}
            <div 
                @dragover.prevent="isDragging = true"
                @dragleave.prevent="isDragging = false"
                @drop.prevent="handleDrop"
                @click="$refs.fileInput.click()"
                :class="isDragging ? 'border-magenta bg-magenta/5' : 'border-[#1E297D]/60 bg-transparent hover:bg-white/[0.02]'"
                class="w-full aspect-[21/10] border-[1px] border-dashed rounded-[10px] flex flex-col items-center justify-center cursor-pointer transition-all group relative overflow-hidden"
            >
                <input type="file" x-ref="fileInput" @change="handleFileSelect" class="hidden" accept="audio/*">
                
                <template x-if="!isUploading">
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
            </div>

            {{-- Action Buttons --}}
            <div class="pt-4">
                <a href="{{ route('consumer.dashboard.index') }}" 
                   class="w-full py-4 bg-[#141414] border border-white/20 text-white font-medium rounded-[8px] text-[16px] hover:bg-white/5 transition-all block text-center tracking-wide">
                    Back to home
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
