@extends('layouts.admin')
@section('title', 'Financials')
@section('page_title', 'Financials')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="admin-card p-5">
        <p class="text-xs uppercase tracking-wider text-white/40 mb-1">Total sales (gross)</p>
        <p class="text-2xl font-bold">${{ number_format($totals['total_sales'], 2) }}</p>
    </div>
    <div class="admin-card p-5">
        <p class="text-xs uppercase tracking-wider text-white/40 mb-1">Owed to sellers</p>
        <p class="text-2xl font-bold text-blue-300">${{ number_format($totals['total_payouts_due'], 2) }}</p>
    </div>
    <div class="admin-card p-5">
        <p class="text-xs uppercase tracking-wider text-white/40 mb-1">Platform revenue</p>
        <p class="text-2xl font-bold text-accent">${{ number_format($totals['platform_revenue'], 2) }}</p>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
    <div class="admin-card p-5"><p class="text-xs uppercase tracking-wider text-white/40 mb-1">Purchases</p><p class="text-xl font-bold">${{ number_format($totals['purchases'], 2) }}</p></div>
    <div class="admin-card p-5"><p class="text-xs uppercase tracking-wider text-white/40 mb-1">Licenses</p><p class="text-xl font-bold">${{ number_format($totals['licenses'], 2) }}</p></div>
    <div class="admin-card p-5"><p class="text-xs uppercase tracking-wider text-white/40 mb-1">Investments</p><p class="text-xl font-bold">${{ number_format($totals['investments'], 2) }}</p></div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="admin-card p-6 lg:col-span-2">
        <h3 class="font-semibold mb-4">Recent transactions</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="text-xs uppercase tracking-wider text-white/40 border-b border-white/5">
                    <tr>
                        <th class="py-2">Ref</th>
                        <th class="py-2">Type</th>
                        <th class="py-2">Buyer</th>
                        <th class="py-2 text-right">Amount</th>
                        <th class="py-2 text-right">Fee</th>
                        <th class="py-2">When</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($transactions as $tx)
                        <tr class="table-row">
                            <td class="py-2 text-[11px] font-mono text-white/50">{{ $tx->transaction_reference ?? '#'.$tx->id }}</td>
                            <td class="py-2 capitalize">{{ $tx->transaction_type }}</td>
                            <td class="py-2">{{ $tx->buyer?->username ?? '—' }}</td>
                            <td class="py-2 text-right font-mono">${{ number_format($tx->amount, 2) }}</td>
                            <td class="py-2 text-right font-mono text-white/60">${{ number_format($tx->platform_fee, 2) }}</td>
                            <td class="py-2 text-white/50">{{ $tx->created_at?->diffForHumans() }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="py-6 text-center text-white/40">No transactions yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $transactions->links() }}</div>
    </div>

    <div class="admin-card p-6">
        <h3 class="font-semibold mb-4">Top earning creators</h3>
        <div class="divide-y divide-white/5">
            @forelse($topCreators as $c)
                <div class="py-3 flex items-center gap-3">
                    <img src="{{ $c->profile_image ? (str_starts_with($c->profile_image, 'http') ? $c->profile_image : asset('storage/'.$c->profile_image)) : 'https://ui-avatars.com/api/?name='.urlencode($c->username).'&background=FF00FF&color=fff' }}" class="w-9 h-9 rounded-full" alt="">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium truncate">{{ $c->username }}</p>
                    </div>
                    <span class="text-sm font-mono">${{ number_format((float)$c->earnings, 2) }}</span>
                </div>
            @empty
                <p class="text-sm text-white/40 py-6 text-center">No earnings yet.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
