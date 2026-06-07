<?php

namespace App\Models;

use App\Enums\AppointmentStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Appointment extends Model
{
    protected $guarded = [];

    protected $casts = [
        'date'       => 'date',
        'status'     => AppointmentStatus::class,
    ];

    protected static function booted(): void
    {
        static::creating(function (Appointment $a) {
            if (blank($a->appointment_no)) {
                $a->appointment_no = 'RND-'.now()->format('ymd').'-'.Str::upper(Str::random(5));
            }
        });
    }

    public function treatment(): BelongsTo
    {
        return $this->belongsTo(Treatment::class);
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }

    /** Saat aralığı etiketi: 14:00 - 14:45 */
    public function getTimeRangeAttribute(): string
    {
        return substr((string) $this->start_time, 0, 5).' - '.substr((string) $this->end_time, 0, 5);
    }

    /** Slotu meşgul eden (aktif) randevular. */
    public function scopeBlocking(Builder $q): Builder
    {
        return $q->whereIn('status', [
            AppointmentStatus::Pending->value,
            AppointmentStatus::Confirmed->value,
            AppointmentStatus::Completed->value,
        ]);
    }

    public function scopeUpcoming(Builder $q): Builder
    {
        return $q->whereDate('date', '>=', today());
    }
}
