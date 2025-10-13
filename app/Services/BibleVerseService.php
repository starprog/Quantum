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
}