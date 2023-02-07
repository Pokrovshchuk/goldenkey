<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CallbackController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\HallController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TinkoffController;
use App\Http\Controllers\YookassaController;
use App\Services\DaDataService;
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

// Register and login
Route::group(['middleware' => 'guest'], function () {
    Route::post('/register', [RegisteredUserController::class, 'store']);

    Route::post('/login', [LoginController::class, 'login']);

    Route::post('/resend-password', [RegisteredUserController::class, 'resendPassword']);

    Route::post('/forgot-password', [PasswordResetLinkController::class, 'restore'])
        ->name('password-request');
});


Route::get('/home', [HomeController::class, 'index']);

Route::post('/callback', [CallbackController::class, 'sendCallback']);

Route::get('/banks-list', [OrderController::class, 'banksList']);

Route::post('/order-make-land', [OrderController::class, 'orderMake']);

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/save-certificates', [CertificateController::class, 'saveCertificates']);

    Route::get('/user-product', [OrderController::class, 'productByUser']);

    Route::post('/order-make', [OrderController::class, 'orderMake']);

    Route::post('/password/new', [NewPasswordController::class, 'store']);

    Route::get('/cities', [CityController::class, 'all']);

    Route::get('/certificates', [CertificateController::class, 'index']);

    Route::post('/certificates', [CertificateController::class, 'store']);

    Route::post('/certificates-edit', [CertificateController::class, 'edit']);

    Route::post('/certificates-check', [CertificateController::class, 'codeCheck']);

    Route::post('/certificates-expired', [CertificateController::class, 'certificatesExpired']);

    Route::post('/certificates-remove', [CertificateController::class, 'removeAndRefreshHall']);

    Route::get('/certificates/list', [CertificateController::class, 'getAll']);

    Route::get('/certificate/search', [CertificateController::class, 'search']);

    Route::post('/certificates-change-status', [CertificateController::class, 'changeStatus']);

    Route::get('/hall', [HallController::class, 'hallWithActiveCertificates']);

    Route::get('/hall/certificates', [HallController::class, 'hallRegisterList']);

    Route::post('/logout', [LoginController::class, 'logout']);
});

// DaData
Route::group(['prefix' => 'dadata'], function () {
    Route::get('/fetch', [DaDataService::class, 'fetch']);
});

// Yookassa
Route::group(['prefix' => 'yookassa'], function () {
    Route::post('/notification', [YookassaController::class, 'notification']);
});

// Tinkoff
Route::group(['prefix' => 'tinkoff', 'as' => 'tinkoff.'], function () {
    Route::post('/notification', [TinkoffController::class, 'notification'])->name('notification');

    Route::get('/success/{order_id}', [TinkoffController::class, 'success'])->name('success');

    Route::get('/fail', [TinkoffController::class, 'fail'])->name('fail');
});
