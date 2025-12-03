@extends('admin.layouts.admin')
@section('content')
    <div class="main-side">
        <div class="main-title">
            <div class="small">{{ __('admin.Home') }}</div>
            <div class="large">العمال</div>
        </div>

        <div class="btn-holder d-flex align-items-center justify-content-between gap-3 flex-wrap mb-2">
            <div class="btn-holder d-flex align-items-center flex-wrap gap-1">
                <a href="{{ route('admin.workers.create') }}" class="main-btn">اضافة عامل <i class="fas fa-plus"></i></a>
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
                        <th>التحكم</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>علي محمود</td>
                        <td>123</td>
                        <td>01011111111</td>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <button class="btn btn-sm btn-info"><i class="fa fa-pen"></i></button>
                                <button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>محمد سامي</td>
                        <td>124</td>
                        <td>01022222222</td>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <button class="btn btn-sm btn-info"><i class="fa fa-pen"></i></button>
                                <button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>كريم عادل</td>
                        <td>125</td>
                        <td>01033333333</td>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <button class="btn btn-sm btn-info"><i class="fa fa-pen"></i></button>
                                <button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>يوسف جمال</td>
                        <td>126</td>
                        <td>01044444444</td>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <button class="btn btn-sm btn-info"><i class="fa fa-pen"></i></button>
                                <button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>محمود حسن</td>
                        <td>127</td>
                        <td>01055555555</td>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <button class="btn btn-sm btn-info"><i class="fa fa-pen"></i></button>
                                <button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
