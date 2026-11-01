<?php

namespace App\Filament\Widgets;

use App\Models\ContactSubmission;
use App\Models\PartnershipRequest;
use App\Models\Program;
use App\Models\Achievement;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardStats extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $programsCount = Program::where('is_published', true)->count();
        $unreadContacts = ContactSubmission::where('status', 'unread')->count();
        $pendingPartnerships = PartnershipRequest::where('status', 'pending')->count();
        $achievementsCount = Achievement::where('is_published', true)->count();

        return [
            Stat::make('البرامج النشطة', (string) $programsCount)
                ->description('البرامج المتاحة والمنشورة للجمهور')
                ->descriptionIcon('heroicon-m-academic-cap')
                ->color('primary'),

            Stat::make('رسائل تواصل جديدة', (string) $unreadContacts)
                ->description('رسائل بانتظار الرد والمتابعة')
                ->descriptionIcon('heroicon-m-envelope')
                ->color($unreadContacts > 0 ? 'warning' : 'gray'),

            Stat::make('طلبات شراكة معلقة', (string) $pendingPartnerships)
                ->description('طلبات رعاية وشراكة تحتاج مراجعة')
                ->descriptionIcon('heroicon-m-briefcase')
                ->color($pendingPartnerships > 0 ? 'warning' : 'gray'),

            Stat::make('مؤشرات الأثر والإنجازات', (string) $achievementsCount)
                ->description('إحصائيات وأرقام موثقة معروضة')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color('success'),
        ];
    }
}
