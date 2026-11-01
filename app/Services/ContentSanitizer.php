<?php

namespace App\Services;

class ContentSanitizer
{
    /**
     * Clean and sanitize HTML content to prevent XSS attacks
     */
    public static function clean(?string $html): string
    {
        if (empty($html)) {
            return '';
        }

        // Strip dangerous tags completely including their contents
        $html = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $html);
        $html = preg_replace('#<iframe(.*?)>(.*?)</iframe>#is', '', $html);
        $html = preg_replace('#<object(.*?)>(.*?)</object>#is', '', $html);
        $html = preg_replace('#<embed(.*?)>(.*?)</embed>#is', '', $html);
        $html = preg_replace('#<style(.*?)>(.*?)</style>#is', '', $html);
        $html = preg_replace('#<applet(.*?)>(.*?)</applet>#is', '', $html);

        // Remove on* event handlers (e.g. onclick, onerror, onload)
        $html = preg_replace('#\s*on\w+\s*=\s*("[^"]*"|\'[^\']*\'|[^\s>]+)#i', '', $html);

        // Remove javascript: and data: in href/src
        $html = preg_replace('#href\s*=\s*["\']\s*javascript:[^"\']*["\']#i', 'href="#"', $html);
        $html = preg_replace('#src\s*=\s*["\']\s*javascript:[^"\']*["\']#i', '', $html);
        $html = preg_replace('#href\s*=\s*["\']\s*data:[^"\']*["\']#i', 'href="#"', $html);

        // Allowed tags
        $allowedTags = '<p><br><strong><b><em><i><u><s><h1><h2><h3><h4><h5><h6><ul><ol><li><a><blockquote><code><pre><img><hr><table><thead><tbody><tr><th><td><span><div>';

        $clean = strip_tags($html, $allowedTags);

        return $clean;
    }
}
