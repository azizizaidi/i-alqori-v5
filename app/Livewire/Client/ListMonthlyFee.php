<?php

namespace App\Livewire\Client;

use App\Models\ReportClass;
use Livewire\Component;
use Livewire\WithPagination;

class ListMonthlyFee extends Component
{
    use WithPagination;

    public $search = '';
    public $monthFilter = '';

    public function render()
    {
        $registrar = auth()->user()->registrar;

        if (!$registrar) {
            return view('livewire.client.list-monthly-fee', ['fees' => collect(), 'totalFee' => 0, 'totalPaid' => 0, 'totalUnpaid' => 0]);
        }

        $query = ReportClass::with(['className', 'className2'])
            ->where('registrar_id', $registrar->id);

        $fees = $query->orderBy('created_at', 'desc')->paginate(10);
        $totalFee = $query->clone()->sum(\Illuminate\Support\Str::replace([',', 'RM'], '', $query->clone()->first()?->fee_student ?? 0));
        $totalPaid = $query->clone()->where('status', 1)->sum(\Illuminate\Support\Str::replace([',', 'RM'], '', $query->clone()->first()?->fee_student ?? 0));
        $totalUnpaid = $query->clone()->where('status', '!=', 1)->sum(\Illuminate\Support\Str::replace([',', 'RM'], '', $query->clone()->first()?->fee_student ?? 0));

        return view('livewire.client.list-monthly-fee', compact('fees', 'totalFee', 'totalPaid', 'totalUnpaid'));
    }
}
