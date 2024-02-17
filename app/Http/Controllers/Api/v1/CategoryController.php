<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/categories",
     *     summary="取得所有文章分類",
     *     tags={"Categories"},
     *     description="返回所有文章分类的列表",
     *     operationId="index",
     *     @OA\Response(
     *         response=200,
     *         description="取得所有分類成功",
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
     *                 example="取得所有分類成功"
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Category")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="內部伺服器錯誤"
     *     )
     * )
     */

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
