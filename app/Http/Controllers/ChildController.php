<?php

namespace App\Http\Controllers;

use App\Models\Child;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ChildController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the user's children.
     */
    public function index()
    {
        $children = Auth::user()->children()->with('growthRecords', 'achievedMilestones')->get();
        
        return view('children.index', compact('children'));
    }

    /**
     * Show the form for creating a new child.
     */
    public function create()
    {
        return view('children.create');
    }

    /**
     * Store a newly created child in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date|before_or_equal:today',
            'gender' => 'required|in:male,female,other,prefer_not_to_say',
            'profile_photo' => 'nullable|image|max:2048',
            'notes' => 'nullable|string',
        ]);

        $validated['user_id'] = Auth::id();

        if ($request->hasFile('profile_photo')) {
            $validated['profile_photo'] = $request->file('profile_photo')->store('children/photos', 'public');
        }

        $child = Child::create($validated);

        return redirect()->route('children.show', $child)
            ->with('success', 'Child profile created successfully!');
    }

    /**
     * Display the specified child's profile.
     */
    public function show(Child $child)
    {
        $this->authorize('view', $child);

        $child->load([
            'growthRecords' => fn($q) => $q->latest('recorded_date')->limit(10),
            'achievedMilestones.milestone',
            'developmentLogs' => fn($q) => $q->latest('log_date')->limit(10)
        ]);

        $recommendedMilestones = $child->getRecommendedMilestones();
        $latestGrowth = $child->getLatestGrowthRecord();

        return view('children.show', compact('child', 'recommendedMilestones', 'latestGrowth'));
    }

    /**
     * Show the form for editing the specified child.
     */
    public function edit(Child $child)
    {
        $this->authorize('update', $child);

        return view('children.edit', compact('child'));
    }

    /**
     * Update the specified child in storage.
     */
    public function update(Request $request, Child $child)
    {
        $this->authorize('update', $child);

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date|before_or_equal:today',
            'gender' => 'required|in:male,female,other,prefer_not_to_say',
            'profile_photo' => 'nullable|image|max:2048',
            'notes' => 'nullable|string',
        ]);

        if ($request->hasFile('profile_photo')) {
            // Delete old photo
            if ($child->profile_photo) {
                Storage::disk('public')->delete($child->profile_photo);
            }
            $validated['profile_photo'] = $request->file('profile_photo')->store('children/photos', 'public');
        }

        $child->update($validated);

        return redirect()->route('children.show', $child)
            ->with('success', 'Child profile updated successfully!');
    }

    /**
     * Remove the specified child from storage (soft delete).
     */
    public function destroy(Child $child)
    {
        $this->authorize('delete', $child);

        $child->delete();

        return redirect()->route('children.index')
            ->with('success', 'Child profile archived successfully.');
    }
}