<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class VerseAudio extends Model
{
    protected $table = 'verse_audio';

    protected $fillable = [
        'verse_id',
        'language',
        'version',
        'narrator',
        'audio_url',
        'file_format',
        'duration',
        'file_size',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'duration' => 'integer',
        'file_size' => 'integer',
    ];

    /**
     * Get the verse this audio belongs to.
     */
    public function verse(): BelongsTo
    {
        return $this->belongsTo(Verse::class);
    }

    /**
     * Scope to filter by language.
     */
    public function scopeForLanguage(Builder $query, string $language): Builder
    {
        return $query->where('language', $language);
    }

    /**
     * Scope to filter by version.
     */
    public function scopeForVersion(Builder $query, string $version): Builder
    {
        return $query->where('version', $version);
    }

    /**
     * Scope to get only active audio.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Get formatted duration (e.g., "2:30").
     */
    public function getFormattedDurationAttribute(): string
    {
        if (!$this->duration) {
            return '0:00';
        }

        $minutes = floor($this->duration / 60);
        $seconds = $this->duration % 60;

        return sprintf('%d:%02d', $minutes, $seconds);
    }

    /**
     * Get formatted file size (e.g., "2.5 MB").
     */
    public function getFormattedFileSizeAttribute(): string
    {
        if (!$this->file_size) {
            return '0 B';
        }

        $units = ['B', 'KB', 'MB', 'GB'];
        $size = $this->file_size;
        $unitIndex = 0;

        while ($size >= 1024 && $unitIndex < count($units) - 1) {
            $size /= 1024;
            $unitIndex++;
        }

        return round($size, 2) . ' ' . $units[$unitIndex];
    }
}

