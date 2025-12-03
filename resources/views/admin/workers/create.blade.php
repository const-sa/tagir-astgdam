@extends('admin.layouts.admin')
@section('title', 'اضافة عامل')
@section('content')
    <div class="main-side">
        <div class="d-flex align-items-center justify-content-between gap-3 mb-3">
            <div class="main-title mb-0">
                <div class="small">الرئيسية</div>
                <div class="large">اضافة عامل</div>
            </div>

            <a href="{{ route('admin.workers') }}" class="main-btn bg-secondary">رجوع <i
                    class="fas fa-arrow-left-long"></i></a>
        </div>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
            <div class="col">
                <div class="inp-holder">
                    <label class="special-input">
                        <span>اسم العامل</span>
                        <input type="text" class="form-control" placeholder="ادخل اسم العامل">
                    </label>
                </div>
            </div>

            <div class="col">
                <div class="inp-holder">
                    <label class="special-input">
                        <span>رقم الهوية</span>
                        <input type="text" class="form-control" placeholder="ادخل رقم الهوية">
                    </label>
                </div>
            </div>

            <div class="col">
                <div class="inp-holder">
                    <label class="special-input">
                        <span>رقم الجوال</span>
                        <input type="text" class="form-control" placeholder="ادخل رقم الجوال">
                    </label>
                </div>
            </div>

            

            <div class="col-12">
                <div class="btn-holder mt-2">
                    <button class="main-btn">حفظ</button>
                </div>
            </div>
        </div>
    </div>
@endsection
