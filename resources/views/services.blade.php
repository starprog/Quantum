<x-app-layout>
    <div style="min-height: 100vh; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
        <div style="max-width: 1280px; margin: 0 auto; padding: 3rem 1.5rem;">
            
            <!-- Hero Section -->
            <div style="text-align: center; margin-bottom: 3rem;">
                <h1 style="font-size: 3.5rem; font-weight: 800; color: white; margin-bottom: 1rem; text-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                    Our Services
                </h1>
                <p style="font-size: 1.25rem; color: rgba(255,255,255,0.9); max-width: 600px; margin: 0 auto;">
                    Explore the powerful features and services available in Quantum
                </p>
            </div>

            <!-- Services Grid -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem; margin-bottom: 3rem;">
                
                <!-- Bible Verses Service -->
                <div style="background: white; border-radius: 1rem; padding: 2rem; 
                            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); transition: all 0.3s;"
                     onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 20px 25px -5px rgba(0, 0, 0, 0.1)';"
                     onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 15px -3px rgba(0, 0, 0, 0.1)';">
                    <div style="width: 3.5rem; height: 3.5rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
                                border-radius: 1rem; display: flex; align-items: center; justify-content: center; margin-bottom: 1.5rem;">
                        <svg style="width: 2rem; height: 2rem; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <h3 style="font-size: 1.25rem; font-weight: 700; color: #1f2937; margin-bottom: 0.75rem;">Daily Bible Verses</h3>
                    <p style="color: #6b7280; margin-bottom: 1.5rem; line-height: 1.6;">
                        Access a curated collection of Bible verses organized by category for daily inspiration and spiritual growth.
                    </p>
                    <a href="{{ route('bible-verse') }}" 
                       style="display: inline-block; padding: 0.75rem 1.5rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
                              color: white; border-radius: 0.5rem; font-weight: 600; text-decoration: none; font-size: 0.875rem;
                              transition: all 0.2s;"
                       onmouseover="this.style.opacity='0.9'"
                       onmouseout="this.style.opacity='1'">
                        Explore Verses
                    </a>
                </div>

                <!-- Church Finder Service (NEW!) -->
                <div style="background: white; border-radius: 1rem; padding: 2rem; 
                            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); transition: all 0.3s; position: relative;
                            border: 2px solid transparent;"
                     onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 20px 25px -5px rgba(0, 0, 0, 0.1)'; this.style.borderColor='#667eea';"
                     onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 15px -3px rgba(0, 0, 0, 0.1)'; this.style.borderColor='transparent';">
                    <span style="position: absolute; top: 1rem; right: 1rem; padding: 0.25rem 0.75rem; 
                                 background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; 
                                 font-size: 0.75rem; font-weight: 700; border-radius: 9999px;">NEW!</span>
                    <div style="width: 3.5rem; height: 3.5rem; background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%); 
                                border-radius: 1rem; display: flex; align-items: center; justify-content: center; margin-bottom: 1.5rem;">
                        <svg style="width: 2rem; height: 2rem; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <h3 style="font-size: 1.25rem; font-weight: 700; color: #1f2937; margin-bottom: 0.75rem;">Find Local Churches</h3>
                    <p style="color: #6b7280; margin-bottom: 1.5rem; line-height: 1.6;">
                        Discover churches in your area by zip code or city. View locations on a map, get directions, and save your favorites.
                    </p>
                    <a href="{{ route('church-finder') }}" 
                       style="display: inline-block; padding: 0.75rem 1.5rem; background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%); 
                              color: white; border-radius: 0.5rem; font-weight: 600; text-decoration: none; font-size: 0.875rem;
                              transition: all 0.2s;"
                       onmouseover="this.style.opacity='0.9'"
                       onmouseout="this.style.opacity='1'">
                        🗺️ Find Churches
                    </a>
                </div>

                <!-- Favorites Service -->
                <div style="background: white; border-radius: 1rem; padding: 2rem; 
                            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); transition: all 0.3s;"
                     onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 20px 25px -5px rgba(0, 0, 0, 0.1)';"
                     onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 15px -3px rgba(0, 0, 0, 0.1)';">
                    <div style="width: 3.5rem; height: 3.5rem; background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); 
                                border-radius: 1rem; display: flex; align-items: center; justify-content: center; margin-bottom: 1.5rem;">
                        <svg style="width: 2rem; height: 2rem; color: white;" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h3 style="font-size: 1.25rem; font-weight: 700; color: #1f2937; margin-bottom: 0.75rem;">Favorite Verses</h3>
                    <p style="color: #6b7280; margin-bottom: 1.5rem; line-height: 1.6;">
                        Save your favorite verses for quick access and create your personal collection of inspirational scriptures.
                    </p>
                    @auth
                    <a href="{{ route('favorites.index') }}" 
                       style="display: inline-block; padding: 0.75rem 1.5rem; background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); 
                              color: white; border-radius: 0.5rem; font-weight: 600; text-decoration: none; font-size: 0.875rem;
                              transition: all 0.2s;"
                       onmouseover="this.style.opacity='0.9'"
                       onmouseout="this.style.opacity='1'">
                        View Favorites
                    </a>
                    @else
                    <a href="{{ route('login') }}" 
                       style="display: inline-block; padding: 0.75rem 1.5rem; background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); 
                              color: white; border-radius: 0.5rem; font-weight: 600; text-decoration: none; font-size: 0.875rem;
                              transition: all 0.2s;"
                       onmouseover="this.style.opacity='0.9'"
                       onmouseout="this.style.opacity='1'">
                        Login to View
                    </a>
                    @endauth
                </div>

                <!-- User Management -->
                <div style="background: white; border-radius: 1rem; padding: 2rem; 
                            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); transition: all 0.3s;"
                     onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 20px 25px -5px rgba(0, 0, 0, 0.1)';"
                     onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 15px -3px rgba(0, 0, 0, 0.1)';">
                    <div style="width: 3.5rem; height: 3.5rem; background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); 
                                border-radius: 1rem; display: flex; align-items: center; justify-content: center; margin-bottom: 1.5rem;">
                        <svg style="width: 2rem; height: 2rem; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <h3 style="font-size: 1.25rem; font-weight: 700; color: #1f2937; margin-bottom: 0.75rem;">Profile Management</h3>
                    <p style="color: #6b7280; margin-bottom: 1.5rem; line-height: 1.6;">
                        Complete user profile system with customization options, security settings, and account management.
                    </p>
                    @auth
                    <a href="{{ route('profile.show') }}" 
                       style="display: inline-block; padding: 0.75rem 1.5rem; background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); 
                              color: white; border-radius: 0.5rem; font-weight: 600; text-decoration: none; font-size: 0.875rem;
                              transition: all 0.2s;"
                       onmouseover="this.style.opacity='0.9'"
                       onmouseout="this.style.opacity='1'">
                        Manage Profile
                    </a>
                    @else
                    <a href="{{ route('login') }}" 
                       style="display: inline-block; padding: 0.75rem 1.5rem; background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); 
                              color: white; border-radius: 0.5rem; font-weight: 600; text-decoration: none; font-size: 0.875rem;
                              transition: all 0.2s;"
                       onmouseover="this.style.opacity='0.9'"
                       onmouseout="this.style.opacity='1'">
                        Login to Access
                    </a>
                    @endauth
                </div>

                <!-- Settings -->
                <div style="background: white; border-radius: 1rem; padding: 2rem; 
                            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); transition: all 0.3s;"
                     onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 20px 25px -5px rgba(0, 0, 0, 0.1)';"
                     onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 15px -3px rgba(0, 0, 0, 0.1)';">
                    <div style="width: 3.5rem; height: 3.5rem; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); 
                                border-radius: 1rem; display: flex; align-items: center; justify-content: center; margin-bottom: 1.5rem;">
                        <svg style="width: 2rem; height: 2rem; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <h3 style="font-size: 1.25rem; font-weight: 700; color: #1f2937; margin-bottom: 0.75rem;">Personalization</h3>
                    <p style="color: #6b7280; margin-bottom: 1.5rem; line-height: 1.6;">
                        Customize your experience with personalized settings and preferences for the application.
                    </p>
                    <a href="{{ route('settings') }}" 
                       style="display: inline-block; padding: 0.75rem 1.5rem; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); 
                              color: white; border-radius: 0.5rem; font-weight: 600; text-decoration: none; font-size: 0.875rem;
                              transition: all 0.2s;"
                       onmouseover="this.style.opacity='0.9'"
                       onmouseout="this.style.opacity='1'">
                        Settings
                    </a>
                </div>

                <!-- Modular System -->
                <div style="background: white; border-radius: 1rem; padding: 2rem; 
                            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); transition: all 0.3s;"
                     onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 20px 25px -5px rgba(0, 0, 0, 0.1)';"
                     onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 15px -3px rgba(0, 0, 0, 0.1)';">
                    <div style="width: 3.5rem; height: 3.5rem; background: linear-gradient(135deg, #10b981 0%, #059669 100%); 
                                border-radius: 1rem; display: flex; align-items: center; justify-content: center; margin-bottom: 1.5rem;">
                        <svg style="width: 2rem; height: 2rem; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                    <h3 style="font-size: 1.25rem; font-weight: 700; color: #1f2937; margin-bottom: 0.75rem;">Modular Architecture</h3>
                    <p style="color: #6b7280; margin-bottom: 1.5rem; line-height: 1.6;">
                        Extensible module system that allows adding new functionality without modifying core code.
                    </p>
                    <span style="display: inline-block; padding: 0.75rem 1.5rem; background: rgba(255, 255, 255, 0.95); 
                                 color: #6b7280; border-radius: 0.5rem; font-weight: 600; font-size: 0.875rem;
                                 border: 2px solid #e5e7eb;">
                        Powered by Modules
                    </span>
                </div>

                <!-- API Integration -->
                <div style="background: white; border-radius: 1rem; padding: 2rem; 
                            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); transition: all 0.3s;"
                     onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 20px 25px -5px rgba(0, 0, 0, 0.1)';"
                     onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 15px -3px rgba(0, 0, 0, 0.1)';">
                    <div style="width: 3.5rem; height: 3.5rem; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); 
                                border-radius: 1rem; display: flex; align-items: center; justify-content: center; margin-bottom: 1.5rem;">
                        <svg style="width: 2rem; height: 2rem; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 style="font-size: 1.25rem; font-weight: 700; color: #1f2937; margin-bottom: 0.75rem;">API Integration</h3>
                    <p style="color: #6b7280; margin-bottom: 1.5rem; line-height: 1.6;">
                        RESTful API endpoints for seamless integration with external applications and services.
                    </p>
                    <span style="display: inline-block; padding: 0.75rem 1.5rem; background: rgba(255, 255, 255, 0.95); 
                                 color: #6b7280; border-radius: 0.5rem; font-weight: 600; font-size: 0.875rem;
                                 border: 2px solid #e5e7eb;">
                        Coming Soon
                    </span>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
