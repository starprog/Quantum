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
        return VerseCategory::all();
    }

    public function getRandomVerse($categoryId = null)
    {
        $query = Verse::with('category');
        
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }
        
        return $query->inRandomOrder()->first();
    }
}