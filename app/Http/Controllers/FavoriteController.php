<?php

namespace App\Http\Controllers;

use App\Models\Verse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class FavoriteController extends Controller
{
    /**
     * Display the user's favorite verses.
     */
    public function index()
    {
        $favorites = auth()->user()
            ->favoriteVerses()
            ->with('category')
            ->latest('user_favorite_verses.created_at')
            ->paginate(20);

        return view('favorites.index', compact('favorites'));
    }

    /**
     * Toggle favorite status for a verse.
     */
    public function toggle(Verse $verse): JsonResponse
    {
        $user = auth()->user();
        
        if ($user->hasFavorited($verse)) {
            $user->favoriteVerses()->detach($verse->id);
            $isFavorited = false;
            $message = 'Verse removed from favorites';
        } else {
            $user->favoriteVerses()->attach($verse->id);
            $isFavorited = true;
            $message = 'Verse added to favorites';
        }

        return response()->json([
            'success' => true,
            'is_favorited' => $isFavorited,
            'message' => $message,
            'favorites_count' => $verse->favoritedBy()->count(),
        ]);
    }

    /**
     * Remove a verse from favorites.
     */
    public function destroy(Verse $verse): JsonResponse
    {
        auth()->user()->favoriteVerses()->detach($verse->id);

        return response()->json([
            'success' => true,
            'message' => 'Verse removed from favorites',
        ]);
    }

    /**
     * Check if a verse is favorited by the current user.
     */
    public function check(Verse $verse): JsonResponse
    {
        $isFavorited = auth()->user()->hasFavorited($verse);

        return response()->json([
            'is_favorited' => $isFavorited,
        ]);
    }
}

