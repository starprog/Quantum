<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // If user is authenticated, redirect to dashboard
        if (auth()->check()) {
            return redirect()->route('dashboard');
        }
        
        return view('welcome');
    }

    public function services()
    {
        // Require authentication for services
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        
        return view('services');
    }

    public function settings()
    {
        // Require authentication for settings
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        
        return view('settings');
    }
}
