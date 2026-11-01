<?php

namespace App\Filament\Resources\MediaItems;

use App\Filament\Resources\MediaItems\Pages\CreateMediaItem;
use App\Filament\Resources\MediaItems\Pages\EditMediaItem;
use App\Filament\Resources\MediaItems\Pages\ListMediaItems;
use App\Models\MediaItem;
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
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class MediaItemResource extends Resource
{
    protected static ?string $model = MediaItem::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPhoto;

    protected static string|\UnitEnum|null $navigationGroup = 'إدارة المحتوى والصفحات';

    protected static ?string $modelLabel = 'ملف وسائط أو فيديو';

    protected static ?string $pluralModelLabel = 'مكتبة الصور والوسائط';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('بيانات ملف الوسائط')
                    ->description('رفع صور البرامج والفعاليات أو تضمين روابط الفيديوهات وYouTube Shorts')
                    ->schema([
                        Grid::make(3)->schema([
                            TextInput::make('title')
                                ->label('عنوان المادة الإعلامية')
                                ->placeholder('مثال: ورشة إدارة الميزانية الأسرية')
                                ->required(),

                            Select::make('type')
                                ->label('نوع الوسائط')
                                ->options([
                                    'image' => 'صورة فوتوغرافية',
                                    'video' => 'مقطع فيديو مرفوع',
                                    'youtube_short' => 'YouTube Shorts / Reels',
                                    'infographic' => 'إنفوجرافيك وبوستر توعوي',
                                ])
                                ->default('image')
                                ->required(),

                            Select::make('category')
                                ->label('التصنيف')
                                ->options([
                                    'programs' => 'صور البرامج والدورات',
                                    'activities' => 'الأنشطة والفعاليات',
                                    'educational' => 'مواد وفيديوهات توعوية',
                                    'announcements' => 'إعلانات وحملات سابقة',
                                ])
                                ->default('activities')
                                ->required(),
                        ]),

                        Grid::make(2)->schema([
                            FileUpload::make('file_path')
                                ->label('رفع الملف (صورة أو وسائط)')
                                ->disk('public')
                                ->directory('media')
                                ->maxSize(10240) // 10MB
                                ->helperText('الحد الأقصى للملف: 10 ميجابايت'),

                            TextInput::make('external_url')
                                ->label('رابط خارجي (YouTube / Shorts / Drive)')
                                ->url()
                                ->placeholder('https://www.youtube.com/shorts/...'),
                        ]),

                        Textarea::make('description')
                            ->label('وصف توضيحي للمادة')
                            ->rows(2),

                        Grid::make(2)->schema([
                            TextInput::make('sort_order')
                                ->label('ترتيب العرض')
                                ->numeric()
                                ->default(0),

                            Toggle::make('is_published')
                                ->label('منشور في معرض الوسائط')
                                ->default(true),
                        ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('file_path')
                    ->label('المعاينة')
                    ->disk('public'),

                TextColumn::make('title')
                    ->label('العنوان')
                    ->searchable()
                    ->weight('bold'),

                TextColumn::make('type')
                    ->label('النوع')
                    ->badge()
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'image' => 'صورة',
                        'video' => 'فيديو',
                        'youtube_short' => 'Shorts',
                        'infographic' => 'إنفوجرافيك',
                        default => $state,
                    }),

                TextColumn::make('category')
                    ->label('التصنيف')
                    ->badge(),

                IconColumn::make('is_published')
                    ->label('منشور')
                    ->boolean(),
            ])
            ->defaultSort('sort_order', 'asc')
            ->filters([
                SelectFilter::make('category')
                    ->label('تصفية حسب التصنيف')
                    ->options([
                        'programs' => 'صور البرامج',
                        'activities' => 'الأنشطة',
                        'educational' => 'توعوية',
                        'announcements' => 'إعلانات',
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
            'index' => ListMediaItems::route('/'),
            'create' => CreateMediaItem::route('/create'),
            'edit' => EditMediaItem::route('/{record}/edit'),
        ];
    }
}
