<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PengurusController;
use App\Http\Controllers\AkunController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;

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
Route::get('/registration/{uuid?}', [RegisterController::class, 'showRegister'])->name('showRegister');
Route::post('/postregistration', [RegisterController::class, 'postRegister'])->name('postRegister');
Route::get('/verified/{uuid?}/{token?}', [RegisterController::class, 'verified'])->name('showVerified');
//Route::post('/verified/{uuid?}/{token?}', [RegisterController::class, 'postVerified'])->name('postVerified');
Route::get('/activated', [LoginController::class, 'showActivated'])->name('activated');

Route::get('/forgotpassword', [ForgotPasswordController::class, 'showFormReset'])->name('showFormReset');
Route::post('/sendmail', [ForgotPasswordController::class, 'sendMail'])->name('sendMail');
Route::get('/reset/{uuid?}/{token?}', [ForgotPasswordController::class, 'newPassword'])->name('newPassword');
Route::post('/sendnewpassword', [ForgotPasswordController::class, 'sendNewpassword'])->name('sendNewpassword');
Auth::routes();

// Rute yang membutuhkan autentikasi
Route::group(['middleware' => 'auth'], function () {
    
    // Rute yang bisa diakses oleh semua peran
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    // Route::post('/postActivated', [LoginController::class, 'postActivated'])->name('postActivated');
    Route::get('/addpost', [HomeController::class, 'addpost'])->name('addpost');
    Route::post('/storypost', [HomeController::class, 'postStory'])->name('addPost');
    Route::get('/pembayaran', [PembayaranController::class, 'index'])->name('pembayaran');
    Route::get('/addpembayaran', [PembayaranController::class, 'addpembayaran'])->name('addpembayaran');
    Route::post('/postpembayaran', [PembayaranController::class, 'postPembayaran'])->name('postPembayaran');
    Route::get('/akun', [AkunController::class, 'akun'])->name('akun');
    Route::get('/infoakun', [AkunController::class, 'infoakun'])->name('infoakun');
    Route::get('/inforekening', [AkunController::class, 'inforekening'])->name('inforekening');
    Route::get('/infokeluarga', [AkunController::class, 'infokeluarga'])->name('infokeluarga');
    Route::get('/edit', [AkunController::class, 'edit'])->name('edit');
    Route::get('/registrasi', [AkunController::class, 'registrasi'])->name('registrasi');
    
    Route::get('/logout', [LoginController::class, 'logout'])->name('log_out');
    
    // Rute khusus untuk pengurus
    Route::group(['middleware' => 'role:pengurus'], function () {
        Route::get('/pengurus', [PengurusController::class, 'index'])->name('pengurus');
    });
});

