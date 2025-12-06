<div>
    <!-- Header -->
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
        <div class="main-title mb-0">
            <div class="small">
                @lang('admin.Home')
            </div>
            <div class="large">
                تقرير العملاء
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

    <div class="content_view">
        <!-- Filters -->
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-1 mb-3">
            <div class="row g-2 align-items-end flex-grow-1">
                <div class="col-12 col-md-3">
                    <div class="input-group">
                        <span class="input-group-text">من</span>
                        <input type="date" class="form-control" wire:model.live="from_date">
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="input-group">
                        <span class="input-group-text">إلى</span>
                        <input type="date" class="form-control" wire:model.live="to_date">
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="inp-holder">
                        <select class="form-select" wire:model.live="client_id">
                            <option value="">اختر العميل </option>
                            @foreach ($clients as $client)
                                <option value="{{ $client->id }}">{{ $client->name }}</option>
                            @endforeach
                        </select>
                        {{-- {{ var_export($client_id) }} --}}
                    </div>
                </div>
            </div>
            <div class="d-flex align-items-center gap-1">
                <button
                    class="main-btn btn-main-color {{ $status_filter === 'all' ? '' : 'opacity-75' }}"
                    wire:click="setStatusFilter('all')"
                >
                    كل المشاريع: {{ $totalProjects }}
                </button>

                <button
                    class="main-btn bg-secondary {{ $status_filter === 'finished' ? '' : 'opacity-75' }}"
                    wire:click="setStatusFilter('finished')"
                >
                    مشاريع منتهية: {{ $finishedProjects }}
                </button>

                <button
                    class="main-btn {{ $status_filter === 'running' ? '' : 'opacity-75' }}"
                    wire:click="setStatusFilter('running')"
                >
                    مشاريع سارية: {{ $runningProjects }}
                </button>
            </div>
        </div>
        <div id="prt-content">
            <div class="table-responsive mb-4">
                <table class="main-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>العنوان</th>
                            <th>العميل</th>
                            <th>تاريخ البداية</th>
                            <th>تاريخ النهاية</th>
                            <th>حالة المشروع</th>
                            <th>قيمة العقد</th>
                            <th>المدفوع</th>
                            <th>المتبقي</th>
                            <th>الاجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($projects as $project)

                            <tr>
                                <td>{{ $project->id }}</td>
                                <td>{{ $project->title ?? '-' }}</td>
                                <td>{{ $project->client?->name }}</td>
                                <td>
                                    {{ $project->start_date ? $project->start_date : '-' }}
                                </td>
                                <td>
                                    {{ $project->end_date ? $project->end_date : '-' }}
                                </td>
                                <td>
                                    @if ($project->end_date && $project->end_date <= now()->toDateString())
                                        منتهية
                                    @else
                                        سارية
                                    @endif
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <div class="d-flex align-items-center justify-content-center gap-1">
                                        <button class="btn btn-sm btn-primary">العقود: 55</button>
                                        <button class="btn btn-sm btn-info">المشاريع: 55</button>
                                        <button class="btn btn-sm btn-success">الفواتير: 55</button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted">لا توجد مشاريع مطابقة للبحث</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $projects->links() }}
            </div>

            @if ($selectedClient)
                <!-- عقود العميل -->
                <div class="mb-4">
                    <h5 class="mb-2">العقود - {{ $selectedClient->name }}</h5>
                    <div class="table-responsive">
                        <table class="main-table">
                            <thead>
                            <tr>
                                <th>رقم العقد</th>
                                <th>تاريخ العقد</th>
                                <th>نهاية العقد</th>
                                <th>قيمة العقد</th>
                                <th>المدفوع</th>
                                <th>المتبقي</th>
                                <th>المرفق</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($contracts as $contract)
                                <tr>
                                    <td>{{ $contract->id }}</td>
                                    <td>{{ $contract->start_date }}</td>
                                    <td>{{ $contract->end_date }}</td>
                                    <td>{{ $contract->contract?->amount }}</td>
                                    <td>{{ $contract->contract?->paid }}</td>
                                    <td>{{ $contract->contract?->rest }}</td>
                                    <td>
                                        @if ($contract->contract_path)
                                            <a href="{{ display_file($contract->contract_path) }}" target="_blank"
                                               class="btn btn-sm btn-primary">
                                                عرض / تحميل
                                            </a>
                                        @else
                                            —
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">لا توجد عقود مسجلة</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- مشاريع العميل -->
                <div class="mb-4">
                    <h5 class="mb-2">المشاريع - {{ $selectedClient->name }}</h5>
                    <div class="table-responsive">
                        <table class="main-table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>العنوان</th>
                                <th>تاريخ البداية</th>
                                <th>تاريخ النهاية</th>
                                <th>حالة المشروع</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($clientProjects as $p)
                                <tr>
                                    <td>{{ $p->id }}</td>
                                    <td>{{ $p->title ?? $p->name ?? '-' }}</td>
                                    <td>{{ $p->start_date }}</td>
                                    <td>{{ $p->end_date }}</td>
                                    <td>
                                    @if ($p->end_date && $p->end_date <= now()->toDateString())
                                        منتهية
                                    @else
                                        سارية
                                    @endif
                                </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">لا توجد مشاريع للعميل</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- فواتير العميل -->
                <div class="mb-4">
                    <h5 class="mb-2">الفواتير - {{ $selectedClient->name }}</h5>
                    <div class="table-responsive">
                        <table class="main-table">
                            <thead>
                            <tr>
                                <th>الرقم</th>
                                <th>البيان</th>
                                <th>المبلغ</th>
                                <th>الضريبة</th>
                                <th>الإجمالي</th>
                                <th>الحالة</th>

                            </tr>
                            </thead>
                            <tbody>
                            @forelse($invoices as $invoice)
                                @php
                                    $amount = $invoice->amount ?? 0;
                                    $tax    = $invoice->tax ?? 0;
                                    $total  = $invoice->total ?? ($amount + $tax);
                                @endphp
                                <tr>
                                    <td>{{ $invoice->id ?? $invoice->number }}</td>
                                    <td>{{ $invoice->description ?? '-' }}</td>
                                    <td>{{ number_format($amount, 2) }}</td>
                                    <td>{{ number_format($tax, 2) }}</td>
                                    <td>{{ number_format($total, 2) }}</td>
                                    <td>
                                        @switch($invoice->status)
                                            @case('paid') مدفوع @break
                                            @case('partial') مدفوع جزئياً @break
                                            @case('unpaid') غير مدفوع @break
                                            @default {{ $invoice->status }}
                                        @endswitch
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">لا توجد فواتير للعميل</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
