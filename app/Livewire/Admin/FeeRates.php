<?php

namespace App\Livewire\Admin;

use App\Models\FeeRate;
use App\Models\ClassName;
use Livewire\Component;
use Livewire\WithPagination;

class FeeRates extends Component
{
    use WithPagination;

    public $search = '';
    public $showModal = false;
    public $editingId = null;
    public $class_names_id = '';
    public $total_hours_min = '';
    public $total_hours_max = '';
    public $feeperhour = '';

    protected $rules = [
        'class_names_id' => 'required|exists:class_names,id',
        'total_hours_min' => 'required|string',
        'total_hours_max' => 'required|string',
        'feeperhour' => 'required|string',
    ];

    public function render()
    {
        $feeRates = FeeRate::with(['className'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('total_hours_min', 'like', "%{$this->search}%")
                        ->orWhere('total_hours_max', 'like', "%{$this->search}%")
                        ->orWhereHas('className', function ($q2) {
                            $q2->where('name', 'like', "%{$this->search}%");
                        });
                });
            })
            ->orderBy('class_names_id')
            ->orderBy('total_hours_min')
            ->paginate(10);

        $classNames = ClassName::all();

        return view('livewire.admin.fee-rates', compact('feeRates', 'classNames'));
    }

    public function openModal($id = null)
    {
        if ($id) {
            $feeRate = FeeRate::find($id);
            $this->editingId = $id;
            $this->class_names_id = $feeRate->class_names_id;
            $this->total_hours_min = $feeRate->total_hours_min;
            $this->total_hours_max = $feeRate->total_hours_max;
            $this->feeperhour = $feeRate->feeperhour;
        } else {
            $this->reset(['editingId', 'class_names_id', 'total_hours_min', 'total_hours_max', 'feeperhour']);
        }
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->reset(['showModal', 'editingId', 'class_names_id', 'total_hours_min', 'total_hours_max', 'feeperhour']);
    }

    public function save()
    {
        $this->validate();

        FeeRate::updateOrCreate(
            ['id' => $this->editingId],
            [
                'class_names_id' => $this->class_names_id,
                'total_hours_min' => $this->total_hours_min,
                'total_hours_max' => $this->total_hours_max,
                'feeperhour' => $this->feeperhour,
            ]
        );

        $this->closeModal();
        session()->flash('success', 'Fee rate saved successfully.');
    }

    public function delete($id)
    {
        $feeRate = FeeRate::find($id);
        if ($feeRate) {
            $feeRate->delete();
            session()->flash('success', 'Fee rate deleted successfully.');
        }
    }
}
