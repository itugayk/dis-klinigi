<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Treatment extends Model
{
    protected $guarded = [];

    protected $casts = [
        'benefits'        => 'array',
        'price_from'      => 'decimal:2',
        'featured'        => 'boolean',
        'is_active'       => 'boolean',
        'duration_minutes'=> 'integer',
        'sort_order'      => 'integer',
    ];

    protected static function booted(): void
    {
        static::saving(function (Treatment $t) {
            if (blank($t->slug) && filled($t->name)) {
                $t->slug = Str::slug($t->name);
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function doctors(): BelongsToMany
    {
        return $this->belongsToMany(Doctor::class);
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    public function galleryCases(): HasMany
    {
        return $this->hasMany(GalleryCase::class);
    }

    public function scopeActive(Builder $q): Builder
    {
        return $q->where('is_active', true);
    }

    public function scopeFeatured(Builder $q): Builder
    {
        return $q->where('featured', true);
    }
}
