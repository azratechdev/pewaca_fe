<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PengurusController;
use App\Http\Controllers\AkunController;


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

Route::get('/', [LoginController::class, 'showLoginForm'])->name('showLoginForm');
Route::post('/', [LoginController::class, 'postlogin'])->name('postlogin');


Auth::routes();

// Rute yang membutuhkan autentikasi
Route::group(['middleware' => 'auth'], function () {
    
    // Rute yang bisa diakses oleh semua peran
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/activated', [LoginController::class, 'showActivated'])->name('activated');
    Route::post('/postActivated', [LoginController::class, 'postActivated'])->name('postActivated');
    Route::get('/addpost', [HomeController::class, 'addpost'])->name('addpost');
    Route::get('/pembayaran', [PembayaranController::class, 'index'])->name('pembayaran');
    Route::get('/addpembayaran', [PembayaranController::class, 'addpembayaran'])->name('addpembayaran');
    Route::post('/postpembayaran', [PembayaranController::class, 'postPembayaran'])->name('postPembayaran');
    Route::get('/akun', [AkunController::class, 'akun'])->name('akun');
    Route::put('/edit', [AkunController::class, 'edit'])->name('edit');
    Route::post('/registrasi', [AkunController::class, 'registrasi'])->name('registrasi');
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

    // Rute khusus untuk pengurus
    Route::group(['middleware' => 'role:pengurus'], function () {
        Route::get('/pengurus', [PengurusController::class, 'index'])->name('pengurus');
    });
});
// Auth::routes();

// Route::group(['middleware' => 'auth'], function(){

    //dashboard route
    // Route::get('/home', [HomeController::class, 'index'])->name('home');
    // Route::get('/activated', [LoginController::class, 'showActivated'])->name('activated');
    // Route::get('/activated', [LoginController::class, 'postActivated'])->name('postActivated');
    // Route::get('/addpost', [HomeController::class, 'addpost'])->name('addpost');

    // Route::get('/pembayaran', [PembayaranController::class, 'index'])->name('pembayaran');
    // Route::get('/addpembayaran', [PembayaranController::class, 'addpembayaran'])->name('addpembayaran');

    // Route::get('/pengurus', [PengurusController::class, 'index'])->name('pengurus');

    // Route::get('/akun', [AkunController::class, 'akun'])->name('akun');
    // Route::get('/edit', [AkunController::class, 'edit'])->name('edit');
    // Route::get('/registrasi', [AkunController::class, 'registrasi'])->name('registrasi');

   
    // Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
// });

