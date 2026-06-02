@extends('layouts.admin')
@section('title', 'Site Content')
@section('page_title', 'Site Content')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <div>
        <p class="text-sm text-white/60">Edit the text and images that appear on the public website. Changes are live immediately after saving.</p>
    </div>
    <a href="{{ url('/') }}" target="_blank"
       class="text-xs text-accent hover:underline flex items-center gap-2">
        <i class="fa-solid fa-arrow-up-right-from-square"></i> Open website in new tab
    </a>
</div>

<form method="POST" action="{{ route('admin.site-content.update') }}" enctype="multipart/form-data" class="space-y-6">
    @csrf

    @foreach($groups as $groupName => $rows)
        <div class="admin-card p-6">
            <div class="flex items-center gap-3 mb-6 pb-4 border-b border-white/5">
                <i class="fa-solid fa-folder text-accent"></i>
                <h3 class="font-semibold text-lg">{{ $groupName }}</h3>
                <span class="text-xs text-white/40">{{ $rows->count() }} fields</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($rows as $row)
                    <div class="{{ in_array($row->type, ['textarea','image']) ? 'md:col-span-2' : '' }}">
                        <label class="block text-[11px] uppercase tracking-widest text-white/50 mb-2 flex items-center gap-2">
                            <span>{{ $row->label }}</span>
                            <code class="text-white/30 normal-case tracking-normal text-[10px]">{{ $row->key }}</code>
                        </label>

                        @if($row->type === 'textarea')
                            <textarea name="settings[{{ $row->key }}]" rows="4"
                                      class="w-full bg-[#0F0F0F] border border-white/10 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-accent">{{ $row->value }}</textarea>

                        @elseif($row->type === 'html')
                            <textarea name="settings[{{ $row->key }}]" rows="6"
                                      class="w-full bg-[#0F0F0F] border border-white/10 rounded-lg px-3 py-2.5 text-xs font-mono focus:outline-none focus:border-accent">{{ $row->value }}</textarea>
                            <p class="text-[10px] text-white/30 mt-1">HTML is allowed in this field.</p>

                        @elseif($row->type === 'color')
                            <div class="flex items-center gap-3">
                                <input type="color" name="settings[{{ $row->key }}]" value="{{ $row->value ?: '#FF00FF' }}"
                                       class="h-10 w-16 bg-[#0F0F0F] border border-white/10 rounded-lg cursor-pointer">
                                <input type="text" value="{{ $row->value ?: '#FF00FF' }}" disabled
                                       class="flex-1 bg-[#0F0F0F]/60 border border-white/5 rounded-lg px-3 py-2.5 text-sm text-white/50">
                            </div>

                        @elseif($row->type === 'image')
                            <div class="flex items-start gap-4">
                                <div class="w-32 h-32 rounded-lg border border-white/10 bg-[#0F0F0F] flex items-center justify-center overflow-hidden shrink-0">
                                    @if($row->value)
                                        <img src="{{ \App\Models\SiteSetting::image($row->key) }}" alt="" class="w-full h-full object-cover">
                                    @else
                                        <i class="fa-regular fa-image text-3xl text-white/20"></i>
                                    @endif
                                </div>
                                <div class="flex-1 space-y-2">
                                    <input type="file" name="image[{{ $row->key }}]" accept="image/*"
                                           class="block w-full text-sm text-white/70 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-accent file:text-white file:cursor-pointer hover:file:opacity-90">
                                    <p class="text-[10px] text-white/30">Recommended: JPG/PNG/WEBP, &lt; 2 MB.</p>
                                    @if($row->value)
                                        <label class="text-[11px] text-red-400 flex items-center gap-2 cursor-pointer">
                                            <input type="checkbox" name="clear[{{ $row->key }}]" value="1"
                                                   class="accent-red-400">
                                            Remove current image
                                        </label>
                                    @endif
                                </div>
                            </div>

                        @elseif($row->type === 'email')
                            <input type="email" name="settings[{{ $row->key }}]" value="{{ $row->value }}"
                                   class="w-full bg-[#0F0F0F] border border-white/10 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-accent">

                        @elseif($row->type === 'url')
                            <input type="text" name="settings[{{ $row->key }}]" value="{{ $row->value }}"
                                   placeholder="https://..."
                                   class="w-full bg-[#0F0F0F] border border-white/10 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-accent">

                        @else  {{-- text --}}
                            <input type="text" name="settings[{{ $row->key }}]" value="{{ $row->value }}"
                                   class="w-full bg-[#0F0F0F] border border-white/10 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-accent">
                        @endif

                        @if($row->help_text)
                            <p class="text-[11px] text-white/40 mt-1">{{ $row->help_text }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach

    <div class="sticky bottom-0 bg-[#1A1A1A]/95 backdrop-blur-md border-t border-white/5 py-4 -mx-8 px-8 flex justify-end gap-3 z-20">
        <a href="{{ url('/') }}" target="_blank" class="text-sm text-white/60 hover:text-white px-4 py-2.5">
            Preview
        </a>
        <button type="submit" class="bg-accent text-white px-6 py-2.5 rounded-lg text-sm font-semibold hover:opacity-90 transition-opacity flex items-center gap-2">
            <i class="fa-solid fa-floppy-disk"></i> Save All Changes
        </button>
    </div>
</form>
@endsection
