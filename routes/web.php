<?php

use App\Livewire\Admin\AssignClassTeachers;
use App\Livewire\Admin\CalculatorFee;
use App\Livewire\Admin\ClassNames;
use App\Livewire\Admin\ClassNumbers;
use App\Livewire\Admin\ClassPackages;
use App\Livewire\Admin\ClassTypes;
use App\Livewire\Admin\Dashboard as AdminDashboard;
use App\Livewire\Admin\FeeRates;
use App\Livewire\Admin\RecordStudent;
use App\Livewire\Admin\ReportClasses;
use App\Livewire\Admin\StudentInfo;
use App\Livewire\Admin\Users;
use App\Livewire\Admin\OverduePayList;
use App\Livewire\Admin\AddClass;
use App\Livewire\Client\ListClientClass;
use App\Livewire\Client\ListMonthlyFee;
use App\Livewire\Client\ListMyClients;
use App\Livewire\Client\ListTransaction;
use App\Livewire\Teacher\ListAllowance;
use App\Livewire\Teacher\ListFee;
use App\Livewire\Teacher\ListYourClass;
use App\Livewire\Teacher\Memo;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Admin routes (role: admin)
Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/', AdminDashboard::class)->name('admin.dashboard');
    Route::get('/users', Users::class)->name('admin.users');
    Route::get('/class-names', ClassNames::class)->name('admin.class-names');
    Route::get('/class-packages', ClassPackages::class)->name('admin.class-packages');
    Route::get('/class-types', ClassTypes::class)->name('admin.class-types');
    Route::get('/class-numbers', ClassNumbers::class)->name('admin.class-numbers');
    Route::get('/fee-rates', FeeRates::class)->name('admin.fee-rates');
    Route::get('/assign-class-teachers', AssignClassTeachers::class)->name('admin.assign-class-teachers');
    Route::get('/report-classes', ReportClasses::class)->name('admin.report-classes');
    Route::get('/overdue-pay-list', OverduePayList::class)->name('admin.overdue-pay-list');
    Route::get('/add-class', AddClass::class)->name('admin.add-class');
    Route::get('/calculator-fee', CalculatorFee::class)->name('admin.calculator-fee');
    Route::get('/record-student', RecordStudent::class)->name('admin.record-student');
    Route::get('/student-info', StudentInfo::class)->name('admin.student-info');
});

// Teacher routes (role: teacher)
Route::middleware(['auth', 'verified', 'role:teacher'])->prefix('teacher')->group(function () {
    Route::get('/your-class', ListYourClass::class)->name('teacher.your-class');
    Route::get('/fee-student', ListFee::class)->name('teacher.fee-student');
    Route::get('/allowance', ListAllowance::class)->name('teacher.allowance');
    Route::get('/info', Memo::class)->name('teacher.info');
});

// Client routes (role: client)
Route::middleware(['auth', 'verified', 'role:client'])->prefix('client')->group(function () {
    Route::get('/my-clients', ListMyClients::class)->name('client.my-clients');
    Route::get('/client-class', ListClientClass::class)->name('client.client-class');
    Route::get('/monthly-fee', ListMonthlyFee::class)->name('client.monthly-fee');
    Route::get('/transaction', ListTransaction::class)->name('client.transaction');
});

require __DIR__.'/settings.php';
