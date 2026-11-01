<?php

namespace Tests\Feature;

use App\Models\ContactSubmission;
use App\Models\PartnershipRequest;
use App\Models\SiteSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FormsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        SiteSetting::create([
            'initiative_name' => 'نبض للتوعية المالية',
            'slogan' => 'طريقك نحو النجاح المالي',
        ]);
    }

    public function test_contact_form_saves_valid_submission(): void
    {
        $payload = [
            'name' => 'محمد أحمد',
            'email' => 'mohammed@example.com',
            'phone' => '0501234567',
            'subject' => 'استفسار عن موعد ورشة العمل',
            'message' => 'السلام عليكم، أود الاستفسار عن موعد ورشة التخطيط المالي القادمة.',
        ];

        $response = $this->post('/contact', $payload);

        $response->assertRedirect('/#contact');
        $response->assertSessionHas('contact_success');

        $this->assertDatabaseHas('contact_submissions', [
            'name' => 'محمد أحمد',
            'email' => 'mohammed@example.com',
            'phone' => '0501234567',
            'status' => 'unread',
        ]);
    }

    public function test_contact_form_rejects_invalid_data(): void
    {
        $payload = [
            'name' => '',
            'email' => 'not-an-email',
            'message' => '',
        ];

        $response = $this->post('/contact', $payload);

        $response->assertSessionHasErrors(['name', 'email', 'message']);
        $this->assertDatabaseCount('contact_submissions', 0);
    }

    public function test_partnership_form_saves_valid_request(): void
    {
        $payload = [
            'organization_name' => 'مؤسسة التنمية الأهلية',
            'contact_person' => 'سارة خالد',
            'email' => 'sara@example.org',
            'phone' => '0559876543',
            'request_type' => 'رعاية برامج تدريبية',
            'description' => 'نود رعاية النسخة القادمة من برنامج كيف أنمي مالي لصالح مستفيدي الجمعية.',
            'privacy_accepted' => '1',
        ];

        $response = $this->post('/partnership', $payload);

        $response->assertRedirect('/#partnership-form');
        $response->assertSessionHas('partnership_success');

        $this->assertDatabaseHas('partnership_requests', [
            'organization_name' => 'مؤسسة التنمية الأهلية',
            'contact_person' => 'سارة خالد',
            'request_type' => 'رعاية برامج تدريبية',
            'status' => 'pending',
        ]);
    }

    public function test_partnership_form_rejects_when_privacy_not_accepted(): void
    {
        $payload = [
            'organization_name' => 'جهة تجريبية',
            'contact_person' => 'مسؤول',
            'email' => 'test@example.com',
            'phone' => '0500000000',
            'request_type' => 'أخرى',
            'description' => 'تفاصيل شراكة تدريبية كافية للطول المطلوب',
            // privacy_accepted omitted
        ];

        $response = $this->post('/partnership', $payload);

        $response->assertSessionHasErrors('privacy_accepted');
        $this->assertDatabaseCount('partnership_requests', 0);
    }
}
