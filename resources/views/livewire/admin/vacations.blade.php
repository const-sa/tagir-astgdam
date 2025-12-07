<div class="main-side">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-1 mb-2">
        <div class="main-title">
            <div class="small">@lang('admin.Home')</div>
            <div class="large">الخروج و العودة
            </div>
        </div>
        <div>
            <button class="btn btn-sm bg-warning text-light" id="btn-prt-content"><i
                    class="fa-solid fa-print"></i></button>
        </div>
    </div>
    <x-admin-alert></x-admin-alert>
    <div class="row g-3 mb-3">

        <div class="col-md-3">
            <div class="card bg-secondary text-white text-center">
                <div class="card-body">
                    <h6>الطلبات المعلقة</h6>
                    <h3>{{ $stats['pending'] }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-success text-white text-center">
                <div class="card-body">
                    <h6>الطلبات المقبولة</h6>
                    <h3>{{ $stats['approved'] }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-danger text-white text-center">
                <div class="card-body">
                    <h6>الطلبات المرفوضة</h6>
                    <h3>{{ $stats['rejected'] }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-info text-white text-center">
                <div class="card-body">
                    <h6>تم الخروج</h6>
                    <h3>{{ $stats['exited'] }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-warning text-dark text-center">
                <div class="card-body">
                    <h6>لم يخرج بعد</h6>
                    <h3>{{ $stats['not_exited'] }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-primary text-white text-center">
                <div class="card-body">
                    <h6>عاد الموظف</h6>
                    <h3>{{ $stats['returned'] }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-dark text-white text-center">
                <div class="card-body">
                    <h6>لم يعد بعد</h6>
                    <h3>{{ $stats['not_returned'] }}</h3>
                </div>
            </div>
        </div>

    </div>
    {{-- <div class="row g-3 mb-3">
        <div class="col-md-3">
            <div class="card text-white text-center
            {{ $filter_approval_status === 'pending' ? 'border border-3 border-light' : '' }}
            bg-secondary"
                style="cursor:pointer" wire:click="filterByStatus('pending')">

                <div class="card-body">
                    <h6>الطلبات المعلقة</h6>
                    <h3>{{ $stats['pending'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white text-center
            {{ $filter_approval_status === 'approved' ? 'border border-3 border-light' : '' }}
            bg-success"
                style="cursor:pointer" wire:click="filterByStatus('approved')">

                <div class="card-body">
                    <h6>الطلبات المقبولة</h6>
                    <h3>{{ $stats['approved'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white text-center
            {{ $filter_approval_status === 'rejected' ? 'border border-3 border-light' : '' }}
            bg-danger"
                style="cursor:pointer" wire:click="filterByStatus('rejected')">

                <div class="card-body">
                    <h6>الطلبات المرفوضة</h6>
                    <h3>{{ $stats['rejected'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white text-center
            {{ $filter_exit_status === 'exited' ? 'border border-3 border-light' : '' }}
            bg-info"
                style="cursor:pointer" wire:click="filterByExit('exited')">

                <div class="card-body">
                    <h6>تم الخروج</h6>
                    <h3>{{ $stats['exited'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-dark text-center
            {{ $filter_exit_status === 'not_exited' ? 'border border-3 border-dark' : '' }}
            bg-warning"
                style="cursor:pointer" wire:click="filterByExit('not_exited')">

                <div class="card-body">
                    <h6>لم يخرج بعد</h6>
                    <h3>{{ $stats['not_exited'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white text-center
            {{ $filter_return_status === 'returned' ? 'border border-3 border-light' : '' }}
            bg-primary"
                style="cursor:pointer" wire:click="filterByReturn('returned')">

                <div class="card-body">
                    <h6>عاد الموظف</h6>
                    <h3>{{ $stats['returned'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white text-center
            {{ $filter_return_status === 'not_returned' ? 'border border-3 border-light' : '' }}
            bg-dark"
                style="cursor:pointer" wire:click="filterByReturn('not_returned')">

                <div class="card-body">
                    <h6>لم يعد بعد</h6>
                    <h3>{{ $stats['not_returned'] }}</h3>
                </div>
            </div>
        </div>

    </div> --}}

    <div class="bar-options d-flex align-items-center justify-content-start flex-wrap gap-1 mb-2">
        <button class="main-btn" data-bs-toggle="modal" data-bs-target="#createVacation">
            @lang('admin.Add')
            <i class="fas fa-plus"></i>
        </button>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="filter_employee_id">الموظف</label>
                <div wire:ignore>
                    <x-select2 url="/admin/select2/employees" placeholder="اختر الموظف" id="filter_employee_id"
                        wire:model="filter_employee_id" class="form-control" />
                </div>
            </div>
        </div>
        <div class="row mb-3">

            {{-- فلتر حالة الطلب --}}
            <div class="col-md-3">
                <label>حالة الطلب</label>
                <select wire:model.live="filter_approval_status" class="form-control">
                    <option value="">الكل</option>
                    <option value="pending">معلق</option>
                    <option value="approved">مقبول</option>
                    <option value="rejected">مرفوض</option>
                </select>
            </div>

            {{-- فلتر الخروج --}}
            <div class="col-md-3">
                <label>حالة الخروج</label>
                <select wire:model.live="filter_exit_status" class="form-control">
                    <option value="">الكل</option>
                    <option value="exited">تم الخروج</option>
                    <option value="not_exited">لم يتم الخروج</option>
                </select>
            </div>

            {{-- فلتر العودة --}}
            <div class="col-md-3">
                <label>حالة العودة</label>
                <select wire:model.live="filter_return_status" class="form-control">
                    <option value="">الكل</option>
                    <option value="returned">عاد الموظف</option>
                    <option value="not_returned">لم يعد بعد</option>
                </select>
            </div>

        </div>

    </div>



    <div class="table-responsive" id="prt-content" style="margin-top: 10px;">
        <table class="main-table">
            <thead>
                <tr>
                    <th>#</th>
                    @if (!$user)
                        <th>الموظف</th>
                    @endif

                    <th>تاريخ الخروج</th>
                    <th>تاريخ العودة</th>
                    <th>حالة الطلب</th>
                    <th>تم الخروج؟</th>
                    <th>اخر إشعار</th>
                    <th>هل عاد الموظف</th>
                    <th>@lang('admin.Control')</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($vacations as $vacation)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        @if (!$user)
                            <td>{{ $vacation->user->name }}</td>
                        @endif
                        <td>{{ $vacation->exit_at }}</td>
                        <td>{{ $vacation->return_at }}</td>
                        <td>
                            @switch($vacation->approval_status)
                                @case('approved')
                                    <span class="badge bg-success">مقبول</span>
                                @break

                                @case('rejected')
                                    <span class="badge bg-danger">مرفوض</span>
                                @break

                                @default
                                    <span class="badge bg-secondary">معلق</span>
                            @endswitch
                        </td>

                        {{-- تم الخروج؟ --}}
                        <td>
                            @if ($vacation->exit_done_at)
                                <span class="badge bg-success">
                                    تم الخروج {{ $vacation->exit_done_at }}
                                </span>
                            @else
                                <span class="badge bg-warning text-dark">لم يخرج بعد</span>
                            @endif
                        </td>
                        <td>{{ $vacation->notified_at ?? 'لم يتم التنبية بعد' }}</td>
                        <td>{{ $vacation->user_return_at ?? 'لم يعود بعد' }}</td>
                        <td>
                            <div class="d-flex gap-3">
                                @if (!$vacation->user_return_at)
                                    <button class="btn btn-success btn-sm"
                                        wire:click='userReturnAt({{ $vacation->id }})'>تسجيل رجوع
                                        الموظف</button>
                                @endif
                                @if ($vacation->approval_status === 'pending')
                                    <button class="btn btn-primary btn-sm"
                                        wire:click='approveVacation({{ $vacation->id }})'>
                                        موافقة
                                    </button>

                                    <button class="btn btn-outline-danger btn-sm"
                                        wire:click='rejectVacation({{ $vacation->id }})'>
                                        رفض
                                    </button>
                                @endif

                                {{-- تسجيل الخروج الفعلي بعد الموافقة --}}
                                @if ($vacation->approval_status === 'approved' && !$vacation->exit_done_at)
                                    <button class="btn btn-warning btn-sm"
                                        wire:click='confirmExit({{ $vacation->id }})'>
                                        تسجيل الخروج
                                    </button>
                                @endif
                                <div class="dropdown drop-table dropend">
                                    <button class="btn btn-outline-secondary btn-sm" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        @if (!$vacation->user_return_at)
                                            <li>
                                                <button class="dropdown-item text-center" data-bs-toggle="modal"
                                                    data-bs-target="#extendReturnAt{{ $vacation->id }}">
                                                    <i class="fas fa-boxes-packing"></i>
                                                    تمديد اجازة الموظف
                                                </button>
                                            </li>
                                        @endif
                                        <li>
                                            <button class="dropdown-item text-center" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal{{ $vacation->id }}">
                                                <i class="fa-solid fa-trash-can"></i>
                                                حذف الاجازة
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                                @if (!$vacation->user_return_at)
                                    <div class="modal fade" id="extendReturnAt{{ $vacation->id }}"
                                        aria-hidden="false">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="archiveModalLabel">تمديد إجازة الموظف
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="">تاريخ العودة الحالي</label>
                                                        <p>{{ $vacation->return_at }}</p>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">تاريخ الرجوع الجديد</label>
                                                        <input type="date" wire:model='return_at'
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary btn-sm px-3"
                                                        data-bs-dismiss="modal">@lang('Cancel')</button>
                                                    <button data-bs-dismiss="modal" class="btn btn-danger btn-sm px-3"
                                                        wire:click='extendReturnAt({{ $vacation->id }})'>نعم</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="modal fade" id="deleteModal{{ $vacation->id }}" aria-hidden="false">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel">@lang('admin.Delete')
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                @lang('admin.Are you sure you want to delete?') {{ $vacation->id }}
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary btn-sm px-3"
                                                    data-bs-dismiss="modal">@lang('Cancel')</button>
                                                <button data-bs-dismiss="modal" class="btn btn-danger btn-sm px-3"
                                                    wire:click='delete({{ $vacation->id }})'>@lang('admin.Delete')</button>
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
            {{ $vacations->links() }}
        </div>
    </div>
    <div class="modal fade" id="createVacation" aria-hidden="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">اضف جديد
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">الموظف</label>
                        <select wire:model="user_id" id="user_id" class="form-control">
                            <option value="">اختر الموظف</option>
                            @foreach (App\Models\User::employes()->select('id', 'name')->get() as $emp)
                                <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    {{-- <div class="form-group mb-3">
                        <label for="user_id_select">الموظف</label>
                        <div wire:ignore>
                            <x-select2
                                url="/admin/select2/employees"
                                placeholder="اختر الموظف"
                                id="user_id_select"
                                wire:model="user_id"
                                class="form-control"
                            />
                        </div>
                    </div> --}}
                    <div class="form-group">
                        <label for="">تاريخ الخروج</label>
                        <input type="date" wire:model='exit_at' id="exit_at" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">تاريخ العودة</label>
                        <input type="date" wire:model='return_at' id="return_at" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm px-3"
                        data-bs-dismiss="modal">@lang('Cancel')</button>
                    <button data-bs-dismiss="modal" class="btn btn-primary btn-sm px-3"
                        wire:click='submit'>إضافة</button>
                </div>
            </div>
        </div>
    </div>

</div>
