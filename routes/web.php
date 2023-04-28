<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\dashboard\Analytics;
use App\Http\Controllers\authentications\Login;
use App\Http\Controllers\modules\Users;
use App\Http\Controllers\modules\Hits;
use App\Http\Controllers\modules\CancelBets;
use App\Http\Controllers\modules\Expenses;
use App\Http\Controllers\reports\Draw;
use App\Http\Controllers\modules\SoldOuts;
use App\Http\Controllers\modules\Settings;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
 
// Main Page Route

$controller_path = 'App\Http\Controllers';

// pages
Route::get('/pages/account-settings-account', $controller_path . '\pages\AccountSettingsAccount@index')->name('pages-account-settings-account');
Route::get('/pages/account-settings-notifications', $controller_path . '\pages\AccountSettingsNotifications@index')->name('pages-account-settings-notifications');
Route::get('/pages/account-settings-connections', $controller_path . '\pages\AccountSettingsConnections@index')->name('pages-account-settings-connections');
Route::get('/pages/misc-error', $controller_path . '\pages\MiscError@index')->name('pages-misc-error');
Route::get('/pages/misc-under-maintenance', $controller_path . '\pages\MiscUnderMaintenance@index')->name('pages-misc-under-maintenance');

// authentication
Route::get('/auth/forgot-password-basic', $controller_path . '\authentications\ForgotPasswordBasic@index')->name('auth-reset-password-basic');

Route::middleware('has.admin')->group(function () {
    Route::get('/', [Analytics::class, 'index'])->name('dashboard');
    // Route::get('/dashboard', [Analytics::class, 'index'])->name('dashboard');
    Route::get('/dashboard', function () {
        return redirect('/');
    })->name('dashboard.index');

    Route::prefix('hits')->group(function () {
        Route::get('/', [Hits::class, 'index'])->name('hits.index');
        Route::get('/create', [Hits::class, 'hitsForm'])->name('hits.create');
        Route::post('/create', [Hits::class, 'createOrUpdate'])->name('hits.create.post');
        Route::get('/reset', [Hits::class, 'reset'])->name('hits.reset');
        Route::get('/report', [Hits::class, 'report'])->name('hits.report');
        // Route::post('/report', [Hits::class, 'report'])->name('hits.report');
    });

    Route::prefix('cancel-bets')->group(function () {
        Route::get('/', [CancelBets::class, 'index'])->name('cancel-bets.index');
        Route::get('/approve', [CancelBets::class, 'approve'])->name('cancel-bets.approve');
    });

    Route::prefix('users')->group(function () {
        Route::get('/', [Users::class, 'index'])->name('users.index');
        Route::get('/create', [Users::class, 'userForm'])->name('users.create');
        Route::post('/create', [Users::class, 'createOrUpdate'])->name('users.create.post');
        Route::get('/edit/{id}', [Users::class, 'userForm'])->name('users.edit');
        Route::post('/edit/{id}', [Users::class, 'createOrUpdate'])->name('users.edit.post');
        // Route::get('/delete/{id}', [Users::class, 'delete'])->name('users.delete');
    });

    Route::prefix('sold-outs')->group(function () {
        Route::get('/', [SoldOuts::class, 'index'])->name('sold-outs.index');
        Route::get('/create', [SoldOuts::class, 'soldOutsForm'])->name('sold-outs.create');
        Route::post('/create', [SoldOuts::class, 'createOrUpdate'])->name('sold-outs.create.post');
        Route::get('/delete', [SoldOuts::class, 'delete'])->name('sold-outs.delete');
    });

    Route::prefix('hot-number')->group(function () {
        Route::get('/', [SoldOuts::class, 'index'])->name('sold-outs.index');
        Route::get('/create', [SoldOuts::class, 'soldOutsForm'])->name('sold-outs.create');
        Route::post('/create', [SoldOuts::class, 'createOrUpdate'])->name('sold-outs.create.post');
        Route::get('/delete', [SoldOuts::class, 'delete'])->name('sold-outs.delete');
    });

    Route::prefix('draw-limit')->group(function () {
        Route::get('/', [SoldOuts::class, 'index'])->name('sold-outs.index');
        Route::get('/create', [SoldOuts::class, 'soldOutsForm'])->name('sold-outs.create');
        Route::post('/create', [SoldOuts::class, 'createOrUpdate'])->name('sold-outs.create.post');
        Route::get('/delete', [SoldOuts::class, 'delete'])->name('sold-outs.delete');
    });

    Route::prefix('bet-limit')->group(function () {
        Route::get('/', [SoldOuts::class, 'index'])->name('sold-outs.index');
        Route::get('/create', [SoldOuts::class, 'soldOutsForm'])->name('sold-outs.create');
        Route::post('/create', [SoldOuts::class, 'createOrUpdate'])->name('sold-outs.create.post');
        Route::get('/delete', [SoldOuts::class, 'delete'])->name('sold-outs.delete');
    });

    // reports
    Route::prefix('reports')->group(function () {
        Route::get('/', [Draw::class, 'index'])->name('reports.index');
        // Route::post('/draw', [Draw::class, 'report'])->name('reports.report');
    });

    Route::prefix('approval')->group(function () {
        Route::get('/', [Expenses::class, 'index'])->name('expenses.index');
        Route::get('/approve', [Expenses::class, 'approve'])->name('expenses.approve');
    });

    Route::prefix('expenses')->group(function () {
        Route::get('/', [Expenses::class, 'index'])->name('expenses.index');
        Route::get('/create', [Expenses::class, 'expensesForm'])->name('expenses.create');
        Route::post('/create', [Expenses::class, 'createOrUpdate'])->name('expenses.create.post');
        Route::get('/edit/{id}', [Expenses::class, 'expensesForm'])->name('expenses.edit');
        Route::post('/edit/{id}', [Expenses::class, 'createOrUpdate'])->name('expenses.edit.post');
    });

    Route::prefix('settings')->group(function () {
        Route::get('/', [Settings::class, 'index'])->name('settings.index');
    });

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware('is.guest')->group(function () {
    Route::get('/login', [Login::class, 'index'])->name('login');
});