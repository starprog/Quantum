<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Verse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteVerseController extends Controller
{
    /**
     * Display the user's favorite verses.
     */
    public function index()
    {
        $favoriteVerses = Auth::user()->favoriteVerses()->with('category')->get();
        
        return view('favorites.index', compact('favoriteVerses'));
    }

    /**
     * Toggle a verse as favorite.
     */
    public function toggle(Verse $verse)
    {
        $user = Auth::user();
        
        if ($user->favoriteVerses()->where('verse_id', $verse->id)->exists()) {
            // Remove from favorites
            $user->favoriteVerses()->detach($verse->id);
            $isFavorited = false;
        } else {
            // Add to favorites
            $user->favoriteVerses()->attach($verse->id);
            $isFavorited = true;
        }

        return response()->json([
            'success' => true,
            'isFavorited' => $isFavorited,
            'message' => $isFavorited ? 'Verse added to favorites' : 'Verse removed from favorites'
        ]);
    }
}
