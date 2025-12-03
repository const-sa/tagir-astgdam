<div class="main-side">
    <div class="alert alert-primary">
        هنا يمكنك اضافة الوثائق لمتابعة الانتهاء والتجديد مثال ( السجل التجاري - الرخص…

    </div>
    <div class="main-title">
        <div class="small">@lang('admin.Home')</div>
        <div class="large">الوثائق الحكوميه

            @if (request('expired'))
                (المنتهيه)
            @endif
        </div>
    </div>
    <x-admin-alert></x-admin-alert>

    @if ($screen == 'index')
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-1 mb-2">
            <button class="main-btn" wire:click='$set("screen","create")'>@lang('admin.Add') <i
                    class="fas fa-plus"></i></button>
        </div>
        <div class="table-responsive">
            <table class="main-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الجهة الحكومية </th>
                        <th>تاريخ الانتهاء</th>
                        <th>الصوره</th>
                        <th>@lang('admin.Control')</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($governmentals as $governmental)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $governmental->name }}</td>
                            <td>{{ $governmental->expire_date }}</td>
                            <td>
                                @if (!$governmental->image)
                                    <img src="{{ asset('admin-asset/img/no-image.jpeg') }}" alt=""
                                        class="img-thumbnail img-preview" width="50">
                                @else
                                    <img src="{{ display_file($governmental->image) }}" alt=""
                                        class="img-thumbnail img-preview" width="50">
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-3">
                                    <button title="@lang('admin.Edit')" type="button"
                                        wire:click="edit({{ $governmental->id }})"><i></i>
                                        <i class="fa fa-edit text-info icon-table"></i>
                                    </button>
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                        <i class="fas fa-trash text-danger icon-table"></i>
                                    </button>
                                    <div class="modal fade" id="exampleModal" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">@lang('admin.Delete')
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    @lang('admin.Are you sure you want to delete?')
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary btn-sm px-3"
                                                        data-bs-dismiss="modal">@lang('Cancel')</button>
                                                    <button data-bs-dismiss="modal" class="btn btn-danger btn-sm px-3"
                                                        wire:click='delete({{ $governmental->id }})'>@lang('admin.Delete')</button>
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

        </div>
    @else
        @include('livewire.admin.governmentals.createOrUpdate')
    @endif
</div>
