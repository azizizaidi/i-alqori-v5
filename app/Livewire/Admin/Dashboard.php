<?php

namespace App\Livewire\Admin;

use App\Models\ReportClass;
use App\Models\User;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class Dashboard extends Component
{
    public $totalFeeDecember = 0;
    public $totalAllowanceDecember = 0;
    public $overdueBalanceDecember = 0;
    public $overduePayments = [];

    public function mount()
    {
        $this->loadStats();
    }

    public function loadStats()
    {
        $month = '2025-12';

        // Total Fee December
        $this->totalFeeDecember = ReportClass::where('month', $month)
            ->where('status', 1)
            ->sum('fee_student');

        // Total Allowance December
        $this->totalAllowanceDecember = ReportClass::where('month', $month)
            ->where('status', 1)
            ->sum('allowance');

        // Overdue Balance December (status != 1)
        $this->overdueBalanceDecember = ReportClass::where('month', $month)
            ->where('status', '!=', 1)
            ->sum('fee_student');

        // Overdue Payments List
        $this->overduePayments = ReportClass::where('month', $month)
            ->where('status', '!=', 1)
            ->with(['registrar', 'className'])
            ->orderBy('fee_student', 'desc')
            ->limit(10)
            ->get();
    }

    public function render()
    {
        return view('livewire.admin.dashboard', [
            'stats' => [
                'totalFee' => number_format($this->totalFeeDecember, 2),
                'totalAllowance' => number_format($this->totalAllowanceDecember, 2),
                'overdueBalance' => number_format($this->overdueBalanceDecember, 2),
            ],
            'overduePayments' => $this->overduePayments,
            'userCount' => User::count(),
            'teacherCount' => Role::findByName('teacher')->users()->count(),
            'clientCount' => Role::findByName('client')->users()->count(),
        ]);
    }
}
