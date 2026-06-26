<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PrediksiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HistoryPrediksiController;
use App\Http\Controllers\IncomeEventController;

/*
|--------------------------------------------------------------------------
| LOGIN
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.process');


/*
|--------------------------------------------------------------------------
| DASHBOARD
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


/*
|--------------------------------------------------------------------------
| LAPORAN
|--------------------------------------------------------------------------
*/
Route::get('/laporan-penjualan', function () {
    return view('laporan');
})->middleware('auth')->name('laporan.penjualan');


/*
|--------------------------------------------------------------------------
| PREDIKSI
|--------------------------------------------------------------------------
*/
Route::get('/prediksi', [PrediksiController::class, 'index'])
    ->middleware('auth')
    ->name('prediksi.index');

Route::post('/prediksi/predict', [PrediksiController::class, 'predict'])
    ->middleware('auth')
    ->name('prediksi.predict');

     // History Prediksi
Route::get('/prediksi/history', [PrediksiController::class, 'historyIndex'])
    ->middleware('auth')
    ->name('prediksi.history');

Route::get('/prediksi/history/{id}', [PrediksiController::class, 'historyShow'])
    ->middleware('auth')
    ->name('prediksi.history.show');

    Route::get('/history', [HistoryPrediksiController::class, 'index'])->name('history.index');
    Route::delete('/history/{id}', [HistoryPrediksiController::class, 'destroy'])->middleware('auth')->name('history.destroy');
    Route::get('/history/{id}/export-pdf', [HistoryPrediksiController::class, 'exportPdf'])->middleware('auth')->name('history.exportPdf');

/*
|--------------------------------------------------------------------------
| PRODUK
|--------------------------------------------------------------------------
*/
Route::get('/produk', [ProdukController::class, 'index'])
    ->middleware('auth')
    ->name('produk.index');

Route::post('/produk/import', [ProdukController::class, 'import'])
    ->middleware('auth')
    ->name('produk.import');

Route::post('/produk/store', [ProdukController::class, 'store'])
    ->middleware('auth')
    ->name('produk.store');


/*
|--------------------------------------------------------------------------
| PENJUALAN
|--------------------------------------------------------------------------
*/
Route::get('/penjualan', [PenjualanController::class, 'index'])
    ->middleware('auth')
    ->name('penjualan.index');

Route::post('/penjualan/import', [PenjualanController::class, 'import'])
    ->middleware('auth')
    ->name('penjualan.import');

Route::post('/penjualan/store', [PenjualanController::class, 'store'])
    ->middleware('auth')
    ->name('penjualan.store');


/*
|--------------------------------------------------------------------------
| USER MANAGEMENT
|--------------------------------------------------------------------------
*/

Route::post('/user/store', [UserController::class, 'store'])
    ->middleware('auth')
    ->name('user.store');


/*
|--------------------------------------------------------------------------
| LOGOUT
|--------------------------------------------------------------------------
*/
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');


/*
|--------------------------------------------------------------------------
| PAGE STATIC
|--------------------------------------------------------------------------
*/
Route::get('/sidebar', fn() => view('sidebar'))->middleware('auth');