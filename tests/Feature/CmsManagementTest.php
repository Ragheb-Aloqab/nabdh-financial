<?php

namespace Tests\Feature;

use App\Models\Program;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CmsManagementTest extends TestCase
{
    use RefreshDatabase;

    protected User $superAdmin;
    protected User $contentManager;
    protected User $formsManager;

    protected function setUp(): void
    {
        parent::setUp();

        $this->superAdmin = User::create([
            'name' => 'مسؤول عام',
            'email' => 'admin@nabdh.sa',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
            'is_active' => true,
        ]);

        $this->contentManager = User::create([
            'name' => 'مدير المحتوى',
            'email' => 'editor@nabdh.sa',
            'password' => Hash::make('password'),
            'role' => 'content_manager',
            'is_active' => true,
        ]);

        $this->formsManager = User::create([
            'name' => 'مدير النماذج',
            'email' => 'forms@nabdh.sa',
            'password' => Hash::make('password'),
            'role' => 'forms_manager',
            'is_active' => true,
        ]);

        SiteSetting::create([
            'initiative_name' => 'نبض للتوعية المالية',
            'slogan' => 'طريقك نحو النجاح المالي',
        ]);

        \App\Models\PageSection::create([
            'section_key' => 'programs',
            'title' => 'برامج المبادرة',
            'is_visible' => true,
            'sort_order' => 4,
        ]);
    }

    public function test_can_create_update_and_publish_program(): void
    {
        // 1. Create program as draft
        $program = Program::create([
            'title' => 'برنامج التخطيط المالي للمقبلين على الزواج',
            'slug' => 'marriage-planning',
            'short_description' => '<p>وصف <strong>منسق</strong> باللغة العربية</p>',
            'detailed_description' => '<h3>المحاور الرئيسية</h3><ul><li>الميزانية المشتركة</li><li>صندوق الطوارئ</li></ul>',
            'pillars' => 'التخطيط المالي، الثقافة المالية للأسرة',
            'target_audience' => 'المقبلون على الزواج',
            'status' => 'upcoming',
            'delivery_mode' => 'online',
            'is_published' => false,
            'sort_order' => 1,
        ]);

        $this->assertDatabaseHas('programs', [
            'id' => $program->id,
            'title' => 'برنامج التخطيط المالي للمقبلين على الزواج',
            'is_published' => false,
        ]);

        // Verify draft is not visible on frontend
        $response = $this->get('/');
        $response->assertDontSee('برنامج التخطيط المالي للمقبلين على الزواج');

        // 2. Update and Publish
        $program->update([
            'status' => 'open',
            'is_published' => true,
        ]);

        $this->assertDatabaseHas('programs', [
            'id' => $program->id,
            'is_published' => true,
            'status' => 'open',
        ]);

        // Verify it is now visible on frontend
        $response = $this->get('/');
        $response->assertSee('برنامج التخطيط المالي للمقبلين على الزواج');
    }

    public function test_site_settings_can_be_saved_and_reflected_on_frontend(): void
    {
        $setting = SiteSetting::first();
        $setting->update([
            'slogan' => 'شعار مالي محدث وفريد للواجهة',
            'contact_phone' => '00966500000000',
        ]);

        SiteSetting::flushCache();

        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('شعار مالي محدث وفريد للواجهة');
        $response->assertSee('00966500000000');
    }

    public function test_super_admin_can_manage_users(): void
    {
        $this->assertTrue($this->superAdmin->can('viewAny', User::class));
        $this->assertTrue($this->superAdmin->can('create', User::class));

        $newUser = User::create([
            'name' => 'مشرف جديد',
            'email' => 'new@nabdh.sa',
            'password' => Hash::make('password'),
            'role' => 'content_manager',
            'is_active' => true,
        ]);

        $this->assertTrue($this->superAdmin->can('update', $newUser));
        $this->assertTrue($this->superAdmin->can('delete', $newUser));
    }

    public function test_user_cannot_delete_themselves(): void
    {
        $this->assertFalse($this->superAdmin->can('delete', $this->superAdmin));
    }

    public function test_content_manager_permissions(): void
    {
        $this->assertFalse($this->contentManager->can('viewAny', User::class));
        $this->assertFalse($this->contentManager->can('create', User::class));

        // Can manage programs and sections
        $this->assertTrue($this->contentManager->can('viewAny', Program::class));
        $this->assertTrue($this->contentManager->can('create', Program::class));
    }

    public function test_forms_manager_permissions(): void
    {
        // Cannot manage programs
        $this->assertFalse($this->formsManager->can('viewAny', Program::class));
        $this->assertFalse($this->formsManager->can('create', Program::class));

        // Cannot manage users
        $this->assertFalse($this->formsManager->can('viewAny', User::class));
    }
}
