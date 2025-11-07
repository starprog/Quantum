<?php

namespace App\Http\Controllers;

use App\Models\Verse;
use App\Models\VerseCollection;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class CollectionController extends Controller
{
    /**
     * Display all collections (user's own + public ones).
     */
    public function index()
    {
        $myCollections = auth()->user()->verseCollections()
            ->withCount('verses')
            ->latest()
            ->get();

        $publicCollections = VerseCollection::public()
            ->where('user_id', '!=', auth()->id())
            ->with('user')
            ->withCount('verses')
            ->latest()
            ->paginate(12);

        return view('collections.index', compact('myCollections', 'publicCollections'));
    }

    /**
     * Show the form for creating a new collection.
     */
    public function create()
    {
        return view('collections.create');
    }

    /**
     * Store a newly created collection.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'is_public' => 'boolean',
        ]);

        $collection = auth()->user()->verseCollections()->create($validated);

        return redirect()->route('collections.show', $collection->slug)
            ->with('success', 'Collection created successfully!');
    }

    /**
     * Display the specified collection.
     */
    public function show(string $slug)
    {
        $collection = VerseCollection::where('slug', $slug)
            ->with(['verses.category', 'user'])
            ->firstOrFail();

        // Check if user has access (owner or public collection)
        if (!$collection->is_public && $collection->user_id !== auth()->id()) {
            abort(403, 'This collection is private.');
        }

        return view('collections.show', compact('collection'));
    }

    /**
     * Show the form for editing the collection.
     */
    public function edit(string $slug)
    {
        $collection = VerseCollection::where('slug', $slug)->firstOrFail();

        // Check if user owns this collection
        if (!$collection->canEdit()) {
            abort(403, 'You cannot edit this collection.');
        }

        $availableVerses = Verse::with('category')
            ->orderBy('reference')
            ->get();

        return view('collections.edit', compact('collection', 'availableVerses'));
    }

    /**
     * Update the specified collection.
     */
    public function update(Request $request, string $slug)
    {
        $collection = VerseCollection::where('slug', $slug)->firstOrFail();

        if (!$collection->canEdit()) {
            abort(403, 'You cannot edit this collection.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'is_public' => 'boolean',
        ]);

        $collection->update($validated);

        return redirect()->route('collections.show', $collection->slug)
            ->with('success', 'Collection updated successfully!');
    }

    /**
     * Remove the specified collection.
     */
    public function destroy(string $slug)
    {
        $collection = VerseCollection::where('slug', $slug)->firstOrFail();

        if (!$collection->canEdit()) {
            abort(403, 'You cannot delete this collection.');
        }

        $collection->delete();

        return redirect()->route('collections.index')
            ->with('success', 'Collection deleted successfully!');
    }

    /**
     * Add a verse to the collection.
     */
    public function addVerse(Request $request, string $slug): JsonResponse
    {
        $collection = VerseCollection::where('slug', $slug)->firstOrFail();

        if (!$collection->canEdit()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'verse_id' => 'required|exists:verses,id',
        ]);

        // Check if verse is already in collection
        if ($collection->verses()->where('verse_id', $request->verse_id)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Verse is already in this collection',
            ]);
        }

        // Get the next order number
        $maxOrder = $collection->verses()->max('order') ?? 0;

        $collection->verses()->attach($request->verse_id, ['order' => $maxOrder + 1]);

        return response()->json([
            'success' => true,
            'message' => 'Verse added to collection',
        ]);
    }

    /**
     * Remove a verse from the collection.
     */
    public function removeVerse(Request $request, string $slug): JsonResponse
    {
        $collection = VerseCollection::where('slug', $slug)->firstOrFail();

        if (!$collection->canEdit()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'verse_id' => 'required|exists:verses,id',
        ]);

        $collection->verses()->detach($request->verse_id);

        return response()->json([
            'success' => true,
            'message' => 'Verse removed from collection',
        ]);
    }

    /**
     * Toggle the public status of a collection.
     */
    public function togglePublic(string $slug): JsonResponse
    {
        $collection = VerseCollection::where('slug', $slug)->firstOrFail();

        if (!$collection->canEdit()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $collection->update(['is_public' => !$collection->is_public]);

        return response()->json([
            'success' => true,
            'is_public' => $collection->is_public,
            'message' => $collection->is_public 
                ? 'Collection is now public' 
                : 'Collection is now private',
        ]);
    }
}

