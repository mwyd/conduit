<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\SteamMarketCsgoItemController;
use App\Http\Controllers\Api\V1\ShadowpaySoldItemController;
use App\Http\Controllers\Api\V1\ShadowpaySaleGuardItemController;
use App\Http\Controllers\Api\V1\ShadowpayBotPresetController;
use App\Http\Controllers\Api\V1\ShadowpayBotConfigController;
use App\Http\Controllers\Api\V1\ShadowpayFriendController;
use App\Http\Controllers\Api\V1\CsgoBlueGemItemController;

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

Route::prefix('v1')->group(function () {
    // public routes
    Route::get('/steam-market-csgo-items', [SteamMarketCsgoItemController::class, 'index']);
    Route::get('/steam-market-csgo-items/{hashName}', [SteamMarketCsgoItemController::class, 'show']);

    Route::get('/shadowpay-sold-items', [ShadowpaySoldItemController::class, 'index']);
    Route::get('/shadowpay-sold-items/{transactionId}', [ShadowpaySoldItemController::class, 'show']);
    Route::get('/shadowpay-sold-items/{hashName}/trend', [ShadowpaySoldItemController::class, 'showTrend']);

    // protected routes
    Route::middleware(['auth:sanctum'])->group(function() {
        Route::apiResource('shadowpay-sale-guard-items', ShadowpaySaleGuardItemController::class);
        Route::apiResource('shadowpay-bot-presets', ShadowpayBotPresetController::class);
        Route::apiResource('shadowpay-bot-configs', ShadowpayBotConfigController::class);
        Route::apiResource('shadowpay-friends', ShadowpayFriendController::class);
        Route::apiResource('csgo-blue-gem-items', CsgoBlueGemItemController::class);

        Route::post('/steam-market-csgo-items', [SteamMarketCsgoItemController::class, 'store']);
        Route::put('/steam-market-csgo-items/{hashName}', [SteamMarketCsgoItemController::class, 'update']);
        Route::delete('/steam-market-csgo-items/{hashName}', [SteamMarketCsgoItemController::class, 'destroy']);

        Route::post('/shadowpay-sold-items', [ShadowpaySoldItemController::class, 'store']);
        Route::put('/shadowpay-sold-items/{transactionId}', [ShadowpaySoldItemController::class, 'update']);
        Route::delete('/shadowpay-sold-items/{transactionId}', [ShadowpaySoldItemController::class, 'destroy']);

        Route::get('/user', function(Request $request) {
            return response()->apiSuccess($request->user(), 200);
        });
    });
});