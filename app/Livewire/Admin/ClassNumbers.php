<?php

namespace App\Livewire\Admin;

use App\Models\ClassNumber;
use Livewire\Component;
use Livewire\WithPagination;

class ClassNumbers extends Component
{
    use WithPagination;

    public $search = '';
    public $showModal = false;
    public $editingId = null;
    public $name = '';

    protected $rules = [
        'name' => 'required|string|max:255|unique:class_numbers,name,' . null,
    ];

    public function render()
    {
        $classNumbers = ClassNumber::withTrashed()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', "%{$this->search}%");
            })
            ->orderBy('name')
            ->paginate(10);

        return view('livewire.admin.class-numbers', compact('classNumbers'));
    }

    public function openModal($id = null)
    {
        if ($id) {
            $classNumber = ClassNumber::withTrashed()->find($id);
            $this->editingId = $id;
            $this->name = $classNumber->name;
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

        ClassNumber::updateOrCreate(
            ['id' => $this->editingId],
            ['name' => $this->name]
        );

        $this->closeModal();
        session()->flash('success', 'Class number saved successfully.');
    }

    public function delete($id)
    {
        $classNumber = ClassNumber::find($id);
        if ($classNumber) {
            $classNumber->delete();
            session()->flash('success', 'Class number deleted successfully.');
        }
    }

    public function restore($id)
    {
        $classNumber = ClassNumber::withTrashed()->find($id);
        if ($classNumber) {
            $classNumber->restore();
            session()->flash('success', 'Class number restored successfully.');
        }
    }
}
