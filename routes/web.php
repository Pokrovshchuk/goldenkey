<?php

use App\Http\Controllers\CertificateController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\HallController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SocialAuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

//Route::get('/pdf', function () {
//    $certificate = \App\Models\Certificate::latest()->first();
//    $certificate->str = '123asd1';
//
//    return new \App\Mail\CertificateCreated($certificate);
//});

Route::group(['prefix' => 'auth'], function () {
    Route::get('redirect/{driver}', [SocialAuthController::class, 'driverRedirect']);

    Route::get('callback/{driver}', [SocialAuthController::class, 'driverCallback']);
});

Route::get('/admin/arm{any}', function () {
    return view('arm.index');
})->where('any', '.*');


//===============Admin===============
Route::group(['prefix' => 'admin', 'middleware' => 'auth:api'], function () {
    Route::get('/users', [UserController::class, 'getAll'])->name('users');

    Route::get('/cities', [CityController::class, 'getAll'])->name('cities');

    Route::post('/cities', [CityController::class, 'store'])->name('add-city');

    Route::get('/halls', [HallController::class, 'index'])->name('halls');

    Route::post('/halls', [HallController::class, 'store'])->name('add-hall');

    Route::post('/halls/edit', [HallController::class, 'edit'])->name('halls-edit');

    Route::post('/halls-add-service', [HallController::class, 'addService'])->name('halls-add-service');

    Route::get('/roles', [RoleController::class, 'index'])->name('roles');

    Route::post('/roles', [RoleController::class, 'store'])->name('add-role');

    Route::get('/products', [ProductController::class, 'index'])->name('products');

    Route::post('/products', [ProductController::class, 'store'])->name('add-products');

    Route::get('/certificates', [CertificateController::class, 'index'])->name('certificates');

    Route::post('/certificates', [CertificateController::class, 'testStore'])->name('create-certificates');

    Route::get('/services', [ServiceController::class, 'index'])->name('services');

    Route::post('/services', [ServiceController::class, 'store'])->name('add-service');

    Route::post('/services/edit', [ServiceController::class, 'edit'])->name('edit-service');

    Route::post('/services/add-content', [ServiceController::class, 'addContent'])->name('add-content');

    Route::post('/services/delete', [ServiceController::class, 'remove'])->name('delete-service');

    Route::post('/services/service-halls', [HallController::class, 'addServiceToHalls'])->name('add-service-to-halls');
});

Route::get('/api-docs', function () {
    return view('api-docs.gk-api-docs');
});

require __DIR__ . '/auth.php';
