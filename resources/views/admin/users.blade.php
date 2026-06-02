@extends('layouts.admin')
@section('title', 'Users')
@section('page_title', 'Users')

@section('content')
<form method="GET" action="{{ route('admin.users') }}" class="mb-6 grid grid-cols-1 md:grid-cols-5 gap-3">
    <div class="md:col-span-2 relative">
        <i class="fa-solid fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-500"></i>
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Search username / email / phone"
               class="w-full bg-[#252525] border border-white/5 rounded-xl py-3 pl-12 pr-4 text-sm focus:outline-none focus:border-accent/50 transition-colors">
    </div>
    <select name="role" class="bg-[#252525] border border-white/5 rounded-xl py-3 px-4 text-sm focus:outline-none focus:border-accent/50">
        <option value="">All roles</option>
        @foreach(['consumer','creator','admin'] as $r)
            <option value="{{ $r }}" @selected(request('role')===$r)>{{ ucfirst($r) }}</option>
        @endforeach
    </select>
    <select name="status" class="bg-[#252525] border border-white/5 rounded-xl py-3 px-4 text-sm">
        <option value="">All statuses</option>
        <option value="active" @selected(request('status')==='active')>Active</option>
        <option value="inactive" @selected(request('status')==='inactive')>Inactive</option>
    </select>
    <select name="verified" class="bg-[#252525] border border-white/5 rounded-xl py-3 px-4 text-sm">
        <option value="">All verification</option>
        <option value="yes" @selected(request('verified')==='yes')>Verified</option>
        <option value="no" @selected(request('verified')==='no')>Unverified</option>
    </select>
    <div class="md:col-span-5 flex justify-end gap-2">
        <a href="{{ route('admin.users') }}" class="px-4 py-2 text-sm text-white/60 hover:text-white">Clear</a>
        <button class="bg-accent text-white px-6 py-2 rounded-lg text-sm font-semibold hover:opacity-90">Apply</button>
    </div>
</form>

<div class="admin-card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-white/5 text-gray-400 text-xs uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-3 font-semibold">User</th>
                    <th class="px-6 py-3 font-semibold">Role</th>
                    <th class="px-6 py-3 font-semibold">Status</th>
                    <th class="px-6 py-3 font-semibold">Verified</th>
                    <th class="px-6 py-3 font-semibold">Tracks</th>
                    <th class="px-6 py-3 font-semibold">Joined</th>
                    <th class="px-6 py-3 font-semibold text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse($users as $u)
                <tr class="table-row">
                    <td class="px-6 py-3">
                        <div class="flex items-center gap-3">
                            <img src="{{ $u->profile_image ? (str_starts_with($u->profile_image, 'http') ? $u->profile_image : asset('storage/' . $u->profile_image)) : 'https://ui-avatars.com/api/?name='.urlencode($u->username).'&background=random' }}" class="w-9 h-9 rounded-full" alt="">
                            <div>
                                <p class="text-sm font-semibold">{{ $u->username }}</p>
                                <p class="text-xs text-gray-500">{{ $u->email }}</p>
                                <p class="text-[10px] text-gray-600 font-mono">ID #{{ $u->id }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-3">
                        <span class="text-[10px] uppercase tracking-wider px-2 py-1 rounded font-bold {{ $u->role === 'admin' ? 'bg-pink-500/10 text-pink-300' : ($u->role === 'creator' ? 'bg-blue-500/10 text-blue-300' : 'bg-gray-500/10 text-gray-300') }}">{{ $u->role }}</span>
                    </td>
                    <td class="px-6 py-3">
                        <span class="text-[10px] font-bold uppercase tracking-wide px-2 py-1 rounded-full {{ $u->is_active ? 'bg-green-500/10 text-green-500' : 'bg-red-500/10 text-red-500' }}">
                            {{ $u->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="px-6 py-3">
                        @if($u->is_verified)
                            <i class="fa-solid fa-circle-check text-blue-400" title="Verified"></i>
                        @else
                            <span class="text-white/30 text-xs">—</span>
                        @endif
                    </td>
                    <td class="px-6 py-3">
                        <span class="text-sm font-medium">{{ $u->marketplace_assets_count }}</span>
                    </td>
                    <td class="px-6 py-3 text-sm text-gray-400">{{ $u->created_at?->diffForHumans() }}</td>
                    <td class="px-6 py-3 text-right">
                        <div class="flex items-center justify-end gap-1">
                            @if($u->role !== 'admin')
                                <form action="{{ route('admin.users.verify', $u->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-blue-500/10 hover:text-blue-400 text-gray-500" title="Toggle verified">
                                        <i class="fa-solid fa-circle-check text-xs"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.users.toggle-status', $u->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-accent/10 hover:text-accent text-gray-500" title="Toggle active">
                                        <i class="fa-solid fa-power-off text-xs"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.users.delete', $u->id) }}" method="POST" onsubmit="return confirm('Delete {{ $u->username }}?');">
                                    @csrf
                                    <button type="submit" class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-red-500/10 hover:text-red-500 text-gray-500" title="Delete">
                                        <i class="fa-solid fa-trash text-xs"></i>
                                    </button>
                                </form>
                            @else
                                <span class="text-xs text-white/30 italic">protected</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                    <tr><td colspan="7" class="px-6 py-12 text-center text-white/40">No users match these filters.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-4 border-t border-white/5">{{ $users->links() }}</div>
</div>
@endsection
