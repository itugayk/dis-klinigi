<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TestimonialResource\Pages;
use App\Models\Testimonial;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TestimonialResource extends Resource
{
    protected static ?string $model = Testimonial::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    protected static ?string $navigationGroup = 'İçerik Yönetimi';
    protected static ?string $navigationLabel = 'Hasta Yorumları';
    protected static ?string $modelLabel = 'Yorum';
    protected static ?string $pluralModelLabel = 'Hasta Yorumları';
    protected static ?int $navigationSort = 3;

    public static function getNavigationBadge(): ?string
    {
        $count = static::getModel()::where('is_approved', false)->count();

        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make()
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('patient_name')->label('Hasta adı')->required(),
                    Forms\Components\TextInput::make('treatment_label')->label('Tedavi (etiket)')->placeholder('İmplant tedavisi'),
                    Forms\Components\Select::make('rating')->label('Puan')
                        ->options([5 => '★★★★★', 4 => '★★★★', 3 => '★★★', 2 => '★★', 1 => '★'])
                        ->default(5)->required()->native(false),
                    Forms\Components\TextInput::make('avatar_url')->label('Avatar URL')->url(),
                    Forms\Components\Textarea::make('body')->label('Yorum metni')->rows(4)->required()->columnSpanFull(),
                    Forms\Components\Toggle::make('is_approved')->label('Onaylı (sitede görünür)')->inline(false),
                    Forms\Components\Toggle::make('is_featured')->label('Öne çıkan')->inline(false),
                    Forms\Components\TextInput::make('sort_order')->label('Sıra')->numeric()->default(0),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('patient_name')->label('Hasta')->searchable()->weight('bold')
                    ->description(fn (Testimonial $r) => $r->treatment_label),
                Tables\Columns\TextColumn::make('rating')->label('Puan')
                    ->formatStateUsing(fn ($state) => str_repeat('★', (int) $state))->color('warning'),
                Tables\Columns\TextColumn::make('body')->label('Yorum')->limit(60)->wrap(),
                Tables\Columns\IconColumn::make('is_approved')->label('Onaylı')->boolean(),
                Tables\Columns\IconColumn::make('is_featured')->label('Öne çıkan')->boolean(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_approved')->label('Onay durumu'),
            ])
            ->actions([
                Tables\Actions\Action::make('approve')
                    ->label('Onayla')->icon('heroicon-m-check-circle')->color('success')
                    ->visible(fn (Testimonial $r) => ! $r->is_approved)
                    ->action(fn (Testimonial $r) => $r->update(['is_approved' => true])),
                Tables\Actions\Action::make('unapprove')
                    ->label('Yayından kaldır')->icon('heroicon-m-eye-slash')->color('gray')
                    ->visible(fn (Testimonial $r) => $r->is_approved)
                    ->action(fn (Testimonial $r) => $r->update(['is_approved' => false])),
                Tables\Actions\EditAction::make()->label(''),
                Tables\Actions\DeleteAction::make()->label(''),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('approveAll')->label('Seçilenleri onayla')->icon('heroicon-m-check-circle')->color('success')
                        ->action(fn ($records) => $records->each->update(['is_approved' => true]))->deselectRecordsAfterCompletion(),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListTestimonials::route('/'),
            'create' => Pages\CreateTestimonial::route('/create'),
            'edit'   => Pages\EditTestimonial::route('/{record}/edit'),
        ];
    }
}
