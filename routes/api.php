<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\dashboard\Analytics;
use App\Http\Controllers\modules\Users;
use App\Http\Controllers\modules\Hits;
use App\Http\Controllers\modules\CancelBets;
use App\Http\Controllers\modules\Expenses;
use App\Http\Controllers\modules\SoldOuts;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

$controller_path = 'App\Http\Controllers';

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('gaming')->group(function () {
    Route::get('/', [AuthController::class, 'index']);
    Route::get('/load', [Analytics::class, 'index']);
    Route::get('/loadTop20', [Analytics::class, 'loadTop20']);
    Route::post('authorize', [AuthController::class, 'getStatus'])->name('login.post');
    Route::get('getDrawCategory', [AuthController::class, 'getDrawCategory']);
    Route::post('getReportPerDraw', [AuthController::class, 'getReportPerDraw']);
    Route::post('getDashboardPerUser', [AuthController::class, 'getDashboardPerUser']);
    
    Route::get('getRegisterUser', [Users::class, 'users']);
    Route::get('resetDevice', [Users::class, 'resetDevice']);
    
    Route::post('activateUser', [AuthController::class, 'activateUser']);

    Route::get('getGenerateHits', [Hits::class, 'hits']);
    Route::post('getReportHits', [Hits::class, 'report']);
    Route::get('getBetCancel', [CancelBets::class, 'cancelBets']);
    Route::get('getSoldOut', [SoldOuts::class, 'soldOuts']);

    Route::prefix('sold-outs')->group(function () {
        Route::post('/update', [SoldOuts::class, 'update']);
    });

    // tag users
    Route::get('getTellerUsers', [Users::class, 'getTellerUsers']);
    Route::get('getMasterAreaLocation', [Users::class, 'GetMasterAreaLocation']);

    Route::get('getApproval', [Expenses::class, 'approval']);
    Route::get('getExpenses', [Expenses::class, 'expenses']);
});
