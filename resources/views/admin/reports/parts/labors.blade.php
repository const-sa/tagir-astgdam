<!-- Header -->
{{-- <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
    <div class="main-title mb-0">
        <div class="small">
            @lang('admin.Home')
        </div>
        <div class="large">
            تقرير العمالة
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
        <div class="d-flex align-items-center gap-1">
            <button class="main-btn btn-main-color">كل العمال: 7</button>
            <button class="main-btn btn-blue">الذكور: 7</button>
            <button class="main-btn btn-orange">الاناث: 7</button>
            <button class="main-btn btn-purple">كل عمليات التاجير: 7</button>
        </div>
    </div>

    <!-- Main Table -->
    <div id="prt-content">
        <div class="table-responsive">
            <table class="main-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>خروج وعودة</th>
                        <th>اقامات منتهية</th>
                        <th>عقود منهية</th>
                        <th>جوازات منتهية</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>==</td>
                        <td>==</td>
                        <td>==</td>
                        <td>==</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div> --}}

<livewire:admin.reports.labors-report />
