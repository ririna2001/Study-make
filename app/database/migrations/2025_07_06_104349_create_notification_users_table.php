<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('notification_users', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unique(); //ユーザーID
            $table->integer('instructor_id')->unique(); //講師ID
            $table->integer('admin_id')->unique(); //管理者ID
            $table->integer('notification_id')->unique(); //お知らせID
            $table->tinyInteger('is_read')->default(0); //既読機能
            $table->dateTime('read_at')->nullable(); //既読日時
            $table->softDeletes(); //deleted_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_users');
    }
};
