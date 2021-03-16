<?php

use Illuminate\Support\Facades\Route;
use Azuriom\Plugin\Flyff\Controllers\FlyffHomeController;
use Azuriom\Plugin\Flyff\Controllers\FlyffGuildController;
use Azuriom\Plugin\Flyff\Controllers\FlyffAccountController;
use Azuriom\Plugin\Flyff\Controllers\FlyffCharacterController;

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

Route::prefix('accounts')->name('accounts.')->middleware('auth')->group(function () {
    Route::get('/', [FlyffHomeController::class, 'index'])->name('index');
    Route::post('/', [FlyffAccountController::class, 'store'])->name('store');
    Route::get('/{account}', [FlyffAccountController::class, 'edit'])->name('edit');
    Route::post('/{account}/change-password', [FlyffAccountController::class, 'update'])->name('change-password');
});

Route::prefix('guilds')->name('guilds.')->group(function(){
    Route::get('/', [FlyffGuildController::class, 'index'])->name('index');
    Route::get('/{guild}', [FlyffGuildController::class, 'show'])->name('show');
});

Route::prefix('characters')->name('characters.')->group(function(){
    Route::get('/', [FlyffCharacterController::class, 'index'])->name('index');
    Route::get('/{character}', [FlyffCharacterController::class, 'show'])->name('show');
});

Route::post('/update_character', [FlyffCharacterController::class, 'shop_update_character'])->name('cart.update_character');


