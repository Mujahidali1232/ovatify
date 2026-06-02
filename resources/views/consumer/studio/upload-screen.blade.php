@extends('layouts.app')

@section('content')

<div class="h-full flex flex-col items-center justify-center -mt-10" x-data="{
    isUploading: false,
    uploadProgress: 0,
    uploadType: '',
    fileName: '',
    async handleUpload(e, type) {
        const file = e.target.files[0];
        if (!file) return;

        this.isUploading = true;
        this.uploadType = type;
        this.fileName = file.name;
        this.uploadProgress = 0;

        let formData = new FormData();
        formData.append('file', file);
        formData.append('type', type);
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
                window.location.href = '{{ route('consumer.studio.upload-success') }}';
            } else {
                alert('Upload failed: ' + (result.message || 'Unknown error'));
                this.isUploading = false;
            }
        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred during upload.');
            this.isUploading = false;
        }
    }
}">
    <div class="w-full max-w-[1000px] border border-gray-800/40 rounded-[32px] p-10 md:p-16 bg-[#1b1c20]/60 backdrop-blur-xl shadow-2xl relative overflow-hidden">
        {{-- Background blur effect --}}
        <div class="absolute top-0 right-0 w-80 h-80 bg-[#4D61FF]/5 rounded-full blur-[120px] -mr-40 -mt-40"></div>
        
        {{-- Header --}}
        <div class="mb-14 relative z-10">
            <div class="flex items-center gap-6 mb-6">
                <a href="{{ url()->previous() }}" class="text-[#4D61FF] hover:text-white transition-colors duration-200">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="19" y1="12" x2="5" y2="12"></line>
                        <polyline points="12 19 5 12 12 5"></polyline>
                    </svg>
                </a>
                <h1 class="text-[42px] font-bold text-[#4D61FF] tracking-tight">Upload Your Creative Content</h1>
            </div>
            <p class="text-[18px] text-gray-400 font-medium max-w-3xl leading-relaxed">
                Choose the type of content you want to upload. You'll be able to sell, license or offer investments.
            </p>
        </div>

        {{-- Loading State --}}
        <template x-if="isUploading">
            <div class="fixed inset-0 z-[100] bg-black/80 flex items-center justify-center backdrop-blur-md">
                <div class="text-center w-full max-w-md px-10">
                    <div class="w-20 h-20 border-4 border-magenta border-t-transparent rounded-full animate-spin mx-auto mb-8"></div>
                    <h2 class="text-2xl font-bold mb-2">Uploading <span x-text="uploadType" class="text-magenta capitalize"></span></h2>
                    <p class="text-gray-400 mb-6 truncate" x-text="fileName"></p>
                    <div class="w-full h-1.5 bg-white/10 rounded-full overflow-hidden">
                        <div class="h-full bg-magenta animate-progress-ind"></div>
                    </div>
                </div>
            </div>
        </template>

        {{-- Upload Options --}}
        <div class="space-y-8 relative z-10">
            {{-- Video Upload --}}
            <div class="p-10 rounded-[28px] bg-[#161719] border border-white/5 hover:border-[#4D61FF]/30 transition-all duration-300 group">
                <div class="flex items-center gap-6 mb-8">
                    <div class="w-14 h-14 rounded-2xl bg-white/5 flex items-center justify-center transition-colors group-hover:bg-[#4D61FF]/10">
                        <svg class="w-8 h-8 text-[#4D61FF]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-[22px] font-bold text-white">Upload Your Video</h3>
                        <p class="text-sm text-gray-500 mt-1">MP4, MOV or AVI (Max 50MB)</p>
                    </div>
                </div>
                <input type="file" @change="handleUpload($event, 'video')" class="hidden" x-ref="videoInput" accept="video/*">
                <button @click="$refs.videoInput.click()" class="w-full py-5 rounded-[14px] border border-gray-700 text-white font-bold text-[17px] hover:bg-[#4D61FF] hover:border-[#4D61FF] transition-all duration-300 active:scale-[0.99] uppercase tracking-wide">
                    Select Video File
                </button>
            </div>

            {{-- Image/Illustration Upload --}}
            <div class="p-10 rounded-[28px] bg-[#161719] border border-white/5 hover:border-[#4D61FF]/30 transition-all duration-300 group">
                <div class="flex items-center gap-6 mb-8">
                    <div class="w-14 h-14 rounded-2xl bg-white/5 flex items-center justify-center transition-colors group-hover:bg-[#4D61FF]/10">
                        <svg class="w-8 h-8 text-[#4D61FF]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-[22px] font-bold text-white">Upload Your Images or illustrations</h3>
                        <p class="text-sm text-gray-500 mt-1">JPG, PNG or WEBP (Max 10MB)</p>
                    </div>
                </div>
                <input type="file" @change="handleUpload($event, 'image')" class="hidden" x-ref="imageInput" accept="image/*">
                <button @click="$refs.imageInput.click()" class="w-full py-5 rounded-[14px] border border-gray-800 text-white font-bold text-[17px] hover:bg-[#4D61FF] hover:border-[#4D61FF] transition-all duration-300 active:scale-[0.99] uppercase tracking-wide">
                    Select Image File
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes progress-ind {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(100%); }
    }
    .animate-progress-ind {
        animation: progress-ind 1.5s infinite linear;
        width: 50%;
    }
</style>

@endsection