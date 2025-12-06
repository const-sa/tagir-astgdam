@extends('admin.layouts.admin')

@section('content')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <div class="main-side" x-data="reportsData()">
        <div class="main-title" x-show="currentView === 'main'">
            <div class="small">
                @lang('admin.Home')
            </div>
            <div class="large">
                التقارير
            </div>
        </div>

        <!-- عرض البوكسات الرئيسية -->
        <template x-if="currentView === 'main'">
            <div class="content_view">
                <div class="row g-4">
                    <div class="col-12 col-md-4 col-lg-3">
                        <a href="javascript:void(0)" @click="changeView('clients')">
                            <div class="box-report">
                                <p class="mb-0">تقرير العملاء</p>
                                <img src="{{ asset('admin-asset/img/icons/public-relation.png') }}" alt="icon"
                                    class="report-img">
                            </div>
                        </a>
                    </div>
                    <div class="col-12 col-md-4 col-lg-3">
                        <a href="javascript:void(0)" @click="changeView('projects')">
                            <div class="box-report">
                                <p class="mb-0">تقرير المشاريع</p>
                                <img src="{{ asset('admin-asset/img/icons/project.png') }}" alt="icon"
                                    class="report-img">
                            </div>
                        </a>
                    </div>
                    <div class="col-12 col-md-4 col-lg-3">
                        <a href="javascript:void(0)" @click="changeView('labors')">
                            <div class="box-report">
                                <p class="mb-0">تقرير العماله</p>
                                <img src="{{ asset('admin-asset/img/icons/group.png') }}" alt="icon" class="report-img">
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </template>

        <!-- محتوى الشركات الأكثر استخداماً -->
        <template x-if="currentView === 'clients'" x-transition>
            <div>
                @include('admin.reports.parts.clients')
            </div>
        </template>

        <!-- محتوى المزودين الأكثر تعاقداً -->
        <template x-if="currentView === 'projects'" x-transition>
            <div>
                @include('admin.reports.parts.projects')
            </div>
        </template>

        <!-- محتوى الإيرادات / المطالبات -->
        <template x-if="currentView === 'labors'" x-transition>
            <div>
                @include('admin.reports.parts.labors')
            </div>
        </template>
    </div>

    <script>
        function reportsData() {
            return {
                currentView: 'main',
                changeView(view) {
                    this.currentView = view;
                }
            }
        }
    </script>
@endsection
