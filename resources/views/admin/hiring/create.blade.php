@extends('admin.layouts.admin')
@section('title', 'اضافة تأجير عامل')
@section('content')
    <div class="main-side">
        <div class="d-flex align-items-center justify-content-between gap-3 mb-3">
            <div class="main-title mb-0">
                <div class="small">الرئيسية</div>
                <div class="large">اضافة تأجير عامل</div>
            </div>

            <a href="{{ route('admin.hiring') }}" class="main-btn bg-secondary">رجوع <i class="fas fa-arrow-left-long"></i></a>
        </div>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">

            <!-- اختيار المشروع -->
            <div class="col">
                <label for="">المشروع</label>
                <select id="project" class="form-control">
                    <option value="">اختر المشروع</option>
                    <option value="1">مشروع النظافة</option>
                    <option value="2">مشروع الصيانة</option>
                    <option value="3">مشروع الأمن</option>
                </select>
            </div>

            <!-- اختيار العامل -->
            <div class="col">
                <label for="">العامل</label>
                <select id="worker" class="form-control">
                    <option value="">اختر العامل</option>
                    <option value="1" data-name="علي محمود" data-id="123" data-phone="01011111111">علي محمود</option>
                    <option value="2" data-name="محمد سامي" data-id="124" data-phone="01022222222">محمد سامي</option>
                    <option value="3" data-name="كريم عادل" data-id="125" data-phone="01033333333">كريم عادل</option>
                </select>
            </div>

            <!-- بيانات العامل تلقائياً -->
            <div class="col">
                <div class="inp-holder">
                    <label class="special-input">
                        <span>اسم العامل</span>
                        <input type="text" id="worker_name" class="form-control" readonly>
                    </label>
                </div>
            </div>
            <div class="col">
                <div class="inp-holder">
                    <label class="special-input">
                        <span>رقم الهوية</span>
                        <input type="text" id="worker_id" class="form-control" readonly>
                    </label>
                </div>
            </div>
            <div class="col">
                <div class="inp-holder">
                    <label class="special-input">
                        <span>رقم الجوال</span>
                        <input type="text" id="worker_phone" class="form-control" readonly>
                    </label>
                </div>
            </div>

            <!-- مدة التأجير -->
            <div class="col">
                <div class="inp-holder">
                    <label class="special-input">
                        <span>تاريخ بدء التأجير</span>
                        <input type="date" id="start_date" class="form-control">
                    </label>
                </div>
            </div>
            <div class="col">
                <div class="inp-holder">
                    <label class="special-input">
                        <span>تاريخ انتهاء التأجير</span>
                        <input type="date" id="end_date" class="form-control">
                    </label>
                </div>
            </div>

            <!-- زر الحفظ -->
            <div class="col-12">
                <div class="btn-holder mt-2">
                    <button class="main-btn">حفظ</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
<script>
    // عند اختيار العامل، عرض بياناته تلقائيًا
    document.getElementById('worker').addEventListener('change', function() {
        var selected = this.options[this.selectedIndex];
        document.getElementById('worker_name').value = selected.dataset.name || '';
        document.getElementById('worker_id').value = selected.dataset.id || '';
        document.getElementById('worker_phone').value = selected.dataset.phone || '';
    });
</script>
@endpush
