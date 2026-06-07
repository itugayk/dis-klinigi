<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TreatmentResource\Pages;
use App\Models\Treatment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class TreatmentResource extends Resource
{
    protected static ?string $model = Treatment::class;

    protected static ?string $navigationIcon = 'heroicon-o-sparkles';
    protected static ?string $navigationGroup = 'İçerik Yönetimi';
    protected static ?string $navigationLabel = 'Tedaviler';
    protected static ?string $modelLabel = 'Tedavi';
    protected static ?string $pluralModelLabel = 'Tedaviler';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Tedavi Bilgileri')
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('Tedavi adı')->required()->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn (Forms\Set $set, ?string $state) => $set('slug', Str::slug((string) $state))),
                    Forms\Components\TextInput::make('slug')
                        ->label('URL (slug)')->required()->maxLength(255)
                        ->unique(ignoreRecord: true),
                    Forms\Components\Select::make('icon')
                        ->label('İkon')
                        ->options([
                            'implant' => 'İmplant', 'ortodonti' => 'Ortodonti', 'estetik' => 'Estetik',
                            'beyazlatma' => 'Beyazlatma', 'kanal' => 'Kanal tedavisi', 'cocuk' => 'Çocuk',
                            'tooth' => 'Diş (genel)', 'sparkle' => 'Parıltı', 'shield' => 'Kalkan', 'heart' => 'Kalp',
                        ])->default('tooth')->native(false),
                    Forms\Components\ColorPicker::make('color')->label('Kart rengi')->default('#15a3a8'),
                    Forms\Components\TextInput::make('excerpt')
                        ->label('Kısa açıklama')->maxLength(255)->columnSpanFull()
                        ->helperText('Kartlarda görünen tek satırlık özet.'),
                    Forms\Components\RichEditor::make('description')
                        ->label('Detaylı açıklama')->columnSpanFull(),
                    Forms\Components\TagsInput::make('benefits')
                        ->label('Faydalar / öne çıkanlar')->columnSpanFull()
                        ->placeholder('Madde ekleyin ve Enter')
                        ->helperText('Detay sayfasında liste olarak gösterilir.'),
                ]),
            Forms\Components\Section::make('Ayarlar')
                ->columns(3)
                ->schema([
                    Forms\Components\TextInput::make('price_from')
                        ->label('Başlangıç fiyatı (₺)')->numeric()->prefix('₺'),
                    Forms\Components\TextInput::make('duration_minutes')
                        ->label('Randevu süresi (dk)')->numeric()->default(45)->required()
                        ->helperText('Slot hesabında kullanılır.'),
                    Forms\Components\TextInput::make('sort_order')->label('Sıra')->numeric()->default(0),
                    Forms\Components\TextInput::make('image_url')->label('Görsel URL')->url()->columnSpan(2),
                    Forms\Components\Toggle::make('featured')->label('Öne çıkan')->inline(false),
                    Forms\Components\Toggle::make('is_active')->label('Aktif')->default(true)->inline(false),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->columns([
                Tables\Columns\ColorColumn::make('color')->label(''),
                Tables\Columns\TextColumn::make('name')->label('Tedavi')->searchable()->weight('bold'),
                Tables\Columns\TextColumn::make('duration_minutes')->label('Süre')->suffix(' dk')->sortable(),
                Tables\Columns\TextColumn::make('price_from')->label('Fiyat')->money('TRY')->sortable(),
                Tables\Columns\IconColumn::make('featured')->label('Öne çıkan')->boolean(),
                Tables\Columns\IconColumn::make('is_active')->label('Aktif')->boolean(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')->label('Aktif'),
                Tables\Filters\TernaryFilter::make('featured')->label('Öne çıkan'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListTreatments::route('/'),
            'create' => Pages\CreateTreatment::route('/create'),
            'edit'   => Pages\EditTreatment::route('/{record}/edit'),
        ];
    }
}
