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
    <div class="bar-options d-flex align-items-center justify-content-start flex-wrap gap-1 mb-2">
        <button class="main-btn" data-bs-toggle="modal" data-bs-target="#createVacation">
            @lang('admin.Add')
            <i class="fas fa-plus"></i>
        </button>
    </div>
    <div class="table-responsive" id="prt-content">
        <table class="main-table">
            <thead>
                <tr>
                    <th>#</th>
                    @if(!$user)
                    <th>الموظف</th>
                    @endif

                    <th>تاريخ الخروج</th>
                    <th>تاريخ العودة</th>
                    <th>اخر إشعار</th>
                    <th>هل عاد الموظف</th>
                    <th>@lang('admin.Control')</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($vacations as $vacation)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    @if(!$user)
                    <td>{{ $vacation->user->name }}</td>
                    @endif
                    <td>{{ $vacation->exit_at }}</td>
                    <td>{{ $vacation->return_at }}</td>
                    <td>{{ $vacation->notified_at ?? 'لم يتم التنبية بعد' }}</td>
                    <td>{{ $vacation->user_return_at ?? 'لم يعود بعد' }}</td>
                    <td>
                        <div class="d-flex gap-3">
                            @if(!$vacation->user_return_at)
                            <button class="btn btn-success btn-sm"
                                wire:click='userReturnAt({{ $vacation->id }})'>تسجيل رجوع
                                الموظف</button>
                            @endif
                            <div class="dropdown drop-table dropend">
                                <button class="btn btn-outline-secondary btn-sm" type="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    @if(!$vacation->user_return_at)
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
                            @if(!$vacation->user_return_at)
                            <div class="modal fade" id="extendReturnAt{{ $vacation->id }}" aria-hidden="false">
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
                                                <input type="date" wire:model='return_at' class="form-control">
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
                            @foreach (App\Models\User::employes()->select('id','name')->get() as $emp)
                            <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                            @endforeach
                        </select>
                    </div>
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