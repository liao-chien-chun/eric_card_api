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
     *      description="類別 model",
     *      @OA\Property(
    *           property="id",
    *           type="integer",
    *           format="int64",
    *           description="Category ID"
    *       ),
    *       @OA\Property(
    *           property="category_name",
    *           type="string",
    *           description="Category name"
    *       ),
    *       @OA\Property(
    *           property="created_at",
    *           type="string",
    *           format="date-time",
    *           description="Creation date"
    *       ),
    *       @OA\Property(
    *           property="updated_at",
    *           type="string",
    *           format="date-time",
    *           description="Last update date"
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
