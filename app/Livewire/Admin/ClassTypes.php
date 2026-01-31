<?php

namespace App\Livewire\Admin;

use App\Models\ClassType;
use Livewire\Component;
use Livewire\WithPagination;

class ClassTypes extends Component
{
    use WithPagination;

    public $search = '';
    public $showModal = false;
    public $editingId = null;
    public $name = '';

    protected $rules = [
        'name' => 'required|string|max:255|unique:class_types,name,' . null,
    ];

    public function render()
    {
        $classTypes = ClassType::withTrashed()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', "%{$this->search}%");
            })
            ->orderBy('name')
            ->paginate(10);

        return view('livewire.admin.class-types', compact('classTypes'));
    }

    public function openModal($id = null)
    {
        if ($id) {
            $classType = ClassType::withTrashed()->find($id);
            $this->editingId = $id;
            $this->name = $classType->name;
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

        ClassType::updateOrCreate(
            ['id' => $this->editingId],
            ['name' => $this->name]
        );

        $this->closeModal();
        session()->flash('success', 'Class type saved successfully.');
    }

    public function delete($id)
    {
        $classType = ClassType::find($id);
        if ($classType) {
            $classType->delete();
            session()->flash('success', 'Class type deleted successfully.');
        }
    }

    public function restore($id)
    {
        $classType = ClassType::withTrashed()->find($id);
        if ($classType) {
            $classType->restore();
            session()->flash('success', 'Class type restored successfully.');
        }
    }
}
