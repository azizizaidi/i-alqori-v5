<div>
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Transaction History</h2>
        <input type="text" wire:model.live="search" placeholder="Search..." class="input input-bordered input-sm w-64" />
    </div>

    <div class="overflow-x-auto">
        <table class="table table-zebra">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Date</th>
                    <th>Amount</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->id }}</td>
                        <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                        <td class="font-bold">RM {{ number_format($transaction->amount, 2) }}</td>
                        <td>{{ $transaction->description ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">No transactions found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $transactions->links() }}</div>
</div>
