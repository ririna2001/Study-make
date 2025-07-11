<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaceType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    //記事
     public function articles(){
        return $this->hasMany(Article::class);
    }

    //プロフィール
    public function profile(){
        return $this->hasMany(Profile::class);
    }
}
