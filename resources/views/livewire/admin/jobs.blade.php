<div class="main-side">
    @if ($screen == 'index')
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-1 mb-2">
            <div class="main-title">
                <div class="small">@lang('admin.Home')</div>
                <div class="large">المهن</div>
            </div>
            <a class="main-btn" href="{{ route('admin.jobs', ['screen' => 'create']) }}">
                @lang('admin.Add') <i class="fas fa-plus"></i>
            </a>
        </div>

        <x-admin-alert></x-admin-alert>

        <div class="table-responsive">
            <table class="main-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>المهنة</th>
                        <th>عدد الموظفين</th>
                        <th>@lang('admin.Control')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($jobs as $job)
                        <tr>
                            <td>{{ $job->id }}</td>
                            <td>{{ $job->name }}</td>
                            <td>{{ $job->employees_count }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.jobs', ['screen' => 'edit', 'id' => $job->id]) }}"
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>

                                    <button class="btn btn-sm btn-outline-danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteJobModal{{ $job->id }}">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </div>

                                <!-- Delete Modal -->
                                <div class="modal fade" id="deleteJobModal{{ $job->id }}" aria-hidden="false">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">@lang('admin.Delete')</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                هل انت متأكد من حذف المهنة ({{ $job->name }})؟
                                                @if($job->employees_count > 0)
                                                    <div class="text-danger mt-2">
                                                        يوجد {{ $job->employees_count }} موظف مرتبط بهذه المهنة.
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary btn-sm px-3"
                                                        data-bs-dismiss="modal">@lang('Cancel')</button>
                                                @if($job->employees_count == 0)
                                                    <button data-bs-dismiss="modal"
                                                            class="btn btn-danger btn-sm px-3"
                                                            wire:click='delete({{ $job->id }})'>
                                                        @lang('admin.Delete')
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">لا توجد مهن</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div id="pagination" class="mt-3 mb-2">
                {{ $jobs->links() }}
            </div>
        </div>
    @else
        {{-- فورم الإضافة/التعديل --}}
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-1 mb-2">
            <div class="main-title">
                <div class="small">@lang('admin.Home')</div>
                <div class="large">{{ $screen == 'edit' ? 'تعديل مهنة' : 'اضافة مهنة' }}</div>
            </div>
            <a class="main-btn btn-main-color" href="{{ route('admin.jobs') }}">رجوع لقائمة المهن</a>
        </div>

        <x-admin-alert></x-admin-alert>

        <div class="row g-3">
            <div class="col-12 col-md-6 col-lg-4">
                <label for="">اسم المهنة</label>
                <input type="text" class="form-control" wire:model="name">
                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="col-12">
                <button type="button" class="main-btn px-4" wire:click="submit">@lang('Save')</button>
            </div>
        </div>
    @endif
</div>

