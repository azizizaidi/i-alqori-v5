<div>
    <h2 class="text-2xl font-bold mb-6">Fee Calculator</h2>

    <div class="card bg-base-100 shadow-lg max-w-xl mx-auto">
        <div class="card-body">
            <div class="form-control mb-4">
                <label class="label"><span class="label-text">Select Class</span></label>
                <select wire:model="selectedClass" class="select select-bordered">
                    <option value="">Select a class...</option>
                    @foreach($classNames as $class)
                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                    @endforeach
                </select>
            </div>

            @if($selectedClass)
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div class="stat bg-primary/10 rounded-lg">
                        <div class="stat-title">Fee/Hour</div>
                        <div class="stat-value text-primary text-xl">RM {{ number_format($feePerHour, 2) }}</div>
                    </div>
                    <div class="stat bg-secondary/10 rounded-lg">
                        <div class="stat-title">Allowance/Hour</div>
                        <div class="stat-value text-secondary text-xl">RM {{ number_format($allowancePerHour, 2) }}</div>
                    </div>
                </div>
            @endif

            <div class="form-control mb-4">
                <label class="label"><span class="label-text">Total Hours</span></label>
                <input type="number" wire:model="totalHours" class="input input-bordered" placeholder="Enter hours..." step="0.5" />
            </div>

            @if($totalHours && $selectedClass)
                <div class="divider">Result</div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="stat bg-success/10 rounded-lg">
                        <div class="stat-title">Total Fee</div>
                        <div class="stat-value text-success text-2xl">RM {{ number_format($calculatedFee, 2) }}</div>
                    </div>
                    <div class="stat bg-info/10 rounded-lg">
                        <div class="stat-title">Total Allowance</div>
                        <div class="stat-value text-info text-2xl">RM {{ number_format($calculatedAllowance, 2) }}</div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
