<?php

namespace App\Filament\Widgets;

use App\Enums\AppointmentStatus;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Testimonial;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AppointmentStatsWidget extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $today = Appointment::whereDate('date', today())->count();
        $pending = Appointment::where('status', AppointmentStatus::Pending->value)->count();
        $upcoming = Appointment::whereDate('date', '>=', today())
            ->whereIn('status', [AppointmentStatus::Pending->value, AppointmentStatus::Confirmed->value])
            ->count();

        // Son 7 günün günlük randevu sayısı (trend grafiği için)
        $trend = collect(range(6, 0))->map(
            fn ($d) => Appointment::whereDate('created_at', today()->subDays($d))->count()
        )->all();

        return [
            Stat::make('Bugünkü randevular', $today)
                ->description('Bugün için planlanan')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('info'),

            Stat::make('Onay bekleyen', $pending)
                ->description($pending > 0 ? 'İşlem gerekiyor' : 'Hepsi güncel')
                ->descriptionIcon($pending > 0 ? 'heroicon-m-exclamation-triangle' : 'heroicon-m-check-circle')
                ->color($pending > 0 ? 'warning' : 'success')
                ->chart($trend),

            Stat::make('Yaklaşan randevular', $upcoming)
                ->description('Aktif & onaylı')
                ->descriptionIcon('heroicon-m-clock')
                ->color('primary'),

            Stat::make('Aktif hekim', Doctor::where('is_active', true)->count())
                ->description(Testimonial::where('is_approved', false)->count().' yorum onay bekliyor')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('gray'),
        ];
    }
}
