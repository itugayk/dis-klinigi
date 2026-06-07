<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class BlogCategory extends Model
{
    protected $guarded = [];

    protected static function booted(): void
    {
        static::saving(function (BlogCategory $c) {
            if (blank($c->slug) && filled($c->name)) {
                $c->slug = Str::slug($c->name);
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function posts(): HasMany
    {
        return $this->hasMany(BlogPost::class);
    }
}
