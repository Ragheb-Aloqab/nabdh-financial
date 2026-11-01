<?php

namespace App\Filament\Resources\RoadmapSteps;

use App\Filament\Resources\RoadmapSteps\Pages\CreateRoadmapStep;
use App\Filament\Resources\RoadmapSteps\Pages\EditRoadmapStep;
use App\Filament\Resources\RoadmapSteps\Pages\ListRoadmapSteps;
use App\Models\RoadmapStep;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
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

class RoadmapStepResource extends Resource
{
    protected static ?string $model = RoadmapStep::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedMap;

    protected static string|\UnitEnum|null $navigationGroup = 'البرامج والمبادرات';

    protected static ?string $modelLabel = 'خطوة تخطيط مالي';

    protected static ?string $pluralModelLabel = 'خارطة التخطيط المالي';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('بيانات خطوة التخطيط المالي')
                    ->schema([
                        Grid::make(3)->schema([
                            TextInput::make('step_number')
                                ->label('رقم الخطوة')
                                ->numeric()
                                ->default(1)
                                ->required(),

                            TextInput::make('title')
                                ->label('عنوان الخطوة')
                                ->placeholder('مثال: تحديد الوضع المالي الحالي')
                                ->required(),

                            Select::make('icon')
                                ->label('الأيقونة الرمزية')
                                ->options([
                                    'magnifying-glass' => 'عدسة فحص / تحليل',
                                    'flag' => 'علم / وضع الأهداف',
                                    'arrows-pointing-out' => 'خيارات وبدائل',
                                    'scale' => 'ميزان التقييم والمقارنة',
                                    'document-check' => 'إعداد الخطة وتنفيذها',
                                    'arrow-path' => 'تحديث وإعادة تقييم',
                                ])
                                ->default('magnifying-glass'),
                        ]),

                        Textarea::make('description')
                            ->label('الوصف التوضيحي للخطوة')
                            ->placeholder('شرح لكيفية تطبيق هذه الخطوة بنجاح')
                            ->rows(3),

                        Grid::make(2)->schema([
                            TextInput::make('sort_order')
                                ->label('ترتيب العرض')
                                ->numeric()
                                ->default(0),

                            Toggle::make('is_published')
                                ->label('منشور في الموقع')
                                ->default(true),
                        ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('step_number')
                    ->label('الخطوة')
                    ->formatStateUsing(fn ($state) => "الخطوة $state")
                    ->badge()
                    ->sortable(),

                TextColumn::make('title')
                    ->label('عنوان الخطوة')
                    ->searchable()
                    ->weight('bold'),

                TextColumn::make('description')
                    ->label('الشرح والوصف')
                    ->limit(50),

                IconColumn::make('is_published')
                    ->label('منشور')
                    ->boolean(),
            ])
            ->defaultSort('step_number', 'asc')
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
            'index' => ListRoadmapSteps::route('/'),
            'create' => CreateRoadmapStep::route('/create'),
            'edit' => EditRoadmapStep::route('/{record}/edit'),
        ];
    }
}
