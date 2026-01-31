<?php

namespace App\Livewire\Teacher;

use App\Models\ReportClass;
use Livewire\Component;
use Livewire\WithPagination;

class ListFee extends Component
{
    use WithPagination;

    public $search = '';
    public $monthFilter = '';

    public function render()
    {
        $teacher = auth()->user()->teacher;

        if (!$teacher) {
            return view('livewire.teacher.list-fee', ['fees' => collect()]);
        }

        $fees = ReportClass::with(['registrar.user', 'className', 'className2'])
            ->where('created_by_id', auth()->id())
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('fee_student', 'like', "%{$this->search}%")
                        ->orWhere('note', 'like', "%{$this->search}%")
                        ->orWhereHas('registrar.user', function ($q2) {
                            $q2->where('name', 'like', "%{$this->search}%");
                        });
                });
            })
            ->when($this->monthFilter, function ($query) {
                $query->where('month', $this->monthFilter);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.teacher.list-fee', compact('fees'));
    }
}
