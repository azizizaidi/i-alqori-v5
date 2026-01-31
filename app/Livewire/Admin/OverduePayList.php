<?php

namespace App\Livewire\Admin;

use App\Models\ReportClass;
use Livewire\Component;
use Livewire\WithPagination;

class OverduePayList extends Component
{
    use WithPagination;

    public $search = '';
    public $monthFilter = '';

    public function render()
    {
        $overduePayments = ReportClass::with(['registrar.user', 'className'])
            ->where('status', '!=', 1)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('fee_student', 'like', "%{$this->search}%")
                        ->orWhere('month', 'like', "%{$this->search}%")
                        ->orWhereHas('registrar.user', function ($q2) {
                            $q2->where('name', 'like', "%{$this->search}%");
                        });
                });
            })
            ->when($this->monthFilter, function ($query) {
                $query->where('month', $this->monthFilter);
            })
            ->orderBy('fee_student', 'desc')
            ->paginate(10);

        $totalOverdue = ReportClass::where('status', '!=', 1)
            ->when($this->monthFilter, function ($query) {
                $query->where('month', $this->monthFilter);
            })
            ->sum('fee_student');

        return view('livewire.admin.overdue-pay-list', compact('overduePayments', 'totalOverdue'));
    }
}
