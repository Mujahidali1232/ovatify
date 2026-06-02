@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page_title', 'Dashboard')

@section('content')
    {{-- KPI Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        @php
            $kpis = [
                ['label' => 'Total Users',        'value' => number_format($stats['total_users']),         'icon' => 'fa-users',          'color' => 'text-blue-400',    'sub' => '+'.$stats['new_users_30d'].' last 30d'],
                ['label' => 'Tracks Uploaded',    'value' => number_format($stats['total_tracks']),        'icon' => 'fa-music',          'color' => 'text-purple-400',  'sub' => '+'.$stats['new_tracks_30d'].' last 30d'],
                ['label' => 'Platform Revenue',   'value' => '$'.number_format($stats['platform_fee'], 2), 'icon' => 'fa-wallet',         'color' => 'text-green-400',   'sub' => 'of $'.number_format($stats['total_revenue'], 2).' gross'],
                ['label' => 'Active Assets',      'value' => number_format($stats['total_active_assets']), 'icon' => 'fa-circle-check',   'color' => 'text-pink-400',    'sub' => $stats['total_creators'].' creators'],
            ];
        @endphp
        @foreach($kpis as $k)
            <div class="admin-card stat-card p-5">
                <div class="flex items-start justify-between mb-3">
                    <span class="text-xs uppercase tracking-wider text-white/40 font-medium">{{ $k['label'] }}</span>
                    <i class="fa-solid {{ $k['icon'] }} {{ $k['color'] }}"></i>
                </div>
                <p class="text-2xl lg:text-3xl font-bold">{{ $k['value'] }}</p>
                <p class="text-xs text-white/40 mt-1">{{ $k['sub'] }}</p>
            </div>
        @endforeach
    </div>

    {{-- Action banner / pending queues --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        <a href="{{ route('admin.distributions') }}" class="admin-card p-5 hover:border-accent/30 transition-colors flex items-center justify-between">
            <div>
                <p class="text-xs uppercase tracking-wider text-white/40 font-medium mb-1">Pending Distributions</p>
                <p class="text-2xl font-bold">{{ $stats['pending_distributions'] }}</p>
            </div>
            <i class="fa-solid fa-tower-broadcast text-3xl text-accent/50"></i>
        </a>
        <a href="{{ route('admin.collab-requests') }}" class="admin-card p-5 hover:border-accent/30 transition-colors flex items-center justify-between">
            <div>
                <p class="text-xs uppercase tracking-wider text-white/40 font-medium mb-1">Pending Collab Requests</p>
                <p class="text-2xl font-bold">{{ $stats['pending_collabs'] }}</p>
            </div>
            <i class="fa-solid fa-handshake text-3xl text-accent/50"></i>
        </a>
        <a href="{{ route('admin.creators') }}" class="admin-card p-5 hover:border-accent/30 transition-colors flex items-center justify-between">
            <div>
                <p class="text-xs uppercase tracking-wider text-white/40 font-medium mb-1">Total Creators</p>
                <p class="text-2xl font-bold">{{ $stats['total_creators'] }}</p>
            </div>
            <i class="fa-solid fa-microphone-lines text-3xl text-accent/50"></i>
        </a>
    </div>

    {{-- Charts --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <div class="admin-card p-6 lg:col-span-2">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold">Revenue — Last 30 days</h3>
                <span class="text-xs text-white/40">Gross transaction amount</span>
            </div>
            <div class="h-64"><canvas id="revenueChart"></canvas></div>
        </div>
        <div class="admin-card p-6">
            <h3 class="font-semibold mb-4">Transaction Mix</h3>
            <div class="h-64"><canvas id="txMixChart"></canvas></div>
        </div>
    </div>

    {{-- Recent activity --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="admin-card p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold">Recent Users</h3>
                <a href="{{ route('admin.users') }}" class="text-xs text-accent hover:underline">View all</a>
            </div>
            <div class="divide-y divide-white/5">
                @forelse($recentUsers as $u)
                    <div class="py-3 flex items-center gap-3">
                        <img src="{{ $u->profile_image ? (str_starts_with($u->profile_image, 'http') ? $u->profile_image : asset('storage/'.$u->profile_image)) : 'https://ui-avatars.com/api/?name='.urlencode($u->username).'&background=random' }}" class="w-9 h-9 rounded-full" alt="">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium truncate">{{ $u->username }}</p>
                            <p class="text-xs text-white/40 truncate">{{ $u->email }}</p>
                        </div>
                        <span class="text-[10px] uppercase tracking-wider px-2 py-1 rounded {{ $u->role === 'admin' ? 'bg-pink-500/10 text-pink-300' : ($u->role === 'creator' ? 'bg-blue-500/10 text-blue-300' : 'bg-gray-500/10 text-gray-300') }}">{{ $u->role }}</span>
                    </div>
                @empty
                    <p class="text-sm text-white/40 py-6 text-center">No users yet.</p>
                @endforelse
            </div>
        </div>

        <div class="admin-card p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold">Recent Transactions</h3>
                <a href="{{ route('admin.transactions') }}" class="text-xs text-accent hover:underline">View all</a>
            </div>
            <div class="divide-y divide-white/5">
                @forelse($recentTransactions as $t)
                    <div class="py-3 flex items-center justify-between gap-3">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm truncate">{{ $t->asset?->title ?? 'Asset #'.$t->marketplace_asset_id }}</p>
                            <p class="text-xs text-white/40">{{ $t->buyer?->username ?? '—' }} • {{ ucfirst($t->transaction_type) }} • {{ $t->created_at?->diffForHumans() }}</p>
                        </div>
                        <span class="text-sm font-mono">${{ number_format($t->amount, 2) }}</span>
                    </div>
                @empty
                    <p class="text-sm text-white/40 py-6 text-center">No transactions yet.</p>
                @endforelse
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        Chart.defaults.color = '#666';
        Chart.defaults.borderColor = 'rgba(255,255,255,0.05)';

        new Chart(document.getElementById('revenueChart'), {
            type: 'line',
            data: {
                labels: @json($labels),
                datasets: [{
                    label: 'Revenue',
                    data: @json($revenues),
                    fill: true,
                    backgroundColor: 'rgba(255, 0, 255, 0.08)',
                    borderColor: '#FF00FF',
                    tension: 0.35,
                    pointRadius: 0,
                    pointHoverRadius: 4,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { grid: { display: false } },
                    y: { ticks: { callback: v => '$'+v } }
                }
            }
        });

        new Chart(document.getElementById('txMixChart'), {
            type: 'doughnut',
            data: {
                labels: @json($txTypes->pluck('transaction_type')->map(fn($x) => ucfirst($x))),
                datasets: [{
                    data: @json($txTypes->pluck('count')),
                    backgroundColor: ['#FF00FF', '#5c67ff', '#4ade80', '#facc15'],
                    borderWidth: 0,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'bottom', labels: { boxWidth: 12, padding: 12 } } }
            }
        });
    </script>
    @endpush
@endsection
