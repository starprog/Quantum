<x-app-layout>
    @section('content')
    <div class="flex justify-center pt-12">
        <div class="max-w-xl w-full bg-white p-6 rounded shadow">
            <h1 class="text-2xl font-bold mb-4 text-center">Profile</h1>
            <div class="mb-4 flex items-center gap-4">
                <img src="{{ $user->profile_photo_url }}" alt="Profile Photo" class="w-16 h-16 rounded-full object-cover">
                <form method="POST" action="{{ route('profile.photo') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="profile_photo" accept="image/*" required>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Upload</button>
                </form>
            </div>
            <div class="mb-4">
                <strong>Name:</strong> {{ $user->name }}
            </div>
            <div class="mb-4">
                <strong>Email:</strong> {{ $user->email }}
            </div>
            <!-- Add more public fields as needed -->
        </div>
    </div>
    @endsection

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                @livewire('profile.update-profile-information-form')

                <x-section-border />
            @endif

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.update-password-form')
                </div>

                <x-section-border />
            @endif

            @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.two-factor-authentication-form')
                </div>

                <x-section-border />
            @endif

            <div class="mt-10 sm:mt-0">
                @livewire('profile.logout-other-browser-sessions-form')
            </div>

            @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                <x-section-border />

                <div class="mt-10 sm:mt-0">
                    @livewire('profile.delete-user-form')
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
