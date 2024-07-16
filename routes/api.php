<?php

use App\Http\Controllers\Api\EmployerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    /** Get current user */
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    /** Employer Routes */
    Route::prefix('employers')
        ->name('employers.')
        ->group(function () {
            /** List employers */
            Route::get('list', [EmployerController::class, 'list']);

            /** Get employer */
            Route::get('get/{id}', [EmployerController::class, 'get']);
        });
});

/** Guest Routes */
Route::middleware('guest')->group(function () {
    /** Login Route */
    Route::post('login', [AuthController::class, 'login']);
});
