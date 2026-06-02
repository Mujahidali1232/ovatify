@extends('layouts.admin')
@section('title', 'Transactions')
@section('page_title', 'Marketplace Transactions')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="admin-card p-5"><p class="text-xs text-white/40 uppercase tracking-wider mb-1">All-time gross</p><p class="text-2xl font-bold">${{ number_format($totals['all_time'], 2) }}</p></div>
    <div class="admin-card p-5"><p class="text-xs text-white/40 uppercase tracking-wider mb-1">This month</p><p class="text-2xl font-bold">${{ number_format($totals['this_month'], 2) }}</p></div>
    <div class="admin-card p-5"><p class="text-xs text-white/40 uppercase tracking-wider mb-1">Platform fees</p><p class="text-2xl font-bold text-accent">${{ number_format($totals['platform_fees'], 2) }}</p></div>
</div>

<form method="GET" class="mb-6 flex flex-wrap gap-3">
    <select name="type" class="bg-[#252525] border border-white/5 rounded-xl py-3 px-4 text-sm">
        <option value="">All types</option>
        @foreach(['purchase','license','investment'] as $t)
            <option value="{{ $t }}" @selected(request('type')===$t)>{{ ucfirst($t) }}</option>
        @endforeach
    </select>
    <select name="status" class="bg-[#252525] border border-white/5 rounded-xl py-3 px-4 text-sm">
        <option value="">All statuses</option>
        @foreach(['pending','completed','failed','refunded'] as $s)
            <option value="{{ $s }}" @selected(request('status')===$s)>{{ ucfirst($s) }}</option>
        @endforeach
    </select>
    <button class="bg-accent text-white px-6 py-3 rounded-xl text-sm font-semibold hover:opacity-90">Apply</button>
    <a href="{{ route('admin.transactions') }}" class="px-4 py-3 text-sm text-white/60 hover:text-white">Clear</a>
</form>

<div class="admin-card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-white/5 text-gray-400 text-xs uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-3 font-semibold">Ref</th>
                    <th class="px-6 py-3 font-semibold">Type</th>
                    <th class="px-6 py-3 font-semibold">Buyer</th>
                    <th class="px-6 py-3 font-semibold">Seller</th>
                    <th class="px-6 py-3 font-semibold">Asset</th>
                    <th class="px-6 py-3 font-semibold text-right">Amount</th>
                    <th class="px-6 py-3 font-semibold text-right">Seller</th>
                    <th class="px-6 py-3 font-semibold text-right">Fee</th>
                    <th class="px-6 py-3 font-semibold">Status</th>
                    <th class="px-6 py-3 font-semibold">When</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse($transactions as $t)
                    <tr class="table-row">
                        <td class="px-6 py-3 text-[11px] font-mono text-white/60">{{ $t->transaction_reference ?? '#'.$t->id }}</td>
                        <td class="px-6 py-3 text-sm capitalize">{{ $t->transaction_type }}</td>
                        <td class="px-6 py-3 text-sm">{{ $t->buyer?->username ?? '—' }}</td>
                        <td class="px-6 py-3 text-sm">{{ $t->seller?->username ?? '—' }}</td>
                        <td class="px-6 py-3 text-sm">{{ $t->asset?->title ?? '#'.$t->marketplace_asset_id }}</td>
                        <td class="px-6 py-3 text-sm text-right font-mono">${{ number_format($t->amount, 2) }}</td>
                        <td class="px-6 py-3 text-sm text-right font-mono">${{ number_format($t->seller_amount, 2) }}</td>
                        <td class="px-6 py-3 text-sm text-right font-mono">${{ number_format($t->platform_fee, 2) }}</td>
                        <td class="px-6 py-3">
                            @php
                                $c = match($t->status) {
                                    'completed' => 'bg-green-500/10 text-green-400',
                                    'failed' => 'bg-red-500/10 text-red-400',
                                    'refunded' => 'bg-yellow-500/10 text-yellow-400',
                                    default => 'bg-gray-500/10 text-gray-400',
                                };
                            @endphp
                            <span class="text-[10px] uppercase tracking-wider px-2 py-1 rounded {{ $c }}">{{ $t->status }}</span>
                        </td>
                        <td class="px-6 py-3 text-sm text-gray-400">{{ $t->created_at?->diffForHumans() }}</td>
                    </tr>
                @empty
                    <tr><td colspan="10" class="px-6 py-12 text-center text-white/40">No transactions yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-4 border-t border-white/5">{{ $transactions->links() }}</div>
</div>
@endsection
