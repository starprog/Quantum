<?php

namespace Starprog\BibleVerseAdmin\Http\Controllers;

use Illuminate\Routing\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $verseModel = config('bible-verse-admin.models.verse');
        $categoryModel = config('bible-verse-admin.models.verse_category');
        
        $versesCount = $verseModel::count();
        $categoriesCount = $categoryModel::count();
        $featuredCount = $verseModel::where('is_featured', true)->count();
        
        return view('bible-verse-admin::dashboard', compact('versesCount', 'categoriesCount', 'featuredCount'));
    }
}
