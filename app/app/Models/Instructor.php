<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'image_path',
    ];

    //プロフィール
    public function profile(){
        return $this->hasOne(Profile::class);
    }

    //記事
     public function articles(){
        return $this->hasMany(Article::class);
    }

     //コメント
    public function comments(){
        return $this->hasMany(Comment::class);
    }

     //問い合わせ
     public function inquiries(){
        return $this->hasMany(Inquiry::class);
    }

    //通知ユーザー
     public function notification_users(){
        return $this->hasMany(NotificationUser::class);
    }
}
