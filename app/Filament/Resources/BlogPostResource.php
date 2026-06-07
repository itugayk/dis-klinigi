<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlogPostResource\Pages;
use App\Models\BlogPost;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class BlogPostResource extends Resource
{
    protected static ?string $model = BlogPost::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    protected static ?string $navigationGroup = 'İçerik Yönetimi';
    protected static ?string $navigationLabel = 'Blog Yazıları';
    protected static ?string $modelLabel = 'Blog Yazısı';
    protected static ?string $pluralModelLabel = 'Blog Yazıları';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make()
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('title')->label('Başlık')->required()->maxLength(255)
                        ->live(onBlur: true)->columnSpanFull()
                        ->afterStateUpdated(fn (Forms\Set $set, ?string $state) => $set('slug', Str::slug((string) $state))),
                    Forms\Components\TextInput::make('slug')->label('URL (slug)')->required()->unique(ignoreRecord: true),
                    Forms\Components\Select::make('blog_category_id')->label('Kategori')
                        ->relationship('category', 'name')->searchable()->preload()
                        ->createOptionForm([
                            Forms\Components\TextInput::make('name')->label('Ad')->required()
                                ->afterStateUpdated(fn (Forms\Set $set, $state) => $set('slug', Str::slug((string) $state)))->live(onBlur: true),
                            Forms\Components\TextInput::make('slug')->required(),
                        ]),
                    Forms\Components\Textarea::make('excerpt')->label('Özet')->rows(2)->columnSpanFull()
                        ->maxLength(500)->helperText('Listede ve SEO açıklamasında kullanılır.'),
                    Forms\Components\RichEditor::make('body')->label('İçerik')->columnSpanFull()
                        ->fileAttachmentsDisk('public')->fileAttachmentsDirectory('blog/attachments'),
                ]),
            Forms\Components\Section::make('Görsel & Yayın')
                ->columns(2)
                ->schema([
                    Forms\Components\SpatieMediaLibraryFileUpload::make('cover')
                        ->label('Kapak görseli')->collection('cover')->image()
                        ->imageEditor()->columnSpanFull(),
                    Forms\Components\TextInput::make('author')->label('Yazar')->placeholder(site('short_name')),
                    Forms\Components\TextInput::make('reading_minutes')->label('Okuma süresi (dk)')->numeric()
                        ->helperText('Boş bırakılırsa otomatik hesaplanır.'),
                    Forms\Components\Toggle::make('is_published')->label('Yayında')->default(true)->inline(false),
                    Forms\Components\DateTimePicker::make('published_at')->label('Yayın tarihi')->native(false),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('published_at', 'desc')
            ->columns([
                Tables\Columns\SpatieMediaLibraryImageColumn::make('cover')->label('')->collection('cover')
                    ->height(44)->extraImgAttributes(['class' => 'rounded-lg object-cover']),
                Tables\Columns\TextColumn::make('title')->label('Başlık')->searchable()->weight('bold')->limit(50),
                Tables\Columns\TextColumn::make('category.name')->label('Kategori')->badge()->color('info')->placeholder('—'),
                Tables\Columns\TextColumn::make('published_at')->label('Tarih')->date('d.m.Y')->sortable(),
                Tables\Columns\IconColumn::make('is_published')->label('Yayında')->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('blog_category_id')->label('Kategori')->relationship('category', 'name'),
                Tables\Filters\TernaryFilter::make('is_published')->label('Yayında'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListBlogPosts::route('/'),
            'create' => Pages\CreateBlogPost::route('/create'),
            'edit'   => Pages\EditBlogPost::route('/{record}/edit'),
        ];
    }
}
