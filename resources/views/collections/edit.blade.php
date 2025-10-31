<x-app-layout>
    <div class="min-h-screen" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
        <div class="py-12">
            <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Header -->
                <div class="mb-8">
                    <a href="{{ route('collections.show', $collection) }}" class="inline-flex items-center text-purple-100 hover:text-white mb-4 transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Collection
                    </a>
                    <h1 class="text-4xl font-bold text-white mb-2">Edit Collection</h1>
                    <p class="text-purple-100">Update your collection details</p>
                </div>

                <!-- Form Card -->
                <div class="bg-white rounded-xl shadow-2xl p-8">
                    <form action="{{ route('collections.update', $collection) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Name -->
                        <div class="mb-6">
                            <label for="name" class="block text-gray-700 font-semibold mb-2">
                                Collection Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $collection->name) }}"
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
                                      placeholder="Describe what this collection is about...">{{ old('description', $collection->description) }}</textarea>
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
                                       value="{{ old('color', $collection->color) }}"
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
                                Update Collection
                            </button>
                            <a href="{{ route('collections.show', $collection) }}" class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg font-semibold hover:bg-gray-200 transition-colors duration-200">
                                Cancel
                            </a>
                        </div>
                    </form>

                    <!-- Delete Section -->
                    <div class="mt-8 pt-8 border-t border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Delete Collection</h3>
                        <p class="text-gray-600 mb-4">Once you delete this collection, all of its data will be permanently removed. This action cannot be undone.</p>
                        <form action="{{ route('collections.destroy', $collection) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this collection? This action cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-6 py-3 bg-red-600 text-white rounded-lg font-semibold hover:bg-red-700 transition-colors duration-200">
                                Delete Collection
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
