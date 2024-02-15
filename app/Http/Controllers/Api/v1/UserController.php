<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Exception;

class UserController extends Controller
{
    // 取得當前登入使用者收藏文章
    public function collectedPosts()
    {
        // 取得登入之使用者
        $user = \Auth::user();

        // 取該該使用者收藏之文章 id
        $collectedPostsId = $user->collectedPosts()->pluck('post_id');

        // 根據文章ID 取得文章
        $collectedPosts = Post::whereIn('id', $collectedPostsId)
                            ->with(['user:id,name', 'category:id,category_name'])
                            ->get();

        return response()->json([
            'success' => true,
            'status' => 200,
            'message' => '成功取得使用者收藏之文章',
            'data' => $collectedPosts
        ], 200);
    }

}
