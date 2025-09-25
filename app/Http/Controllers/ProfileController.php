<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show()
    {
        $user = auth()->user();
        return view('profile.show', compact('user'));
    }

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
    public function toggleTheme(Request $request)
    {
        $user = auth()->user();
        $user->theme = $user->theme === 'dark' ? 'light' : 'dark';
        $user->save();

        return back();
    }
}
