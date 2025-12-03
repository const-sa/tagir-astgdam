<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Job;
use App\Models\User;
use App\Traits\livewireResource;

class Jobs extends Component
{
    use livewireResource;

    public $model = Job::class;
    public $name;
    public $screen = 'index';

    public $queryString = ['screen'];

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:jobs,name,' . ($this->obj->id ?? 'null'),
        ];
    }

    public function setModelName()
    {
        $this->model = Job::class;
    }

    //  public function whileEditing()
    // {
    //     $this->name = $this->obj->name;
    // }

    public function render()
    {
        if (request('id') && $this->screen == 'edit') {
        $this->edit(request('id'));
    }
        $jobs = Job::withCount('employees')->latest()->paginate(10);

        return view('livewire.admin.jobs', compact('jobs'))
            ->extends('admin.layouts.admin')
            ->section('content');
    }

    public function afterSubmit()
    {
        session()->flash('success', 'تم حفظ المهنة بنجاح');
        $this->screen = 'index';
        $this->resetInputs();
    }

    public function beforeDelete($id)
    {
        $job = Job::withCount('employees')->findOrFail($id);

        if ($job->employees_count > 0) {
            session()->flash('error', 'لا يمكن حذف مهنة مرتبطة بموظفين.');
            return false;
        }

        return true;
    }
}

