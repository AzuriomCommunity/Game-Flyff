<?php

use Illuminate\Support\Facades\Route;
use Azuriom\Plugin\Flyff\Controllers\Admin\ItemController;
use Azuriom\Plugin\Flyff\Controllers\Admin\MailController;
use Azuriom\Plugin\Flyff\Controllers\Admin\AdminController;
use Azuriom\Plugin\Flyff\Controllers\Admin\TradeController;
use Azuriom\Plugin\Flyff\Controllers\Admin\SettingController;
use Azuriom\Plugin\Flyff\Controllers\Admin\GuildSiegeLogController;

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

Route::get('/settings', [SettingController::class, 'index'])->name('settings');

Route::get('/siege', [GuildSiegeLogController::class, 'index'])->name('siege');

Route::post('/add_siege', [GuildSiegeLogController::class, 'addSiege'])->name('addSiege');

Route::post('/settings', [SettingController::class, 'update'])->name('settings_update');

Route::get('/mails', [MailController::class, 'index'])->name('mails');

Route::get('/items/lookup', [ItemController::class, 'index'])->name('lookup');

Route::prefix('trades')->name('trades.')->group(function () {
    Route::get('/', [TradeController::class, 'index'])->name('index');
});
