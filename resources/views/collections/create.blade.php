<x-app-layout>
    <div class="min-h-screen" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
        <div class="py-12">
            <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Header -->
                <div class="mb-8">
                    <a href="{{ route('collections.index') }}" class="inline-flex items-center text-purple-100 hover:text-white mb-4 transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Collections
                    </a>
                    <h1 class="text-4xl font-bold text-white mb-2">Create New Collection</h1>
                    <p class="text-purple-100">Organize your verses into a themed collection</p>
                </div>

                <!-- Form Card -->
                <div class="bg-white rounded-xl shadow-2xl p-8">
                    <form action="{{ route('collections.store') }}" method="POST">
                        @csrf

                        <!-- Name -->
                        <div class="mb-6">
                            <label for="name" class="block text-gray-700 font-semibold mb-2">
                                Collection Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}"
                                   class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition-all duration-200 @error('name') border-red-500 @enderror" 
                                   placeholder="e.g., Morning Prayers, Comfort & Peace, Wedding Verses"
                                   required>
                            @error('name')
                                <p class="mt-2 text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-6">
                            <label for="description" class="block text-gray-700 font-semibold mb-2">
                                Description
                            </label>
                            <textarea id="description" 
                                      name="description" 
                                      rows="4"
                                      class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition-all duration-200 @error('description') border-red-500 @enderror" 
                                      placeholder="Describe what this collection is about...">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-2 text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Color Picker -->
                        <div class="mb-8">
                            <label for="color" class="block text-gray-700 font-semibold mb-2">
                                Collection Color <span class="text-red-500">*</span>
                            </label>
                            <p class="text-gray-600 text-sm mb-3">Choose a color to help identify this collection</p>
                            <div class="flex items-center gap-4">
                                <input type="color" 
                                       id="color" 
                                       name="color" 
                                       value="{{ old('color', '#667eea') }}"
                                       class="w-20 h-12 rounded-lg border-2 border-gray-300 cursor-pointer @error('color') border-red-500 @enderror">
                                <span class="text-gray-600 text-sm">Click to choose a color</span>
                            </div>
                            @error('color')
                                <p class="mt-2 text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Actions -->
                        <div class="flex gap-4">
                            <button type="submit" class="flex-1 bg-purple-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition-all duration-200 transform hover:-translate-y-0.5">
                                Create Collection
                            </button>
                            <a href="{{ route('collections.index') }}" class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg font-semibold hover:bg-gray-200 transition-colors duration-200">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
