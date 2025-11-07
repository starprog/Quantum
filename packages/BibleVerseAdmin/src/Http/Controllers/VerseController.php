<?php

namespace Starprog\BibleVerseAdmin\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class VerseController extends Controller
{
    protected $verseModel;
    protected $categoryModel;

    public function __construct()
    {
        $this->verseModel = config('bible-verse-admin.models.verse');
        $this->categoryModel = config('bible-verse-admin.models.verse_category');
    }

    /**
     * Display a listing of verses with search and filter
     */
    public function index(Request $request)
    {
        $query = $this->verseModel::with('category');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('verse', 'like', "%{$search}%")
                  ->orWhere('reference', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $perPage = config('bible-verse-admin.pagination.verses', 20);
        $verses = $query->orderBy('reference')->paginate($perPage);
        $categories = $this->categoryModel::orderBy('name')->get();

        return view('bible-verse-admin::verses.index', compact('verses', 'categories'));
    }

    /**
     * Show the form for creating a new verse
     */
    public function create()
    {
        $categories = $this->categoryModel::orderBy('name')->get();
        return view('bible-verse-admin::verses.create', compact('categories'));
    }

    /**
     * Store a newly created verse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'reference' => 'required|string|max:100|unique:verses,reference',
            'verse' => 'required|string',
            'category_id' => 'required|exists:verse_categories,id',
            'is_featured' => 'boolean',
        ]);

        $this->verseModel::create($validated);

        return redirect()->route('admin.verses.index')
            ->with('success', 'Verse created successfully!');
    }

    /**
     * Show the form for editing the specified verse
     */
    public function edit($id)
    {
        $verse = $this->verseModel::findOrFail($id);
        $categories = $this->categoryModel::orderBy('name')->get();
        return view('bible-verse-admin::verses.edit', compact('verse', 'categories'));
    }

    /**
     * Update the specified verse
     */
    public function update(Request $request, $id)
    {
        $verse = $this->verseModel::findOrFail($id);
        
        $validated = $request->validate([
            'reference' => 'required|string|max:100|unique:verses,reference,' . $verse->id,
            'verse' => 'required|string',
            'category_id' => 'required|exists:verse_categories,id',
            'is_featured' => 'boolean',
        ]);

        $verse->update($validated);

        return redirect()->route('admin.verses.index')
            ->with('success', 'Verse updated successfully!');
    }

    /**
     * Remove the specified verse
     */
    public function destroy($id)
    {
        $verse = $this->verseModel::findOrFail($id);
        $verse->delete();

        return redirect()->route('admin.verses.index')
            ->with('success', 'Verse deleted successfully!');
    }

    /**
     * Toggle featured status of a verse
     */
    public function toggleFeatured($id)
    {
        $verse = $this->verseModel::findOrFail($id);
        $verse->update(['is_featured' => !$verse->is_featured]);

        $status = $verse->is_featured ? 'featured' : 'unfeatured';
        
        return redirect()->back()
            ->with('success', "Verse {$status} successfully!");
    }

    /**
     * Show bulk import form
     */
    public function importForm()
    {
        return view('bible-verse-admin::verses.import');
    }

    /**
     * Handle bulk CSV import
     */
    public function import(Request $request)
    {
        $maxSize = config('bible-verse-admin.import.max_file_size', 2048);
        
        $request->validate([
            'csv_file' => "required|file|mimes:csv,txt|max:{$maxSize}",
        ]);

        $file = $request->file('csv_file');
        $rows = array_map('str_getcsv', file($file->getRealPath()));
        $header = array_shift($rows);

        $imported = 0;
        $skipped = 0;
        $errors = [];

        foreach ($rows as $index => $row) {
            if (count($row) < 3) {
                $errors[] = "Row " . ($index + 2) . ": Insufficient columns";
                $skipped++;
                continue;
            }

            $reference = trim($row[0]);
            $text = trim($row[1]);
            $categoryName = trim($row[2]);

            // Find or skip if category doesn't exist
            $category = $this->categoryModel::where('name', $categoryName)->first();
            if (!$category) {
                $errors[] = "Row " . ($index + 2) . ": Category '{$categoryName}' not found";
                $skipped++;
                continue;
            }

            // Check if verse already exists
            if ($this->verseModel::where('reference', $reference)->exists()) {
                $skipped++;
                continue;
            }

            try {
                $this->verseModel::create([
                    'reference' => $reference,
                    'verse' => $text,
                    'category_id' => $category->id,
                ]);
                $imported++;
            } catch (\Exception $e) {
                $errors[] = "Row " . ($index + 2) . ": " . $e->getMessage();
                $skipped++;
            }
        }

        $message = "Import complete! Imported: {$imported}, Skipped: {$skipped}";
        
        return redirect()->route('admin.verses.index')
            ->with('success', $message)
            ->with('import_errors', $errors);
    }
}
