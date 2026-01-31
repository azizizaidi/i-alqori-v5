<div>
    <h2 class="text-2xl font-bold mb-6">Your Classes</h2>

    @if($classes->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($classes as $class)
                <div class="card bg-base-100 shadow-lg">
                    <div class="card-body">
                        <h3 class="card-title">{{ $class->assign_class_code }}</h3>
                        <div class="space-y-2">
                            <p><strong>Client:</strong> {{ $class->registrar?->user?->name ?? 'N/A' }}</p>
                            <p><strong>Classes:</strong></p>
                            <div class="flex flex-wrap gap-1">
                                @foreach($class->classNames as $cn)
                                    <span class="badge badge-info">{{ $cn->name }}</span>
                                @endforeach
                            </div>
                            @if($class->classPackage)
                                <p><strong>Package:</strong> {{ $class->classPackage->name }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-info">
            <span>No classes assigned yet.</span>
        </div>
    @endif
</div>
