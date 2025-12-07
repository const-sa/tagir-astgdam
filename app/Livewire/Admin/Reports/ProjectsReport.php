<?php

namespace App\Livewire\Admin\Reports;

use App\Models\HiringProject;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class ProjectsReport extends Component
{
     use WithPagination;

    public $from_date;
    public $to_date;
    public $client_id;
    public $status_filter = 'all';
    public $clients = [];

    protected $paginationTheme = 'bootstrap';

    protected $queryString = [
        'from_date'     => ['except' => null],
        'to_date'       => ['except' => null],
        'client_id'     => ['except' => null],
        'status_filter' => ['except' => 'all'],
        'page'          => ['except' => 1],
    ];

    public function mount()
    {
        $this->clients = User::clients()->orderBy('name')->get();
    }

    public function updating($field)
    {
        if (in_array($field, ['from_date', 'to_date', 'client_id', 'status_filter'], true)) {
            $this->resetPage();
        }
    }

    protected function baseQuery()
    {
        $query = HiringProject::with('client');

        if ($this->client_id) {
            $query->where('client_id', $this->client_id);
        }

        if ($this->from_date) {
            $query->whereDate('start_date', '>=', $this->from_date);
        }

        if ($this->to_date) {
            $query->whereDate('start_date', '<=', $this->to_date);
        }

        return $query;
    }

    public function setStatusFilter(string $status): void
    {
        if (! in_array($status, ['all', 'finished', 'running'], true)) {
            return;
        }

        $this->status_filter = $status;
        $this->resetPage();
    }

    public function render()
    {
        $today     = now()->toDateString();
        $baseQuery = $this->baseQuery();
        $totalProjects    = (clone $baseQuery)->count();
        $finishedProjects = (clone $baseQuery)
            ->whereDate('end_date', '<=', $today)
            ->count();

        $runningProjects  = (clone $baseQuery)
            ->where(function ($q) use ($today) {
                $q->whereNull('end_date')
                  ->orWhereDate('end_date', '>', $today);
            })
            ->count();
        $projectsQuery = clone $baseQuery;

        if ($this->status_filter === 'finished') {
            $projectsQuery->whereDate('end_date', '<=', $today);
        } elseif ($this->status_filter === 'running') {
            $projectsQuery->where(function ($q) use ($today) {
                $q->whereNull('end_date')
                  ->orWhereDate('end_date', '>', $today);
            });
        }

        $projects = $projectsQuery->latest('id')->paginate(10);

        return view('livewire.admin.reports.projects-report', [
            'projects'         => $projects,
            'totalProjects'    => $totalProjects,
            'finishedProjects' => $finishedProjects,
            'runningProjects'  => $runningProjects,
            'status_filter'    => $this->status_filter,
            'clients'          => $this->clients,
        ]);
    }
}

