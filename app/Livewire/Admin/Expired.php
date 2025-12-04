<?php

namespace App\Livewire\Admin;

use App\Models\Governmental;
use App\Models\User;
use App\Traits\livewireResource;
use Livewire\Component;
use Livewire\WithPagination;

// class Expired extends Component
// {

//     use livewireResource;

//     public $page;
//     public $govern = 'yes';
//     protected function rules()
//     {
//         return [];
//     }

//     public function render()
//     {


//         $governmentals = [];
//         if (!$this->page && $this->govern == 'yes') {
//             $governmentals = Governmental::whereDate('expire_date', '<', now())
//                 ->latest()->paginate(10);
//         }
//         $items = User::where(function ($q) {
//             if ($this->page) {
//                 $q->whereDate($this->page, '<', now());
//             }
//         })->latest()->paginate(10);
//         return view('livewire.admin.expired', compact('items', 'governmentals'))->extends('admin.layouts.admin')->section('content');
//     }


//     // public function render()
//     // {
//     //     $governmentals = Governmental::where(function ($q) {
//     //         if (request('expired')) {
//     //             $q->whereDate('expire_date', '<', now());
//     //         }
//     //     })->latest()->paginate(10);
//     //     return view('livewire.admin.governmentals', compact('governmentals'))->extends('admin.layouts.admin')->section('content');
//     // }
// }
class Expired extends Component
{
    use WithPagination;
    public ?string $page = null;
    public string $govern = 'yes';
    protected $queryString = [
        'page'   => ['except' => null],
        'govern' => ['except' => 'yes'],
    ];
    public const FILE_MAP = [
        'end_id_number'   => 'file_end_id_number',
        'end_insurance'   => 'file_end_insurance',
        'end_passport'    => 'file_end_passport',
        'end_driver_card' => 'file_driver_card',
        'end_health_card' => 'file_health_card',
        'end_is_employee' => 'file_is_employee',
        'end_resident'    => 'file_resident',
    ];
    public const USER_DATE_FIELDS = [
        'end_id_number',
        'end_insurance',
        'end_passport',
        'end_driver_card',
        'end_health_card',
        'end_is_employee',
        'end_resident',
    ];

    public function render()
    {
        $expiredCounts = $this->makeCounts();
        $governmentals = collect();
        $items         = collect();

        if (!$this->page && $this->govern === 'yes') {
            $governmentals = Governmental::whereDate('expire_date', '<', now())
                ->latest()->paginate(10);
        } else {
            $items = User::query()
                ->when($this->page, function ($q) {
                    $q->whereDate($this->page, '<', now());
                })
                ->latest()->paginate(10);
        }

        return view('livewire.admin.expired', [
            'governmentals'   => $governmentals,
            'items'           => $items,
            'expired_counts'  => $expiredCounts,
            'current_file_key'=> $this->resolveFileKey($this->page),
        ])
        ->extends('admin.layouts.admin')
        ->section('content');
    }
    protected function makeCounts(): array
    {
        $counts = [
            'governmentals' => Governmental::whereDate('expire_date', '<', now())->count(),
        ];

        foreach (self::USER_DATE_FIELDS as $field) {
            $counts[$field] = User::whereDate($field, '<', now())->count();
        }

        $counts['total'] = array_sum($counts);
        return $counts;
    }
    protected function resolveFileKey(?string $page): ?string
    {
        if (!$page) return null;
        return self::FILE_MAP[$page] ?? ('file_' . $page);
    }
    public function showGovernmentals()
    {
        $this->resetPage();
        $this->page = null;
        $this->govern = 'yes';
    }

    public function filterUserBy(string $field)
    {
        if (!in_array($field, self::USER_DATE_FIELDS, true)) {
            return;
        }
        $this->resetPage();
        $this->govern = 'no';
        $this->page   = $field;
    }
}
