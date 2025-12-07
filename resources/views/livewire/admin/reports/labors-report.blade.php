<div>
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
        <div class="main-title mb-0">
            <div class="small">
                @lang('admin.Home')
            </div>
            <div class="large">
                تقرير العمالة / الموظفين
            </div>
        </div>
        <div class="d-flex align-items-center gap-1">
            <button class="main-btn bg-warning" id="btn-prt-content">
                <i class="fas fa-print"></i> طباعة
            </button>
            <button class="main-btn bg-secondary" @click="changeView('main')">
                رجوع
                <i class="fas fa-arrow-left"></i>
            </button>
        </div>
    </div>

    @php
        $statusLabels = [
            'active'          => 'نشطين',
            'inactive'        => 'غير نشطين',
            'resigned'        => 'مستقيلين',
            'fired'           => 'مفصولين',
            'death'           => 'حالة وفاة',
            'exit_and_return' => 'خروج وعودة',
            'final_exit'      => 'خروج نهائي',
        ];
         $statusBadgeClasses = [
            'active'          => 'badge bg-success',
            'inactive'        => 'badge bg-secondary',
            'resigned'        => 'badge bg-warning text-dark',
            'fired'           => 'badge bg-danger',
            'death'           => 'badge bg-dark',
            'exit_and_return' => 'badge bg-info text-dark',
            'final_exit'      => 'badge bg-primary',
        ];
    @endphp

    <div class="content_view">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
            <div class="d-flex align-items-center gap-1 flex-wrap">
                {{-- <button
                    class="main-btn btn-main-color {{ $genderFilter === null ? '' : 'opacity-75' }}"
                    wire:click="setGenderFilter"
                >
                    كل العمال: {{ $totalLabors }}
                </button> --}}
                <button class="main-btn btn-main-color {{ $genderFilter === null && $statusFilter === null && $search === '' ? '' : 'opacity-75' }}"
                    wire:click="resetFilters">
                    كل العمال: {{ $totalLabors }}
                </button>


                <button
                    class="main-btn btn-blue {{ $genderFilter === 'male' ? '' : 'opacity-75' }}"
                    wire:click="setGenderFilter('male')"
                >
                    الذكور: {{ $maleCount }}
                </button>

                <button
                    class="main-btn btn-orange {{ $genderFilter === 'female' ? '' : 'opacity-75' }}"
                    wire:click="setGenderFilter('female')"
                >
                    الإناث: {{ $femaleCount }}
                </button>
            </div>
            {{-- <div class="col-12 col-md-3">
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fas fa-search"></i>
                    </span>
                    <input
                        type="text"
                        class="form-control"
                        placeholder="بحث بالاسم / رقم الهوية / الجوال"
                        wire:model.debounce.500ms="search"
                    >
                </div>
            </div> --}}
        </div>
        <div class="row g-2 mb-3">
            @foreach($statusLabels as $key => $label)
                <div class="col-6 col-md-3 col-lg-3">
                    <button
                        class="w-100 btn btn-sm
                            {{ $statusFilter === $key ? 'btn-main-color' : 'btn-outline-secondary' }}"
                        wire:click="setStatusFilter('{{ $key }}')"
                    >
                        <div class="fw-bold">{{ $label }}</div>
                        <div class="fs-5">{{ $statusCounts[$key] ?? 0 }}</div>
                    </button>
                </div>
            @endforeach
        </div>
        <div id="prt-content">
            <div class="table-responsive">
                <table class="main-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>الاسم</th>
                            <th>رقم الهوية</th>
                            <th>الجوال</th>
                            <th>الجنس</th>
                            <th>الحالة</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($employees as $emp)
                            <tr>
                                <td>{{ $emp->id }}</td>
                                <td>{{ $emp->name }}</td>
                                <td>{{ $emp->id_number ?? '-' }}</td>
                                <td>{{ $emp->phone ?? '-' }}</td>
                                <td>
                                    @if($emp->gender === 'male')
                                        ذكر
                                    @elseif($emp->gender === 'female')
                                        أنثى
                                    @else
                                        -
                                    @endif
                                </td>
                                {{-- <td>{{ $statusLabels[$emp->status] ?? $emp->status }}</td> --}}
                                <td>
                                    @php
                                        $statusKey   = $emp->status;
                                        $badgeClass  = $statusBadgeClasses[$statusKey] ?? 'badge bg-light text-dark';
                                        $statusLabel = $statusLabels[$statusKey] ?? $statusKey;
                                    @endphp

                                    <span class="{{ $badgeClass }}">
                                        {{ $statusLabel }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">
                                    لا توجد بيانات مطابقة للفلاتر الحالية
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-2">
                    {{ $employees->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

