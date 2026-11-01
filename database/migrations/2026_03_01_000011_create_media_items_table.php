<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('media_items', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('type')->default('image'); // image, video, youtube_short, infographic
            $table->string('file_path')->nullable();
            $table->string('external_url')->nullable();
            $table->string('category')->default('activities'); // programs, activities, educational, announcements
            $table->text('description')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('media_items');
    }
};
