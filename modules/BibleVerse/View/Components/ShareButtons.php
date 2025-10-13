<?php

namespace Modules\BibleVerse\View\Components;

use Illuminate\View\Component;

class ShareButtons extends Component
{
    public $verse;
    public $reference;

    public function __construct($verse, $reference)
    {
        $this->verse = $verse;
        $this->reference = $reference;
    }

    public function render()
    {
        return view('bible-verse::components.share-buttons');
    }
}