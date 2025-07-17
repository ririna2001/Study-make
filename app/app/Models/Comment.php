<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'instructor_id',
        'article_id',
        'content',
        'reply',
    ];

    //ユーザー
     public function user(){
       return $this->belongsTo(User::class);
    }

    //講師
     public function instructor(){
        return $this->belongsTo(Instructor::class);
    }

    public function parent(){
        return $this->belongsTo(Comment::class, 'reply');
    }

    public function replies(){
        return $this->hasMany(Comment::class, 'reply');
    }

}
