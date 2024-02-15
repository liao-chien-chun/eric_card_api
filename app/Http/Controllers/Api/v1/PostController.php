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
    /**
     * @OA\Get(
     *     path="/api/v1/posts",
     *     summary="展示所有文章",
     *     tags={"Posts"},
     *     @OA\Response(
     *         response=200,
     *         description="操作成功",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="success",
     *                 type="boolean",
     *                 example=true
     *             ),
     *             @OA\Property(
     *                 property="status",
     *                 type="integer",
     *                 example=201
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="取得所有文章成功"
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Post")
     *             ),
     *         )
     *     )
     * )
     */
    // 展示所有文章，不用登入即可看到
    public function index()
    {
        $posts = Post::with(['user', 'category'])
                        ->withCount('comments')
                        ->withCount('likers')
                        ->get();

        // 排除資料
        $posts->each(function ($post) {
            if ($post->user) {
                $post->user->makeHidden(['description', 'email_verified_at', 'created_at', 'updated_at']);
            }
        });

        return response()->json([
            'success' => true,
            'status' => 200,
            'message' => '取得所有文章成功',
            'data' => $posts
        ], 200);
    }

/**
 * @OA\Get(
 *     path="/api/v1/posts/{post_id}",
 *     summary="取得單一文章內容",
 *     tags={"Posts"},
 *     @OA\Parameter(
 *         name="post_id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="操作成功",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                 property="success",
 *                 type="boolean",
 *                 example=true
 *             ),
 *             @OA\Property(
 *                 property="status",
 *                 type="integer",
 *                 example=200
 *             ),
 *             @OA\Property(
 *                 property="message",
 *                 type="string",
 *                 example="取得文章成功"
 *             ),
 *             @OA\Property(
 *                 property="data",
 *                 ref="#/components/schemas/Post"
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="文章未找到",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                 property="success",
 *                 type="boolean",
 *                 example=false
 *             ),
 *             @OA\Property(
 *                 property="status",
 *                 type="integer",
 *                 example=404
 *             ),
 *             @OA\Property(
 *                 property="message",
 *                 type="string",
 *                 example="找不到此文章"
 *             )
 *         )
 *     )
 * )
 */
    // 取得單一文章內容
    public function show($post_id)
    {
        $post = Post::with(['user', 'category'])
                    ->withCount('comments')
                    ->withCount('likers')                
                    ->find($post_id);

        // 如果不存在
        if (!$post) {
            return response()->json([
                'success' => false,
                'status' => 404,
                'message' => '找不到此文章',
            ], 404);
        }

        // 排除資料
        if ($post->user) {
            $post->user->makeHidden(['description', 'email_verified_at', 'created_at', 'updated_at']);
        }

        return response()->json([
            'success' => true,
            'status' => 200,
            'message' => '取得文章成功',
            'data' => $post
        ], 200);
    }


/**
 * @OA\Post(
 *     path="/api/v1/posts",
 *     summary="發布文章",
 *     tags={"Posts"},
 *     @OA\RequestBody(
 *         @OA\JsonContent(
 *             required={"title","content"},
 *             @OA\Property(property="title", type="string", example="範例標題"),
 *             @OA\Property(property="content", type="string", example="這是文章內容")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="文章發布成功",
 *         @OA\JsonContent(ref="#/components/schemas/Post")
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="請求參數錯誤"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="伺服器錯誤，請稍後再試"
 *     ),
 *     security={{ "apiAuth": {} }}
 * )
 */

    // 發布文章，已登入者才可發文
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:100',
            'content' => 'required',
            'category_id' => 'required'
        ], [
            'title.required' => '標題為必填',
            'title.max' => '標題最長為100個字',
            'content.required' => '文章內容為必填',
            'category_id.required' => '必須得選擇一個文章分類'
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
                'user_id' => $user_id,
                'category_id' => $request->category_id
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
