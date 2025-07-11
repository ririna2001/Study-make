<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PHPUnit\Metadata\AnnotationsAreNotSupportedForInternalClassesException;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'instructor_id',
        'age',
        'gender',
        'occupation',
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

     //顔タイプ
     public function facetypes(){
        return $this->belongsTo(FaceType::class);
    }

    //パーソナルカラー
     public function personalcolors(){
        return $this->belongsTo(PersonalColor::class);
    }

}
