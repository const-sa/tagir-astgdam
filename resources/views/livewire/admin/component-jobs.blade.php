<div class="main-side">
    <div class="main-title">
        <div class="small">@lang('Home')</div>
        <div class="large">الوظائف</div>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="issue-main-info">
                <div class="content-header">
                    اضف وظيفة جديدة
                </div>
                <x-admin-alert></x-admin-alert>
                <div class="col-md-12">
                    <label class="small-label" for="">
                        اسم الوظيفة
                        <span class="text-danger">*</span>
                    </label>
                    <div class="box-input">
                        <input type="text" class="form-control" wire:model='name' id="" />
                    </div>
                </div>
                <div class="d-flex justify-content-center mt-4">
                    <button type="button" wire:click='submit' class="main-btn"> @lang('Save') </button>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <form action="" class="issue-main-info">
                <div class="content-header">
                    عرض كل الوظائف
                </div>
                <div class="bar-obtions d-flex align-items-center justify-content-end flex-wrap gap-3 mb-4">
                    <div class="box-search">
                        <img src="{{ asset('admin-asset/img/icons/search.png') }}" alt="icon" />
                        <input type="search" wire:model.live="search" id="" placeholder="@lang('Search')" />
                    </div>
                </div>
                <div class="bar-options d-flex align-items-center justify-content-between flex-wrap gap-1 mb-2">
                    <a wire:click="$set('screen','create')" class=""></a>
                    <div class="d-flex align-items-center gap-1">

                        {{-- <a href="{{ route('admin.regions') }}" class="main-btn btn-main-color" >
                        الأحياء <i class="fa-solid fa-arrow-up-right-from-square fs-15px"></i>
                        </a> --}}
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="main-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>إسم الوظيفة</th>
                                <th>عدد الموظفين</th>
                                <th>@lang('Actions')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($jobs as $job)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $job->name }}</td>
                                    <td>
                                        {{-- {{ $job->employees_count }} --}}
                                         @if($job->employees_count > 0)
                                            <a href="{{ route('admin.employes', ['job' => $job->id]) }}"
                                            class="badge bg-info text-white text-decoration-none">
                                                {{ $job->employees_count }}
                                            </a>
                                        @else
                                            0
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-holder d-flex align-items-center gap-3">
                                            <button type="button" wire:click='edit({{ $job->id }})'>
                                                <i class="fas fa-pen text-info icon-table"></i>
                                            </button>
                                            <button type="button" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal{{ $job->id }}">
                                                <i class="fas fa-trash text-danger icon-table"></i>
                                            </button>




                                            <div class="modal fade" id="exampleModal{{ $job->id }}" tabindex="-1"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">حذف</h1>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            هل متاكد من الحذف
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">الغاء</button>
                                                            <button wire:click='delete({{ $job->id }})'
                                                                type="button" class="btn btn-danger"
                                                                data-bs-dismiss="modal">نعم</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan='4'>
                                        <div class="alert alert-warning">
                                            @lang('No results')
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $jobs->links() }}

                </div>
            </form>
        </div>
    </div>
</div>
