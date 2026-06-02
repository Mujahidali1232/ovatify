@extends('layouts.admin')
@section('title', 'Tracks & Media')
@section('page_title', 'Tracks & Media')

@section('content')
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="admin-card p-4"><p class="text-xs text-white/40 uppercase tracking-wider mb-1">Total</p><p class="text-2xl font-bold">{{ number_format($stats['total']) }}</p></div>
    <div class="admin-card p-4"><p class="text-xs text-white/40 uppercase tracking-wider mb-1">Audio</p><p class="text-2xl font-bold text-blue-300">{{ number_format($stats['audio']) }}</p></div>
    <div class="admin-card p-4"><p class="text-xs text-white/40 uppercase tracking-wider mb-1">Video</p><p class="text-2xl font-bold text-purple-300">{{ number_format($stats['video']) }}</p></div>
    <div class="admin-card p-4"><p class="text-xs text-white/40 uppercase tracking-wider mb-1">Illustration</p><p class="text-2xl font-bold text-pink-300">{{ number_format($stats['illustration']) }}</p></div>
</div>

<form method="GET" class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-3">
    <div class="md:col-span-2 relative">
        <i class="fa-solid fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-500"></i>
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Search title / creator / description"
               class="w-full bg-[#252525] border border-white/5 rounded-xl py-3 pl-12 pr-4 text-sm focus:outline-none focus:border-accent/50">
    </div>
    <select name="type" class="bg-[#252525] border border-white/5 rounded-xl py-3 px-4 text-sm">
        <option value="">All media types</option>
        <option value="audio" @selected(request('type')==='audio')>Audio</option>
        <option value="video" @selected(request('type')==='video')>Video</option>
        <option value="illustration" @selected(request('type')==='illustration')>Illustration</option>
    </select>
    <select name="status" class="bg-[#252525] border border-white/5 rounded-xl py-3 px-4 text-sm">
        <option value="">All statuses</option>
        <option value="uploaded" @selected(request('status')==='uploaded')>Uploaded</option>
        <option value="processing" @selected(request('status')==='processing')>Processing</option>
        <option value="failed" @selected(request('status')==='failed')>Failed</option>
    </select>
    <div class="md:col-span-4 flex justify-end gap-2">
        <a href="{{ route('admin.tracks') }}" class="px-4 py-2 text-sm text-white/60 hover:text-white">Clear</a>
        <button class="bg-accent text-white px-6 py-2 rounded-lg text-sm font-semibold hover:opacity-90">Apply</button>
    </div>
</form>

<div class="admin-card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-white/5 text-gray-400 text-xs uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-3 font-semibold">Track</th>
                    <th class="px-6 py-3 font-semibold">Creator</th>
                    <th class="px-6 py-3 font-semibold">Type</th>
                    <th class="px-6 py-3 font-semibold">Genre</th>
                    <th class="px-6 py-3 font-semibold">Assets</th>
                    <th class="px-6 py-3 font-semibold">Created</th>
                    <th class="px-6 py-3 font-semibold text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse($tracks as $t)
                    <tr class="table-row">
                        <td class="px-6 py-3">
                            <div class="flex items-center gap-3">
                                <img src="{{ $t->cover_image ? asset('storage/'.$t->cover_image) : 'https://ui-avatars.com/api/?name='.urlencode($t->title ?? '?').'&background=222&color=fff' }}" class="w-12 h-12 rounded-lg object-cover" alt="">
                                <div>
                                    <p class="text-sm font-semibold">{{ $t->title ?? 'Untitled' }}</p>
                                    <p class="text-[10px] text-gray-600 font-mono">#{{ $t->id }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-3 text-sm">{{ $t->user?->username ?? '—' }}</td>
                        <td class="px-6 py-3 text-sm capitalize">{{ $t->file_type }}</td>
                        <td class="px-6 py-3 text-sm">{{ $t->genre ?: '—' }}</td>
                        <td class="px-6 py-3 text-xs">
                            @foreach($t->marketplaceAssets as $a)
                                <span class="inline-block px-2 py-1 rounded mr-1 mb-1 {{ $a->is_active ? 'bg-green-500/10 text-green-400' : 'bg-white/5 text-white/40' }}">{{ $a->sale_type }} ${{ number_format((float)($a->price ?: $a->price_per_license ?: $a->price_per_block), 0) }}</span>
                            @endforeach
                            @if($t->marketplaceAssets->isEmpty())<span class="text-white/30">—</span>@endif
                        </td>
                        <td class="px-6 py-3 text-sm text-gray-400">{{ $t->created_at?->diffForHumans() }}</td>
                        <td class="px-6 py-3 text-right">
                            <form action="{{ route('admin.tracks.delete', $t->id) }}" method="POST" onsubmit="return confirm('Delete this track?');" class="inline">
                                @csrf
                                <button class="w-8 h-8 rounded-lg hover:bg-red-500/10 hover:text-red-500 text-gray-500" title="Delete">
                                    <i class="fa-solid fa-trash text-xs"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="px-6 py-12 text-center text-white/40">No tracks match these filters.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-4 border-t border-white/5">{{ $tracks->links() }}</div>
</div>
@endsection
