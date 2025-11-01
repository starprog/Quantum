<?php

namespace Modules\BibleVerse\src\Http\Livewire;

use Livewire\Component;
use App\Services\BibleVerseService;

class BibleVerseEmbed extends Component
{
    public $verse;
    public $loading = false;

    public function mount(BibleVerseService $bibleVerseService)
    {
        $this->verse = $bibleVerseService->getVerseOfTheDay();
    }

    public function refreshVerse()
    {
        $this->loading = true;
        
        $bibleVerseService = app(BibleVerseService::class);
        $this->verse = $bibleVerseService->getRandomVerse();
        
        $this->loading = false;
    }

    public function render()
    {
        return view('bible-verse.livewire.bible-verse-embed');
    }
}

