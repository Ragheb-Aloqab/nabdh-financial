<?php

namespace App\Filament\Resources\Pillars;

use App\Filament\Resources\Pillars\Pages\CreatePillar;
use App\Filament\Resources\Pillars\Pages\EditPillar;
use App\Filament\Resources\Pillars\Pages\ListPillars;
use App\Models\Pillar;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\ColorPicker;
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

class PillarResource extends Resource
{
    protected static ?string $model = Pillar::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSparkles;

    protected static string|\UnitEnum|null $navigationGroup = 'إدارة المحتوى والصفحات';

    protected static ?string $modelLabel = 'محور ومستهدف';

    protected static ?string $pluralModelLabel = 'أهداف ومحاور المبادرة';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('بيانات المحور الأساسي')
                    ->schema([
                        TextInput::make('title')
                            ->label('عنوان المحور')
                            ->placeholder('مثال: التوعية والتمكين المالي')
                            ->required(),

                        Textarea::make('short_description')
                            ->label('الوصف التوضيحي للمحور')
                            ->placeholder('شرح مختصر لأهمية المحور وما يغطيه')
                            ->rows(3),

                        Grid::make(3)->schema([
                            Select::make('icon')
                                ->label('الأيقونة الرمزية')
                                ->options([
                                    'currency-dollar' => 'عملة ومال (Dollar)',
                                    'chart-bar' => 'رسم بياني (Chart)',
                                    'scale' => 'ميزان وتخطيط (Scale)',
                                    'shield-check' => 'حماية وأمان (Shield)',
                                    'home' => 'أسرة ومجتمع (Family/Home)',
                                    'trending-up' => 'استثمار ونمو (Growth)',
                                    'sparkles' => 'تميز ولمعان (Sparkles)',
                                ])
                                ->default('chart-bar'),

                            TextInput::make('color')
                                ->label('رمز اللون أو التمييز')
                                ->placeholder('#1e3a8a أو navy'),

                            TextInput::make('sort_order')
                                ->label('ترتيب العرض')
                                ->numeric()
                                ->default(0)
                                ->required(),
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
                    ->label('عنوان المحور')
                    ->searchable()
                    ->weight('bold'),

                TextColumn::make('short_description')
                    ->label('الوصف')
                    ->limit(50),

                TextColumn::make('icon')
                    ->label('الأيقونة')
                    ->badge(),

                TextColumn::make('sort_order')
                    ->label('الترتيب')
                    ->sortable(),

                IconColumn::make('is_published')
                    ->label('منشور')
                    ->boolean(),
            ])
            ->defaultSort('sort_order', 'asc')
            ->recordActions([
                EditAction::make()->label('تعديل'),
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
            'index' => ListPillars::route('/'),
            'create' => CreatePillar::route('/create'),
            'edit' => EditPillar::route('/{record}/edit'),
        ];
    }
}
