<?php

namespace App\Services;

use App\Models\Verse;
use App\Models\VerseCategory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

class BibleVerseService
{
    public function getAllVerses()
    {
        return Verse::with('category')->get();
    }

    public function getVersesByCategory($categoryId)
    {
        return Verse::where('category_id', $categoryId)->with('category')->get();
    }

    public function getAllCategories()
    {
        return VerseCategory::select(['id', 'name', 'description'])
            ->orderBy('name')
            ->get();
    }

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