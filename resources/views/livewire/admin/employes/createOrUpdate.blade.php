<div class="d-flex align-items-center justify-content-between flex-wrap gap-1 mb-2">
    <div class="main-title">
        <div class="small">@lang('admin.Home')</div>
        <div class="large">الموظفين</div>
    </div>
    <a class="main-btn btn-main-color" href="{{ route('admin.employes') }}">عرض كل الموظفين</a>
</div>
<x-admin-alert></x-admin-alert>
<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 g-3">
    <div class="col">
        <label for="">الاسم المستخدم / Username</label>
        <input class="form-control" type="text" wire:model="name" />
    </div>
    <div class="col">
        <label for="">الاسم الاول / First Name</label>
        <input class="form-control" type="text" wire:model="first_name" />
    </div>
    <div class="col">
        <label for="">الاسم الثاني / Second Name</label>
        <input class="form-control" type="text" wire:model="second_name" />
    </div>
    <div class="col">
        <label for="">الاسم العائلة / Last Name</label>
        <input class="form-control" type="text" wire:model="last_name" />
    </div>
    <div class="col">
        <label for="">الجنس</label>
        <select class="form-select" id="" wire:model="gender">
            <option value="">اختر الجنس</option>
            <option value="male">ذكر</option>
            <option value="female">انثى</option>
        </select>
    </div>
    <div class="col">
        <label for="">الجنسية</label>
        <select class="form-select" id="" wire:model.live="nationality">
            <option value="">اختر الجنسية</option>
            <option value="sudia">سعودي</option>
            <option value="not-sudia">غير سعودي</option>
        </select>
    </div>
    {{-- @if ($nationality == 'not-sudia')
        <div class="col">
            <label for="">الجنسية</label>
            <select class="form-select" id="employes" class="select2" wire:model.live="nationality_id">
                <option value="">اختر الجنسية</option>
                @foreach ($nationalities as $nationality)
                    <option value="{{ $nationality->id }}">{{ $nationality->name_ar }}</option>
                @endforeach
            </select>
        </div>
    @endif --}}




    @if ($screen == 'edit')
        <div class="col" wire:ignore>
            <label for="" class="small-label">الجنسية</label>
            <select id="nationality_id" class="main-select" wire:model="nationality_id">
                <option value="{{ $nationality_id ?? '' }}">
                    @php $selected_nationality=  App\Models\Nationality::find($nationality_id)@endphp
                    {{$selected_nationality->name_ar .' | ' . $selected_nationality->name_en ?? '' }}
                </option>
            </select>
        </div>
    @else
        <div class="col" {{ $nationality == 'not-sudia' ? '' : 'hidden' }}>
            <label for="">الجنسية</label>
            <x-select2 id="nationality_id" wire:model="nationality_id" :url="'/select2/nationalities'" />
        </div>
    @endif





    <div class="col">
        <label for="">رقم الهوية / الاقامة</label>
        <input class="form-control" type="number" min="0" maxlength="10" wire:model="id_number" />
    </div>
    <div class="col">
        <label for="">البريد الألكتروني</label>
        <input class="form-control" type="email" wire:model.live="email" />
    </div>
    <div class="col">
        <label for="">تاريخ بدء الهوية / الاقامة</label>
        <input class="form-control" type="date" wire:model="start_id_number" />
    </div>
    <div class="col">
        <label for="">تاريخ انتهاء الهوية / الاقامة</label>
        <input class="form-control" type="date" wire:model="end_id_number" />
    </div>
    <div class="col">
        <label for="">مرفق انتهاء الهوية / الاقامة</label>
        <input class="form-control" type="file" wire:model="file_end_id_number" />
    </div>


    <div class="col">
        <label for="">كلمة المرور</label>
        <input class="form-control" type="password" wire:model="password" />
    </div>
    <div class="col">
        <label for="">الجوال</label>
        <input class="form-control" type="tel" wire:model="phone" />
    </div>
    <div class="col">
        <label for="">رقم منشاة (اعمار المساند)</label>
        <input class="form-control" type="tel" wire:model="employer_number" />
    </div>
    <div class="col">
        <label for="">اسم صاحب العمل</label>
        <input class="form-control"  wire:model="employer_name" />
    </div>
    <div class="col">
        <label for="">التامينات الاجتماعية</label>
        <input class="form-control" wire:model="social_insurance" />
    </div>
    <div class="col-12 col-md-4 col-lg-4">
        <label for=""> حالة الموظف</label>
        <select class="form-select" id="" wire:model="status">
            <option value="">اختر الحالة</option>
            <option value="active">نشط</option>
            <option value="inactive">غير نشط</option>
            <option value="resigned">مستقيل</option>
            <option value="fired">مفصول</option>
            <option value="death">وفاة</option>
            <option value="exit_and_return">خروج وعودة</option>
            <option value="final_exit">خروج نهائي</option>
        </select>
    </div>
    <div class="col">
        <label for=""> نوع الدوام</label>

        <select class="form-select" id="work_type_id" wire:model="work_type_id">
            <option value="">اختر نوع الدوام</option>
            @foreach (App\Models\WorkType::all() as $work)
                <option value="{{ $work->id }}">{{ $work->name }}</option>
            @endforeach
        </select>
    </div>
    {{-- <div class="col">
        <label for="">المهنة</label>
        <input class="form-control" type="text" wire:model="job" />
    </div> --}}
    <div class="col">
        <label for="">المهنة</label>
        <select class="form-select" wire:model="job_id">
            <option value="">اختر المهنة</option>
            @foreach(\App\Models\Job::orderBy('name')->get() as $job)
                <option value="{{ $job->id }}">{{ $job->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col">
        <label for="">جهة العمل</label>
{{--        <input class="form-control" type="text" wire:model="side_job" />--}}
        <select wire:model.live="side_job_id" class="form-select">
            <option>اختر</option>
            @foreach(\App\Models\User::clients()->select('id','name')->get() as $client)
                <option value="{{$client->id}}">{{$client->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="col">
        <label for="">المسمى الوظيفي</label>
{{--        <input class="form-control" type="text" wire:model="side_job" />--}}
        <select wire:model.live="price_quotation_job_id" class="form-select">
            <option>اختر</option>
            @foreach($jobs as $item)
                <option value="{{$item->id}}">{{$item->job_title}}</option>
            @endforeach
        </select>
    </div>

    <div class="col">
        <label for="">تاريخ مباشرة العمل</label>
        <input class="form-control" type="date" wire:model.live="start_work" />
    </div>
    <div class="col">
        <label for="">شركات التأمين</label>
        <select class="form-select" wire:model='insurance_company_id' id="insurance_company_id">
            <option value="">اختر شركة التأمين</option>
            @foreach (App\Models\InsuranceCompany::get() as $insuranceCompany)
                <option value="{{ $insuranceCompany->id }}">{{ $insuranceCompany->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col">
        <label for="">تاريخ انتهاء التأمين</label>
        <input class="form-control" type="date" wire:model="end_insurance" />
    </div>
    <div class="col">
        <label for="">مرفق انتهاء التأمين</label>
        <input class="form-control" type="file" wire:model="file_end_insurance" />
    </div>
    <div class="col">
        <label for="">تاريخ انتهاء جواز السفر</label>
        <input class="form-control" type="date" wire:model="end_passport" />
    </div>
    <div class="col">
        <label for="">مرفق انتهاء جواز السفر</label>
        <input class="form-control" type="file" wire:model="file_end_passport" />
    </div>
    <div class="col">
        <label for="">الصورة الشخصية</label>
        <input class="form-control" type="file" wire:model="image" />
    </div>
    <div class="col">
        <label> بطاقة سائق : </label>
        <label for="">نعم</label>
        <input type="radio" wire:model.live="driver_card" value="1" />
        <label for="">لا</label>
        <input type="radio" wire:model.live="driver_card" value="0" />
    </div>
    @if ($driver_card)
        <div class="col">
            <label for="">تاريخ بداية بطاقة سائق </label>
            <input class="form-control" type="date" wire:model="start_driver_card" />
        </div>
        <div class="col">
            <label for="">تاريخ نهاية بطاقة سائق </label>
            <input class="form-control" type="date" wire:model="end_driver_card" />
        </div>

        <div class="col">
            <label for="">مرفق نهاية بطاقة سائق </label>
            <input class="form-control" type="file" wire:model="file_driver_card" />
        </div>
    @endif

    <div class="col">
        <label>الكارت الصحي : </label>
        <input type="radio" wire:model.live="health_card" value="1" />
        <label for="">نعم</label>
        <input type="radio" wire:model.live="health_card" value="0" />
        <label for="">لا</label>
    </div>
    @if ($health_card)
        <div class="col">
            <label for="">تاريخ بداية الكارت الصحى </label>
            <input class="form-control" type="date" wire:model="start_health_card" />
        </div>
        <div class="col">
            <label for="">تاريخ نهاية الكارت الصحى </label>
            <input class="form-control" type="date" wire:model="end_health_card" />
        </div>

        <div class="col">
            <label for="">مرقق نهاية الكارت الصحى </label>
            <input class="form-control" type="file" wire:model="file_health_card" />
        </div>
    @endif


    <div class="col">
        <label> أجير : </label>
        <input type="radio" wire:model.live="is_employee" value="1" />
        <label for="">نعم</label>
        <input type="radio" wire:model.live="is_employee" value="0" />
        <label for="">لا</label>
    </div>
    @if ($is_employee)
        <div class="col">
            <label for="">تاريخ بداية أجير </label>
            <input class="form-control" type="date" wire:model="start_is_employee" />
        </div>
        <div class="col">
            <label for="">تاريخ نهاية أجير </label>
            <input class="form-control" type="date" wire:model="end_is_employee" />
        </div>

        <div class="col">
            <label for="">مرفق نهاية أجير </label>
            <input class="form-control" type="file"wire:model="file_is_employee" />
        </div>
    @endif


    <div class="col">
        <label> مقيم : </label>
        <input type="radio" wire:model.live="resident" value="1" />
        <label for="">نعم</label>
        <input type="radio" wire:model.live="resident" value="0" />
        <label for="">لا</label>
    </div>
    @if ($resident)
        <div class="col">
            <label for="">تاريخ بداية مقيم </label>
            <input class="form-control" type="date" wire:model="start_resident" />
        </div>
        <div class="col">
            <label for="">تاريخ نهاية مقيم </label>
            <input class="form-control" type="date" wire:model="end_resident" />
        </div>

        <div class="col">
            <label for="">مرفق نهاية مقيم </label>
            <input class="form-control" type="file" wire:model="file_resident" />
        </div>
    @endif

        <div class="row w-100">
            <div class="col-12 col-md-6">
                <label for="" class="small-label">
                    الاجازة
                    -
                    Vacation
                </label>
                <select wire:model.live="vacation"
                        disabled
                        class="form-control">
                    <option value="">حدد الاجازة</option>
                    <option value="one_year">سنه</option>
                    <option value="two_years">سنتين</option>
                </select>

            </div>

            <div class="col-12 col-md-6">
                <label for="" class="small-label">
                    أيام الأجازة
                    -
                    Vacation days
                </label>
                <input type="number" min="0"
                       wire:model="vacation_days"
                       disabled
                       class="form-control">
            </div>
            <div class="col-12 col-md-6">
                <label for="" class="small-label">
                    تكلفة الأجازة
                    -
                    Vacation cost
                </label>
                <input type="text"
                       wire:model="vacation_cost"
                       disabled
                       class="form-control">
            </div>
            <div class="col-12 col-md-6">
                <label for="" class="small-label">
                    تكلفة التذكرة الأجازة
                    -
                    Cost of vacation ticket
                </label>
                <input type="text"
                       disabled
                       wire:model="vacation_ticket_cost"
                       class="form-control">
            </div>

            <div class="col-12 col-md-6">
                <label for="" class="small-label">
                    نهاية الخدمة
                    -
                    End of service
                </label>
                <input type="text"
                       disabled
                       wire:model="end_of_service_cost"
                       class="form-control">
            </div>

            <div class="col-12 col-md-6">
                <label for="" class="small-label">
                    تذكرة نهاية الخدمة
                    -
                    Ticket for end of service
                </label>
                <input type="text"
                       disabled
                       wire:model="end_of_service_ticket_cost"
                       class="form-control"
                >
            </div>

        </div>





    <div class="col-12 col-md-12 col-lg-12 col-xl-12">
        <button type="button" class="main-btn px-4" wire:click="submit">@lang('Save')</button>
    </div>


    @if ($screen == 'edit')
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
        <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI="
            crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
            integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script>
            function initializeSelect2(selector, url, extraParams = {}) {
                $(selector).select2({
                    allowClear: true,
                    width: '100%',
                    ajax: {
                        url: url,
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            return {
                                search: params.term || '',
                                page: params.page || 1,
                                ...extraParams
                            }
                        },
                        cache: true,
                        pagination: {
                            more: true
                        }
                    },
                })

                $(selector).on('change', function() {
                    const data = $(this).val();
                    const name = $(this).attr('id');
                    @this.set(name, data);
                });
            }

            function initializeAll() {
                initializeSelect2('#nationality_id', '/select2/nationalities');
                $(document).on('select2:open', () => {
                    document.querySelector('.select2-container--open .select2-search__field').focus();
                });
            }

            document.addEventListener('refreshSelect2', function() {
                initializeAll()
            });

            initializeAll()
        </script>
    @endif

</div>
