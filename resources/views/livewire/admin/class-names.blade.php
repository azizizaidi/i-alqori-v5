<div>
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Class Names</h2>
        <div class="flex gap-2">
            <input type="text" wire:model.live="search" placeholder="Search..." class="input input-bordered input-sm w-64" />
            <button wire:click="openModal()" class="btn btn-primary btn-sm">Add Class Name</button>
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
                    <th>Name</th>
                    <th>Fee/Hour (RM)</th>
                    <th>Allowance/Hour (RM)</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($classNames as $className)
                    <tr class="{{ $className->deleted_at ? 'opacity-50' : '' }}">
                        <td>{{ $className->id }}</td>
                        <td>{{ $className->name }}</td>
                        <td>{{ number_format($className->feeperhour, 2) }}</td>
                        <td>{{ number_format($className->allowanceperhour, 2) }}</td>
                        <td>{{ $className->created_at->format('d/m/Y') }}</td>
                        <td>
                            <div class="flex gap-1">
                                <button wire:click="openModal({{ $className->id }})" class="btn btn-ghost btn-xs">Edit</button>
                                @if($className->deleted_at)
                                    <button wire:click="restore({{ $className->id }})" class="btn btn-ghost btn-xs">Restore</button>
                                @else
                                    <button wire:click="delete({{ $className->id }})" class="btn btn-ghost btn-xs text-error">Delete</button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $classNames->links() }}</div>

    <!-- Modal -->
    <dialog class="modal" :class="{ 'modal-open': showModal }">
        <div class="modal-box">
            <h3 class="font-bold text-lg">{{ $editingId ? 'Edit' : 'Add' }} Class Name</h3>
            <div class="py-4 space-y-4">
                <div class="form-control">
                    <label class="label"><span class="label-text">Name</span></label>
                    <input type="text" wire:model="name" class="input input-bordered" placeholder="Class name" />
                    @error('name') <span class="text-error text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text">Fee Per Hour (RM)</span></label>
                    <input type="number" wire:model="feeperhour" class="input input-bordered" placeholder="0" />
                    @error('feeperhour') <span class="text-error text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text">Allowance Per Hour (RM)</span></label>
                    <input type="number" wire:model="allowanceperhour" class="input input-bordered" placeholder="0" />
                    @error('allowanceperhour') <span class="text-error text-sm">{{ $message }}</span> @enderror
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
