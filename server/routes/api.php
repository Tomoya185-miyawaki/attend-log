<?php

declare(strict_types=1);

use App\Http\Controllers\AdminListController;
use App\Http\Controllers\Auth\AdminPasswordResetController;
use App\Http\Controllers\EmployeeCreateController;
use App\Http\Controllers\EmployeeIdController;
use App\Http\Controllers\EmployeeListController;
use App\Http\Controllers\EmployeeUpdateController;
use Illuminate\Support\Facades\Route;

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

/**
 * 認証が不要なルーティング
 */
Route::prefix('admin')->group(function () {
    Route::post('/password-reset', AdminPasswordResetController::class);
});

/**
 * 認証が必要なルーティング
 */
Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('/', AdminListController::class);
    });
    Route::prefix('employee')->group(function () {
        Route::get('/', EmployeeListController::class);
        Route::get('/{id}', EmployeeIdController::class);
        Route::post('/create', EmployeeCreateController::class);
        Route::patch('/{id}', EmployeeUpdateController::class);
    });
});
