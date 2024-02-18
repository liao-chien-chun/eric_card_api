<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

class Comment extends Model
{
    use HasFactory;

    /**
     * @OA\Schema(
     *      schema="Comment",
     *      type="object",
     *      title="Comment",
     *       description="文章留言",
     *      @OA\Property(
     *          property="id",
     *          type="integer",
     *          format="int64",
     *          description="Comment ID"
     *      ),
     *      @OA\Property(
     *          property="content",
     *          type="string",
     *          description="留言內容"
     *      ),
     *      @OA\Property(
     *          property="user_id",
     *          type="integer",
     *          format="int64",
     *          description="留言者的 ID"
     *      ),
     *      @OA\Property(
     *          property="post_id",
     *          type="integer",
     *          format="int64",
     *          description="該留言屬於的文章 ID"
     *      ),
     *      @OA\Property(
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

    protected $table = 'comments';

    protected $fillable = [
        'content',
        'user_id',
        'post_id'
    ];

    // 自訂義時間
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s'); // 自定義時間格式
    }

    // 關聯使用者
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // 關聯文章
    public function post()
    {
        return $this->belongsTo(User::class, 'post_id', 'id');
    }
}
