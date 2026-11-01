<!DOCTYPE html>
<html lang="ar" dir="rtl" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- SEO Meta Tags -->
    <title>@yield('title', $settings->site_title ?? 'نبض للتوعية المالية | طريقك نحو النجاح المالي')</title>
    <meta name="description" content="@yield('meta_description', $settings->meta_description ?? 'مبادرة نبض للتوعية والتمكين المالي للأفراد والأسرة - وعي.. مال.. أسرة')">
    <meta name="keywords" content="{{ $settings->keywords ?? 'وعي مالي, تمكين مالي, تخطيط مالي, ادخار, استثمار واعي, نبض للتوعية المالية' }}">
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Open Graph / Social Media -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', $settings->site_title ?? 'نبض للتوعية المالية')">
    <meta property="og:description" content="@yield('meta_description', $settings->meta_description ?? 'طريقك نحو النجاح المالي - وعي.. مال.. أسرة')">
    @if (!empty($settings->og_image_path))
        <meta property="og:image" content="{{ asset('images/logo.png') }}">
    @else
        <meta property="og:image" content="{{ asset('images/logo.png') }}">
    @endif

    <!-- Twitter Cards -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', $settings->site_title ?? 'نبض للتوعية المالية')">
    <meta name="twitter:description" content="@yield('meta_description', $settings->meta_description ?? 'طريقك نحو النجاح المالي')">

    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800;900&family=IBM+Plex+Sans+Arabic:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Styles & Scripts via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --primary-navy: {{ $settings->primary_color ?? '#1e3a8a' }};
            --accent-gold: {{ $settings->accent_color ?? '#eab308' }};
            --secondary-royal: {{ $settings->secondary_color ?? '#2563eb' }};
            --secondary-turquoise: {{ $settings->turquoise_color ?? '#0d9488' }};
            --font-family-site: '{{ $settings->font_family ?? 'Cairo' }}', system-ui, sans-serif;
        }
        body {
            font-family: var(--font-family-site);
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased selection:bg-amber-400 selection:text-slate-900">

    <!-- Header Navigation -->
    <header class="fixed top-0 inset-x-0 z-50 transition-all duration-300 glass-nav shadow-lg border-b border-slate-700/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">

                <!-- Logo & Brand Name -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 group focus:outline-none focus:ring-2 focus:ring-amber-400 rounded-lg p-1">
                    @if (!empty($settings->logo_path))
                        <img src="{{ asset('storage/' . $settings->logo_path) }}" alt="{{ $settings->initiative_name }}" class="h-12 w-auto object-contain">
                    @else
                        <!-- Typographic Brand Mark with Pulse Curve -->
                        <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-amber-400 via-amber-500 to-amber-600 flex items-center justify-center text-slate-900 shadow-md shadow-amber-500/20 group-hover:scale-105 transition-transform">
                            <svg class="w-6 h-6 animate-pulse-slow text-slate-950" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                    @endif
                    <div class="flex flex-col">
                        <span class="text-xl font-bold tracking-tight text-white group-hover:text-amber-400 transition-colors">
                            {{ $settings->initiative_name ?? 'نبض للتوعية المالية' }}
                        </span>
                        <span class="text-xs text-amber-400 font-medium tracking-wide">
                            {{ $settings->slogan ?? 'طريقك نحو النجاح المالي' }}
                        </span>
                    </div>
                </a>

                <!-- Desktop Navigation Menu -->
                <nav class="hidden lg:flex items-center gap-6">
                    <a href="{{ route('home') }}#hero" class="text-sm font-medium text-slate-200 hover:text-amber-400 transition-colors">الرئيسية</a>
                    <a href="{{ route('home') }}#about" class="text-sm font-medium text-slate-200 hover:text-amber-400 transition-colors">عن المبادرة</a>
                    <a href="{{ route('home') }}#pillars" class="text-sm font-medium text-slate-200 hover:text-amber-400 transition-colors">المحاور</a>
                    <a href="{{ route('home') }}#programs" class="text-sm font-medium text-slate-200 hover:text-amber-400 transition-colors">البرامج</a>
                    <a href="{{ route('home') }}#achievements" class="text-sm font-medium text-slate-200 hover:text-amber-400 transition-colors">الإنجازات</a>
                    @if ($settings->show_phases_section)
                        <a href="{{ route('home') }}#phases" class="text-sm font-medium text-slate-200 hover:text-amber-400 transition-colors">المراحل</a>
                    @endif
                    <a href="{{ route('home') }}#roadmap" class="text-sm font-medium text-slate-200 hover:text-amber-400 transition-colors">خارطة التخطيط</a>
                    <a href="{{ route('home') }}#partnerships" class="text-sm font-medium text-slate-200 hover:text-amber-400 transition-colors">الشراكات</a>
                    <a href="{{ route('home') }}#contact" class="text-sm font-medium text-slate-200 hover:text-amber-400 transition-colors">تواصل معنا</a>
                </nav>

                <!-- Header Actions (CTA) -->
                <div class="hidden sm:flex items-center gap-3">
                    @if (!empty($settings->whatsapp_channel_url))
                        <a href="{{ $settings->whatsapp_channel_url }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-semibold bg-emerald-600/90 text-white hover:bg-emerald-500 transition-all shadow-sm shadow-emerald-900/20">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86.174.086.275.072.376-.043.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564.289.13.332.202c.045.072.045.419-.099.824zm-3.423-14.416c-6.627 0-12 5.373-12 12 0 2.155.57 4.178 1.564 5.928l-1.636 5.975 6.136-1.61c1.693.923 3.633 1.457 5.702 1.457 6.627 0 12-5.373 12-12 0-6.627-5.373-12-12-12z"/></svg>
                            قناة واتساب
                        </a>
                    @endif

                    <a href="{{ route('home') }}#contact" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-bold bg-amber-400 text-slate-950 hover:bg-amber-300 transition-all shadow-md shadow-amber-500/20 hover:scale-[1.02]">
                        {{ $settings->header_cta_text ?? 'تواصل معنا' }}
                    </a>
                </div>

                <!-- Mobile Menu Button (Hamburger) -->
                <div class="flex lg:hidden items-center">
                    <button id="mobile-menu-btn" type="button" class="p-2 rounded-xl text-slate-300 hover:text-white hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-amber-400" aria-label="فتح القائمة">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path id="hamburger-icon" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path id="close-icon" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Drawer -->
        <div id="mobile-menu" class="hidden lg:hidden bg-slate-900/95 border-b border-slate-800 px-4 pt-3 pb-6 space-y-3 shadow-2xl">
            <a href="{{ route('home') }}#hero" class="mobile-nav-link block px-3 py-2 rounded-lg text-base font-medium text-slate-200 hover:text-amber-400 hover:bg-slate-800">الرئيسية</a>
            <a href="{{ route('home') }}#about" class="mobile-nav-link block px-3 py-2 rounded-lg text-base font-medium text-slate-200 hover:text-amber-400 hover:bg-slate-800">عن المبادرة</a>
            <a href="{{ route('home') }}#pillars" class="mobile-nav-link block px-3 py-2 rounded-lg text-base font-medium text-slate-200 hover:text-amber-400 hover:bg-slate-800">المحاور</a>
            <a href="{{ route('home') }}#programs" class="mobile-nav-link block px-3 py-2 rounded-lg text-base font-medium text-slate-200 hover:text-amber-400 hover:bg-slate-800">البرامج</a>
            <a href="{{ route('home') }}#achievements" class="mobile-nav-link block px-3 py-2 rounded-lg text-base font-medium text-slate-200 hover:text-amber-400 hover:bg-slate-800">الإنجازات</a>
            @if ($settings->show_phases_section)
                <a href="{{ route('home') }}#phases" class="mobile-nav-link block px-3 py-2 rounded-lg text-base font-medium text-slate-200 hover:text-amber-400 hover:bg-slate-800">المراحل</a>
            @endif
            <a href="{{ route('home') }}#roadmap" class="mobile-nav-link block px-3 py-2 rounded-lg text-base font-medium text-slate-200 hover:text-amber-400 hover:bg-slate-800">خارطة التخطيط</a>
            <a href="{{ route('home') }}#partnerships" class="mobile-nav-link block px-3 py-2 rounded-lg text-base font-medium text-slate-200 hover:text-amber-400 hover:bg-slate-800">الشراكات</a>
            <a href="{{ route('home') }}#contact" class="mobile-nav-link block px-3 py-2 rounded-lg text-base font-medium text-slate-200 hover:text-amber-400 hover:bg-slate-800">تواصل معنا</a>

            <div class="pt-4 border-t border-slate-800 flex flex-col gap-2">
                @if (!empty($settings->whatsapp_channel_url))
                    <a href="{{ $settings->whatsapp_channel_url }}" target="_blank" rel="noopener noreferrer" class="w-full text-center py-2.5 rounded-xl text-sm font-semibold bg-emerald-600 text-white">
                        انضم لقناة واتساب
                    </a>
                @endif
                <a href="{{ route('home') }}#contact" class="w-full text-center py-2.5 rounded-xl text-sm font-bold bg-amber-400 text-slate-950">
                    {{ $settings->header_cta_text ?? 'تواصل معنا' }}
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="pt-20">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-slate-950 text-slate-400 border-t border-slate-800 pt-16 pb-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 mb-12">

                <!-- Col 1: Brand Info -->
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        @if (!empty($settings->footer_logo_path))
                            <img src="{{ asset('storage/' . $settings->footer_logo_path) }}" alt="{{ $settings->initiative_name }}" class="h-10 w-auto">
                        @else
                            <div class="w-9 h-9 rounded-lg bg-amber-400 flex items-center justify-center text-slate-950 font-black text-lg">
                                ن
                            </div>
                        @endif
                        <span class="text-xl font-bold text-white">{{ $settings->initiative_name ?? 'نبض للتوعية المالية' }}</span>
                    </div>
                    <p class="text-sm text-slate-400 leading-relaxed">
                        {{ $settings->slogan ?? 'طريقك نحو النجاح المالي' }} - وعي.. مال.. أسرة. مبادرة مجتمعية متخصصة في رفع الوعي والتمكين المالي للأفراد والأسر وتحقيق الاستقرار السلوكي المستدام.
                    </p>
                    <div class="pt-2">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-slate-800 text-emerald-400 border border-slate-700">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                            متوافق مع مستهدفات رؤية 2030
                        </span>
                    </div>
                </div>

                <!-- Col 2: Quick Links -->
                @if ($settings->show_footer_quick_links)
                <div>
                    <h3 class="text-base font-semibold text-white mb-4 border-r-2 border-amber-400 pr-2">روابط سريعة</h3>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="{{ route('home') }}#about" class="hover:text-amber-400 transition-colors">عن المبادرة وأهدافها</a></li>
                        <li><a href="{{ route('home') }}#pillars" class="hover:text-amber-400 transition-colors">محاور التمكين المالي</a></li>
                        <li><a href="{{ route('home') }}#programs" class="hover:text-amber-400 transition-colors">البرامج التدريبية والتوعوية</a></li>
                        <li><a href="{{ route('home') }}#roadmap" class="hover:text-amber-400 transition-colors">خارطة التخطيط المالي</a></li>
                        <li><a href="{{ route('home') }}#achievements" class="hover:text-amber-400 transition-colors">مؤشرات الأثر والإنجاز</a></li>
                        <li><a href="{{ route('home') }}#partnerships" class="hover:text-amber-400 transition-colors">طلب شراكة أو رعاية</a></li>
                        <li><a href="{{ route('privacy') }}" class="hover:text-amber-400 transition-colors">سياسة الخصوصية والاستخدام</a></li>
                    </ul>
                </div>
                @endif

                <!-- Col 3: Official Contact Info -->
                <div>
                    <h3 class="text-base font-semibold text-white mb-4 border-r-2 border-amber-400 pr-2">معلومات التواصل</h3>
                    <ul class="space-y-3 text-sm">
                        @if (!empty($settings->contact_email))
                            <li class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-amber-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                <a href="mailto:{{ $settings->contact_email }}" class="hover:text-amber-400 transition-colors" dir="ltr">{{ $settings->contact_email }}</a>
                            </li>
                        @endif

                        @if (!empty($settings->contact_phone))
                            <li class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-amber-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                <a href="tel:{{ $settings->contact_phone }}" class="hover:text-amber-400 transition-colors" dir="ltr">{{ $settings->contact_phone }}</a>
                            </li>
                        @endif

                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-emerald-400 shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86.174.086.275.072.376-.043.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564.289.13.332.202c.045.072.045.419-.099.824zm-3.423-14.416c-6.627 0-12 5.373-12 12 0 2.155.57 4.178 1.564 5.928l-1.636 5.975 6.136-1.61c1.693.923 3.633 1.457 5.702 1.457 6.627 0 12-5.373 12-12 0-6.627-5.373-12-12-12z"/></svg>
                            <span>خدمة المستفيدين عبر واتساب المعتمد</span>
                        </li>
                    </ul>
                </div>

                <!-- Col 4: Community & Official Channels -->
                @if ($settings->show_footer_social)
                <div>
                    <h3 class="text-base font-semibold text-white mb-4 border-r-2 border-amber-400 pr-2">المجتمعات والقنوات الرسمية</h3>
                    <p class="text-sm text-slate-400 mb-4 leading-relaxed">
                        انضم إلى قنوات المبادرة لتصلك الورش المجانية، والمواد التوعوية، واستشارات إدارة الميزانية.
                    </p>
                    <div class="flex flex-col gap-2.5">
                        @if (!empty($settings->whatsapp_channel_url))
                            <a href="{{ $settings->whatsapp_channel_url }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-between px-3.5 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-xs text-slate-200 border border-slate-800 hover:border-emerald-500 transition-colors">
                                <span class="flex items-center gap-2.5">
                                    <i class="fa-brands fa-whatsapp text-emerald-400 text-base"></i>
                                    قناة واتساب الرسمية
                                </span>
                                <span class="text-emerald-400 font-semibold flex items-center gap-1">متابعة <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i></span>
                            </a>
                        @endif

                        @if (!empty($settings->telegram_channel_url))
                            <a href="{{ $settings->telegram_channel_url }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-between px-3.5 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-xs text-slate-200 border border-slate-800 hover:border-sky-500 transition-colors">
                                <span class="flex items-center gap-2.5">
                                    <i class="fa-brands fa-telegram text-sky-400 text-base"></i>
                                    قناة تيليجرام
                                </span>
                                <span class="text-sky-400 font-semibold flex items-center gap-1">اشتراك <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i></span>
                            </a>
                        @endif

                        @if (!empty($settings->whatsapp_group_url))
                            <a href="{{ $settings->whatsapp_group_url }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-between px-3.5 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-xs text-slate-200 border border-slate-800 hover:border-emerald-500 transition-colors">
                                <span class="flex items-center gap-2.5">
                                    <i class="fa-solid fa-users text-emerald-400 text-sm"></i>
                                    مجموعة واتساب التفاعلية
                                </span>
                                <span class="text-emerald-400 font-semibold flex items-center gap-1">انضمام <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i></span>
                            </a>
                        @endif

                        @if (!empty($settings->linkjar_url))
                            <a href="{{ $settings->linkjar_url }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-between px-3.5 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-xs text-slate-200 border border-slate-800 hover:border-amber-400 transition-colors">
                                <span class="flex items-center gap-2.5">
                                    <i class="fa-solid fa-link text-amber-400 text-sm"></i>
                                    مجمع الحسابات (Linkjar)
                                </span>
                                <span class="text-amber-400 font-semibold flex items-center gap-1">زيارة <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i></span>
                            </a>
                        @endif
                    </div>
                </div>
                @endif

            </div>

            <!-- Bottom Copyright & Admin Link -->
            <div class="border-t border-slate-900 pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-400">
                <p>
                    {{ $settings->copyright_text ?? ('جميع الحقوق محفوظة لمبادرة نبض للتوعية المالية © ' . date('Y')) }}
                </p>
                <div class="flex items-center gap-4">
                    <a href="{{ route('privacy') }}" class="hover:text-slate-300 transition-colors">الخصوصية والشروط</a>
                    <span>•</span>
                    <a href="{{ url('/admin') }}" target="_blank" class="text-slate-400 hover:text-amber-400 transition-colors flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        لوحة التحكم
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Interactive Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Mobile Menu Toggle
            const btn = document.getElementById('mobile-menu-btn');
            const menu = document.getElementById('mobile-menu');
            const hamburgerIcon = document.getElementById('hamburger-icon');
            const closeIcon = document.getElementById('close-icon');

            if (btn && menu) {
                btn.addEventListener('click', function () {
                    menu.classList.toggle('hidden');
                    hamburgerIcon.classList.toggle('hidden');
                    closeIcon.classList.toggle('hidden');
                });

                // Close mobile menu on clicking any navigation link
                document.querySelectorAll('.mobile-nav-link').forEach(link => {
                    link.addEventListener('click', () => {
                        menu.classList.add('hidden');
                        hamburgerIcon.classList.remove('hidden');
                        closeIcon.classList.add('hidden');
                    });
                });
            }

            // Smooth header elevation on scroll
            const header = document.querySelector('header');
            window.addEventListener('scroll', () => {
                if (window.scrollY > 20) {
                    header.classList.add('shadow-xl', 'bg-slate-950/95');
                } else {
                    header.classList.remove('shadow-xl');
                }
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
