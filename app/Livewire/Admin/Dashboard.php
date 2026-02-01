<?php

namespace App\Livewire\Admin;

use App\Models\ReportClass;
use App\Models\User;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class Dashboard extends Component
{
    public string $selectedMonth = '';
    public array $chartData = [];

    public function mount(): void
    {
        $this->selectedMonth = now()->format('m-Y');
        $this->loadChartData();
    }

    public function loadChartData(): void
    {
        $years = ['2022', '2023', '2024', '2025'];
        $months = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];

        $this->chartData = [];

        foreach ($years as $year) {
            $feeData = [];
            $allowanceData = [];

            foreach ($months as $month) {
                $monthKey = $month . '-' . $year;
                $feeData[] = (float) ReportClass::where('month', $monthKey)->whereNull('deleted_at')->sum('fee_student');
                $allowanceData[] = (float) ReportClass::where('month', $monthKey)->whereNull('deleted_at')->sum('allowance');
            }

            $this->chartData[$year] = [
                'fee' => $feeData,
                'allowance' => $allowanceData,
            ];
        }
    }

    public function getStats(): array
    {
        $currentMonth = now()->format('m-Y');

        $fee = ReportClass::where('month', $currentMonth)->sum('fee_student');
        $allowance = ReportClass::where('month', $currentMonth)->sum('allowance');
        $overdue = ReportClass::where('month', $currentMonth)->where('status', '!=', 1)->sum('fee_student');

        return [
            'totalFee' => number_format($fee, 2),
            'totalAllowance' => number_format($allowance, 2),
            'overdueBalance' => number_format($overdue, 2),
            'currentMonth' => now()->format('F Y'),
        ];
    }

    public function getOverdueByStatus(int $status): array
    {
        $years = ['2022', '2023', '2024', '2025'];
        $months = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
        $result = [];

        foreach ($years as $year) {
            $yearData = [];
            foreach ($months as $month) {
                $monthKey = $month . '-' . $year;
                $amount = ReportClass::where('month', $monthKey)
                    ->where('status', $status)
                    ->sum('fee_student');
                $yearData[$monthKey] = $amount;
            }
            $result[$year] = $yearData;
        }

        return $result;
    }

    public function render()
    {
        return view('livewire.admin.dashboard', [
            'stats' => $this->getStats(),
            'chartData' => $this->chartData,
            'overdueUnpaid' => $this->getOverdueByStatus(0),
            'overdueFailed' => $this->getOverdueByStatus(3),
            'overdueProcessing' => $this->getOverdueByStatus(2),
            'userCount' => User::count(),
            'teacherCount' => Role::findByName('Teacher')->users()->count(),
            'clientCount' => Role::findByName('Registrar')->users()->count(),
        ]);
    }
}
