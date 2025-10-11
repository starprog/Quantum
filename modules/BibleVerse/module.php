<?php

return [
    'name' => 'BibleVerse',
    'description' => 'A plugin that provides random Bible verses',
    'namespace' => 'Modules\\BibleVerse',
    'provider' => 'Modules\\BibleVerse\\src\\BibleVerseServiceProvider',
    'autoload' => [
        'namespace' => 'Modules\\BibleVerse\\',
        'path' => 'src'
    ],
    'requires' => []
];