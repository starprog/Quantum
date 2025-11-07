<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $plan->name }}
            </h2>
            <a href="{{ route('devotionals.index') }}" class="text-sm text-gray-600 hover:text-gray-900">
                ← Back to Plans
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Plan Overview -->
            <div class="bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg shadow-xl p-8 text-white mb-8">
                <h1 class="text-3xl font-bold mb-4">{{ $plan->name }}</h1>
                
                @if($plan->description)
                    <p class="text-lg text-blue-50 mb-6">{{ $plan->description }}</p>
                @endif

                <div class="flex items-center gap-6 mb-6">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                        </svg>
                        <span>{{ $plan->duration_days }} Days</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"></path>
                        </svg>
                        <span>{{ $plan->planVerses->count() }} Verses</span>
                    </div>
                </div>

                @if($userProgress)
                    @if($userProgress->isCompleted())
                        <div class="bg-green-500 bg-opacity-30 rounded-lg p-4 mb-4">
                            <p class="font-semibold">🎉 You completed this devotional!</p>
                            <p class="text-sm text-green-50">Finished on {{ $userProgress->completed_at->format('F j, Y') }}</p>
                        </div>
                    @else
                        <div class="bg-white bg-opacity-20 rounded-lg p-4 mb-4">
                            <div class="flex justify-between text-sm mb-2">
                                <span>Your Progress: Day {{ $userProgress->current_day }} of {{ $plan->duration_days }}</span>
                                <span>{{ $userProgress->progress_percentage }}%</span>
                            </div>
                            <div class="w-full bg-white bg-opacity-30 rounded-full h-2">
                                <div class="bg-white h-2 rounded-full transition-all" style="width: {{ $userProgress->progress_percentage }}%"></div>
                            </div>
                        </div>
                        <a href="{{ route('devotionals.daily', $plan->slug) }}" 
                           class="inline-block px-6 py-3 bg-white text-blue-600 font-semibold rounded-lg hover:bg-blue-50 transition">
                            Continue to Day {{ $userProgress->current_day }} →
                        </a>
                    @endif
                @else
                    <form action="{{ route('devotionals.start', $plan->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="px-6 py-3 bg-white text-blue-600 font-semibold rounded-lg hover:bg-blue-50 transition">
                            Start This Devotional
                        </button>
                    </form>
                @endif
            </div>

            <!-- Day by Day Preview -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Daily Schedule</h3>
                
                @if($plan->planVerses->isEmpty())
                    <p class="text-gray-500 text-center py-8">This plan is being configured. Check back soon!</p>
                @else
                    <div class="space-y-3">
                        @foreach($plan->planVerses as $planVerse)
                            <div class="border rounded-lg p-4 hover:bg-gray-50 transition">
                                <div class="flex items-start gap-4">
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-semibold">
                                            {{ $planVerse->day_number }}
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-gray-900 mb-1">
                                            Day {{ $planVerse->day_number }}: {{ $planVerse->verse->reference }}
                                        </h4>
                                        <p class="text-sm text-gray-600">
                                            {{ Str::limit($planVerse->verse->verse, 120) }}
                                        </p>
                                        @if($planVerse->reflection_text)
                                            <p class="text-xs text-gray-500 italic mt-2 border-l-2 border-blue-300 pl-2">
                                                {{ Str::limit($planVerse->reflection_text, 100) }}
                                            </p>
                                        @endif
                                    </div>
                                    @if($userProgress && $userProgress->current_day > $planVerse->day_number)
                                        <span class="text-green-600">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
