@extends('admin.layouts.admin')
@section('content')

<div class="main-side">
    <div class="main-title">
        <div class="small">{{ __('admin.Home') }}</div>
        <div class="large">ادارة المشاريع</div>
    </div>

    <div class="btn-holder d-flex align-items-center justify-content-between gap-3 flex-wrap mb-2">
        <div class="btn-holder d-flex align-items-center flex-wrap gap-1">
            <a href="{{ route('admin.management.create') }}" class="main-btn">اضافة مشروع <i class="fas fa-plus"></i></a>
            <button class="main-btn btn-main-color">عدد المشاريع: 3</button>
        </div>
        <div class="box-search">
            <img src="{{ asset('admin-asset/img/icons/search.png') }}" alt="icon" />
            <input type="search" id="search-project" placeholder="ابحث باسم المشروع">
        </div>
    </div>

    <div class="table-responsive">
        <table class="main-table mb-2">
            <thead>
                <tr>
                    <th>#</th>
                    <th>اسم المشروع</th>
                    <th>العميل</th>
                    <th>عدد العمال</th>
                    <th>تاريخ التأجير</th>
                    <th>تاريخ انتهاء التأجير</th>
                    <th>التحكم</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>مشروع النظافة</td>
                    <td>أحمد علي</td>
                    <td> <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#workersModal1">5</button> <!-- Workers Modal -->
                        <div class="modal fade" id="workersModal1" tabindex="-1" aria-labelledby="workersModalLabel1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="workersModalLabel1">تفاصيل العمال</h5> <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <table class="user-table">
                                            <thead>
                                                <tr>
                                                    <th>الاسم</th>
                                                    <th>رقم الهوية</th>
                                                    <th>رقم الجوال</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>علي محمود</td>
                                                    <td>123</td>
                                                    <td>01011111111</td>
                                                </tr>
                                                <tr>
                                                    <td>محمد سامي</td>
                                                    <td>124</td>
                                                    <td>01022222222</td>
                                                </tr>
                                                <tr>
                                                    <td>كريم عادل</td>
                                                    <td>125</td>
                                                    <td>01033333333</td>
                                                </tr>
                                                <tr>
                                                    <td>يوسف جمال</td>
                                                    <td>126</td>
                                                    <td>01044444444</td>
                                                </tr>
                                                <tr>
                                                    <td>محمود حسن</td>
                                                    <td>127</td>
                                                    <td>01055555555</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <style>
                                        .modal-body {
                                            padding: 20px;
                                            background-color: #f9f9f9;
                                            border-radius: 8px;
                                        }

                                        .user-table {
                                            width: 100%;
                                            border-collapse: collapse;

                                        }

                                        .user-table th,
                                        .user-table td {
                                            padding: 12px 15px;
                                            text-align: center;
                                        }

                                        .user-table thead th {
                                            background-color: #007BFF;
                                            color: #fff;
                                            font-weight: bold;
                                            /* border-radius: 4px 4px 0 0; */
                                        }

                                        .user-table tbody tr {
                                            background-color: #ffffff;
                                            border-bottom: 1px solid #ddd;
                                            transition: background-color 0.2s, transform 0.2s;
                                        }

                                        .user-table tbody tr:hover {
                                            background-color: #f1f7ff;
                                            transform: translateY(-2px);
                                        }

                                        .user-table tbody td {
                                            color: #333;
                                        }

                                        .user-table tbody tr:last-child {
                                            border-bottom: none;
                                        }
                                    </style>

                                    <div class="modal-footer"> <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">اغلاق</button> </div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>01-12-2025</td>
                    <td>31-12-2025</td>
                    <td>
                        <div class="d-flex align-items-center gap-2"> <button class="btn btn-sm btn-info"><i class="fa fa-pen"></i></button> <button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button> </div>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>


</div>
@endsection
