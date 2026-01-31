<div>
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Users Management</h2>
        <div class="flex gap-2">
            <input type="text" wire:model.live="search" placeholder="Search users..." class="input input-bordered input-sm w-64" />
            <select wire:model.live="roleFilter" class="select select-bordered select-sm">
                <option value="">All Roles</option>
                @foreach($roles as $role)
                    <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                @endforeach
            </select>
        </div>
    </div>

    @if (session()->has('success'))
        <div class="alert alert-success mb-4">
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="table table-zebra">
            <thead>
                <tr>
                    <th><a href="#" wire:click.prevent="sortBy('id')">ID</a></th>
                    <th><a href="#" wire:click.prevent="sortBy('name')">Name</a></th>
                    <th>Email</th>
                    <th>Code</th>
                    <th>Phone</th>
                    <th>Role</th>
                    <th><a href="#" wire:click.prevent="sortBy('created_at')">Created</a></th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->code }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>
                            @foreach($user->roles as $role)
                                <span class="badge badge-outline">{{ $role->name }}</span>
                            @endforeach
                        </td>
                        <td>{{ $user->created_at->format('d/m/Y') }}</td>
                        <td>
                            <div class="flex gap-1">
                                <button wire:click="impersonate({{ $user->id }})" class="btn btn-ghost btn-xs">
                                    Impersonate
                                </button>
                                <button wire:click="confirmDelete({{ $user->id }})" class="btn btn-ghost btn-xs text-error">
                                    Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $users->links() }}
    </div>

    <!-- Delete Modal -->
    <dialog class="modal" :class="{ 'modal-open': showDeleteModal }">
        <div class="modal-box">
            <h3 class="font-bold text-lg">Delete User</h3>
            <p class="py-4">Are you sure you want to delete this user? This action cannot be undone.</p>
            <div class="modal-action">
                <button wire:click="showDeleteModal = false" class="btn">Cancel</button>
                <button wire:click="deleteUser" class="btn btn-error">Delete</button>
            </div>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button wire:click="showDeleteModal = false">close</button>
        </form>
    </dialog>
</div>
