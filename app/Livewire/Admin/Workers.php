<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\HiringProject;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class Workers extends Component
{
    use WithPagination;
      protected $paginationTheme = 'bootstrap';

    public $queryString = ['screen'];
    public $screen = 'index';

    public $worker_id;
    public $name;
    public $id_number;
    public $phone;
    public $nationality;
    public $is_hired = false;
    public $hiring_project_id;
    public $hire_start_date;
    public $hire_end_date;
    public $search = '';

    protected $rules = [
        'name'              => 'required|string|max:255',
        'id_number'         => 'nullable|string|max:255',
        'phone'             => 'nullable|string|max:255',
        'nationality'       => 'nullable|string|max:255',
        'is_hired'          => 'boolean',
        'hiring_project_id' => 'nullable|exists:hiring_projects,id',
        'hire_start_date'   => 'nullable|date',
        'hire_end_date'     => 'nullable|date|after_or_equal:hire_start_date',
    ];

    public function messages()
    {
        return [
            'name.required' => 'حقل اسم العامل مطلوب',
            'hiring_project_id.exists' => 'المشروع المحدد غير موجود',
            'hire_end_date.after_or_equal' => 'تاريخ نهاية التأجير يجب أن يكون بعد أو يساوي بداية التأجير',
        ];
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function resetInputs()
    {
        $this->worker_id        = null;
        $this->name             = null;
        $this->id_number        = null;
        $this->phone            = null;
        $this->nationality      = null;
        $this->is_hired         = false;
        $this->hiring_project_id = null;
        $this->hire_start_date  = null;
        $this->hire_end_date    = null;
    }

    public function create()
    {
        $this->resetInputs();
        $this->screen = 'create';
    }

    public function edit($id)
    {
        $worker = User::workers()->findOrFail($id);

        $this->worker_id        = $worker->id;
        $this->name             = $worker->name;
        $this->id_number        = $worker->id_number ?? null;
        $this->phone            = $worker->phone;
        $this->nationality      = $worker->nationality ?? null;
        $this->is_hired         = (bool) $worker->is_hired;
        $this->hiring_project_id = $worker->hiring_project_id ?? null;
        $this->hire_start_date  = $worker->hire_start_date;
        $this->hire_end_date    = $worker->hire_end_date;

        $this->screen = 'edit';
    }

    public function delete($id)
    {
        $worker = User::workers()->findOrFail($id);
        $worker->delete();

        session()->flash('success', 'تم حذف العامل بنجاح');
    }

    public function submit()
    {
        $data = $this->validate();
        $data['type'] = 'worker';
        if (! $this->is_hired) {
            $data['hiring_project_id'] = null;
            $data['hire_start_date']   = null;
            $data['hire_end_date']     = null;
        }

        if ($this->worker_id) {
            $worker = User::workers()->findOrFail($this->worker_id);
            $worker->update($data);
            $message = 'تم تحديث بيانات العامل بنجاح';
        } else {
            $data['password'] = Str::random(16);
            User::create($data);
            $message = 'تم إضافة العامل بنجاح';
        }

        session()->flash('success', $message);

        $this->resetInputs();
        $this->screen = 'index';

        return redirect()->route('admin.workers');
    }

    public function render()
    {
        $workersQuery = User::workers()
        ->with('currentHiringProject')
        ->when($this->search, function ($q) {
            $search = $this->search;
            $q->where(function ($query) use ($search) {
                $query->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('phone', 'LIKE', "%{$search}%")
                    ->orWhere('id_number', 'LIKE', "%{$search}%");
            });
            $q->where('is_hired', 1);
        })
        ->latest();

        $workers = $workersQuery->paginate(10);

        $hiredCount     = User::workers()->where('is_hired', 1)->count();
        $notHiredCount  = User::workers()->where('is_hired', 0)->count();

        $projects = HiringProject::select('id', 'title')->latest()->get();

        return view('livewire.admin.workers', compact('workers', 'hiredCount', 'notHiredCount', 'projects'))
            ->extends('admin.layouts.admin')
            ->section('content');
    }
}
