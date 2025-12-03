<nav class="main-navbar not-print">
    <div class="container-fluid d-flex align-items-center justify-content-between">
        <div class="logo">
            <div class="tog-active d-block d-lg-none" data-tog="true" data-active=".app">
                <i class="fas fa-bars"></i>
            </div>
            <img src="{{ asset('admin-asset/img/logo.png') }}" alt="logo" class="img">

        </div>
        @php
            $userNeedToReturn = App\Models\User::whereHas('vacations', function ($q) {
                $q->where('return_at', '<', now()->format('Y-m-d'))->whereNull('user_return_at');
            })->count();
        @endphp
        <div class="d-flex align-items-center gap-3">
            <div class="list-item d-none d-md-flex">
                <a href="{{ route('admin.vacations', ['expired' => true]) }}" class="main-btn btn-main-color">
                    موظفين تعدوا تاريخ العودة : {{ $userNeedToReturn }}
                    <i class="fas fa-bell"></i>
                </a>
            </div>

            @php
                $count =
                    App\Models\Governmental::whereDate('expire_date', '<', now())->count() +
                    App\Models\User::whereDate('end_id_number', '<', now())->count() +
                    App\Models\User::whereDate('end_insurance', '<', now())->count() +
                    App\Models\User::whereDate('end_passport', '<', now())->count() +
                    App\Models\User::whereDate('end_driver_card', '<', now())->count() +
                    App\Models\User::whereDate('end_health_card', '<', now())->count() +
                    App\Models\User::whereDate('end_is_employee', '<', now())->count() +
                    App\Models\User::whereDate('end_resident', '<', now())->count();
            @endphp
            <div class="list-item d-none d-md-flex">
                <a href="{{ route('admin.expired') }}" class="main-btn btn-main-color">
                    @lang('expired_documents') :
                    {{ $count }}
                    <i class="fas fa-bell"></i>
                </a>
            </div>



            <div class="list-item d-none d-md-flex">
                <a href="#" class="main-btn btn-main-color">
                    @lang('exit_return_request') : 1
                    <i class="fas fa-bell"></i>
                </a>
            </div>

            <div class="dropdown">
                <button class="btn btn-light dropdown-toggle btn-sm px-4" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    {{ LaravelLocalization::getSupportedLocales()[app()->getLocale()]['native'] }}
                </button>
                <ul class="dropdown-menu">
                    @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                        <li><a class="dropdown-item" rel="alternate" hreflang="{{ $localeCode }}"
                                href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">{{ $properties['native'] }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>


            <div class="dropdown info-user ms-auto">
                <button class="dropdown-toggle d-flex align-items-center gap-2 content" type="button"
                    id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="text">
                        <div class="name">
                            <i class="fas fa-angle-down"></i>
                            {{ auth()->user()->name }}
                        </div>
                        <div class="dic">
                            @lang('Management')
                            @endlang
                        </div>
                    </div>
                    <div class="img">
                        <img src="{{ asset('admin-asset/img/icons/user-black.svg') }}" alt="" class="icon" />
                    </div>
                </button>


                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    @auth
                        <li>
                            <form action="{{ route('admin.logout') }}" method="POST">
                                @csrf
                                <button class="dropdown-item" type="submit">
                                    تسجيل الخروج
                                </button>
                            </form>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </div>
</nav>
