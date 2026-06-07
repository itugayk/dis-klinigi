<?php

namespace App\Enums;

enum AppointmentStatus: string
{
    case Pending   = 'pending';
    case Confirmed = 'confirmed';
    case Completed = 'completed';
    case Cancelled = 'cancelled';
    case NoShow    = 'no_show';

    public function label(): string
    {
        return match ($this) {
            self::Pending   => 'Onay Bekliyor',
            self::Confirmed => 'Onaylandı',
            self::Completed => 'Tamamlandı',
            self::Cancelled => 'İptal Edildi',
            self::NoShow    => 'Gelmedi',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Pending   => 'warning',
            self::Confirmed => 'success',
            self::Completed => 'info',
            self::Cancelled => 'danger',
            self::NoShow    => 'gray',
        };
    }

    /** Bu durumdaki randevu slotu "dolu" sayılır mı? (iptal/gelmedi → slot tekrar açılır) */
    public function blocksSlot(): bool
    {
        return in_array($this, [self::Pending, self::Confirmed, self::Completed], true);
    }

    /** Filament / form select için. */
    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn (self $s) => [$s->value => $s->label()])
            ->all();
    }
}
