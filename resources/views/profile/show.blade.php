<x-app-layout>
    <div style="min-height: 100vh; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
        <div style="max-width: 1024px; margin: 0 auto; padding: 3rem 1.5rem;">
            
            <!-- Hero Section -->
            <div style="text-align: center; margin-bottom: 3rem;">
                <h1 style="font-size: 3.5rem; font-weight: 800; color: white; margin-bottom: 1rem; text-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                    👤 Profile Management
                </h1>
                <p style="font-size: 1.25rem; color: rgba(255,255,255,0.9); max-width: 600px; margin: 0 auto;">
                    Manage your account information and security settings
                </p>
            </div>

            <div style="display: grid; gap: 2rem;"
                @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                    <div style="background: white; border-radius: 1rem; padding: 2rem; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);">
                        @livewire('profile.update-profile-information-form')
                    </div>
                @endif

                @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                    <div style="background: white; border-radius: 1rem; padding: 2rem; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);">
                        @livewire('profile.update-password-form')
                    </div>
                @endif

                @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                    <div style="background: white; border-radius: 1rem; padding: 2rem; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);">
                        @livewire('profile.two-factor-authentication-form')
                    </div>
                @endif

                <div style="background: white; border-radius: 1rem; padding: 2rem; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);">
                    @livewire('profile.logout-other-browser-sessions-form')
                </div>

                @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                    <div style="background: white; border-radius: 1rem; padding: 2rem; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);">
                        @livewire('profile.delete-user-form')
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
