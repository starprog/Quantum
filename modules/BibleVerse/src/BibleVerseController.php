<?php

namespace Modules\BibleVerse\src;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class BibleVerseController extends Controller
{
    public function getVerse()
    {
        $bibleVerseService = app('bible-verse');
        $verse = $bibleVerseService->getRandomVerse();
        
        return view('bible-verse::verse', compact('verse'));
    }
}