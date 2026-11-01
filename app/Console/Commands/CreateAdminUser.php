<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateAdminUser extends Command
{
    protected $signature = 'app:create-admin';

    protected $description = 'إنشاء حساب إداري جديد للوحة التحكم بطريقة آمنة';

    public function handle(): int
    {
        $this->info('--- إنشاء حساب إداري جديد لمبادرة نبض للتوعية المالية ---');

        $name = $this->ask('اسم المسؤول');
        $email = $this->ask('البريد الإلكتروني');

        $validator = Validator::make(['email' => $email], [
            'email' => ['required', 'email', 'unique:users,email'],
        ]);

        if ($validator->fails()) {
            $this->error('البريد الإلكتروني غير صالح أو مستخدم مسبقاً.');
            return self::FAILURE;
        }

        $password = $this->secret('كلمة المرور (لن تظهر أثناء الكتابة)');
        $passwordConfirmation = $this->secret('تأكيد كلمة المرور');

        if ($password !== $passwordConfirmation) {
            $this->error('كلمتا المرور غير متطابقتين.');
            return self::FAILURE;
        }

        if (strlen($password) < 8) {
            $this->error('يجب ألا تقل كلمة المرور عن 8 خانات.');
            return self::FAILURE;
        }

        $role = $this->choice('الدور الإداري والصلاحيات', [
            'super_admin' => 'مسؤول عام (Super Admin)',
            'content_manager' => 'مدير محتوى (Content Manager)',
            'forms_manager' => 'مدير النماذج والمراسلات (Forms Manager)',
        ], 'super_admin');

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => $role,
            'is_active' => true,
        ]);

        $this->info("تم إنشاء الحساب الإداري بنجاح! يمكنك الآن تسجيل الدخول عبر: " . url('/admin'));

        return self::SUCCESS;
    }
}
