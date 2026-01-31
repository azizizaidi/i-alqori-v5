<?php

namespace App\Livewire\Admin;

use App\Models\ClassName;
use Livewire\Component;

class CalculatorFee extends Component
{
    public $selectedClass = '';
    public $totalHours = '';
    public $feePerHour = 0;
    public $calculatedFee = 0;
    public $allowancePerHour = 0;
    public $calculatedAllowance = 0;

    protected $rules = [
        'selectedClass' => 'required|exists:class_names,id',
        'totalHours' => 'required|numeric|min:0',
    ];

    public function updatedSelectedClass($value)
    {
        if ($value) {
            $class = ClassName::find($value);
            $this->feePerHour = $class->feeperhour;
            $this->allowancePerHour = $class->allowanceperhour;
            $this->calculate();
        }
    }

    public function updatedTotalHours($value)
    {
        $this->calculate();
    }

    public function calculate()
    {
        $this->calculatedFee = $this->feePerHour * (float) $this->totalHours;
        $this->calculatedAllowance = $this->allowancePerHour * (float) $this->totalHours;
    }

    public function render()
    {
        $classNames = ClassName::all();

        return view('livewire.admin.calculator-fee', compact('classNames'));
    }
}
