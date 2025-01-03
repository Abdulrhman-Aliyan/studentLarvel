<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Create subjects table
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('subject_name');
            $table->integer('pass_grade');
            $table->timestamps();
        });

        // Create user_subjects table
        Schema::create('user_subjects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('subject_id')->constrained('subjects')->onDelete('cascade');
            $table->integer('user_grade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_subjects');
        Schema::dropIfExists('subjects');
    }
};
