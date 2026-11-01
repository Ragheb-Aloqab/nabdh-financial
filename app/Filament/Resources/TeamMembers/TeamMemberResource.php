<?php

namespace App\Filament\Resources\TeamMembers;

use App\Filament\Resources\TeamMembers\Pages\CreateTeamMember;
use App\Filament\Resources\TeamMembers\Pages\EditTeamMember;
use App\Filament\Resources\TeamMembers\Pages\ListTeamMembers;
use App\Models\TeamMember;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TeamMemberResource extends Resource
{
    protected static ?string $model = TeamMember::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static string|\UnitEnum|null $navigationGroup = 'الأثر وفريق العمل';

    protected static ?string $modelLabel = 'عضو في الفريق';

    protected static ?string $pluralModelLabel = 'فريق العمل';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('بيانات عضو الفريق')
                    ->description('تنبيه: لا تقم باختلاق صور أو مؤهلات غير موثقة')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('name')
                                ->label('الاسم الكامل')
                                ->required(),

                            TextInput::make('role')
                                ->label('المسمى الوظيفي / الدور في المبادرة')
                                ->required(),
                        ]),

                        Textarea::make('bio')
                            ->label('نبذة تعريفية موجزة')
                            ->rows(3),

                        Grid::make(2)->schema([
                            FileUpload::make('photo_path')
                                ->label('الصورة الشخصية (اختيارية ومعتمدة)')
                                ->image()
                                ->disk('public')
                                ->directory('team'),

                            TextInput::make('sort_order')
                                ->label('ترتيب العرض')
                                ->numeric()
                                ->default(0),
                        ]),

                        Toggle::make('is_published')
                            ->label('حالة النشر في الموقع العام')
                            ->helperText('المسودات تحتاج إلى اعتماد قبل ظهورها')
                            ->default(false),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('photo_path')
                    ->label('الصورة')
                    ->circular()
                    ->disk('public'),

                TextColumn::make('name')
                    ->label('الاسم')
                    ->searchable()
                    ->weight('bold'),

                TextColumn::make('role')
                    ->label('الدور / المنصب')
                    ->searchable(),

                TextColumn::make('sort_order')
                    ->label('الترتيب')
                    ->sortable(),

                IconColumn::make('is_published')
                    ->label('معتمد ومنشور')
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
            'index' => ListTeamMembers::route('/'),
            'create' => CreateTeamMember::route('/create'),
            'edit' => EditTeamMember::route('/{record}/edit'),
        ];
    }
}
