<?php

namespace App\Livewire\Admin;

use App\Models\ClassPackage;
use Livewire\Component;
use Livewire\WithPagination;

class ClassPackages extends Component
{
    use WithPagination;

    public $search = '';
    public $showModal = false;
    public $editingId = null;
    public $name = '';

    protected $rules = [
        'name' => 'required|string|max:255|unique:class_packages,name,' . null,
    ];

    public function render()
    {
        $packages = ClassPackage::withTrashed()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', "%{$this->search}%");
            })
            ->orderBy('name')
            ->paginate(10);

        return view('livewire.admin.class-packages', compact('packages'));
    }

    public function openModal($id = null)
    {
        if ($id) {
            $package = ClassPackage::withTrashed()->find($id);
            $this->editingId = $id;
            $this->name = $package->name;
        } else {
            $this->reset(['editingId', 'name']);
        }
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->reset(['showModal', 'editingId', 'name']);
    }

    public function save()
    {
        $this->validate();

        ClassPackage::updateOrCreate(
            ['id' => $this->editingId],
            ['name' => $this->name]
        );

        $this->closeModal();
        session()->flash('success', 'Class package saved successfully.');
    }

    public function delete($id)
    {
        $package = ClassPackage::find($id);
        if ($package) {
            $package->delete();
            session()->flash('success', 'Class package deleted successfully.');
        }
    }

    public function restore($id)
    {
        $package = ClassPackage::withTrashed()->find($id);
        if ($package) {
            $package->restore();
            session()->flash('success', 'Class package restored successfully.');
        }
    }
}
