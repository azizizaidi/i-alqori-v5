<?php

namespace App\Livewire\Admin;

use App\Models\Student;
use Livewire\Component;
use Livewire\WithPagination;

class StudentInfo extends Component
{
    use WithPagination;

    public $search = '';
    public $ageStageFilter = '';

    public function render()
    {
        $students = Student::with(['user', 'registrar.user'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('code', 'like', "%{$this->search}%")
                        ->orWhere('note', 'like', "%{$this->search}%")
                        ->orWhereHas('user', function ($q2) {
                            $q2->where('name', 'like', "%{$this->search}%");
                        });
                });
            })
            ->when($this->ageStageFilter, function ($query) {
                $query->where('age_stage', $this->ageStageFilter);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.admin.student-info', compact('students'));
    }
}
