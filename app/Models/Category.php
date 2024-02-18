<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

class Category extends Model
{
    use HasFactory;

    /**
     * @OA\Schema(
     *      schema="Category",
     *      type="object",
     *      title="Category",
     *      description="類別",
     *      @OA\Property(
    *           property="id",
    *           type="integer",
    *           format="int64",
    *           description="類別 ID"
    *       ),
    *       @OA\Property(
    *           property="category_name",
    *           type="string",
    *           description="文章類別名稱"
    *       ),
    *       @OA\Property(
    *           property="created_at",
    *           type="string",
    *           format="date-time",
    *           description="建立時間"
    *       ),
    *       @OA\Property(
    *           property="updated_at",
    *           type="string",
    *           format="date-time",
    *           description="最後修改時間"
    *       )
     * )
     * 
     */

    protected $table = 'categories';

    protected $fillable = [
        'category_name',
    ];

    // 自訂義時間格式
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s'); // 自定義時間格式
    }

    // 關聯文章
    public function posts()
    {
        return $this->hasMany(Post::class, 'category_id', 'id');
    }
}
