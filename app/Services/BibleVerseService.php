<?php

namespace App\Services;

use App\Models\Verse;
use App\Models\VerseCategory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

/**
 * Bible Verse Service
 * 
 * Handles all verse retrieval, caching, and search operations.
 * Provides optimized methods for displaying verses with performance-focused caching.
 * 
 * @package App\Services
 */
class BibleVerseService
{
    /**
     * Get all verses with their categories
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllVerses()
    {
        return Verse::with('category')->get();
    }

    /**
     * Get verses filtered by category
     * 
     * @param int $categoryId The category ID to filter by
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getVersesByCategory($categoryId)
    {
        return Verse::where('category_id', $categoryId)->with('category')->get();
    }

    /**
     * Get all verse categories
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllCategories()
    {
        return VerseCategory::select(['id', 'name', 'description'])
            ->orderBy('name')
            ->get();
    }

    /**
     * Get a random verse, optionally filtered by category name
     * 
     * @param string|null $categoryName Optional category name to filter by
     * @return \App\Models\Verse|null
     */
    public function getRandomVerse($categoryName = null)
    {
        $query = Verse::with('category');
        
        if ($categoryName) {
            $query->whereHas('category', function($q) use ($categoryName) {
                $q->where('name', $categoryName);
            });
        }
        
        return $query->inRandomOrder()->first();
    }

    /**
     * Get the verse of the day with caching
     * 
     * Uses date-based seeding to ensure the same verse is returned for the entire day.
     * Cached until midnight for optimal performance.
     * 
     * @return \App\Models\Verse|null
     */
    public function getVerseOfTheDay()
    {
        // Cache key based on today's date
        $cacheKey = 'verse_of_the_day_' . Carbon::now()->format('Y-m-d');
        
        // Get cache expiry at midnight
        $expiresAt = Carbon::now()->endOfDay();
        
        return Cache::remember($cacheKey, $expiresAt, function () {
            try {
                // Get the total number of verses
                $count = Verse::count();
                if ($count === 0) {
                    return null;
                }

                // Get today's date components
                $date = Carbon::now();
                $seed = ($date->year * 1000) + $date->dayOfYear;
                
                // Get a verse based on today's date
                $verse = Verse::with('category')
                    ->offset($seed % $count)
                    ->first();
                    
                return $verse ?: $this->getRandomVerse();
            } catch (\Exception $e) {
                return $this->getRandomVerse();
            }
        });
    }

    /**
     * Search verses by text or reference
     * 
     * @param string $searchTerm
     * @param int|null $categoryId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function searchVerses($searchTerm, $categoryId = null)
    {
        $query = Verse::with('category');

        if (!empty($searchTerm)) {
            $query->where(function($q) use ($searchTerm) {
                $q->where('verse', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('reference', 'LIKE', '%' . $searchTerm . '%');
            });
        }

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        return $query->orderBy('reference')->get();
    }

    /**
     * Clear the cached verse of the day
     * Useful after seeding or updating verses
     * 
     * @return bool
     */
    public function clearDailyVerseCache()
    {
        $cacheKey = 'verse_of_the_day_' . Carbon::now()->format('Y-m-d');
        return Cache::forget($cacheKey);
    }
}