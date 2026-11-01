<?php

namespace Tests\Feature;

use App\Models\ContactSubmission;
use App\Models\PageSection;
use App\Models\Program;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_admin_login(): void
    {
        $response = $this->get('/admin');

        $response->assertRedirect('/admin/login');
    }

    public function test_inactive_user_cannot_access_admin_panel(): void
    {
        $user = User::create([
            'name' => 'مستخدم معطل',
            'email' => 'inactive@nabdh.sa',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
            'is_active' => false,
        ]);

        $this->actingAs($user);

        $response = $this->get('/admin');

        $response->assertStatus(403);
    }

    public function test_super_admin_can_access_admin_panel(): void
    {
        $admin = User::create([
            'name' => 'مدير النظام',
            'email' => 'admin@nabdh.sa',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
            'is_active' => true,
        ]);

        $this->actingAs($admin);

        $response = $this->get('/admin');

        $response->assertStatus(200);
    }

    public function test_content_manager_can_access_programs_resource(): void
    {
        $editor = User::create([
            'name' => 'مدير المحتوى',
            'email' => 'editor@nabdh.sa',
            'password' => Hash::make('password'),
            'role' => 'content_manager',
            'is_active' => true,
        ]);

        $this->actingAs($editor);

        $response = $this->get('/admin/programs');

        $response->assertStatus(200);
    }

    public function test_forms_manager_can_access_contact_submissions(): void
    {
        $formsManager = User::create([
            'name' => 'مدير النماذج',
            'email' => 'forms@nabdh.sa',
            'password' => Hash::make('password'),
            'role' => 'forms_manager',
            'is_active' => true,
        ]);

        $this->actingAs($formsManager);

        $response = $this->get('/admin/contact-submissions');

        $response->assertStatus(200);
    }

    public function test_forms_manager_is_forbidden_from_programs_resource(): void
    {
        $formsManager = User::create([
            'name' => 'مدير النماذج',
            'email' => 'forms@nabdh.sa',
            'password' => Hash::make('password'),
            'role' => 'forms_manager',
            'is_active' => true,
        ]);

        $this->actingAs($formsManager);

        $response = $this->get('/admin/programs');

        $response->assertStatus(403);
    }

    public function test_content_manager_is_forbidden_from_user_management(): void
    {
        $editor = User::create([
            'name' => 'مدير المحتوى',
            'email' => 'editor@nabdh.sa',
            'password' => Hash::make('password'),
            'role' => 'content_manager',
            'is_active' => true,
        ]);

        $this->actingAs($editor);

        $response = $this->get('/admin/users');

        $response->assertStatus(403);
    }

    public function test_super_admin_can_render_page_section_edit_page(): void
    {
        $admin = User::create([
            'name' => 'مدير النظام',
            'email' => 'admin@nabdh.sa',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
            'is_active' => true,
        ]);

        $section = PageSection::create([
            'section_key' => 'hero',
            'title' => 'الواجهة الرئيسية',
            'content' => '<p>مرحبا بكم في نبض للتوعية المالية</p>',
            'is_visible' => true,
            'sort_order' => 1,
        ]);

        $this->actingAs($admin);

        $response = $this->get("/admin/page-sections/{$section->id}/edit");

        $response->assertStatus(200);
    }

    public function test_super_admin_can_render_program_edit_page(): void
    {
        $admin = User::create([
            'name' => 'مدير النظام',
            'email' => 'admin@nabdh.sa',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
            'is_active' => true,
        ]);

        $program = Program::create([
            'title' => 'برنامج تجريبي',
            'slug' => 'test-prog',
            'short_description' => '<p>وصف قصير</p>',
            'detailed_description' => '<p>وصف تفصيلي</p>',
            'is_published' => true,
            'sort_order' => 1,
        ]);

        $this->actingAs($admin);

        $response = $this->get("/admin/programs/{$program->id}/edit");

        $response->assertStatus(200);
    }
}
