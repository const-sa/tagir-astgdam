<div class="sidebar not-print" wire:ignore.self>
    <div class="tog-active d-none d-lg-block" data-tog="true" data-active=".app">
        <i class="fas fa-bars"></i>
    </div>
    <ul class="list">
        <li class="list-item {{ request()->routeIs('admin.home') ? 'active' : '' }}">
            <a href="{{ route('admin.home') }}">
                <div>
                    <i class="fa-solid fa-grip"></i>
                    @lang('admin.Home')
                </div>
            </a>
        </li>
        {{-- <li class="list-item">
            <a href="{{ route('home') }}" target="_blank">
        <div>
            <i class="fas fa-house"></i>
            @lang('admin.Visit front page')
        </div>
        </a>
        </li> --}}

        <li class="list-item">
            <a data-bs-toggle="collapse" href="#Notifications"
                aria-expanded="{{ request()->routeIs('admin.notifications.index') || request()->routeIs('admin.library.index') ? 'true' : 'false' }}">
                <div>
                    <i class="fa-solid fa-bell"></i>
                    @lang('admin.Notifications')
                </div>
                {{-- <i class="fa-solid fa-angle-left arrow"></i> --}}
                <i class="fas fa-angle-left "></i>
            </a>
        </li>
        <div wire:ignore.self id="Notifications"
            class="collapse item-collapse {{ request()->routeIs('admin.notifications.index') || request()->routeIs('admin.library.index') ? 'show' : '' }}">
            <li class="list-item {{ request()->routeIs('admin.notifications.index') ? 'active' : '' }}">
                <a href="{{ route('admin.notifications.index') }}">
                    <div>
                        <i class="fa-solid fa-bell"></i>
                        @lang('admin.Notifications')
                    </div>
                </a>
            </li>
            <li class="list-item {{ request()->routeIs('admin.library.index') ? 'active' : '' }}">
                <a href="{{ route('admin.library.index') }}" class="">
                    <div>
                        <i class="fa-solid fa-envelope-open-text"></i>
                        @lang('admin.Notifications Library')
                    </div>
                </a>
            </li>
        </div>
        @canany(['read_settings', 'read_governmentals', 'read_jobs', 'read_work_types', 'read_insurance_companies'])
            <li class="list-item">
                <a data-bs-toggle="collapse" href="#settings" aria-expanded="false">
                    <div>
                        <i class="fa-solid fa-gear icon"></i>
                        @lang('admin.Settings')
                    </div>
                    <i class="fas fa-angle-left "></i>
                </a>
            </li>

            <div id="settings" class="collapse item-collapse">
                @can('read_settings')
                    <li class="list-item">
                        <a href="{{ route('admin.settings') }}" class="">
                            <div>
                                <i class="fa-solid fa-gear icon"></i>
                                @lang('admin.Settings')
                            </div>
                        </a>
                    </li>
                @endcan
                <li class="list-item">
                        <a href="{{ route('admin.roles') }}" class="">
                            <div>
                                <i class="fas fa-users"></i>
                                الصلاحيات
                            </div>
                        </a>
                    </li>
                <li class="list-item">
                        <a href="{{ route('admin.cities') }}" class="">
                            <div>
                                <i class="fas fa-users"></i>
                                المدن
                            </div>
                        </a>
                    </li>
                <li class="list-item">
                        <a href="{{ route('admin.departments') }}" class="">
                            <div>
                                <i class="fas fa-users"></i>
                                اقسام الاداره
                            </div>
                        </a>
                    </li>
                @can('read_governmentals')
                    <li class="list-item">
                        <a href="{{ route('admin.governmentals') }}" class="">
                            <div>
                                <i class="fas fa-users"></i>
                                الوثائق الحكوميه
                            </div>
                        </a>
                    </li>
                @endcan

                @can('read_jobs')
                    <li class="list-item">
                        <a href="{{ route('admin.jobs') }}" class="">
                            <div>
                                <i class="fas fa-users"></i>
                                التحكم المهن
                            </div>
                        </a>
                    </li>

                @endcan
                <li class="list-item">
                    <a href="{{ route('admin.employees.statuses') }}" class="">
                        <div>
                            <i class="fas fa-chart-pie"></i>
                            احصائيات الموظفين
                        </div>
                    </a>
                </li>
                @can('read_work_types')
                    <li class="list-item">
                        <a href="{{ route('admin.work_types') }}" class="">
                            <div>
                                <i class="fas fa-users"></i>
                                انواع الدوام
                            </div>
                        </a>
                    </li>
                @endcan
                @can('read_insurance_companies')
                    <li class="list-item">

                        <a href="{{ route('admin.insurance_companies') }}" class="">
                            <div>
                                <i class="fas fa-users"></i>
                                شركات التامين
                            </div>
                        </a>
                    </li>
                @endcan

            </div>
        @endcanany
        @canany(['read_administration_employees', 'read_employees'])
            <li class="list-item">
                <a data-bs-toggle="collapse" href="#employesManagement" aria-expanded=""">
                    <div>
                        <i class=" fas fa-gear"></i>
                        ادارة الموظفين
                    </div>
                    <i class="fas fa-angle-left "></i>
                </a>
            </li>
            <div id="employesManagement" class="collapse item-collapse">

                <li class="list-item">
                    <a href="{{ route('admin.administration-employees') }}" class="">
                        <div>
                            <i class="fas fa-users"></i>
                            موظفين الادارة
                        </div>
                    </a>
                </li>
                <li class="list-item">
                    <a href="{{ route('admin.employes') }}" class="">
                        <div>
                            <i class="fas fa-users"></i>
                            الموظفين
                        </div>
                    </a>
                </li>

            </div>
        @endcanany

        @canany(['read_users', 'read_administrative_structure', 'read_contracts', 'read_projects', 'read_goals'])

            <li class="list-item">
                <a data-bs-toggle="collapse" href="#administrativeAffairs" aria-expanded=""">
                    <div>
                        <i class=" fas fa-gear"></i>
                        الشؤون الادارية
                    </div>
                    <i class="fas fa-angle-left"></i>
                </a>
            </li>
            <div id="administrativeAffairs" class="collapse item-collapse">
                @can('read_users')
                    <li class="list-item">
                        <a href="{{ route('admin.users') }}" class="">
                            <div>
                                <i class="fas fa-user-tie"></i>
                                @lang('admin.Moderators')
                            </div>
                        </a>
                    </li>
                @endcan

                @can('read_administrative_structure')
                    <li class="list-item">
                        <a href="{{ route('admin.administrative-structure') }}" class="">
                            <div>
                                <i class="fa-solid fa-code-branch"></i>
                                الهيكل الاداري
                            </div>
                        </a>
                    </li>
                @endcan

                @can('read_contracts')
                    <li class="list-item">
                        <a href="{{ route('admin.contracts') }}" class="">
                            <div>
                                <i class="fas fa-file-signature"></i>
                                العقود
                            </div>
                        </a>
                    </li>
                @endcan
                @can('read_projects')
                    <li class="list-item">
                        <a href="{{ route('admin.projects') }}" class="">
                            <div>
                                <i class="fas fa-briefcase"></i>
                                المشاريع
                            </div>
                        </a>
                    </li>
                @endcan
                @can('read_goals')
                    <li class="list-item">
                        <a href="{{ route('admin.goals') }}" class="">
                            <div>
                                <i class="fa-solid fa-bullseye"></i>
                                الاهداف
                            </div>
                        </a>
                    </li>
                @endcan
            </div>
        @endcanany
        <li class="list-item">
            <a data-bs-toggle="collapse" href="#hiring" aria-expanded=""">
                <div>
                    <i class=" fas fa-gear"></i>
                    مشاريع التاجير
                </div>
                <i class="fas fa-angle-left "></i>
            </a>
        </li>
        <div id="hiring" class="collapse item-collapse">

            {{-- <li class="list-item">
                <a href="{{ route('admin.management') }}" class="">
                    <div>
                        <i class="fas fa-users"></i>
                        المشاريع
                    </div>
                </a>
            </li> --}}
            <li class="list-item">
                <a href="{{ route('admin.hiring') }}" class="">
                    <div>
                        <i class="fas fa-users"></i>
                        تأجير العمالة
                    </div>
                </a>
            </li>
            <li class="list-item">
                <a href="{{ route('admin.workers') }}" class="">
                    <div>
                        <i class="fas fa-users"></i>
                        العمالة
                    </div>
                </a>
            </li>
        </div>
        @can('read_clients')
            <li class="list-item">
                <a href="{{ route('admin.clients') }}" class="">
                    <div>
                        <i class="fas fa-users"></i>
                        @lang('Clients')
                    </div>
                </a>
            </li>
        @endcan

        @can('read_invoices')
            <li class="list-item">
                <a href="{{ route('admin.invoices') }}" class="">
                    <div>
                        <i class="fas fa-receipt"></i>
                        الفواتير
                    </div>
                </a>
            </li>
        @endcan

        <li class="list-item">
            <a href="{{ route('admin.accounting') }}">
                <div>
                    <i class="fa-solid fa-grip"></i>
                    المحاسبة
                </div>
            </a>
        </li>

        <li class="list-item">
            <a href="{{ route('admin.accounting') }}">
                <div>
                    <i class="fa-solid fa-grip"></i>
                    التقارير
                </div>
            </a>
        </li>

        @can('read_price_quotation')
            <li class="list-item">
                <a href="{{ route('admin.prices') }}" class="">
                    <div>
                        <i class="fas fa-dollar-sign"></i>
                        عرض الأسعار
                    </div>
                </a>
            </li>
        @endcan

        {{-- @can('read_contactes')
            <li class="list-item">
                <a href="{{ route('admin.contactes') }}" class="">
                    <div>
                        <i class="fa-solid fa-handshake-angle"></i>
                        @lang('admin.Contact Us')
                        <div class="main-badge">{{ App\Models\ContactUs::count() }}</div>
                    </div>
                </a>
            </li>
        @endcan --}}
    </ul>
</div>
