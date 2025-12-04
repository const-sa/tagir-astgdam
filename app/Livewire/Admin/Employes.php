<?php

namespace App\Livewire\Admin;

use App\Models\PriceQuotationJob;
use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Str;
use App\Exports\EmployesExport;
use App\Exports\EmployesImportExampleExport;
use App\Models\InsuranceCompany;
use App\Models\Job;
use App\Models\Nationality;
use App\Traits\livewireResource;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Employes extends Component
{

    use livewireResource;

    public $queryString = ['screen'];
    public $user_id, $name, $first_name, $last_name, $work_type_id, $filter_work_type_id, $second_name, $email, $password, $filter_status, $search_employeeId, $search_name_number, $filter_nationality,
        $type = 'employe', $status, $phone, $nationality, $start_id_number, $job, $start_work, $image;
    public $id_number, $end_id_number, $end_work, $end_passport, $end_insurance, $address, $bank_account, $insurance_company_id;
    public $import_file, $gender, $nationality_id, $filter_gender;
    public $health_card, $start_health_card, $end_health_card;
    public $driver_card, $start_driver_card, $end_driver_card;
    public $is_employee, $start_is_employee, $end_is_employee;
    public $resident, $start_resident, $end_resident, $search_side_job;
    public $job_id;
    public $file_end_id_number, $file_end_insurance, $file_end_passport, $file_health_card, $file_is_employee, $file_resident, $file_driver_card;

    public $model = User::class;

    public $employer_number;
    public $social_insurance;
    // job details
    public $vacation;
    public $vacation_days;
    public $vacation_cost;
    public $vacation_ticket_cost;
    public $end_of_service_cost;
    public $end_of_service_ticket_cost;

    public $side_job, $side_job_id, $price_quotation_job_id,$jobs=[];


    public function updatedSideJobId(): void
    {
        if ($this->side_job_id) {
            $this->side_job = User::find($this->side_job_id);
        }
    }

    public function updated($field): void
    {
        if (in_array($field, ['price_quotation_job_id', 'start_work', 'side_job_id'])) {
            if ($field == 'side_job_id') {
                $this->jobs =  PriceQuotationJob::select('id', 'job_title')
                    ->whereRelation('priceQuotation', 'client_id', $this->side_job_id)
                    ->get();
            }

            $this->calculateVacation();
        }
    }

    private function calculateVacation()
    {
        if ($this->price_quotation_job_id && $this->start_work) {
            $price_quotation_job = PriceQuotationJob::find($this->price_quotation_job_id);
            $startWorkFrom = Carbon::parse($this->start_work)->diffInMonths();
            $contract_duration = ($price_quotation_job->vacation) ? ($price_quotation_job->vacation === 'one_year' ? 12 : 24) : 0;
            $this->vacation = $price_quotation_job->vacation;
            $vacation_fields = [
                'vacation_days',
                'vacation_cost',
                'vacation_ticket_cost',
                'end_of_service_cost',
                'end_of_service_ticket_cost',
            ];
            foreach ($vacation_fields as $vacation_field) {
                $this->$vacation_field = round($price_quotation_job->$vacation_field / $contract_duration * $startWorkFrom, 2);
            }
        }

    }

    public function setModelName()
    {
        $this->model = 'App\Models\User';
    }

    public function whileEditing()
    {
        $this->side_job = User::find($this->side_job_id);
        $this->calculateVacation();
        $this->jobs =  PriceQuotationJob::select('id', 'job_title')
            ->whereRelation('priceQuotation', 'client_id', $this->side_job_id)
            ->get();
    }

    protected function rules()
    {
        return [
            'name' => ['string', 'required'],
            'first_name' => ['required', 'string'],
            'second_name' => ['required', 'string'],
            'last_name' => ['nullable', 'string'],
            'nationality' => ['required', 'string'],
            'id_number' => ['required', 'digits:10'],
            'start_id_number' => ['nullable'],
            'end_id_number' => ['nullable'],
            'email' => ['required', 'email', 'unique:users,email,' . $this->obj?->id],
            'password' => ['required_without:obj'],
            'phone' => ['required'],
            'status' => ['required'],
            // 'job' => ['required'],
            'start_work' => ['nullable'],
            'end_insurance' => ['nullable'],
            'image' => ['nullable'],
            'gender' => ['nullable'],
            'work_type_id' => ['nullable'],
            'side_job_id' => ['nullable'],
            // 'price_quotation_job_id' => 'required',
            'job_id' => 'required|exists:jobs,id',


            'type' => ['nullable'],
            'nationality_id' => ['nullable'],
            'insurance_company_id' => 'nullable',
            'end_passport' => 'nullable',


            'health_card' => ['nullable'],
            'start_health_card' => 'required_if:health_card,1',
            'end_health_card' => 'required_if:health_card,1',

            'driver_card' => ['nullable'],
            'start_driver_card' => 'required_if:driver_card,1',
            'end_driver_card' => 'required_if:driver_card,1',

            'is_employee' => ['nullable'],
            'start_is_employee' => 'required_if:is_employee,1',
            'end_is_employee' => 'required_if:is_employee,1',

            'resident' => ['nullable'],
            'start_resident' => 'required_if:resident,1',
            'end_resident' => 'required_if:resident,1',
            'social_insurance' => 'nullable',
            'employer_number' => 'nullable',

        ];
    }


    public function export()
    {
        $allEmployes = User::employes()->get();
        return Excel::download(new EmployesExport($allEmployes), 'employes' . time() . '.xlsx');
    }

    public function beforeSubmit()
    {
        if ($this->password) {
            $this->data['password'] = Hash::make($this->password);
        } else {
            $this->data['password'] = $this->obj->password;
        }

        if ($this->image) {
            if ($this->obj) {
                if ($this->obj->image !== $this->image) {
                    delete_file($this->obj->image);
                    $this->data['image'] = store_file($this->image, 'employes');
                }
            } else {
                $this->data['image'] = store_file($this->image, 'employes');
            }
        }


        if ($this->file_end_id_number) {
            if ($this->obj) {
                if ($this->obj->file_end_id_number !== $this->file_end_id_number) {
                    delete_file($this->obj->file_end_id_number);
                    $this->data['file_end_id_number'] = store_file($this->file_end_id_number, 'employes');
                }
            } else {
                $this->data['file_end_id_number'] = store_file($this->file_end_id_number, 'employes');
            }
        }


        if ($this->file_end_insurance) {
            if ($this->obj) {
                if ($this->obj->file_end_insurance !== $this->file_end_insurance) {
                    delete_file($this->obj->file_end_insurance);
                    $this->data['file_end_insurance'] = store_file($this->file_end_insurance, 'employes');
                }
            } else {
                $this->data['file_end_insurance'] = store_file($this->file_end_insurance, 'employes');
            }
        }


        if ($this->file_end_passport) {
            if ($this->obj) {
                if ($this->obj->file_end_passport !== $this->file_end_passport) {
                    delete_file($this->obj->file_end_passport);
                    $this->data['file_end_passport'] = store_file($this->file_end_passport, 'employes');
                }
            } else {
                $this->data['file_end_passport'] = store_file($this->file_end_passport, 'employes');
            }
        }

        if ($this->file_health_card) {
            if ($this->obj) {
                if ($this->obj->file_health_card !== $this->file_health_card) {
                    delete_file($this->obj->file_health_card);
                    $this->data['file_health_card'] = store_file($this->file_health_card, 'employes');
                }
            } else {
                $this->data['file_health_card'] = store_file($this->file_health_card, 'employes');
            }
        }


        if ($this->file_is_employee) {
            if ($this->obj) {
                if ($this->obj->file_is_employee !== $this->file_is_employee) {
                    delete_file($this->obj->file_is_employee);
                    $this->data['file_is_employee'] = store_file($this->file_is_employee, 'employes');
                }
            } else {
                $this->data['file_is_employee'] = store_file($this->file_is_employee, 'employes');
            }
        }
        if ($this->file_resident) {
            if ($this->obj) {
                if ($this->obj->file_resident !== $this->file_resident) {
                    delete_file($this->obj->file_resident);
                    $this->data['file_resident'] = store_file($this->file_resident, 'employes');
                }
            } else {
                $this->data['file_resident'] = store_file($this->file_resident, 'employes');
            }
        }
        if ($this->file_driver_card) {
            if ($this->obj) {
                if ($this->obj->file_driver_card !== $this->file_driver_card) {
                    delete_file($this->obj->file_driver_card);
                    $this->data['file_driver_card'] = store_file($this->file_driver_card, 'employes');
                }
            } else {
                $this->data['file_driver_card'] = store_file($this->file_driver_card, 'employes');
            }
        }
    }

    public function resetFilter()
    {
        $this->reset([
            'search_employeeId',
            'search_name_number',
            'search_side_job',
            'filter_status',
            'filter_nationality',
            'filter_work_type_id',
        ]);
    }

    public function render()
    {
        $users = User::employes()->where(function ($q) {
            if ($this->search_employeeId) {
                $q->where('id', 'LIKE', '%' . $this->search_employeeId . '%');
            }
            if ($this->search_name_number) {
                $q->where('phone', 'LIKE', '%' . $this->search_name_number . '%');
            }
            if ($this->search_side_job) {
                $q->where('side_job', 'LIKE', '%' . $this->search_side_job . '%');
            }
            if (request('status')) {
                $q->where('status', request('status'));
            }
            if ($this->filter_status) {
                $q->where('status', $this->filter_status);
            }
            if ($this->filter_gender) {
                $q->where('gender', $this->filter_gender);
            }
            if ($this->filter_nationality) {
                $q->where('nationality', $this->filter_nationality);
            }
            if ($this->filter_work_type_id) {
                $q->where('work_type_id', $this->filter_work_type_id);
            }
             if (request('job')) {
                $q->whereHas('jobrelation', function ($jobQuery) {
                    $jobQuery->where('id', request('job'));
                });
            }
        })->latest()->paginate(10);

        $nationalities = Nationality::all();


        if (request('employee_id') && $this->screen = 'edit') {
            $this->edit(request('employee_id'));
            $this->nationality_id = $this->obj->nationality_id;
        }
        return view('livewire.admin.employes', compact('users', 'nationalities'))->extends('admin.layouts.admin')->section('content');
    }


    public function deleteAll()
    {
        $delete = User::employes()->withTrashed()->forceDelete();
        // $this->dispatch('alert', ['type' => 'success', 'message' => __('Deleted.')]);
        session()->flash('success', 'تم الحذف بنجاح');
    }

    public function delete($id)
    {
        $delete = $this->model::findOrFail($id);
        $delete->delete();
        // $this->dispatch('alert', ['type' => 'success', 'message' => __('Deleted.')]);
        session()->flash('success', 'تم الارشفه بنجاح');
    }

    public function softDelete($id)
    {
        $delete = $this->model::withTrashed()->find($id);
        $delete->forceDelete();
        // $this->dispatch('alert', ['type' => 'success', 'message' => __('Deleted.')]);
        session()->flash('success', 'تم الحذف بنجاح');
    }

    public function restore($id)
    {
        $delete = $this->model::withTrashed()->find($id);
        $delete->restore();
        // $this->dispatch('alert', ['type' => 'success', 'message' => __('Deleted.')]);
        session()->flash('success', 'تم حذف الارشفه بنجاح');
    }

    // public function uploadExcelFile()
    // {
    //     $this->validate(
    //         [
    //             'import_file' => 'required|file',
    //             // 'excel_company_id' => 'required',
    //         ],
    //         [
    //             'import_file.required' => __('Excel Input required'),
    //             'import_file.file' => __('Excel Input must be a file')
    //         ]
    //     );
    //     try {
    //         $file = $this->import_file;
    //         $spreadsheet = IOFactory::load($file->getRealPath());
    //         $sheet = $spreadsheet->getSheet(0);
    //         $maxcols = $sheet->getHighestRow();
    //         // dd($maxcols);
    //         for ($i = 7; $i <= $maxcols; $i++) {
    //             // start data to save
    //             $idNumber = $sheet->getCell("B$i")->getValue(); // Id Number
    //             $userFullName = $sheet->getCell("C$i")->getValue(); // Name
    //             $contractStartAt = $sheet->getCell("D$i")->getValue();
    //             $mobile = $sheet->getCell("E$i")->getValue();
    //             $email = $sheet->getCell("F$i")->getValue();
    //             $passportNumber = $sheet->getCell("G$i")->getValue();
    //             $passportExpiredDate = $sheet->getCell("H$i")->getValue();
    //             $idNumberStartAt = $sheet->getCell("I$i")->getValue();
    //             $idNumberExpiredDate = $sheet->getCell("J$i")->getValue();
    //             $birthDay = $sheet->getCell("K$i")->getValue();
    //             $insuranceExpiredAt = $sheet->getCell("L$i")->getValue();
    //             $insuranceName = $sheet->getCell("M$i")->getValue();
    //             $job = $sheet->getCell("P$i")->getValue();

    //             // $companyName = $sheet->getCell("D$i")->getValue(); //
    //             // $status = $sheet->getCell("K$i")->getValue();
    //             // end date to save
    //             // dd($contractStartAt);
    //             $nameArray = explode(' ', $userFullName);
    //             // $company = (!is_null($companyName)) ? Company::firstOrCreate(['name' => $companyName], ['name' => $companyName]) : null;
    //             $insuranceCompany = (!is_null($insuranceName)) ? InsuranceCompany::firstOrCreate(['name' => $insuranceName], ['name' => $insuranceName]) : null;
    //             if (!is_null($idNumber)) {
    //                 $userExists = User::withTrashed()->where('id_number', $idNumber)->first();
    //                 if ($userExists?->deleted_at) { // delete user if actually deleted to add user again from file
    //                     $userExists->forceDelete();
    //                     $userExists = null;
    //                 }
    //                 if (!$userExists) {
    //                     $user = User::create([
    //                         'type' => 'employe',
    //                         'id_number' => $idNumber,
    //                         'name' => $userFullName,
    //                         'start_id_number' => $this->excelToObjectDate($idNumberExpiredDate),
    //                         'end_id_number' => $this->excelToObjectDate($idNumberExpiredDate),
    //                         'password' => bcrypt(Str::random(15)),
    //                         'email' => $email,
    //                         'phone' => Str::startsWith($mobile, '5') ? '0' . $mobile : null,
    //                         'active' => 1,
    //                         'status' => 'active',
    //                         'end_passport' => $this->excelToObjectDate($passportExpiredDate),
    //                         'end_insurance' => $this->excelToObjectDate($insuranceExpiredAt),
    //                         'insurance_company_id' => $insuranceCompany?->id,
    //                         'start_work' => $this->excelToObjectDate($contractStartAt),
    //                         'birthday' => $this->excelToObjectDate($birthDay),
    //                         'passport_number' => $passportNumber,
    //                         'first_name' => isset($nameArray[0]) ? $nameArray[0] : null,
    //                         'second_name' => isset($nameArray[1]) ? $nameArray[1] : null,
    //                         'last_name' => (isset($nameArray[2]) ? $nameArray[2] : null) . ' ' . (isset($nameArray[3]) ? $nameArray[3] : null),
    //                         'job' => $job
    //                     ]);
    //                 } else {
    //                     $userExists->update([
    //                         'id_number' => $idNumber,
    //                         'name' => $userFullName,
    //                         'start_id_number' => $this->excelToObjectDate($idNumberExpiredDate),
    //                         'end_id_number' => $this->excelToObjectDate($idNumberExpiredDate),
    //                         'password' => bcrypt(Str::random(15)),
    //                         'email' => $email,
    //                         'phone' => Str::startsWith($mobile, '5') ? '0' . $mobile : null,
    //                         'active' => 1,
    //                         'status' => 'active',
    //                         'end_passport' => $this->excelToObjectDate($passportExpiredDate),
    //                         'end_insurance' => $this->excelToObjectDate($insuranceExpiredAt),
    //                         'insurance_company_id' => $insuranceCompany?->id,
    //                         'start_work' => $this->excelToObjectDate($contractStartAt),
    //                         'birthday' => $this->excelToObjectDate($birthDay),
    //                         'passport_number' => $passportNumber,
    //                         'first_name' => isset($nameArray[0]) ? $nameArray[0] : null,
    //                         'second_name' => isset($nameArray[1]) ? $nameArray[1] : null,
    //                         'last_name' => (isset($nameArray[2]) ? $nameArray[2] : null) . ' ' . (isset($nameArray[3]) ? $nameArray[3] : null),
    //                         'job' => $job
    //                     ]);
    //                 }
    //             }

    //             $this->reset([
    //                 'import_file',
    //                 // 'excel_company_id'
    //             ]);
    //         }
    //         $this->dispatch('alert', type: 'success', message: 'تم الرفع بنجاح');
    //     } catch (\Exception $e) {
    //         $this->dispatch('alert', type: 'error', message: 'حدث خطأ اثناء الرفع برجاء التأكد من ترتيب الملف والبيانات واعد المحاولة' . $e->getMessage());
    //     }
    // }
    public function uploadExcelFile()
{
    $this->validate(
        [
            'import_file' => 'required|file',
        ],
        [
            'import_file.required' => __('Excel Input required'),
            'import_file.file' => __('Excel Input must be a file')
        ]
    );

    try {
        $file = $this->import_file;
        $spreadsheet = IOFactory::load($file->getRealPath());
        $sheet = $spreadsheet->getSheet(0);
        $maxRows = $sheet->getHighestRow();
        for ($i = 2; $i <= $maxRows; $i++) {
            $idNumber            = $sheet->getCell("A$i")->getValue();
            $userFullName        = $sheet->getCell("B$i")->getValue();
            $contractStartAt     = $sheet->getCell("C$i")->getValue();
            $mobile              = $sheet->getCell("D$i")->getValue();
            $email               = $sheet->getCell("E$i")->getValue();
            $passportNumber      = $sheet->getCell("F$i")->getValue();
            $passportExpiredDate = $sheet->getCell("G$i")->getValue();
            $idNumberStartAt     = $sheet->getCell("H$i")->getValue();
            $idNumberExpiredDate = $sheet->getCell("I$i")->getValue();
            $birthDay            = $sheet->getCell("J$i")->getValue();
            $insuranceExpiredAt  = $sheet->getCell("K$i")->getValue();
            $insuranceName       = $sheet->getCell("L$i")->getValue();
            $jobName             = $sheet->getCell("M$i")->getValue();
            $nameArray = explode(' ', trim($userFullName));
            $insuranceCompany = (!is_null($insuranceName) && $insuranceName != '')
                ? InsuranceCompany::firstOrCreate(['name' => $insuranceName], ['name' => $insuranceName])
                : null;
            $jobModel = null;
            if (!is_null($jobName) && $jobName != '') {
                $jobModel = Job::firstOrCreate(['name' => $jobName], ['name' => $jobName]);
            }

            if (!is_null($idNumber) && $idNumber != '') {

                $userExists = User::withTrashed()->where('id_number', $idNumber)->first();
                if ($userExists?->deleted_at) {
                    $userExists->forceDelete();
                    $userExists = null;
                }

                $commonData = [
                    'type'               => 'employe',
                    'id_number'          => $idNumber,
                    'name'               => $userFullName,
                    'start_id_number'    => $this->excelToObjectDate($idNumberStartAt),
                    'end_id_number'      => $this->excelToObjectDate($idNumberExpiredDate),
                    'password'           => bcrypt(Str::random(15)),
                    'email'              => $email,
                    'phone'              => Str::startsWith($mobile, '5') ? '0' . $mobile : $mobile,
                    'active'             => 1,
                    'status'             => 'active',
                    'end_passport'       => $this->excelToObjectDate($passportExpiredDate),
                    'end_insurance'      => $this->excelToObjectDate($insuranceExpiredAt),
                    'insurance_company_id' => $insuranceCompany?->id,
                    'start_work'         => $this->excelToObjectDate($contractStartAt),
                    'birthday'           => $this->excelToObjectDate($birthDay),
                    'passport_number'    => $passportNumber,
                    'first_name'         => $nameArray[0] ?? null,
                    'second_name'        => $nameArray[1] ?? null,
                    'last_name'          => (isset($nameArray[2]) ? $nameArray[2] : null) . ' ' . (isset($nameArray[3]) ? $nameArray[3] : null),
                    'job_id'             => $jobModel?->id,
                ];

                if (!$userExists) {
                    User::create($commonData);
                } else {
                    $userExists->update($commonData);
                }
            }
        }
        $this->reset(['import_file']);
        $this->dispatch('alert', type: 'success', message: 'تم الرفع بنجاح');
    } catch (\Exception $e) {
        $this->dispatch('alert', type: 'error', message: 'حدث خطأ اثناء الرفع برجاء التأكد من ترتيب الملف والبيانات واعد المحاولة: ' . $e->getMessage());
    }
}
    public function downloadImportExample()
    {
        return Excel::download(new EmployesImportExampleExport(), 'employees_import_example.xlsx');
    }

    private function excelToObjectDate($date)
    {
        $result = null;
        if ($date) {
            if (is_string($date)) {
                $result = Carbon::parse($date);
            } elseif (is_integer($date) || is_float($date)) {
                $result = Carbon::parse(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($date));
            }
        }
        return $result;
    }


    public function submit()
    {
        $this->data = $this->validate();
        $this->beforeSubmit();

        if ($this->obj) {
            $this->beforeUpdate();
            $this->obj->update($this->data);
            $this->afterUpdate();
        } else {
            $this->beforeCreate();
            $this->obj = $this->model::create($this->data);
            $this->afterCreate();
        }
        $this->afterSubmit();
        $this->obj = null;
        $this->resetInputs();
        $this->screen = 'index';
        session()->flash('success', 'تم الحفظ بنجاح');
        return redirect()->route('admin.employes');
        // $this->dispatch('alert', ['ss','sss']);
    }

    public function mount()
    {
        if (request('employee_id') && $this->screen == 'edit') {
            $user = User::find(request('employee_id'));
            $this->nationality_id = $user->nationality_id;
        }
    }
}
