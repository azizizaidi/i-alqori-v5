<div>
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Record Student</h2>
        <input type="text" wire:model.live="search" placeholder="Search students..." class="input input-bordered input-sm w-64" />
    </div>

    <div class="overflow-x-auto">
        <table class="table table-zebra">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Code</th>
                    <th>Student Name</th>
                    <th>Age Stage</th>
                    <th>Registrar</th>
                    <th>Created</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $student)
                    <tr>
                        <td>{{ $student->id }}</td>
                        <td>{{ $student->code }}</td>
                        <td>{{ $student->user?->name ?? 'N/A' }}</td>
                        <td>{{ $student->age_stage }}</td>
                        <td>{{ $student->registrar?->user?->name ?? 'N/A' }}</td>
                        <td>{{ $student->created_at->format('d/m/Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $students->links() }}</div>
</div>
