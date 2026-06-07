<?php

namespace App\Filament\Resources\DoctorResource\RelationManagers;

use App\Models\DoctorSchedule;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class SchedulesRelationManager extends RelationManager
{
    protected static string $relationship = 'schedules';
    protected static ?string $title = 'Çalışma Saatleri';
    protected static ?string $modelLabel = 'çalışma günü';

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('day_of_week')
                ->label('Gün')->options(DoctorSchedule::DAYS)->required()->native(false),
            Forms\Components\Toggle::make('is_active')->label('Aktif')->default(true),
            Forms\Components\TimePicker::make('start_time')->label('Başlangıç')->seconds(false)->required(),
            Forms\Components\TimePicker::make('end_time')->label('Bitiş')->seconds(false)->required(),
            Forms\Components\TimePicker::make('break_start')->label('Öğle arası başlangıç')->seconds(false),
            Forms\Components\TimePicker::make('break_end')->label('Öğle arası bitiş')->seconds(false),
        ])->columns(2);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('day_of_week')
            ->defaultSort('day_of_week')
            ->columns([
                Tables\Columns\TextColumn::make('day_of_week')->label('Gün')
                    ->formatStateUsing(fn ($state) => DoctorSchedule::DAYS[$state] ?? $state)->badge(),
                Tables\Columns\TextColumn::make('start_time')->label('Başlangıç')->time('H:i'),
                Tables\Columns\TextColumn::make('end_time')->label('Bitiş')->time('H:i'),
                Tables\Columns\TextColumn::make('break_start')->label('Öğle')->time('H:i')->placeholder('—'),
                Tables\Columns\IconColumn::make('is_active')->label('Aktif')->boolean(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->label('Gün ekle'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->emptyStateHeading('Henüz çalışma saati eklenmemiş')
            ->emptyStateDescription('Hekim için haftalık çalışma günlerini ekleyin; randevu slotları buna göre üretilir.');
    }
}
