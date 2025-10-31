<?php

namespace Modules\BibleVerse\src\Http\Livewire;

use Livewire\Component;
use App\Services\BibleVerseService;

class BibleVerse extends Component
{
    public $verse;
    public $loading = false;
    public $selectedCategory = null;
    public $categories = [];

    public function mount(BibleVerseService $bibleVerseService)
    {
        $this->categories = $bibleVerseService->getAllCategories();
        $this->verse = $bibleVerseService->getRandomVerse();
    }

    public function refreshVerse($category = null)
    {
        $this->loading = true;
        $this->selectedCategory = $category;
        
        $bibleVerseService = app(BibleVerseService::class);
        $this->verse = $bibleVerseService->getRandomVerse($category);
        
        $this->loading = false;
    }

    public function render()
    {
        return view('bible-verse.livewire.bible-verse');
    }
}