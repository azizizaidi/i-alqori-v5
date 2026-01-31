<div>
    <h2 class="text-2xl font-bold mb-6">Add Class Assignment</h2>

    @if (session()->has('success'))
        <div class="alert alert-success mb-4">{{ session('success') }}</div>
    @endif

    <div class="card bg-base-100 shadow-lg max-w-2xl mx-auto">
        <div class="card-body space-y-4">
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
                <div class="flex flex-wrap gap-2 p-4 border rounded-lg bg-base-200">
                    @foreach($classNames as $class)
                        <label class="cursor-pointer bg-base-100 px-3 py-2 rounded border">
                            <input type="checkbox" wire:model="class_names_id" value="{{ $class->id }}" class="checkbox checkbox-sm" />
                            <span class="label-text ml-1">{{ $class->name }}</span>
                        </label>
                    @endforeach
                </div>
                @error('class_names_id') <span class="text-error text-sm">{{ $message }}</span> @enderror
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

            <button wire:click="save" class="btn btn-primary mt-4">Create Assignment</button>
        </div>
    </div>
</div>
