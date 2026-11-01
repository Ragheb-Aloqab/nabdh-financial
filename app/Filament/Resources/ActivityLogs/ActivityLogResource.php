<?php

namespace App\Filament\Resources\ActivityLogs;

use App\Filament\Resources\ActivityLogs\Pages\ListActivityLogs;
use App\Models\ActivityLog;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ActivityLogResource extends Resource
{
    protected static ?string $model = ActivityLog::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClock;

    protected static string|\UnitEnum|null $navigationGroup = 'النظام والإعدادات';

    protected static ?string $modelLabel = 'سجل عملية إدارية';

    protected static ?string $pluralModelLabel = 'سجل العمليات الإدارية';

    protected static ?int $navigationSort = 3;

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('تفاصيل العملية الإدارية')
                    ->schema([
                        Grid::make(3)->schema([
                            TextInput::make('user.name')
                                ->label('المستخدم المسؤول')
                                ->readOnly(),

                            TextInput::make('action')
                                ->label('نوع الإجراء')
                                ->readOnly(),

                            TextInput::make('ip_address')
                                ->label('عنوان IP')
                                ->readOnly(),
                        ]),

                        Textarea::make('description')
                            ->label('وصف العملية بالتفصيل')
                            ->rows(4)
                            ->readOnly(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('المستخدم')
                    ->searchable()
                    ->default('النظام'),

                TextColumn::make('action')
                    ->label('الإجراء')
                    ->badge()
                    ->searchable(),

                TextColumn::make('description')
                    ->label('التفاصيل')
                    ->limit(50)
                    ->searchable(),

                TextColumn::make('ip_address')
                    ->label('IP')
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label('الوقت والتاريخ')
                    ->dateTime('d/m/Y H:i:s')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->recordActions([])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListActivityLogs::route('/'),
        ];
    }
}
