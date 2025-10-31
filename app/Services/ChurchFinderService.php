<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChurchFinderService
{
    protected $apiKey;
    protected $baseUrl = 'https://maps.googleapis.com/maps/api/place';

    public function __construct()
    {
        $this->apiKey = config('services.google.places_api_key');
    }

    /**
     * Search for churches near a location
     *
     * @param string $location City, state, or zip code
     * @param int $radius Search radius in meters (default 8000m = ~5 miles)
     * @param string $keyword Additional search keyword
     * @return array
     */
    public function searchChurches(string $location, int $radius = 8000, string $keyword = ''): array
    {
        try {
            // First, geocode the location to get lat/lng
            $geocode = $this->geocodeLocation($location);
            
            if (!$geocode['success']) {
                return [
                    'success' => false,
                    'message' => $geocode['message'] ?? 'Failed to find location',
                    'churches' => []
                ];
            }

            $lat = $geocode['lat'];
            $lng = $geocode['lng'];

            // Search for churches using Places API Nearby Search
            $response = Http::get("{$this->baseUrl}/nearbysearch/json", [
                'location' => "{$lat},{$lng}",
                'radius' => $radius,
                'type' => 'church',
                'keyword' => $keyword,
                'key' => $this->apiKey,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                if ($data['status'] === 'OK') {
                    return [
                        'success' => true,
                        'churches' => $this->formatChurches($data['results']),
                        'location' => [
                            'lat' => $lat,
                            'lng' => $lng,
                            'formatted_address' => $geocode['formatted_address']
                        ]
                    ];
                }

                return [
                    'success' => false,
                    'message' => 'No churches found in this area',
                    'churches' => []
                ];
            }

            return [
                'success' => false,
                'message' => 'Failed to search for churches',
                'churches' => []
            ];

        } catch (\Exception $e) {
            Log::error('Church search failed: ' . $e->getMessage());
            
            return [
                'success' => false,
                'message' => 'An error occurred while searching. Please try again.',
                'churches' => []
            ];
        }
    }

    /**
     * Geocode a location string to lat/lng
     */
    protected function geocodeLocation(string $location): array
    {
        try {
            $response = Http::get('https://maps.googleapis.com/maps/api/geocode/json', [
                'address' => $location,
                'key' => $this->apiKey,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                if ($data['status'] === 'OK' && !empty($data['results'])) {
                    $result = $data['results'][0];
                    
                    return [
                        'success' => true,
                        'lat' => $result['geometry']['location']['lat'],
                        'lng' => $result['geometry']['location']['lng'],
                        'formatted_address' => $result['formatted_address']
                    ];
                }
            }

            return [
                'success' => false,
                'message' => 'Location not found. Please try a different zip code or city.'
            ];

        } catch (\Exception $e) {
            Log::error('Geocoding failed: ' . $e->getMessage());
            
            return [
                'success' => false,
                'message' => 'Failed to find location'
            ];
        }
    }

    /**
     * Format church data from Google Places API
     */
    protected function formatChurches(array $results): array
    {
        return collect($results)->map(function ($place) {
            return [
                'place_id' => $place['place_id'] ?? null,
                'name' => $place['name'] ?? 'Unknown Church',
                'address' => $place['vicinity'] ?? null,
                'latitude' => $place['geometry']['location']['lat'] ?? null,
                'longitude' => $place['geometry']['location']['lng'] ?? null,
                'rating' => $place['rating'] ?? null,
                'user_ratings_total' => $place['user_ratings_total'] ?? 0,
                'types' => $place['types'] ?? [],
                'photo_reference' => $place['photos'][0]['photo_reference'] ?? null,
                'open_now' => $place['opening_hours']['open_now'] ?? null,
            ];
        })->toArray();
    }

    /**
     * Get detailed information about a specific church
     */
    public function getChurchDetails(string $placeId): array
    {
        try {
            $response = Http::get("{$this->baseUrl}/details/json", [
                'place_id' => $placeId,
                'fields' => 'name,formatted_address,formatted_phone_number,website,rating,user_ratings_total,geometry,photos,opening_hours,types',
                'key' => $this->apiKey,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                if ($data['status'] === 'OK') {
                    $result = $data['result'];
                    
                    return [
                        'success' => true,
                        'church' => [
                            'place_id' => $placeId,
                            'name' => $result['name'] ?? 'Unknown Church',
                            'address' => $result['formatted_address'] ?? null,
                            'phone' => $result['formatted_phone_number'] ?? null,
                            'website' => $result['website'] ?? null,
                            'latitude' => $result['geometry']['location']['lat'] ?? null,
                            'longitude' => $result['geometry']['location']['lng'] ?? null,
                            'rating' => $result['rating'] ?? null,
                            'user_ratings_total' => $result['user_ratings_total'] ?? 0,
                            'types' => $result['types'] ?? [],
                            'photo_reference' => $result['photos'][0]['photo_reference'] ?? null,
                            'opening_hours' => $result['opening_hours'] ?? null,
                        ]
                    ];
                }
            }

            return [
                'success' => false,
                'message' => 'Church details not found'
            ];

        } catch (\Exception $e) {
            Log::error('Church details fetch failed: ' . $e->getMessage());
            
            return [
                'success' => false,
                'message' => 'Failed to fetch church details'
            ];
        }
    }
}
