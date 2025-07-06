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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unique(); //ユーザーID
            $table->integer('instructor_id')->unique(); //講師ID
            $table->string('title','254')->unique(); //タイトル
            $table->string('content','500')->unique(); //本文
            $table->integer('face_type_id')->nullable(); //顔タイプID
            $table->integer('personal_color_id')->nullable(); //パーソナルカラーID
            $table->timestamps(); //created_atとupdated_at
            $table->softDeletes(); //deleted_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
