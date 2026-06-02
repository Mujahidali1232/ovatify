@extends('layouts.admin')
@section('title', 'Distributions Queue')
@section('page_title', 'Distributions Queue')

@section('content')
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <div class="admin-card p-4"><p class="text-xs text-white/40 uppercase tracking-wider mb-1">Pending</p><p class="text-2xl font-bold text-yellow-300">{{ $stats['pending'] }}</p></div>
    <div class="admin-card p-4"><p class="text-xs text-white/40 uppercase tracking-wider mb-1">Processing</p><p class="text-2xl font-bold text-blue-300">{{ $stats['processing'] }}</p></div>
    <div class="admin-card p-4"><p class="text-xs text-white/40 uppercase tracking-wider mb-1">Distributed</p><p class="text-2xl font-bold text-green-300">{{ $stats['distributed'] }}</p></div>
    <div class="admin-card p-4"><p class="text-xs text-white/40 uppercase tracking-wider mb-1">Failed</p><p class="text-2xl font-bold text-red-300">{{ $stats['failed'] }}</p></div>
</div>

<form method="GET" class="mb-6 flex gap-3">
    <select name="status" class="bg-[#252525] border border-white/5 rounded-xl py-3 px-4 text-sm">
        @foreach(['pending','processing','distributed','failed'] as $s)
            <option value="{{ $s }}" @selected(request('status', 'pending')===$s)>{{ ucfirst($s) }}</option>
        @endforeach
    </select>
    <button class="bg-accent text-white px-6 py-3 rounded-xl text-sm font-semibold hover:opacity-90">Filter</button>
</form>

<div class="admin-card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-white/5 text-gray-400 text-xs uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-3 font-semibold">ID</th>
                    <th class="px-6 py-3 font-semibold">Track</th>
                    <th class="px-6 py-3 font-semibold">Release Title</th>
                    <th class="px-6 py-3 font-semibold">Artist</th>
                    <th class="px-6 py-3 font-semibold">Platforms</th>
                    <th class="px-6 py-3 font-semibold">Submitted By</th>
                    <th class="px-6 py-3 font-semibold">Status</th>
                    <th class="px-6 py-3 font-semibold text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse($distributions as $d)
                    <tr class="table-row">
                        <td class="px-6 py-3 text-xs font-mono text-white/60">#{{ $d->id }}</td>
                        <td class="px-6 py-3">
                            <div class="flex items-center gap-2">
                                @if($d->songGeneration?->cover_image)
                                    <img src="{{ asset('storage/'.$d->songGeneration->cover_image) }}" class="w-8 h-8 rounded object-cover" alt="">
                                @endif
                                <span class="text-sm">{{ $d->songGeneration?->title ?? '#'.$d->song_generation_id }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-3 text-sm">{{ $d->release_title }}</td>
                        <td class="px-6 py-3 text-sm">{{ $d->artist_name }}</td>
                        <td class="px-6 py-3 text-xs">
                            @foreach((array)($d->platforms ?? []) as $p)
                                <span class="inline-block px-2 py-1 rounded bg-white/5 mr-1 mb-1">{{ $p }}</span>
                            @endforeach
                        </td>
                        <td class="px-6 py-3 text-sm">{{ $d->user?->username ?? '—' }}</td>
                        <td class="px-6 py-3">
                            @php
                                $c = match($d->status) {
                                    'distributed' => 'bg-green-500/10 text-green-400',
                                    'failed' => 'bg-red-500/10 text-red-400',
                                    'processing' => 'bg-blue-500/10 text-blue-400',
                                    default => 'bg-yellow-500/10 text-yellow-400',
                                };
                            @endphp
                            <span class="text-[10px] uppercase tracking-wider px-2 py-1 rounded {{ $c }}">{{ $d->status }}</span>
                        </td>
                        <td class="px-6 py-3 text-right">
                            @if($d->status !== 'distributed')
                                <form method="POST" action="{{ route('admin.distributions.action', $d->id) }}" class="inline">
                                    @csrf
                                    <input type="hidden" name="action" value="mark_processing">
                                    <button title="Mark processing" class="w-8 h-8 rounded-lg hover:bg-blue-500/10 hover:text-blue-400 text-gray-500"><i class="fa-solid fa-spinner text-xs"></i></button>
                                </form>
                                <form method="POST" action="{{ route('admin.distributions.action', $d->id) }}" class="inline">
                                    @csrf
                                    <input type="hidden" name="action" value="mark_distributed">
                                    <button title="Mark distributed" class="w-8 h-8 rounded-lg hover:bg-green-500/10 hover:text-green-400 text-gray-500"><i class="fa-solid fa-check text-xs"></i></button>
                                </form>
                                <form method="POST" action="{{ route('admin.distributions.action', $d->id) }}" class="inline">
                                    @csrf
                                    <input type="hidden" name="action" value="mark_failed">
                                    <button title="Mark failed" class="w-8 h-8 rounded-lg hover:bg-red-500/10 hover:text-red-400 text-gray-500"><i class="fa-solid fa-xmark text-xs"></i></button>
                                </form>
                            @else
                                <span class="text-xs text-white/30 italic">done</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="px-6 py-12 text-center text-white/40">No distribution requests at this status.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-4 border-t border-white/5">{{ $distributions->links() }}</div>
</div>
@endsection
