<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $activity->title }}
            </h2>
            <a href="{{ route('activities.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to Activities
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-8">
                    <!-- Activity Header -->
                    <div class="mb-6 pb-6 border-b">
                        <div class="flex justify-between items-start mb-4">
                            <h1 class="text-3xl font-bold text-gray-900">{{ $activity->title }}</h1>
                            <span class="text-sm bg-blue-100 text-blue-800 px-3 py-1 rounded-full">
                                {{ $activity->age_range }}
                            </span>
                        </div>
                        
                        <div class="flex items-center gap-4 text-sm">
                            <span class="flex items-center text-gray-600">
                                <span class="mr-1">📂</span>
                                <span class="capitalize">{{ $activity->category_name }}</span>
                            </span>
                            <span class="flex items-center text-gray-600">
                                <span class="mr-1">⏱️</span>
                                <span>{{ $activity->duration }}</span>
                            </span>
                            <span class="capitalize px-3 py-1 rounded-full text-xs font-semibold
                                {{ $activity->difficulty === 'easy' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $activity->difficulty === 'moderate' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $activity->difficulty === 'challenging' ? 'bg-red-100 text-red-800' : '' }}">
                                {{ $activity->difficulty }}
                            </span>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-2 text-gray-900">Description</h3>
                        <p class="text-gray-700">{{ $activity->description }}</p>
                    </div>

                    <!-- Developmental Benefits -->
                    @if($activity->developmental_benefits)
                        <div class="mb-6 p-4 bg-purple-50 rounded-lg">
                            <h3 class="text-lg font-semibold mb-2 text-purple-900 flex items-center">
                                <span class="mr-2">🌟</span>
                                Developmental Benefits
                            </h3>
                            <p class="text-purple-800">{{ $activity->developmental_benefits }}</p>
                        </div>
                    @endif

                    <!-- Materials Needed -->
                    @if($activity->materials)
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold mb-2 text-gray-900 flex items-center">
                                <span class="mr-2">🧰</span>
                                Materials Needed
                            </h3>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-gray-700 whitespace-pre-line">{{ $activity->materials }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Instructions -->
                    @if($activity->instructions)
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold mb-2 text-gray-900 flex items-center">
                                <span class="mr-2">📋</span>
                                Step-by-Step Instructions
                            </h3>
                            <div class="bg-blue-50 p-4 rounded-lg">
                                <div class="text-gray-700 whitespace-pre-line">{{ $activity->instructions }}</div>
                            </div>
                        </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="flex gap-3 pt-6 border-t">
                        <a href="{{ route('activities.index') }}" class="flex-1 text-center bg-gray-500 hover:bg-gray-700 text-white font-bold py-3 px-6 rounded transition">
                            ← Back to Activities
                        </a>
                        <a href="{{ route('activities.by-category', $activity->category) }}" class="flex-1 text-center bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded transition">
                            More {{ $activity->category_name }} Activities →
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>