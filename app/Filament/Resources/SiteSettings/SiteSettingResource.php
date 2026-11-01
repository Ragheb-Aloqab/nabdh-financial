<?php

namespace App\Filament\Resources\SiteSettings;

use App\Filament\Resources\SiteSettings\Pages\EditSiteSetting;
use App\Filament\Resources\SiteSettings\Pages\ListSiteSettings;
use App\Models\SiteSetting;
use BackedEnum;
use Filament\Actions\EditAction;
use Filament\Forms\Components\ColorPicker;
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
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class SiteSettingResource extends Resource
{
    protected static ?string $model = SiteSetting::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static string|\UnitEnum|null $navigationGroup = 'النظام والإعدادات';

    protected static ?string $modelLabel = 'إعدادات الموقع العامة';

    protected static ?string $pluralModelLabel = 'إعدادات الموقع العامة';

    protected static ?int $navigationSort = 1;

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canDelete(Model $record): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('الهوية المؤسسية والشعارات')
                    ->description('تحديد اسم المبادرة والشعار التسويقي والشعارات المعتمدة')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('initiative_name')
                                ->label('اسم المبادرة')
                                ->required()
                                ->default('نبض للتوعية المالية'),

                            TextInput::make('slogan')
                                ->label('الشعار التسويقي (Slogan)')
                                ->required()
                                ->default('طريقك نحو النجاح المالي'),
                        ]),

                        Grid::make(3)->schema([
                            FileUpload::make('logo_path')
                                ->label('الشعار الرسمي (الترويسة)')
                                ->image()
                                ->disk('public')
                                ->directory('settings')
                                ->helperText('يظهر في الشريط العلوي للموقع'),

                            FileUpload::make('footer_logo_path')
                                ->label('شعار التذييل أو الشعار البديل')
                                ->image()
                                ->disk('public')
                                ->directory('settings')
                                ->helperText('يظهر في أسفل الصفحة'),

                            FileUpload::make('favicon_path')
                                ->label('أيقونة الموقع (Favicon)')
                                ->image()
                                ->disk('public')
                                ->directory('settings'),
                        ]),
                    ]),

                Section::make('ألوان الهوية والخط العربي')
                    ->description('الألوان المؤسسية المعتمدة للمبادرة (تنعكس تلقائياً على واجهة الموقع)')
                    ->schema([
                        Grid::make(4)->schema([
                            TextInput::make('primary_color')
                                ->label('الأزرق الكحلي (الرئيسي)')
                                ->default('#1e3a8a')
                                ->required(),

                            TextInput::make('accent_color')
                                ->label('الأصفر الذهبي (الإبراز)')
                                ->default('#eab308')
                                ->required(),

                            TextInput::make('secondary_color')
                                ->label('الأزرق الملكي (مساعد)')
                                ->default('#2563eb')
                                ->required(),

                            TextInput::make('turquoise_color')
                                ->label('التركوازي (مساعد)')
                                ->default('#0d9488')
                                ->required(),
                        ]),

                        Select::make('font_family')
                            ->label('الخط العربي المعتمد')
                            ->options([
                                'Cairo' => 'Cairo (خط حديث وواضح)',
                                'IBM Plex Sans Arabic' => 'IBM Plex Sans Arabic (خط مؤسسي احترافي)',
                            ])
                            ->default('Cairo')
                            ->required(),
                    ]),

                Section::make('معلومات التواصل والروابط الرسمية')
                    ->description('أرقام التواصل والبريد وقنوات واتساب وتيليجرام')
                    ->schema([
                        Grid::make(3)->schema([
                            TextInput::make('contact_email')
                                ->label('البريد الإلكتروني الرسمي')
                                ->email()
                                ->default('nabdh.almaliah@outlook.sa'),

                            TextInput::make('contact_phone')
                                ->label('رقم الاتصال المعتمد')
                                ->default('00966599957589'),

                            TextInput::make('whatsapp_number')
                                ->label('رقم واتساب المباشر')
                                ->default('00966599957589'),
                        ]),

                        Grid::make(2)->schema([
                            TextInput::make('whatsapp_channel_url')
                                ->label('رابط قناة واتساب')
                                ->url()
                                ->default('https://whatsapp.com/channel/0029Vb7xxYv4o7qIlqvlVU1e'),

                            TextInput::make('telegram_channel_url')
                                ->label('رابط قناة تيليجرام')
                                ->url()
                                ->default('https://t.me/nabdh_almaliah_sa'),

                            TextInput::make('whatsapp_group_url')
                                ->label('رابط مجموعة واتساب')
                                ->url()
                                ->default('https://chat.whatsapp.com/EuJWkZ1k7MPFunngBMk7NC'),

                            TextInput::make('linkjar_url')
                                ->label('رابط مجمع الحسابات (Linkjar)')
                                ->url()
                                ->default('https://linkjar.co/nabdh.almalih'),
                        ]),
                    ]),

                Section::make('تهيئة محركات البحث والمشاركة الاجتماعية (SEO)')
                    ->schema([
                        TextInput::make('site_title')
                            ->label('عنوان صفحة الموقع في جوجل')
                            ->required()
                            ->default('نبض للتوعية المالية | طريقك نحو النجاح المالي'),

                        Textarea::make('meta_description')
                            ->label('وصف الموقع لمحركات البحث (Meta Description)')
                            ->rows(3)
                            ->default('مبادرة نبض للتوعية والتمكين المالي للأفراد والأسرة - وعي.. مال.. أسرة. رفع الوعي المالي وتغيير السلوك المالي المستدام.'),

                        TextInput::make('keywords')
                            ->label('الكلمات المفتاحية')
                            ->default('وعي مالي, تمكين مالي, تخطيط مالي, ادخار, استثمار واعي, نبض للتوعية المالية'),

                        FileUpload::make('og_image_path')
                            ->label('صورة المعاينة عند المشاركة (Open Graph Image)')
                            ->image()
                            ->disk('public')
                            ->directory('settings'),
                    ]),

                Section::make('إعدادات التذييل والتحكم بالصفحات')
                    ->schema([
                        TextInput::make('copyright_text')
                            ->label('نص حقوق النشر في التذييل')
                            ->default('جميع الحقوق محفوظة لمبادرة نبض للتوعية المالية © ' . date('Y')),

                        Grid::make(3)->schema([
                            Toggle::make('show_footer_social')
                                ->label('إظهار أيقونات التواصل في التذييل')
                                ->default(true),

                            Toggle::make('show_footer_quick_links')
                                ->label('إظهار روابط الوصول السريع في التذييل')
                                ->default(true),

                            Toggle::make('show_phases_section')
                                ->label('إظهار قسم مراحل المبادرة في الصفحة')
                                ->default(true),
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

                TextColumn::make('initiative_name')
                    ->label('اسم المبادرة')
                    ->weight('bold'),

                TextColumn::make('slogan')
                    ->label('الشعار التسويقي'),

                TextColumn::make('contact_email')
                    ->label('البريد الإلكتروني'),

                TextColumn::make('contact_phone')
                    ->label('رقم التواصل'),

                TextColumn::make('updated_at')
                    ->label('آخر تحديث')
                    ->dateTime('d/m/Y H:i'),
            ])
            ->recordActions([
                EditAction::make()->label('تعديل الإعدادات'),
            ])
            ->toolbarActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSiteSettings::route('/'),
            'edit' => EditSiteSetting::route('/{record}/edit'),
        ];
    }
}
