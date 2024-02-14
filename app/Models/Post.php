<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $table = 'posts';

    protected $fillable = [
        'title',
        'content',
        'user_id'
    ];

    // 關聯使用者
    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }
}
