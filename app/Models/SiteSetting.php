<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    protected $fillable = [
        'initiative_name',
        'slogan',
        'site_title',
        'meta_description',
        'keywords',
        'logo_path',
        'footer_logo_path',
        'favicon_path',
        'og_image_path',
        'primary_color',
        'accent_color',
        'secondary_color',
        'turquoise_color',
        'font_family',
        'contact_email',
        'contact_phone',
        'whatsapp_number',
        'whatsapp_channel_url',
        'telegram_channel_url',
        'whatsapp_group_url',
        'linkjar_url',
        'twitter_url',
        'instagram_url',
        'linkedin_url',
        'youtube_url',
        'copyright_text',
        'show_footer_social',
        'show_footer_quick_links',
        'show_phases_section',
        'maintenance_mode',
        'header_cta_text',
        'header_cta_url',
    ];

    protected function casts(): array
    {
        return [
            'show_footer_social' => 'boolean',
            'show_footer_quick_links' => 'boolean',
            'show_phases_section' => 'boolean',
            'maintenance_mode' => 'boolean',
        ];
    }

    public static function current(): self
    {
        return Cache::remember('site_settings_current', 3600, function () {
            return self::first() ?? self::create([
                'initiative_name' => 'نبض للتوعية المالية',
                'slogan' => 'طريقك نحو النجاح المالي',
                'site_title' => 'نبض للتوعية المالية | طريقك نحو النجاح المالي',
                'meta_description' => 'مبادرة نبض للتوعية والتمكين المالي للأفراد والأسرة - وعي.. مال.. أسرة',
                'keywords' => 'وعي مالي, تمكين مالي, إدارة الدخل, ادخار, استثمار واعي, نبض للتوعية المالية',
                'primary_color' => '#1e3a8a',
                'accent_color' => '#eab308',
                'secondary_color' => '#2563eb',
                'turquoise_color' => '#0d9488',
                'font_family' => 'Cairo',
                'contact_email' => 'nabdh.almaliah@outlook.sa',
                'contact_phone' => '00966599957589',
                'whatsapp_number' => '00966599957589',
                'whatsapp_channel_url' => 'https://whatsapp.com/channel/0029Vb7xxYv4o7qIlqvlVU1e',
                'telegram_channel_url' => 'https://t.me/nabdh_almaliah_sa',
                'whatsapp_group_url' => 'https://chat.whatsapp.com/EuJWkZ1k7MPFunngBMk7NC',
                'linkjar_url' => 'https://linkjar.co/nabdh.almalih',
                'copyright_text' => 'جميع الحقوق محفوظة لمبادرة نبض للتوعية المالية © ' . date('Y'),
                'show_footer_social' => true,
                'show_footer_quick_links' => true,
                'show_phases_section' => true,
                'maintenance_mode' => false,
                'header_cta_text' => 'تواصل معنا',
                'header_cta_url' => '#contact',
            ]);
        });
    }

    public static function flushCache(): void
    {
        Cache::forget('site_settings_current');
    }

    protected static function booted(): void
    {
        static::saved(function () {
            self::flushCache();
        });

        static::deleted(function () {
            self::flushCache();
        });
    }
}
