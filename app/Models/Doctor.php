<?php

namespace App\Models;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Doctor extends Model
{
    protected $guarded = [];

    protected $casts = [
        'specialties'          => 'array',
        'accepts_appointments' => 'boolean',
        'is_active'            => 'boolean',
        'experience_years'     => 'integer',
        'sort_order'           => 'integer',
    ];

    protected static function booted(): void
    {
        static::saving(function (Doctor $d) {
            if (blank($d->slug) && filled($d->name)) {
                $d->slug = Str::slug($d->name);
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getFullNameAttribute(): string
    {
        return trim(($this->title ? $this->title.' ' : '').$this->name);
    }

    public function treatments(): BelongsToMany
    {
        return $this->belongsToMany(Treatment::class);
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(DoctorSchedule::class);
    }

    public function timeOff(): HasMany
    {
        return $this->hasMany(DoctorTimeOff::class);
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    public function scopeActive(Builder $q): Builder
    {
        return $q->where('is_active', true);
    }

    public function scopeBookable(Builder $q): Builder
    {
        return $q->where('is_active', true)->where('accepts_appointments', true);
    }

    /** Verilen tarih bu hekimin izin/tatil aralığına denk geliyor mu? */
    public function isOnLeave(CarbonInterface $date): bool
    {
        return $this->timeOff()
            ->whereDate('start_date', '<=', $date->toDateString())
            ->whereDate('end_date', '>=', $date->toDateString())
            ->exists();
    }
}
