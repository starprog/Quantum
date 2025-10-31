<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Church extends Model
{
    use HasFactory;

    protected $fillable = [
        'place_id',
        'name',
        'address',
        'phone',
        'website',
        'latitude',
        'longitude',
        'rating',
        'user_ratings_total',
        'types',
        'vicinity',
        'photo_reference',
    ];

    protected $casts = [
        'types' => 'array',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
        'rating' => 'decimal:1',
    ];

    /**
     * Users who have favorited this church
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_churches')
            ->withTimestamps();
    }

    /**
     * Get the photo URL for this church
     */
    public function getPhotoUrlAttribute(): ?string
    {
        if (!$this->photo_reference) {
            return null;
        }

        $apiKey = config('services.google.places_api_key');
        return "https://maps.googleapis.com/maps/api/place/photo?maxwidth=400&photo_reference={$this->photo_reference}&key={$apiKey}";
    }

    /**
     * Get Google Maps directions URL
     */
    public function getDirectionsUrlAttribute(): string
    {
        return "https://www.google.com/maps/dir/?api=1&destination={$this->latitude},{$this->longitude}";
    }
}
