<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('initiative_name')->default('نبض للتوعية المالية');
            $table->string('slogan')->default('طريقك نحو النجاح المالي');
            $table->string('site_title')->default('نبض للتوعية المالية | طريقك نحو النجاح المالي');
            $table->text('meta_description')->nullable();
            $table->text('keywords')->nullable();
            $table->string('logo_path')->nullable();
            $table->string('footer_logo_path')->nullable();
            $table->string('favicon_path')->nullable();
            $table->string('og_image_path')->nullable();
            $table->string('primary_color')->default('#1e3a8a');
            $table->string('accent_color')->default('#eab308');
            $table->string('secondary_color')->default('#2563eb');
            $table->string('turquoise_color')->default('#0d9488');
            $table->string('font_family')->default('Cairo');
            $table->string('contact_email')->nullable()->default('nabdh.almaliah@outlook.sa');
            $table->string('contact_phone')->nullable()->default('00966599957589');
            $table->string('whatsapp_number')->nullable()->default('00966599957589');
            $table->string('whatsapp_channel_url')->nullable()->default('https://whatsapp.com/channel/0029Vb7xxYv4o7qIlqvlVU1e');
            $table->string('telegram_channel_url')->nullable()->default('https://t.me/nabdh_almaliah_sa');
            $table->string('whatsapp_group_url')->nullable()->default('https://chat.whatsapp.com/EuJWkZ1k7MPFunngBMk7NC');
            $table->string('linkjar_url')->nullable()->default('https://linkjar.co/nabdh.almalih');
            $table->string('twitter_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('youtube_url')->nullable();
            $table->text('copyright_text')->nullable();
            $table->boolean('show_footer_social')->default(true);
            $table->boolean('show_footer_quick_links')->default(true);
            $table->boolean('show_phases_section')->default(true);
            $table->boolean('maintenance_mode')->default(false);
            $table->string('header_cta_text')->default('تواصل معنا');
            $table->string('header_cta_url')->default('#contact');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
