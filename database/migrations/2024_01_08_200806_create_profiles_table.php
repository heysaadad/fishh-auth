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
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->enum('gender', ['male', 'female', 'other'])->default('other');
            $table->integer('age');
            $table->string('about')->nullable();
            $table->string('job_title')->nullable();
            $table->string('job_place')->nullable();
            $table->string('school_name')->nullable();
            $table->integer('grad_year')->nullable();
            $table->string('custom_username')->nullable();
            $table->string('current_city')->nullable();
            $table->string('photo_1')->nullable();
            $table->string('photo_2')->nullable();
            $table->string('photo_3')->nullable();
            $table->string('photo_4')->nullable();
            $table->string('photo_5')->nullable();
            $table->boolean('active')->default(true);
            $table->boolean('verified')->default(false);
            $table->boolean('banned')->default(false);
            $table->integer('profile_score')->nullable();
            $table->string('user_ip')->nullable();
            $table->string('last_login_ip')->nullable();
            $table->timestamps();
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
