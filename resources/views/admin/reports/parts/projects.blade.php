<!-- Header -->
{{-- <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
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
                    <span class="input-group-text" id="">من</span>
                    <input type="date" class="form-control">
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="input-group">
                    <span class="input-group-text" id="">الى</span>
                    <input type="date" class="form-control">
                </div>
            </div>
        </div>

        <div class="d-flex align-items-center gap-1">
            <button class="main-btn btn-main-color">كل المشاريع: 7</button>
            <button class="main-btn bg-secondary">مشاريع منتهية: 7</button>
            <button class="main-btn">مشاريع سارية: 7</button>
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
                    <tr>
                        <td>1</td>
                        <td>مشروع تجريبى</td>
                        <td>22/10/2025</td>
                        <td>22/10/2025</td>
                        <td>منتهى</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div> --}}
<livewire:admin.reports.projects-report />
