@extends('admin.layouts.admin')
@section('title', 'اضافة مشروع')
@section('content')
    <div class="main-side">

        <div class="d-flex align-items-center justify-content-between gap-3 mb-3">
            <div class="main-title mb-0">
                <div class="small">الرئيسية</div>
                <div class="large">اضافة مشروع</div>
            </div>

            <a href="{{ route('admin.hiring') }}" class="main-btn bg-secondary">رجوع <i class="fas fa-arrow-left-long"></i></a>
        </div>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">

            <!-- عنوان المشروع -->
            <div class="col">
                <label>عنوان المشروع</label>
                <input type="text" class="form-control" placeholder="مثال: مشروع النظافة">
            </div>

            <!-- العميل -->
            <div class="col">
                <label>العميل</label>
                <select id="client" class="form-control">
                    <option value="">اختر العميل</option>
                    <option value="1" data-phone="01011111111" data-city="الرياض">شركة الفهد</option>
                    <option value="2" data-phone="01022222222" data-city="جدة">شركة الراشد</option>
                    <option value="3" data-phone="01033333333" data-city="الدمام">شركة الرفاعي</option>
                </select>
            </div>

            <!-- رقم الجوال تلقائي -->
            <div class="col">
                <label>رقم الجوال</label>
                <input type="text" id="client_phone" class="form-control" readonly>
            </div>

            <!-- المدينة تلقائي -->
            <div class="col">
                <label>المدينة</label>
                <input type="text" id="client_city" class="form-control" readonly>
            </div>

            <!-- بداية المشروع -->
            <div class="col">
                <label>بداية المشروع</label>
                <input type="date" class="form-control">
            </div>

            <!-- انتهاء المشروع -->
            <div class="col">
                <label>انتهاء المشروع</label>
                <input type="date" class="form-control">
            </div>

            <!-- العقد -->
            <div class="col">
                <label>العقد</label>
                <input type="file" class="form-control">
            </div>

            <!-- عدد العمال -->
            <div class="col">
                <label>عدد العمال</label>
                <input type="number" class="form-control" placeholder="مثال: 5">
            </div>

            <!-- زر الحفظ -->

        </div>
        <div class="col-12">
            <div class="btn-holder mt-2">
                <button class="main-btn">حفظ</button>
            </div>
        </div>
    </div>
@endsection

@push('js')
<script>
    // تعبئة الجوال والمدينة حسب اختيار العميل
    document.getElementById('client').addEventListener('change', function() {
        let selected = this.options[this.selectedIndex];

        document.getElementById('client_phone').value = selected.dataset.phone || '';
        document.getElementById('client_city').value = selected.dataset.city || '';
    });
</script>
@endpush
