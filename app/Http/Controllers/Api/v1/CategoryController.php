<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    // 取得所有文章分類
    public function index()
    {
        $categories = Category::all();

        return response()->json([
            'success' => true,
            'status' => 200,
            'message' => '取得所有分類成功',
            'data' => $categories
        ], 200);
    }
}
