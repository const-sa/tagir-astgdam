<?php

namespace App\Livewire\Admin\Reports;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class LaborsReport extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $genderFilter = null;
    public $statusFilter = null;
    public $search = '';

    public function updatingGenderFilter()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function setGenderFilter($gender = null)
    {
        $this->genderFilter = $gender ?: null;
    }

    public function setStatusFilter($status = null)
    {
        $this->statusFilter = $status ?: null;
    }

    protected function baseQuery()
    {
        $q = User::employes();

        if ($this->genderFilter) {
            $q->where('gender', $this->genderFilter);
        }

        if ($this->statusFilter) {
            $q->where('status', $this->statusFilter);
        }

        if ($this->search) {
            $s = trim($this->search);

            $q->where(function ($qq) use ($s) {
                $qq->where('name', 'LIKE', "%{$s}%")
                    ->orWhere('id_number', 'LIKE', "%{$s}%")
                    ->orWhere('phone', 'LIKE', "%{$s}%");
            });
        }

        return $q;
    }

    public function render()
    {
        $baseCountsQuery = User::employes();

        $totalLabors = (clone $baseCountsQuery)->count();
        $maleCount   = (clone $baseCountsQuery)->where('gender', 'male')->count();
        $femaleCount = (clone $baseCountsQuery)->where('gender', 'female')->count();

        $statusCounts = [
            'active'          => (clone $baseCountsQuery)->where('status', 'active')->count(),
            'inactive'        => (clone $baseCountsQuery)->where('status', 'inactive')->count(),
            'resigned'        => (clone $baseCountsQuery)->where('status', 'resigned')->count(),
            'fired'           => (clone $baseCountsQuery)->where('status', 'fired')->count(),
            'death'           => (clone $baseCountsQuery)->where('status', 'death')->count(),
            'exit_and_return' => (clone $baseCountsQuery)->where('status', 'exit_and_return')->count(),
            'final_exit'      => (clone $baseCountsQuery)->where('status', 'final_exit')->count(),
        ];
        $employees = $this->baseQuery()
            ->select('id', 'name', 'id_number', 'phone', 'gender', 'status')
            ->latest('id')
            ->paginate(15);

        return view('livewire.admin.reports.labors-report', [
            'totalLabors'   => $totalLabors,
            'maleCount'     => $maleCount,
            'femaleCount'   => $femaleCount,
            'statusCounts'  => $statusCounts,
            'employees'     => $employees,
        ]);
    }

   

    public function resetFilters()
    {
        $this->genderFilter = null;
        $this->statusFilter = null;
        $this->search       = '';
        $this->resetPage();
    }

}

