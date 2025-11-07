@extends('admin.layout')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">Edit Verse</h2>
            <a href="{{ route('admin.verses.index') }}" class="text-gray-600 hover:text-gray-900">
                ← Back to Verses
            </a>
        </div>

        <form action="{{ route('admin.verses.update', $verse) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="reference" class="block text-sm font-medium text-gray-700">Reference</label>
                <input type="text" name="reference" id="reference" value="{{ old('reference', $verse->reference) }}" 
                    placeholder="e.g., John 3:16"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('reference') border-red-500 @enderror">
                @error('reference')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="verse" class="block text-sm font-medium text-gray-700">Verse Text</label>
                <textarea name="verse" id="verse" rows="6" 
                    placeholder="Enter the verse text..."
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('verse') border-red-500 @enderror">{{ old('verse', $verse->verse) }}</textarea>
                @error('verse')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
                <select name="category_id" id="category_id" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('category_id') border-red-500 @enderror">
                    <option value="">Select a category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $verse->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center">
                <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured', $verse->is_featured) ? 'checked' : '' }}
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <label for="is_featured" class="ml-2 block text-sm text-gray-700">
                    Mark as Featured
                </label>
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.verses.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                    Cancel
                </a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Update Verse
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
