<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'instructor_id',
        'title',
        'content',
        'face_type_id',
        'personal_color_id',
    ];

    //ユーザー
    public function user(){
       return $this->belongsTo(User::class);
    }

    //講師
     public function instructor(){
        return $this->belongsTo(Instructor::class);
    }

    //お気に入り
     public function favorites(){
        return $this->hasMany(Favorite::class);
    }

     //顔タイプ
     public function facetypes(){
        return $this->belongsTo(FaceType::class);
    }

    //パーソナルカラー
     public function personalcolors(){
        return $this->belongsTo(PersonalColor::class);
    }

}
