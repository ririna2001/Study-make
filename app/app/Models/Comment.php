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
        'nickname',
        'parent_id',
    ];

    //ユーザー
     public function user(){
       return $this->belongsTo(User::class);
    }

    //講師
     public function instructor(){
        return $this->belongsTo(Instructor::class);
    }

     public function scopeParentComment($query){
        return $query->whereNull('parent_id');
    }


    public function parent(){
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function replies(){
        return $this->hasMany(Comment::class, 'parent_id');
    }

    public function article(){
    return $this->belongsTo(Article::class);
    }

}
