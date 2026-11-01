<?php

namespace Database\Seeders;

use App\Models\Achievement;
use App\Models\PageSection;
use App\Models\Pillar;
use App\Models\Program;
use App\Models\ProgramPhase;
use App\Models\RoadmapStep;
use App\Models\SiteSetting;
use App\Models\Testimonial;
use App\Models\TeamMember;
use App\Models\Partner;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Admin users
        if (app()->environment('production')) {
            // Production: never use the public development credentials.
            // Credentials come from ADMIN_EMAIL / ADMIN_PASSWORD env variables.
            $adminEmail = env('ADMIN_EMAIL', 'admin@nabdh.sa');
            $adminPassword = env('ADMIN_PASSWORD');

            if (blank($adminPassword)) {
                $adminPassword = Str::password(20);
                $this->command?->warn('ADMIN_PASSWORD is not set. A random password was generated for '.$adminEmail.':');
                $this->command?->line($adminPassword);
                $this->command?->warn('Change it after the first login.');
            }

            User::firstOrCreate(
                ['email' => $adminEmail],
                [
                    'name' => env('ADMIN_NAME', 'مدير النظام - نبض'),
                    'password' => Hash::make($adminPassword),
                    'role' => 'super_admin',
                    'is_active' => true,
                ]
            );
        } else {
            // Initial Local Admin User for Development
            User::firstOrCreate(
                ['email' => 'admin@nabdh.sa'],
                [
                    'name' => 'مدير النظام - نبض',
                    'password' => Hash::make('Admin#Nabdh2026!'),
                    'role' => 'super_admin',
                    'is_active' => true,
                ]
            );

            // Content Manager
            User::firstOrCreate(
                ['email' => 'editor@nabdh.sa'],
                [
                    'name' => 'مدير المحتوى - نبض',
                    'password' => Hash::make('Editor#Nabdh2026!'),
                    'role' => 'content_manager',
                    'is_active' => true,
                ]
            );

            // Forms Manager
            User::firstOrCreate(
                ['email' => 'forms@nabdh.sa'],
                [
                    'name' => 'مدير المراسلات والشراكات',
                    'password' => Hash::make('Forms#Nabdh2026!'),
                    'role' => 'forms_manager',
                    'is_active' => true,
                ]
            );
        }

        // 2. Global Site Settings
        SiteSetting::current(); // Ensures default row exists

        // 3. Page Sections (The 13 interactive sections of the landing page)
        $sections = [
            [
                'section_key' => 'hero',
                'title' => 'طريقك نحو النجاح المالي',
                'subtitle' => 'مبادرة نبض للتوعية والتمكين المالي للأفراد والأسرة',
                'badge' => 'وعي.. مال.. أسرة',
                'content' => '<p class="text-xl md:text-2xl text-slate-100 font-medium leading-relaxed">رفع الوعي المالي وتحقيق تغيير سلوكي مستدام لدى الأفراد والأسر عبر برامج تدريبية وتوعوية وتطبيقية قابلة للقياس، ومتوافقة مع مستهدفات رؤية السعودية 2030.</p>',
                'button_text' => 'تعرّف على المبادرة',
                'button_url' => '#about',
                'secondary_button_text' => 'اكتشف برامجنا',
                'secondary_button_url' => '#programs',
                'background_style' => 'navy',
                'is_visible' => true,
                'sort_order' => 1,
            ],
            [
                'section_key' => 'about',
                'title' => 'عن مبادرة نبض للتوعية المالية',
                'subtitle' => 'التوعية والتمكين المالي للأفراد والأسرة',
                'badge' => 'رسالتنا وهدفنا',
                'content' => '<p class="text-lg text-slate-700 leading-relaxed font-semibold mb-4 text-emerald-800">وعي.. مال.. أسرة</p><p class="text-slate-600 leading-relaxed mb-4">انطلقت مبادرة «نبض للتوعية المالية» استجابة للحاجة المجتمعية الملحة لبناء ثقافة مالية واعية تمكن الأسر والأفراد من اتخاذ قرارات مالية حكيمة، وتعزز الاستقرار الاجتماعي والاقتصادي.</p><p class="text-slate-600 leading-relaxed">نؤمن بأن الوعي المالي ليس مجرد أرقام وحسابات، بل هو سلوك يومي وثقافة حياة تبدأ من ميزانية الأسرة وتثمر استقراراً وتنمية مستدامة للأجيال القادمة.</p>',
                'button_text' => 'استكشف محاور المبادرة',
                'button_url' => '#pillars',
                'secondary_button_text' => 'خارطة التخطيط',
                'secondary_button_url' => '#roadmap',
                'background_style' => 'default',
                'is_visible' => true,
                'sort_order' => 2,
            ],
            [
                'section_key' => 'pillars',
                'title' => 'محاور وأهداف المبادرة',
                'subtitle' => 'ركائز متكاملة تغطي كافة جوانب الحياة المالية للفرد والأسرة',
                'badge' => 'محاور التمكين',
                'content' => '<p class="text-slate-600 text-center max-w-3xl mx-auto">محاور تدريبية وتوعوية مبنية وفق أسس منهجية لنقل المستفيد من مرحلة العشوائية المالية إلى الإدارة الواعية والاستقرار المستدام.</p>',
                'button_text' => null,
                'button_url' => null,
                'background_style' => 'light',
                'is_visible' => true,
                'sort_order' => 3,
            ],
            [
                'section_key' => 'programs',
                'title' => 'برامج المبادرة التدريبية والتوعوية',
                'subtitle' => 'برامج تخصصية وتطبيقية موجهة لمختلف الفئات المجتمعية',
                'badge' => 'برامجنا المطروحة',
                'content' => '<p class="text-slate-600 text-center max-w-3xl mx-auto">برامج تطبيقية متميزة تم تصميمها بعناية لتناسب الشباب، وأرباب الأسر، والمقبلين على الزواج، والأطفال ورواد الأعمال.</p>',
                'button_text' => 'عرض تفاصيل البرامج',
                'button_url' => '#programs',
                'background_style' => 'default',
                'is_visible' => true,
                'sort_order' => 4,
            ],
            [
                'section_key' => 'achievements',
                'title' => 'الإنجازات ومؤشرات الأثر الواقعي',
                'subtitle' => 'أرقام وإحصائيات موثقة تعكس مسيرة العمل والأثر المجتمعي',
                'badge' => 'أثرنا بالأرقام',
                'content' => '<p class="text-slate-600 text-center max-w-3xl mx-auto">أرقام صادقة تعبر عن أثر المبادرة في الميدان دون مبالغة، موثقة بتاريخ التحديث الأخير.</p>',
                'background_style' => 'light',
                'is_visible' => true,
                'sort_order' => 5,
            ],
            [
                'section_key' => 'phases',
                'title' => 'مراحل تنفيذ المبادرة',
                'subtitle' => 'مسار مرحلي مدروس يضمن جودة التنفيذ وتثبيت السلوك المالي',
                'badge' => 'منهجية التنفيذ',
                'content' => '<p class="text-slate-600 text-center max-w-3xl mx-auto">تعتمد مبادرتنا خطة عمل متسلسلة تضمن قياس المخرجات والانتقال بالمستفيد عبر خطوات متدرجة ومستدامة.</p>',
                'background_style' => 'default',
                'is_visible' => true,
                'sort_order' => 6,
            ],
            [
                'section_key' => 'roadmap',
                'title' => 'خارطة التخطيط المالي الشخصي',
                'subtitle' => '6 خطوات عملية ومنهجية لإدارة أموالك بنجاح واقتدار',
                'badge' => 'مسار التخطيط',
                'content' => '<p class="text-slate-600 text-center max-w-3xl mx-auto">خريطة طريق مبسطة تمكنك من تقييم واقعك المالي، وتحديد أولوياتك، وبناء خطة مالية قابلة للتنفيذ والتطوير المستمر.</p>',
                'background_style' => 'light',
                'is_visible' => true,
                'sort_order' => 7,
            ],
            [
                'section_key' => 'testimonials',
                'title' => 'آراء وتجارب المستفيدين',
                'subtitle' => 'أصداء المشاركين بعد خوضهم تجربة برامج نبض للتوعية المالية',
                'badge' => 'قصص واقعية',
                'content' => '<p class="text-slate-600 text-center max-w-3xl mx-auto">تجارب حقيقية تعكس التغيير الإيجابي في إدارة الميزانية والادخار.</p>',
                'background_style' => 'default',
                'is_visible' => true,
                'sort_order' => 8,
            ],
            [
                'section_key' => 'team',
                'title' => 'فريق عمل المبادرة',
                'subtitle' => 'كفاءات وطنية ملتزمة بنشر المعرفة وبناء الوعي المالي',
                'badge' => 'فريقنا',
                'content' => '<p class="text-slate-600 text-center max-w-3xl mx-auto">نخبة من المتخصصين والمهتمين بالتمكين المالي والمسؤولية المجتمعية.</p>',
                'background_style' => 'light',
                'is_visible' => true,
                'sort_order' => 9,
            ],
            [
                'section_key' => 'partners',
                'title' => 'شركاء النجاح والمستشارون',
                'subtitle' => 'شراكات تكاملية ومستشارون معتمدون لإثراء برامج المبادرة',
                'badge' => 'الشركاء',
                'content' => '<p class="text-slate-600 text-center max-w-3xl mx-auto">نتعاون مع المؤسسات والخبراء لتقديم محتوى عالي الجودة وموثوق.</p>',
                'background_style' => 'default',
                'is_visible' => true,
                'sort_order' => 10,
            ],
            [
                'section_key' => 'media',
                'title' => 'الصور والمحتوى المرئي',
                'subtitle' => 'لقطات من الفعاليات وورش العمل والمقاطع التوعوية',
                'badge' => 'المركز الإعلامي',
                'content' => '<p class="text-slate-600 text-center max-w-3xl mx-auto">شاهد تغطيات برامجنا ومقاطع الفيديو التثقيفية المنشورة عبر منصاتنا الرسمية.</p>',
                'background_style' => 'light',
                'is_visible' => true,
                'sort_order' => 11,
            ],
            [
                'section_key' => 'partnerships',
                'title' => 'فرص الشراكة والتعاون المؤسسي',
                'subtitle' => 'ساهم معنا في تمكين المجتمع مالياً وبناء مستقبل اقتصادي مزدهر',
                'badge' => 'كن شريكاً',
                'content' => '<p class="text-slate-600 text-center max-w-3xl mx-auto">نرحب بالشراكات الاستراتيجية مع القطاعات الحكومية والخاصة وغير الربحية لتنفيذ برامج مخصصة لمنسوبيهم ومجتمعاتهم.</p>',
                'button_text' => 'تقديم طلب شراكة',
                'button_url' => '#partnership-form',
                'background_style' => 'default',
                'is_visible' => true,
                'sort_order' => 12,
            ],
            [
                'section_key' => 'contact',
                'title' => 'تواصل معنا وانضم إلى مجتمعنا',
                'subtitle' => 'يسعدنا تواصلكم واستقبال استفساراتكم والمشاركة في قنواتنا الرسمية',
                'badge' => 'اتصل بنا',
                'content' => '<p class="text-slate-600 text-center max-w-3xl mx-auto">انضم إلى قنوات نبض للتوعية المالية على واتساب وتيليجرام للحصول على المواد والفعاليات أولاً بأول.</p>',
                'background_style' => 'light',
                'is_visible' => true,
                'sort_order' => 13,
            ],
        ];

        foreach ($sections as $s) {
            PageSection::updateOrCreate(
                ['section_key' => $s['section_key']],
                $s
            );
        }

        // 4. Pillars (The 6 authentic pillars)
        $pillars = [
            [
                'title' => 'التوعية والتمكين المالي',
                'short_description' => 'بناء المفاهيم المالية الأساسية، وتمكين الأفراد من اتخاذ قرارات مالية سليمة ومستقلة.',
                'icon' => 'currency-dollar',
                'sort_order' => 1,
                'is_published' => true,
            ],
            [
                'title' => 'إدارة الدخل والمصروفات',
                'short_description' => 'مهارات ضبط الميزانية الشخصية والأسرية، وتحديد الأولويات والحد من النفقات العشوائية.',
                'icon' => 'scale',
                'sort_order' => 2,
                'is_published' => true,
            ],
            [
                'title' => 'التخطيط المالي',
                'short_description' => 'وضع خطط مالية قصيرة وطويلة الأجل، والاستعداد لمتطلبات المستقبل والأزمات الطارئة.',
                'icon' => 'chart-bar',
                'sort_order' => 3,
                'is_published' => true,
            ],
            [
                'title' => 'الادخار وإدارة الديون',
                'short_description' => 'بناء صندوق الطوارئ، وتطبيق استراتيجيات التخلص من الديون وتجنب القروض الاستهلاكية.',
                'icon' => 'shield-check',
                'sort_order' => 4,
                'is_published' => true,
            ],
            [
                'title' => 'الثقافة المالية للأسرة',
                'short_description' => 'غرس السلوك المالي الرشيد داخل الأسرة، وتعليم الأبناء قيمة المال وإدارته من الصغر.',
                'icon' => 'home',
                'sort_order' => 5,
                'is_published' => true,
            ],
            [
                'title' => 'الاستثمار الواعي',
                'short_description' => 'التعرف على مبادئ الاستثمار، وتنويع مصادر الدخل، وحماية المدخرات من المخاطر والاحتيال.',
                'icon' => 'trending-up',
                'sort_order' => 6,
                'is_published' => true,
            ],
        ];

        foreach ($pillars as $p) {
            Pillar::updateOrCreate(['title' => $p['title']], $p);
        }

        // 5. Authentic Programs from the initiative files
        $programs = [
            [
                'title' => 'كيف أبدأ من الصفر',
                'slug' => 'start-from-scratch',
                'short_description' => '<p>برنامج تدريبي تطبيقي يركز على المبادئ الأولى لبناء الوضع المالي السليم من الصفر وإعادة ترتيب الأولويات المالية.</p>',
                'detailed_description' => '<p>يركز هذا البرنامج على الأدوات والخطوات العملية التي تمكن الفرد من تجاوز مرحلة العشوائية وبناء أول قاعدة مالية صلبة، مع كيفية إدارة المصروفات الشهرية وتوليد مصادر دخل جديدة.</p>',
                'pillars' => 'التوعية والتمكين المالي، إدارة الدخل والمصروفات',
                'target_audience' => 'الشباب والباحثون عن انطلاقة مالية منظمة',
                'status' => 'open',
                'delivery_mode' => 'online',
                'sort_order' => 1,
                'is_published' => true,
                'is_featured' => true,
            ],
            [
                'title' => 'لا تنتظر الفرصة بل اصنعها',
                'slug' => 'create-opportunity',
                'short_description' => '<p>ورشة تفاعلية حول استثمار المهارات الذاتية واكتشاف الفرص المالية المتاحة وتنميتها.</p>',
                'detailed_description' => '<p>تمكين المشارك من تحويل مهاراته واهتماماته إلى مشاريع ومصادر دخل حقيقية من خلال التخطيط والمبادرة الإيجابية في سوق العمل.</p>',
                'pillars' => 'الاستثمار الواعي، التمكين المالي',
                'target_audience' => 'الشباب، رواد الأعمال الجدد',
                'status' => 'upcoming',
                'delivery_mode' => 'online',
                'sort_order' => 2,
                'is_published' => true,
                'is_featured' => true,
            ],
            [
                'title' => 'كيف أكتب سيرتي الذاتية واستعد للمقابلة الشخصية',
                'slug' => 'resume-and-interview',
                'short_description' => '<p>برنامج تأهيلي لاكتساب مهارات التسويق الذاتي والجاهزية المهنية لدخول سوق العمل وتحسين الدخل.</p>',
                'detailed_description' => '<p>يربط البرنامج بين التمكين المهني وزيادة مصادر الدخل، حيث يتدرب المشارك على بناء سيرة ذاتية احترافية واجتياز المقابلات الوظيفية بثقة.</p>',
                'pillars' => 'التمكين المالي، إدارة الدخل',
                'target_audience' => 'الخريجون والباحثون عن عمل',
                'status' => 'upcoming',
                'delivery_mode' => 'online',
                'sort_order' => 3,
                'is_published' => true,
            ],
            [
                'title' => 'الديون وأثرها على رب الأسرة',
                'slug' => 'debts-and-family',
                'short_description' => '<p>برنامج توعوي وإرشادي يعالج مشكلة الالتزامات المالية المتراكمة وأثرها على استقرار الأسرة وطرق التخلص منها.</p>',
                'detailed_description' => '<p>يقدم حلولاً عملية وجداول سداد علمية للتعامل مع الديون والقروض، وتفادي الفخاخ الائتمانية لحماية استقرار الأسرة النفسي والمالي.</p>',
                'pillars' => 'الادخار وإدارة الديون، الثقافة المالية للأسرة',
                'target_audience' => 'أرباب الأسر وأصحاب الالتزامات المالية',
                'status' => 'open',
                'delivery_mode' => 'online',
                'sort_order' => 4,
                'is_published' => true,
                'is_featured' => true,
            ],
            [
                'title' => 'كيف أنمي مالي؟',
                'slug' => 'grow-my-money',
                'short_description' => '<p>دليل إرشادي وورشة عملية حول القنوات الاستثمارية الآمنة، وتنمية المدخرات بصورة متوازنة.</p>',
                'detailed_description' => '<p>استعراض الفروق بين الادخار والاستثمار، وكيفية بناء محفظة متوازنة تناسب مختلف مستويات الدخل مع مراعاة إدارة المخاطر.</p>',
                'pillars' => 'الاستثمار الواعي، التخطيط المالي',
                'target_audience' => 'المدخرون، الراغبون في بدء الاستثمار الآمن',
                'status' => 'upcoming',
                'delivery_mode' => 'online',
                'sort_order' => 5,
                'is_published' => true,
            ],
            [
                'title' => 'يلا نحقق أحلامنا',
                'slug' => 'achieve-our-dreams',
                'short_description' => '<p>برنامج تحفيزي وتطبيقي يربط بين الأهداف المالية الشخصية وأهداف الحياة الواقعية.</p>',
                'detailed_description' => '<p>كيف تترجم رغباتك وأحلامك إلى أهداف مالية ذكية ومحددة بزمن، مع وضع جدول زمني لتحقيقها دون ضغوط مالية.</p>',
                'pillars' => 'التخطيط المالي، التمكين المالي',
                'target_audience' => 'الشباب والأسر',
                'status' => 'upcoming',
                'delivery_mode' => 'online',
                'sort_order' => 6,
                'is_published' => true,
            ],
            [
                'title' => 'التاجر الصغير',
                'slug' => 'young-trader',
                'short_description' => '<p>برنامج مالي مبسط وتفاعلي لتعليم الأطفال واليافعين مبادئ البيع والشراء وقيمة الادخار والعمل.</p>',
                'detailed_description' => '<p>أنشطة تفاعلية ومحاكاة للتجارة البسيطة لغرس روح المسؤولية المالية وريادة الأعمال لدى الناشئة بأسلوب ممتع وشيق.</p>',
                'pillars' => 'الثقافة المالية للأسرة',
                'target_audience' => 'الأطفال واليافعون وأولياء الأمور',
                'status' => 'open',
                'delivery_mode' => 'hybrid',
                'sort_order' => 7,
                'is_published' => true,
                'is_featured' => true,
            ],
            [
                'title' => 'النفخة الكذابة',
                'slug' => 'fake-prestige',
                'short_description' => '<p>جلسة حوارية وتوعوية حول خطورة الاستهلاك المظهري والتقليد الاجتماعي وتأثيره الكارثي على الميزانية.</p>',
                'detailed_description' => '<p>تسليط الضوء على السلوكيات الشرائية غير المدروسة وضغط المجتمع الاستهلاكي، وطرق تعزيز القناعة والتوازن المالي الحقيقي.</p>',
                'pillars' => 'إدارة الدخل والمصروفات، التوعية والتمكين',
                'target_audience' => 'كافة فئات المجتمع، الشباب، الأسر',
                'status' => 'upcoming',
                'delivery_mode' => 'online',
                'sort_order' => 8,
                'is_published' => true,
            ],
            [
                'title' => 'جاهز للزواج',
                'slug' => 'ready-for-marriage',
                'short_description' => '<p>دورة تأهيلية للمقبلين على الزواج للتخطيط المالي لمصاريف الزواج وبناء ميزانية أسرية متوازنة من البداية.</p>',
                'detailed_description' => '<p>التخطيط لنفقات الزواج وتجنب الديون غير المبررة، والتفاهم المالي المشترك بين الزوجين لضمان بداية مستقرة لحياتهما المشتركة.</p>',
                'pillars' => 'الثقافة المالية للأسرة، التخطيط المالي',
                'target_audience' => 'المقبلون والمقبلات على الزواج، حديثو الزواج',
                'status' => 'upcoming',
                'delivery_mode' => 'online',
                'sort_order' => 9,
                'is_published' => true,
            ],
            [
                'title' => 'نحو الهدف',
                'slug' => 'toward-the-goal',
                'short_description' => '<p>برنامج تدريبي متخصص سبق الإعلان عنه يركز على رسم المسارات المالية وتحقيق مستهدفات الأمان المالي.</p>',
                'detailed_description' => '<p>خطوات عملية لقياس التقدم المالي ومراجعة الأداء الدوري لضمان الوصول إلى الاستقلال المالي المنشود.</p>',
                'pillars' => 'التخطيط المالي، الاستثمار الواعي',
                'target_audience' => 'المهتمون بتطوير وضعهم المالي',
                'status' => 'completed',
                'delivery_mode' => 'online',
                'sort_order' => 10,
                'is_published' => true,
            ],
        ];

        foreach ($programs as $prog) {
            Program::updateOrCreate(['slug' => $prog['slug']], $prog);
        }

        // 6. Program Phases (The 6 phases from files)
        $phases = [
            [
                'phase_number' => 1,
                'title' => 'الإعداد والتأسيس',
                'duration' => '3 أشهر',
                'objectives' => 'بناء البنية التنظيمية، إعداد الحقائب التدريبية، وبناء الهوية والمنصات.',
                'tasks' => 'إعداد المحتوى التدريبي، استكمال أطر العمل، تجهيز المتطلبات اللوجستية والتقنية.',
                'deliverables' => 'حقائب تدريبية معتمدة، منصة تدريبية، مواد تعريفية متكاملة.',
                'sort_order' => 1,
                'is_published' => true,
            ],
            [
                'phase_number' => 2,
                'title' => 'الإطلاق والتفعيل',
                'duration' => 'شهران',
                'objectives' => 'إطلاق الحملات التعريفية واستقطاب المستفيدين والشركاء الأوليين.',
                'tasks' => 'إطلاق حملات التوعية الرقمية، فتح باب التسجيل في البرامج، عقد اللقاءات التمهيدية.',
                'deliverables' => 'قاعدة مستفيدين مسجلين، تفعيل القنوات الرقمية والتفاعلية.',
                'sort_order' => 2,
                'is_published' => true,
            ],
            [
                'phase_number' => 3,
                'title' => 'التنفيذ الأساسي',
                'duration' => '6 أشهر',
                'objectives' => 'تقديم البرامج التدريبية وورش العمل التفاعلية وقياس الحضور والتفاعل.',
                'tasks' => 'تنفيذ الجلسات وورش العمل، توزيع النماذج التطبيقية، تقديم الإرشاد المالي المباشر.',
                'deliverables' => 'إكمال البرامج التدريبية المجدولة، وتوزيع الأدوات التطبيقية للمستفيدين.',
                'sort_order' => 3,
                'is_published' => true,
            ],
            [
                'phase_number' => 4,
                'title' => 'المتابعة وتثبيت السلوك',
                'duration' => '3 أشهر',
                'objectives' => 'متابعة تطبيق المستفيدين للأدوات المالية والتأكد من استدامة العادات الرشيدة.',
                'tasks' => 'تقديم جلسات متابعة دورية، مراجعة ميزانيات المستفيدين، رصد التحديات ومعالجتها.',
                'deliverables' => 'تقارير متابعة فردية وجماعية تثبت التغيير السلوكي العملي.',
                'sort_order' => 4,
                'is_published' => true,
            ],
            [
                'phase_number' => 5,
                'title' => 'التقييم والتطوير',
                'duration' => 'شهران',
                'objectives' => 'قياس الأثر المجتمعي للمبادرة واستطلاع آراء المستفيدين وتحسين المحتوى.',
                'tasks' => 'توزيع استبانات قياس الأثر، تحليل البيانات الإحصائية، تحديث المناهج التدريبية.',
                'deliverables' => 'تقرير أثر شامل يوثق مخرجات المبادرة والدروس المستفادة.',
                'sort_order' => 5,
                'is_published' => true,
            ],
            [
                'phase_number' => 6,
                'title' => 'الاستدامة والتوسع',
                'duration' => 'مستمر',
                'objectives' => 'بناء شراكات مستدامة مع القطاعات المختلفة وتوسيع نطاق المبادرة جغرافياً.',
                'tasks' => 'توقيع اتفاقيات تعاون، إطلاق نسخ متقدمة من البرامج، وتدريب مدربين معتمدين.',
                'deliverables' => 'شبكة شراكات فاعلة، وانتشار أوسع لبرامج التوعية المالية.',
                'sort_order' => 6,
                'is_published' => true,
            ],
        ];

        foreach ($phases as $ph) {
            ProgramPhase::updateOrCreate(['phase_number' => $ph['phase_number']], $ph);
        }

        // 7. Roadmap Steps (6 Steps from files)
        $roadmapSteps = [
            [
                'step_number' => 1,
                'title' => 'تحديد الوضع المالي الحالي',
                'description' => 'حصر شامل وصادق لجميع مصادر الدخل، وكافة النفقات والديون والالتزامات المالية لمعرفة نقطة الانطلاق الحقيقية.',
                'icon' => 'magnifying-glass',
                'sort_order' => 1,
                'is_published' => true,
            ],
            [
                'step_number' => 2,
                'title' => 'وضع الأهداف المالية',
                'description' => 'صياغة أهداف واضحة وواقعية وقابلة للقياس (قصيرة ومتوسطة وطويلة المدى) مثل سداد دين أو بناء صندوق طوارئ.',
                'icon' => 'flag',
                'sort_order' => 2,
                'is_published' => true,
            ],
            [
                'step_number' => 3,
                'title' => 'تحديد البدائل والخيارات',
                'description' => 'استكشاف سبل متعددة للوصول إلى الهدف، كتقليص بنود استهلاكية محددة، أو البحث عن مصدر دخل إضافي.',
                'icon' => 'arrows-pointing-out',
                'sort_order' => 3,
                'is_published' => true,
            ],
            [
                'step_number' => 4,
                'title' => 'تقييم البدائل واختيار الأنسب',
                'description' => 'الموازنة بين العائد والمخاطرة والجهد لكل بديل واختيار الخيار الأكثر ملاءمة لظروفك وظروف أسرتك.',
                'icon' => 'scale',
                'sort_order' => 4,
                'is_published' => true,
            ],
            [
                'step_number' => 5,
                'title' => 'إعداد الخطة المالية وتنفيذها',
                'description' => 'ترجمة الاختيارات إلى ميزانية شهرية مجدولة والالتزام بالصرف والادخار وفق النسب المحددة مسبقاً.',
                'icon' => 'document-check',
                'sort_order' => 5,
                'is_published' => true,
            ],
            [
                'step_number' => 6,
                'title' => 'إعادة تقييم الخطة وتحديثها',
                'description' => 'مراجعة دورية منتظمة (شهرية أو ربع سنوية) لقياس التقدم وتعديل الخطة بحسب المتغيرات والمستجدات.',
                'icon' => 'arrow-path',
                'sort_order' => 6,
                'is_published' => true,
            ],
        ];

        foreach ($roadmapSteps as $st) {
            RoadmapStep::updateOrCreate(['step_number' => $st['step_number']], $st);
        }

        // 8. Verified Impact Metrics
        $metrics = [
            [
                'title' => 'عدد المستفيدين من المبادرة',
                'metric_value' => '200',
                'metric_suffix' => 'مستفيد',
                'description' => 'بدأ عدد المستفيدين من 30 ووصل إلى 200 مستفيد من مختلف أنحاء الوطن العربي',
                'icon' => 'users',
                'last_updated_date' => now()->subMonths(1),
                'sort_order' => 1,
                'is_published' => true,
            ],
            [
                'title' => 'البرامج التوعوية المطروحة',
                'metric_value' => '10',
                'metric_suffix' => 'برامج تدريبية',
                'description' => 'برامج متخصصة تستهدف الأفراد والأسر والشباب والناشئة',
                'icon' => 'academic-cap',
                'last_updated_date' => now()->subMonths(1),
                'sort_order' => 2,
                'is_published' => true,
            ],
            [
                'title' => 'محاور التمكين المالي المعتمدة',
                'metric_value' => '6',
                'metric_suffix' => 'محاور متكاملة',
                'description' => 'تغطي الدخل والمصروفات والادخار وإدارة الديون والأسرة والاستثمار الواعي',
                'icon' => 'briefcase',
                'last_updated_date' => now()->subMonths(1),
                'sort_order' => 3,
                'is_published' => true,
            ],
        ];

        foreach ($metrics as $m) {
            Achievement::updateOrCreate(['title' => $m['title']], $m);
        }

        // 9. Initial Testimonials as DRAFTS (is_published = false) as strictly instructed
        Testimonial::firstOrCreate(
            ['author_name' => 'مشارك في برامج نبض'],
            [
                'city_country' => 'المملكة العربية السعودية',
                'content' => 'استفدت بشكل كبير من ورش إدارة الدخل، وتعلمت كيفية التفرقة بين الرغبات والاحتياجات، ووضعت أول خطة ادخارية عملية لأسرتي.',
                'rating' => 5,
                'sort_order' => 1,
                'is_published' => false, // DRAFT until approved
            ]
        );

        // 10. Initial Team Member draft
        TeamMember::firstOrCreate(
            ['name' => 'فريق نبض للتوعية المالية'],
            [
                'role' => 'إدارة المبادرة والتطوير',
                'bio' => 'مجموعة من المتخصصين والمهتمين بالتمكين المالي والمسؤولية المجتمعية.',
                'sort_order' => 1,
                'is_published' => false, // DRAFT until approved
            ]
        );

        // 11. Initial Partner draft
        Partner::firstOrCreate(
            ['name' => 'شركاء ورعاة برامج نبض'],
            [
                'type' => 'شريك استراتيجي',
                'sort_order' => 1,
                'is_published' => false, // DRAFT until approved
            ]
        );
    }
}
