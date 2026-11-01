<?php

namespace App\Http\Controllers;

use App\Models\PartnershipRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PartnershipController extends Controller
{
    public function submit(Request $request): RedirectResponse
    {
        // Anti-spam honeypot
        if ($request->filled('website_hp')) {
            return redirect('/#partnership-form')
                ->with('partnership_success', 'شكراً لاهتمامكم، تم استلام طلبكم.');
        }

        $validated = $request->validate([
            'organization_name' => ['required', 'string', 'max:150'],
            'contact_person' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:100'],
            'phone' => ['required', 'string', 'max:25'],
            'request_type' => ['required', 'string', 'max:50'],
            'description' => ['required', 'string', 'min:10', 'max:3000'],
            'privacy_accepted' => ['accepted'],
        ], [
            'organization_name.required' => 'يرجى إدخال اسم الجهة أو المؤسسة.',
            'contact_person.required' => 'يرجى إدخال اسم الشخص المسؤول للتواصل.',
            'email.required' => 'يرجى إدخال البريد الإلكتروني للتواصل.',
            'email.email' => 'البريد الإلكتروني غير صالح.',
            'phone.required' => 'يرجى إدخال رقم هاتف أو جوال للتواصل.',
            'request_type.required' => 'يرجى تحديد نوع الشراكة أو الرعاية المطلوبة.',
            'description.required' => 'يرجى كتابة نبذة مختصرة عن الشراكة ومجال التعاون المقترح.',
            'description.min' => 'يرجى توضيح تفاصيل الشراكة بما لا يقل عن 10 أحرف.',
            'privacy_accepted.accepted' => 'يرجى الموافقة على شروط التواصل والخصوصية لمتابعة الطلب.',
        ]);

        PartnershipRequest::create([
            'organization_name' => strip_tags($validated['organization_name']),
            'contact_person' => strip_tags($validated['contact_person']),
            'email' => strip_tags($validated['email']),
            'phone' => strip_tags($validated['phone']),
            'request_type' => strip_tags($validated['request_type']),
            'description' => strip_tags($validated['description']),
            'privacy_accepted' => true,
            'status' => 'pending',
            'ip_address' => $request->ip(),
        ]);

        return redirect('/#partnership-form')
            ->with('partnership_success', 'شكراً لاهتمامكم بالشراكة والتعاون مع مبادرة نبض للتوعية المالية! تم استلام طلبكم بنجاح وسيتواصل معكم فريق العلاقات والشراكات قريباً.');
    }
}
