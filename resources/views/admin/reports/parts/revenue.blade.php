<!-- Header -->
<div class="header-section">
    <h2 class="title">الايرادات / المطالبات</h2>
    <div class="header-buttons">
        <button class="btn-header btn-add" @click="changeView('main')">
            <i class="fas fa-arrow-right"></i> رجوع
        </button>

        <button class="btn-header btn-export">
            <i class="fas fa-file-excel"></i> استيراد Excel
        </button>

        <button class="btn-header btn-export bg-warning" id="btn-prt-content">
            <i class="fas fa-print"></i> طباعة
        </button>
    </div>
</div>

<!-- Filters -->
<div class="search-filter-section mb-4">
    <div class="row g-2 flex-grow-1 align-items-center">
        <div class="col-12 col-md-3">
            <div class="search-box">
                <i class="bi bi-search"></i>
                <input type="text" class="form-control" placeholder="ابحث...">
            </div>
        </div>
    </div>
</div>

<!-- Main Table -->
<div id="prt-content">
    <div class="table-responsive">
        <table class="main-table">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>اسم المزود</th>
                    <th>المبلغ المطلوب</th>
                    <th>التاريخ</th>
                    <th>حالة الدفع</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>مصر التامين</td>
                    <td>555</td>
                    <td>1/12/2025</td>
                    <td>مدفع</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
