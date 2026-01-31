<?php

namespace App\Livewire\Admin;

use App\Models\AssignClassTeacher;
use App\Models\ClassName;
use App\Models\ClassPackage;
use App\Models\Registrar;
use App\Models\Teacher;
use Livewire\Component;
use Livewire\WithPagination;

class AssignClassTeachers extends Component
{
    use WithPagination;

    public $search = '';
    public $showModal = false;
    public $editingId = null;
    public $teacher_id = '';
    public $registrar_id = '';
    public $assign_class_code = '';
    public $class_names_id = [];
    public $classpackage_id = '';

    protected $rules = [
        'teacher_id' => 'required|exists:teachers,id',
        'registrar_id' => 'required|exists:registrars,id',
        'assign_class_code' => 'required|string|max:255',
        'class_names_id' => 'array',
        'classpackage_id' => 'nullable|exists:class_packages,id',
    ];

    public function render()
    {
        $assignments = AssignClassTeacher::with(['teacher.user', 'registrar.user', 'classNames', 'classPackage'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('assign_class_code', 'like', "%{$this->search}%")
                        ->orWhereHas('teacher.user', function ($q2) {
                            $q2->where('name', 'like', "%{$this->search}%");
                        })
                        ->orWhereHas('registrar.user', function ($q2) {
                            $q2->where('name', 'like', "%{$this->search}%");
                        });
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $teachers = Teacher::with('user')->get();
        $registrars = Registrar::with('user')->get();
        $classNames = ClassName::all();
        $classPackages = ClassPackage::all();

        return view('livewire.admin.assign-class-teachers', compact('assignments', 'teachers', 'registrars', 'classNames', 'classPackages'));
    }

    public function openModal($id = null)
    {
        if ($id) {
            $assignment = AssignClassTeacher::with(['classNames'])->find($id);
            $this->editingId = $id;
            $this->teacher_id = $assignment->teacher_id;
            $this->registrar_id = $assignment->registrar_id;
            $this->assign_class_code = $assignment->assign_class_code;
            $this->class_names_id = $assignment->classNames->pluck('id')->toArray();
            $this->classpackage_id = $assignment->classpackage_id;
        } else {
            $this->reset(['editingId', 'teacher_id', 'registrar_id', 'assign_class_code', 'class_names_id', 'classpackage_id']);
        }
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->reset(['showModal', 'editingId', 'teacher_id', 'registrar_id', 'assign_class_code', 'class_names_id', 'classpackage_id']);
    }

    public function save()
    {
        $this->validate();

        $assignment = AssignClassTeacher::updateOrCreate(
            ['id' => $this->editingId],
            [
                'teacher_id' => $this->teacher_id,
                'registrar_id' => $this->registrar_id,
                'assign_class_code' => $this->assign_class_code,
                'classpackage_id' => $this->classpackage_id ?: null,
            ]
        );

        $assignment->classNames()->sync($this->class_names_id);

        $this->closeModal();
        session()->flash('success', 'Class assignment saved successfully.');
    }

    public function delete($id)
    {
        $assignment = AssignClassTeacher::find($id);
        if ($assignment) {
            $assignment->delete();
            session()->flash('success', 'Class assignment deleted successfully.');
        }
    }
}
