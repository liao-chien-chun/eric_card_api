<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

class Comment extends Model
{
    use HasFactory;

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
