@extends('layouts.admin')
@section('title', 'Collab Requests')
@section('page_title', 'Collab Requests')

@section('content')
<div class="grid grid-cols-3 gap-4 mb-6">
    <div class="admin-card p-4"><p class="text-xs text-white/40 uppercase tracking-wider mb-1">Pending</p><p class="text-2xl font-bold text-yellow-300">{{ $stats['pending'] }}</p></div>
    <div class="admin-card p-4"><p class="text-xs text-white/40 uppercase tracking-wider mb-1">Accepted</p><p class="text-2xl font-bold text-green-300">{{ $stats['accepted'] }}</p></div>
    <div class="admin-card p-4"><p class="text-xs text-white/40 uppercase tracking-wider mb-1">Declined</p><p class="text-2xl font-bold text-red-300">{{ $stats['declined'] }}</p></div>
</div>

<form method="GET" class="mb-6 flex gap-3">
    <select name="status" class="bg-[#252525] border border-white/5 rounded-xl py-3 px-4 text-sm">
        <option value="">All statuses</option>
        @foreach(['pending','accepted','declined','withdrawn'] as $s)
            <option value="{{ $s }}" @selected(request('status')===$s)>{{ ucfirst($s) }}</option>
        @endforeach
    </select>
    <button class="bg-accent text-white px-6 py-3 rounded-xl text-sm font-semibold hover:opacity-90">Filter</button>
    <a href="{{ route('admin.collab-requests') }}" class="px-4 py-3 text-sm text-white/60 hover:text-white">Clear</a>
</form>

<div class="admin-card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-white/5 text-gray-400 text-xs uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-3 font-semibold">ID</th>
                    <th class="px-6 py-3 font-semibold">From → To</th>
                    <th class="px-6 py-3 font-semibold">Title</th>
                    <th class="px-6 py-3 font-semibold">Role</th>
                    <th class="px-6 py-3 font-semibold">Track</th>
                    <th class="px-6 py-3 font-semibold">Status</th>
                    <th class="px-6 py-3 font-semibold">Created</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse($collabs as $c)
                    <tr class="table-row">
                        <td class="px-6 py-3 text-xs font-mono text-white/60">#{{ $c->id }}</td>
                        <td class="px-6 py-3 text-sm">{{ $c->fromUser?->username ?? '—' }} <span class="text-white/30">→</span> {{ $c->toUser?->username ?? '—' }}</td>
                        <td class="px-6 py-3 text-sm">{{ $c->title }}</td>
                        <td class="px-6 py-3 text-sm capitalize">{{ $c->role }}</td>
                        <td class="px-6 py-3 text-sm">{{ $c->song?->title ?? '—' }}</td>
                        <td class="px-6 py-3">
                            @php
                                $cl = match($c->status) {
                                    'accepted' => 'bg-green-500/10 text-green-400',
                                    'declined','withdrawn' => 'bg-red-500/10 text-red-400',
                                    default => 'bg-yellow-500/10 text-yellow-400',
                                };
                            @endphp
                            <span class="text-[10px] uppercase tracking-wider px-2 py-1 rounded {{ $cl }}">{{ $c->status }}</span>
                        </td>
                        <td class="px-6 py-3 text-sm text-gray-400">{{ $c->created_at?->diffForHumans() }}</td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="px-6 py-12 text-center text-white/40">No collab requests.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-4 border-t border-white/5">{{ $collabs->links() }}</div>
</div>
@endsection
