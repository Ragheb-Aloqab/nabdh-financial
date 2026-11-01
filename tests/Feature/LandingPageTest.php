<?php

namespace Tests\Feature;

use App\Models\PageSection;
use App\Models\Program;
use App\Models\SiteSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LandingPageTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        SiteSetting::create([
            'initiative_name' => 'نبض للتوعية المالية',
            'slogan' => 'طريقك نحو النجاح المالي',
            'site_title' => 'نبض للتوعية المالية | طريقك نحو النجاح المالي',
            'meta_description' => 'مبادرة نبض للتوعية والتمكين المالي للأفراد والأسرة',
            'contact_email' => 'nabdh.almaliah@outlook.sa',
            'contact_phone' => '00966599957589',
            'show_phases_section' => true,
        ]);

        PageSection::create([
            'section_key' => 'hero',
            'title' => 'طريقك نحو النجاح المالي',
            'subtitle' => 'مبادرة نبض للتوعية والتمكين المالي',
            'content' => 'محتوى تعريفي',
            'is_visible' => true,
            'sort_order' => 1,
        ]);

        PageSection::create([
            'section_key' => 'programs',
            'title' => 'برامج المبادرة',
            'is_visible' => true,
            'sort_order' => 4,
        ]);

        PageSection::create([
            'section_key' => 'hidden_section',
            'title' => 'قسم مخفي تجريبي',
            'is_visible' => false,
            'sort_order' => 99,
        ]);
    }

    public function test_home_page_returns_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('نبض للتوعية المالية');
        $response->assertSee('طريقك نحو النجاح المالي');
    }

    public function test_only_published_programs_are_displayed(): void
    {
        $published = Program::create([
            'title' => 'برنامج منشور تجريبي',
            'slug' => 'published-program',
            'short_description' => '<p>وصف برنامج منشور</p>',
            'status' => 'open',
            'is_published' => true,
            'sort_order' => 1,
        ]);

        $draft = Program::create([
            'title' => 'برنامج مسودة مخفي',
            'slug' => 'draft-program',
            'short_description' => '<p>وصف مسودة</p>',
            'status' => 'upcoming',
            'is_published' => false,
            'sort_order' => 2,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('برنامج منشور تجريبي');
        $response->assertDontSee('برنامج مسودة مخفي');
    }

    public function test_hidden_sections_are_not_displayed(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertDontSee('قسم مخفي تجريبي');
    }

    public function test_published_program_details_page_is_accessible(): void
    {
        $program = Program::create([
            'title' => 'كيف أبدأ من الصفر',
            'slug' => 'start-from-scratch',
            'short_description' => '<p>وصف مبسط</p>',
            'detailed_description' => '<p>تفاصيل البرنامج التدريبي</p>',
            'status' => 'open',
            'is_published' => true,
        ]);

        $response = $this->get('/programs/' . $program->slug);

        $response->assertStatus(200);
        $response->assertSee('كيف أبدأ من الصفر');
        $response->assertSee('تفاصيل البرنامج التدريبي');
    }

    public function test_draft_program_details_page_returns_404(): void
    {
        $draft = Program::create([
            'title' => 'برنامج سري قيد الإعداد',
            'slug' => 'secret-draft',
            'short_description' => 'وصف',
            'is_published' => false,
        ]);

        $response = $this->get('/programs/' . $draft->slug);

        $response->assertStatus(404);
    }

    public function test_privacy_page_is_accessible(): void
    {
        $response = $this->get('/privacy-policy');

        $response->assertStatus(200);
        $response->assertSee('سياسة الخصوصية');
    }

    public function test_sitemap_returns_valid_xml(): void
    {
        $response = $this->get('/sitemap.xml');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/xml; charset=UTF-8');
        $response->assertSee('<urlset', false);
    }
}
