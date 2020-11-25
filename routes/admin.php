<?php

use Illuminate\Support\Facades\Route;
use Azuriom\Plugin\Flyff\Controllers\Admin\MailController;
use Azuriom\Plugin\Flyff\Controllers\Admin\AdminController;
use Azuriom\Plugin\Flyff\Controllers\Admin\TradeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your plugin. These
| routes are loaded by the RouteServiceProvider of your plugin within
| a group which contains the "web" middleware group and your plugin name
| as prefix. Now create something great!
|
*/

Route::get('/', [AdminController::class, 'index'])->name('index');

Route::get('/mails', [MailController::class, 'index'])->name('mails');


Route::prefix('trades')->name('trades.')->group(function(){
    Route::get('/', [TradeController::class, 'index'])->name('index');
    Route::get('/{trade}', [TradeController::class, 'show'])->name('show');
});



