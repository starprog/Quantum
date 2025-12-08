<?php

namespace App\Http\Controllers;

use App\Models\Child;
use App\Models\Milestone;
use App\Models\ChildMilestone;
use Illuminate\Http\Request;

class MilestoneController extends Controller
{
    /**
     * Display milestones for a child
     */
    public function index(Child $child)
    {
        $this->authorize('view', $child);
        
        $milestones = Milestone::where('is_active', true)
            ->orderBy('typical_age_months_min')
            ->get();
            
        $childMilestones = $child->milestones()->pluck('milestone_id')->toArray();

        return view('milestones.index', compact('child', 'milestones', 'childMilestones'));
    }

    /**
     * Toggle milestone achievement
     */
    public function toggle(Request $request, Child $child)
    {
        $this->authorize('update', $child);
        
        $validated = $request->validate([
            'milestone_id' => 'required|exists:milestones,id',
            'is_achieved' => 'required|boolean',
        ]);

        $childMilestone = ChildMilestone::firstOrCreate(
            [
                'child_id' => $child->id,
                'milestone_id' => $validated['milestone_id']
            ],
            [
                'achieved_date' => now(),
                'is_achieved' => false
            ]
        );

        $childMilestone->update([
            'is_achieved' => $validated['is_achieved'],
            'achieved_date' => $validated['is_achieved'] ? now() : null,
        ]);

        return back()->with('success', 'Milestone updated successfully!');
    }
}