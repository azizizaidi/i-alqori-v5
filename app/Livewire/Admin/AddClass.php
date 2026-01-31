<?php

namespace App\Livewire\Admin;

use App\Models\AssignClassTeacher;
use App\Models\ClassName;
use App\Models\ClassPackage;
use App\Models\Registrar;
use App\Models\Teacher;
use Livewire\Component;

class AddClass extends Component
{
    public $teacher_id = '';
    public $registrar_id = '';
    public $assign_class_code = '';
    public $class_names_id = [];
    public $classpackage_id = '';

    protected $rules = [
        'teacher_id' => 'required|exists:teachers,id',
        'registrar_id' => 'required|exists:registrars,id',
        'assign_class_code' => 'required|string|max:255',
        'class_names_id' => 'array|min:1',
        'classpackage_id' => 'nullable|exists:class_packages,id',
    ];

    public function render()
    {
        $teachers = Teacher::with('user')->get();
        $registrars = Registrar::with('user')->get();
        $classNames = ClassName::all();
        $classPackages = ClassPackage::all();

        return view('livewire.admin.add-class', compact('teachers', 'registrars', 'classNames', 'classPackages'));
    }

    public function save()
    {
        $this->validate();

        $assignment = AssignClassTeacher::create([
            'teacher_id' => $this->teacher_id,
            'registrar_id' => $this->registrar_id,
            'assign_class_code' => $this->assign_class_code,
            'classpackage_id' => $this->classpackage_id ?: null,
        ]);

        $assignment->classNames()->attach($this->class_names_id);

        $this->reset(['teacher_id', 'registrar_id', 'assign_class_code', 'class_names_id', 'classpackage_id']);
        session()->flash('success', 'Class assignment created successfully.');
    }
}
