<?php

namespace App\Livewire\Teacher;

use App\Models\ReportClass;
use Livewire\Component;
use Livewire\WithPagination;

class ListAllowance extends Component
{
    use WithPagination;

    public $search = '';
    public $monthFilter = '';

    public function render()
    {
        $teacher = auth()->user()->teacher;

        if (!$teacher) {
            return view('livewire.teacher.list-allowance', ['allowances' => collect(), 'totalAllowance' => 0]);
        }

        $query = ReportClass::with(['className', 'className2'])
            ->where('created_by_id', auth()->id())
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('allowance', 'like', "%{$this->search}%")
                        ->orWhere('month', 'like', "%{$this->search}%");
                });
            })
            ->when($this->monthFilter, function ($query) {
                $query->where('month', $this->monthFilter);
            });

        $allowances = $query->orderBy('created_at', 'desc')->paginate(10);
        $totalAllowance = $query->sum('allowance');

        return view('livewire.teacher.list-allowance', compact('allowances', 'totalAllowance'));
    }
}
