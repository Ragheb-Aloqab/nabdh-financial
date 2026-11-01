<?php

namespace App\Http\Controllers;

use App\Models\ContactSubmission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function submit(Request $request): RedirectResponse
    {
        // Spam honeypot protection: if hidden field is filled, silently discard
        if ($request->filled('website_hp')) {
            return redirect('/#contact')
                ->with('contact_success', 'شكراً لتواصلك معنا، تم استلام رسالتك.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:100'],
            'phone' => ['nullable', 'string', 'max:25'],
            'subject' => ['nullable', 'string', 'max:150'],
            'message' => ['required', 'string', 'min:5', 'max:3000'],
        ], [
            'name.required' => 'يرجى كتابة الاسم الكريم.',
            'email.required' => 'يرجى إدخال البريد الإلكتروني.',
            'email.email' => 'صيغة البريد الإلكتروني غير صحيحة.',
            'message.required' => 'يرجى كتابة نص الرسالة أو الاستفسار.',
            'message.min' => 'نص الرسالة قصير جداً.',
        ]);

        ContactSubmission::create([
            'name' => strip_tags($validated['name']),
            'email' => strip_tags($validated['email']),
            'phone' => strip_tags($validated['phone'] ?? ''),
            'subject' => strip_tags($validated['subject'] ?? 'استفسار من الموقع'),
            'message' => strip_tags($validated['message']),
            'status' => 'unread',
            'ip_address' => $request->ip(),
        ]);

        return redirect('/#contact')
            ->with('contact_success', 'شكراً لتواصلك معنا! تم استلام رسالتك بنجاح، وسيتواصل معك فريق مبادرة نبض قريباً.');
    }
}
