<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    // 發布文章，已登入者才可發文
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:100',
            'content' => 'required'
        ], [
            'title.required' => '標題為必填',
            'title.max' => '標題最長為100個字',
            'content.required' => '文章內容為必填'
        ]);

        // 如果有錯誤
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'status' => 400,
                'message' => '請求參數錯誤',
                'errors' => $validator->errors()
            ], 400);
        }

        try {
            $user_id = Auth::id();

            $post = Post::create([
                'title' => $request->title,
                'content' => $request->content,
                'user_id' => $user_id
            ]);

            return response()->json([
                'success' => true,
                'status' => 201,
                'message' => '文章發布成功',
                'data' => $post
            ], 201);
        } catch (Exception $e) {
            // 記錄錯誤到日誌
            \Log::error($e);

            return response()->json([
                'success' => false,
                'status' => 500,
                'message' => '伺服器錯誤，請稍後再試'
            ], 500);
        }
    }
}
