<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PushNotificationController;

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

Route::as('NotificationDto Service')->group(function () {
    Route::prefix('/notification')
        ->as('notification')
        ->group(function () {
            Route::post('/', [PushNotificationController::class, 'push'])->name('push');
        });
});


