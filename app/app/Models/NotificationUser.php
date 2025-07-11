<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'instructor_id',
        'admin_id',
        'notification_id',
    ];

       //ユーザー
     public function user(){
       return $this->belongsTo(User::class);
    }

    //講師
     public function instructor(){
        return $this->belongsTo(Instructor::class);
    }

    //管理人
     public function admins(){
        return $this->belongsTo(Admin::class);
    }

     //通知
     public function notifications(){
        return $this->belongsTo(Notification::class);
    }


}
