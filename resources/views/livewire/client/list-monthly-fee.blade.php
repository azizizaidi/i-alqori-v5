<div>
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Monthly Fees</h2>
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

    <!-- Fee Summary -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="stat bg-primary text-primary-content rounded-lg">
            <div class="stat-title">Total Fee</div>
            <div class="stat-value text-2xl">RM {{ number_format($totalFee, 2) }}</div>
        </div>
        <div class="stat bg-success text-success-content rounded-lg">
            <div class="stat-title">Paid</div>
            <div class="stat-value text-2xl">RM {{ number_format($totalPaid, 2) }}</div>
        </div>
        <div class="stat bg-error text-error-content rounded-lg">
            <div class="stat-title">Unpaid</div>
            <div class="stat-value text-2xl">RM {{ number_format($totalUnpaid, 2) }}</div>
        </div>
    </div>

    @if($totalUnpaid > 0)
        <div class="alert alert-warning mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
            <span>You have unpaid fees. Please settle your balance.</span>
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="table table-zebra">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Class</th>
                    <th>Month</th>
                    <th>Fee (RM)</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($fees as $fee)
                    <tr>
                        <td>{{ $fee->id }}</td>
                        <td>{{ $fee->className?->name ?? 'N/A' }}</td>
                        <td>{{ $fee->month }}</td>
                        <td>{{ $fee->fee_student }}</td>
                        <td>
                            <span class="badge badge-sm
                                @switch($fee->status)
                                    @case(1) badge-success @break
                                    @case(0) badge-warning @break
                                    @default badge-error @break
                                @endswitch">
                                @switch($fee->status)
                                    @case(0) Unpaid @break
                                    @case(1) Paid @break
                                    @case(2) Partial @break
                                    @default Overdue @break
                                @endswitch
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $fees->links() }}</div>
</div>
