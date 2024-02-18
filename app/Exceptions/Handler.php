<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    // 自訂 401 錯誤處理
    public function render($request, Throwable $e)
    {
        // 檢查是否為未認證錯誤
        if ($e instanceof AuthenticationException) {
            // 確認是否為 API 請求，並返回自訂義未認證錯誤訊息
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'status' => 401,
                    'message' => "未經授權"
                ], 401);
            }
        }

        return parent::render($request, $e);
    }
}
