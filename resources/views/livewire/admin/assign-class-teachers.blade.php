<div>
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Assign Class Teachers</h2>
        <div class="flex gap-2">
            <input type="text" wire:model.live="search" placeholder="Search..." class="input input-bordered input-sm w-64" />
            <button wire:click="openModal()" class="btn btn-primary btn-sm">Add Assignment</button>
        </div>
    </div>

    @if (session()->has('success'))
        <div class="alert alert-success mb-4">{{ session('success') }}</div>
    @endif

    <div class="overflow-x-auto">
        <table class="table table-zebra">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Code</th>
                    <th>Teacher</th>
                    <th>Client</th>
                    <th>Classes</th>
                    <th>Package</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($assignments as $assignment)
                    <tr>
                        <td>{{ $assignment->id }}</td>
                        <td>{{ $assignment->assign_class_code }}</td>
                        <td>{{ $assignment->teacher?->user?->name ?? 'N/A' }}</td>
                        <td>{{ $assignment->registrar?->user?->name ?? 'N/A' }}</td>
                        <td>
                            @foreach($assignment->classNames as $class)
                                <span class="badge badge-info badge-sm">{{ $class->name }}</span>
                            @endforeach
                        </td>
                        <td>{{ $assignment->classPackage?->name ?? '-' }}</td>
                        <td>
                            <div class="flex gap-1">
                                <button wire:click="openModal({{ $assignment->id }})" class="btn btn-ghost btn-xs">Edit</button>
                                <button wire:click="delete({{ $assignment->id }})" class="btn btn-ghost btn-xs text-error">Delete</button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $assignments->links() }}</div>

    <!-- Modal -->
    <dialog class="modal" :class="{ 'modal-open': showModal }">
        <div class="modal-box max-w-2xl">
            <h3 class="font-bold text-lg">{{ $editingId ? 'Edit' : 'Add' }} Class Assignment</h3>
            <div class="py-4 space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label"><span class="label-text">Teacher</span></label>
                        <select wire:model="teacher_id" class="select select-bordered">
                            <option value="">Select Teacher</option>
                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}">{{ $teacher->user?->name }}</option>
                            @endforeach
                        </select>
                        @error('teacher_id') <span class="text-error text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-control">
                        <label class="label"><span class="label-text">Client</span></label>
                        <select wire:model="registrar_id" class="select select-bordered">
                            <option value="">Select Client</option>
                            @foreach($registrars as $registrar)
                                <option value="{{ $registrar->id }}">{{ $registrar->user?->name }}</option>
                            @endforeach
                        </select>
                        @error('registrar_id') <span class="text-error text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text">Class Code</span></label>
                    <input type="text" wire:model="assign_class_code" class="input input-bordered" placeholder="e.g., AQ001" />
                    @error('assign_class_code') <span class="text-error text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text">Classes</span></label>
                    <div class="flex flex-wrap gap-2">
                        @foreach($classNames as $class)
                            <label class="cursor-pointer">
                                <input type="checkbox" wire:model="class_names_id" value="{{ $class->id }}" class="checkbox checkbox-sm" />
                                <span class="label-text ml-1">{{ $class->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text">Package (Optional)</span></label>
                    <select wire:model="classpackage_id" class="select select-bordered">
                        <option value="">No Package</option>
                        @foreach($classPackages as $package)
                            <option value="{{ $package->id }}">{{ $package->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-action">
                <button wire:click="closeModal" class="btn">Cancel</button>
                <button wire:click="save" class="btn btn-primary">Save</button>
            </div>
        </div>
        <form method="dialog" class="modal-backdrop"><button>close</button></form>
    </dialog>
</div>
