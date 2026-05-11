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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('user_name', 20);
            $table->string('email', 255)->unique();
            $table->string('password', 255);
            $table->boolean('email_verified')->default(false);
            $table->string('profile_image', 255)->nullable();
            $table->char('post_code', 8)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('building', 255)->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
