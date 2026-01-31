<div>
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Overdue Payment List</h2>
        <div class="flex gap-2">
            <input type="text" wire:model.live="search" placeholder="Search..." class="input input-bordered input-sm w-64" />
            <select wire:model.live="monthFilter" class="select select-bordered select-sm">
                <option value="">All Months</option>
                @for($i = 0; $i < 12; $i++)
                    <option value="{{ now()->subMonths($i)->format('m-Y') }}">{{ now()->subMonths($i)->format('m/Y') }}</option>
                @endfor
            </select>
        </div>
    </div>

    <!-- Summary -->
    <div class="alert alert-error mb-4">
        <span>Total Overdue: <strong>RM {{ number_format($totalOverdue, 2) }}</strong></span>
    </div>

    <div class="overflow-x-auto">
        <table class="table table-zebra">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Registrar</th>
                    <th>Class</th>
                    <th>Month</th>
                    <th>Fee (RM)</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($overduePayments as $payment)
                    <tr>
                        <td>{{ $payment->id }}</td>
                        <td>{{ $payment->registrar?->user?->name ?? 'N/A' }}</td>
                        <td>{{ $payment->className?->name ?? 'N/A' }}</td>
                        <td>{{ $payment->month }}</td>
                        <td class="font-bold">{{ number_format($payment->fee_student, 2) }}</td>
                        <td>
                            <span class="badge badge-error">Overdue</span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No overdue payments found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $overduePayments->links() }}</div>
</div>
