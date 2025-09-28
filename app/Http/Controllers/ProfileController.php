<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Display the authenticated user's profile page.
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        $user = auth()->user();
        return view('profile.show', compact('user'));
    }

    /**
     * Handle the upload and update of the user's profile photo.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePhoto(Request $request)
    {
        $request->validate([
            'profile_photo' => 'required|image|max:2048',
        ]);

        $path = $request->file('profile_photo')->store('profile-photos', 'public');
        $user = auth()->user();
        $user->profile_photo_path = $path;
        $user->save();

        return redirect()->route('profile.show');
    }

    /**
     * Toggle the user's theme preference between light and dark mode.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggleTheme(Request $request)
    {
        $user = auth()->user();
        $user->theme = $user->theme === 'dark' ? 'light' : 'dark';
        $user->save();

        return back();
    }
}
