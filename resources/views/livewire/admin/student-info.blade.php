<div>
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Student Info</h2>
        <div class="flex gap-2">
            <input type="text" wire:model.live="search" placeholder="Search..." class="input input-bordered input-sm w-64" />
            <select wire:model.live="ageStageFilter" class="select select-bordered select-sm">
                <option value="">All Ages</option>
                <option value="kanak-kanak">Kanak-kanak</option>
                <option value="remaja">Remaja</option>
                <option value="dewasa">Dewasa</option>
            </select>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="table table-zebra">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Age Stage</th>
                    <th>Note</th>
                    <th>Registrar</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $student)
                    <tr>
                        <td>{{ $student->id }}</td>
                        <td>{{ $student->code }}</td>
                        <td>{{ $student->user?->name ?? 'N/A' }}</td>
                        <td>
                            <span class="badge badge-outline">
                                {{ $student->age_stage }}
                            </span>
                        </td>
                        <td class="max-w-xs truncate">{{ $student->note ?? '-' }}</td>
                        <td>{{ $student->registrar?->user?->name ?? 'N/A' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $students->links() }}</div>
</div>
