<?php

namespace Tests\Unit;

use App\Services\ContentSanitizer;
use PHPUnit\Framework\TestCase;

class ContentSanitizerTest extends TestCase
{
    public function test_strips_malicious_script_tags(): void
    {
        $dirty = '<p>مرحباً بكم</p><script>alert("XSS")</script><p>في نبض للتوعية</p>';
        $clean = ContentSanitizer::clean($dirty);

        $this->assertStringNotContainsString('<script>', $clean);
        $this->assertStringNotContainsString('alert', $clean);
        $this->assertStringContainsString('مرحباً بكم', $clean);
        $this->assertStringContainsString('في نبض للتوعية', $clean);
    }

    public function test_removes_inline_event_handlers(): void
    {
        $dirty = '<img src="valid.jpg" onerror="alert(\'Hacked\')" alt="صورة">';
        $clean = ContentSanitizer::clean($dirty);

        $this->assertStringNotContainsString('onerror', $clean);
        $this->assertStringNotContainsString('alert', $clean);
    }

    public function test_removes_javascript_pseudo_protocol_urls(): void
    {
        $dirty = '<a href="javascript:alert(1)">رابط ملغوم</a>';
        $clean = ContentSanitizer::clean($dirty);

        $this->assertStringNotContainsString('javascript:', $clean);
        $this->assertStringContainsString('رابط ملغوم', $clean);
    }

    public function test_preserves_safe_html_formatting(): void
    {
        $safe = '<h3>عنوان رئيسي</h3><p>نص منسق <strong>عريض</strong> و<em>مائل</em></p><ul><li>نقطة 1</li><li>نقطة 2</li></ul><a href="https://example.com">رابط</a>';
        $clean = ContentSanitizer::clean($safe);

        $this->assertStringContainsString('<h3>عنوان رئيسي</h3>', $clean);
        $this->assertStringContainsString('<strong>عريض</strong>', $clean);
        $this->assertStringContainsString('<em>مائل</em>', $clean);
        $this->assertStringContainsString('<li>نقطة 1</li>', $clean);
        $this->assertStringContainsString('href="https://example.com"', $clean);
    }
}
