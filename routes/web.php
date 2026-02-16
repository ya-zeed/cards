<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->middleware('auth');

Route::post('/upload', [App\Http\Controllers\GiftCardController::class, 'store'])->middleware('auth');
Route::get('/card/{route}', [App\Http\Controllers\GiftCardController::class, 'downloadPage'])->name('giftcards.download');
Route::get('/cards', [App\Http\Controllers\GiftCardController::class, 'cardsByRoute'])->middleware('auth')->name('giftcards.cards');
Route::delete('/cards/{card}', [App\Http\Controllers\GiftCardController::class, 'destroy'])->middleware('auth')->name('giftcards.destroy');

Route::get('routes', [App\Http\Controllers\GiftCardController::class, 'showRoutes'])->middleware('auth');

Route::post('/track-download', [App\Http\Controllers\GiftCardController::class, 'trackDownload'])->name('track.download');
Route::post('/routes/update', [App\Http\Controllers\GiftCardController::class, 'updateRoute'])->middleware('auth')->name('routes.update');
Route::get('/admin', [App\Http\Controllers\GiftCardController::class, 'admin'])->middleware('auth')->name('admin.dashboard');

require __DIR__.'/auth.php';
