<?php

namespace App\Services;

use App\Models\Verse;
use App\Models\VerseCategory;
use Illuminate\Database\Eloquent\Collection;

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

    public function getRandomVerse($category = null)
    {
        $query = Verse::with('category');
        
        if ($category) {
            $query->whereHas('category', function($q) use ($category) {
                $q->where('name', $category);
            });
        }
        
        return $query->inRandomOrder()->first();
    }

    public function getVerseOfTheDay()
    {
        // Use the current date as a seed to get a consistent verse for the whole day
        $dayOfYear = now()->dayOfYear;
        $year = now()->year;
        
        // Get total number of verses
        $totalVerses = Verse::count();
        
        // Use the day and year to deterministically select a verse
        // This ensures the same verse is shown all day, but changes daily
        $index = (($dayOfYear + $year) % $totalVerses) + 1;
        
        return Verse::with('category')
            ->skip($index - 1)
            ->take(1)
            ->first();
    }
}