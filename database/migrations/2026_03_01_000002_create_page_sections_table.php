<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('page_sections', function (Blueprint $table) {
            $table->id();
            $table->string('section_key')->unique(); // hero, about, pillars, programs, achievements, phases, roadmap, testimonials, team, partners, media, partnerships, contact
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->string('badge')->nullable();
            $table->longText('content')->nullable();
            $table->string('button_text')->nullable();
            $table->string('button_url')->nullable();
            $table->string('secondary_button_text')->nullable();
            $table->string('secondary_button_url')->nullable();
            $table->string('image_path')->nullable();
            $table->string('image_alt')->nullable();
            $table->string('background_style')->default('default');
            $table->boolean('is_visible')->default(true);
            $table->integer('sort_order')->default(0);
            $table->json('extra_data')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_sections');
    }
};
