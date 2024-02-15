<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Collection;
use Illuminate\Support\Facades\Auth;

class CollectionController extends Controller
{
    // 收藏/取消收藏
    public function toggleCollection(Request $request, $post_id)
    {
        $user = auth()->user();

        // 判斷是否有收藏過
        $isCollected = $user->collectedPosts()->where('post_id', $post_id)->exists();

        if ($isCollected) {
            // 已收藏則取消
            $user->collectedPosts()->detach($post_id);
            return response()->json([
                'success' => true,
                'status' => 200,
                'message' => '取消收藏成功'
            ], 200);
        } else {
            // 尚未收藏則收藏
            $user->collectedPosts()->attach($post_id);
            return response()->json([
                'success' => true,
                'status' => 200,
                'message' => '收藏成功'
            ], 200);
        }
    }
}
