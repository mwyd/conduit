<?php

use App\Http\Controllers\Api\V1\BuffMarketCsgoItemController;
use App\Http\Controllers\Api\V1\CsgoRarePaintSeedItemController;
use App\Http\Controllers\Api\V1\ShadowpayBotConfigController;
use App\Http\Controllers\Api\V1\ShadowpayBotPresetController;
use App\Http\Controllers\Api\V1\ShadowpayFriendController;
use App\Http\Controllers\Api\V1\ShadowpaySaleGuardItemController;
use App\Http\Controllers\Api\V1\ShadowpaySoldItemController;
use App\Http\Controllers\Api\V1\SteamMarketCsgoItemController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
    Route::controller(SteamMarketCsgoItemController::class)->prefix('steam-market-csgo-items')->group(function () {
        Route::get('/', 'index');
        Route::get('/{item}', 'show');
        Route::post('/', 'store')->middleware('auth:sanctum');
        Route::put('/{item}', 'update')->middleware('auth:sanctum');
        Route::delete('/{item}', 'destroy')->middleware('auth:sanctum');
    });

    Route::controller(ShadowpaySoldItemController::class)->prefix('shadowpay-sold-items')->group(function () {
        Route::get('/', 'index');
        Route::get('/{item}', 'show');
        Route::post('/', 'store')->middleware('auth:sanctum');
        Route::put('/{item}', 'update')->middleware('auth:sanctum');
        Route::delete('/{item}', 'destroy')->middleware('auth:sanctum');
    });

    Route::controller(BuffMarketCsgoItemController::class)->prefix('buff-market-csgo-items')->group(function () {
        Route::get('/', 'index');
        Route::get('/{item}', 'show');
        Route::post('/', 'store')->middleware('auth:sanctum');
        Route::put('/{item}', 'update')->middleware('auth:sanctum');
        Route::delete('/{item}', 'destroy')->middleware('auth:sanctum');
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::apiResource('shadowpay-sale-guard-items', ShadowpaySaleGuardItemController::class, [
            'parameters' => ['shadowpay-sale-guard-items' => 'item'],
        ]);

        Route::apiResource('shadowpay-bot-presets', ShadowpayBotPresetController::class, [
            'parameters' => ['shadowpay-bot-presets' => 'preset'],
        ]);

        Route::apiResource('shadowpay-bot-configs', ShadowpayBotConfigController::class, [
            'parameters' => ['shadowpay-bot-configs' => 'config'],
        ]);

        Route::apiResource('shadowpay-friends', ShadowpayFriendController::class, [
            'parameters' => ['shadowpay-friends' => 'friend'],
        ]);

        Route::apiResource('csgo-rare-paint-seed-items', CsgoRarePaintSeedItemController::class, [
            'parameters' => ['csgo-rare-paint-seed-items' => 'item'],
        ]);

        Route::get('/user', function (Request $request) {
            return response()->apiSuccess($request->user(), 200);
        });
    });
});
