<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use DateTimeInterface;


/**
 * @OA\Schema(
 *     schema="User",
 *     type="object",
 *     title="User",
 *     description="使用者",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="使用者 ID"
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="使用者名稱"
 *     ),
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         description="使用者電子郵件"
 *     ),
 * )
 */


class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;


    protected $fillable = [
        'name',
        'email',
        'description',
        'password',
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];

    // 自訂義時間
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s'); // 自定義時間格式
    }

    // JWT 相關
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // 關聯文章
    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id', 'id');
    }

    // 關聯留言
    public function comments()
    {
        return $this->hasMany(Comment::class, 'user_id', 'id');
    }

    // 關聯使用者收藏文章
    public function collectedPosts()
    {
        return $this->belongsToMany(Post::class, 'collections', 'user_id', 'post_id')->withTimestamps();
    }

    // 關聯喜歡之文章
    public function likedPosts()
    {
        return $this->belongsToMany(Post::class, 'likes', 'user_id', 'post_id')->withTimestamps();
    }
}
