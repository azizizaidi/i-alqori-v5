<div>
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Class Types</h2>
        <div class="flex gap-2">
            <input type="text" wire:model.live="search" placeholder="Search..." class="input input-bordered input-sm w-64" />
            <button wire:click="openModal()" class="btn btn-primary btn-sm">Add Type</button>
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
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($classTypes as $classType)
                    <tr class="{{ $classType->deleted_at ? 'opacity-50' : '' }}">
                        <td>{{ $classType->id }}</td>
                        <td>{{ $classType->name }}</td>
                        <td>{{ $classType->created_at->format('d/m/Y') }}</td>
                        <td>
                            <div class="flex gap-1">
                                <button wire:click="openModal({{ $classType->id }})" class="btn btn-ghost btn-xs">Edit</button>
                                @if($classType->deleted_at)
                                    <button wire:click="restore({{ $classType->id }})" class="btn btn-ghost btn-xs">Restore</button>
                                @else
                                    <button wire:click="delete({{ $classType->id }})" class="btn btn-ghost btn-xs text-error">Delete</button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $classTypes->links() }}</div>

    <!-- Modal -->
    <dialog class="modal" :class="{ 'modal-open': showModal }">
        <div class="modal-box">
            <h3 class="font-bold text-lg">{{ $editingId ? 'Edit' : 'Add' }} Class Type</h3>
            <div class="py-4">
                <div class="form-control">
                    <label class="label"><span class="label-text">Name</span></label>
                    <input type="text" wire:model="name" class="input input-bordered" placeholder="Type name" />
                    @error('name') <span class="text-error text-sm">{{ $message }}</span> @enderror
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
