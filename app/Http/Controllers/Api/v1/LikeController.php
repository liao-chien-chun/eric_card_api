<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Like;
use App\Models\Post;

class LikeController extends Controller
{
    // 按愛心/取消愛心
    public function toggleLike($post_id)
    {
        // 取得當前登入使用者
        $user = \Auth::user();
        $post = Post::find($post_id);

        if (!$post) {
            return response()->json([
                'success' => false,
                'status' => 404,
                'message' => '文章不存在'
            ], 404);
        }

        $isLiked = $user->likedPosts()->where('post_id', $post_id)->exists();

        if ($isLiked) {
            // 代表按愛心則取消
            $user->likedPosts()->detach($post_id);
            return response()->json([
                'success' => true,
                'status' => 200,
                'message' => '愛心取消成功'
            ], 200);
        } else {
            // 尚未按愛心則按愛心
            $user->likedPosts()->attach($post_id);
            return response()->json([
                'success' => true,
                'status' => 200,
                'message' => '按愛心成功'
            ], 200);
        }

    }
}
