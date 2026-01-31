<?php

namespace App\Livewire\Client;

use App\Models\HistoryPayment;
use Livewire\Component;
use Livewire\WithPagination;

class ListTransaction extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        $transactions = HistoryPayment::with(['user', 'reportClass'])
            ->where('user_id', auth()->id())
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('amount', 'like', "%{$this->search}%")
                        ->orWhere('transaction_id', 'like', "%{$this->search}%")
                        ->orWhere('description', 'like', "%{$this->search}%");
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.client.list-transaction', compact('transactions'));
    }
}
