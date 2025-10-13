<?php

namespace App\Http\Controllers;

<<<<<<< HEAD
use App\Models\Verse;
use App\Models\VerseCategory;
=======
>>>>>>> origin/Spencer-Verses
use Illuminate\Http\Request;

class HomeController extends Controller
{
<<<<<<< HEAD
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
=======
    public function index()
    {
        return view('home');
    }

    public function services()
    {
        return view('services');
>>>>>>> origin/Spencer-Verses
    }

    public function settings()
    {
        return view('settings');
    }
}
