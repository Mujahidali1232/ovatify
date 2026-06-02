@extends('layouts.admin')
@section('title', 'AI Tasks')
@section('page_title', 'AI Tasks')

@section('content')
<div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6">
    @foreach($byTool as $t)
        <div class="admin-card p-4">
            <p class="text-xs text-white/40 uppercase tracking-wider mb-1">{{ str_replace('-', ' ', $t->tool) }}</p>
            <p class="text-xl font-bold">{{ number_format($t->count) }}</p>
        </div>
    @endforeach
    @if($byTool->isEmpty())
        <div class="col-span-full admin-card p-4 text-center text-white/40">No AI tasks yet.</div>
    @endif
</div>

<form method="GET" class="mb-6 flex gap-3">
    <select name="tool" class="bg-[#252525] border border-white/5 rounded-xl py-3 px-4 text-sm">
        <option value="">All tools</option>
        @foreach(['vocal-enhancer','melody-generator','hook-generator','genre-matcher','mood-analyzer','mixing-assistant','mastering-tool','lyric-generator'] as $tool)
            <option value="{{ $tool }}" @selected(request('tool')===$tool)>{{ str_replace('-', ' ', $tool) }}</option>
        @endforeach
    </select>
    <select name="status" class="bg-[#252525] border border-white/5 rounded-xl py-3 px-4 text-sm">
        <option value="">All statuses</option>
        @foreach(['pending','processing','completed','failed'] as $s)
            <option value="{{ $s }}" @selected(request('status')===$s)>{{ ucfirst($s) }}</option>
        @endforeach
    </select>
    <button class="bg-accent text-white px-6 py-3 rounded-xl text-sm font-semibold hover:opacity-90">Apply</button>
    <a href="{{ route('admin.ai-tasks') }}" class="px-4 py-3 text-sm text-white/60 hover:text-white">Clear</a>
</form>

<div class="admin-card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-white/5 text-gray-400 text-xs uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-3 font-semibold">ID</th>
                    <th class="px-6 py-3 font-semibold">User</th>
                    <th class="px-6 py-3 font-semibold">Tool</th>
                    <th class="px-6 py-3 font-semibold">Status</th>
                    <th class="px-6 py-3 font-semibold">Created</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse($tasks as $t)
                    <tr class="table-row">
                        <td class="px-6 py-3 text-xs font-mono text-white/60">#{{ $t->id }}</td>
                        <td class="px-6 py-3 text-sm">{{ $t->user?->username ?? '—' }}</td>
                        <td class="px-6 py-3 text-sm">{{ str_replace('-', ' ', $t->tool) }}</td>
                        <td class="px-6 py-3">
                            @php
                                $c = match($t->status) {
                                    'completed' => 'bg-green-500/10 text-green-400',
                                    'failed' => 'bg-red-500/10 text-red-400',
                                    'processing' => 'bg-yellow-500/10 text-yellow-400',
                                    default => 'bg-gray-500/10 text-gray-400',
                                };
                            @endphp
                            <span class="text-[10px] uppercase tracking-wider px-2 py-1 rounded {{ $c }}">{{ $t->status }}</span>
                        </td>
                        <td class="px-6 py-3 text-sm text-gray-400">{{ $t->created_at?->diffForHumans() }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-6 py-12 text-center text-white/40">No AI tasks found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-4 border-t border-white/5">{{ $tasks->links() }}</div>
</div>
@endsection
