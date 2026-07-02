<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GalleryCaseResource\Pages;
use App\Models\GalleryCase;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class GalleryCaseResource extends Resource
{
    protected static ?string $model = GalleryCase::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationGroup = 'İçerik Yönetimi';
    protected static ?string $navigationLabel = 'Galeri (Öncesi/Sonrası)';
    protected static ?string $modelLabel = 'Vaka';
    protected static ?string $pluralModelLabel = 'Galeri Vakaları';
    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make()
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('title')->label('Vaka başlığı')->required()->columnSpanFull(),
                    Forms\Components\Select::make('treatment_id')->label('Tedavi')
                        ->relationship('treatment', 'name')->searchable()->preload(),
                    Forms\Components\TextInput::make('sort_order')->label('Sıra')->numeric()->default(0),
                    Forms\Components\FileUpload::make('before_url')->label('Öncesi görseli')->image()->directory('gallery')->required(),
                    Forms\Components\FileUpload::make('after_url')->label('Sonrası görseli')->image()->directory('gallery')->required(),
                    Forms\Components\Textarea::make('description')->label('Açıklama')->rows(2)->columnSpanFull(),
                    Forms\Components\Toggle::make('is_published')->label('Yayında')->default(true),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->columns([
                Tables\Columns\ImageColumn::make('before_url')->label('Öncesi')->height(44),
                Tables\Columns\ImageColumn::make('after_url')->label('Sonrası')->height(44),
                Tables\Columns\TextColumn::make('title')->label('Başlık')->searchable()->weight('bold'),
                Tables\Columns\TextColumn::make('treatment.name')->label('Tedavi')->badge()->color('info')->placeholder('—'),
                Tables\Columns\IconColumn::make('is_published')->label('Yayında')->boolean(),
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
            'index'  => Pages\ListGalleryCases::route('/'),
            'create' => Pages\CreateGalleryCase::route('/create'),
            'edit'   => Pages\EditGalleryCase::route('/{record}/edit'),
        ];
    }
}
