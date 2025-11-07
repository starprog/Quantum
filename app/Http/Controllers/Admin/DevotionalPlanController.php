<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DevotionalPlan;
use App\Models\DevotionalPlanVerse;
use App\Models\Verse;
use Illuminate\Http\Request;

class DevotionalPlanController extends Controller
{
    /**
     * Display all devotional plans
     */
    public function index()
    {
        $plans = DevotionalPlan::withCount('planVerses', 'userProgress')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.devotionals.index', compact('plans'));
    }

    /**
     * Show form to create a new plan
     */
    public function create()
    {
        return view('admin.devotionals.create');
    }

    /**
     * Store a new devotional plan
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration_days' => 'required|integer|min:1|max:365',
            'is_active' => 'boolean',
        ]);

        $plan = DevotionalPlan::create($validated);

        return redirect()->route('admin.devotionals.edit', $plan->id)
            ->with('success', 'Devotional plan created! Now add verses for each day.');
    }

    /**
     * Show form to edit a plan and manage verses
     */
    public function edit(DevotionalPlan $plan)
    {
        $plan->load(['planVerses.verse.category']);
        $availableVerses = Verse::with('category')->orderBy('reference')->get();

        return view('admin.devotionals.edit', compact('plan', 'availableVerses'));
    }

    /**
     * Update the devotional plan details
     */
    public function update(Request $request, DevotionalPlan $plan)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration_days' => 'required|integer|min:1|max:365',
            'is_active' => 'boolean',
        ]);

        $plan->update($validated);

        return redirect()->route('admin.devotionals.edit', $plan->id)
            ->with('success', 'Devotional plan updated successfully!');
    }

    /**
     * Delete a devotional plan
     */
    public function destroy(DevotionalPlan $plan)
    {
        $plan->delete();

        return redirect()->route('admin.devotionals.index')
            ->with('success', 'Devotional plan deleted successfully!');
    }

    /**
     * Add or update a verse for a specific day
     */
    public function assignVerse(Request $request, DevotionalPlan $plan)
    {
        $validated = $request->validate([
            'verse_id' => 'required|exists:verses,id',
            'day_number' => 'required|integer|min:1|max:' . $plan->duration_days,
            'reflection_text' => 'nullable|string',
        ]);

        DevotionalPlanVerse::updateOrCreate(
            [
                'devotional_plan_id' => $plan->id,
                'day_number' => $validated['day_number'],
            ],
            [
                'verse_id' => $validated['verse_id'],
                'reflection_text' => $validated['reflection_text'],
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Verse assigned to day ' . $validated['day_number'],
        ]);
    }

    /**
     * Remove a verse from a specific day
     */
    public function removeVerse(DevotionalPlan $plan, int $dayNumber)
    {
        DevotionalPlanVerse::where('devotional_plan_id', $plan->id)
            ->where('day_number', $dayNumber)
            ->delete();

        return response()->json([
            'success' => true,
            'message' => 'Verse removed from day ' . $dayNumber,
        ]);
    }
}

