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
use App\Http\Controllers\WarungkuController;
use App\Http\Controllers\WarungkuSetupController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Pengurus\SellerController;
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

Route::get('/', [LoginController::class, 'showLoginForm'])
    ->middleware('check.token')
    ->name('showLoginForm');

Route::get('/company-profile', [LoginController::class, 'companyProfile'])->name('companyProfile');

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

// PWA Offline Page
Route::get('/offline', function () {
    return view('offline');
})->name('offline');

// Warungku Setup Routes (Admin - Public)
Route::get('/warungku/setup', [WarungkuSetupController::class, 'setup'])->name('warungku.setup');
Route::get('/warungku/update-images', [WarungkuSetupController::class, 'updateImages'])->name('warungku.update-images');
Route::get('/warungku/setup-cart', [WarungkuSetupController::class, 'setupCart'])->name('warungku.setup-cart');

// Voting Routes (Public - No Auth Required)
Route::get('/pemilu-tc', [\App\Http\Controllers\VotingController::class, 'index'])->name('voting.index');
Route::post('/pemilu-tc/vote', [\App\Http\Controllers\VotingController::class, 'store'])->name('voting.store');
Route::get('/pemilu-tc/results', [\App\Http\Controllers\VotingController::class, 'results'])->name('voting.results');

Auth::routes();

// Rute yang membutuhkan autentikasi
Route::group(['middleware' => ['auth', 'check.token']], function () {
   
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
        
        //report download routes
        Route::get('/pengurus/report/download/comprehensive', [ReportController::class, 'downloadComprehensive'])->name('pengurus.report.download.comprehensive');
        //end report route
        
        // Seller Request Management Routes (Pengurus Only)
        Route::prefix('pengurus/seller-requests')->name('pengurus.seller-requests.')->group(function () {
            Route::get('/', [App\Http\Controllers\Pengurus\SellerRequestController::class, 'index'])->name('index');
            Route::get('/{id}', [App\Http\Controllers\Pengurus\SellerRequestController::class, 'show'])->name('show');
            Route::post('/{id}/approve', [App\Http\Controllers\Pengurus\SellerRequestController::class, 'approve'])->name('approve');
            Route::post('/{id}/reject', [App\Http\Controllers\Pengurus\SellerRequestController::class, 'reject'])->name('reject');
        });
    });
    
    // Seller Registration Routes (Open to all authenticated users - NO role required)
    Route::get('/pengurus/seller/register', [SellerController::class, 'showRegisterForm'])->name('pengurus.seller.register');
    Route::post('/pengurus/seller/register', [SellerController::class, 'processRegistration'])->name('pengurus.seller.register.process');
    Route::get('/pengurus/seller/request-status', [SellerController::class, 'requestStatus'])->name('pengurus.seller.request.status');
    
    // Warungku Seller Routes (Protected by is_seller check in controller - NO pengurus role required)
    Route::prefix('pengurus/seller')->name('pengurus.seller.')->group(function () {
        Route::get('/dashboard', [SellerController::class, 'dashboard'])->name('dashboard');
        
        // Store Management
        Route::get('/my-stores', [SellerController::class, 'myStores'])->name('my-stores');
        Route::get('/browse-stores', [SellerController::class, 'browseStores'])->name('browse-stores');
        Route::post('/claim/{store}', [SellerController::class, 'claimStore'])->name('claim-store');
        Route::post('/leave/{store}', [SellerController::class, 'leaveStore'])->name('leave-store');
        
        // Product Management
        Route::get('/{store}/products', [SellerController::class, 'products'])->name('products');
        Route::get('/{store}/products/create', [SellerController::class, 'createProduct'])->name('products.create');
        Route::post('/{store}/products', [SellerController::class, 'storeProduct'])->name('products.store');
        Route::get('/{store}/products/{product}/edit', [SellerController::class, 'editProduct'])->name('products.edit');
        Route::put('/{store}/products/{product}', [SellerController::class, 'updateProduct'])->name('products.update');
        Route::delete('/{store}/products/{product}', [SellerController::class, 'deleteProduct'])->name('products.delete');
        Route::post('/{store}/products/{product}/stock', [SellerController::class, 'updateStock'])->name('products.update-stock');
        
        // Order Management
        Route::get('/{store}/orders', [SellerController::class, 'orders'])->name('orders');
        Route::get('/{store}/orders/{order}', [SellerController::class, 'orderDetail'])->name('orders.detail');
        Route::post('/{store}/orders/{order}/status', [SellerController::class, 'updateOrderStatus'])->name('orders.update-status');
        
        // Reports & Analytics
        Route::get('/{store}/reports', [SellerController::class, 'reports'])->name('reports');
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
    Route::get('/pembayaran/{id}/qris', [PembayaranController::class, 'qrisPembayaran'])->name('pembayaran.qris');
    Route::get('/api/check-payment/{paymentId}', [PembayaranController::class, 'checkPaymentStatus'])->name('pembayaran.check_status');

    // Route::get('/pembayaran/pembayaran_periode', [PembayaranController::class, 'pembayaran_periode'])->name('pembayaran.pembayaran_periode');
    // Route::get('/pembayaran/periode', [PembayaranController::class, 'periode'])->name('pembayaran.periode');

    // Cart Routes (Protected - Requires Login)
    Route::get('/warungku/keranjang', [CartController::class, 'index'])->name('cart.index');
    Route::post('/warungku/keranjang/add', [CartController::class, 'add'])->name('cart.add');
    Route::put('/warungku/keranjang/update/{itemId}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/warungku/keranjang/remove/{itemId}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/warungku/keranjang/clear', [CartController::class, 'clear'])->name('cart.clear');
    Route::get('/warungku/keranjang/count', [CartController::class, 'getCount'])->name('cart.count');
});

// Warungku Marketplace Routes (Public - No Auth Required)
Route::get('/warungku', [WarungkuController::class, 'index'])->name('warungku.index');
Route::get('/warungku/toko/{id}', [WarungkuController::class, 'showStore'])->name('warungku.store');
Route::get('/warungku/produk/{id}', [WarungkuController::class, 'showProduct'])->name('warungku.product');

use App\Http\Controllers\Test\RegistrationTestController;

Route::prefix('test/registration')->group(function () {
    Route::get('/', [RegistrationTestController::class, 'index'])->name('test.registration');
    Route::prefix('api')->group(function () {
        Route::get('/master-data', [RegistrationTestController::class, 'getMasterData'])->name('test.registration.master');
        Route::get('/master-data/all', [RegistrationTestController::class, 'getAllMasterData'])->name('test.registration.master.all');
        Route::get('/residence', [RegistrationTestController::class, 'getResidenceByCode'])->name('test.registration.residence');
        Route::get('/units', [RegistrationTestController::class, 'getUnitsByCode'])->name('test.registration.units');
        Route::post('/registration', [RegistrationTestController::class, 'testRegistration'])->name('test.registration.submit');
        Route::post('/login', [RegistrationTestController::class, 'testLogin'])->name('test.registration.login');
        Route::post('/verify', [RegistrationTestController::class, 'testVerify'])->name('test.registration.verify');
        Route::post('/resend-verification', [RegistrationTestController::class, 'testResendVerification'])->name('test.registration.resend');
    });
});

// Debug route untuk check session data
Route::get('/debug/session', function () {
    if (!Session::get('token')) {
        return response()->json(['error' => 'Not logged in']);
    }
    
    return response()->json([
        'user' => Session::get('cred'),
        'warga' => Session::get('warga'),
        'residence' => Session::get('residence'),
        'token_exists' => Session::has('token')
    ]);
})->name('debug.session');

