<?php

namespace App\Filament\Widgets;

use App\Enums\AppointmentStatus;
use App\Models\Appointment;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class UpcomingAppointmentsWidget extends BaseWidget
{
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 'full';
    protected static ?string $heading = 'Yaklaşan Randevular';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Appointment::query()
                    ->whereDate('date', '>=', today())
                    ->whereIn('status', [AppointmentStatus::Pending->value, AppointmentStatus::Confirmed->value])
                    ->orderBy('date')->orderBy('start_time')
            )
            ->defaultPaginationPageOption(5)
            ->columns([
                Tables\Columns\TextColumn::make('date')->label('Tarih')->date('d.m.Y')
                    ->description(fn (Appointment $r) => $r->time_range),
                Tables\Columns\TextColumn::make('patient_name')->label('Hasta')->weight('bold')
                    ->description(fn (Appointment $r) => $r->patient_phone),
                Tables\Columns\TextColumn::make('doctor.name')->label('Hekim')
                    ->formatStateUsing(fn (Appointment $r) => $r->doctor?->full_name),
                Tables\Columns\TextColumn::make('treatment.name')->label('Tedavi')->badge()->color('info')->placeholder('Genel'),
                Tables\Columns\TextColumn::make('status')->label('Durum')->badge()
                    ->formatStateUsing(fn (AppointmentStatus $state) => $state->label())
                    ->color(fn (AppointmentStatus $state) => $state->color()),
            ])
            ->actions([
                Tables\Actions\Action::make('confirm')
                    ->label('Onayla')->icon('heroicon-m-check-circle')->color('success')->size('sm')
                    ->visible(fn (Appointment $r) => $r->status === AppointmentStatus::Pending)
                    ->action(fn (Appointment $r) => $r->update(['status' => AppointmentStatus::Confirmed])),
            ])
            ->emptyStateHeading('Yaklaşan randevu yok')
            ->emptyStateIcon('heroicon-o-calendar');
    }
}
