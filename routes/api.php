<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SteamMarketCsgoItemController;
use App\Http\Controllers\ShadowpaySoldItemController;
use App\Http\Controllers\SaleGuardItemController;
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

Route::middleware(['auth:sanctum'])->group(function() {
    Route::resource('steam-market-csgo-items', SteamMarketCsgoItemController::class);
    Route::resource('shadowpay-sold-items', ShadowpaySoldItemController::class);
    Route::resource('sale-guard-items', SaleGuardItemController::class);
    Route::resource('shadowpay-bot-presets', ShadowpayBotPresetController::class);
    Route::resource('shadowpay-bot-configs', ShadowpayBotConfigController::class);

    Route::get('/user', function(Request $request) {
        return response()->apiSuccess(['name' => $request->user()->name], 200);
    });
});