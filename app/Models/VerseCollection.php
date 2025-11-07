<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class VerseCollection extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'is_public',
        'slug',
    ];

    protected $casts = [
        'is_public' => 'boolean',
    ];

    /**
     * Boot the model and create slug automatically
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($collection) {
            if (empty($collection->slug)) {
                $collection->slug = Str::slug($collection->name) . '-' . Str::random(6);
            }
        });
    }

    /**
     * Get the user that owns the collection
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the verses in this collection
     */
    public function verses(): BelongsToMany
    {
        return $this->belongsToMany(Verse::class, 'collection_verses')
            ->withTimestamps()
            ->withPivot('order')
            ->orderBy('order');
    }

    /**
     * Scope to get only public collections
     */
    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    /**
     * Scope to get collections by user
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Get the URL for this collection
     */
    public function getUrlAttribute(): string
    {
        return route('collections.show', $this->slug);
    }

    /**
     * Check if current user can edit this collection
     */
    public function canEdit(?User $user = null): bool
    {
        $user = $user ?? auth()->user();
        return $user && $user->id === $this->user_id;
    }
}

