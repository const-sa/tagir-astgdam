<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use App\Models\Vacation;
use App\Traits\livewireResource;

class Vacations extends Component
{
    use livewireResource;

    public $user;
    public $exit_at, $return_at, $user_return_at, $user_id;
    public $filter_employee_id = null;

    public function rules()
    {
        return [
            'user_id'   => $this->user ? 'nullable' : 'required',
            'exit_at'   => 'required',
            'return_at' => 'required',
        ];
    }

    public function updating($field)
    {
        if ($field === 'filter_employee_id') {
            $this->resetPage();
        }
    }

    public function mount($user = null)
    {
        if ($user) {
            $user = User::find($user);
            $this->user = $user;
        }
    }

    public function render()
    {
        $vacations = Vacation::with('user')
            ->when($this->filter_employee_id, function ($q) {
                $q->where('user_id', $this->filter_employee_id);
            })
            ->latest()
            ->paginate(10);
        return view('livewire.admin.vacations', compact('vacations'))
            ->extends('admin.layouts.admin')
            ->section('content');
    }

    public function beforeSubmit()
    {
        if ($this->user) {
            $this->data['user_id'] = $this->user->id;
        } else {
            $this->data['user_id'] = $this->user_id;
        }
    }

    public function extendReturnAt(Vacation $vacation)
    {
        $this->validate(['return_at' => 'required']);
        $vacation->update(['return_at' => $this->return_at, 'notified_at' => null]);
        $this->reset('return_at');
        $this->dispatch('alert', type: 'success', message: 'تم الحفظ بنجاح');
    }

    public function userReturnAt(Vacation $vacation)
    {
        $vacation->update(['user_return_at' => now()->format('Y-m-d')]);
        $this->dispatch('alert', type: 'success', message: 'تم تسجيل رجوع الموظف');
    }
}

