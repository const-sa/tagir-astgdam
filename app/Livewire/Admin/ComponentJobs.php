<?php

namespace App\Livewire\Admin;

use App\Models\Job;
use App\Traits\livewireResource;
use Livewire\Component;

class ComponentJobs extends Component
{

    use livewireResource;
    public $name, $search;
    public function rules()
    {
        return ['name' => 'required'];
    }

    public function setModelName()
    {
        $this->model = 'App\Models\Job';
    }
    public function render()
    {
        $jobs = Job::withCount('employees')->where(function ($q) {
            if ($this->search) {
                $q->where('name', 'LIKE', "%" . $this->search . "%");
            }
        })->latest('id')->paginate();
        return view('livewire.admin.component-jobs', compact('jobs'))->extends('admin.layouts.admin')->section('content');
    }
}
