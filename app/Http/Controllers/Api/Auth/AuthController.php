<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    //  註冊
    public function register(Request $request)
    {
        // 驗證輸入之資料
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed'
        ], [
            // 自定義錯誤訊息
            'name.required' => '名字為必填',
            'name.max' => '名字最長為255個字',
            'email.required' => '電子郵件為必填',
            'email.email' => '請填寫有效的電子郵件格式',
            'email.max' => '電子郵件最長為255個字',
            'email.unique' => '此電子郵件已經被使用',
            'password.required' => '密碼為必填',
            'password.min' => '密碼最少要有8個字',
            'password.confirmed' => '密碼與確認密碼不符'
        ]);

        // 如果錯誤回傳錯誤訊息
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'status' => 400,
                'message' => '請求參數錯誤',
                'errors' => $validator->errors()
            ], 400);
        }

        // 驗證通過建立用戶
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // 成功後回傳
        return response()->json([
            'success' => true,
            'status' => 201,
            'message' => '使用者註冊成功',
            'data' => [
                'user' => $user
            ]
        ], 201);
    }

    // 登入
    public function login(Request $request)
    {
        // 驗證登入資料
        $credentials = $request->only('email', 'password');

        // 嘗試驗證並創建 token 
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'success' => false,
                    'status' => 400,
                    'message' => '電子郵件或密碼錯誤',
                ], 400);
            }   
        } catch (JWTException $e) {
            // 創建 token 遇到異常
            return response()->json([
                'success' => false,
                'status' => 500,
                'message' => '無法建立token',
            ], 500);
        }

        // 成功登入，回傳 token和使用者資訊
        return response()->json([
            'success' => true,
            'status' => 200,
            'message' => '登入成功',
            'data' => [
                'token' => $token,
                'user' => \Auth::user()->only(['id', 'name', 'email'])// 取得當前已認證之使用者資訊 
            ]
        ], 200); 
    }

    // 登出
    public function logout(Request $request)
    {
        try {
            // 使 token 失效
            JWTAuth::invalidate(JWTAuth::getToken());

            return response()->json([
                'success' => true,
                'status' => 200,
                'message' => '成功登出'
            ], 200);
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'status' => 500,
                'message' => '登出時發生錯誤'
            ], 500);
        }
    }
}
