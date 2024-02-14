<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;



class CommentController extends Controller
{
    // 取得文章留言
    public function index($post_id)
    {
        $comments = Comment::with('user')
                            ->where('post_id', $post_id)
                            ->get();

        // 排除
        $comments->each(function ($comment) {
            if ($comment->user) {
                $comment->user->makeHidden(['description', 'email_verified_at', 'created_at', 'updated_at']);
            }
        });

        return response()->json([
            'success' => true,
            'status' => 200,
            'message' => '取得文章留言成功',
            'data' => $comments
        ], 200);
    }

    // 新增留言
    public function store(Request $request, $post_id)
    {
        $validator = Validator::make($request->all(), [
            'content' => 'required',
        ], [
            'content.required' => '留言內容不得為空'
        ]);

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

            $comment = Comment::create([
                'content' => $request->content,
                'user_id' => $user_id,
                'post_id' => $post_id
            ]);

            return response()->json([
                'success' => true,
                'status' => 201,
                'message' => '留言新增成功',
                'data' => $comment
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
