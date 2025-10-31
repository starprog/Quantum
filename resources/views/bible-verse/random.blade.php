<x-public-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-medium text-gray-900">
                            Random Verse
                        </h1>
                        <div class="flex items-center">
                            <select id="category-filter" 
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    onchange="window.location.href='?category=' + this.value">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" 
                                            {{ $selectedCategoryId == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <a href="{{ route('verses.random', ['category' => $selectedCategoryId]) }}" 
                               class="ml-4 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                New Random Verse
                            </a>
                        </div>
                    </div>

                    @if($verse)
                        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
                            <div class="text-lg text-gray-900 mb-2">{{ $verse->reference }}</div>
                            <p class="text-gray-600">{{ $verse->verse }}</p>
                            <div class="mt-2">
                                <span class="inline-flex items-center rounded-md bg-indigo-50 px-2 py-1 text-xs font-medium text-indigo-700 ring-1 ring-inset ring-indigo-700/10">
                                    {{ $verse->category->name }}
                                </span>
                            </div>
                        </div>
                    @else
                        <div class="text-gray-600">No verses found in this category.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-public-layout>