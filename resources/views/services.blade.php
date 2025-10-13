<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Services') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-medium text-gray-900">
                        Available Services
                    </h1>
                    <p class="mt-6 text-gray-500 leading-relaxed">
                        Explore the powerful services and features available in Quantum.
                    </p>
                </div>

                <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 p-6 lg:p-8">
                    <!-- Payment Processing -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                            </svg>
                            <h3 class="ml-3 text-lg font-medium text-gray-900">Payment Processing</h3>
                        </div>
                        <p class="mt-4 text-gray-500">
                            Secure payment processing powered by Stripe. Accept credit cards, digital wallets, and more.
                        </p>
                        <div class="mt-4">
                            <a href="{{ route('checkout.show') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                                Try Demo Payment
                            </a>
                        </div>
                    </div>

                    <!-- Modular Architecture -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                            <h3 class="ml-3 text-lg font-medium text-gray-900">Modular System</h3>
                        </div>
                        <p class="mt-4 text-gray-500">
                            Extensible module system that allows you to add new functionality without touching core code.
                        </p>
                        <div class="mt-4">
                            <a href="{{ route('hello') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                View Sample Module
                            </a>
                        </div>
                    </div>

                    <!-- User Management -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <svg class="h-8 w-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                            <h3 class="ml-3 text-lg font-medium text-gray-900">User Management</h3>
                        </div>
                        <p class="mt-4 text-gray-500">
                            Complete user authentication system with profiles, teams, and two-factor authentication.
                        </p>
                        <div class="mt-4">
                            <a href="{{ route('profile.show') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700">
                                Manage Profile
                            </a>
                        </div>
                    </div>

                    <!-- API Access -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <svg class="h-8 w-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                            <h3 class="ml-3 text-lg font-medium text-gray-900">API Integration</h3>
                        </div>
                        <p class="mt-4 text-gray-500">
                            RESTful API endpoints for integration with external applications and services.
                        </p>
                        <div class="mt-4">
                            <span class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-gray-100">
                                Coming Soon
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
