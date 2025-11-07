<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VerseAudio;
use App\Models\Verse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AudioController extends Controller
{
    /**
     * Display a listing of audio files.
     */
    public function index()
    {
        $audioFiles = VerseAudio::with('verse')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.audio.index', compact('audioFiles'));
    }

    /**
     * Show the form for creating new audio.
     */
    public function create()
    {
        $verses = Verse::orderBy('reference')->get();
        return view('admin.audio.create', compact('verses'));
    }

    /**
     * Store newly uploaded audio.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'verse_id' => 'required|exists:verses,id',
            'language' => 'required|string|max:10',
            'version' => 'required|string|max:50',
            'narrator' => 'nullable|string|max:100',
            'audio_file' => 'required|file|mimes:mp3,wav,ogg|max:20480', // Max 20MB
            'is_active' => 'boolean'
        ]);

        $file = $request->file('audio_file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('audio/verses', $fileName, 'public');

        // Get file metadata
        $duration = null; // Would need getID3 library for accurate duration
        $fileSize = $file->getSize();
        $fileFormat = $file->getClientOriginalExtension();

        VerseAudio::create([
            'verse_id' => $validated['verse_id'],
            'language' => $validated['language'],
            'version' => $validated['version'],
            'narrator' => $validated['narrator'] ?? null,
            'audio_url' => $path,
            'file_format' => $fileFormat,
            'duration' => $duration,
            'file_size' => $fileSize,
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->route('admin.audio.index')
            ->with('success', 'Audio file uploaded successfully.');
    }

    /**
     * Show the form for editing audio.
     */
    public function edit(VerseAudio $audio)
    {
        $verses = Verse::orderBy('reference')->get();
        return view('admin.audio.edit', compact('audio', 'verses'));
    }

    /**
     * Update the audio metadata.
     */
    public function update(Request $request, VerseAudio $audio)
    {
        $validated = $request->validate([
            'verse_id' => 'required|exists:verses,id',
            'language' => 'required|string|max:10',
            'version' => 'required|string|max:50',
            'narrator' => 'nullable|string|max:100',
            'duration' => 'nullable|integer',
            'is_active' => 'boolean'
        ]);

        $audio->update([
            'verse_id' => $validated['verse_id'],
            'language' => $validated['language'],
            'version' => $validated['version'],
            'narrator' => $validated['narrator'] ?? null,
            'duration' => $validated['duration'] ?? null,
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->route('admin.audio.index')
            ->with('success', 'Audio metadata updated successfully.');
    }

    /**
     * Remove the audio file.
     */
    public function destroy(VerseAudio $audio)
    {
        // Delete file from storage
        if (Storage::disk('public')->exists($audio->audio_url)) {
            Storage::disk('public')->delete($audio->audio_url);
        }

        $audio->delete();

        return redirect()->route('admin.audio.index')
            ->with('success', 'Audio file deleted successfully.');
    }

    /**
     * Bulk upload audio files.
     */
    public function bulkUpload(Request $request)
    {
        $request->validate([
            'audio_files.*' => 'required|file|mimes:mp3,wav,ogg|max:20480',
            'language' => 'required|string|max:10',
            'version' => 'required|string|max:50',
            'narrator' => 'nullable|string|max:100'
        ]);

        $uploaded = 0;
        $files = $request->file('audio_files');

        foreach ($files as $file) {
            // Try to extract verse reference from filename (e.g., "John_3_16.mp3")
            $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $reference = str_replace('_', ' ', $filename);

            // Find matching verse
            $verse = Verse::where('reference', 'LIKE', '%' . $reference . '%')->first();

            if ($verse) {
                $fileName = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('audio/verses', $fileName, 'public');

                VerseAudio::create([
                    'verse_id' => $verse->id,
                    'language' => $request->language,
                    'version' => $request->version,
                    'narrator' => $request->narrator,
                    'audio_url' => $path,
                    'file_format' => $file->getClientOriginalExtension(),
                    'file_size' => $file->getSize(),
                    'is_active' => true
                ]);

                $uploaded++;
            }
        }

        return redirect()->route('admin.audio.index')
            ->with('success', "Successfully uploaded {$uploaded} audio files.");
    }
}

