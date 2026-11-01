<?php

namespace App\Filament\Resources\Programs;

use App\Filament\Resources\Programs\Pages\CreateProgram;
use App\Filament\Resources\Programs\Pages\EditProgram;
use App\Filament\Resources\Programs\Pages\ListPrograms;
use App\Models\Program;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
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
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ProgramResource extends Resource
{
    protected static ?string $model = Program::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedAcademicCap;

    protected static string|\UnitEnum|null $navigationGroup = 'البرامج والمبادرات';

    protected static ?string $modelLabel = 'برنامج تدريبي';

    protected static ?string $pluralModelLabel = 'برامج المبادرة';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('معلومات البرنامج الأساسية')
                    ->description('عنوان البرنامج والرابط التعريفي والوصف')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('title')
                                ->label('اسم البرنامج')
                                ->placeholder('مثال: كيف أبدأ من الصفر')
                                ->required(),

                            TextInput::make('slug')
                                ->label('الرابط المختصر (Slug)')
                                ->placeholder('يتم توليده تلقائياً إذا تُرك فارغاً')
                                ->helperText('يُستخدم في رابط صفحة البرنامج'),
                        ]),

                        RichEditor::make('short_description')
                            ->label('وصف مختصر للبرنامج (Rich Text)')
                            ->placeholder('نبذة تعريفية سريعة تظهر في بطاقة البرنامج')
                            ->columnSpanFull()
                            ->fileAttachmentsDisk('public')
                            ->fileAttachmentsDirectory('programs')
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'underline',
                                'h3',
                                'bulletList',
                                'orderedList',
                                'link',
                                'undo',
                                'redo',
                            ]),

                        RichEditor::make('detailed_description')
                            ->label('الوصف التفصيلي والمحاور (Rich Text)')
                            ->columnSpanFull()
                            ->fileAttachmentsDisk('public')
                            ->fileAttachmentsDirectory('programs')
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

                Section::make('تفاصيل التنفيذ والتسجيل')
                    ->schema([
                        Grid::make(2)->schema([
                            FileUpload::make('cover_image')
                                ->label('صورة غلاف البرنامج')
                                ->image()
                                ->disk('public')
                                ->directory('programs/covers')
                                ->imageEditor(),

                            TextInput::make('target_audience')
                                ->label('الفئة المستهدفة')
                                ->placeholder('مثال: الأفراد، المقبلون على الزواج، أرباب الأسر'),
                        ]),

                        Grid::make(2)->schema([
                            TextInput::make('trainer_name')
                                ->label('اسم المدرب / المدربين (إن توفر)')
                                ->placeholder('اتركه فارغاً إن لم تتوفر بيانات معتمدة'),

                            TextInput::make('pillars')
                                ->label('المحاور التدريبية')
                                ->placeholder('مثال: التخطيط المالي، إدارة المصروفات'),
                        ]),

                        Grid::make(2)->schema([
                            DatePicker::make('start_date')
                                ->label('تاريخ البداية (اختياري)'),

                            DatePicker::make('end_date')
                                ->label('تاريخ النهاية (اختياري)'),
                        ]),

                        Grid::make(2)->schema([
                            Select::make('status')
                                ->label('حالة البرنامج')
                                ->options([
                                    'upcoming' => 'قريباً / قادم',
                                    'open' => 'متاح للتسجيل الآن',
                                    'ongoing' => 'جارٍ تنفيذه',
                                    'completed' => 'مكتمل',
                                    'archived' => 'مؤرشف',
                                ])
                                ->default('upcoming')
                                ->required(),

                            Select::make('delivery_mode')
                                ->label('طريقة التنفيذ')
                                ->options([
                                    'online' => 'عن بُعد (Online)',
                                    'in_person' => 'حضوري',
                                    'hybrid' => 'مدمج (حضوري وعن بعد)',
                                ])
                                ->default('online')
                                ->required(),
                        ]),

                        Grid::make(2)->schema([
                            TextInput::make('registration_url')
                                ->label('رابط نموذج التسجيل (اختياري)')
                                ->placeholder('https://forms...'),

                            TextInput::make('registration_button_text')
                                ->label('نص زر التسجيل')
                                ->default('سجّل الآن'),
                        ]),
                    ]),

                Section::make('حالة النشر والترتيب وتهيئة محركات البحث (SEO)')
                    ->schema([
                        Grid::make(3)->schema([
                            TextInput::make('sort_order')
                                ->label('ترتيب العرض')
                                ->numeric()
                                ->default(0),

                            Toggle::make('is_published')
                                ->label('منشور للجمهور')
                                ->helperText('المسودات لن تظهر في الموقع العام')
                                ->default(true),

                            Toggle::make('is_featured')
                                ->label('برنامج مميز')
                                ->default(false),
                        ]),

                        Grid::make(2)->schema([
                            TextInput::make('meta_title')
                                ->label('عنوان SEO (اختياري)')
                                ->placeholder('عنوان يظهر في نتائج بحث جوجل'),

                            Textarea::make('meta_description')
                                ->label('وصف SEO (اختياري)')
                                ->rows(2),
                        ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('cover_image')
                    ->label('الغلاف')
                    ->disk('public'),

                TextColumn::make('title')
                    ->label('اسم البرنامج')
                    ->searchable()
                    ->weight('bold'),

                TextColumn::make('status')
                    ->label('الحالة')
                    ->badge()
                    ->colors([
                        'warning' => 'upcoming',
                        'success' => 'open',
                        'info' => 'ongoing',
                        'gray' => ['completed', 'archived'],
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'open' => 'متاح للتسجيل',
                        'upcoming' => 'قريباً',
                        'ongoing' => 'جارٍ',
                        'completed' => 'مكتمل',
                        'archived' => 'مؤرشف',
                        default => $state,
                    }),

                TextColumn::make('delivery_mode')
                    ->label('طريقة التنفيذ')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'online' => 'عن بُعد',
                        'in_person' => 'حضوري',
                        'hybrid' => 'مدمج',
                        default => $state,
                    }),

                TextColumn::make('sort_order')
                    ->label('الترتيب')
                    ->sortable(),

                IconColumn::make('is_published')
                    ->label('منشور')
                    ->boolean(),

                TextColumn::make('created_at')
                    ->label('تاريخ الإضافة')
                    ->dateTime('d/m/Y')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('sort_order', 'asc')
            ->filters([
                SelectFilter::make('status')
                    ->label('تصفية حسب الحالة')
                    ->options([
                        'open' => 'متاح للتسجيل',
                        'upcoming' => 'قريباً',
                        'ongoing' => 'جارٍ',
                        'completed' => 'مكتمل',
                    ]),
            ])
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
            'index' => ListPrograms::route('/'),
            'create' => CreateProgram::route('/create'),
            'edit' => EditProgram::route('/{record}/edit'),
        ];
    }
}
