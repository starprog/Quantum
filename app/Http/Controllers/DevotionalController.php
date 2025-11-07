<?php

namespace App\Http\Controllers;

use App\Models\DevotionalPlan;
use App\Models\UserDevotionalProgress;
use Illuminate\Http\Request;

class DevotionalController extends Controller
{
    /**
     * Browse all available devotional plans
     */
    public function index()
    {
        $activePlans = DevotionalPlan::active()
            ->withCount('planVerses')
            ->get();

        $myProgress = auth()->user()
            ->devotionalProgress()
            ->with('devotionalPlan')
            ->active()
            ->get();

        $completed = auth()->user()
            ->devotionalProgress()
            ->completed()
            ->with('devotionalPlan')
            ->latest('completed_at')
            ->take(5)
            ->get();

        return view('devotionals.index', compact('activePlans', 'myProgress', 'completed'));
    }

    /**
     * Show details of a devotional plan
     */
    public function show(string $slug)
    {
        $plan = DevotionalPlan::where('slug', $slug)
            ->with('planVerses.verse.category')
            ->firstOrFail();

        $userProgress = auth()->user()
            ->devotionalProgress()
            ->where('devotional_plan_id', $plan->id)
            ->first();

        return view('devotionals.show', compact('plan', 'userProgress'));
    }

    /**
     * Start a devotional plan
     */
    public function start(DevotionalPlan $plan)
    {
        // Check if user already has progress for this plan
        $existing = auth()->user()
            ->devotionalProgress()
            ->where('devotional_plan_id', $plan->id)
            ->first();

        if ($existing) {
            return redirect()->route('devotionals.daily', $plan->slug)
                ->with('info', 'You already started this plan. Continuing where you left off!');
        }

        UserDevotionalProgress::create([
            'user_id' => auth()->id(),
            'devotional_plan_id' => $plan->id,
            'current_day' => 1,
            'started_at' => now(),
            'last_activity_at' => now(),
        ]);

        return redirect()->route('devotionals.daily', $plan->slug)
            ->with('success', 'Devotional plan started! Enjoy your journey!');
    }

    /**
     * Display the current day's devotion
     */
    public function daily(string $slug)
    {
        $plan = DevotionalPlan::where('slug', $slug)->firstOrFail();

        $progress = auth()->user()
            ->devotionalProgress()
            ->where('devotional_plan_id', $plan->id)
            ->firstOrFail();

        $todaysVerse = $plan->getVerseForDay($progress->current_day);

        if (!$todaysVerse) {
            return redirect()->route('devotionals.show', $plan->slug)
                ->with('error', 'This day hasn\'t been configured yet.');
        }

        $todaysVerse->load('verse.category');

        return view('devotionals.daily', compact('plan', 'progress', 'todaysVerse'));
    }

    /**
     * Mark current day as complete and advance to next
     */
    public function completeDay(DevotionalPlan $plan)
    {
        $progress = auth()->user()
            ->devotionalProgress()
            ->where('devotional_plan_id', $plan->id)
            ->firstOrFail();

        // Advance to next day
        $advanced = $progress->advanceDay();

        if ($progress->isCompleted()) {
            return response()->json([
                'success' => true,
                'completed' => true,
                'message' => '🎉 Congratulations! You completed the devotional plan!',
                'redirect' => route('devotionals.show', $plan->slug),
            ]);
        }

        if ($advanced) {
            return response()->json([
                'success' => true,
                'completed' => false,
                'message' => 'Day completed! Ready for day ' . $progress->current_day . '?',
                'current_day' => $progress->current_day,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Could not advance to next day.',
        ]);
    }
}

