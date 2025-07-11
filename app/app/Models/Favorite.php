<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'article_id',
    ];

    //ユーザー
     public function user(){
       return $this->belongsTo(User::class);
    }

    //記事
     public function articles(){
        return $this->belongsTo(Article::class);
    }
}
