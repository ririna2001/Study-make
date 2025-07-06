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
        Schema::create('inquiries', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unique(); //ユーザーID
            $table->integer('instructor_id')->unique(); //講師ID
            $table->string('category','254')->unique(); //項目
            $table->string('content','500')->unique(); //本文
            $table->string('status','20'); //ステータス
            $table->integer('reply'); //返信
            $table->timestamps(); //created_atとupdated_at
            $table->softDeletes(); //deleted_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inquiries');
    }
};
