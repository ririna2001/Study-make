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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unique(); //ユーザーID
            $table->integer('instructor_id')->unique(); //講師ID
            $table->unsignedTinyInteger('age')->nullable(); //年齢
            $table->tinyInteger('gender')->default(0); //性別
            $table->string('occupation','254')->nullable(); //職業
            $table->integer('face_type_id')->unique()->nullable(); //顔タイプID
            $table->integer('personal_color_id')->unique()->nullable(); //パーソナルカラーID
            $table->timestamps(); //created_atとupdated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
