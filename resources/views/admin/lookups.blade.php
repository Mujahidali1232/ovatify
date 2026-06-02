@extends('layouts.admin')
@section('title', 'Lookup Data')
@section('page_title', 'Lookup Data')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    {{-- Genres --}}
    <div class="admin-card p-6">
        <h3 class="font-semibold mb-4 flex items-center gap-2"><i class="fa-solid fa-music text-accent"></i> Genres</h3>
        <form method="POST" action="{{ route('admin.lookups.genres.store') }}" class="flex gap-2 mb-4">
            @csrf
            <input type="text" name="name" placeholder="New genre name" required
                   class="flex-1 bg-[#0F0F0F] border border-white/10 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-accent">
            <button class="bg-accent text-white px-4 py-2 rounded-lg text-sm font-semibold hover:opacity-90">Add</button>
        </form>
        <div class="space-y-1 max-h-80 overflow-y-auto">
            @foreach($genres as $g)
                <div class="flex items-center justify-between py-2 px-3 rounded hover:bg-white/5">
                    <span class="text-sm {{ $g->is_active ? '' : 'text-white/40 line-through' }}">{{ $g->name }}</span>
                    <div class="flex gap-1">
                        <form method="POST" action="{{ route('admin.lookups.genres.toggle', $g->id) }}" class="inline">
                            @csrf
                            <button class="w-7 h-7 rounded hover:bg-white/10 text-xs" title="Toggle"><i class="fa-solid fa-power-off"></i></button>
                        </form>
                        <form method="POST" action="{{ route('admin.lookups.genres.delete', $g->id) }}" class="inline" onsubmit="return confirm('Delete {{ $g->name }}?');">
                            @csrf
                            <button class="w-7 h-7 rounded hover:bg-red-500/10 hover:text-red-400 text-xs" title="Delete"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- DSP Platforms --}}
    <div class="admin-card p-6">
        <h3 class="font-semibold mb-4 flex items-center gap-2"><i class="fa-solid fa-tower-broadcast text-accent"></i> DSP Platforms</h3>
        <form method="POST" action="{{ route('admin.lookups.dsp.store') }}" class="grid grid-cols-3 gap-2 mb-4">
            @csrf
            <input type="text" name="name" placeholder="Platform name" required
                   class="col-span-2 bg-[#0F0F0F] border border-white/10 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-accent">
            <input type="text" name="brand_color" placeholder="#1DB954"
                   class="bg-[#0F0F0F] border border-white/10 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-accent">
            <button class="col-span-3 bg-accent text-white px-4 py-2 rounded-lg text-sm font-semibold hover:opacity-90">Add DSP</button>
        </form>
        <div class="space-y-1 max-h-80 overflow-y-auto">
            @foreach($dspPlatforms as $d)
                <div class="flex items-center justify-between py-2 px-3 rounded hover:bg-white/5">
                    <div class="flex items-center gap-2">
                        @if($d->brand_color)
                            <span class="w-3 h-3 rounded-full" style="background: {{ $d->brand_color }}"></span>
                        @endif
                        <span class="text-sm {{ $d->is_active ? '' : 'text-white/40 line-through' }}">{{ $d->name }}</span>
                    </div>
                    <div class="flex gap-1">
                        <form method="POST" action="{{ route('admin.lookups.dsp.toggle', $d->id) }}" class="inline">
                            @csrf
                            <button class="w-7 h-7 rounded hover:bg-white/10 text-xs"><i class="fa-solid fa-power-off"></i></button>
                        </form>
                        <form method="POST" action="{{ route('admin.lookups.dsp.delete', $d->id) }}" class="inline" onsubmit="return confirm('Delete {{ $d->name }}?');">
                            @csrf
                            <button class="w-7 h-7 rounded hover:bg-red-500/10 hover:text-red-400 text-xs"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- License Tiers --}}
    <div class="admin-card p-6 lg:col-span-2">
        <h3 class="font-semibold mb-4 flex items-center gap-2"><i class="fa-solid fa-key text-accent"></i> License Tiers</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="text-xs uppercase tracking-wider text-white/40 border-b border-white/5">
                    <tr>
                        <th class="py-2">Name</th>
                        <th class="py-2">Slug</th>
                        <th class="py-2">Features</th>
                        <th class="py-2 text-right">Edit price / duration</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @foreach($licenseTiers as $t)
                        <tr>
                            <td class="py-3">{{ $t->name }}</td>
                            <td class="py-3 text-xs font-mono text-white/50">{{ $t->slug }}</td>
                            <td class="py-3 text-xs text-white/60">{{ implode(' • ', $t->features ?? []) }}</td>
                            <td class="py-3">
                                <form method="POST" action="{{ route('admin.lookups.license-tiers.update', $t->id) }}" class="flex gap-2 justify-end">
                                    @csrf
                                    <span class="self-center text-white/40">$</span>
                                    <input type="number" step="0.01" name="default_price" value="{{ $t->default_price }}"
                                           class="bg-[#0F0F0F] border border-white/10 rounded px-2 py-1 text-sm w-24">
                                    <input type="number" name="default_duration_months" value="{{ $t->default_duration_months }}" placeholder="months"
                                           class="bg-[#0F0F0F] border border-white/10 rounded px-2 py-1 text-sm w-20">
                                    <button class="bg-accent text-white px-3 py-1 rounded text-xs">Save</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Agreement Templates --}}
    <div class="admin-card p-6 lg:col-span-2">
        <h3 class="font-semibold mb-4 flex items-center gap-2"><i class="fa-solid fa-file-contract text-accent"></i> Agreement Templates</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="text-xs uppercase tracking-wider text-white/40 border-b border-white/5">
                    <tr>
                        <th class="py-2">Name</th>
                        <th class="py-2">Category</th>
                        <th class="py-2">Type</th>
                        <th class="py-2">Source</th>
                        <th class="py-2 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @foreach($agreementTemplates as $t)
                        <tr>
                            <td class="py-3">{{ $t->name }}</td>
                            <td class="py-3">{{ $t->category }}</td>
                            <td class="py-3">{{ $t->type }}</td>
                            <td class="py-3">
                                @if($t->is_system)
                                    <span class="text-[10px] uppercase tracking-wider bg-blue-500/10 text-blue-400 px-2 py-1 rounded">System</span>
                                @else
                                    <span class="text-[10px] uppercase tracking-wider bg-white/5 px-2 py-1 rounded">User #{{ $t->user_id }}</span>
                                @endif
                            </td>
                            <td class="py-3 text-right">
                                @if(! $t->is_system)
                                    <form method="POST" action="{{ route('admin.lookups.agreement-templates.delete', $t->id) }}" onsubmit="return confirm('Delete {{ $t->name }}?');" class="inline">
                                        @csrf
                                        <button class="w-8 h-8 rounded hover:bg-red-500/10 hover:text-red-400 text-gray-500"><i class="fa-solid fa-trash text-xs"></i></button>
                                    </form>
                                @else
                                    <span class="text-xs text-white/30 italic">protected</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
