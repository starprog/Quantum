<?php

namespace App\Http\Controllers;

use App\Models\Child;
use App\Models\GrowthRecord;
use Illuminate\Http\Request;

class GrowthRecordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display growth records for a child.
     */
    public function index(Child $child)
    {
        $this->authorize('view', $child);

        $growthRecords = $child->growthRecords()->orderBy('recorded_date', 'desc')->paginate(20);

        // Prepare data for growth chart
        $chartData = $child->growthRecords()
            ->orderBy('recorded_date')
            ->get()
            ->map(function ($record) {
                return [
                    'date' => $record->recorded_date->format('Y-m-d'),
                    'age_months' => $record->age_in_months,
                    'weight' => $record->weight_kg,
                    'height' => $record->height_cm,
                    'head_circumference' => $record->head_circumference_cm,
                ];
            });

        return view('growth.index', compact('child', 'growthRecords', 'chartData'));
    }

    /**
     * Show the form for creating a new growth record.
     */
    public function create(Child $child)
    {
        $this->authorize('update', $child);

        return view('growth.create', compact('child'));
    }

    /**
     * Store a newly created growth record.
     */
    public function store(Request $request, Child $child)
    {
        $this->authorize('update', $child);

        $validated = $request->validate([
            'recorded_date' => 'required|date|before_or_equal:today',
            'weight_kg' => 'nullable|numeric|min:0|max:200',
            'height_cm' => 'nullable|numeric|min:0|max:250',
            'head_circumference_cm' => 'nullable|numeric|min:0|max:100',
            'notes' => 'nullable|string',
        ]);

        $validated['child_id'] = $child->id;
        $validated['age_in_months'] = $child->age_in_months;

        GrowthRecord::create($validated);

        return redirect()->route('growth.index', $child)
            ->with('success', 'Growth record added successfully!');
    }

    /**
     * Display the specified growth record.
     */
    public function show(Child $child, GrowthRecord $growthRecord)
    {
        $this->authorize('view', $child);

        return view('growth.show', compact('child', 'growthRecord'));
    }

    /**
     * Show the form for editing the specified growth record.
     */
    public function edit(Child $child, GrowthRecord $growthRecord)
    {
        $this->authorize('update', $child);

        return view('growth.edit', compact('child', 'growthRecord'));
    }

    /**
     * Update the specified growth record.
     */
    public function update(Request $request, Child $child, GrowthRecord $growthRecord)
    {
        $this->authorize('update', $child);

        $validated = $request->validate([
            'recorded_date' => 'required|date|before_or_equal:today',
            'weight_kg' => 'nullable|numeric|min:0|max:200',
            'height_cm' => 'nullable|numeric|min:0|max:250',
            'head_circumference_cm' => 'nullable|numeric|min:0|max:100',
            'notes' => 'nullable|string',
        ]);

        $growthRecord->update($validated);

        return redirect()->route('growth.index', $child)
            ->with('success', 'Growth record updated successfully!');
    }

    /**
     * Remove the specified growth record.
     */
    public function destroy(Child $child, GrowthRecord $growthRecord)
    {
        $this->authorize('update', $child);

        $growthRecord->delete();

        return redirect()->route('growth.index', $child)
            ->with('success', 'Growth record deleted.');
    }
}