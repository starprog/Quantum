<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Services\BibleVerseService;

class BibleVerseEmbed extends Component
{
    public $verse;
    public $loading = false;
    public $isVerseOfTheDay = true;

    public function mount(BibleVerseService $bibleVerseService)
    {
        $this->verse = $bibleVerseService->getVerseOfTheDay();
        $this->isVerseOfTheDay = true;
    }

    public function refreshVerse()
    {
        $this->loading = true;
        
        $bibleVerseService = app(BibleVerseService::class);
        $this->verse = $bibleVerseService->getRandomVerse();
        $this->isVerseOfTheDay = false;
        
        $this->loading = false;
    }

    public function render()
    {
        return view('bible-verse.livewire.bible-verse-embed');
    }
}
