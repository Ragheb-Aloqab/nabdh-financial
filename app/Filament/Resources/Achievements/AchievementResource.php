<?php

namespace App\Filament\Resources\Achievements;

use App\Filament\Resources\Achievements\Pages\CreateAchievement;
use App\Filament\Resources\Achievements\Pages\EditAchievement;
use App\Filament\Resources\Achievements\Pages\ListAchievements;
use App\Models\Achievement;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AchievementResource extends Resource
{
    protected static ?string $model = Achievement::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChartBar;

    protected static string|\UnitEnum|null $navigationGroup = 'الأثر وفريق العمل';

    protected static ?string $modelLabel = 'مؤشر إنجاز وأثر';

    protected static ?string $pluralModelLabel = 'الإنجازات ومؤشرات الأثر';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('بيانات المؤشر والإنجاز')
                    ->description('إدخال الأرقام والإحصائيات الموثقة مع تاريخ آخر تحديث')
                    ->schema([
                        Grid::make(3)->schema([
                            TextInput::make('title')
                                ->label('عنوان المؤشر')
                                ->placeholder('مثال: عدد المستفيدين')
                                ->required(),

                            TextInput::make('metric_value')
                                ->label('القيمة أو الرقم')
                                ->placeholder('مثال: 200 أو 30-200')
                                ->required(),

                            TextInput::make('metric_suffix')
                                ->label('اللاحقة / الوحدة')
                                ->placeholder('مثال: مستفيد / برنامج / شريك'),
                        ]),

                        Textarea::make('description')
                            ->label('وصف أو سياق الرقم')
                            ->placeholder('مثال: بدأ عدد المستفيدين من 30 ووصل إلى 200 من مختلف أنحاء الوطن العربي')
                            ->rows(3),

                        Grid::make(3)->schema([
                            Select::make('icon')
                                ->label('الأيقونة')
                                ->options([
                                    'users' => 'مستفيدين / مجتمع',
                                    'academic-cap' => 'برامج تدريبية',
                                    'briefcase' => 'شراكات ومؤسسات',
                                    'trophy' => 'جوائز وإنجازات',
                                    'arrow-trending-up' => 'نسبة نمو وتطور',
                                ])
                                ->default('users'),

                            DatePicker::make('last_updated_date')
                                ->label('تاريخ آخر تدقيق للمعلومة')
                                ->default(now()),

                            TextInput::make('sort_order')
                                ->label('ترتيب العرض')
                                ->numeric()
                                ->default(0),
                        ]),

                        Toggle::make('is_published')
                            ->label('حالة النشر في الموقع العام')
                            ->default(true),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('المؤشر')
                    ->searchable()
                    ->weight('bold'),

                TextColumn::make('metric_value')
                    ->label('القيمة')
                    ->badge()
                    ->color('primary'),

                TextColumn::make('metric_suffix')
                    ->label('الوحدة'),

                TextColumn::make('description')
                    ->label('الوصف التوضيحي')
                    ->limit(40),

                TextColumn::make('last_updated_date')
                    ->label('تاريخ التحديث')
                    ->date('d/m/Y')
                    ->toggleable(),

                IconColumn::make('is_published')
                    ->label('منشور')
                    ->boolean(),
            ])
            ->defaultSort('sort_order', 'asc')
            ->recordActions([
                EditAction::make()->label('تعديل'),
                DeleteAction::make()->label('حذف')->requiresConfirmation(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAchievements::route('/'),
            'create' => CreateAchievement::route('/create'),
            'edit' => EditAchievement::route('/{record}/edit'),
        ];
    }
}
