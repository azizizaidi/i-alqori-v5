<div>
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Student Fees</h2>
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
                @foreach($fees as $fee)
                    <tr>
                        <td>{{ $fee->id }}</td>
                        <td>{{ $fee->registrar?->user?->name ?? 'N/A' }}</td>
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
