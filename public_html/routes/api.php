<?php

use App\Http\Controllers\TransactionInformationController;
use App\Http\Controllers\TransactionDetailController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BusinessCardController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

//Public Routes for User
Route::controller(AuthController::class)->group(function () {
    Route::prefix('user')->group(function () {
//        Route::post('sendOtp', 'sendOtp');
//        Route::post('getExistingOTPS', 'getExistingOTPS');
        Route::post('otpCodeDone', 'otpCodeDone');
        Route::post('googleLogin', 'googleLogin');
        Route::post('register', 'register');
        Route::post('login', 'login');
    });
});


// Protected Routes for User
Route::middleware(['auth:user'])->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::prefix('user')->group(function () {
            Route::post('logout', 'logout');
        });
    });
});


// Protected Routes for User
Route::middleware(['auth:user'])->group(function () {
    Route::controller(BusinessCardController::class)->group(function () {
        Route::prefix('user')->group(function () {
            Route::get('getBusinessCard', 'getBusinessCard');
            Route::post('updateBusinessCard', 'updateBusinessCard');
        });
    });
});

// Protected Routes for User
Route::middleware(['auth:user'])->group(function () {
    Route::controller(TransactionInformationController::class)->group(function () {
        Route::prefix('user')->group(function () {
            Route::get('getTransactionInformation', 'getTransactionInformation');
            Route::get('getUniqueCustomersName', 'getUniqueCustomersName');
            Route::post('takeMoney', 'takeMoney');
            Route::post('giveMoney', 'giveMoney');
            Route::post('updateTakeMoney', 'updateTakeMoney');
            Route::post('updateGiveMoney', 'updateGiveMoney');
            Route::get('getReportOfTransactionInformation', 'getReportOfTransactionInformation');
            Route::post('deleteSingleTransactionInformation', 'deleteSingleTransactionInformation');
        });
    });
});

// Protected Routes for User
Route::middleware(['auth:user'])->group(function () {
    Route::controller(TransactionDetailController::class)->group(function () {
        Route::prefix('user')->group(function () {
            Route::get('getTransactionDetails', 'getTransactionDetails');
        });
    });
});
