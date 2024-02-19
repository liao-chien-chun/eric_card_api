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

    /**
     * @OA\Post(
     *      path="/api/v1/posts/{post_id}/comments",
     *      summary="對文章留言",
     *      tags={"Posts"},
     *      @OA\Parameter(
     *          name="post_id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="留言成功",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean",
     *                  example=true
     *              ),
     *              @OA\Property(
    *                   property="status",
    *                   type="integer",
    *                   example=201
    *               ),
    *               @OA\Property(
    *                   property="message",
    *                   type="string",
    *                   example="留言成功"
    *               ),
    *               @OA\Property(
    *                   property="data",
    *                   ref="#/components/schemas/Comment"
    *               )
     *          )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="bad request",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
    *                   type="boolean",
    *                   example=false
     *              ),
     *              @OA\Property(
     *                  property="status",
    *                   type="integer",
    *                   example=400
     *              ),
     *              @OA\Property(
     *                  property="message",
    *                   type="string",
    *                   example="請求參數錯誤"
     *              ),
     *              @OA\Property(
     *                  property="errors",
    *                   type="object",
    *                   @OA\Property(
    *                       property="content",
    *                       type="array",
    *                       @OA\Items(
    *                           type="string",
    *                           example="留言內容不得為空"        
    *                       )
     *                  )
     *              ),
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="伺服器錯誤",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean",
     *                  example=false
     *              ),
     *              @OA\Property(
     *                  property="status",
     *                  type="integer",
     *                  example=500
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="伺服器錯誤，請稍後再試"
     *              ),
     *          )
     *      ),
     * 
     *      security={{ "bearerAuth": {} }}
     * )
     */


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

    // 修改留言
    public function update(Request $request, $post_id, $comment_id)
    {
        $validator = Validator::make($request->all(), [
            'content' => 'required'
        ], [
            'content.required' => '留言內容不得為空'
        ]);

        // 如果驗證錯誤
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'status' => 400,
                'message' => '請求參數錯誤',
                'errors' => $validator->errors()
            ], 400);
        }

        // 尋找該留言
        $comment = Comment::find($comment_id);
        // 判斷留言是否存在
        if (!$comment) {
            return response()->json([
                'success' => false,
                'status' => 404,
                'message' => '該留言不存在'
            ], 404);
        }

        // 檢查留言是否為當前登入使用者之留言
        if ($comment->user_id != auth()->user()->id) {
            return response()->json([
                'success' => false,
                'status' => 403,
                'message' => '沒有修改他人留言之權限'
            ], 403);
        }

        // 更新留言內容
        $comment->update([
            'content' => $request->content
        ]);

        return response()->json([
            'success' => true,
            'status' => 200,
            'message' => '更新留言成功',
            'data' => $comment,
        ], 200);
    }

    // 刪除留言
    public function destroy($post_id, $comment_id)
    {
        // 尋找該留言
        $comment = Comment::find($comment_id);

        if (!$comment) {
            return response()->json([
                'success' => false,
                'status' => 404,
                'message' => '該留言不存在'
            ], 404);
        }

        // 檢查是否為當前登入者之留言
        if ($comment->user_id != auth()->user()->id) {
            return response()->json([
                'success' => false,
                'status' => 403,
                'message' => '不得刪除他人留言'
            ], 403);
        }

        // 刪除留言
        $comment->delete();

        return response()->json([
            'success' => true,
            'status' => 200,
            'message' => '刪除留言成功',
        ], 200);
    }
}
