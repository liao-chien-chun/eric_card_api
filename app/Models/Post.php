<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

class Post extends Model
{
    use HasFactory;

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
