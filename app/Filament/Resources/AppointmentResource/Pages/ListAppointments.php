<?php

namespace App\Filament\Resources\AppointmentResource\Pages;

use App\Enums\AppointmentStatus;
use App\Filament\Resources\AppointmentResource;
use App\Models\Appointment;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListAppointments extends ListRecords
{
    protected static string $resource = AppointmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Randevu ekle'),
        ];
    }

    public function getTabs(): array
    {
        return [
            'today' => Tab::make('Bugün')
                ->icon('heroicon-m-sun')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereDate('date', today()))
                ->badge(Appointment::whereDate('date', today())->count()),

            'pending' => Tab::make('Onay bekleyen')
                ->icon('heroicon-m-clock')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', AppointmentStatus::Pending->value))
                ->badge(Appointment::where('status', AppointmentStatus::Pending->value)->count())
                ->badgeColor('warning'),

            'upcoming' => Tab::make('Yaklaşan')
                ->icon('heroicon-m-calendar')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereDate('date', '>=', today())
                    ->whereIn('status', [AppointmentStatus::Pending->value, AppointmentStatus::Confirmed->value])),

            'past' => Tab::make('Geçmiş')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereDate('date', '<', today())),

            'all' => Tab::make('Tümü'),
        ];
    }
}
