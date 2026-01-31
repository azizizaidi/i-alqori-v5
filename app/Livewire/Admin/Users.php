<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class Users extends Component
{
    use WithPagination;

    public $search = '';
    public $roleFilter = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $showDeleteModal = false;
    public $userToDelete = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'roleFilter' => ['except' => ''],
        'sortField' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
    ];

    public function render()
    {
        $users = User::with('roles')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', "%{$this->search}%")
                        ->orWhere('email', 'like', "%{$this->search}%")
                        ->orWhere('code', 'like', "%{$this->search}%")
                        ->orWhere('phone', 'like', "%{$this->search}%");
                });
            })
            ->when($this->roleFilter, function ($query) {
                $query->whereHas('roles', function ($q) {
                    $q->where('name', $this->roleFilter);
                });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        $roles = Role::all();

        return view('livewire.admin.users', compact('users', 'roles'));
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function confirmDelete(User $user)
    {
        $this->userToDelete = $user;
        $this->showDeleteModal = true;
    }

    public function deleteUser()
    {
        if ($this->userToDelete) {
            $this->userToDelete->delete();
            $this->showDeleteModal = false;
            $this->userToDelete = null;
            session()->flash('success', 'User deleted successfully.');
        }
    }

    public function impersonate(User $user)
    {
        auth()->login($user);
        return redirect()->route('dashboard');
    }
}
