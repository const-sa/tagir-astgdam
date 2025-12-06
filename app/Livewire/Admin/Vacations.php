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

    public $filter_approval_status = null;
    public $filter_exit_status = null;
    public $filter_return_status = null;


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
        // $vacations = Vacation::with('user')
        //     ->when($this->filter_employee_id, function ($q) {
        //         $q->where('user_id', $this->filter_employee_id);
        //     })
        //     ->latest()
        //     ->paginate(10);
        $query = Vacation::with('user');

        if ($this->filter_employee_id) {
            $query->where('user_id', $this->filter_employee_id);
        }

        if ($this->filter_approval_status) {
            $query->where('approval_status', $this->filter_approval_status);
        }

        if ($this->filter_exit_status === 'exited') {
            $query->whereNotNull('exit_done_at');
        } elseif ($this->filter_exit_status === 'not_exited') {
            $query->whereNull('exit_done_at');
        }

        if ($this->filter_return_status === 'returned') {
            $query->whereNotNull('user_return_at');
        } elseif ($this->filter_return_status === 'not_returned') {
            $query->whereNull('user_return_at');
        }

        $vacations = $query->latest()->paginate(10);

        // الإحصائيات
        $stats = [
            'pending'       => Vacation::where('approval_status', 'pending')->count(),
            'approved'      => Vacation::where('approval_status', 'approved')->count(),
            'rejected'      => Vacation::where('approval_status', 'rejected')->count(),
            'exited'        => Vacation::whereNotNull('exit_done_at')->count(),
            'not_exited'    => Vacation::whereNull('exit_done_at')->count(),
            'returned'      => Vacation::whereNotNull('user_return_at')->count(),
            'not_returned'  => Vacation::whereNull('user_return_at')->count(),
        ];
        return view('livewire.admin.vacations', compact('vacations', 'stats'))
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


    public function approveVacation(Vacation $vacation)
    {
        $vacation->update(['approval_status' => 'approved']);
        $this->dispatch('alert', type: 'success', message: 'تمت الموافقة على الطلب');
    }

    public function rejectVacation(Vacation $vacation)
    {
        $vacation->update(['approval_status' => 'rejected']);
        $this->dispatch('alert', type: 'success', message: 'تم رفض الطلب');
    }

    public function confirmExit(Vacation $vacation)
    {
        $vacation->update(['exit_done_at' => now()->format('Y-m-d')]);
        $this->dispatch('alert', type: 'success', message: 'تم تسجيل خروج الموظف');
    }

    public function filterByStatus($status)
    {
        $this->filter_approval_status = $status;
        $this->resetPage();
    }

    public function filterByExit($status)
    {
        $this->filter_exit_status = $status;
        $this->resetPage();
    }

    public function filterByReturn($status)
    {
        $this->filter_return_status = $status;
        $this->resetPage();
    }
}
