<?php

namespace App\Livewire\Admin\Projects;

use App\Models\User;
use App\Models\Client;
use App\Models\Project;
use Livewire\Component;
use App\Traits\livewireResource;
use Mpdf\Tag\U;

class ProjectForm extends Component
{
    use livewireResource;
    public $title, $client_id, $start_at, $end_at, $expected_duration, $status, $image, $excel_file, $content, $teamwork = [];

    public function setModelName()
    {
        $this->model = Project::class;
    }
    public function rules()
    {
        return [
            // 'user_id' => 'required',
            'title' => 'required',
            'client_id' => 'required',
            'start_at' => 'required',
            'end_at' => 'required',
            'expected_duration' => 'required',
            'status' => 'required',
            'content' => 'nullable',
        ];
    }
    public function mount($id = null)
    {
        if ($id) {
            $this->edit($id);
            $this->teamwork = $this->obj->users()->pluck('user_id')->toArray();
        }
    }
    public function hydrate()
    {
        $this->dispatch('refreshSelect2');
    }
    public function render()
    {
        // $clients = Client::pluck('name', 'id')->toArray();
        $clients = User::clients()->pluck('name', 'id')->toArray();
        $employees = User::employes()->pluck('name', 'id')->toArray();
        return view('livewire.admin.projects.project-form', compact('clients', 'employees'));
    }

    public function beforeSubmit()
    {
        $this->data['user_id'] = auth()->id();
        if ($this->image) {
            $this->data['image'] = store_file($this->image, 'projects');
        }
        if ($this->excel_file) {
            $this->data['excel_file'] = store_file($this->excel_file, 'projects');
        }
    }

    public function afterSubmit()
    {
        $this->obj->users()->sync($this->teamwork);
        return redirect()->route('admin.projects')->with('success', 'تم بنجاح');
    }
}
