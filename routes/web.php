<?php

use App\Http\Controllers\PDFController;
use Illuminate\Support\Facades\Artisan;
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

Route::get('/', [PDFController::class, 'index']);
Route::post('/upload', [PDFController::class, 'upload']);

Route::get('/generate-key', function () {
    Artisan::call('key:generate');
    return 'APP_KEY generated!!';
});