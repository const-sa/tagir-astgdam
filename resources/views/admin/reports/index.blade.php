@extends('insurance.layouts.insurance')

@section('content')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <div class="main-content" x-data="reportsData()">

        <div class="container-fluid">
            <!-- Header -->
            <div class="header-section"  x-show="currentView === 'main'">
                <h2 class="title">التقارير</h2>
            </div>

            <!-- عرض البوكسات الرئيسية -->
            <div class="content_view" x-show="currentView === 'main'">
                <div class="row g-4">
                    <div class="col-12 col-md-4 col-lg-3">
                        <a href="javascript:void(0)" @click="changeView('companies')">
                            <div class="box-report">
                                <p class="mb-0">الشركات الاكثر استخداما</p>
                                <img src="{{ asset('provider-asset/img/icons/enterprise.png') }}" alt="icon"
                                    class="report-img">
                            </div>
                        </a>
                    </div>
                    <div class="col-12 col-md-4 col-lg-3">
                        <a href="javascript:void(0)" @click="changeView('providers')">
                            <div class="box-report">
                                <p class="mb-0">المزودين الاكثر تعاقدا</p>
                                <img src="{{ asset('provider-asset/img/icons/contract.png') }}" alt="icon"
                                    class="report-img">
                            </div>
                        </a>
                    </div>
                    <div class="col-12 col-md-4 col-lg-3">
                        <a href="javascript:void(0)" @click="changeView('revenue')">
                            <div class="box-report">
                                <p class="mb-0">الايرادات / المطالبات</p>
                                <img src="{{ asset('provider-asset/img/icons/money.png') }}" alt="icon"
                                    class="report-img">
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- محتوى الشركات الأكثر استخداماً -->
            <div x-show="currentView === 'companies'" x-transition>
                @include('insurance.reports.parts.companies')
            </div>

            <!-- محتوى المزودين الأكثر تعاقداً -->
            <div x-show="currentView === 'providers'" x-transition>
                @include('insurance.reports.parts.providers')
            </div>

            <!-- محتوى الإيرادات / المطالبات -->
            <div x-show="currentView === 'revenue'" x-transition>
                @include('insurance.reports.parts.revenue')
            </div>

        </div>
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
