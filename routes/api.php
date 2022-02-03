<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CoinsUserController;

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
Route::get('/teste', function (Request $request) {
    $teste = 'rafael';
    return $teste;
});

//Auth
Route::post('/auth/register', [AuthController:: class, 'register']);
Route::get('/auth/userinformation', [AuthController:: class, 'userInformation'])->middleware('auth:sanctum');
Route::post('/auth/login', [AuthController:: class, 'login']);
Route::post('/auth/logout', [AuthController:: class, 'logout'])->middleware('auth:sanctum');

//Coins
Route::get('coin/coinsuser', [CoinsUserController:: class, 'index'])->middleware('auth:sanctum');
Route::post('/store/coin', [CoinsUserController:: class, 'store'])->middleware('auth:sanctum');