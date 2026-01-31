<div>
    <h2 class="text-2xl font-bold mb-6">My Clients (Teachers)</h2>

    @if($teachers->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($teachers as $teacher)
                <div class="card bg-base-100 shadow-lg">
                    <div class="card-body">
                        <h3 class="card-title">{{ $teacher->teacher?->user?->name ?? 'N/A' }}</h3>
                        <div class="space-y-2">
                            <p><strong>Class Code:</strong> {{ $teacher->assign_class_code }}</p>
                            <p><strong>Classes:</strong></p>
                            <div class="flex flex-wrap gap-1">
                                @foreach($teacher->classNames as $cn)
                                    <span class="badge badge-info">{{ $cn->name }}</span>
                                @endforeach
                            </div>
                            @if($teacher->classPackage)
                                <p><strong>Package:</strong> {{ $teacher->classPackage->name }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-info">
            <span>No teachers assigned yet.</span>
        </div>
    @endif
</div>
