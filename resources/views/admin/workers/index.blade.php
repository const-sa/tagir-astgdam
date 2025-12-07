@extends('admin.layouts.admin')
@section('content')
    <div class="main-side">

        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div class="main-title mb-0">
                <div class="small">الرئيسية</div>
                <div class="large">العمال</div>
            </div>
            <div class="alert alert-primary mb-0 mx-auto" role="alert">
                يمكنك البحث عن أي عامل برقم الهويه او رقم الجوال وسيظهر بيانت التأجير هنا
            </div>

        </div>

        {{-- الفلاتر (بيانات ثابتة) --}}
        <div class="btn-holder d-flex align-items-center justify-content-between gap-3 flex-wrap mb-3">
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <a href="#" class="main-btn">
                    اضافة عامل <i class="fas fa-plus"></i>
                </a>

                <button class="main-btn bg-success">
                    عدد العمال المؤجرين: 2
                </button>

                <button class="main-btn bg-danger">
                    عدد العمال غير المؤجرين: 3
                </button>
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
                        <th>الجنسية</th>
                        <th>رقم الإقامة</th>
                        <th>رقم الجوال</th>
                        <th>الحالة</th>
                        <th>المشروع</th>
                        <th>بداية التأجير</th>
                        <th>نهاية التأجير</th>
                        <th>التحكم</th>
                    </tr>
                </thead>

                <tbody>

                    <tr>
                        <td>1</td>
                        <td>علي محمود</td>
                        <td>مصري</td>
                        <td>987654</td>
                        <td>01011111111</td>
                        <td><span class="badge bg-success">مؤجر</span></td>
                        <td>مشروع A</td>
                        <td>2025-01-01</td>
                        <td>2025-03-01</td>
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
                        <td>سوداني</td>
                        <td>654321</td>
                        <td>01022222222</td>
                        <td><span class="badge bg-danger">غير مؤجر</span></td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
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
                        <td>مصري</td>
                        <td>112233</td>
                        <td>01033333333</td>
                        <td><span class="badge bg-success">مؤجر</span></td>
                        <td>مشروع B</td>
                        <td>2025-02-10</td>
                        <td>2025-04-10</td>
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
                        <td>يمني</td>
                        <td>445566</td>
                        <td>01044444444</td>
                        <td><span class="badge bg-danger">غير مؤجر</span></td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
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
                        <td>مصري</td>
                        <td>778899</td>
                        <td>01055555555</td>
                        <td><span class="badge bg-danger">غير مؤجر</span></td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
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
