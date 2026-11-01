<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('program_phases', function (Blueprint $table) {
            $table->id();
            $table->integer('phase_number')->default(1);
            $table->string('title');
            $table->string('duration')->nullable();
            $table->text('objectives')->nullable();
            $table->text('tasks')->nullable();
            $table->text('deliverables')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('program_phases');
    }
};
