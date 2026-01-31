<div>
    <h2 class="text-2xl font-bold mb-6">Admin Dashboard</h2>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="stat bg-primary text-primary-content rounded-lg">
            <div class="stat-title">Total Fee (Dec 2025)</div>
            <div class="stat-value text-3xl">RM {{ $stats['totalFee'] }}</div>
        </div>
        <div class="stat bg-secondary text-secondary-content rounded-lg">
            <div class="stat-title">Total Allowance (Dec 2025)</div>
            <div class="stat-value text-3xl">RM {{ $stats['totalAllowance'] }}</div>
        </div>
        <div class="stat bg-accent text-accent-content rounded-lg">
            <div class="stat-title">Overdue Balance (Dec 2025)</div>
            <div class="stat-value text-3xl">RM {{ $stats['overdueBalance'] }}</div>
        </div>
        <div class="stat bg-neutral text-neutral-content rounded-lg">
            <div class="stat-title">Users / Teachers / Clients</div>
            <div class="stat-value text-3xl">{{ $userCount }} / {{ $teacherCount }} / {{ $clientCount }}</div>
        </div>
    </div>

    <!-- Overdue Payments -->
    <div class="card bg-base-100 shadow-lg">
        <div class="card-body">
            <h3 class="card-title">Top 10 Overdue Payments (Dec 2025)</h3>
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Registrar</th>
                            <th>Class</th>
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
                                <td>{{ number_format($payment->fee_student, 2) }}</td>
                                <td>
                                    <span class="badge badge-error">
                                        @switch($payment->status)
                                            @case(0) Pending @break
                                            @case(2) Partial @break
                                            @case(3) Overdue @break
                                            @case(4) Cancelled @break
                                            @case(5) Refunded @break
                                            @default Unknown @break
                                        @endswitch
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No overdue payments</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
