<?php

namespace Modules\BibleVerse\src\Http\Livewire;

use Livewire\Component;
use Modules\BibleVerse\src\BibleVerseService;

class BibleVerse extends Component
{
    public $verse;
    public $loading = false;
    public $lastVerseIndex = -1;

    public function mount(BibleVerseService $bibleVerseService)
    {
        $this->verse = $bibleVerseService->getRandomVerse();
    }

    public function refreshVerse(BibleVerseService $bibleVerseService)
    {
        $this->verse = $bibleVerseService->getRandomVerse();
    }

    public function render()
    {
        return view('bible-verse::livewire.bible-verse');
    }
}