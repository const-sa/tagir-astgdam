@extends('admin.layouts.admin')
@section('title', 'اضافة مشروع')
@section('content')
<div class="main-side">
    <div class="d-flex align-items-center justify-content-between gap-3 mb-3">
        <div class="main-title mb-0">
            <div class="small">الرئيسية</div>
            <div class="large">اضافة مشروع</div>
        </div>

        <a href="{{ route('admin.management') }}" class="main-btn bg-secondary">رجوع <i class="fas fa-arrow-left-long"></i></a>
    </div>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-3">

        <!-- اسم المشروع -->
        <div class="col">
            <div class="inp-holder">
                <label class="special-input">
                    <span>اسم المشروع</span>
                    <input type="text" class="form-control" placeholder="ادخل اسم المشروع">
                </label>
            </div>
        </div>

        <!-- وصف المشروع / ملاحظات -->
        <div class="col-12">
            <label for="">وصف المشروع</label>
            <textarea class="form-control" rows="3" placeholder="ادخل وصف أو ملاحظات عن المشروع"></textarea>
        </div>

        <!-- اختيار العمال (Multi-Select) -->
        <div class="col">
            <label for="">العمال</label>
            <select name="workers[]" id="workers" class="form-control select2" multiple="multiple">
                <option value="1">علي محمود</option>
                <option value="2">محمد سامي</option>
                <option value="3">كريم عادل</option>
                <option value="4">يوسف جمال</option>
                <option value="5">محمود حسن</option>
            </select>
        </div>

        <!-- مدة المشروع -->
        <div class="col">
            <div class="inp-holder">
                <label class="special-input">
                    <span>تاريخ بدء المشروع</span>
                    <input type="date" id="start_date" class="form-control">
                </label>
            </div>
        </div>
        <div class="col">
            <div class="inp-holder">
                <label class="special-input">
                    <span>تاريخ انتهاء المشروع</span>
                    <input type="date" id="end_date" class="form-control">
                </label>
            </div>
        </div>

        <!-- زر الحفظ -->

    </div>
      <div class="btn-holder mt-2">
                <button class="main-btn">حفظ</button>
            </div>
</div>
@endsection

@push('js')
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        // تفعيل Select2 للعمال
        $('#workers').select2({
            placeholder: "اختر العمال",
            allowClear: true
        });
    });
</script>
@endpush
