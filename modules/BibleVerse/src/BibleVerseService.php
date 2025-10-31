<?php

namespace Modules\BibleVerse\src;

use App\Models\Verse;
use App\Models\VerseCategory;

class BibleVerseService
{
    public function getRandomVerse(string $category = null)
    {
        $query = Verse::with('category');

        if ($category) {
            $query->whereHas('category', function($q) use ($category) {
                $q->where('name', $category);
            });
        }

        return $query->inRandomOrder()->first();
    }

    public function getCategories()
    {
        return VerseCategory::query()->orderBy('name')->get(['id', 'name', 'description']);
    }

    public function getVersesByCategory(string $category)
    {
        return Verse::with('category')
            ->whereHas('category', function($q) use ($category) {
                $q->where('name', $category);
            })
            ->get();
    }
}