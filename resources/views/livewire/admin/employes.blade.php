<div class="main-side">
    @if ($screen == 'index')
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-1 mb-2">
            <div class="main-title">
                <div class="small">@lang('admin.Home')</div>
                <div class="large">الموظفين
                    @if (request('status'))
                        ({{ __(request('status')) }})
                    @endif
                </div>
            </div>
            <div>
                <button class="btn btn-sm bg-warning text-light" id="btn-prt-content"><i
                        class="fa-solid fa-print"></i></button>
                <button class="btn btn-sm bg-primary text-light" wire:click="export()">تصدير Excel</button>
            </div>
        </div>
        <x-admin-alert></x-admin-alert>
        <div class="bar-options d-flex align-items-center justify-content-start flex-wrap gap-1 mb-2">
            <a class="main-btn" href="{{ route('admin.employes', ['screen' => 'create']) }}"> @lang('admin.Add')
                <i class="fas fa-plus"></i></a>
            <button class="main-btn btn-main-color" wire:click="resetFilter">كل الموظفين:
                {{ App\Models\User::employes()->count() }}</button>
            <button class="main-btn" wire:click="$set('filter_status','active')">موظفين نشطين:
                {{ App\Models\User::employes()->where('status', 'active')->count() }}</button>
            <button class="main-btn btn-orange" wire:click="$set('filter_status','inactive')">موظفين غير نشظين:
                {{ App\Models\User::employes()->where('status', 'inactive')->count() }}</button>
            <button class="main-btn btn-blue" wire:click="$set('filter_nationality','sudia')">موظفين سعوديين:
                {{ App\Models\User::employes()->where('nationality', 'sudia')->count() }}</button>
            <button class="main-btn btn-blue" wire:click="$set('filter_nationality','not-sudia')">موظفين غير سعوديين:
                {{ App\Models\User::employes()->where('nationality', 'not-sudia')->count() }}</button>
            <button class="main-btn btn-purple px-4" button data-bs-toggle="modal"
                    data-bs-target="#importModal">استيراد
            </button>
            <div class="modal fade" id="importModal" aria-hidden="true" wire:ignore.self>
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="importModalLabel">أضافة ملف Excel</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-12 col-md-12">
                                    <div class="inp-holder">
                                        <label for="" class="small-label">المرفق</label>
                                        <input type="file" wire:model.defer="import_file" id=""
                                               class="form-control">
                                        @error('import_file')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="mt-2">
                                        <button type="button"
                                                class="btn btn-outline-primary btn-sm"
                                                wire:click="downloadImportExample">
                                            تحميل ملف مثال للاستيراد
                                        </button>
                                    </div>
                                    {{-- <div class="inp-holder">
                                    <label for="" class="small-label">المشروع</label>
                                    <select wire:model.defer="excel_company_id" class="form-control"
                                        id="excel_company_id">
                                        <option value="">اختر جهه العمل</option>
                                        @foreach (App\Models\Company::get() as $comp)
                                        <option value="{{ $comp->id }}">{{ $comp->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('excel_company_id')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div> --}}
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <span wire:loading class="badge bg-danger">جاري رفع الحسابات .. برجاء
                                الانتظار</span>
                            <button type="button" class="btn btn-secondary btn-sm px-3"
                                    data-bs-dismiss="modal">رجوع
                            </button>
                            <button type="button" wire:click="uploadExcelFile" class="btn btn-primary btn-sm px-3">
                                حفظ
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <button class="main-btn bg-danger" data-bs-toggle="modal" data-bs-target="#deleteModalall">
                حذف كل الموظفين
            </button>


            <div class="modal fade" id="deleteModalall" aria-hidden="false">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel">@lang('admin.Delete')
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            هل انت متاكد من حذف كل الموظفين ؟؟
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm px-3"
                                    data-bs-dismiss="modal">@lang('Cancel')</button>
                            <button data-bs-dismiss="modal" class="btn btn-danger btn-sm px-3"
                                    wire:click='deleteAll'>@lang('admin.Delete')</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row  g-2 mb-2">
            <div class="col-12 col-sm-6 col-md-3">
                <div class="inp-holder">
                    <input type="search" class="form-control" wire:model.live="search_name_number"
                           placeholder="أبحث باستخدام الجوال أو الاسم" id="search_name_number">
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="inp-holder">
                    <input type="search" class="form-control" wire:model.live="search_side_job"
                           placeholder="أبحث  جهة العمل" id="search_side_job">
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="inp-holder">
                    <input type="search" class="form-control" wire:model.live="search_employeeId"
                           placeholder="أبحث باستخدام رقم الموظف" id="search_employeeId">
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-2">
                <select class="form-select" id="status" wire:model.live="filter_status">
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
            <!-- <div class="col-12 col-sm-6 col-md-3">
            <select class="form-select" id="category_id">
                <option value="">اختر القسم التابع له</option>
                <option value="5"> شركة إعمار المساند لتشغيل والصيانة</option>
                <option value="6"> مؤسسة عبدالله غازي المطيري</option>
                <option value="7"> شركة البيك</option>
                <option value="8"> شركة كابلي</option>
            </select>
        </div> -->
            <div class="col-12 col-sm-6 col-md-2">
                <select class="form-select" id="work_type_id" wire:model.live="filter_work_type_id">
                    <option value="">اختر نوع الدوام</option>
                    @foreach (App\Models\WorkType::all() as $work)
                        <option value="{{ $work->id }}">{{ $work->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-sm-6 col-md-2">
                <select class="form-select" id="" wire:model.live="filter_gender">
                    <option value="">اختر الجنس</option>
                    <option value="male">ذكر</option>
                    <option value="female">انثى</option>
                </select>
            </div>
        </div>
        <div class="table-responsive">
            <table class="main-table" id="prt-content">
                <thead>
                <tr>
                    <th>الرقم الوظيفي</th>
                    <th>الموظف</th>
                    <th>البريد</th>
                    <th>الجوال</th>
                    <th>رقم الاقامة</th>
                    <th>انتهاء الاقامة</th>
                    <th>حالة الموظف</th>
                    <th>جهة العمل</th>
                    <th>تاريخ مباشرة العمل</th>
                    <th>تاريخ انتهاء التأمين</th>
                    <th>التأمين</th>
                    <th>المهنة</th>
                    <th>@lang('admin.Control')</th>
                </tr>
                </thead>
                <tbody>

                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>
                            <div class="user">
                                <img
                                    src="{{ $user->image ? display_file($user->image) : asset('admin-asset/img/no-image.jpeg') }}"
                                    alt="user">
                                <span>{{ $user->name . ' ' . $user->second_name . ' ' . $user->last_name }}</span>
                            </div>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>{{ $user->id_number }}</td>
                        <td>{{ $user->end_id_number }}</td>
                        <td>{{ __($user->status) }}</td>
                        <td class="{{ !$user->side_job ? 'text-danger' : '' }}">
                            {{ $user->side_job ?? 'غير محدد' }}</td>
                        <td class="{{ !$user->start_work ? 'text-danger' : '' }}">
                            {{ $user->start_work ?? 'غير محدد' }}</td>
                        <td>{{ $user->end_insurance }}</td>
                        <td class="{{ !$user->insuranceCompany ? 'text-danger' : '' }}">
                            {{ $user->insuranceCompany?->name ?? 'غير محدد' }}</td>
                        <td>{{ $user->jobrelation?->name }}</td>
                        <td>
                            <div class="d-flex gap-3">
                                <div class="dropdown drop-table dropend">
                                    <button class="btn btn-outline-secondary btn-sm" type="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        @if ($user->phone)
                                            <li>
                                                <a class="dropdown-item text-center"
                                                   href="https://wa.me/+966{{ $user->phone }}">
                                                    <i class="fab fa-whatsapp"></i>
                                                    واتساب الموظف
                                                </a>
                                            </li>
                                        @endif
                                        <li>
                                            <a class="dropdown-item text-center"
                                               href="{{ route('admin.employees.statistics') }}">
                                                <i class="fas fa-file-signature"></i>
                                                احصائيات الموظف
                                            </a>
                                        </li>
                                        @can('archive_employees')

                                            <li>
                                                <button class="dropdown-item text-center" data-bs-toggle="modal"
                                                        data-bs-target="#archiveModal{{ $user->id }}">
                                                    <i class="fas fa-boxes-packing"></i>
                                                    ارشفة الموظف
                                                </button>
                                            </li>
                                        @endcan

                                        <li>
                                            <a class="dropdown-item text-center"
                                               href="{{ route('admin.employees.show', $user->id) }}">
                                                <i class="fas fa-eye"></i>
                                                عرض الموظف
                                            </a>
                                        </li>
                                        @can('vacation_employees')
                                            <li>
                                                <a class="dropdown-item text-center"
                                                   href="{{ route('admin.vacations', $user->id) }}">
                                                    <i class="fa-solid fa-recycle"></i>
                                                    الخروج و العودة
                                                </a>
                                            </li>
                                        @endcan

                                        @can('update_employees')
                                            <li>
                                                <a class="dropdown-item text-center"
                                                   href="{{ route('admin.employes', ['screen' => 'edit', 'employee_id' => $user->id]) }}">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                    تعديل الموظف
                                                </a>
                                            </li>
                                        @endcan

                                        @can('delete_employees')
                                            <li>
                                                <button class="dropdown-item text-center" data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal{{ $user->id }}">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                    حذف الموظف
                                                </button>
                                            </li>
                                        @endcan
                                    </ul>
                                </div>
                                <div class="modal fade" id="archiveModal{{ $user->id }}"
                                     aria-hidden="false">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="archiveModalLabel">ارشفة إسم الموظف
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                هل انت متأكد من ارشفة
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary btn-sm px-3"
                                                        data-bs-dismiss="modal">@lang('Cancel')</button>
                                                <button data-bs-dismiss="modal" class="btn btn-danger btn-sm px-3"
                                                        wire:click='delete({{ $user->id }})'>نعم
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="deleteModal{{ $user->id }}" aria-hidden="false">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel">@lang('admin.Delete')
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                @lang('admin.Are you sure you want to delete?') {{ $user->id }}
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary btn-sm px-3"
                                                        data-bs-dismiss="modal">@lang('Cancel')</button>
                                                <button data-bs-dismiss="modal" class="btn btn-danger btn-sm px-3"
                                                        wire:click='softDelete({{ $user->id }})'>@lang('admin.Delete')</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div id="pagination" class="mt-3 mb-2">
                {{ $users->links() }}
            </div>
        </div>
    @else
        @include('livewire.admin.employes.createOrUpdate')
    @endif
</div>
