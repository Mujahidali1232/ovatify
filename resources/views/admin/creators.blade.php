@extends('layouts.admin')
@section('title', 'Creators')
@section('page_title', 'Creators')

@section('content')
<form method="GET" class="mb-6 flex flex-col md:flex-row gap-3">
    <div class="relative flex-1">
        <i class="fa-solid fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-500"></i>
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Search creators by name or email"
               class="w-full bg-[#252525] border border-white/5 rounded-xl py-3 pl-12 pr-4 text-sm focus:outline-none focus:border-accent/50">
    </div>
    <button class="bg-accent text-white px-6 py-3 rounded-xl text-sm font-semibold hover:opacity-90">Search</button>
</form>

<div class="admin-card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-white/5 text-gray-400 text-xs uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-3 font-semibold">Creator</th>
                    <th class="px-6 py-3 font-semibold">Email</th>
                    <th class="px-6 py-3 font-semibold">Tracks</th>
                    <th class="px-6 py-3 font-semibold">Status</th>
                    <th class="px-6 py-3 font-semibold">Verified</th>
                    <th class="px-6 py-3 font-semibold">Joined</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse($creators as $c)
                    <tr class="table-row">
                        <td class="px-6 py-3">
                            <div class="flex items-center gap-3">
                                <img src="{{ $c->profile_image ? (str_starts_with($c->profile_image, 'http') ? $c->profile_image : asset('storage/' . $c->profile_image)) : 'https://ui-avatars.com/api/?name='.urlencode($c->username).'&background=FF00FF&color=fff' }}" class="w-9 h-9 rounded-full" alt="">
                                <div>
                                    <p class="text-sm font-semibold">{{ $c->username }}</p>
                                    <p class="text-[10px] text-gray-600 font-mono">ID #{{ $c->id }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-3 text-sm text-gray-300">{{ $c->email }}</td>
                        <td class="px-6 py-3 text-sm">{{ $c->marketplace_assets_count }}</td>
                        <td class="px-6 py-3">
                            <span class="text-[10px] font-bold uppercase px-2 py-1 rounded-full {{ $c->is_active ? 'bg-green-500/10 text-green-500' : 'bg-red-500/10 text-red-500' }}">{{ $c->is_active ? 'Active' : 'Inactive' }}</span>
                        </td>
                        <td class="px-6 py-3">
                            @if($c->is_verified) <i class="fa-solid fa-circle-check text-blue-400"></i> @else <span class="text-white/30 text-xs">—</span> @endif
                        </td>
                        <td class="px-6 py-3 text-sm text-gray-400">{{ $c->created_at?->diffForHumans() }}</td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-6 py-12 text-center text-white/40">No creators yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-4 border-t border-white/5">{{ $creators->links() }}</div>
</div>
@endsection
