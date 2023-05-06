<?php

use App\Http\Controllers\Web\SummaryItemController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [SummaryItemController::class, 'index']);

Route::get('{hash_name}', [SummaryItemController::class, 'show']);
