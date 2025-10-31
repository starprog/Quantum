<?php

namespace App\Services;

use App\Models\Verse;
use App\Models\VerseCategory;
use Illuminate\Support\Carbon;

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
    }
}