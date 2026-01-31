<div>
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">My Classes</h2>
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
                    <th>Class</th>
                    <th>Month</th>
                    <th>Date</th>
                    <th>Hours</th>
                    <th>Fee (RM)</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($classes as $class)
                    <tr>
                        <td>{{ $class->id }}</td>
                        <td>{{ $class->className?->name ?? 'N/A' }}</td>
                        <td>{{ $class->month }}</td>
                        <td>{{ $class->date }}</td>
                        <td>{{ $class->total_hour }}</td>
                        <td>{{ $class->fee_student }}</td>
                        <td>
                            <span class="badge badge-sm
                                @switch($class->status)
                                    @case(1) badge-success @break
                                    @case(0) badge-warning @break
                                    @default badge-error @break
                                @endswitch">
                                @switch($class->status)
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

    <div class="mt-4">{{ $classes->links() }}</div>
</div>
