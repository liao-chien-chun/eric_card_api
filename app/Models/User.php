<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use DateTimeInterface;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * @OA\Schema(
     *   schema="User",
     *   type="object",
     *   title="User",
     *   @OA\Property(property="id", type="integer", format="int64", description="User ID"),
     *   @OA\Property(property="name", type="string", description="User name"),
     *   @OA\Property(property="email", type="string", description="User email"),
     *   // 省略了其他屬性...
     * )
     */

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'description',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
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

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
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
}
