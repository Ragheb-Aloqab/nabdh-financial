<?php

namespace App\Filament\Resources\Testimonials;

use App\Filament\Resources\Testimonials\Pages\CreateTestimonial;
use App\Filament\Resources\Testimonials\Pages\EditTestimonial;
use App\Filament\Resources\Testimonials\Pages\ListTestimonials;
use App\Models\Testimonial;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
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
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TestimonialResource extends Resource
{
    protected static ?string $model = Testimonial::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChatBubbleBottomCenterText;

    protected static string|\UnitEnum|null $navigationGroup = 'الأثر وفريق العمل';

    protected static ?string $modelLabel = 'رأي مستفيد';

    protected static ?string $pluralModelLabel = 'آراء وتجارب المستفيدين';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('تفاصيل رأي المستفيد')
                    ->description('تنبيه: لا تقم بنشر آراء شخصية للعامة إلا بعد التأكد من الصلاحية وموافقة أصحابها')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('author_name')
                                ->label('اسم المستفيد / اللقب')
                                ->required(),

                            TextInput::make('city_country')
                                ->label('المدينة أو الدولة (اختياري)')
                                ->placeholder('مثال: الرياض، المملكة العربية السعودية'),
                        ]),

                        Textarea::make('content')
                            ->label('نص الشهادة أو الرأي')
                            ->required()
                            ->rows(4),

                        Grid::make(3)->schema([
                            FileUpload::make('avatar_path')
                                ->label('صورة المستفيد (اختياري)')
                                ->image()
                                ->disk('public')
                                ->directory('testimonials'),

                            Select::make('rating')
                                ->label('التقييم من 5 نجوم')
                                ->options([
                                    5 => '★★★★★ (5/5)',
                                    4 => '★★★★☆ (4/5)',
                                    3 => '★★★☆☆ (3/5)',
                                ])
                                ->default(5),

                            TextInput::make('sort_order')
                                ->label('ترتيب العرض')
                                ->numeric()
                                ->default(0),
                        ]),

                        Toggle::make('is_published')
                            ->label('اعتماد ونشر الرأي في الموقع')
                            ->helperText('اتركه معطلاً حتى مراجعة الموافقة على النشر')
                            ->default(false),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('avatar_path')
                    ->label('الصورة')
                    ->circular()
                    ->disk('public'),

                TextColumn::make('author_name')
                    ->label('الاسم')
                    ->searchable()
                    ->weight('bold'),

                TextColumn::make('city_country')
                    ->label('المدينة/الدولة'),

                TextColumn::make('content')
                    ->label('نص الرأي')
                    ->limit(50),

                TextColumn::make('rating')
                    ->label('التقييم')
                    ->formatStateUsing(fn ($state) => str_repeat('★', $state)),

                IconColumn::make('is_published')
                    ->label('منشور وموثق')
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
            'index' => ListTestimonials::route('/'),
            'create' => CreateTestimonial::route('/create'),
            'edit' => EditTestimonial::route('/{record}/edit'),
        ];
    }
}
