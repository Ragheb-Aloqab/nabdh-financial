<?php

namespace App\Filament\Resources\PartnershipRequests;

use App\Filament\Resources\PartnershipRequests\Pages\EditPartnershipRequest;
use App\Filament\Resources\PartnershipRequests\Pages\ListPartnershipRequests;
use App\Models\PartnershipRequest;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PartnershipRequestResource extends Resource
{
    protected static ?string $model = PartnershipRequest::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBriefcase;

    protected static string|\UnitEnum|null $navigationGroup = 'طلبات التواصل والرسائل';

    protected static ?string $modelLabel = 'طلب شراكة ورعاية';

    protected static ?string $pluralModelLabel = 'طلبات الشراكة والرعاية';

    protected static ?int $navigationSort = 2;

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('بيانات الجهة ومقدم الطلب')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('organization_name')
                                ->label('اسم الجهة أو المؤسسة')
                                ->readOnly(),

                            TextInput::make('contact_person')
                                ->label('اسم الشخص المسؤول')
                                ->readOnly(),

                            TextInput::make('email')
                                ->label('البريد الإلكتروني')
                                ->readOnly(),

                            TextInput::make('phone')
                                ->label('رقم التواصل')
                                ->readOnly(),
                        ]),

                        Grid::make(2)->schema([
                            TextInput::make('request_type')
                                ->label('نوع الشراكة المطلوبة')
                                ->readOnly(),

                            TextInput::make('ip_address')
                                ->label('عنوان IP')
                                ->readOnly(),
                        ]),

                        Textarea::make('description')
                            ->label('وصف وتفاصيل طلب الشراكة')
                            ->rows(4)
                            ->readOnly(),
                    ]),

                Section::make('المراجعة واتخاذ الإجراء')
                    ->schema([
                        Grid::make(2)->schema([
                            Select::make('status')
                                ->label('حالة الطلب')
                                ->options([
                                    'pending' => 'قيد المراجعة والتقييم',
                                    'reviewed' => 'تمت المراجعة والتحقق',
                                    'contacted' => 'تم التواصل والاتفاق',
                                    'rejected' => 'طلب غير ملائم / معتذر عنه',
                                ])
                                ->required(),

                            Textarea::make('admin_notes')
                                ->label('ملاحظات الإدارة الداخلية')
                                ->placeholder('سجّل تفاصيل التنسيق ومحضر التواصل')
                                ->rows(3),
                        ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('organization_name')
                    ->label('الجهة')
                    ->searchable()
                    ->weight('bold'),

                TextColumn::make('contact_person')
                    ->label('المسؤول')
                    ->searchable(),

                TextColumn::make('request_type')
                    ->label('نوع الطلب')
                    ->badge(),

                TextColumn::make('phone')
                    ->label('رقم الهاتف')
                    ->searchable(),

                TextColumn::make('status')
                    ->label('الحالة')
                    ->badge()
                    ->colors([
                        'warning' => 'pending',
                        'info' => 'reviewed',
                        'success' => 'contacted',
                        'danger' => 'rejected',
                    ])
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'pending' => 'قيد المراجعة',
                        'reviewed' => 'تمت المراجعة',
                        'contacted' => 'تم التواصل',
                        'rejected' => 'معتذر عنه',
                        default => $state,
                    }),

                TextColumn::make('created_at')
                    ->label('تاريخ التقديم')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->label('تصفية حسب الحالة')
                    ->options([
                        'pending' => 'قيد المراجعة',
                        'reviewed' => 'تمت المراجعة',
                        'contacted' => 'تم التواصل',
                    ]),
            ])
            ->recordActions([
                EditAction::make()->label('مراجعة الطلب'),
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
            'index' => ListPartnershipRequests::route('/'),
            'edit' => EditPartnershipRequest::route('/{record}/edit'),
        ];
    }
}
