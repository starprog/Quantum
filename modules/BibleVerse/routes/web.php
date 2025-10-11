<?php

use Illuminate\Support\Facades\Route;
use Modules\BibleVerse\src\BibleVerseController;

Route::get('/bible-verse', [BibleVerseController::class, 'getVerse'])
    ->name('bible-verse.random')
    ->middleware('web');