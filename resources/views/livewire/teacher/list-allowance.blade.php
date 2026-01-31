<div>
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Allowance Records</h2>
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

    <!-- Summary Card -->
    <div class="stat bg-primary text-primary-content rounded-lg mb-6">
        <div class="stat-title">Total Allowance</div>
        <div class="stat-value text-3xl">RM {{ number_format($totalAllowance, 2) }}</div>
    </div>

    <div class="overflow-x-auto">
        <table class="table table-zebra">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Class</th>
                    <th>Month</th>
                    <th>Hours</th>
                    <th>Allowance (RM)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($allowances as $allowance)
                    <tr>
                        <td>{{ $allowance->id }}</td>
                        <td>{{ $allowance->className?->name ?? 'N/A' }}</td>
                        <td>{{ $allowance->month }}</td>
                        <td>{{ $allowance->total_hour }}</td>
                        <td>{{ number_format($allowance->allowance, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $allowances->links() }}</div>
</div>
