<?php

namespace App\Http\Controllers;

use App\Models\Verse;
use App\Models\VerseCategory;
use Illuminate\Http\Request;
use App\Services\BibleVerseService;

class HomeController extends Controller
{
    protected $bibleVerseService;

    public function __construct(BibleVerseService $bibleVerseService)
    {
        $this->bibleVerseService = $bibleVerseService;
    }

    public function index()
    {
        $verseOfTheDay = $this->bibleVerseService->getVerseOfTheDay();
        return view('home', [
            'verseOfTheDay' => $verseOfTheDay
        ]);
    }

    public function services()
    {
        return view('services');
    }

    public function settings()
    {
        return view('settings');
    }
}
