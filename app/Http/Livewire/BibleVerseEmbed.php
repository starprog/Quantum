<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Services\BibleVerseService;
use App\Models\VerseCategory;

class BibleVerseEmbed extends Component
{
    public $verse;
    public $loading = false;
    public $isVerseOfTheDay = true;
    public $selectedCategory = null;

    public function mount(BibleVerseService $bibleVerseService)
    {
        $this->verse = $bibleVerseService->getVerseOfTheDay();
        $this->isVerseOfTheDay = true;
    }

    public function refreshVerse()
    {
        $this->loading = true;
        
        $bibleVerseService = app(BibleVerseService::class);
        
        if ($this->selectedCategory) {
            // Get random verse from selected category
            $verses = $bibleVerseService->getVersesByCategory($this->selectedCategory);
            $this->verse = $verses->random();
        } else {
            // Get any random verse
            $this->verse = $bibleVerseService->getRandomVerse();
        }
        
        $this->isVerseOfTheDay = false;
        $this->loading = false;
    }

    public function filterByCategory($categoryId)
    {
        $this->selectedCategory = $categoryId;
        $this->refreshVerse();
    }

    public function clearCategoryFilter()
    {
        $this->selectedCategory = null;
        $this->refreshVerse();
    }

    public function render()
    {
        return view('bible-verse.livewire.bible-verse-embed');
    }
}
