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
require __DIR__.'/auth.php';
