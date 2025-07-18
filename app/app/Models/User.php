<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
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

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    //プロフィール
    public function profile(){
        return $this->hasOne(Profile::class);
    }

    //記事
     public function articles(){
        return $this->hasMany(Article::class);
    }

    //日記
     public function diaries(){
        return $this->hasMany(Diary::class);
    }

    //コメント
    public function comments(){
        return $this->hasMany(Comment::class);
    }

    //問い合わせ
     public function inquiries(){
        return $this->hasMany(Inquiry::class);
    }

     //お気に入り
     public function favorites(){
        return $this->hasMany(Favorite::class);
    }

    //通知ユーザー
     public function notification_users(){
        return $this->hasMany(NotificationUser::class);
    }

    //通知


}
