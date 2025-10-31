<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Verse;
use App\Models\VerseCategory;
use App\Services\BibleVerseService;

class BibleVerse extends Component
{
    public $verse;
    public $selectedCategory = null;
    public $categories;
    protected $bibleVerseService;

    public function boot(BibleVerseService $bibleVerseService)
    {
        $this->bibleVerseService = $bibleVerseService;
    }

    public function mount()
    {
        $this->categories = VerseCategory::all();
        $this->refreshVerse();
    }

    public function refreshVerse($category = null)
    {
        $this->selectedCategory = $category;
        $this->verse = $this->bibleVerseService->getRandomVerse($category);
    }

    public function render()
    {
        return view('vendor.bible-verse.livewire.bible-verse');
    }
}