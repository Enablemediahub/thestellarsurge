<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('summary')->nullable();
            $table->longText('description')->nullable();
            $table->dateTime('start_at');
            $table->dateTime('end_at')->nullable();
            $table->string('location');
            $table->string('venue')->nullable();
            $table->unsignedInteger('price')->default(0);
            $table->string('currency', 10)->default('NGN');
            $table->text('banner_image')->nullable();
            $table->boolean('is_published')->default(false);
            $table->boolean('featured')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
