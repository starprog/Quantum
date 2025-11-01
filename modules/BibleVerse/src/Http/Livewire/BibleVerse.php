<?php

namespace Modules\BibleVerse\src\Http\Livewire;

use Livewire\Component;
use App\Services\BibleVerseService;

class BibleVerse extends Component
{
    public $verse;
    public $verses = [];
    public $loading = false;
    public $selectedCategory = null;
    public $categories = [];
    public $searchTerm = '';
    public $isSearching = false;

    public function mount(BibleVerseService $bibleVerseService)
    {
        $this->categories = $bibleVerseService->getAllCategories();
        $this->verse = $bibleVerseService->getRandomVerse();
    }

    public function refreshVerse($category = null)
    {
        $this->loading = true;
        $this->selectedCategory = $category;
        $this->isSearching = false;
        $this->searchTerm = '';
        $this->verses = [];
        
        $bibleVerseService = app(BibleVerseService::class);
        $this->verse = $bibleVerseService->getRandomVerse($category);
        
        $this->loading = false;
    }

    public function search()
    {
        $this->loading = true;
        $this->isSearching = true;
        
        $bibleVerseService = app(BibleVerseService::class);
        
        if (empty($this->searchTerm)) {
            $this->verses = [];
            $this->isSearching = false;
            $this->verse = $bibleVerseService->getRandomVerse($this->selectedCategory);
        } else {
            $this->verses = $bibleVerseService->searchVerses(
                $this->searchTerm, 
                $this->selectedCategory
            );
            $this->verse = null;
        }
        
        $this->loading = false;
    }

    public function clearSearch()
    {
        $this->searchTerm = '';
        $this->verses = [];
        $this->isSearching = false;
        $this->refreshVerse($this->selectedCategory);
    }

    public function selectVerse($verseId)
    {
        $this->verse = \App\Models\Verse::with('category')->find($verseId);
        $this->isSearching = false;
    }

    public function render()
    {
        return view('bible-verse.livewire.bible-verse');
    }
}