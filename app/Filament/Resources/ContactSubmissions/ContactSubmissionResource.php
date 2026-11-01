<?php

namespace App\Filament\Resources\ContactSubmissions;

use App\Filament\Resources\ContactSubmissions\Pages\EditContactSubmission;
use App\Filament\Resources\ContactSubmissions\Pages\ListContactSubmissions;
use App\Models\ContactSubmission;
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

class ContactSubmissionResource extends Resource
{
    protected static ?string $model = ContactSubmission::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedEnvelope;

    protected static string|\UnitEnum|null $navigationGroup = 'طلبات التواصل والرسائل';

    protected static ?string $modelLabel = 'رسالة تواصل';

    protected static ?string $pluralModelLabel = 'رسائل واستفسارات التواصل';

    protected static ?int $navigationSort = 1;

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('تفاصيل رسالة الزائر')
                    ->schema([
                        Grid::make(3)->schema([
                            TextInput::make('name')
                                ->label('اسم المرسل')
                                ->readOnly(),

                            TextInput::make('email')
                                ->label('البريد الإلكتروني')
                                ->readOnly(),

                            TextInput::make('phone')
                                ->label('رقم الهاتف')
                                ->readOnly(),
                        ]),

                        TextInput::make('subject')
                            ->label('موضوع الرسالة')
                            ->readOnly(),

                        Textarea::make('message')
                            ->label('نص الرسالة المرسلة')
                            ->rows(5)
                            ->readOnly(),

                        TextInput::make('ip_address')
                            ->label('عنوان IP')
                            ->readOnly(),
                    ]),

                Section::make('معالجة الرسالة والمتابعة الإدارية')
                    ->schema([
                        Grid::make(2)->schema([
                            Select::make('status')
                                ->label('حالة الرسالة')
                                ->options([
                                    'unread' => 'جديدة غير مقروءة',
                                    'read' => 'تم الاطلاع عليها',
                                    'replied' => 'تم الرد على المرسل',
                                    'archived' => 'مؤرشفة',
                                ])
                                ->required(),

                            Textarea::make('admin_notes')
                                ->label('ملاحظات الإدارة الداخلية')
                                ->placeholder('سجّل تاريخ الرد وطريقة المتابعة')
                                ->rows(3),
                        ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('المرسل')
                    ->searchable()
                    ->weight('bold'),

                TextColumn::make('email')
                    ->label('البريد الإلكتروني')
                    ->searchable(),

                TextColumn::make('phone')
                    ->label('الهاتف')
                    ->searchable(),

                TextColumn::make('subject')
                    ->label('الموضوع')
                    ->limit(30),

                TextColumn::make('status')
                    ->label('الحالة')
                    ->badge()
                    ->colors([
                        'danger' => 'unread',
                        'warning' => 'read',
                        'success' => 'replied',
                        'gray' => 'archived',
                    ])
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'unread' => 'جديد',
                        'read' => 'تم الاطلاع',
                        'replied' => 'تم الرد',
                        'archived' => 'مؤرشف',
                        default => $state,
                    }),

                TextColumn::make('created_at')
                    ->label('تاريخ الإرسال')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->label('تصفية حسب الحالة')
                    ->options([
                        'unread' => 'جديدة',
                        'read' => 'تم الاطلاع',
                        'replied' => 'تم الرد',
                    ]),
            ])
            ->recordActions([
                EditAction::make()->label('عرض ومتابعة'),
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
            'index' => ListContactSubmissions::route('/'),
            'edit' => EditContactSubmission::route('/{record}/edit'),
        ];
    }
}
