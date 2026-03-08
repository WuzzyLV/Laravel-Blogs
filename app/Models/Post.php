<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'body',
        'image',
        'published_at',
        'is_active',
    ];

    protected $casts = [
        'published_at' => 'date',
        'is_active' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function (Post $post) {
            if (empty($post->slug)) {
                $post->slug = static::generateUniqueSlug($post->title);
            }
        });

        static::updating(function (Post $post) {
            if ($post->isDirty('title') && ! $post->isDirty('slug')) {
                $post->slug = static::generateUniqueSlug($post->title, $post->id);
            }
        });
    }

    protected static function generateUniqueSlug(string $title, ?int $excludeId = null): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $i = 1;

        while (
            static::where('slug', $slug)
                ->when($excludeId, fn ($q) => $q->where('id', '!=', $excludeId))
                ->exists()
        ) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }
}
