<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;


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


// 註冊、登入、登出路由
Route::prefix('v1')->group(function () {
    Route::prefix('auth')->group(function () {
        // 註冊
        Route::post('/register', [AuthController::class, 'register']);
        // 登入
        Route::post('/login', [AuthController::class, 'login']);
    });

});


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
