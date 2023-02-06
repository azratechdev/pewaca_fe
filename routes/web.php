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

Route::get('/', [LoginController::class, 'index'])->name('log');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Auth::routes();

Route::group(['middleware' => 'auth'], function(){
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    //user route
    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::post('/store', [UserController::class, 'store'])->name('store');
    Route::post('/getUser', [UserController::class, 'getUser'])->name('getUser');
    Route::put('/update/{id}', [UserController::class, 'update'])->name('update');
});

