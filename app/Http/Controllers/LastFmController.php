<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class LastFmController extends Controller
{
    private function getApiKey()
    {
        return env('LASTFM_API_KEY');
    }

    /**
     * Get track information from Last.fm
     */
    public function getTrackInfo(Request $request)
    {
        $request->validate([
            'artist' => 'required|string|max:255',
            'track' => 'required|string|max:255',
        ]);

        $apiKey = $this->getApiKey();
        if (!$apiKey) {
            return response()->json([
                'error' => 'Last.fm API key not configured',
                'message' => 'Please add LASTFM_API_KEY to your .env file'
            ], 500);
        }

        try {
            $response = Http::timeout(10)->get('http://ws.audioscrobbler.com/2.0/', [
                'method' => 'track.getInfo',
                'api_key' => $apiKey,
                'artist' => $request->artist,
                'track' => $request->track,
                'format' => 'json',
                'autocorrect' => 1,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['error'])) {
                    return response()->json([
                        'error' => 'Last.fm API error',
                        'message' => $data['message'] ?? 'Unknown error'
                    ], 404);
                }

                return response()->json($data);
            }

            return response()->json([
                'error' => 'Failed to fetch track info',
                'status' => $response->status()
            ], $response->status());

        } catch (\Exception $e) {
            Log::error('Last.fm track info error: ' . $e->getMessage());
            return response()->json([
                'error' => 'Request failed',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get similar tracks from Last.fm
     */
    public function getSimilarTracks(Request $request)
    {
        $request->validate([
            'artist' => 'required|string|max:255',
            'track' => 'required|string|max:255',
        ]);

        $apiKey = $this->getApiKey();
        if (!$apiKey) {
            return response()->json([
                'error' => 'Last.fm API key not configured',
                'message' => 'Please add LASTFM_API_KEY to your .env file'
            ], 500);
        }

        try {
            $response = Http::timeout(10)->get('http://ws.audioscrobbler.com/2.0/', [
                'method' => 'track.getSimilar',
                'api_key' => $apiKey,
                'artist' => $request->artist,
                'track' => $request->track,
                'format' => 'json',
                'autocorrect' => 1,
                'limit' => 10,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['error'])) {
                    return response()->json([
                        'error' => 'Last.fm API error',
                        'message' => $data['message'] ?? 'Unknown error'
                    ], 404);
                }

                return response()->json($data);
            }

            return response()->json([
                'error' => 'Failed to fetch similar tracks',
                'status' => $response->status()
            ], $response->status());

        } catch (\Exception $e) {
            Log::error('Last.fm similar tracks error: ' . $e->getMessage());
            return response()->json([
                'error' => 'Request failed',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
