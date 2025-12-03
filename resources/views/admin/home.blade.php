@extends('admin.layouts.admin')

@section('content')
<div class="main-side">
    <div class="main-title">
        <div class="small">
            @lang('Home')
        </div>
        <div class="large">
            @lang('admin.Dashboard')
        </div>
    </div>
    <div class="row g-3 mb-2">
        <div class="col-12 ">
            <div class="d-flex gap-3 flex-wrap">
                <a href="{{ route('admin.contracts') }}" class="box-icon">
                    <i class="fas fa-file-signature"></i>
                    <div class="text">@lang('contracts')</div>
                </a>
                <a href="{{ route('admin.invoices') }}" class="box-icon">
                    <img src="{{ asset('admin-asset/img/invoice.svg') }}" alt="">
                    <div class="text">@lang('invoices')</div>
                </a>
                <a href="{{ route('admin.employes') }}" class="box-icon">
                    <img src="{{ asset('admin-asset/img/employees.svg') }}" alt="">
                    <div class="text">@lang('employees')</div>
                </a>
                <a href="{{ route('admin.goals') }}" class="box-icon">
                    <img src="{{ asset('admin-asset/img/documents.svg') }}" alt="">
                    <div class="text">@lang('goals')</div>
                </a>
                <a href="{{ route('admin.projects') }}" class="box-icon">
                    <i class="fab fa-buffer"></i>
                    <div class="text"> المشاريع</div>
                </a>
                <a href="{{ route('admin.notifications.index') }}" class="box-icon">
                    <img src="{{ asset('admin-asset/img/bell.svg') }}" alt="">
                    <div class="text">@lang('notifications')</div>
                </a>
            </div>
        </div>
        <style>
            .labor-cards-container {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 20px;
            }

            .labor-info-card {
                background: #ffffff;
                border-radius: 16px;
                padding: 10px;
                text-align: center;
                transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
                box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
                border: 1px solid #f0f0f0;
                position: relative;
                overflow: hidden;
            }

            .labor-info-card::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 4px;
                transition: transform 0.3s ease;
            }

            .labor-info-card:hover {
                transform: translateY(-8px) scale(1.02);
                box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
            }

            .labor-info-card.total-workers::before {
                background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
            }

            .labor-info-card.rented-workers::before {
                background: linear-gradient(90deg, #f093fb 0%, #f5576c 100%);
            }

            .labor-info-card.non-rented-workers::before {
                background: linear-gradient(90deg, #4facfe 0%, #00f2fe 100%);
            }

            .labor-card-icon {
                font-size: 2.5em;
                margin-bottom: 15px;
                display: block;
            }

            .labor-info-card.total-workers .labor-card-icon {
                color: #667eea;
            }

            .labor-info-card.rented-workers .labor-card-icon {
                color: #f5576c;
            }

            .labor-info-card.non-rented-workers .labor-card-icon {
                color: #4facfe;
            }

            .labor-card-title {
                font-size: 1em;
                margin-bottom: 15px;
                font-weight: 600;
                color: #333;
                letter-spacing: -0.3px;
            }

            .labor-count-number {
                font-size: 3em;
                font-weight: 800;
                line-height: 1;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }

            .labor-info-card.rented-workers .labor-count-number {
                background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }

            .labor-info-card.non-rented-workers .labor-count-number {
                background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }

            @media (max-width: 768px) {
                .labor-cards-container {
                    grid-template-columns: 1fr;
                    gap: 15px;
                }

                .labor-info-card {
                    padding: 25px 20px;
                }

                .labor-count-number {
                    font-size: 2.5em;
                }

                .labor-card-title {
                    font-size: 0.95em;
                }
            }
        </style>


        <div class="labor-dashboard-wrapper mb-4">
            <div class="labor-cards-container">
                <div class="labor-info-card total-workers">
                    <span class="labor-card-icon">👥</span>
                    <div class="labor-card-title">عدد العمالة الإجمالي</div>
                    <div class="labor-count-number" id="totalWorkers">150</div>
                </div>

                <div class="labor-info-card rented-workers">
                    <span class="labor-card-icon">📋</span>
                    <div class="labor-card-title">عمالة مؤجرة</div>
                    <div class="labor-count-number" id="rentedWorkers">95</div>
                </div>

                <div class="labor-info-card non-rented-workers">
                    <span class="labor-card-icon">✓</span>
                    <div class="labor-card-title">عمالة بدون تأجير</div>
                    <div class="labor-count-number" id="nonRentedWorkers">55</div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
            <div class="status_box blue-box">
                <div class="data">
                    <h3 class="num-stat" data-goal="{{ App\Models\User::employes()->count() }}">0</h3>
                    <p class="mb-3">@lang('all_employees')</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-tie blue-icon"></i>
                </div>
                <a href="{{ route('admin.employes') }}" class="more">
                    <i class="fa-solid fa-money-bills blue-icon"></i>
                    @lang('more_info')
                </a>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
            <div class="status_box warning-box">
                <div class="data">
                    <h3 class="num-stat" data-goal="100">0</h3>
                    <p class="mb-3">@lang('delayed_employees')</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-tie warning-icon"></i>
                </div>
                <a href="{{ route('admin.employes') }}" class="more">
                    <i class="fa-solid fa-circle-arrow-right"></i>
                    @lang('more_info')
                </a>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
            <div class="status_box danger-box">
                <div class="data">
                    <h3 class="num-stat"
                        data-goal="{{ App\Models\User::employes()->where('status', 'exit_and_return')->count() }}">0
                    </h3>
                    <p class="mb-3">@lang('exit_return_employees')</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-tie danger-icon"></i>
                </div>
                <a href="{{ route('admin.employes', ['status' => 'exit_and_return']) }}" class="more">
                    <i class="fa-solid fa-circle-arrow-right"></i>
                    @lang('more_info')
                </a>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
            <div class="status_box success-box">
                <div class="data">
                    <h3 class="num-stat" data-goal="100">0</h3>
                    <p class="mb-3">@lang('vacation_employees')</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-tie success-icon"></i>
                </div>
                <a href="{{ route('admin.employes') }}" class="more">
                    <i class="fa-solid fa-circle-arrow-right"></i>
                    @lang('more_info')
                </a>
            </div>
        </div>

        <div class="col-12 col-md-12">
            <div class="row g-3">
                <div class="col-12 col-md-6">
                    <div class="card">
                        <div class="card-header bg-white">
                            @lang('profit')
                        </div>
                        <div class="card-body">
                            <canvas class="w-100" id="myChartDate" height="250"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <div class="status_box main-box">
                                <div class="data">
                                    <h3 class="num-stat" data-goal="{{ App\Models\User::clients()->count() }}">0</h3>
                                    <p class="mb-3">@lang('Companies')</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-users main-icon"></i>
                                </div>
                                <a href="{{ route('admin.clients') }}" class="more">
                                    <i class="fa-solid fa-circle-arrow-right"></i>
                                    @lang('more_info')
                                </a>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="status_box purple-box">
                                <div class="data">
                                    <h3 class="num-stat" data-goal="{{ App\Models\Project::count() }}">0</h3>
                                    <p class="mb-3">@lang('projects_tasks')</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-briefcase purple-icon"></i>
                                </div>
                                <a href="{{ route('admin.projects') }}" class="more">
                                    <i class="fa-solid fa-circle-arrow-right"></i>
                                    @lang('more_info')
                                </a>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="status_box sky-box">
                                <div class="data">
                                    <h3 class="num-stat" data-goal="{{ App\Models\Goal::count() }}">0</h3>
                                    <p class="mb-3">@lang('goals')</p>
                                </div>
                                <div class="icon">
                                    <i class="fa-solid fa-bullseye sky-icon"></i>
                                </div>
                                <a href="{{ route('admin.goals') }}" class="more">
                                    <i class="fa-solid fa-circle-arrow-right"></i>
                                    @lang('more_info')
                                </a>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="status_box orange-box">
                                <div class="data">
                                    <h3 class="num-stat" data-goal="{{ App\Models\Contract::count() }}">0</h3>
                                    <p class="mb-3">@lang('contracts')</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-file-signature orange-icon"></i>
                                </div>
                                <a href="{{ route('admin.contracts') }}" class="more">
                                    <i class="fa-solid fa-circle-arrow-right"></i>
                                    @lang('more_info')
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
@push('js')
<script>
    let xValues = ["January", "February", "March", "April", "May", "June", "July"];
    new Chart("myChartDate", {
        type: "bar", // الرسم البياني من نوع الأعمدة
        data: {
            labels: xValues,
            datasets: [{
                    label: 'الأرباح',
                    data: [00, 100, 400, 500, 600, 700, 100],
                    backgroundColor: "#22baa6",
                    borderWidth: 1,
                    barThickness: 20,
                },
                {
                    type: 'line',
                    label: 'الطلبات',
                    data: [0, 50, 500, 200, 400, 300, 100],
                    borderWidth: 2,
                    pointRadius: 1,
                    borderColor: "#405189",
                    backgroundColor: "rgb(64 81 137 / 10%)",
                    fill: true
                },
                {
                    label: 'الربح',
                    data: [100, 200, 700, 800, 500, 600, 300],
                    type: 'line',
                    borderWidth: 2,
                    pointRadius: 1,
                    borderColor: "#f06548",
                    borderDash: [5, 5] // تحديد نمط متقطع للخط
                }
            ],
            options: {
                responsive: true,
                legend: {
                    display: true
                },
                tooltips: {
                    mode: 'index',
                    intersect: false
                },
                hover: {
                    mode: 'index',
                    intersect: false
                }
            }
        },
    });


    if (document.querySelectorAll(".num-stat")) {
        let numStats = document.querySelectorAll(".num-stat");
        let started = false;
        document.addEventListener("DOMContentLoaded", function() {
            numStats.forEach((num) => startCount(num));
        });

        function startCount(el) {
            let goal = el.dataset.goal;
            let duration = 2000; // تحديد المدة الزمنية
            let start = null;

            function updateCount(timestamp) {
                if (!start) start = timestamp;
                let progress = timestamp - start;
                let increment = Math.floor((progress / duration) * goal);
                el.textContent = increment > goal ? goal : increment;
                if (progress < duration) {
                    requestAnimationFrame(updateCount);
                }
            }
            requestAnimationFrame(updateCount);
        }
    }
</script>
@endpush
