<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\v1\PostController;
use App\Http\Controllers\Api\v1\CategoryController;
use App\Http\Controllers\Api\v1\CommentController;


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
    // Auth 相關路由
    Route::prefix('auth')->group(function () {
        // 註冊
        Route::post('/register', [AuthController::class, 'register']);
        // 登入
        Route::post('/login', [AuthController::class, 'login']);
    });

    // 需要經過驗證的路由
    Route::middleware('auth:api')->group(function () {
        // 已登錄者才能發布文章
        Route::post('/posts', [PostController::class, 'store']);

        // 特定文章下留言
        Route::post('/posts/{post_id}/comments', [CommentController::class, 'store']);

    });

    // 公開路由
    Route::prefix('posts')->group(function () {
        Route::get('/', [PostController::class, 'index']);
        Route::get('/{post_id}', [PostController::class, 'show']);
    });

    // 取得所有分類
    Route::get('/categories', [CategoryController::class, 'index']);
});


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
