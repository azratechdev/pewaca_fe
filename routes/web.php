<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;

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
Route::post('/postlogin', [LoginController::class, 'postlogin'])->name('postlogin');



Auth::routes();

Route::group(['middleware' => 'auth'], function(){

    //dashboard route
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

    //user route
    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::get('/user/profile', [UserController::class, 'profile'])->name('profile');
    Route::post('/user/store', [UserController::class, 'store'])->name('store');
    Route::post('/user/getUser', [UserController::class, 'getUser'])->name('getUser');
    Route::put('/user/update/{id}', [UserController::class, 'update'])->name('update');
    Route::get('/user/delete/{id}', [UserController::class, 'destroy'])->name('destroy');

    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
});

