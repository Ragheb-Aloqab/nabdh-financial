@extends('layouts.app')

@section('title', 'سياسة الخصوصية وشروط الاستخدام | نبض للتوعية المالية')

@section('content')
<div class="py-16 bg-slate-900 text-white border-b border-slate-800">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-4">
        <h1 class="text-3xl sm:text-4xl font-extrabold text-white">سياسة الخصوصية وشروط الاستخدام</h1>
        <p class="text-sm text-amber-400 font-semibold">مبادرة «نبض للتوعية المالية» - التوعية والتمكين المالي للأفراد والأسرة</p>
    </div>
</div>

<div class="py-16 bg-white text-slate-700">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8 leading-relaxed text-sm">
        <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200">
            <h2 class="text-lg font-bold text-slate-900 mb-3">1. مقدمة والتزام</h2>
            <p>تلتزم مبادرة «نبض للتوعية المالية» بحماية خصوصية زوار الموقع والمشاركين في برامجها التدريبية والتوعوية. تحدد هذه الوثيقة طبيعة المعلومات التي يتم جمعها وكيفية التعامل معها وفق أعلى معايير الأمان والسرية.</p>
        </div>

        <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200">
            <h2 class="text-lg font-bold text-slate-900 mb-3">2. المعلومات التي نجمعها</h2>
            <ul class="list-disc list-inside space-y-2">
                <li>بيانات الاتصال والتواصل الطوعية (الاسم، البريد الإلكتروني، رقم الهاتف) المقدمة عبر نماذج التواصل أو طلبات الشراكة.</li>
                <li>بيانات الاستفسارات والملاحظات المقدمة من المستفيدين لتطوير البرامج التدريبية.</li>
                <li>بيانات تقنية وإحصائية عامة تتعلق بزيارة الموقع وتحسين تجربة المستخدم.</li>
            </ul>
        </div>

        <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200">
            <h2 class="text-lg font-bold text-slate-900 mb-3">3. الغرض من استخدام البيانات</h2>
            <p>تُستخدم البيانات المدخلة حصراً في:</p>
            <ul class="list-disc list-inside space-y-2 mt-2">
                <li>التواصل مع المستفيدين والإجابة على استفساراتهم ومتابعة طلبات الشراكة.</li>
                <li>إرسال روابط التسجيل والمواعيد الخاصة بالبرامج التدريبية التي يبدي الزائر رغبته بالانضمام إليها.</li>
                <li>قياس مؤشرات الأداء والأثر التوعوي العام دون نشر أي بيانات شخصية أو سرية.</li>
            </ul>
        </div>

        <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200">
            <h2 class="text-lg font-bold text-slate-900 mb-3">4. عدم مشاركة البيانات مع أطراف خارجية</h2>
            <p>لا يتم بيع أو تأجير أو مشاركة أي بيانات شخصية للمستفيدين مع أي طرف ثالث لأغراض تجارية، وتظل كافة المعلومات محفوظة في بيئة تقنية آمنة.</p>
        </div>

        <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200">
            <h2 class="text-lg font-bold text-slate-900 mb-3">5. حقوق الملكية الفكرية</h2>
            <p>كافة الحقوق الفكرية المتعلقة بمحتوى مبادرة «نبض للتوعية المالية» وبرامجها وشعارها محفوظة للمبادرة، ولا يجوز إعادة إنتاج أو نسخ المواد دون إذن مسبق.</p>
        </div>

        <div class="pt-6 text-center">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-slate-900 text-white font-bold text-sm hover:bg-slate-800 transition-colors">
                ← العودة إلى الصفحة الرئيسية
            </a>
        </div>
    </div>
</div>
@endsection
