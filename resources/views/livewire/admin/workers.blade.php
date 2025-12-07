<div class="main-side">

    @if ($screen === 'index')
        <div class="main-title">
            <div class="small">الرئيسية</div>
            <div class="large">العمال</div>
        </div>

        <div class="btn-holder d-flex align-items-center justify-content-between gap-3 flex-wrap mb-3">
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <button wire:click="create" class="main-btn">
                    اضافة عامل <i class="fas fa-plus"></i>
                </button>

                <button class="main-btn bg-success">
                    عدد العمال المؤجرين: {{ $hiredCount }}
                </button>

                <button class="main-btn bg-danger">
                    عدد العمال غير المؤجرين: {{ $notHiredCount }}
                </button>
            </div>

            <div class="box-search">
                <img src="{{ asset('admin-asset/img/icons/search.png') }}" alt="icon" />
                <input type="search" placeholder="ابحث باسم العامل أو رقم الجوال"
                       wire:model.live="search">
            </div>
        </div>

        <x-admin-alert></x-admin-alert>

        <div class="table-responsive">
            <table class="main-table mb-2 table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الاسم</th>
                        <th>الجنسية</th>
                        <th>رقم الإقامة</th>
                        <th>رقم الجوال</th>
                        <th>الحالة</th>
                        <th>المشروع</th>
                        <th>بداية التأجير</th>
                        <th>نهاية التأجير</th>
                        <th>التحكم</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($workers as $worker)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $worker->name }}</td>
                            <td>{{ $worker->nationality ?? '-' }}</td>
                            <td>{{ $worker->id_number ?? '-' }}</td>
                            <td>{{ $worker->phone ?? '-' }}</td>
                            <td>
                                @if($worker->is_hired)
                                    <span class="badge bg-success">مؤجر</span>
                                @else
                                    <span class="badge bg-danger">غير مؤجر</span>
                                @endif
                            </td>
                            <td>{{ $worker->currentHiringProject?->title ?? '-' }}</td>
                            <td>{{ $worker->hire_start_date ?? '-' }}</td>
                            <td>{{ $worker->hire_end_date ?? '-' }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <button type="button" class="btn btn-sm btn-info"
                                            wire:click="edit({{ $worker->id }})">
                                        <i class="fa fa-pen"></i>
                                    </button>

                                    <button type="button" class="btn btn-sm btn-danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteWorkerModal{{ $worker->id }}">
                                        <i class="fa fa-trash"></i>
                                    </button>

                                    <div class="modal fade" id="deleteWorkerModal{{ $worker->id }}" tabindex="-1" aria-hidden="true" wire:ignore.self>
                                        <div class="modal-dialog">
                                            <div class="modal-content">

                                                <div class="modal-header">
                                                    <h5 class="modal-title">حذف العامل</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>

                                                <div class="modal-body">
                                                    هل أنت متأكد أنك تريد حذف هذا العامل؟
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">إلغاء</button>

                                                    <button type="button"
                                                            class="btn btn-danger btn-sm"
                                                            wire:click="delete({{ $worker->id }})"
                                                            data-bs-dismiss="modal">
                                                        نعم، احذف
                                                    </button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center">لا يوجد عمال حاليا</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-2">
                {{ $workers->links() }}
            </div>
        </div>

    @else
        {{-- شاشة الإضافة / التعديل --}}
        <div class="d-flex align-items-center justify-content-between gap-3 mb-3">
            <div class="main-title mb-0">
                <div class="small">الرئيسية</div>
                <div class="large">
                    {{ $screen === 'create' ? 'اضافة عامل' : 'تعديل عامل' }}
                </div>
            </div>

            <button wire:click="$set('screen','index')" class="main-btn bg-secondary">
                رجوع <i class="fas fa-arrow-left-long"></i>
            </button>
        </div>

        <x-admin-alert></x-admin-alert>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
            <div class="col">
                <label>اسم العامل</label>
                <input type="text" class="form-control" placeholder="ادخل اسم العامل" wire:model="name">
                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="col">
                <label>رقم الهوية</label>
                <input type="text" class="form-control" placeholder="ادخل رقم الإقامة" wire:model="id_number">
                @error('id_number') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="col">
                <label>رقم الجوال</label>
                <input type="text" class="form-control" placeholder="ادخل رقم الجوال" wire:model="phone">
                @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="col">
                <label>الجنسية</label>
                <input type="text" class="form-control" placeholder="ادخل الجنسية" wire:model="nationality">
                @error('nationality') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="col">
                <label>حالة التأجير</label>
                <select class="form-control" wire:model.live="is_hired">
                    <option value="0">غير مؤجر</option>
                    <option value="1">مؤجر</option>
                </select>
                @error('is_hired') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="col">
                <label>المشروع</label>
                <select class="form-control" wire:model="hiring_project_id" @if(!$is_hired) disabled @endif>
                    <option value="">بدون</option>
                    @foreach($projects as $project)
                        <option value="{{ $project->id }}">{{ $project->title }}</option>
                    @endforeach
                </select>
                @error('hiring_project_id') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="col">
                <label>بداية التأجير</label>
                <input type="date" class="form-control" wire:model="hire_start_date" @if(!$is_hired) disabled @endif>
                @error('hire_start_date') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="col">
                <label>نهاية التأجير</label>
                <input type="date" class="form-control" wire:model="hire_end_date" @if(!$is_hired) disabled @endif>
                @error('hire_end_date') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="col-12">
                <div class="btn-holder mt-2">
                    <button class="main-btn" wire:click="submit">حفظ</button>
                </div>
            </div>
        </div>
    @endif

</div>

