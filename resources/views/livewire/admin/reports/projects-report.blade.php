<div>
    <!-- Header -->
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
        <div class="main-title mb-0">
            <div class="small">
                @lang('admin.Home')
            </div>
            <div class="large">
                تقرير المشاريع
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
                            <option value="">كل العملاء</option>
                            @foreach ($clients as $client)
                                <option value="{{ $client->id }}">{{ $client->name }}</option>
                            @endforeach
                        </select>
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

        <!-- Main Table -->
        <div id="prt-content">
            <div class="table-responsive">
                <table class="main-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>العنوان</th>
                            <th>العميل</th>
                            <th>تاريخ البداية</th>
                            <th>تاريخ النهاية</th>
                            <th>حالة المشروع</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($projects as $project)
                            <tr>
                                <td>{{ $project->id }}</td>
                                <td>{{ $project->title ?? '-' }}</td>
                                <td>{{ $project->client?->name ?? '-' }}</td>
                                <td>{{ $project->start_date ?: '-' }}</td>
                                <td>{{ $project->end_date ?: '-' }}</td>
                                <td>
                                    @if ($project->end_date && $project->end_date <= now()->toDateString())
                                        منتهية
                                    @else
                                        سارية
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted">
                                    لا توجد مشاريع مطابقة للبحث
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-2">
                    {{ $projects->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

