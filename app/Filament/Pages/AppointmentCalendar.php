<?php

namespace App\Filament\Pages;

use App\Models\Appointment;
use Carbon\Carbon;
use Filament\Pages\Page;

class AppointmentCalendar extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    protected static ?string $navigationGroup = 'Randevular';
    protected static ?string $navigationLabel = 'Randevu Takvimi';
    protected static ?string $title = 'Randevu Takvimi';
    protected static ?int $navigationSort = 2;

    protected static string $view = 'filament.pages.appointment-calendar';

    public string $month;

    public function mount(): void
    {
        $this->month = today()->startOfMonth()->toDateString();
    }

    public function prevMonth(): void
    {
        $this->month = Carbon::parse($this->month)->subMonth()->startOfMonth()->toDateString();
    }

    public function nextMonth(): void
    {
        $this->month = Carbon::parse($this->month)->addMonth()->startOfMonth()->toDateString();
    }

    public function today(): void
    {
        $this->month = today()->startOfMonth()->toDateString();
    }

    public function getMonthLabelProperty(): string
    {
        return Carbon::parse($this->month)->translatedFormat('F Y');
    }

    /** @return array<int, array<int, array>> Haftalara bölünmüş günler */
    public function getWeeksProperty(): array
    {
        $first = Carbon::parse($this->month)->startOfMonth();
        $start = $first->copy()->startOfWeek(Carbon::MONDAY);
        $end   = $first->copy()->endOfMonth()->endOfWeek(Carbon::SUNDAY);

        $appointments = Appointment::query()
            ->with(['doctor', 'treatment'])
            ->whereBetween('date', [$start->toDateString(), $end->toDateString()])
            ->orderBy('start_time')
            ->get()
            ->groupBy(fn ($a) => $a->date->toDateString());

        $weeks = [];
        $cursor = $start->copy();
        while ($cursor->lte($end)) {
            $week = [];
            for ($i = 0; $i < 7; $i++) {
                $ds = $cursor->toDateString();
                $week[] = [
                    'date'    => $ds,
                    'day'     => $cursor->day,
                    'inMonth' => $cursor->month === $first->month,
                    'isToday' => $cursor->isToday(),
                    'items'   => $appointments->get($ds, collect()),
                ];
                $cursor->addDay();
            }
            $weeks[] = $week;
        }

        return $weeks;
    }
}
