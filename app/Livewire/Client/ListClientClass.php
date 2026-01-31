<?php

namespace App\Livewire\Client;

use App\Models\ReportClass;
use Livewire\Component;
use Livewire\WithPagination;

class ListClientClass extends Component
{
    use WithPagination;

    public $search = '';
    public $monthFilter = '';

    public function render()
    {
        $registrar = auth()->user()->registrar;

        if (!$registrar) {
            return view('livewire.client.list-client-class', ['classes' => collect()]);
        }

        $classes = ReportClass::with(['className', 'className2', 'createdBy.user'])
            ->where('registrar_id', $registrar->id)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('fee_student', 'like', "%{$this->search}%")
                        ->orWhere('note', 'like', "%{$this->search}%")
                        ->orWhere('month', 'like', "%{$this->search}%");
                });
            })
            ->when($this->monthFilter, function ($query) {
                $query->where('month', $this->monthFilter);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.client.list-client-class', compact('classes'));
    }
}
