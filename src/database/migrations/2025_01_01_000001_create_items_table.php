<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->constrained('users');
            $table->string('image', 255);
            $table->string('item_name', 255);
            $table->string('brand_name', 255);
            $table->integer('price');
            $table->string('description', 255);
            $table->tinyInteger('condition');
            $table->boolean('sold');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
