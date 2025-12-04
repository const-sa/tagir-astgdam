<div class="main-side">
    @if ($screen === 'index')
        <div class="main-title">
            <div class="small">{{ __('admin.Home') }}</div>
            <div class="large">المشاريع وتأجير العمالة</div>
        </div>

        <div class="btn-holder d-flex align-items-center justify-content-between gap-3 flex-wrap mb-2">
            <div class="btn-holder d-flex align-items-center flex-wrap gap-1">
                <button wire:click="create" class="main-btn">اضافة تأجير <i class="fas fa-plus"></i></button>

                <button class="main-btn bg-success">
                    مشاريع سارية: {{ $activeCount }}
                </button>

                <button class="main-btn bg-danger">
                    مشاريع منتهية: {{ $finishedCount }}
                </button>
            </div>

            <div class="box-search">
                <img src="{{ asset('admin-asset/img/icons/search.png') }}" alt="icon" />
                <input type="search" placeholder="ابحث بعنوان المشروع أو اسم العميل"
                       wire:model.live="search">
            </div>
        </div>

        <x-admin-alert></x-admin-alert>

        <div class="table-responsive">
            <table class="main-table mb-2 table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>عنوان المشروع</th>
                        <th>العميل</th>
                        <th>رقم الجوال</th>
                        <th>المدينة</th>
                        <th>بداية المشروع</th>
                        <th>انتهاء المشروع</th>
                        <th>العقد</th>
                        {{-- <th>عدد العمال</th> --}}
                        <th>التحكم</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($projects as $project)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $project->title }}</td>
                            <td>{{ $project->client?->name }}</td>
                            <td>{{ $project->client?->phone }}</td>
                            <td>{{ $project->client_city ?? $project->client?->city?->name }}</td>
                            <td>{{ $project->start_date }}</td>
                            <td>{{ $project->end_date }}</td>
                            <td>
                                @if($project->contract_file)
                                    <a href="{{ display_file($project->contract_file) }}" target="_blank"
                                       class="btn btn-sm btn-primary">
                                        مرفق
                                    </a>
                                @else
                                    --
                                @endif
                            </td>
                            {{-- <td>{{ $project->workers_count ?? '--' }}</td> --}}
                            <td class="not-print">
                                <div class="btn-holder d-flex align-items-center justify-content-center gap-3">

                                    {{-- تصدير عمال المشروع (تضيفه لاحقاً) --}}
                                    <button type="button" class="btn btn-sm btn-primary" title="تصدير بيانات العمال">
                                        Excel <i class="fa-solid fa-file-excel"></i>
                                    </button>

                                    <button type="button" class="btn btn-sm btn-info"
                                            wire:click="edit({{ $project->id }})">
                                        <i class="fas fa-pen"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteProjectModal{{ $project->id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <div class="modal fade" id="deleteProjectModal{{ $project->id }}" tabindex="-1" aria-hidden="true"
                                        wire:ignore.self>
                                        <div class="modal-dialog">
                                            <div class="modal-content">

                                                <div class="modal-header">
                                                    <h5 class="modal-title">حذف المشروع</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>

                                                <div class="modal-body">
                                                    هل أنت متأكد أنك تريد حذف هذا المشروع؟
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">إلغاء</button>

                                                    <button type="button"
                                                            class="btn btn-danger btn-sm"
                                                            wire:click="delete({{ $project->id }})"
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
                            <td colspan="10" class="text-center">
                                لا توجد مشاريع حالياً
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-2">
                {{ $projects->links() }}
            </div>
        </div>

    @else
        {{-- شاشة الإضافة / التعديل --}}
        <div class="d-flex align-items-center justify-content-between gap-3 mb-3">
            <div class="main-title mb-0">
                <div class="small">الرئيسية</div>
                <div class="large">
                    {{ $screen === 'create' ? 'اضافة مشروع تأجير' : 'تعديل مشروع تأجير' }}
                </div>
            </div>

            <button wire:click="$set('screen','index')" class="main-btn bg-secondary">
                رجوع <i class="fas fa-arrow-left-long"></i>
            </button>
        </div>

        <x-admin-alert></x-admin-alert>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
            <div class="col">
                <label>عنوان المشروع</label>
                <input type="text" class="form-control"
                       placeholder="مثال: مشروع النظافة"
                       wire:model="title">
                @error('title') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="col">
                <label>العميل</label>
                <select wire:model.live="client_id" class="form-control">
                    <option value="">اختر العميل</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}">
                            {{ $client->name }}
                        </option>
                    @endforeach
                </select>
                @error('client_id') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="col">
                <label>رقم الجوال</label>
                <input type="text" class="form-control" wire:model="client_phone" readonly>
            </div>
            <div class="col">
                <label>المدينة</label>
                <input type="text" class="form-control" wire:model="client_city" readonly>
            </div>
            <div class="col">
                <label>بداية المشروع</label>
                <input type="date" class="form-control" wire:model="start_date">
            </div>
            <div class="col">
                <label>انتهاء المشروع</label>
                <input type="date" class="form-control" wire:model="end_date">
                @error('end_date') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            {{-- <div class="col">
                <label>عدد العمال</label>
                <input type="number" min="0" class="form-control" wire:model="workers_count">
            </div> --}}
            <div class="col">
                <label>العقد *</label>
                <input type="file" class="form-control" wire:model="contract_file" accept=".pdf,image/*">
                @error('contract_file') <span class="text-danger">{{ $message }}</span> @enderror

                @if($project_id)
                    @php
                        $currentProject = \App\Models\HiringProject::find($project_id);
                    @endphp
                    @if($currentProject && $currentProject->contract_file)
                        <div class="mt-1">
                            <a href="{{ display_file($currentProject->contract_file) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                عرض العقد الحالي
                            </a>
                        </div>
                    @endif
                @endif
            </div>
            <div class="col">
                <label>ملف اكسيل للعامل *</label>
                <input type="file" class="form-control" wire:model="workers_file" accept=".xlsx,.xls,.csv">
                @error('workers_file') <span class="text-danger">{{ $message }}</span> @enderror

                @if($project_id)
                    @php
                        $currentProject = $currentProject ?? \App\Models\HiringProject::find($project_id);
                    @endphp
                    @if($currentProject && $currentProject->workers_file)
                        <div class="mt-1">
                            <a href="{{ display_file($currentProject->workers_file) }}" target="_blank" class="btn btn-sm btn-outline-success">
                                تحميل ملف العمال الحالي
                            </a>
                        </div>
                    @endif
                @endif
            </div>
        </div>

        <div class="col-12">
            <div class="btn-holder mt-3">
                <button class="main-btn" wire:click="submit">حفظ</button>
            </div>
        </div>

    @endif
</div>

