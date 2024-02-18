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
     *   @OA\Property(property="id", type="integer", format="int64", description="文章 ID"),
     *   @OA\Property(property="title", type="string", description="文章標題"),
     *   @OA\Property(property="content", type="string", description="文章內容"),
     *   @OA\Property(property="user_id", type="integer", description="關聯之使用者 ID"),
     *    @OA\Property(
     *          property="created_at",
     *          type="string",
     *          format="date-time",
     *          description="建立時間"
     *      ),
     *      @OA\Property(
     *          property="updated_at",
     *          type="string",
     *          format="data-time",
     *          description="最後修改時間"
     *      ),
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

    // 關聯留言
    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id', 'id');
    }

    // 關聯收藏
    public function collectors()
    {
        return $this->belongsToMany(User::class, 'collections', 'post_id', 'user_id')->withTimestamps();
    }

    // 文章關聯按愛心
    public function likers()
    {
        return $this->belongsToMany(User::class, 'likes', 'post_id', 'user_id')->withTimestamps();
    }

}
