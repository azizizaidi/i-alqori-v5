<div>
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Fee Rates</h2>
        <div class="flex gap-2">
            <input type="text" wire:model.live="search" placeholder="Search..." class="input input-bordered input-sm w-64" />
            <button wire:click="openModal()" class="btn btn-primary btn-sm">Add Fee Rate</button>
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
                    <th>Class Name</th>
                    <th>Hours (Min)</th>
                    <th>Hours (Max)</th>
                    <th>Fee/Hour (RM)</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($feeRates as $feeRate)
                    <tr>
                        <td>{{ $feeRate->id }}</td>
                        <td>{{ $feeRate->className?->name ?? 'N/A' }}</td>
                        <td>{{ $feeRate->total_hours_min }}</td>
                        <td>{{ $feeRate->total_hours_max }}</td>
                        <td>{{ number_format($feeRate->feeperhour, 2) }}</td>
                        <td>
                            <div class="flex gap-1">
                                <button wire:click="openModal({{ $feeRate->id }})" class="btn btn-ghost btn-xs">Edit</button>
                                <button wire:click="delete({{ $feeRate->id }})" class="btn btn-ghost btn-xs text-error">Delete</button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $feeRates->links() }}</div>

    <!-- Modal -->
    <dialog class="modal" :class="{ 'modal-open': showModal }">
        <div class="modal-box">
            <h3 class="font-bold text-lg">{{ $editingId ? 'Edit' : 'Add' }} Fee Rate</h3>
            <div class="py-4 space-y-4">
                <div class="form-control">
                    <label class="label"><span class="label-text">Class Name</span></label>
                    <select wire:model="class_names_id" class="select select-bordered">
                        <option value="">Select Class</option>
                        @foreach($classNames as $className)
                            <option value="{{ $className->id }}">{{ $className->name }}</option>
                        @endforeach
                    </select>
                    @error('class_names_id') <span class="text-error text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label"><span class="label-text">Min Hours</span></label>
                        <input type="text" wire:model="total_hours_min" class="input input-bordered" placeholder="0" />
                    </div>
                    <div class="form-control">
                        <label class="label"><span class="label-text">Max Hours</span></label>
                        <input type="text" wire:model="total_hours_max" class="input input-bordered" placeholder="0" />
                    </div>
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text">Fee Per Hour (RM)</span></label>
                    <input type="text" wire:model="feeperhour" class="input input-bordered" placeholder="0" />
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
