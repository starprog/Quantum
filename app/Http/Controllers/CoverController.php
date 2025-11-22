<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CoverController extends Controller
{
    /**
     * Accept an uploaded cover image (PNG/JPG), store it on the public disk, and return its URL.
     */
    public function upload(Request $request)
    {
        $request->validate([
            'cover' => 'required|file|mimes:png,jpeg,jpg|max:10240', // max 10MB
        ]);

        $file = $request->file('cover');
        if (! $file) {
            return response()->json(['error' => 'No file uploaded'], 400);
        }

        try {
            $path = $file->store('covers', 'public');
            $url = Storage::disk('public')->url($path);
            return response()->json(['url' => $url]);
        } catch (\Exception $e) {
            Log::warning('Cover upload failed: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to save cover'], 500);
        }
    }
}
