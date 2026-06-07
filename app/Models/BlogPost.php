<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class BlogPost extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $guarded = [];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::saving(function (BlogPost $p) {
            if (blank($p->slug) && filled($p->title)) {
                $p->slug = Str::slug($p->title);
            }
            if ($p->is_published && blank($p->published_at)) {
                $p->published_at = now();
            }
            if (blank($p->reading_minutes) && filled($p->body)) {
                $words = str_word_count(strip_tags($p->body));
                $p->reading_minutes = max(1, (int) ceil($words / 200));
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('cover')->singleFile();
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id');
    }

    /** Spatie media yoksa seed/fallback cover_url'e düş. */
    public function coverUrl(): ?string
    {
        $media = $this->getFirstMediaUrl('cover');

        return $media ?: $this->cover_url;
    }

    public function scopePublished(Builder $q): Builder
    {
        return $q->where('is_published', true)
            ->where(function ($q) {
                $q->whereNull('published_at')->orWhere('published_at', '<=', now());
            });
    }
}
