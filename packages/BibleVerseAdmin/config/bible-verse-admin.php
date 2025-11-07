<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Admin Route Prefix
    |--------------------------------------------------------------------------
    |
    | This value determines the URI prefix for all admin routes.
    | You can change this to any value you prefer.
    |
    */
    'route_prefix' => 'admin',

    /*
    |--------------------------------------------------------------------------
    | Admin Middleware
    |--------------------------------------------------------------------------
    |
    | Middleware that will be applied to all admin routes.
    |
    */
    'middleware' => ['web', 'auth', 'admin'],

    /*
    |--------------------------------------------------------------------------
    | Pagination
    |--------------------------------------------------------------------------
    |
    | Number of items to display per page in admin lists.
    |
    */
    'pagination' => [
        'verses' => 20,
        'categories' => 20,
    ],

    /*
    |--------------------------------------------------------------------------
    | CSV Import
    |--------------------------------------------------------------------------
    |
    | Configuration for CSV import functionality.
    |
    */
    'import' => [
        'max_file_size' => 2048, // in KB
        'allowed_mimes' => ['csv', 'txt'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Models
    |--------------------------------------------------------------------------
    |
    | Specify your custom models if you're not using the default ones.
    |
    */
    'models' => [
        'user' => \App\Models\User::class,
        'verse' => \App\Models\Verse::class,
        'verse_category' => \App\Models\VerseCategory::class,
    ],
];
