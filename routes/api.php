<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Payment\PaymentController;
use App\Http\Controllers\Payment\WebhookController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('payments')->middleware('throttle:10,1')->group(function () {
    Route::post('/', [PaymentController::class, 'create']);
    Route::get('/{id}', [PaymentController::class, 'show']);
});

Route::post('/webhooks/qris', [WebhookController::class, 'handleQrisWebhook']);
