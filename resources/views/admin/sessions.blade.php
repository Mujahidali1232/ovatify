@extends('layouts.admin')
@section('title', 'Creator Sessions')
@section('page_title', 'Creator Sessions')

@section('content')
<div class="grid grid-cols-3 gap-4 mb-6">
    <div class="admin-card p-4"><p class="text-xs text-white/40 uppercase tracking-wider mb-1">Total Sessions</p><p class="text-2xl font-bold">{{ number_format($stats['total']) }}</p></div>
    <div class="admin-card p-4"><p class="text-xs text-white/40 uppercase tracking-wider mb-1">Drafts in progress</p><p class="text-2xl font-bold text-yellow-300">{{ number_format($stats['drafts']) }}</p></div>
    <div class="admin-card p-4"><p class="text-xs text-white/40 uppercase tracking-wider mb-1">Published</p><p class="text-2xl font-bold text-green-300">{{ number_format($stats['published']) }}</p></div>
</div>

<form method="GET" class="mb-6 flex gap-3">
    <select name="status" class="bg-[#252525] border border-white/5 rounded-xl py-3 px-4 text-sm">
        <option value="">All statuses</option>
        @foreach(['draft','ideas','customizing','mixing','arranging','completed','published'] as $s)
            <option value="{{ $s }}" @selected(request('status')===$s)>{{ ucfirst($s) }}</option>
        @endforeach
    </select>
    <button class="bg-accent text-white px-6 py-3 rounded-xl text-sm font-semibold hover:opacity-90">Apply</button>
    <a href="{{ route('admin.sessions') }}" class="px-4 py-3 text-sm text-white/60 hover:text-white">Clear</a>
</form>

<div class="admin-card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-white/5 text-gray-400 text-xs uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-3 font-semibold">Title</th>
                    <th class="px-6 py-3 font-semibold">Creator</th>
                    <th class="px-6 py-3 font-semibold">Type</th>
                    <th class="px-6 py-3 font-semibold">Genre</th>
                    <th class="px-6 py-3 font-semibold">Status</th>
                    <th class="px-6 py-3 font-semibold">Updated</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse($sessions as $s)
                    <tr class="table-row">
                        <td class="px-6 py-3">
                            <p class="text-sm font-semibold">{{ $s->title ?? 'Untitled draft' }}</p>
                            <p class="text-[10px] text-gray-600 font-mono">#{{ $s->id }}</p>
                        </td>
                        <td class="px-6 py-3 text-sm">{{ $s->user?->username ?? '—' }}</td>
                        <td class="px-6 py-3 text-sm capitalize">{{ $s->file_type }}</td>
                        <td class="px-6 py-3 text-sm">{{ $s->genre ?: '—' }}</td>
                        <td class="px-6 py-3">
                            @php
                                $color = match($s->status) {
                                    'published' => 'bg-green-500/10 text-green-400',
                                    'completed' => 'bg-blue-500/10 text-blue-400',
                                    'draft', 'ideas' => 'bg-gray-500/10 text-gray-400',
                                    default => 'bg-yellow-500/10 text-yellow-400',
                                };
                            @endphp
                            <span class="text-[10px] uppercase tracking-wider px-2 py-1 rounded {{ $color }}">{{ $s->status }}</span>
                        </td>
                        <td class="px-6 py-3 text-sm text-gray-400">{{ $s->updated_at?->diffForHumans() }}</td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-6 py-12 text-center text-white/40">No sessions found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-4 border-t border-white/5">{{ $sessions->links() }}</div>
</div>
@endsection
