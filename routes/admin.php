<?php

use App\Http\Controllers\Admin\AccountTreeController;
use App\Http\Controllers\Admin\ArticlesController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ContactUsController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PrivacyPolicyController;
use App\Http\Controllers\Admin\ShowPriceQutation;
use App\Http\Controllers\Admin\TicketController;
use App\Http\Controllers\Admin\UsagePolicyController;
use App\Livewire\Accountant\AccountTree;
use App\Livewire\Admin\Accounting\Accounts;
use App\Livewire\Admin\Accounting\AccountsSettings;
use App\Livewire\Admin\Accounting\AccountStatement;
use App\Livewire\Admin\Accounting\BalanceSheet;
use App\Livewire\Admin\Accounting\CostCenters;
use App\Livewire\Admin\Accounting\IncomeStatement;
use App\Livewire\Admin\Accounting\ShowAccounts;
use App\Livewire\Admin\Accounting\TrialBalance;
use App\Livewire\Admin\AdministrationEmployes;
use App\Livewire\Admin\AdministrativeStructures;
use App\Livewire\Admin\Categories;
use App\Livewire\Admin\Cities;
use App\Livewire\Admin\ComponentJobs;
use App\Livewire\Admin\EmailMenu;
use App\Livewire\Admin\Employes;
use App\Livewire\Admin\Expired;
use App\Livewire\Admin\Goals;
use App\Livewire\Admin\Governmentals;
use App\Livewire\Admin\InsuranceCompanies;
use App\Livewire\Admin\Jobs;
use App\Livewire\Admin\Menus;
use App\Livewire\Admin\Messages\Image;
use App\Livewire\Admin\Messages\MessagesSent;
use App\Livewire\Admin\Messages\SendMessage;
use App\Livewire\Admin\Messages\Text;
use App\Livewire\Admin\Pages;
use App\Livewire\Admin\Programs;
use App\Livewire\Admin\Roles;
use App\Livewire\Admin\Settings;
use App\Livewire\Admin\ShowEmployee;
use App\Livewire\Admin\SubCategories;
use App\Livewire\Admin\Users;
use App\Livewire\Admin\Vacations;
use App\Livewire\Admin\Vouchers\CreateVouchers;
use App\Livewire\Admin\Vouchers\EditVouchers;
use App\Livewire\Admin\Vouchers\PaymentVoucher;
use App\Livewire\Admin\Vouchers\ReceiptVoucher;
use App\Livewire\Admin\Vouchers\ShowVouchers;
use App\Livewire\Admin\Vouchers\Vouchers;
use App\Livewire\Admin\WorkTypes;
use App\Models\PriceQuotation;
use App\Models\Voucher;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
], function () {
    Route::prefix('admin')->group(function () {
        // Livewire Update Route
        Livewire::setUpdateRoute(function ($handle) {
            return Route::post('/livewire/update', $handle);
        });

        // Authentication Routes
        Route::view('login', 'admin.login')->middleware('admin_guest')->name('login');
        Route::post('login', [AuthController::class, 'login'])->middleware('admin_guest')->name('login.post');

        // Protected Admin Routes
        Route::group(['middleware' => ['admin']], function () {
            // Dashboard
            Route::get('/', [DashboardController::class, 'index'])->name('home');

            // Settings Management
            Route::get('settings', Settings::class)
                ->middleware('can:read_settings')
                ->name('settings');

            // Client Management
            Route::prefix('clients')->group(function () {
                Route::view('/', 'admin.clients')
                    ->middleware('can:read_clients')
                    ->name('clients');
                Route::view('projects', 'admin.clients.projects')
                    ->middleware('can:read_clients')
                    ->name('clients.projects');
                Route::view('projects/show', 'admin.clients.show-project')
                    ->middleware('can:read_clients')
                    ->name('clients.show-project');
            });

            // Employee Management
            Route::prefix('employees')->group(function () {
                Route::get('/', Employes::class)
                    ->middleware('can:read_employees')
                    ->name('employes');
                Route::get('{employee}/show', ShowEmployee::class)
                    ->middleware('can:read_employees')
                    ->name('employees.show');
                Route::view('statistics', 'admin.employees.statistics')
                    ->middleware('can:read_employees')
                    ->name('employees.statistics');
                Route::get('vacations/{user?}', Vacations::class)
                    ->middleware('can:read_employees')
                    ->name('vacations');
            });

            // Administration Employees
            Route::prefix('administration-employees')->group(function () {
                Route::get('/', AdministrationEmployes::class)
                    ->middleware('can:read_administration_employees')
                    ->name('administration-employees');
                Route::view('create', 'admin.administration-employees.create')
                    ->middleware('can:create_administration_employees')
                    ->name('administration-employees.create');
                Route::view('show', 'admin.administration-employees.show')
                    ->middleware('can:read_administration_employees')
                    ->name('administration-employees.show');
            });

            // Price Quotations
            Route::prefix('prices')->group(function () {
                Route::view('/', 'admin.prices.index')
                    ->middleware('can:read_price_quotation')
                    ->name('prices');
                Route::get('{price_quotation}/show', \App\Livewire\Admin\ShowPriceQuotation::class)
                    ->middleware('can:read_price_quotation')
                    ->name('prices.show');
                Route::get('{price_quotation}/chat', \App\Livewire\PriceQuotationChats::class)
                    ->middleware('can:send_message_price_quotation')
                    ->name('prices.chat');
                Route::get('{price_quotation}/edit', \App\Livewire\PriceQuotationsChatEdite::class)
                    ->middleware('can:update_price_quotation')
                    ->name('prices.chat.edite');
                Route::get('{price_quotation}/contract/edit', \App\Livewire\PriceQuotationsChatEditeContract::class)
                    ->middleware('can:update_price_quotation')
                    ->name('prices.contract.edite');
            });

            // Projects
            Route::prefix('projects')->group(function () {
                Route::view('/', 'admin.projects.index')
                    ->middleware('can:read_projects')
                    ->name('projects');
                Route::view('form/{id?}', 'admin.projects.form')
                    ->middleware('can:create_projects')
                    ->name('projects.create');
                Route::get('{project}/show', fn(\App\Models\Project $project) => view('admin.projects.show', compact('project')))
                    ->middleware('can:read_projects')
                    ->name('projects.show');
            });

            // Goals
            Route::prefix('goals')->group(function () {
                Route::get('/', Goals::class)
                    ->middleware('can:read_goals')
                    ->name('goals');
                Route::view('create', 'admin.goals.create')
                    ->middleware('can:create_goals')
                    ->name('goals.create');
            });

            // Contracts
            Route::prefix('contracts')->group(function () {
                Route::view('/', 'admin.contracts.index')
                    ->middleware('can:read_contracts')
                    ->name('contracts');
                Route::view('form/{id?}', 'admin.contracts.form')
                    ->middleware('can:create_contracts')
                    ->name('contracts.form');
            });

            // Invoices
            Route::prefix('invoices')->group(function () {
                Route::view('/', 'admin.invoices.index')
                    ->middleware('can:read_invoices')
                    ->name('invoices');
                Route::view('create', 'admin.invoices.create')
                    ->middleware('can:create_invoices')
                    ->name('invoices.create');
                Route::view('show', 'admin.invoices.show')
                    ->middleware('can:read_invoices')
                    ->name('invoices.show');
            });

            // User Management
            Route::get('users', Users::class)
                ->middleware('can:read_users')
                ->name('users');
            Route::get('roles', Roles::class)
                ->middleware('can:read_roles')
                ->name('roles');

            // Messages
            Route::prefix('messages')->group(function () {
                Route::get('text', Text::class)->name('texts');
                Route::get('images', Image::class)->name('images');
                Route::get('send', SendMessage::class)->name('SendMessage');
                Route::get('sent', MessagesSent::class)->name('MessagesSent');
            });

            // Accountants
            Route::get('/accounts/tree', [AccountTreeController::class, 'index'])->name('accounts.tree');
            Route::get('/accounts/tree/data', [AccountTreeController::class, 'getTreeData'])->name('accounts.tree.data');
            Route::post('/accounts/add', [AccountTreeController::class, 'store'])->name('accounts.add');
            Route::post('/accounts/update', [AccountTreeController::class, 'update'])->name('accounts.update');

            Route::view('accounting', 'admin.accounting')->name('accounting')->middleware('can:read_accounts');
            Route::prefix('accounting')->group(function () {
                Route::get('account_settings', AccountsSettings::class)->name('account_settings');
                Route::get('accounts', Accounts::class)->name('accounts');
                Route::get('accounts/{account}', ShowAccounts::class)->name('accounts.show');
                Route::get('vouchers', Vouchers::class)->name('vouchers.index')->middleware('can:read_vouchers');
                Route::get('vouchers/create', CreateVouchers::class)->name('vouchers.create')->middleware('can:create_vouchers');
                Route::get('vouchers/receipt_voucher', ReceiptVoucher::class)->name('vouchers.receipt_voucher')->middleware('can:read_vouchers');
                Route::get('vouchers/payment_voucher', PaymentVoucher::class)->name('vouchers.payment_voucher')->middleware('can:read_vouchers');
                Route::get('vouchers/{voucher}/edit', EditVouchers::class)->name('vouchers.edit')->middleware('can:update_vouchers');
                Route::get('vouchers/show/{voucher}', function (Voucher $voucher) {
                    return view('admin.vouchers.show_voucher', compact('voucher'));
                })->name('vouchers.show_voucher')->middleware('can:read_vouchers');
                Route::get('vouchers/{voucher}', ShowVouchers::class)->name('vouchers.show')->middleware('can:read_vouchers');
                Route::get('account_statment', AccountStatement::class)->name('account_statment');

                Route::get('cost_centers', CostCenters::class)->name('cost_center.report');
                Route::get('balance_sheet', BalanceSheet::class)->name('balance_sheet');
                Route::get('trial_balance', TrialBalance::class)->name('trial_balance');
                Route::get('income_statement', IncomeStatement::class)->name('income_statement');
            });

            // Other Features
            Route::get('insurance-companies', InsuranceCompanies::class)
                ->middleware('can:read_insurance_companies')
                ->name('insurance_companies');
            Route::get('work-types', WorkTypes::class)
                ->middleware('can:read_work_types')
                ->name('work_types');
            Route::get('jobs', ComponentJobs::class)
                ->middleware('can:read_jobs')
                ->name('jobs');
            // Route::get('jobs', Jobs::class)->name('jobs');
            Route::get('governmentals', Governmentals::class)
                ->middleware('can:read_governmentals')
                ->name('governmentals');
            Route::get('expired', Expired::class)->name('expired');

            // Content Management
            Route::get('categories', Categories::class)->name('categories');
            Route::get('sub_categories', SubCategories::class)->name('sub-categories');
            Route::resource('articles', ArticlesController::class);
            Route::view('all_articles', 'admin.articles.index')->name('all_articles');
            Route::get('menus', Menus::class)->name('menus');
            Route::get('pages', Pages::class)->name('pages');
            Route::get('email_menu', EmailMenu::class)->name('email_menu');

            // Contact Management
            Route::get('contactes', \App\Livewire\Admin\ContactUs::class)
                ->middleware('can:read_contactes')
                ->name('contactes');
            Route::resource('contact-us', ContactUsController::class);

            // Administrative Structure
            Route::get('administrative-structure', AdministrativeStructures::class)
                ->middleware('can:read_administrative_structure')
                ->name('administrative-structure');

            // Library Management
            Route::prefix('library')->group(function () {
                Route::resource('/', \App\Http\Controllers\Admin\LibraryController::class);
                Route::post('deleteAll', [\App\Http\Controllers\Admin\LibraryController::class, 'deleteAll'])
                    ->name('library.deleteAll');
            });

            // Vendors
            Route::get('vendors', \App\Livewire\Admin\Vendors::class)->name('vendors.index');

            // Articles Categories
            Route::prefix('articles-categories')->group(function () {
                Route::view('/', 'admin.articles-categories.index')->name('articles-categories.index');
                Route::view('create', 'admin.articles-categories.createOrUpdate')->name('articles-categories.create');
                Route::view('edit', 'admin.articles-categories.edit')->name('articles-categories.edit');
            });

            // Sliders
            Route::view('sliders', 'admin.sliders.index')->name('sliders.index');

            // Tickets
            Route::resource('tickets', TicketController::class);
            Route::post('tickets/storeComment', [TicketController::class, 'storeComment'])->name('tickets.storeComment');

            // Notifications
            Route::get('notifications', \App\Livewire\Admin\Notifications::class)->name('notifications.index');
            Route::resource('/library', \App\Http\Controllers\Admin\LibraryController::class);
            Route::post('/library/deleteAll', [\App\Http\Controllers\Admin\LibraryController::class, 'deleteAll'])->name('library.deleteAll');

            // Policies
            Route::resource('privacy-policy', PrivacyPolicyController::class)->only(['index', 'update']);
            Route::resource('usage-policy', UsagePolicyController::class)->only(['index', 'update']);

            // Utilities
            Route::get('generate-translation', function () {
                Artisan::call('translations:find');
                return back()->with('success', 'تم بنجاح !');
            })->name('generate-translation');

            // Contract Language
            Route::get('contract-lang/{price_quotation}/show', function ($id) {
                $price_quotation = PriceQuotation::findOrFail($id);
                return view('admin.contract-lang', compact('price_quotation'));
            })->name('contract-lang');
        });
    });
});
