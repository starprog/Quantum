<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Child;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display all activities
     */
    public function index()
    {
        $activities = Activity::where('is_active', true)
            ->orderBy('min_age_months')
            ->orderBy('category')
            ->get()
            ->groupBy('category');

        return view('activities.index', compact('activities'));
    }

    /**
     * Show activities for a specific child
     */
    public function forChild(Child $child)
    {
        $ageInMonths = $child->age_in_months;
        $activities = Activity::forAge($ageInMonths);
        
        $groupedActivities = $activities->groupBy('category');

        return view('activities.for-child', compact('child', 'groupedActivities', 'ageInMonths'));
    }

    /**
     * Show activities by age range
     */
    public function byAge(Request $request)
    {
        $ageMonths = $request->input('age', 12);
        $activities = Activity::forAge($ageMonths);
        
        $groupedActivities = $activities->groupBy('category');

        return view('activities.by-age', compact('groupedActivities', 'ageMonths'));
    }

    /**
     * Show single activity details
     */
    public function show(Activity $activity)
    {
        return view('activities.show', compact('activity'));
    }

    /**
     * Show activities by category
     */
    public function byCategory($category)
    {
        $activities = Activity::byCategory($category);

        return view('activities.by-category', compact('activities', 'category'));
    }
}