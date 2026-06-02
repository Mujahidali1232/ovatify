@extends('layouts.app')

@section('content')

    {{-- Header --}}
    <div class="flex justify-between items-center mb-16">
        <div>
            <h2 class="text-accent text-sm font-bold uppercase tracking-widest mb-2">Rights Management</h2>
            <h1 class="text-5xl font-black">Control Portfolio</h1>
        </div>
        <a href="{{ route('consumer.investments.index') }}"
            class="px-6 py-3 rounded-xl bg-accent/10 border border-accent/20 text-accent text-sm font-bold hover:bg-accent/20 transition">
            View my investments
        </a>
    </div>

    {{-- Choose Project --}}
    <div class="mb-8">
        <h3 class="text-sm font-medium mb-4">Choose the project</h3>
        <div class="flex flex-wrap gap-6">
            @foreach(['Reflector', 'Lorem', 'Ipsum', 'Ipsum', 'Ipsum', 'Ipsum'] as $i => $project)
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="radio" name="project" value="{{ $project }}" class="w-4 h-4 accent-accent" {{ $i === 0 ? 'checked' : '' }}>
                    <span class="text-sm text-gray-300">{{ $project }}</span>
                </label>
            @endforeach
        </div>
    </div>

    {{-- Collaborators --}}
    <div class="mb-8">
        <h3 class="text-sm font-medium mb-4">Collaborators</h3>

        <div class="grid grid-cols-3 gap-6">
            @php
                $collaborators = [
                    ['name' => 'Alice Smith', 'roles' => ['Artist', 'Producer', 'Writer']],
                    ['name' => 'John Doe', 'roles' => ['Artist', 'Producer', 'Writer']],
                    ['name' => 'Sarah Lee', 'roles' => ['Artist', 'Producer']],
                ];
            @endphp

            @foreach($collaborators as $collab)
                <div class="p-4 rounded-xl bg-[#252525]">
                    <h4 class="text-sm font-medium mb-3">{{ $collab['name'] }}</h4>
                    <div class="flex flex-wrap gap-2">
                        @foreach($collab['roles'] as $role)
                            <label class="flex items-center gap-1.5 cursor-pointer">
                                <input type="checkbox" class="w-3.5 h-3.5 accent-accent rounded" checked>
                                <span class="text-xs text-gray-400">{{ $role }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Ownership Chart --}}
    <div class="mb-8">
        <h3 class="text-lg font-semibold mb-4 text-center">See Who Gets What</h3>

        <div class="flex items-center justify-center gap-12">
            {{-- Donut Chart SVG --}}
            <div class="relative w-48 h-48">
                <svg viewBox="0 0 100 100" class="w-full h-full transform -rotate-90">
                    {{-- Background circle --}}
                    <circle cx="50" cy="50" r="40" fill="none" stroke="#1A1A1A" stroke-width="20" />
                    {{-- Alice Smith 50% - Magenta --}}
                    <circle cx="50" cy="50" r="40" fill="none" stroke="#FF00FF" stroke-width="20"
                        stroke-dasharray="125.6 125.6" stroke-dashoffset="0" />
                    {{-- John Doe 50% - Blue --}}
                    <circle cx="50" cy="50" r="40" fill="none" stroke="#4D61FF" stroke-width="20"
                        stroke-dasharray="125.6 125.6" stroke-dashoffset="-125.6" />
                </svg>
            </div>

            {{-- Legend --}}
            <div class="space-y-3">
                <div class="flex items-center gap-3">
                    <span class="w-3 h-3 rounded-full bg-accent"></span>
                    <span class="text-sm text-gray-300">Alice Smith is getting <strong
                            class="text-white">50%</strong></span>
                </div>
                <div class="flex items-center gap-3">
                    <span class="w-3 h-3 rounded-full bg-[#4D61FF]"></span>
                    <span class="text-sm text-gray-300">John Doe is getting <strong class="text-white">50%</strong></span>
                </div>
            </div>
        </div>
    </div>

    {{-- Agreement Templates --}}
    <div>
        <h3 class="text-sm font-medium mb-4">Agreement Templates</h3>

        <div class="grid grid-cols-3 gap-4">
            @foreach(['Standard Artist...', 'Producer...', 'Collaboration...'] as $template)
                <button class="p-4 rounded-xl bg-[#252525] text-left hover:bg-[#303030] transition">
                    <span class="text-sm text-gray-300">{{ $template }}</span>
                </button>
            @endforeach
        </div>
    </div>

@endsection