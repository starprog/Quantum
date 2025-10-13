<?php

namespace App\Http\Controllers;

use App\Models\Verse;
use App\Models\VerseCategory;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $categories = VerseCategory::all();
        $selectedCategory = $request->input('category');
        
        $versesQuery = Verse::query();
        
        if ($selectedCategory) {
            $versesQuery->where('category_id', $selectedCategory);
        }
        
        $verses = $versesQuery->get();
        
        return view('home', [
            'verses' => $verses,
            'categories' => $categories,
            'selectedCategory' => $selectedCategory
        ]);
    }

    public function settings()
    {
        return view('settings');
    }
}
