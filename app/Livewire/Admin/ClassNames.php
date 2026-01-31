<?php

namespace App\Livewire\Admin;

use App\Models\ClassName;
use Livewire\Component;
use Livewire\WithPagination;

class ClassNames extends Component
{
    use WithPagination;

    public $search = '';
    public $showModal = false;
    public $editingId = null;
    public $name = '';
    public $feeperhour = '';
    public $allowanceperhour = '';

    protected $rules = [
        'name' => 'required|string|max:255',
        'feeperhour' => 'required|integer|min:0',
        'allowanceperhour' => 'required|integer|min:0',
    ];

    public function render()
    {
        $classNames = ClassName::withTrashed()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', "%{$this->search}%");
            })
            ->orderBy('name')
            ->paginate(10);

        return view('livewire.admin.class-names', compact('classNames'));
    }

    public function openModal($id = null)
    {
        if ($id) {
            $className = ClassName::withTrashed()->find($id);
            $this->editingId = $id;
            $this->name = $className->name;
            $this->feeperhour = $className->feeperhour;
            $this->allowanceperhour = $className->allowanceperhour;
        } else {
            $this->reset(['editingId', 'name', 'feeperhour', 'allowanceperhour']);
        }
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->reset(['showModal', 'editingId', 'name', 'feeperhour', 'allowanceperhour']);
    }

    public function save()
    {
        $this->validate();

        ClassName::updateOrCreate(
            ['id' => $this->editingId],
            [
                'name' => $this->name,
                'feeperhour' => $this->feeperhour,
                'allowanceperhour' => $this->allowanceperhour,
            ]
        );

        $this->closeModal();
        session()->flash('success', 'Class name saved successfully.');
    }

    public function delete($id)
    {
        $className = ClassName::find($id);
        if ($className) {
            $className->delete();
            session()->flash('success', 'Class name deleted successfully.');
        }
    }

    public function restore($id)
    {
        $className = ClassName::withTrashed()->find($id);
        if ($className) {
            $className->restore();
            session()->flash('success', 'Class name restored successfully.');
        }
    }
}
