<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

class Post extends Model
{
    use HasFactory;

    /**
     * @OA\Schema(
     *   schema="Post",
     *   type="object",
     *   title="Post",
     *   required={"title", "content"},
     *   @OA\Property(property="id", type="integer", format="int64", description="Post ID"),
     *   @OA\Property(property="title", type="string", description="Post title"),
     *   @OA\Property(property="content", type="string", description="Post content"),
     *   @OA\Property(property="user_id", type="integer", description="User ID"),
     * )
     */

    protected $table = 'posts';

    protected $fillable = [
        'title',
        'content',
        'user_id',
        'category_id'
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s'); // 自定義時間格式
    }

    // 關聯使用者
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // 關聯分類
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
