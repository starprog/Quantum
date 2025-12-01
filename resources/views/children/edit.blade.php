<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Child Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('children.update', $child) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- First Name -->
                        <div class="mb-4">
                            <label for="first_name" class="block text-gray-700 text-sm font-bold mb-2">
                                First Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $child->first_name) }}"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('first_name') border-red-500 @enderror"
                                required>
                            @error('first_name')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Last Name -->
                        <div class="mb-4">
                            <label for="last_name" class="block text-gray-700 text-sm font-bold mb-2">
                                Last Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="last_name" id="last_name" value="{{ old('last_name', $child->last_name) }}"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('last_name') border-red-500 @enderror"
                                required>
                            @error('last_name')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Date of Birth -->
                        <div class="mb-4">
                            <label for="date_of_birth" class="block text-gray-700 text-sm font-bold mb-2">
                                Date of Birth <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth', $child->date_of_birth->format('Y-m-d')) }}"
                                max="{{ date('Y-m-d') }}"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('date_of_birth') border-red-500 @enderror"
                                required>
                            @error('date_of_birth')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Gender -->
                        <div class="mb-4">
                            <label for="gender" class="block text-gray-700 text-sm font-bold mb-2">
                                Gender <span class="text-red-500">*</span>
                            </label>
                            <select name="gender" id="gender"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('gender') border-red-500 @enderror"
                                required>
                                <option value="">Select Gender</option>
                                <option value="male" {{ old('gender', $child->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender', $child->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                <option value="other" {{ old('gender', $child->gender) == 'other' ? 'selected' : '' }}>Other</option>
                                <option value="prefer_not_to_say" {{ old('gender', $child->gender) == 'prefer_not_to_say' ? 'selected' : '' }}>Prefer not to say</option>
                            </select>
                            @error('gender')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Current Profile Photo -->
                        @if($child->profile_photo)
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Current Photo</label>
                                <img src="{{ asset('storage/' . $child->profile_photo) }}" alt="{{ $child->full_name }}" class="w-24 h-24 rounded-full object-cover">
                            </div>
                        @endif

                        <!-- Profile Photo -->
                        <div class="mb-4">
                            <label for="profile_photo" class="block text-gray-700 text-sm font-bold mb-2">
                                {{ $child->profile_photo ? 'Change Profile Photo' : 'Profile Photo' }}
                            </label>
                            <input type="file" name="profile_photo" id="profile_photo" accept="image/*"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('profile_photo') border-red-500 @enderror">
                            <p class="text-gray-600 text-xs mt-1">Optional. Max size: 2MB</p>
                            @error('profile_photo')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Notes -->
                        <div class="mb-6">
                            <label for="notes" class="block text-gray-700 text-sm font-bold mb-2">
                                Notes
                            </label>
                            <textarea name="notes" id="notes" rows="4"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('notes') border-red-500 @enderror"
                                placeholder="Any additional notes about your child...">{{ old('notes', $child->notes) }}</textarea>
                            @error('notes')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="flex items-center justify-between">
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Update Child
                            </button>
                            <a href="{{ route('children.show', $child) }}"
                                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>