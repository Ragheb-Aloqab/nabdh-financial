@extends('layouts.app')

@section('title', $settings->site_title ?? 'نبض للتوعية المالية | طريقك نحو النجاح المالي')
@section('meta_description', $settings->meta_description ?? 'مبادرة نبض للتوعية والتمكين المالي للأفراد والأسرة - وعي.. مال.. أسرة')

@section('content')

    {{-- Alert Messages for Forms --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
        @if (session('contact_success'))
            <div id="contact-alert" class="p-4 mb-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-900 shadow-sm flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <svg class="w-6 h-6 text-emerald-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span class="font-semibold text-sm">{{ session('contact_success') }}</span>
                </div>
                <button type="button" onclick="document.getElementById('contact-alert').remove()" class="text-emerald-700 hover:text-emerald-900">&times;</button>
            </div>
        @endif

        @if (session('partnership_success'))
            <div id="partnership-alert" class="p-4 mb-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-900 shadow-sm flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <svg class="w-6 h-6 text-emerald-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span class="font-semibold text-sm">{{ session('partnership_success') }}</span>
                </div>
                <button type="button" onclick="document.getElementById('partnership-alert').remove()" class="text-emerald-700 hover:text-emerald-900">&times;</button>
            </div>
        @endif

        @if ($errors->any())
            <div class="p-4 mb-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-900 shadow-sm">
                <p class="font-bold text-sm mb-1">يرجى التحقق من المدخلات التالية:</p>
                <ul class="list-disc list-inside text-xs space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    {{-- SECTION 1: HERO / MAIN SECTION --}}
    @if(isset($sections['hero']) && $sections['hero']->is_visible)
    <section id="hero" class="relative overflow-hidden bg-gradient-to-b from-slate-950 via-slate-900 to-slate-900 text-white py-24 lg:py-32 border-b border-slate-800">
        <!-- Background Decorative Accents -->
        <div class="absolute inset-0 pointer-events-none opacity-20">
            <div class="absolute top-1/4 -right-20 w-96 h-96 bg-amber-400 rounded-full blur-3xl"></div>
            <div class="absolute bottom-10 -left-20 w-96 h-96 bg-blue-600 rounded-full blur-3xl"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">

                <!-- Text Content -->
                <div class="lg:col-span-7 space-y-6 text-center lg:text-right">
                    @if (!empty($sections['hero']->badge))
                        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-slate-800/80 border border-amber-400/40 text-amber-400 text-xs sm:text-sm font-semibold tracking-wide backdrop-blur-sm shadow-sm">
                            <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
                            {{ $sections['hero']->badge }}
                        </div>
                    @endif

                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-white tracking-tight leading-tight">
                        {{ $sections['hero']->title }}
                    </h1>

                    @if (!empty($sections['hero']->subtitle))
                        <p class="text-xl sm:text-2xl font-bold text-amber-400">
                            {{ $sections['hero']->subtitle }}
                        </p>
                    @endif

                    <div class="text-slate-300 text-base sm:text-lg leading-relaxed max-w-2xl mx-auto lg:mx-0 prose-nabdh">
                        @cleanHtml($sections['hero']->content)
                    </div>

                    <!-- Call To Action Buttons -->
                    <div class="flex flex-wrap items-center justify-center lg:justify-start gap-4 pt-4">
                        @if (!empty($sections['hero']->button_text))
                            <a href="{{ $sections['hero']->button_url ?? '#about' }}" class="inline-flex items-center justify-center px-7 py-3.5 rounded-xl font-bold text-slate-950 bg-amber-400 hover:bg-amber-300 transition-all shadow-lg shadow-amber-500/25 hover:scale-105 active:scale-95 text-base">
                                {{ $sections['hero']->button_text }}
                                <svg class="w-5 h-5 mr-2 -scale-x-100" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </a>
                        @endif

                        @if (!empty($sections['hero']->secondary_button_text))
                            <a href="{{ $sections['hero']->secondary_button_url ?? '#programs' }}" class="inline-flex items-center justify-center px-7 py-3.5 rounded-xl font-bold text-white bg-slate-800/90 hover:bg-slate-700 border border-slate-700 hover:border-amber-400/50 transition-all shadow-md hover:scale-105 active:scale-95 text-base">
                                {{ $sections['hero']->secondary_button_text }}
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Visual Card Element with Brand Metrics -->
                <div class="lg:col-span-5">
                    <div class="relative mx-auto max-w-md lg:max-w-none">
                        <!-- Gradient Glow -->
                        <div class="absolute -inset-1 rounded-3xl bg-gradient-to-r from-amber-400 to-blue-600 opacity-30 blur-xl"></div>

                        <div class="relative bg-slate-900/90 border border-slate-800 rounded-3xl p-8 shadow-2xl backdrop-blur-md">
                            <div class="flex items-center justify-between border-b border-slate-800 pb-6 mb-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 rounded-2xl bg-amber-400/10 border border-amber-400/30 flex items-center justify-center text-amber-400">
                                        <svg class="w-7 h-7 animate-pulse-slow" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h2 class="text-lg font-bold text-white">نبض للتوعية المالية</h2>
                                        <span class="text-xs text-amber-400 font-semibold">تغيير سلوكي مستدام</span>
                                    </div>
                                </div>
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                    معتمد
                                </span>
                            </div>

                            <!-- Highlights -->
                            <div class="space-y-4">
                                <div class="p-4 rounded-2xl bg-slate-800/50 border border-slate-700/50 flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-blue-500/10 text-blue-400 flex items-center justify-center">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                        </div>
                                        <div>
                                            <p class="text-xs text-slate-400 font-medium">عدد المستفيدين الموثق</p>
                                            <p class="text-base font-bold text-white">200 مستفيد بالوطن العربي</p>
                                        </div>
                                    </div>
                                    <span class="text-amber-400 font-bold text-sm">بدأ من 30</span>
                                </div>

                                <div class="p-4 rounded-2xl bg-slate-800/50 border border-slate-700/50 flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-amber-500/10 text-amber-400 flex items-center justify-center">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                        </div>
                                        <div>
                                            <p class="text-xs text-slate-400 font-medium">البرامج التوعوية المطروحة</p>
                                            <p class="text-base font-bold text-white">10 برامج تطبيقية</p>
                                        </div>
                                    </div>
                                    <span class="text-emerald-400 font-bold text-sm">تطبيقية</span>
                                </div>

                                <div class="p-4 rounded-2xl bg-slate-800/50 border border-slate-700/50 flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-emerald-500/10 text-emerald-400 flex items-center justify-center">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                        </div>
                                        <div>
                                            <p class="text-xs text-slate-400 font-medium">محاور التمكين المالي</p>
                                            <p class="text-base font-bold text-white">6 محاور رئيسية شاملة</p>
                                        </div>
                                    </div>
                                    <span class="text-blue-400 font-bold text-sm">شاملة</span>
                                </div>
                            </div>

                            <div class="mt-6 pt-4 border-t border-slate-800 text-center">
                                <a href="#programs" class="text-xs text-slate-400 hover:text-amber-400 transition-colors inline-flex items-center gap-1 font-semibold">
                                    استكشف البرامج المتاحة حالياً
                                    <span class="text-amber-400">←</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    @endif

    {{-- SECTION 2: ABOUT SECTION --}}
    @if(isset($sections['about']) && $sections['about']->is_visible)
    <section id="about" class="py-20 lg:py-28 bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">

                <!-- Side Infographic Cards -->
                <div class="lg:col-span-5 order-2 lg:order-1">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 hover:border-amber-400 transition-all shadow-sm group">
                            <div class="w-12 h-12 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </div>
                            <h2 class="text-base font-bold text-slate-900 mb-2">رؤيتنا</h2>
                            <p class="text-xs text-slate-600 leading-relaxed">مجتمع واعٍ مالياً، يمتلك أفراده وأسره المهارات اللازمة للإدارة المالية الرشيدة وبناء مستقبل مستقر.</p>
                        </div>

                        <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 hover:border-blue-400 transition-all shadow-sm group">
                            <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            </div>
                            <h2 class="text-base font-bold text-slate-900 mb-2">رسالتنا</h2>
                            <p class="text-xs text-slate-600 leading-relaxed">تقديم برامج نوعية وتوعوية تطبيقية قابلة للقياس، تُحدث تغييراً سلوكياً إيجابياً ومستداماً في إدارة المال.</p>
                        </div>

                        <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 hover:border-emerald-400 transition-all shadow-sm group sm:col-span-2">
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <div>
                                    <h2 class="text-base font-bold text-slate-900 mb-1">التمكين المالي للأسرة</h2>
                                    <p class="text-xs text-slate-600 leading-relaxed">«وعي.. مال.. أسرة» هو الشعار الذي ننطلق منه لحماية الأسرة من الهدر المالي والديون، ونقلها نحو الادخار والاستثمار الواعي.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Text Presentation -->
                <div class="lg:col-span-7 space-y-6 order-1 lg:order-2">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-slate-100 text-slate-800 text-xs font-bold border border-slate-300">
                        {{ $sections['about']->badge ?? 'التعريف بالمبادرة' }}
                    </div>

                    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 leading-tight">
                        {{ $sections['about']->title }}
                    </h2>

                    @if(!empty($sections['about']->subtitle))
                        <p class="text-lg font-bold text-amber-600">
                            {{ $sections['about']->subtitle }}
                        </p>
                    @endif

                    <div class="text-slate-600 leading-relaxed text-base space-y-4 prose-nabdh">
                        @cleanHtml($sections['about']->content)
                    </div>

                    <div class="flex flex-wrap items-center gap-4 pt-4">
                        @if (!empty($sections['about']->button_text))
                            <a href="{{ $sections['about']->button_url ?? '#pillars' }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl font-bold text-white bg-slate-900 hover:bg-slate-800 transition-colors shadow-sm text-sm">
                                {{ $sections['about']->button_text }}
                                <span>←</span>
                            </a>
                        @endif

                        @if (!empty($sections['about']->secondary_button_text))
                            <a href="{{ $sections['about']->secondary_button_url ?? '#roadmap' }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 transition-colors text-sm">
                                {{ $sections['about']->secondary_button_text }}
                            </a>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </section>
    @endif

    {{-- SECTION 3: PILLARS & OBJECTIVES --}}
    @if(isset($sections['pillars']) && $sections['pillars']->is_visible)
    <section id="pillars" class="py-20 lg:py-28 bg-slate-50 border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16 space-y-3">
                <span class="inline-block px-3 py-1 rounded-full bg-amber-100 text-amber-800 text-xs font-bold border border-amber-300">
                    {{ $sections['pillars']->badge ?? 'المحاور الأساسية' }}
                </span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900">
                    {{ $sections['pillars']->title }}
                </h2>
                @if(!empty($sections['pillars']->subtitle))
                    <p class="text-base text-slate-600">
                        {{ $sections['pillars']->subtitle }}
                    </p>
                @endif
            </div>

            <!-- Pillars Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($pillars as $pillar)
                    <div class="p-8 rounded-3xl bg-white border border-slate-200 hover:border-amber-400 hover:shadow-xl transition-all duration-300 flex flex-col justify-between group">
                        <div>
                            <div class="w-14 h-14 rounded-2xl bg-amber-50 group-hover:bg-amber-400 text-slate-900 flex items-center justify-center mb-6 transition-colors shadow-sm">
                                @if($pillar->icon === 'currency-dollar')
                                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                @elseif($pillar->icon === 'scale')
                                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/></svg>
                                @elseif($pillar->icon === 'chart-bar')
                                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                                @elseif($pillar->icon === 'shield-check')
                                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                @elseif($pillar->icon === 'home')
                                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                @else
                                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                                @endif
                            </div>

                            <h3 class="text-xl font-bold text-slate-900 mb-3 group-hover:text-amber-600 transition-colors">
                                {{ $pillar->title }}
                            </h3>

                            <p class="text-sm text-slate-600 leading-relaxed mb-6">
                                {{ $pillar->short_description }}
                            </p>
                        </div>

                        <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400 font-semibold">
                            <span>محور تمكين معتمد</span>
                            <span class="text-amber-500 font-bold">#{{ $pillar->sort_order }}</span>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center py-12 text-slate-500">
                        لا توجد محاور منشورة حالياً.
                    </div>
                @endforelse
            </div>
        </div>
    </section>
    @endif

    {{-- SECTION 4: PROGRAMS SECTION --}}
    @if(isset($sections['programs']) && $sections['programs']->is_visible)
    <section id="programs" class="py-20 lg:py-28 bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16 space-y-3">
                <span class="inline-block px-3 py-1 rounded-full bg-blue-100 text-blue-800 text-xs font-bold border border-blue-300">
                    {{ $sections['programs']->badge ?? 'البرامج التدريبية' }}
                </span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900">
                    {{ $sections['programs']->title }}
                </h2>
                @if(!empty($sections['programs']->subtitle))
                    <p class="text-base text-slate-600">
                        {{ $sections['programs']->subtitle }}
                    </p>
                @endif
            </div>

            <!-- Programs Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($programs as $program)
                    <div class="rounded-3xl bg-slate-50 border border-slate-200 overflow-hidden hover:shadow-xl transition-all duration-300 flex flex-col justify-between group hover:border-amber-400">
                        <div>
                            <!-- Program Card Header with Badge -->
                            <div class="p-6 bg-gradient-to-r from-slate-900 to-slate-800 text-white relative">
                                <div class="flex items-center justify-between mb-3">
                                    <span class="px-3 py-1 rounded-full text-xs font-bold {{ $program->status === 'open' ? 'bg-emerald-500 text-slate-950' : 'bg-slate-700 text-amber-400' }}">
                                        {{ $program->status_label }}
                                    </span>
                                    <span class="text-xs text-slate-300 bg-slate-800/80 px-2.5 py-1 rounded-md border border-slate-700">
                                        {{ $program->delivery_mode_label }}
                                    </span>
                                </div>
                                <h3 class="text-xl font-bold text-white group-hover:text-amber-400 transition-colors line-clamp-1">
                                    {{ $program->title }}
                                </h3>
                            </div>

                            <!-- Program Body -->
                            <div class="p-6 space-y-4">
                                <div class="text-sm text-slate-600 leading-relaxed line-clamp-3 prose-nabdh">
                                    @cleanHtml($program->short_description)
                                </div>

                                <div class="space-y-2 text-xs text-slate-500 pt-2 border-t border-slate-200">
                                    @if(!empty($program->target_audience))
                                        <div class="flex items-center gap-2">
                                            <span class="font-bold text-slate-700">الفئة:</span>
                                            <span>{{ $program->target_audience }}</span>
                                        </div>
                                    @endif

                                    @if(!empty($program->pillars))
                                        <div class="flex items-center gap-2">
                                            <span class="font-bold text-slate-700">المحاور:</span>
                                            <span class="text-slate-600">{{ $program->pillars }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Card Footer Action -->
                        <div class="p-6 pt-0 border-t border-slate-100 mt-4 flex items-center justify-between gap-3">
                            <a href="{{ route('programs.show', $program->slug) }}" class="text-xs font-bold text-slate-800 hover:text-amber-600 transition-colors py-2">
                                تفاصيل البرنامج ←
                            </a>

                            @if (!empty($program->registration_url))
                                <a href="{{ $program->registration_url }}" target="_blank" rel="noopener noreferrer" class="px-4 py-2 rounded-xl text-xs font-bold bg-amber-400 text-slate-950 hover:bg-amber-300 transition-all shadow-sm">
                                    {{ $program->registration_button_text ?? 'سجّل الآن' }}
                                </a>
                            @else
                                <a href="{{ route('programs.show', $program->slug) }}" class="px-4 py-2 rounded-xl text-xs font-bold bg-slate-900 text-white hover:bg-slate-800 transition-all">
                                    تعرّف على المحتوى
                                </a>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center py-12 text-slate-500">
                        لا توجد برامج منشورة حالياً.
                    </div>
                @endforelse
            </div>
        </div>
    </section>
    @endif

    {{-- SECTION 5: ACHIEVEMENTS & REAL IMPACT --}}
    @if(isset($sections['achievements']) && $sections['achievements']->is_visible)
    <section id="achievements" class="py-20 lg:py-28 bg-gradient-to-b from-slate-900 to-slate-950 text-white border-b border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16 space-y-3">
                <span class="inline-block px-3 py-1 rounded-full bg-slate-800 text-amber-400 text-xs font-bold border border-slate-700">
                    {{ $sections['achievements']->badge ?? 'الإنجازات والأثر' }}
                </span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-white">
                    {{ $sections['achievements']->title }}
                </h2>
                @if(!empty($sections['achievements']->subtitle))
                    <p class="text-base text-slate-400">
                        {{ $sections['achievements']->subtitle }}
                    </p>
                @endif
            </div>

            <!-- Indicators Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @forelse($achievements as $ach)
                    <div class="p-8 rounded-3xl bg-slate-800/60 border border-slate-700/60 hover:border-amber-400/50 transition-all text-center flex flex-col justify-between group">
                        <div>
                            <div class="w-16 h-16 rounded-2xl bg-amber-400/10 border border-amber-400/20 text-amber-400 flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform">
                                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            </div>

                            <div class="flex items-baseline justify-center gap-2 mb-3">
                                <span class="text-5xl lg:text-6xl font-black text-amber-400 tracking-tight">
                                    {{ $ach->metric_value }}
                                </span>
                                @if(!empty($ach->metric_suffix))
                                    <span class="text-lg font-bold text-slate-300">
                                        {{ $ach->metric_suffix }}
                                    </span>
                                @endif
                            </div>

                            <h3 class="text-lg font-bold text-white mb-2">
                                {{ $ach->title }}
                            </h3>

                            @if(!empty($ach->description))
                                <p class="text-xs text-slate-400 leading-relaxed max-w-xs mx-auto">
                                    {{ $ach->description }}
                                </p>
                            @endif
                        </div>

                        @if(!empty($ach->last_updated_date))
                            <div class="mt-6 pt-4 border-t border-slate-700/50 text-[11px] text-slate-400">
                                تم التدقيق: {{ $ach->last_updated_date->format('Y/m/d') }}
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="col-span-3 text-center py-12 text-slate-400">
                        لا توجد مؤشرات منشورة حالياً.
                    </div>
                @endforelse
            </div>
        </div>
    </section>
    @endif

    {{-- SECTION 6: INITIATIVE PHASES --}}
    @if($settings->show_phases_section && isset($sections['phases']) && $sections['phases']->is_visible)
    <section id="phases" class="py-20 lg:py-28 bg-slate-50 border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16 space-y-3">
                <span class="inline-block px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 text-xs font-bold border border-emerald-300">
                    {{ $sections['phases']->badge ?? 'مراحل المبادرة' }}
                </span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900">
                    {{ $sections['phases']->title }}
                </h2>
                @if(!empty($sections['phases']->subtitle))
                    <p class="text-base text-slate-600">
                        {{ $sections['phases']->subtitle }}
                    </p>
                @endif
            </div>

            <!-- 6 Phases Step Flow -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($phases as $phase)
                    <div class="p-6 rounded-3xl bg-white border border-slate-200 hover:border-emerald-400 hover:shadow-lg transition-all flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-4">
                                <span class="px-3 py-1 rounded-xl text-xs font-black bg-slate-900 text-amber-400">
                                    المرحلة {{ $phase->phase_number }}
                                </span>
                                @if(!empty($phase->duration))
                                    <span class="text-xs font-bold text-slate-500 bg-slate-100 px-2.5 py-1 rounded-lg">
                                        {{ $phase->duration }}
                                    </span>
                                @endif
                            </div>

                            <h3 class="text-lg font-bold text-slate-900 mb-3">
                                {{ $phase->title }}
                            </h3>

                            <div class="space-y-3 text-xs text-slate-600 leading-relaxed">
                                @if(!empty($phase->objectives))
                                    <div>
                                        <span class="font-bold text-slate-800 block mb-0.5">الأهداف:</span>
                                        <p>{{ $phase->objectives }}</p>
                                    </div>
                                @endif

                                @if(!empty($phase->tasks))
                                    <div>
                                        <span class="font-bold text-slate-800 block mb-0.5">المهام:</span>
                                        <p>{{ $phase->tasks }}</p>
                                    </div>
                                @endif

                                @if(!empty($phase->deliverables))
                                    <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-200 text-emerald-800">
                                        <span class="font-bold block mb-0.5">المخرجات:</span>
                                        <p>{{ $phase->deliverables }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- SECTION 7: FINANCIAL PLANNING ROADMAP --}}
    @if(isset($sections['roadmap']) && $sections['roadmap']->is_visible)
    <section id="roadmap" class="py-20 lg:py-28 bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16 space-y-3">
                <span class="inline-block px-3 py-1 rounded-full bg-amber-100 text-amber-800 text-xs font-bold border border-amber-300">
                    {{ $sections['roadmap']->badge ?? 'خارطة الطريق' }}
                </span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900">
                    {{ $sections['roadmap']->title }}
                </h2>
                @if(!empty($sections['roadmap']->subtitle))
                    <p class="text-base text-slate-600">
                        {{ $sections['roadmap']->subtitle }}
                    </p>
                @endif
            </div>

            <!-- 6 Step Progression Flow -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($roadmapSteps as $step)
                    <div class="relative p-8 rounded-3xl bg-slate-50 border border-slate-200 hover:border-amber-400 hover:shadow-lg transition-all group">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 rounded-2xl bg-amber-400 text-slate-950 font-black text-xl flex items-center justify-center shadow-md shadow-amber-500/20 group-hover:scale-110 transition-transform">
                                {{ $step->step_number }}
                            </div>
                            <span class="text-xs font-semibold text-slate-400">خطوة عملية</span>
                        </div>

                        <h3 class="text-lg font-bold text-slate-900 mb-2">
                            {{ $step->title }}
                        </h3>

                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            {{ $step->description }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- SECTION 8: TESTIMONIALS (Visible only if approved items exist) --}}
    @if(isset($sections['testimonials']) && $sections['testimonials']->is_visible && $testimonials->count() > 0)
    <section id="testimonials" class="py-20 bg-slate-50 border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16 space-y-3">
                <span class="inline-block px-3 py-1 rounded-full bg-blue-100 text-blue-800 text-xs font-bold border border-blue-300">
                    {{ $sections['testimonials']->badge ?? 'آراء المستفيدين' }}
                </span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900">
                    {{ $sections['testimonials']->title }}
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($testimonials as $t)
                    <div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-sm flex flex-col justify-between">
                        <div class="space-y-4">
                            <div class="flex text-amber-400 text-sm">
                                {!! str_repeat('★', $t->rating) !!}
                            </div>
                            <p class="text-sm text-slate-600 leading-relaxed italic">
                                "{{ $t->content }}"
                            </p>
                        </div>
                        <div class="pt-4 border-t border-slate-100 mt-4 flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-slate-200 text-slate-700 font-bold flex items-center justify-center text-xs">
                                {{ mb_substr($t->author_name, 0, 1) }}
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-slate-900">{{ $t->author_name }}</h4>
                                <span class="text-xs text-slate-400">{{ $t->city_country ?? 'مستفيد من البرامج' }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- SECTION 9: TEAM (Visible only if approved items exist) --}}
    @if(isset($sections['team']) && $sections['team']->is_visible && $teamMembers->count() > 0)
    <section id="team" class="py-20 bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16 space-y-3">
                <span class="inline-block px-3 py-1 rounded-full bg-slate-100 text-slate-800 text-xs font-bold">
                    {{ $sections['team']->badge ?? 'فريق العمل' }}
                </span>
                <h2 class="text-3xl font-extrabold text-slate-900">
                    {{ $sections['team']->title }}
                </h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($teamMembers as $member)
                    <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200 text-center">
                        <div class="w-20 h-20 rounded-full bg-slate-200 text-slate-700 font-bold text-xl flex items-center justify-center mx-auto mb-4">
                            {{ mb_substr($member->name, 0, 1) }}
                        </div>
                        <h4 class="text-base font-bold text-slate-900">{{ $member->name }}</h4>
                        <p class="text-xs text-amber-600 font-semibold mb-2">{{ $member->role }}</p>
                        @if(!empty($member->bio))
                            <p class="text-xs text-slate-500 line-clamp-3">{{ $member->bio }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- SECTION 10: PARTNERS (Visible only if approved items exist) --}}
    @if(isset($sections['partners']) && $sections['partners']->is_visible && $partners->count() > 0)
    <section id="partners" class="py-16 bg-slate-50 border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-10">
                <h3 class="text-xl font-bold text-slate-800">{{ $sections['partners']->title }}</h3>
            </div>
            <div class="flex flex-wrap items-center justify-center gap-8">
                @foreach($partners as $partner)
                    <div class="p-4 px-6 rounded-2xl bg-white border border-slate-200 text-slate-700 font-semibold text-sm shadow-sm">
                        {{ $partner->name }}
                        <span class="text-xs text-slate-400 block">{{ $partner->type }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- SECTION 11: MEDIA & VISUALS --}}
    @if(isset($sections['media']) && $sections['media']->is_visible && $mediaItems->count() > 0)
    <section id="media" class="py-20 bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16 space-y-3">
                <span class="inline-block px-3 py-1 rounded-full bg-amber-100 text-amber-800 text-xs font-bold">
                    {{ $sections['media']->badge ?? 'المركز الإعلامي' }}
                </span>
                <h2 class="text-3xl font-extrabold text-slate-900">
                    {{ $sections['media']->title }}
                </h2>
                @if(!empty($sections['media']->subtitle))
                    <p class="text-base text-slate-600">{{ $sections['media']->subtitle }}</p>
                @endif
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($mediaItems as $media)
                    <div class="rounded-2xl border border-slate-200 overflow-hidden bg-slate-50 shadow-sm hover:shadow-md transition-shadow">
                        @if (!empty($media->file_path))
                            <img src="{{ asset('storage/' . $media->file_path) }}" alt="{{ $media->title }}" class="w-full h-48 object-cover" loading="lazy">
                        @else
                            <div class="w-full h-48 bg-slate-800 text-slate-300 flex items-center justify-center p-4 text-center">
                                <span class="text-xs font-medium">{{ $media->title }}</span>
                            </div>
                        @endif
                        <div class="p-4">
                            <span class="text-[11px] font-bold text-amber-600 block mb-1">{{ $media->type_label }}</span>
                            <h4 class="text-sm font-bold text-slate-900 mb-2">{{ $media->title }}</h4>
                            @if(!empty($media->external_url))
                                <a href="{{ $media->external_url }}" target="_blank" rel="noopener noreferrer" class="text-xs text-blue-600 hover:underline">
                                    مشاهدة المقطع ↗
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- SECTION 12: PARTNERSHIP & SPONSORSHIP REQUEST FORM --}}
    @if(isset($sections['partnerships']) && $sections['partnerships']->is_visible)
    <section id="partnerships" class="py-20 lg:py-28 bg-slate-900 text-white border-b border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">

                <!-- Left Column Info -->
                <div class="lg:col-span-5 space-y-6">
                    <span class="inline-block px-3 py-1 rounded-full bg-slate-800 text-amber-400 text-xs font-bold border border-slate-700">
                        {{ $sections['partnerships']->badge ?? 'فرص التعاون' }}
                    </span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-white leading-tight">
                        {{ $sections['partnerships']->title }}
                    </h2>
                    @if(!empty($sections['partnerships']->subtitle))
                        <p class="text-lg text-amber-400 font-semibold">{{ $sections['partnerships']->subtitle }}</p>
                    @endif
                    <div class="text-slate-300 text-sm leading-relaxed prose-nabdh">
                        @cleanHtml($sections['partnerships']->content)
                    </div>

                    <div class="p-6 rounded-2xl bg-slate-800/60 border border-slate-700 space-y-3">
                        <div class="flex items-center gap-3 text-amber-400 font-bold text-sm">
                            <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span>تصميم برامج توعوية مخصصة لمنسوبي الجهات</span>
                        </div>
                        <div class="flex items-center gap-3 text-amber-400 font-bold text-sm">
                            <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span>رعاية برامج التمكين المالي للأسرة والشباب</span>
                        </div>
                        <div class="flex items-center gap-3 text-amber-400 font-bold text-sm">
                            <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span>شراكات تدريبية واستشارات مالية تطبيقية</span>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Interactive Form -->
                <div class="lg:col-span-7" id="partnership-form">
                    <div class="p-8 sm:p-10 rounded-3xl bg-slate-800/90 border border-slate-700 shadow-2xl backdrop-blur-sm">
                        <h3 class="text-xl font-bold text-white mb-2">نموذج طلب شراكة أو رعاية</h3>
                        <p class="text-xs text-slate-400 mb-6">سجل بيانات جهتك وسيقوم فريق المبادرة بالتواصل لترتيب اللقاء المشترك.</p>

                        <form action="{{ route('partnership.submit') }}" method="POST" class="space-y-4">
                            @csrf

                            <!-- Honeypot anti-spam field -->
                            <input type="text" name="website_hp" class="hidden" tabindex="-1" autocomplete="off">

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="org_name" class="block text-xs font-semibold text-slate-300 mb-1">اسم الجهة أو المؤسسة *</label>
                                    <input type="text" id="org_name" name="organization_name" required value="{{ old('organization_name') }}" placeholder="مثال: شركة / جمعية / قطاع" class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-700 text-white text-sm focus:outline-none focus:border-amber-400 focus:ring-1 focus:ring-amber-400">
                                </div>
                                <div>
                                    <label for="contact_person" class="block text-xs font-semibold text-slate-300 mb-1">اسم الشخص المسؤول *</label>
                                    <input type="text" id="contact_person" name="contact_person" required value="{{ old('contact_person') }}" placeholder="الاسم الكريم" class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-700 text-white text-sm focus:outline-none focus:border-amber-400 focus:ring-1 focus:ring-amber-400">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="p_email" class="block text-xs font-semibold text-slate-300 mb-1">البريد الإلكتروني للجهة *</label>
                                    <input type="email" id="p_email" name="email" required value="{{ old('email') }}" placeholder="name@domain.com" class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-700 text-white text-sm focus:outline-none focus:border-amber-400 focus:ring-1 focus:ring-amber-400" dir="ltr">
                                </div>
                                <div>
                                    <label for="p_phone" class="block text-xs font-semibold text-slate-300 mb-1">رقم هاتف أو جوال للتواصل *</label>
                                    <input type="tel" id="p_phone" name="phone" required value="{{ old('phone') }}" placeholder="05xxxxxxxx" class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-700 text-white text-sm focus:outline-none focus:border-amber-400 focus:ring-1 focus:ring-amber-400" dir="ltr">
                                </div>
                            </div>

                            <div>
                                <label for="request_type" class="block text-xs font-semibold text-slate-300 mb-1">نوع الشراكة المطلوبة *</label>
                                <select id="request_type" name="request_type" required class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-700 text-white text-sm focus:outline-none focus:border-amber-400 focus:ring-1 focus:ring-amber-400">
                                    <option value="رعاية برامج تدريبية" {{ old('request_type') == 'رعاية برامج تدريبية' ? 'selected' : '' }}>رعاية برامج تدريبية</option>
                                    <option value="شراكة تدريبية لمنسوبي الجهة" {{ old('request_type') == 'شراكة تدريبية لمنسوبي الجهة' ? 'selected' : '' }}>شراكة تدريبية لمنسوبي الجهة</option>
                                    <option value="شراكة مجتمعية وغير ربحية" {{ old('request_type') == 'شراكة مجتمعية وغير ربحية' ? 'selected' : '' }}>شراكة مجتمعية وغير ربحية</option>
                                    <option value="استشارات وتطوير حقائب مالية" {{ old('request_type') == 'استشارات وتطوير حقائب مالية' ? 'selected' : '' }}>استشارات وتطوير حقائب مالية</option>
                                    <option value="أخرى" {{ old('request_type') == 'أخرى' ? 'selected' : '' }}>أخرى</option>
                                </select>
                            </div>

                            <div>
                                <label for="p_desc" class="block text-xs font-semibold text-slate-300 mb-1">وصف مختصر للطلب أو مجال التعاون *</label>
                                <textarea id="p_desc" name="description" rows="3" required placeholder="يرجى كتابة نبذة عن الشراكة المتوقعة وما ترغبون بتحقيقه..." class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-700 text-white text-sm focus:outline-none focus:border-amber-400 focus:ring-1 focus:ring-amber-400">{{ old('description') }}</textarea>
                            </div>

                            <div class="flex items-center gap-2 pt-2">
                                <input type="checkbox" id="privacy_accepted" name="privacy_accepted" value="1" required class="rounded bg-slate-900 border-slate-700 text-amber-500 focus:ring-amber-400">
                                <label for="privacy_accepted" class="text-xs text-slate-300">
                                    أوافق على استخدام بيانات الاتصال لغرض التنسيق والتواصل المؤسسي.
                                </label>
                            </div>

                            <button type="submit" class="w-full py-3.5 px-6 rounded-xl text-slate-950 bg-amber-400 hover:bg-amber-300 font-bold text-sm transition-all shadow-lg shadow-amber-500/20 hover:scale-[1.01]">
                                إرسال طلب الشراكة
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>
    @endif

    {{-- SECTION 13: CONTACT & COMMUNITY --}}
    @if(isset($sections['contact']) && $sections['contact']->is_visible)
    <section id="contact" class="py-20 lg:py-28 bg-slate-50 border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16 space-y-3">
                <span class="inline-block px-3 py-1 rounded-full bg-amber-100 text-amber-800 text-xs font-bold border border-amber-300">
                    {{ $sections['contact']->badge ?? 'تواصل معنا' }}
                </span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900">
                    {{ $sections['contact']->title }}
                </h2>
                @if(!empty($sections['contact']->subtitle))
                    <p class="text-base text-slate-600">{{ $sections['contact']->subtitle }}</p>
                @endif
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">

                <!-- Direct Communication Channels -->
                <div class="lg:col-span-5 space-y-6">
                    <div class="p-8 rounded-3xl bg-white border border-slate-200 shadow-sm space-y-6">
                        <h3 class="text-xl font-bold text-slate-900 border-r-4 border-amber-400 pr-3">
                            قنوات المبادرة المعتمدة
                        </h3>

                        <div class="space-y-4">
                            @if (!empty($settings->whatsapp_channel_url))
                                <a href="{{ $settings->whatsapp_channel_url }}" target="_blank" rel="noopener noreferrer" class="flex items-center justify-between p-4 rounded-2xl bg-emerald-50 border border-emerald-200 hover:border-emerald-400 hover:bg-emerald-100/50 transition-all group">
                                    <div class="flex items-center gap-3.5">
                                        <div class="w-12 h-12 rounded-xl bg-emerald-600 text-white flex items-center justify-center text-2xl shadow-sm">
                                            <i class="fa-brands fa-whatsapp"></i>
                                        </div>
                                        <div>
                                            <h4 class="text-sm font-bold text-slate-900">قناة واتساب الرسمية</h4>
                                            <p class="text-xs text-slate-500">نصائح ومواد توعوية يومية</p>
                                        </div>
                                    </div>
                                    <span class="text-emerald-700 font-bold text-xs group-hover:-translate-x-1 transition-transform flex items-center gap-1.5">
                                        متابعة <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                                    </span>
                                </a>
                            @endif

                            @if (!empty($settings->telegram_channel_url))
                                <a href="{{ $settings->telegram_channel_url }}" target="_blank" rel="noopener noreferrer" class="flex items-center justify-between p-4 rounded-2xl bg-sky-50 border border-sky-200 hover:border-sky-400 hover:bg-sky-100/50 transition-all group">
                                    <div class="flex items-center gap-3.5">
                                        <div class="w-12 h-12 rounded-xl bg-sky-500 text-white flex items-center justify-center text-2xl shadow-sm">
                                            <i class="fa-brands fa-telegram"></i>
                                        </div>
                                        <div>
                                            <h4 class="text-sm font-bold text-slate-900">قناة تيليجرام</h4>
                                            <p class="text-xs text-slate-500">الحقائب التدريبية والإعلانات</p>
                                        </div>
                                    </div>
                                    <span class="text-sky-700 font-bold text-xs group-hover:-translate-x-1 transition-transform flex items-center gap-1.5">
                                        انضمام <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                                    </span>
                                </a>
                            @endif

                            @if (!empty($settings->whatsapp_group_url))
                                <a href="{{ $settings->whatsapp_group_url }}" target="_blank" rel="noopener noreferrer" class="flex items-center justify-between p-4 rounded-2xl bg-slate-50 border border-slate-200 hover:border-amber-400 hover:bg-slate-100/60 transition-all group">
                                    <div class="flex items-center gap-3.5">
                                        <div class="w-12 h-12 rounded-xl bg-slate-900 text-emerald-400 flex items-center justify-center text-xl shadow-sm relative">
                                            <i class="fa-brands fa-whatsapp text-2xl"></i>
                                            <span class="absolute -bottom-1 -right-1 w-5 h-5 rounded-full bg-amber-400 text-slate-950 flex items-center justify-center text-[10px] shadow font-bold">
                                                <i class="fa-solid fa-users"></i>
                                            </span>
                                        </div>
                                        <div>
                                            <h4 class="text-sm font-bold text-slate-900">مجموعة واتساب التفاعلية</h4>
                                            <p class="text-xs text-slate-500">نقاشات واستفسارات مالية</p>
                                        </div>
                                    </div>
                                    <span class="text-slate-900 font-bold text-xs group-hover:-translate-x-1 transition-transform flex items-center gap-1.5">
                                        دخول <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                                    </span>
                                </a>
                            @endif

                            @if (!empty($settings->linkjar_url))
                                <a href="{{ $settings->linkjar_url }}" target="_blank" rel="noopener noreferrer" class="flex items-center justify-between p-4 rounded-2xl bg-amber-50/70 border border-amber-200 hover:border-amber-400 hover:bg-amber-100/50 transition-all group">
                                    <div class="flex items-center gap-3.5">
                                        <div class="w-12 h-12 rounded-xl bg-amber-500 text-slate-950 flex items-center justify-center text-xl shadow-sm">
                                            <i class="fa-solid fa-link"></i>
                                        </div>
                                        <div>
                                            <h4 class="text-sm font-bold text-slate-900">مجمع الحسابات والمنصات</h4>
                                            <p class="text-xs text-slate-500">كافة روابط وحسابات المبادرة</p>
                                        </div>
                                    </div>
                                    <span class="text-amber-800 font-bold text-xs group-hover:-translate-x-1 transition-transform flex items-center gap-1.5">
                                        زيارة <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                                    </span>
                                </a>
                            @endif
                        </div>

                        <!-- Direct Contacts -->
                        <div class="pt-4 border-t border-slate-100 space-y-2.5 text-xs text-slate-600">
                            @if(!empty($settings->contact_email))
                                <div class="flex items-center gap-2.5">
                                    <span class="w-7 h-7 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-xs">
                                        <i class="fa-regular fa-envelope"></i>
                                    </span>
                                    <span class="font-bold text-slate-800">البريد:</span>
                                    <a href="mailto:{{ $settings->contact_email }}" class="text-blue-600 hover:underline" dir="ltr">{{ $settings->contact_email }}</a>
                                </div>
                            @endif
                            @if(!empty($settings->contact_phone))
                                <div class="flex items-center gap-2.5">
                                    <span class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center text-xs">
                                        <i class="fa-solid fa-phone"></i>
                                    </span>
                                    <span class="font-bold text-slate-800">الهاتف:</span>
                                    <a href="tel:{{ $settings->contact_phone }}" class="text-slate-800 hover:underline" dir="ltr">{{ $settings->contact_phone }}</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Contact Message Form -->
                <div class="lg:col-span-7">
                    <div class="p-8 sm:p-10 rounded-3xl bg-white border border-slate-200 shadow-sm">
                        <h3 class="text-xl font-bold text-slate-900 mb-2">أرسل لنا رسالة أو استفساراً</h3>
                        <p class="text-xs text-slate-500 mb-6">يسعدنا الإجابة على استفساراتكم حول البرامج التدريبية ومواعيد الجلسات.</p>

                        <form action="{{ route('contact.submit') }}" method="POST" class="space-y-4">
                            @csrf

                            <!-- Honeypot -->
                            <input type="text" name="website_hp" class="hidden" tabindex="-1" autocomplete="off">

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="c_name" class="block text-xs font-semibold text-slate-700 mb-1">الاسم الكامل *</label>
                                    <input type="text" id="c_name" name="name" required value="{{ old('name') }}" placeholder="الاسم الكريم" class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm focus:outline-none focus:border-amber-500 focus:bg-white focus:ring-1 focus:ring-amber-500">
                                </div>
                                <div>
                                    <label for="c_email" class="block text-xs font-semibold text-slate-700 mb-1">البريد الإلكتروني *</label>
                                    <input type="email" id="c_email" name="email" required value="{{ old('email') }}" placeholder="name@example.com" class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm focus:outline-none focus:border-amber-500 focus:bg-white focus:ring-1 focus:ring-amber-500" dir="ltr">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="c_phone" class="block text-xs font-semibold text-slate-700 mb-1">رقم الهاتف (اختياري)</label>
                                    <input type="tel" id="c_phone" name="phone" value="{{ old('phone') }}" placeholder="05xxxxxxxx" class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm focus:outline-none focus:border-amber-500 focus:bg-white focus:ring-1 focus:ring-amber-500" dir="ltr">
                                </div>
                                <div>
                                    <label for="c_subject" class="block text-xs font-semibold text-slate-700 mb-1">موضوع الرسالة</label>
                                    <input type="text" id="c_subject" name="subject" value="{{ old('subject') }}" placeholder="استفسار عن برنامج..." class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm focus:outline-none focus:border-amber-500 focus:bg-white focus:ring-1 focus:ring-amber-500">
                                </div>
                            </div>

                            <div>
                                <label for="c_message" class="block text-xs font-semibold text-slate-700 mb-1">نص الرسالة أو الاستفسار *</label>
                                <textarea id="c_message" name="message" rows="4" required placeholder="اكتب استفسارك هنا..." class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm focus:outline-none focus:border-amber-500 focus:bg-white focus:ring-1 focus:ring-amber-500">{{ old('message') }}</textarea>
                            </div>

                            <button type="submit" class="w-full py-3 px-6 rounded-xl text-slate-950 bg-amber-400 hover:bg-amber-300 font-bold text-sm transition-all shadow-md shadow-amber-500/20 hover:scale-[1.01]">
                                إرسال الرسالة
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>
    @endif

@endsection
