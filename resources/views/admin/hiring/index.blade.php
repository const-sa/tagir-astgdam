@extends('admin.layouts.admin')
@section('content')
<div class="main-side">
    <div class="main-title">
        <div class="small">{{ __('admin.Home') }}</div>
        <div class="large">المشاريع وتأجير العمالة</div>
    </div>

    <div class="btn-holder d-flex align-items-center justify-content-between gap-3 flex-wrap mb-2">
        <div class="btn-holder d-flex align-items-center flex-wrap gap-1">
            <a href="{{ route('admin.hiring.create') }}" class="main-btn">اضافة تأجير <i class="fas fa-plus"></i></a>
            <button class="main-btn bg-success">مشاريع سارية: 5</button>
            <button class="main-btn bg-danger">مشاريع منتهية: 5</button>
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
                    <th>عنوان المشروع</th>
                    <th>العميل</th>
                    <th>رقم الجوال</th>
                    <th>المدينة</th>
                    <th> بداية المشروع</th>
                    <th> انتهاء المشروع</th>
                    <th> العقد</th>
                    <th> عدد العمال</th>
                    <th> التحكم</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>علي محمود</td>
                    <td>123</td>
                    <td>01011111111</td>
                    <td>--</td>
                    <td>مشروع النظافة</td>
                    <td>أحمد علي</td>
                    <td>
                        <button class="btn btn-sm btn-primary">مرفق</button>
                    </td>
                    <td>--</td>
                    <td class="not-print">
                        <div class="btn-holder d-flex align-items-center justify-content-center gap-3">

                            <button type="button" class="btn btn-sm btn-primary" title="تصدير بيانات العمال">
                                Excel <i class="fa-solid fa-file-excel"></i>
                            </button>
                            <button type="button" wire:click="edit(2)">
                                <svg class="svg-inline--fa fa-pen text-info icon-table" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="pen" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                    <path fill="currentColor" d="M362.7 19.32C387.7-5.678 428.3-5.678 453.3 19.32L492.7 58.75C517.7 83.74 517.7 124.3 492.7 149.3L444.3 197.7L314.3 67.72L362.7 19.32zM421.7 220.3L188.5 453.4C178.1 463.8 165.2 471.5 151.1 475.6L30.77 511C22.35 513.5 13.24 511.2 7.03 504.1C.8198 498.8-1.502 489.7 .976 481.2L36.37 360.9C40.53 346.8 48.16 333.9 58.57 323.5L291.7 90.34L421.7 220.3z"></path>
                                </svg><!-- <i class="fas fa-pen text-info icon-table"></i> Font Awesome fontawesome.com -->
                            </button>
                            <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                <svg class="svg-inline--fa fa-trash text-danger icon-table" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="trash" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                    <path fill="currentColor" d="M135.2 17.69C140.6 6.848 151.7 0 163.8 0H284.2C296.3 0 307.4 6.848 312.8 17.69L320 32H416C433.7 32 448 46.33 448 64C448 81.67 433.7 96 416 96H32C14.33 96 0 81.67 0 64C0 46.33 14.33 32 32 32H128L135.2 17.69zM394.8 466.1C393.2 492.3 372.3 512 346.9 512H101.1C75.75 512 54.77 492.3 53.19 466.1L31.1 128H416L394.8 466.1z"></path>
                                </svg><!-- <i class="fas fa-trash text-danger icon-table"></i> Font Awesome fontawesome.com -->
                            </button>
                            <div class="modal fade" id="exampleModal" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">حذف </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            هل انت متأكد من الحذف؟
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary btn-sm px-3" data-bs-dismiss="modal">الغاء
                                            </button>
                                            <button data-bs-dismiss="modal" class="btn btn-danger btn-sm px-3" wire:click="delete(2)">حذف
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="send_notification2" aria-hidden="true" wire:ignore.self="">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="showModalLabel">ارسال
                                                اشعار
                                            </h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-footer">
                                            <button wire:click="send_notification" type="button" class="btn btn-success btn-sm px-3" data-bs-dismiss="modal">إرسال
                                            </button>
                                            <button type="button" class="btn btn-secondary btn-sm px-3" data-bs-dismiss="modal">الغاء
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>
</div>
@endsection
