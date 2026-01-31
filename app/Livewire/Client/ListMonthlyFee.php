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
    public $processingPayment = false;

    public function render()
    {
        $registrar = auth()->user()->registrar;

        if (!$registrar) {
            return view('livewire.client.list-monthly-fee', [
                'fees' => collect(),
                'totalFee' => 0,
                'totalPaid' => 0,
                'totalUnpaid' => 0,
            ]);
        }

        $query = ReportClass::with(['className', 'className2'])
            ->where('registrar_id', $registrar->id);

        $fees = $query->orderBy('created_at', 'desc')->paginate(10);

        // Calculate totals properly
        $allFees = $query->clone()->get();
        $totalFee = $allFees->sum(function ($fee) {
            return (float) str_replace([',', 'RM'], '', $fee->fee_student ?: 0);
        });
        $totalPaid = $allFees->where('status', 1)->sum(function ($fee) {
            return (float) str_replace([',', 'RM'], '', $fee->fee_student ?: 0);
        });
        $totalUnpaid = $totalFee - $totalPaid;

        return view('livewire.client.list-monthly-fee', compact('fees', 'totalFee', 'totalPaid', 'totalUnpaid'));
    }

    public function payNow(int $feeId)
    {
        $this->processingPayment = true;

        $fee = ReportClass::find($feeId);

        if (!$fee || $fee->status == 1) {
            $this->dispatch('notify', 'Invalid fee or already paid.', 'error');
            $this->processingPayment = false;
            return;
        }

        $this->redirectRoute('payment.create', ['report_class_id' => $feeId]);
    }
}
