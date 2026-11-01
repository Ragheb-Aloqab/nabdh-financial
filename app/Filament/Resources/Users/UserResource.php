<?php

namespace App\Filament\Resources\Users;

use App\Filament\Resources\Users\Pages\CreateUser;
use App\Filament\Resources\Users\Pages\EditUser;
use App\Filament\Resources\Users\Pages\ListUsers;
use App\Models\User;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;

    protected static string|\UnitEnum|null $navigationGroup = 'النظام والإعدادات';

    protected static ?string $modelLabel = 'مستخدم إداري';

    protected static ?string $pluralModelLabel = 'المستخدمون والصلاحيات';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('بيانات الحساب والصلاحيات')
                    ->description('تحديد بيانات تسجيل الدخول والدور الإداري المخصص')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('name')
                                ->label('الاسم الكامل')
                                ->required(),

                            TextInput::make('email')
                                ->label('البريد الإلكتروني')
                                ->email()
                                ->required()
                                ->unique(ignoreRecord: true),
                        ]),

                        Grid::make(2)->schema([
                            TextInput::make('password')
                                ->label('كلمة المرور')
                                ->password()
                                ->dehydrateStateUsing(fn ($state) => !empty($state) ? Hash::make($state) : null)
                                ->dehydrated(fn ($state) => !empty($state))
                                ->required(fn (string $operation): bool => $operation === 'create')
                                ->helperText('اترك الحقل فارغاً عند التعديل إذا كنت لا ترغب بتغيير كلمة المرور'),

                            Select::make('role')
                                ->label('الدور الإداري (الصلاحيات)')
                                ->options([
                                    'super_admin' => 'مسؤول عام (Super Admin) - كامل الصلاحيات',
                                    'content_manager' => 'مدير محتوى (Content Manager) - تحرير ونشر المحتوى والوسائط',
                                    'forms_manager' => 'مدير النماذج (Forms Manager) - متابعة طلبات التواصل والشراكات',
                                ])
                                ->default('content_manager')
                                ->required(),
                        ]),

                        Toggle::make('is_active')
                            ->label('الحساب نشط ويمكنه تسجيل الدخول')
                            ->default(true),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('الاسم')
                    ->searchable()
                    ->weight('bold'),

                TextColumn::make('email')
                    ->label('البريد الإلكتروني')
                    ->searchable(),

                TextColumn::make('role')
                    ->label('الدور والصلاحية')
                    ->badge()
                    ->colors([
                        'danger' => 'super_admin',
                        'primary' => 'content_manager',
                        'warning' => 'forms_manager',
                    ])
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'super_admin' => 'مسؤول عام',
                        'content_manager' => 'مدير محتوى',
                        'forms_manager' => 'مدير نماذج',
                        default => $state,
                    }),

                IconColumn::make('is_active')
                    ->label('نشط')
                    ->boolean(),

                TextColumn::make('created_at')
                    ->label('تاريخ الإنشاء')
                    ->dateTime('d/m/Y')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->recordActions([
                EditAction::make()->label('تعديل'),
                DeleteAction::make()
                    ->label('حذف')
                    ->visible(fn ($record) => auth()->id() !== $record->id)
                    ->requiresConfirmation(),
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
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }
}
