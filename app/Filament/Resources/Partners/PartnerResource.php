<?php

namespace App\Filament\Resources\Partners;

use App\Filament\Resources\Partners\Pages\CreatePartner;
use App\Filament\Resources\Partners\Pages\EditPartner;
use App\Filament\Resources\Partners\Pages\ListPartners;
use App\Models\Partner;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
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

class PartnerResource extends Resource
{
    protected static ?string $model = Partner::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingOffice2;

    protected static string|\UnitEnum|null $navigationGroup = 'الأثر وفريق العمل';

    protected static ?string $modelLabel = 'شريك أو مستشار';

    protected static ?string $pluralModelLabel = 'شركاء النجاح والمستشارون';

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('بيانات الشريك أو المستشار')
                    ->description('تنبيه: لا تقم بعرض أي جهة كشريك رسمي دون اعتماد رسمي موثق')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('name')
                                ->label('اسم الجهة أو الشخص المستشار')
                                ->required(),

                            Select::make('type')
                                ->label('الصفة / نوع الشراكة')
                                ->options([
                                    'شريك استراتيجي' => 'شريك استراتيجي',
                                    'مستشار مالي' => 'مستشار مالي',
                                    'جهة راعية' => 'جهة راعية',
                                    'شريك تدريبي' => 'شريك تدريبي',
                                    'شريك إعلامي' => 'شريك إعلامي',
                                ])
                                ->default('شريك استراتيجي')
                                ->required(),
                        ]),

                        Grid::make(2)->schema([
                            FileUpload::make('logo_path')
                                ->label('شعار الجهة أو الصورة المعتمدة')
                                ->image()
                                ->disk('public')
                                ->directory('partners'),

                            TextInput::make('website_url')
                                ->label('الموقع الرسمي للجهة (اختياري)')
                                ->url()
                                ->placeholder('https://...'),
                        ]),

                        Grid::make(2)->schema([
                            TextInput::make('sort_order')
                                ->label('ترتيب العرض')
                                ->numeric()
                                ->default(0),

                            Toggle::make('is_published')
                                ->label('معتمد ومنشور للجمهور')
                                ->helperText('اتركه مسودة حتى الاعتماد النهائي')
                                ->default(false),
                        ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('logo_path')
                    ->label('الشعار')
                    ->disk('public'),

                TextColumn::make('name')
                    ->label('الاسم')
                    ->searchable()
                    ->weight('bold'),

                TextColumn::make('type')
                    ->label('نوع الشراكة')
                    ->badge(),

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
            'index' => ListPartners::route('/'),
            'create' => CreatePartner::route('/create'),
            'edit' => EditPartner::route('/{record}/edit'),
        ];
    }
}
