<?php

namespace App\Filament\Resources\ProgramPhases;

use App\Filament\Resources\ProgramPhases\Pages\CreateProgramPhase;
use App\Filament\Resources\ProgramPhases\Pages\EditProgramPhase;
use App\Filament\Resources\ProgramPhases\Pages\ListProgramPhases;
use App\Models\ProgramPhase;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
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

class ProgramPhaseResource extends Resource
{
    protected static ?string $model = ProgramPhase::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    protected static string|\UnitEnum|null $navigationGroup = 'البرامج والمبادرات';

    protected static ?string $modelLabel = 'مرحلة من مراحل المبادرة';

    protected static ?string $pluralModelLabel = 'مراحل تنفيذ المبادرة';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('بيانات المرحلة')
                    ->schema([
                        Grid::make(3)->schema([
                            TextInput::make('phase_number')
                                ->label('رقم المرحلة')
                                ->numeric()
                                ->default(1)
                                ->required(),

                            TextInput::make('title')
                                ->label('عنوان المرحلة')
                                ->placeholder('مثال: الإعداد والتأسيس')
                                ->required(),

                            TextInput::make('duration')
                                ->label('المدة الزمنية التقديرية')
                                ->placeholder('مثال: 3 أشهر'),
                        ]),

                        Textarea::make('objectives')
                            ->label('أهداف المرحلة')
                            ->placeholder('ما الذي تهدف المرحلة إلى تحقيقه؟')
                            ->rows(3),

                        Textarea::make('tasks')
                            ->label('المهام والأنشطة الرئيسية')
                            ->placeholder('أهم الخطوات والمهام المنفذة خلال المرحلة')
                            ->rows(3),

                        Textarea::make('deliverables')
                            ->label('المخرجات المتوقعة')
                            ->placeholder('النتائج والمخرجات الملموسة')
                            ->rows(3),

                        Grid::make(2)->schema([
                            TextInput::make('sort_order')
                                ->label('الترتيب')
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
                TextColumn::make('phase_number')
                    ->label('المرحلة')
                    ->formatStateUsing(fn ($state) => "المرحلة $state")
                    ->badge()
                    ->sortable(),

                TextColumn::make('title')
                    ->label('اسم المرحلة')
                    ->searchable()
                    ->weight('bold'),

                TextColumn::make('duration')
                    ->label('المدة')
                    ->searchable(),

                TextColumn::make('objectives')
                    ->label('الأهداف')
                    ->limit(40),

                IconColumn::make('is_published')
                    ->label('منشور')
                    ->boolean(),
            ])
            ->defaultSort('phase_number', 'asc')
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
            'index' => ListProgramPhases::route('/'),
            'create' => CreateProgramPhase::route('/create'),
            'edit' => EditProgramPhase::route('/{record}/edit'),
        ];
    }
}
