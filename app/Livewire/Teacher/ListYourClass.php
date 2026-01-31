<?php

namespace App\Livewire\Teacher;

use App\Models\AssignClassTeacher;
use Livewire\Component;

class ListYourClass extends Component
{
    public function render()
    {
        $teacher = auth()->user()->teacher;

        if (!$teacher) {
            return view('livewire.teacher.list-your-class', ['classes' => collect()]);
        }

        $classes = AssignClassTeacher::with(['registrar.user', 'classNames', 'classPackage'])
            ->where('teacher_id', $teacher->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('livewire.teacher.list-your-class', compact('classes'));
    }
}
