<?php

namespace App\Filament\Resources\PageSections;

use App\Filament\Resources\PageSections\Pages\CreatePageSection;
use App\Filament\Resources\PageSections\Pages\EditPageSection;
use App\Filament\Resources\PageSections\Pages\ListPageSections;
use App\Models\PageSection;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
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

class PageSectionResource extends Resource
{
    protected static ?string $model = PageSection::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string|\UnitEnum|null $navigationGroup = 'إدارة المحتوى والصفحات';

    protected static ?string $modelLabel = 'قسم في الصفحة الرئيسية';

    protected static ?string $pluralModelLabel = 'أقسام الصفحة الرئيسية';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('معلومات القسم الأساسية')
                    ->description('تحديد عنوان القسم والمحتوى الظاهر في الواجهة')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('section_key')
                                ->label('المعرف البرمجي للقسم')
                                ->required()
                                ->readOnly()
                                ->helperText('معرف فريد للقسم في الصفحة (مثل hero, about, pillars)'),

                            TextInput::make('badge')
                                ->label('شارة أو وسم القسم')
                                ->placeholder('مثال: نبذة عنا / خدماتنا'),
                        ]),

                        TextInput::make('title')
                            ->label('عنوان القسم الرئيسي')
                            ->required(),

                        TextInput::make('subtitle')
                            ->label('العنوان الفرعي أو التمهيدي')
                            ->placeholder('نص توضيحي قصير يظهر تحت العنوان'),

                        RichEditor::make('content')
                            ->label('المحتوى التفصيلي المنسق')
                            ->columnSpanFull()
                            ->fileAttachmentsDisk('public')
                            ->fileAttachmentsDirectory('page-sections')
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'underline',
                                'h2',
                                'h3',
                                'bulletList',
                                'orderedList',
                                'blockquote',
                                'link',
                                'attachFiles',
                                'undo',
                                'redo',
                            ]),
                    ]),

                Section::make('الأزرار والروابط التفاعلية')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('button_text')
                                ->label('نص الزر الرئيسي')
                                ->placeholder('مثال: تعرّف على المبادرة'),

                            TextInput::make('button_url')
                                ->label('رابط الزر الرئيسي')
                                ->placeholder('مثال: #about أو https://...'),

                            TextInput::make('secondary_button_text')
                                ->label('نص الزر الثانوي')
                                ->placeholder('مثال: اكتشف برامجنا'),

                            TextInput::make('secondary_button_url')
                                ->label('رابط الزر الثانوي')
                                ->placeholder('مثال: #programs'),
                        ]),
                    ]),

                Section::make('الوسائط وإعدادات الظهور')
                    ->schema([
                        Grid::make(2)->schema([
                            FileUpload::make('image_path')
                                ->label('صورة أو خلفية القسم')
                                ->image()
                                ->disk('public')
                                ->directory('sections')
                                ->imageEditor(),

                            TextInput::make('image_alt')
                                ->label('النص البديل للصورة (SEO)')
                                ->placeholder('وصف للصورة لمحركات البحث وضعاف البصر'),
                        ]),

                        Grid::make(3)->schema([
                            Select::make('background_style')
                                ->label('نمط الخلفية')
                                ->options([
                                    'default' => 'أبيض افتراضي',
                                    'light' => 'رمادي فاتح هادئ',
                                    'navy' => 'كحلي داكن فاخر',
                                    'gradient' => 'تدرج كحلي وملكي',
                                ])
                                ->default('default'),

                            TextInput::make('sort_order')
                                ->label('ترتيب العرض')
                                ->numeric()
                                ->default(0),

                            Toggle::make('is_visible')
                                ->label('ظهور القسم للجمهور')
                                ->helperText('عند التعطيل سيتم إخفاء القسم من الموقع العام')
                                ->default(true),
                        ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('section_key')
                    ->label('المعرف')
                    ->badge()
                    ->searchable(),

                TextColumn::make('title')
                    ->label('عنوان القسم')
                    ->searchable()
                    ->weight('bold'),

                TextColumn::make('subtitle')
                    ->label('العنوان الفرعي')
                    ->limit(30)
                    ->toggleable(),

                ImageColumn::make('image_path')
                    ->label('الصورة')
                    ->disk('public'),

                TextColumn::make('sort_order')
                    ->label('الترتيب')
                    ->sortable(),

                IconColumn::make('is_visible')
                    ->label('الظهور')
                    ->boolean(),

                TextColumn::make('updated_at')
                    ->label('آخر تحديث')
                    ->dateTime('d/m/Y H:i')
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => ListPageSections::route('/'),
            'create' => CreatePageSection::route('/create'),
            'edit' => EditPageSection::route('/{record}/edit'),
        ];
    }
}
