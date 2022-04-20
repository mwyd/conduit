<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\SteamMarketCsgoItemController;
use App\Http\Controllers\Api\V1\ShadowpaySoldItemController;
use App\Http\Controllers\Api\V1\ShadowpaySaleGuardItemController;
use App\Http\Controllers\Api\V1\ShadowpayBotPresetController;
use App\Http\Controllers\Api\V1\ShadowpayBotConfigController;
use App\Http\Controllers\Api\V1\ShadowpayFriendController;
use App\Http\Controllers\Api\V1\CsgoRarePaintSeedItemController;
use App\Http\Controllers\Api\V1\BuffMarketCsgoItemController;

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

Route::prefix('v1')->group(function() {
    Route::controller(SteamMarketCsgoItemController::class)->prefix('steam-market-csgo-items')->group(function() {
        Route::get('/', 'index');
        Route::get('/{hashName}', 'show');
        Route::post('/', 'store')->middleware('auth:sanctum');
        Route::put('/{hashName}', 'update')->middleware('auth:sanctum');
        Route::delete('/{hashName}', 'destroy')->middleware('auth:sanctum');
    });

    Route::controller(ShadowpaySoldItemController::class)->prefix('shadowpay-sold-items')->group(function() {
        Route::get('/', 'index');
        Route::get('/{hashName}', 'show');
        Route::get('/{hashName}/trend', 'showTrend');
        Route::post('/', 'store')->middleware('auth:sanctum');
        Route::put('/{transactionId}', 'update')->middleware('auth:sanctum');
        Route::delete('/{transactionId}', 'destroy')->middleware('auth:sanctum');
    });

    Route::controller(BuffMarketCsgoItemController::class)->prefix('buff-market-csgo-items')->group(function() {
        Route::get('/', 'index');
        Route::get('/{hashName}', 'show');
        Route::post('/', 'store')->middleware('auth:sanctum');
        Route::put('/{hashName}', 'update')->middleware('auth:sanctum');
        Route::delete('/{hashName}', 'destroy')->middleware('auth:sanctum');
    });
    
    Route::middleware('auth:sanctum')->group(function() {
        Route::apiResource('shadowpay-sale-guard-items', ShadowpaySaleGuardItemController::class);
        Route::apiResource('shadowpay-bot-presets', ShadowpayBotPresetController::class);
        Route::apiResource('shadowpay-bot-configs', ShadowpayBotConfigController::class);
        Route::apiResource('shadowpay-friends', ShadowpayFriendController::class);
        Route::apiResource('csgo-rare-paint-seed-items', CsgoRarePaintSeedItemController::class);

        Route::get('/user', function(Request $request) {
            return response()->apiSuccess($request->user(), 200);
        });
    });
});