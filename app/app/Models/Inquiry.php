<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'instructor_id',
        'category',
        'content',
        'status',
        'reply',
        'keyword',
        'date',
        'title',
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
        return $this->belongsTo(Inquiry::class, 'parent_id');
    }

     public function replies(){
        return $this->hasMany(Inquiry::class, 'parent_id');
    }
}
