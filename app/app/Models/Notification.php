<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;


    protected $fillable = [
        'title',
        'body',
    ];

     //通知ユーザー
     public function notification_users(){
        return $this->hasMany(NotificationUser::class);
    }

}
