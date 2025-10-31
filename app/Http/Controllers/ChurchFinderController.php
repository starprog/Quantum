<?php

namespace App\Http\Controllers;

use App\Models\Church;
use App\Services\ChurchFinderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChurchFinderController extends Controller
{
    protected $churchService;

    public function __construct(ChurchFinderService $churchService)
    {
        $this->churchService = $churchService;
    }

    /**
     * Display the church finder page
     */
    public function index()
    {
        $apiKey = config('services.google.places_api_key');
        
        return view('church-finder', [
            'apiKey' => $apiKey,
            'favoriteChurches' => Auth::check() ? Auth::user()->favoriteChurches : collect([])
        ]);
    }

    /**
     * Search for churches
     */
    public function search(Request $request)
    {
        $request->validate([
            'location' => 'required|string|min:3',
            'radius' => 'nullable|integer|min:1000|max:50000',
            'keyword' => 'nullable|string|max:100',
        ]);

        $location = $request->input('location');
        $radius = $request->input('radius', 8000); // Default 5 miles
        $keyword = $request->input('keyword', '');

        $result = $this->churchService->searchChurches($location, $radius, $keyword);

        return response()->json($result);
    }

    /**
     * Get details for a specific church
     */
    public function details($placeId)
    {
        $result = $this->churchService->getChurchDetails($placeId);

        return response()->json($result);
    }

    /**
     * Toggle favorite status for a church
     */
    public function toggleFavorite(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to save favorite churches'
            ], 401);
        }

        $request->validate([
            'place_id' => 'required|string',
            'name' => 'required|string',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'website' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'rating' => 'nullable|numeric',
            'user_ratings_total' => 'nullable|integer',
            'types' => 'nullable|array',
            'photo_reference' => 'nullable|string',
        ]);

        $user = Auth::user();
        
        // Find or create the church
        $church = Church::firstOrCreate(
            ['place_id' => $request->place_id],
            [
                'name' => $request->name,
                'address' => $request->address,
                'phone' => $request->phone,
                'website' => $request->website,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'rating' => $request->rating,
                'user_ratings_total' => $request->user_ratings_total,
                'types' => $request->types,
                'vicinity' => $request->address,
                'photo_reference' => $request->photo_reference,
            ]
        );

        // Toggle favorite
        if ($user->favoriteChurches()->where('church_id', $church->id)->exists()) {
            $user->favoriteChurches()->detach($church->id);
            
            return response()->json([
                'success' => true,
                'favorited' => false,
                'message' => 'Church removed from favorites'
            ]);
        } else {
            $user->favoriteChurches()->attach($church->id);
            
            return response()->json([
                'success' => true,
                'favorited' => true,
                'message' => 'Church added to favorites'
            ]);
        }
    }

    /**
     * Get user's favorite churches
     */
    public function favorites()
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to view favorites'
            ], 401);
        }

        $favorites = Auth::user()->favoriteChurches()
            ->get()
            ->map(function ($church) {
                return [
                    'id' => $church->id,
                    'place_id' => $church->place_id,
                    'name' => $church->name,
                    'address' => $church->address,
                    'phone' => $church->phone,
                    'website' => $church->website,
                    'latitude' => $church->latitude,
                    'longitude' => $church->longitude,
                    'rating' => $church->rating,
                    'user_ratings_total' => $church->user_ratings_total,
                    'photo_url' => $church->photo_url,
                    'directions_url' => $church->directions_url,
                ];
            });

        return response()->json([
            'success' => true,
            'churches' => $favorites
        ]);
    }
}
