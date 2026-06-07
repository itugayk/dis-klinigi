<?php

namespace App\Services;

use App\Enums\AppointmentStatus;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Treatment;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Support\Collection;

/**
 * Randevu slot motoru.
 *
 * Bir hekim + tarih (+ opsiyonel tedavi) için uygun saat slotlarını üretir:
 *  - hekimin o güne ait çalışma takvimi (doctor_schedules)
 *  - öğle arası
 *  - hekim izinleri (doctor_time_off)
 *  - klinik tatil günleri (settings.holidays)
 *  - o güne zaten alınmış (aktif) randevular
 * dikkate alınır. Dolu / geçmiş slotlar listelenmez.
 */
class SlotService
{
    public function slotMinutes(): int
    {
        return (int) site('slot_minutes', 30);
    }

    public function horizonDays(): int
    {
        return (int) site('booking_horizon_days', 30);
    }

    /** Klinik geneli kapalı günler (YYYY-MM-DD listesi). */
    public function holidays(): array
    {
        $h = site('holidays', []);

        return is_array($h) ? $h : [];
    }

    public function isHoliday(CarbonInterface $date): bool
    {
        return in_array($date->toDateString(), $this->holidays(), true);
    }

    /**
     * Verilen hekim ve gün için uygun slotları döndürür.
     *
     * @return array<int, array{start:string, end:string, label:string}>
     */
    public function availableSlots(Doctor $doctor, CarbonInterface $date, ?Treatment $treatment = null): array
    {
        $date = Carbon::parse($date)->startOfDay();

        // Geçmiş gün veya horizon dışı → boş
        if ($date->lt(today()) || $date->gt(today()->addDays($this->horizonDays()))) {
            return [];
        }

        if ($this->isHoliday($date) || $doctor->isOnLeave($date)) {
            return [];
        }

        $schedules = $doctor->schedules()
            ->where('day_of_week', $date->dayOfWeek)   // 0=Pazar..6=Cumartesi
            ->where('is_active', true)
            ->get();

        if ($schedules->isEmpty()) {
            return [];
        }

        $step = $this->slotMinutes();
        $duration = $treatment?->duration_minutes ?: $step;
        // Slot başlangıçları step granülasyonunda; tedavi süresi kapladığı yeri belirler.

        $booked = $this->bookedRanges($doctor, $date);
        $now = now();

        $slots = [];

        foreach ($schedules as $schedule) {
            $cursor = $date->copy()->setTimeFromTimeString((string) $schedule->start_time);
            $end    = $date->copy()->setTimeFromTimeString((string) $schedule->end_time);

            $breakStart = $schedule->break_start
                ? $date->copy()->setTimeFromTimeString((string) $schedule->break_start) : null;
            $breakEnd = $schedule->break_end
                ? $date->copy()->setTimeFromTimeString((string) $schedule->break_end) : null;

            while ($cursor->copy()->addMinutes($duration)->lte($end)) {
                $slotStart = $cursor->copy();
                $slotEnd   = $cursor->copy()->addMinutes($duration);

                $blocked = false;

                // Bugünse ve geçmiş saat ise atla
                if ($date->isToday() && $slotStart->lte($now)) {
                    $blocked = true;
                }

                // Öğle arası ile çakışma
                if (! $blocked && $breakStart && $breakEnd
                    && $slotStart->lt($breakEnd) && $slotEnd->gt($breakStart)) {
                    $blocked = true;
                }

                // Dolu randevu ile çakışma
                if (! $blocked) {
                    foreach ($booked as [$bStart, $bEnd]) {
                        if ($slotStart->lt($bEnd) && $slotEnd->gt($bStart)) {
                            $blocked = true;
                            break;
                        }
                    }
                }

                if (! $blocked) {
                    $slots[$slotStart->format('H:i')] = [
                        'start' => $slotStart->format('H:i'),
                        'end'   => $slotEnd->format('H:i'),
                        'label' => $slotStart->format('H:i'),
                    ];
                }

                $cursor->addMinutes($step);
            }
        }

        ksort($slots);

        return array_values($slots);
    }

    /**
     * O gün dolu sayılan randevu zaman aralıkları [[start, end], ...].
     *
     * @return array<int, array{0:Carbon,1:Carbon}>
     */
    protected function bookedRanges(Doctor $doctor, CarbonInterface $date): array
    {
        return Appointment::query()
            ->where('doctor_id', $doctor->id)
            ->whereDate('date', $date->toDateString())
            ->whereIn('status', [
                AppointmentStatus::Pending->value,
                AppointmentStatus::Confirmed->value,
                AppointmentStatus::Completed->value,
            ])
            ->get(['start_time', 'end_time'])
            ->map(fn ($a) => [
                $date->copy()->setTimeFromTimeString((string) $a->start_time),
                $date->copy()->setTimeFromTimeString((string) $a->end_time),
            ])
            ->all();
    }

    /** Belirli slot hâlâ uygun mu? (yarış koşulu / kayıt öncesi son kontrol) */
    public function isSlotAvailable(Doctor $doctor, CarbonInterface $date, string $startTime, ?Treatment $treatment = null): bool
    {
        return collect($this->availableSlots($doctor, $date, $treatment))
            ->contains('start', substr($startTime, 0, 5));
    }

    /**
     * Önümüzdeki günlerden, hekimin slot açtığı tarihleri döndürür (takvim için).
     *
     * @return Collection<int, string> YYYY-MM-DD
     */
    public function availableDates(Doctor $doctor, ?Treatment $treatment = null): Collection
    {
        $dates = collect();
        for ($i = 0; $i <= $this->horizonDays(); $i++) {
            $d = today()->addDays($i);
            if (! empty($this->availableSlots($doctor, $d, $treatment))) {
                $dates->push($d->toDateString());
            }
        }

        return $dates;
    }
}
