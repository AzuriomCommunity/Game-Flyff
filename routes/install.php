<?php

use Illuminate\Support\Facades\Route;
use Azuriom\Plugin\Flyff\Controllers\InstallController;

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

$middleware = [
    \Azuriom\Http\Middleware\EncryptCookies::class,
    \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
    \Illuminate\Session\Middleware\StartSession::class,
    \Illuminate\View\Middleware\ShareErrorsFromSession::class,
];

Route::middleware($middleware)->group(function () {
    Route::get('/', [InstallController::class, 'index'])->name('index');
    Route::get('/adminAccount', [InstallController::class, 'adminAccount'])->name('adminAccount');
    Route::post('/storeAdminAccount', [InstallController::class, 'storeAdminAccount'])->name('storeAdminAccount');
    
    Route::post('/setupDatabase', [InstallController::class, 'setupDatabase'])->name('setupDatabase');
});
