<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('partnership_requests', function (Blueprint $table) {
            $table->id();
            $table->string('organization_name');
            $table->string('contact_person');
            $table->string('email');
            $table->string('phone');
            $table->string('request_type'); // رعاية, شراكة تدريبية, شراكة مجتمعية, استشارات, أخرى
            $table->text('description');
            $table->boolean('privacy_accepted')->default(true);
            $table->string('status')->default('pending'); // pending, reviewed, contacted, rejected
            $table->text('admin_notes')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('partnership_requests');
    }
};
