<?php

namespace App\Livewire\Admin\Reports;

use App\Models\HiringProject;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class ClientsReport extends Component
{
    use WithPagination;

    public $from_date;
    public $to_date;
    public $client_id;
    public $status_filter = 'all';
    public $clients = [];

    protected $paginationTheme = 'bootstrap';

    protected $queryString = [
        'from_date' => ['except' => null],
        'to_date'   => ['except' => null],
        'client_id' => ['except' => null],
        'status_filter' => ['except' => 'all'],
        'page'      => ['except' => 1],
    ];

    public function mount()
    {
        $this->clients = User::clients()->orderBy('name')->get();
    }

    public function updating($field)
    {
        if (in_array($field, ['from_date', 'to_date', 'client_id', 'status_filter'])) {
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
        $finishedProjects = (clone $baseQuery)->where('end_date', '<=', now()->toDateString())->count();
        $runningProjects  = (clone $baseQuery)->where('end_date', '>', now()->toDateString())->count();
        $projectsQuery = clone $baseQuery;
        if ($this->status_filter === 'finished') {
            $projectsQuery->whereDate('end_date', '<=', $today);
        } elseif ($this->status_filter === 'running') {
            $projectsQuery->whereDate('end_date', '>', $today);
        }
        $projects = $projectsQuery->latest('id')->paginate(10);
        $selectedClient = null;
        $contracts      = collect();
        $clientProjects = collect();
        $invoices       = collect();

        if ($this->client_id) {
            $selectedClient = User::with([
                'contracts',
                'projects.invoices',
            ])->find($this->client_id);

            if ($selectedClient) {
                $contracts      = $selectedClient->contracts ?? collect();
                $clientProjects = $selectedClient->hiringProjects ?? collect();
                $invoices       = $clientProjects->flatMap(function ($project) {
                    return $project->invoices ?? collect();
                });
            }
        }

        return view('livewire.admin.reports.clients-report', [
            'projects'         => $projects,
            'totalProjects'    => $totalProjects,
            'finishedProjects' => $finishedProjects,
            'runningProjects'  => $runningProjects,
            'selectedClient'   => $selectedClient,
            'contracts'        => $contracts,
            'clientProjects'   => $clientProjects,
            'invoices'         => $invoices,
            'status_filter'    => $this->status_filter,
        ]);
    }
}
