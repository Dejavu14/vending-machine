<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProdukController;
use App\Http\Controllers\TransaksiController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
Route::get('/produk/create', [ProdukController::class, 'create'])->name('produk.create');
Route::get('/produk/{id}', [ProdukController::class, 'show'])->name('produk.show');
Route::post('/produk', [ProdukController::class, 'store'])->name('produk.store');

Route::post('/produk/purchase', [ProdukController::class, 'purchase'])->name('produk.purchase');



Route::get('/transaksi', [TransaksiController::class, 'index']);
