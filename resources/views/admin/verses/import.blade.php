@extends('admin.layout')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">Import Verses from CSV</h2>
            <a href="{{ route('admin.verses.index') }}" class="text-gray-600 hover:text-gray-900">
                ← Back to Verses
            </a>
        </div>

        <div class="mb-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
            <h3 class="font-semibold text-blue-900 mb-2">CSV Format Instructions</h3>
            <p class="text-sm text-blue-800 mb-2">Your CSV file should have the following format (with or without header row):</p>
            <div class="bg-white rounded p-3 font-mono text-sm border border-blue-200">
                <div class="text-gray-600">Reference, Verse Text, Category Name</div>
                <div>John 3:16, For God so loved the world..., Love</div>
                <div>Psalm 23:1, The Lord is my shepherd..., Comfort</div>
            </div>
            <ul class="mt-3 text-sm text-blue-800 list-disc list-inside">
                <li>Categories must already exist in the system</li>
                <li>Duplicate references will be skipped</li>
                <li>Maximum file size: 2MB</li>
            </ul>
        </div>

        <form action="{{ route('admin.verses.import.process') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div>
                <label for="csv_file" class="block text-sm font-medium text-gray-700 mb-2">
                    Select CSV File
                </label>
                <input type="file" name="csv_file" id="csv_file" accept=".csv,.txt" required
                    class="block w-full text-sm text-gray-500
                        file:mr-4 file:py-2 file:px-4
                        file:rounded-md file:border-0
                        file:text-sm file:font-semibold
                        file:bg-blue-50 file:text-blue-700
                        hover:file:bg-blue-100
                        @error('csv_file') border-red-500 @enderror">
                @error('csv_file')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.verses.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                    Cancel
                </a>
                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    Import Verses
                </button>
            </div>
        </form>

        <!-- Sample CSV Download -->
        <div class="mt-8 border-t pt-6">
            <h3 class="font-semibold text-gray-800 mb-3">Need a sample CSV file?</h3>
            <p class="text-sm text-gray-600 mb-3">Download this sample CSV file to see the correct format:</p>
            <a href="data:text/csv;charset=utf-8,Reference%2CVerse%20Text%2CCategory%0AJohn%203%3A16%2C%22For%20God%20so%20loved%20the%20world%20that%20he%20gave%20his%20one%20and%20only%20Son%2C%20that%20whoever%20believes%20in%20him%20shall%20not%20perish%20but%20have%20eternal%20life.%22%2CLove%0APsalm%2023%3A1%2C%22The%20Lord%20is%20my%20shepherd%2C%20I%20lack%20nothing.%22%2CComfort%0APhilippians%204%3A13%2C%22I%20can%20do%20all%20this%20through%20him%20who%20gives%20me%20strength.%22%2CStrength" 
                download="sample_verses.csv"
                class="inline-block bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Download Sample CSV
            </a>
        </div>
    </div>
</div>
@endsection
