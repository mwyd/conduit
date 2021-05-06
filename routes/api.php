<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SteamMarketCsgoItemController;
use App\Http\Controllers\ShadowpaySoldItemController;
use App\Http\Controllers\ShadowpaySaleGuardItemController;
use App\Http\Controllers\ShadowpayBotPresetController;
use App\Http\Controllers\ShadowpayBotConfigController;

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

// public routes
Route::get('/steam-market-csgo-items', [SteamMarketCsgoItemController::class, 'index']);
Route::get('/steam-market-csgo-items/{hashName}', [SteamMarketCsgoItemController::class, 'show']);

Route::get('/shadowpay-sold-items', [ShadowpaySoldItemController::class, 'index']);
Route::get('/shadowpay-sold-items/{transactionId}', [ShadowpaySoldItemController::class, 'show']);

// protected routes
Route::middleware(['auth:sanctum'])->group(function() {
    Route::resource('shadowpay-sale-guard-items', ShadowpaySaleGuardItemController::class);
    Route::resource('shadowpay-bot-presets', ShadowpayBotPresetController::class);
    Route::resource('shadowpay-bot-configs', ShadowpayBotConfigController::class);

    Route::post('/steam-market-csgo-items', [SteamMarketCsgoItemController::class, 'store']);
    Route::put('/steam-market-csgo-items/{hashName}', [SteamMarketCsgoItemController::class, 'update']);
    Route::delete('/steam-market-csgo-items/{hashName}', [SteamMarketCsgoItemController::class, 'destroy']);

    Route::post('/shadowpay-sold-items', [ShadowpaySoldItemController::class, 'store']);
    Route::put('/shadowpay-sold-items/{transactionId}', [ShadowpaySoldItemController::class, 'update']);
    Route::delete('/shadowpay-sold-items/{transactionId}', [ShadowpaySoldItemController::class, 'destroy']);

    Route::get('/user', function(Request $request) {
        return response()->apiSuccess(['name' => $request->user()->name], 200);
    });
});