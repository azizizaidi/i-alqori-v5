<?php

namespace App\Livewire\Admin;

use App\Models\ClassName;
use App\Models\ReportClass;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class ReportClasses extends Component
{
    use WithPagination;

    public $search = '';
    public $monthFilter = '';
    public $statusFilter = '';
    public $showModal = false;
    public $editingId = null;
    public $registrar_id = '';
    public $class_names_id = '';
    public $date = '';
    public $total_hour = '';
    public $class_names_id_2 = '';
    public $date_2 = '';
    public $total_hour_2 = '';
    public $fee_student = '';
    public $status = '';
    public $note = '';

    protected $rules = [
        'registrar_id' => 'required|exists:users,id',
        'class_names_id' => 'required|exists:class_names,id',
        'date' => 'required|string',
        'total_hour' => 'required|string',
        'fee_student' => 'nullable|string',
        'status' => 'nullable|integer',
        'note' => 'nullable|string',
    ];

    public function render()
    {
        $reportClasses = ReportClass::with(['registrar.user', 'createdBy.user', 'className', 'className2'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('month', 'like', "%{$this->search}%")
                        ->orWhere('note', 'like', "%{$this->search}%")
                        ->orWhereHas('registrar.user', function ($q2) {
                            $q2->where('name', 'like', "%{$this->search}%");
                        });
                });
            })
            ->when($this->monthFilter, function ($query) {
                $query->where('month', $this->monthFilter);
            })
            ->when($this->statusFilter !== '', function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $registrars = User::role('client')->get();
        $classNames = ClassName::all();

        return view('livewire.admin.report-classes', compact('reportClasses', 'registrars', 'classNames'));
    }

    public function openModal($id = null)
    {
        if ($id) {
            $report = ReportClass::find($id);
            $this->editingId = $id;
            $this->registrar_id = $report->registrar_id;
            $this->class_names_id = $report->class_names_id;
            $this->date = $report->date;
            $this->total_hour = $report->total_hour;
            $this->class_names_id_2 = $report->class_names_id_2;
            $this->date_2 = $report->date_2;
            $this->total_hour_2 = $report->total_hour_2;
            $this->fee_student = $report->fee_student;
            $this->status = $report->status;
            $this->note = $report->note;
        } else {
            $this->reset(['editingId', 'registrar_id', 'class_names_id', 'date', 'total_hour', 'class_names_id_2', 'date_2', 'total_hour_2', 'fee_student', 'status', 'note']);
        }
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->reset(['showModal', 'editingId', 'registrar_id', 'class_names_id', 'date', 'total_hour', 'class_names_id_2', 'date_2', 'total_hour_2', 'fee_student', 'status', 'note']);
    }

    public function save()
    {
        $this->validate();

        ReportClass::updateOrCreate(
            ['id' => $this->editingId],
            [
                'registrar_id' => $this->registrar_id,
                'class_names_id' => $this->class_names_id,
                'date' => $this->date,
                'total_hour' => $this->total_hour,
                'class_names_id_2' => $this->class_names_id_2 ?: null,
                'date_2' => $this->date_2 ?: null,
                'total_hour_2' => $this->total_hour_2 ?: null,
                'fee_student' => $this->fee_student ?: null,
                'status' => $this->status ?: 0,
                'note' => $this->note ?: null,
                'created_by_id' => auth()->id(),
                'month' => now()->format('m-Y'),
            ]
        );

        $this->closeModal();
        session()->flash('success', 'Report class saved successfully.');
    }

    public function delete($id)
    {
        $report = ReportClass::find($id);
        if ($report) {
            $report->delete();
            session()->flash('success', 'Report class deleted successfully.');
        }
    }

    public function restore($id)
    {
        $report = ReportClass::withTrashed()->find($id);
        if ($report) {
            $report->restore();
            session()->flash('success', 'Report class restored successfully.');
        }
    }
}
