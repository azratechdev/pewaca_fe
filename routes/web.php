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
use App\Http\Controllers\TagihanController;
use App\Http\Controllers\ReportController;
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
    Route::post('/fetch-html-comment', [HomeController::class, 'getReplays'])->name('getReplays');
    Route::post('/comment-more', [HomeController::class, 'getReplaysMore'])->name('getReplaysMore');
   
    
    //AKun Route
    Route::get('/akun', [AkunController::class, 'akun'])->name('akun');
    Route::get('/infoakun', [AkunController::class, 'infoakun'])->name('infoakun');
    Route::get('/akun/edit/profile/', [AkunController::class, 'editAkun'])->name('akunEdit');
    Route::post('/akun/edit/profile/', [AkunController::class, 'updateAkun'])->name('akunUpdate');
    Route::get('/inforekening', [AkunController::class, 'inforekening'])->name('inforekening');
    Route::get('/rekening/add', [AkunController::class, 'addRekening'])->name('addRekening');
    Route::post('/rekening/post', [AkunController::class, 'postRekening'])->name('postRekening');
    Route::get('/infokeluarga', [AkunController::class, 'infokeluarga'])->name('infokeluarga');
    Route::get('/addkeluarga', [AkunController::class, 'addKeluarga'])->name('addkeluarga');
    Route::get('/postkeluarga', [AkunController::class, 'postKeluarga'])->name('postkeluarga');
    Route::get('/edit', [AkunController::class, 'edit'])->name('edit');
    Route::get('/registrasi', [AkunController::class, 'registrasi'])->name('registrasi');
    Route::get('/kontak', [AkunController::class, 'kontak'])->name('kontak');
    Route::get('/policy', [AkunController::class, 'policy'])->name('policy');
    Route::get('/faq', [AkunController::class, 'faq'])->name('faq');
    Route::get('/logout', [LoginController::class, 'logout'])->name('log_out');

       
    // Rute khusus untuk pengurus
    Route::group(['middleware' => 'role:pengurus'], function () {
        Route::get('/pengurus', [PengurusController::class, 'index'])->name('pengurus');
        Route::get('/pengurus/warga/warga-detail/{id}', [PengurusController::class, 'detail_warga'])->name('detail_warga');
        Route::get('/pengurus/warga/warga-reject/{id}', [PengurusController::class, 'reject_warga'])->name('reject_warga');
        Route::post('/pengurus/warga/post-reject', [PengurusController::class, 'post_reject'])->name('post_reject');
                
        Route::get('/pengurus/tagihan', [PengurusController::class, 'pengurus_tagihan'])->name('pengurus.tagihan');
        
        //new route pengurus biaya
        Route::match(['get', 'post'], '/pengurus/biaya/list', [PengurusController::class, 'list_biaya'])->name('pengurus.biaya.list');
        Route::match(['get', 'post'], '/pengurus/biaya/konfirmasi', [PengurusController::class, 'list_konfirmasi'])->name('pengurus.biaya.konfirmasi');
        Route::match(['get', 'post'], '/pengurus/biaya/disetujui', [PengurusController::class, 'list_disetujui'])->name('pengurus.biaya.disetujui');
        Route::match(['get', 'post'], '/pengurus/biaya/tunggakan', [PengurusController::class, 'list_tunggakan'])->name('pengurus.biaya.tunggakan');
        //

        Route::match(['get', 'post'], '/pengurus/peran', [PengurusController::class, 'pengurus_role'])->name('pengurus.role');
        Route::get('/pengurus/peran/add', [PengurusController::class, 'addPengurus'])->name('addPengurus');
        //Route::get('/pengurus/warga', [PengurusController::class, 'pengurus_warga'])->name('pengurus.warga');

        //new route pengurus warga
        Route::match(['get', 'post'], '/pengurus/warga/waitingapproval', [PengurusController::class, 'waiting_approval_warga'])->name('pengurus.warga.waiting');
        Route::match(['get', 'post'], '/pengurus/warga/approved', [PengurusController::class, 'approved_warga'])->name('pengurus.warga.approved');
        //

        Route::post('/pengurus/peran/postrole', [PengurusController::class, 'postRole'])->name('pengurus.postrole');

        Route::get('/pengurus/tagihan/list', [TagihanController::class, 'list'])->name('pengurus.tagihan.list');
        Route::get('/pengurus/tagihan/add', [TagihanController::class, 'addTagihan'])->name('tagihan.add');
        Route::post('/pengurus/tagihan/post', [TagihanController::class, 'postTagihan'])->name('tagihan.post');
        Route::get('/pengurus/tagihan/{id}/edit', [TagihanController::class, 'editTagihan'])->name('pengurus.tagihan.edit');
        Route::put('/pengurus/tagihan/update', [TagihanController::class, 'postEditTagihan'])->name('pengurus.tagihan.postEdit');
        Route::get('/pengurus/tagihan/approval/{id}/detail', [TagihanController::class, 'approvalDetail'])->name('pengurus.approval.detail');
        Route::post('/pengurus/tagihan/publish', [TagihanController::class, 'publish'])->name('tagihan.publish');
        
        //report route
        Route::get('/pengurus/report', [ReportController::class, 'index'])->name('pengurus.report');
        Route::get('/pengurus/detail-by-chasout/{periode}/{unit?}', [ReportController::class, 'detail_report'])->name('pengurus.detail.report');
        Route::get('/pengurus/detail-tunggakan/{periode}/{unit?}', [ReportController::class, 'detail_tunggakan'])->name('pengurus.detail.tunggakan');
        Route::get('/pengurus/detail-by-type/{periode}/{unit?}', [ReportController::class, 'detail_by_type'])->name('pengurus.detail.bytype');
        //end report route
    });
    
    //cashout route
    Route::get('/pembayaran', [PembayaranController::class, 'index'])->name('pembayaran');
    Route::post('/pembayaran/postpembayaran', [PembayaranController::class, 'postPembayaran'])->name('postPembayaran');
    Route::post('/pembayaran/postnote', [PembayaranController::class, 'postNote'])->name('postNote');

    Route::match(['get', 'post'], '/pembayaran/list', [PembayaranController::class, 'list_tagihan'])->name('pembayaran.list');
    Route::match(['get', 'post'], '/pembayaran/history', [PembayaranController::class, 'list_history'])->name('pembayaran.history');
    Route::match(['get', 'post'], '/pembayaran/postingan', [PembayaranController::class, 'list_postingan'])->name('postingan');

    Route::get('/pembayaran/{id}/add', [PembayaranController::class, 'addpembayaran'])->name('pembayaran.add');
    Route::get('/pembayaran/{id}/upload', [PembayaranController::class, 'uploadbukti'])->name('pembayaran.upload_bukti');
    Route::get('/pembayaran/{id}/detail', [PembayaranController::class, 'detailPembayaran'])->name('pembayaran.detail_bukti');

    Route::view('/offline', 'vendor.laravelpwa.offline')->name('offline');
});

