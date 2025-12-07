<?php

namespace App\Livewire\Admin;

use App\Models\HiringProject;
use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class HiringProjects extends Component
{
    use WithPagination,WithFileUploads;
  protected $paginationTheme = 'bootstrap';
    public $queryString = ['screen'];
    public $screen = 'index';
    public $project_id;
    public $title;
    public $client_id;
    public $client_phone;
    public $client_city;
    public $start_date;
    public $end_date;
    public $contract_file;
    public $workers_file;
    // public $workers_count;
    public $search = '';
    public $description;

    protected $rules = [
        'title'        => 'required|string|max:255',
        'client_id'    => 'required|exists:users,id',
        'start_date'   => 'nullable|date',
        'end_date'     => 'nullable|date|after_or_equal:start_date',
        // 'workers_count'=> 'nullable|integer|min:0',
        'contract_file'=> 'nullable',
        'workers_file' => 'nullable',
        'description'  => 'nullable|string',
    ];
    public function messages()
    {
        return [
            'title.required'     => 'حقل العنوان مطلوب',
            'client_id.required' => 'حقل العميل مطلوب',
            'client_id.exists'   => 'العميل المحدد غير موجود',
            'end_date.after_or_equal' => 'تاريخ الانتهاء يجب أن يكون بعد أو يساوي تاريخ البدء',
            // 'workers_count.integer'   => 'عدد العمال يجب أن يكون رقماً صحيحاً',
            // 'workers_count.min'       => 'عدد العمال لا يمكن أن يكون سالباً',
        ];
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatedClientId()
    {
        if ($this->client_id) {
            $client = User::find($this->client_id);
            if ($client) {
                $this->client_phone = $client->phone;
                $this->client_city  = optional($client->city)->name ?? null;
            }
        }
    }

    public function resetInputs()
    {
        $this->project_id   = null;
        $this->title        = null;
        $this->client_id    = null;
        $this->client_phone = null;
        $this->client_city  = null;
        $this->start_date   = null;
        $this->end_date     = null;
        $this->contract_file = null;
        $this->workers_file  = null;
        $this->description = null;
        // $this->workers_count = null;

    }

    public function create()
    {
        $this->resetInputs();
        $this->screen = 'create';
    }

    public function edit($id)
    {
        $project = HiringProject::findOrFail($id);
        $this->project_id   = $project->id;
        $this->title        = $project->title;
        $this->client_id    = $project->client_id;
        $this->client_phone = $project->client?->phone;
        $this->client_city  = $project->client?->city?->name;
        $this->start_date   = $project->start_date;
        $this->end_date     = $project->end_date;
        $this->description = $project->description;
        // $this->contract_file = $project->contract_file;
        // $this->workers_file  = $project->workers_file;
        // $this->workers_count = 1;
        $this->screen = 'edit';
    }

    public function delete($id)
    {
        $project = HiringProject::findOrFail($id);
        $project->delete();

        session()->flash('success', 'تم حذف المشروع بنجاح');
    }

    public function submit()
    {
        $data = $this->validate();
        $project = null;
        if ($this->project_id) {
            $project = HiringProject::findOrFail($this->project_id);
        }
        if ($this->contract_file) {
            if ($project && $project->contract_file) {
                delete_file($project->contract_file);
            }
            $data['contract_file'] = store_file($this->contract_file, 'contracts');
        }
        if ($this->workers_file) {
            if ($project && $project->workers_file) {
                delete_file($project->workers_file);
            }
            $data['workers_file'] = store_file($this->workers_file, 'workers_excels');
        }
        if ($project) {
            $project->update($data);
            $message = 'تم تحديث المشروع بنجاح';
        } else {
            $project = HiringProject::create($data);
            $message = 'تم إضافة المشروع بنجاح';
        }

        session()->flash('success', $message);

        $this->resetInputs();
        $this->screen = 'index';

        return redirect()->route('admin.hiring');
    }


    public function render()
    {
        $projects = HiringProject::with('client')
            ->when($this->search, function ($q) {
                $q->where('title', 'LIKE', "%{$this->search}%")
                  ->orWhereHas('client', function ($q2) {
                      $q2->where('name', 'LIKE', "%{$this->search}%");
                  });
            })
            ->latest()
            ->paginate(10);
        $activeCount   = HiringProject::whereDate('end_date', '>=', now())->count();
        $finishedCount = HiringProject::whereDate('end_date', '<', now())->count();

        $clients = User::clients()->select('id','name','phone','city_id')->get();

        return view('livewire.admin.hiring-projects', compact('projects', 'activeCount', 'finishedCount', 'clients'))
            ->extends('admin.layouts.admin')
            ->section('content');
    }
}
