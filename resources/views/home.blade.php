@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-4">Welcome to Quantum!</h1>
    <p class="mb-6 text-gray-700">
        This is the home page of your web application. Use the navigation bar above to access your dashboard or profile.
    </p>
    <a href="{{ route('tasks.index') }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        Go to Task List
    </a>
</div>
@endsection