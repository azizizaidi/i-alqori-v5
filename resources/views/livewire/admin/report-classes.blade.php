<div>
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Report Classes</h2>
        <div class="flex gap-2">
            <input type="text" wire:model.live="search" placeholder="Search..." class="input input-bordered input-sm w-64" />
            <select wire:model.live="monthFilter" class="select select-bordered select-sm">
                <option value="">All Months</option>
                @for($i = 0; $i < 12; $i++)
                    <option value="{{ now()->subMonths($i)->format('m-Y') }}">{{ now()->subMonths($i)->format('m/Y') }}</option>
                @endfor
            </select>
            <button wire:click="openModal()" class="btn btn-primary btn-sm">Add Report</button>
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
                    <th>Registrar</th>
                    <th>Class</th>
                    <th>Date</th>
                    <th>Hours</th>
                    <th>Fee (RM)</th>
                    <th>Allowance</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reportClasses as $report)
                    <tr class="{{ $report->deleted_at ? 'opacity-50' : '' }}">
                        <td>{{ $report->id }}</td>
                        <td>{{ $report->registrar?->user?->name ?? 'N/A' }}</td>
                        <td>{{ $report->className?->name ?? 'N/A' }}</td>
                        <td>{{ $report->date }}</td>
                        <td>{{ $report->total_hour }}</td>
                        <td>{{ $report->fee_student }}</td>
                        <td>{{ number_format($report->allowance, 2) }}</td>
                        <td>
                            <span class="badge badge-sm
                                @switch($report->status)
                                    @case(1) badge-success @break
                                    @case(0) badge-warning @break
                                    @case(2) badge-info @break
                                    @default badge-error @break
                                @endswitch">
                                @switch($report->status)
                                    @case(0) Unpaid @break
                                    @case(1) Paid @break
                                    @case(2) Partial @break
                                    @case(3) Overdue @break
                                    @case(4) Cancelled @break
                                    @case(5) Refunded @break
                                    @default Unknown @break
                                @endswitch
                            </span>
                        </td>
                        <td>
                            <div class="flex gap-1">
                                <button wire:click="openModal({{ $report->id }})" class="btn btn-ghost btn-xs">Edit</button>
                                @if($report->deleted_at)
                                    <button wire:click="restore({{ $report->id }})" class="btn btn-ghost btn-xs">Restore</button>
                                @else
                                    <button wire:click="delete({{ $report->id }})" class="btn btn-ghost btn-xs text-error">Delete</button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $reportClasses->links() }}</div>

    <!-- Modal -->
    <dialog class="modal" :class="{ 'modal-open': showModal }">
        <div class="modal-box max-w-2xl">
            <h3 class="font-bold text-lg">{{ $editingId ? 'Edit' : 'Add' }} Report Class</h3>
            <div class="py-4 space-y-4">
                <div class="form-control">
                    <label class="label"><span class="label-text">Registrar/Client</span></label>
                    <select wire:model="registrar_id" class="select select-bordered">
                        <option value="">Select Registrar</option>
                        @foreach($registrars as $registrar)
                            <option value="{{ $registrar->id }}">{{ $registrar->user?->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label"><span class="label-text">Class Name</span></label>
                        <select wire:model="class_names_id" class="select select-bordered">
                            <option value="">Select Class</option>
                            @foreach($classNames as $class)
                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-control">
                        <label class="label"><span class="label-text">Date</span></label>
                        <input type="text" wire:model="date" class="input input-bordered" placeholder="e.g., 13/3, 20/3, 27/3" />
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label"><span class="label-text">Total Hours</span></label>
                        <input type="text" wire:model="total_hour" class="input input-bordered" placeholder="e.g., 1.5" />
                    </div>
                    <div class="form-control">
                        <label class="label"><span class="label-text">Fee (RM)</span></label>
                        <input type="text" wire:model="fee_student" class="input input-bordered" placeholder="0" />
                    </div>
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text">Status</span></label>
                    <select wire:model="status" class="select select-bordered">
                        <option value="0">Unpaid</option>
                        <option value="1">Paid</option>
                        <option value="2">Partial</option>
                        <option value="3">Overdue</option>
                        <option value="4">Cancelled</option>
                        <option value="5">Refunded</option>
                    </select>
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text">Note</span></label>
                    <textarea wire:model="note" class="textarea textarea-bordered" placeholder="Notes..."></textarea>
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
