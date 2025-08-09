<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'instructor_id',
        'title',
        'content',
        'face_type_id',
        'personal_color_id',
    ];

    //講師
     public function instructor(){
        return $this->belongsTo(Instructor::class);
    }

    //お気に入り
     public function favoritedBy(){
        return $this->belongsToMany(User::class, 'favorites', 'article_id', 'user_id')->withTimestamps();
    }

     //顔タイプ
     public function facetypes(){
        return $this->belongsTo(FaceType::class);
    }

    //パーソナルカラー
     public function personalcolors(){
        return $this->belongsTo(PersonalColor::class);
    }

    //コメント
     public function comments(){
        return $this->hasMany(Comment::class);
    }

}
