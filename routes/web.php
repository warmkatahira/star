<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
// +-+-+-+-+-+-+-+- Welcome +-+-+-+-+-+-+-+-
use App\Http\Controllers\Welcome\WelcomeController;
// +-+-+-+-+-+-+-+- TOP +-+-+-+-+-+-+-+-
use App\Http\Controllers\Top\TopController;
// +-+-+-+-+-+-+-+- 履歴 +-+-+-+-+-+-+-+-
use App\Http\Controllers\History\HistoryController;
// +-+-+-+-+-+-+-+- 数量交換 +-+-+-+-+-+-+-+-
use App\Http\Controllers\QuantityChange\QuantityChangeController;
// +-+-+-+-+-+-+-+- 発注 +-+-+-+-+-+-+-+-
use App\Http\Controllers\Order\OrderController;

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

// ★☆★☆★☆★☆★☆★☆★☆★☆★☆★☆ Welcome ★☆★☆★☆★☆★☆★☆★☆★☆★☆★☆
    // -+-+-+-+-+-+-+-+-+-+-+-+ Welcome -+-+-+-+-+-+-+-+-+-+-+-+
    Route::controller(WelcomeController::class)->prefix('')->name('welcome.')->group(function(){
        Route::get('', 'index')->name('index');
    });
// ★☆★☆★☆★☆★☆★☆★☆★☆★☆★☆ Welcome ★☆★☆★☆★☆★☆★☆★☆★☆★☆★☆

// ログインとステータスチェック
Route::middleware(['auth'])->group(function () {
    // ★☆★☆★☆★☆★☆★☆★☆★☆★☆★☆ Top ★☆★☆★☆★☆★☆★☆★☆★☆★☆★☆
        // -+-+-+-+-+-+-+-+-+-+-+-+ TOP -+-+-+-+-+-+-+-+-+-+-+-+
        Route::controller(TopController::class)->prefix('top')->name('top.')->group(function(){
            Route::get('', 'index')->name('index');
        });
        // -+-+-+-+-+-+-+-+-+-+-+-+ 履歴 -+-+-+-+-+-+-+-+-+-+-+-+
        Route::controller(HistoryController::class)->prefix('history')->name('history.')->group(function(){
            Route::get('', 'index')->name('index');
            Route::get('download', 'download')->name('download');
        });
        // -+-+-+-+-+-+-+-+-+-+-+-+ 数量交換 -+-+-+-+-+-+-+-+-+-+-+-+
        Route::controller(QuantityChangeController::class)->prefix('quantity_change')->name('quantity_change.')->group(function(){
            Route::get('', 'index')->name('index');
            Route::post('change', 'change')->name('change');
        });
        // -+-+-+-+-+-+-+-+-+-+-+-+ 発注 -+-+-+-+-+-+-+-+-+-+-+-+
        Route::controller(OrderController::class)->prefix('order')->name('order.')->group(function(){
            Route::get('', 'index')->name('index');
            Route::post('upload', 'upload')->name('upload');
            Route::post('confirm', 'confirm')->name('confirm');
        });
});

require __DIR__.'/auth.php';
