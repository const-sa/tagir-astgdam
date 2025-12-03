@extends('admin.layouts.admin')
@section('content')
    <div class="main-side">
        <div class="main-title">
            <div class="small">{{ __('admin.Home') }}</div>
            <div class="large">تأجير العمالة</div>
        </div>

        <div class="btn-holder d-flex align-items-center justify-content-between gap-3 flex-wrap mb-2">
            <div class="btn-holder d-flex align-items-center flex-wrap gap-1">
                <a href="{{ route('admin.hiring.create') }}" class="main-btn">اضافة عامل <i class="fas fa-plus"></i></a>
                <button class="main-btn btn-main-color">عدد العمال: 5</button>
            </div>
            <div class="box-search">
                <img src="{{ asset('admin-asset/img/icons/search.png') }}" alt="icon" />
                <input type="search" placeholder="ابحث باسم العامل">
            </div>
        </div>

        <div class="table-responsive">
            <table class="main-table mb-2 table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الاسم</th>
                        <th>رقم الهوية</th>
                        <th>رقم الجوال</th>
                        <th>المشروع</th>
                        <th>العميل</th>
                        <th>تاريخ انتهاء المشروع</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>علي محمود</td>
                        <td>123</td>
                        <td>01011111111</td>
                        <td>مشروع النظافة</td>
                        <td>أحمد علي</td>
                        <td>31-12-2025</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>محمد سامي</td>
                        <td>124</td>
                        <td>01022222222</td>
                        <td>مشروع الصيانة</td>
                        <td>محمد حسن</td>
                        <td>15-12-2025</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>كريم عادل</td>
                        <td>125</td>
                        <td>01033333333</td>
                        <td>مشروع النقل</td>
                        <td>سعيد مصطفى</td>
                        <td>20-12-2025</td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>يوسف جمال</td>
                        <td>126</td>
                        <td>01044444444</td>
                        <td>مشروع التغذية</td>
                        <td>علي سامي</td>
                        <td>25-12-2025</td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>محمود حسن</td>
                        <td>127</td>
                        <td>01055555555</td>
                        <td>مشروع الأمن</td>
                        <td>محمود علي</td>
                        <td>30-12-2025</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
