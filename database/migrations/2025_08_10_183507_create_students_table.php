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
        Schema::create('students', function (Blueprint $table) {
           $table->id();
            $table->string('full_name', 255);
            $table->string('nickname', 255)->nullable();
            $table->string('email', 255)->unique();
            $table->string('phone_number', 15)->unique()->lang;
            $table->string('admission_path', 255);
            $table->string('image')->nullable();
            $table->string('major_first_choice', 255);
            $table->string('major_second_choice', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
