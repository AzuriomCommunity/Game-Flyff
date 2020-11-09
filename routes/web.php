<?php

use Illuminate\Support\Facades\Route;
use Azuriom\Plugin\Flyff\Controllers\FlyffHomeController;
use Azuriom\Plugin\Flyff\Controllers\FlyffAccountController;
use Azuriom\Plugin\Flyff\Controllers\FlyffRankingsController;

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
});

Route::prefix('rankings')->name('rankings.')->group(function () {
    Route::get('/guilds', [FlyffRankingsController::class, 'guilds'])->name('guilds');
    Route::get('/players', [FlyffRankingsController::class, 'players'])->name('players');
});


