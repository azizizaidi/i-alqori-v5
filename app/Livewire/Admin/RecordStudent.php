<?php

namespace App\Livewire\Admin;

use App\Models\Student;
use Livewire\Component;
use Livewire\WithPagination;

class RecordStudent extends Component
{
    use WithPagination;

    public $search = '';
    public $registrarFilter = '';

    public function render()
    {
        $students = Student::with(['user', 'registrar.user'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('code', 'like', "%{$this->search}%")
                        ->orWhere('age_stage', 'like', "%{$this->search}%")
                        ->orWhereHas('user', function ($q2) {
                            $q2->where('name', 'like', "%{$this->search}%");
                        });
                });
            })
            ->when($this->registrarFilter, function ($query) {
                $query->where('registrar_id', $this->registrarFilter);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.admin.record-student', compact('students'));
    }
}
