@extends('layouts.app')

@section('title', ($program->meta_title ?: $program->title) . ' | نبض للتوعية المالية')
@section('meta_description', $program->meta_description ?: strip_tags(Str::limit($program->short_description, 160)))

@section('content')
<div class="bg-slate-900 text-white py-12 border-b border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumbs -->
        <nav class="flex items-center gap-2 text-xs text-slate-400 mb-6">
            <a href="{{ route('home') }}" class="hover:text-amber-400">الرئيسية</a>
            <span>/</span>
            <a href="{{ route('home') }}#programs" class="hover:text-amber-400">البرامج التدريبية</a>
            <span>/</span>
            <span class="text-amber-400 font-bold">{{ $program->title }}</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
            <div class="lg:col-span-8 space-y-4">
                <div class="flex flex-wrap items-center gap-3">
                    <span class="px-3 py-1 rounded-full text-xs font-bold {{ $program->status === 'open' ? 'bg-emerald-500 text-slate-950' : 'bg-slate-800 text-amber-400 border border-amber-400/30' }}">
                        {{ $program->status_label }}
                    </span>
                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-slate-800 text-slate-300 border border-slate-700">
                        طريقة التنفيذ: {{ $program->delivery_mode_label }}
                    </span>
                </div>

                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-white leading-tight">
                    {{ $program->title }}
                </h1>

                @if(!empty($program->target_audience))
                    <p class="text-sm text-slate-300">
                        <strong class="text-amber-400">الفئة المستهدفة:</strong> {{ $program->target_audience }}
                    </p>
                @endif
            </div>

            <div class="lg:col-span-4 text-center lg:text-left">
                @if(!empty($program->registration_url))
                    <a href="{{ $program->registration_url }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center px-8 py-4 rounded-2xl font-bold text-slate-950 bg-amber-400 hover:bg-amber-300 transition-all shadow-xl shadow-amber-500/25 hover:scale-105 active:scale-95 text-base w-full sm:w-auto">
                        {{ $program->registration_button_text ?: 'سجّل في البرنامج الآن' }}
                    </a>
                @else
                    <a href="{{ route('home') }}#contact" class="inline-flex items-center justify-center px-8 py-4 rounded-2xl font-bold text-white bg-slate-800 hover:bg-slate-700 border border-slate-700 transition-all text-base w-full sm:w-auto">
                        تواصل للاستفسار عن الموعد
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">

            <!-- Main Content Details -->
            <div class="lg:col-span-8 space-y-8">
                @if(!empty($program->cover_image))
                    <div class="rounded-3xl overflow-hidden border border-slate-200 shadow-md">
                        <img src="{{ asset('storage/' . $program->cover_image) }}" alt="{{ $program->title }}" class="w-full h-80 object-cover">
                    </div>
                @endif

                <div class="p-8 rounded-3xl bg-slate-50 border border-slate-200">
                    <h2 class="text-xl font-bold text-slate-900 mb-4 border-r-4 border-amber-400 pr-3">
                        نبذة عن البرنامج
                    </h2>
                    <div class="text-slate-700 leading-relaxed text-base prose-nabdh">
                        @cleanHtml($program->short_description)
                    </div>
                </div>

                @if(!empty($program->detailed_description))
                    <div class="p-8 rounded-3xl bg-white border border-slate-200 shadow-sm">
                        <h2 class="text-xl font-bold text-slate-900 mb-4 border-r-4 border-blue-600 pr-3">
                            المحاور والتفاصيل الكاملة
                        </h2>
                        <div class="text-slate-700 leading-relaxed text-base prose-nabdh">
                            @cleanHtml($program->detailed_description)
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar Info -->
            <div class="lg:col-span-4 space-y-6">
                <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200 space-y-4">
                    <h3 class="text-base font-bold text-slate-900 border-b border-slate-200 pb-3">معلومات البرنامج</h3>

                    <div class="space-y-3 text-xs">
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500 font-semibold">حالة التسجيل:</span>
                            <span class="font-bold text-slate-900">{{ $program->status_label }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500 font-semibold">طريقة الحضور:</span>
                            <span class="font-bold text-slate-900">{{ $program->delivery_mode_label }}</span>
                        </div>
                        @if(!empty($program->pillars))
                            <div class="flex flex-col gap-1 pt-2 border-t border-slate-200">
                                <span class="text-slate-500 font-semibold">المحاور المغطاة:</span>
                                <span class="font-medium text-slate-800">{{ $program->pillars }}</span>
                            </div>
                        @endif
                        @if(!empty($program->trainer_name))
                            <div class="flex items-center justify-between pt-2 border-t border-slate-200">
                                <span class="text-slate-500 font-semibold">المدرب:</span>
                                <span class="font-bold text-slate-900">{{ $program->trainer_name }}</span>
                            </div>
                        @endif
                    </div>

                    @if(!empty($program->registration_url))
                        <div class="pt-4">
                            <a href="{{ $program->registration_url }}" target="_blank" rel="noopener noreferrer" class="block w-full text-center py-3 px-4 rounded-xl font-bold text-slate-950 bg-amber-400 hover:bg-amber-300 transition-colors text-xs">
                                {{ $program->registration_button_text ?: 'رابط التسجيل المعتمد' }}
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Related Programs -->
                @if($relatedPrograms->count() > 0)
                    <div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-sm space-y-4">
                        <h3 class="text-sm font-bold text-slate-900 border-b border-slate-100 pb-3">برامج أخرى قد تهمك</h3>
                        <div class="space-y-3">
                            @foreach($relatedPrograms as $rel)
                                <a href="{{ route('programs.show', $rel->slug) }}" class="block p-3 rounded-2xl bg-slate-50 hover:bg-amber-50/70 border border-slate-200 hover:border-amber-300 transition-colors">
                                    <h4 class="text-xs font-bold text-slate-900 mb-1">{{ $rel->title }}</h4>
                                    <span class="text-[11px] text-slate-500">{{ $rel->status_label }} • {{ $rel->delivery_mode_label }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>
@endsection
