<?php

namespace App\Swagger;

    /**
    * @OA\Schema(
    *   schema="Post",
    *   type="object",
    *   title="Post",
    *   required={"title", "content"},
    *   @OA\Property(property="id", type="integer", format="int64", description="文章 ID"),
    *   @OA\Property(property="title", type="string", description="文章標題"),
    *   @OA\Property(property="content", type="string", description="文章內容"),
    *   @OA\Property(property="user_id", type="integer", description="關聯之使用者 ID"),
    *    @OA\Property(property="category_id", type="integer", description="關聯之分類 ID"),
    *      @OA\Property(
    *          property="created_at",
    *          type="string",
    *          format="date-time",
    *          description="建立時間"
    *      ),
    *      @OA\Property(
    *          property="updated_at",
    *          type="string",
    *          format="date-time",
    *          description="最後修改時間"
    *      ),
    * ),
    * 
    * 
    */


class PostsSchema
{

}