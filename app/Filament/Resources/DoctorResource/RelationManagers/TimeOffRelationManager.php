<?php

namespace App\Filament\Resources\DoctorResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class TimeOffRelationManager extends RelationManager
{
    protected static string $relationship = 'timeOff';
    protected static ?string $title = 'İzin / Tatil Günleri';
    protected static ?string $modelLabel = 'izin kaydı';

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\DatePicker::make('start_date')->label('Başlangıç tarihi')->required()->native(false),
            Forms\Components\DatePicker::make('end_date')->label('Bitiş tarihi')->required()->native(false)
                ->afterOrEqual('start_date'),
            Forms\Components\TextInput::make('reason')->label('Açıklama')->maxLength(255)->columnSpanFull()
                ->placeholder('Yıllık izin, kongre, vb.'),
        ])->columns(2);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('reason')
            ->defaultSort('start_date', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('start_date')->label('Başlangıç')->date('d.m.Y'),
                Tables\Columns\TextColumn::make('end_date')->label('Bitiş')->date('d.m.Y'),
                Tables\Columns\TextColumn::make('reason')->label('Açıklama')->placeholder('—'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->label('İzin ekle'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->emptyStateHeading('İzin günü yok')
            ->emptyStateDescription('Bu aralıklarda hekime randevu verilmez.');
    }
}
