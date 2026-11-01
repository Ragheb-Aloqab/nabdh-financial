<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('short_description')->nullable();
            $table->longText('detailed_description')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('pillars')->nullable();
            $table->string('target_audience')->nullable();
            $table->string('trainer_name')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('status')->default('upcoming'); // upcoming, open, ongoing, completed, archived
            $table->string('delivery_mode')->default('online'); // online, in_person, hybrid
            $table->string('registration_url')->nullable();
            $table->string('registration_button_text')->default('سجّل الآن');
            $table->integer('sort_order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('programs');
    }
};
