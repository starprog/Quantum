<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <!-- Welcome Text -->
        <div style="text-align: center; margin-bottom: 2rem;">
            <h1 style="font-size: 1.875rem; font-weight: 700; color: #1f2937; margin-bottom: 0.5rem;">Welcome Back</h1>
            <p style="color: #6b7280; font-size: 0.875rem;">Sign in to your account to continue</p>
        </div>

        <x-validation-errors class="mb-4" />

        @session('status')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ $value }}
            </div>
        @endsession

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div style="margin-bottom: 1.25rem;">
                <x-label for="email" value="{{ __('Email') }}" style="font-weight: 600; color: #374151;" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" 
                         style="margin-top: 0.5rem; padding: 0.75rem 1rem; border: 1px solid #d1d5db; border-radius: 0.5rem; width: 100%; font-size: 0.875rem;" />
            </div>

            <div style="margin-bottom: 1.25rem;">
                <x-label for="password" value="{{ __('Password') }}" style="font-weight: 600; color: #374151;" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" 
                         style="margin-top: 0.5rem; padding: 0.75rem 1rem; border: 1px solid #d1d5db; border-radius: 0.5rem; width: 100%; font-size: 0.875rem;" />
            </div>

            <div style="display: flex; align-items: center; margin-bottom: 1.5rem;">
                <label for="remember_me" style="display: flex; align-items: center; cursor: pointer;">
                    <x-checkbox id="remember_me" name="remember" />
                    <span style="margin-left: 0.5rem; font-size: 0.875rem; color: #6b7280;">{{ __('Remember me') }}</span>
                </label>
            </div>

            <button type="submit" 
                    style="width: 100%; padding: 0.875rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
                           color: white; font-weight: 600; border-radius: 0.5rem; border: none; cursor: pointer; 
                           font-size: 0.875rem; transition: all 0.2s; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);"
                    onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 12px rgba(0, 0, 0, 0.15)';"
                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px rgba(0, 0, 0, 0.1)';">
                {{ __('Log in') }}
            </button>

            @if (Route::has('password.request'))
                <div style="text-align: center; margin-top: 1.5rem;">
                    <a style="font-size: 0.875rem; color: #667eea; text-decoration: none; font-weight: 500; transition: color 0.2s;" 
                       href="{{ route('password.request') }}"
                       onmouseover="this.style.color='#764ba2';"
                       onmouseout="this.style.color='#667eea';">
                        {{ __('Forgot your password?') }}
                    </a>
                </div>
            @endif
        </form>
    </x-authentication-card>
</x-guest-layout>
