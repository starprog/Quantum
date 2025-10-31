<x-app-layout>
    <div style="min-height: 100vh; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
        <div style="max-width: 1280px; margin: 0 auto; padding: 3rem 1.5rem;">
            <!-- Hero Welcome Section -->
            <div style="text-align: center; margin-bottom: 3rem;">
                <h1 style="font-size: 3.5rem; font-weight: 800; color: white; margin-bottom: 1rem; text-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                    Welcome to Quantum
                </h1>
                <p style="font-size: 1.25rem; color: rgba(255,255,255,0.9); max-width: 600px; margin: 0 auto;">
                    Your journey to spiritual growth and enlightenment begins here
                </p>
            </div>

            <!-- Verse of the Day Section -->
            @if($verseOfTheDay)
            <div style="background: white; border-radius: 1.5rem; padding: 2.5rem; margin-bottom: 3rem; 
                        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
                        transform: translateY(0); transition: all 0.3s;"
                 onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 25px 50px -12px rgba(0, 0, 0, 0.25)';"
                 onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)';">
                
                <!-- Decorative Quote Mark -->
                <div style="position: relative; margin-bottom: 1.5rem;">
                    <span style="font-size: 6rem; color: #e5e7eb; font-family: Georgia, serif; line-height: 1; position: absolute; top: -2rem; left: -0.5rem;">"</span>
                </div>
                
                <div style="position: relative; padding-left: 3rem;">
                    <div style="margin-bottom: 1rem;">
                        <span style="display: inline-block; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
                                   color: white; padding: 0.5rem 1rem; border-radius: 9999px; font-size: 0.875rem; font-weight: 600;">
                            ✨ Verse of the Day
                        </span>
                        <span style="display: inline-block; margin-left: 0.5rem; background: #f3f4f6; color: #374151; 
                                   padding: 0.5rem 1rem; border-radius: 9999px; font-size: 0.875rem; font-weight: 500;">
                            {{ $verseOfTheDay->category->name }}
                        </span>
                    </div>
                    
                    <p style="font-size: 1.5rem; line-height: 1.75; color: #1f2937; margin-bottom: 1.5rem; font-weight: 500;">
                        {{ $verseOfTheDay->verse }}
                    </p>
                    
                    <div style="display: flex; align-items: center; justify-content: space-between;">
                        <p style="font-size: 1.125rem; color: #6b7280; font-style: italic; font-weight: 600;">
                            — {{ $verseOfTheDay->reference }}
                        </p>
                        <a href="{{ route('bible-verse') }}" 
                           style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.75rem 1.5rem;
                                  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;
                                  border-radius: 0.5rem; font-weight: 600; text-decoration: none; font-size: 0.875rem;
                                  box-shadow: 0 4px 6px rgba(0,0,0,0.1); transition: all 0.2s;"
                           onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 12px rgba(0,0,0,0.15)';"
                           onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px rgba(0,0,0,0.1)';">
                            Explore More Verses →
                        </a>
                    </div>
                </div>
            </div>
            @endif

            <!-- Features Grid -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem; margin-bottom: 3rem;">
                <!-- Daily Verses Feature -->
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
                    <h3 style="font-size: 1.25rem; font-weight: 700; color: #1f2937; margin-bottom: 0.75rem;">Daily Verses</h3>
                    <p style="color: #6b7280; margin-bottom: 1.5rem; line-height: 1.6;">
                        Explore our collection of inspiring Bible verses for daily guidance and reflection.
                    </p>
                    <a href="{{ route('bible-verse') }}" 
                       style="display: inline-block; padding: 0.75rem 1.5rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
                              color: white; border-radius: 0.5rem; font-weight: 600; text-decoration: none; font-size: 0.875rem;
                              transition: all 0.2s;"
                       onmouseover="this.style.opacity='0.9'"
                       onmouseout="this.style.opacity='1'">
                        View More
                    </a>
                </div>

                <!-- Services Feature -->
                <div style="background: white; border-radius: 1rem; padding: 2rem; 
                            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); transition: all 0.3s;"
                     onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 20px 25px -5px rgba(0, 0, 0, 0.1)';"
                     onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 15px -3px rgba(0, 0, 0, 0.1)';">
                    <div style="width: 3.5rem; height: 3.5rem; background: linear-gradient(135deg, #10b981 0%, #059669 100%); 
                                border-radius: 1rem; display: flex; align-items: center; justify-content: center; margin-bottom: 1.5rem;">
                        <svg style="width: 2rem; height: 2rem; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m8 0h2a2 2 0 012 2v6M8 6H6a2 2 0 00-2 2v6"></path>
                        </svg>
                    </div>
                    <h3 style="font-size: 1.25rem; font-weight: 700; color: #1f2937; margin-bottom: 0.75rem;">Our Services</h3>
                    <p style="color: #6b7280; margin-bottom: 1.5rem; line-height: 1.6;">
                        Discover the range of spiritual services and resources we offer.
                    </p>
                    <a href="{{ route('services') }}" 
                       style="display: inline-block; padding: 0.75rem 1.5rem; background: linear-gradient(135deg, #10b981 0%, #059669 100%); 
                              color: white; border-radius: 0.5rem; font-weight: 600; text-decoration: none; font-size: 0.875rem;
                              transition: all 0.2s;"
                       onmouseover="this.style.opacity='0.9'"
                       onmouseout="this.style.opacity='1'">
                        Learn More
                    </a>
                </div>

                <!-- Personalize Feature -->
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
                    <h3 style="font-size: 1.25rem; font-weight: 700; color: #1f2937; margin-bottom: 0.75rem;">Personalize</h3>
                    <p style="color: #6b7280; margin-bottom: 1.5rem; line-height: 1.6;">
                        Customize your experience and manage your preferences.
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

                @auth
                <!-- Favorites Feature -->
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
                    <h3 style="font-size: 1.25rem; font-weight: 700; color: #1f2937; margin-bottom: 0.75rem;">My Favorites</h3>
                    <p style="color: #6b7280; margin-bottom: 1.5rem; line-height: 1.6;">
                        View and manage your favorite Bible verses collection.
                    </p>
                    <a href="{{ route('favorites.index') }}" 
                       style="display: inline-block; padding: 0.75rem 1.5rem; background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); 
                              color: white; border-radius: 0.5rem; font-weight: 600; text-decoration: none; font-size: 0.875rem;
                              transition: all 0.2s;"
                       onmouseover="this.style.opacity='0.9'"
                       onmouseout="this.style.opacity='1'">
                        View Favorites
                    </a>
                </div>
                @endauth
            </div>


        </div>
    </div>
</x-app-layout>
