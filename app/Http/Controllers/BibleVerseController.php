<?php

namespace App\Http\Controllers;

use App\Services\BibleVerseService;
use Illuminate\Http\Request;

class BibleVerseController extends Controller
{
    protected $bibleVerseService;

    public function __construct(BibleVerseService $bibleVerseService)
    {
        $this->bibleVerseService = $bibleVerseService;
    }

    public function index(Request $request)
    {
        $categories = $this->bibleVerseService->getAllCategories();
        $selectedCategoryId = $request->query('category');
        
        $verses = $selectedCategoryId 
            ? $this->bibleVerseService->getVersesByCategory($selectedCategoryId)
            : $this->bibleVerseService->getAllVerses();

        return view('bible-verse.index', [
            'verses' => $verses,
            'categories' => $categories,
            'selectedCategoryId' => $selectedCategoryId
        ]);
    }

    public function random(Request $request)
    {
        $categoryId = $request->query('category');
        $verse = $this->bibleVerseService->getRandomVerse($categoryId);

        return view('bible-verse.random', [
            'verse' => $verse,
            'categories' => $this->bibleVerseService->getAllCategories(),
            'selectedCategoryId' => $categoryId
        ]);
    }

    public function verseOfTheDay()
    {
        $verse = $this->bibleVerseService->getVerseOfTheDay();
        
        return view('bible-verse.verse-of-day', [
            'verse' => $verse,
            'categories' => $this->bibleVerseService->getAllCategories(),
            'selectedCategoryId' => null
        ]);
    }
}