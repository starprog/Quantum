<x-app-layout>
    <div style="min-height: 100vh; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
        <div style="max-width: 1400px; margin: 0 auto; padding: 2rem 1.5rem;">
            
            <!-- Hero Section -->
            <div style="text-align: center; margin-bottom: 2rem;">
                <h1 style="font-size: 3rem; font-weight: 800; color: white; margin-bottom: 1rem; text-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                    Find Churches Near You
                </h1>
                <p style="font-size: 1.125rem; color: rgba(255,255,255,0.9); max-width: 600px; margin: 0 auto;">
                    Discover churches in your area by zip code or city
                </p>
            </div>

            <!-- Search Section -->
            <div style="background: white; border-radius: 1rem; padding: 2rem; 
                        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); margin-bottom: 2rem;">
                <form id="churchSearchForm" style="display: grid; grid-template-columns: 1fr auto auto; gap: 1rem; align-items: end;">
                    <div>
                        <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">
                            Location (Zip Code or City)
                        </label>
                        <input type="text" 
                               id="location" 
                               name="location" 
                               placeholder="Enter zip code or city, state" 
                               required
                               style="width: 100%; padding: 0.75rem 1rem; border: 2px solid #e5e7eb; border-radius: 0.5rem; 
                                      font-size: 1rem; transition: all 0.2s;"
                               onfocus="this.style.borderColor='#667eea'"
                               onblur="this.style.borderColor='#e5e7eb'">
                    </div>
                    
                    <div>
                        <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">
                            Radius
                        </label>
                        <select id="radius" 
                                name="radius"
                                style="width: 150px; padding: 0.75rem 1rem; border: 2px solid #e5e7eb; border-radius: 0.5rem; 
                                       font-size: 1rem; background: white;">
                            <option value="3000">2 miles</option>
                            <option value="8000" selected>5 miles</option>
                            <option value="16000">10 miles</option>
                            <option value="40000">25 miles</option>
                        </select>
                    </div>
                    
                    <button type="submit" 
                            style="padding: 0.75rem 2rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
                                   color: white; border: none; border-radius: 0.5rem; font-weight: 600; font-size: 1rem;
                                   cursor: pointer; transition: all 0.2s; white-space: nowrap;"
                            onmouseover="this.style.opacity='0.9'"
                            onmouseout="this.style.opacity='1'">
                        🔍 Search Churches
                    </button>
                </form>
            </div>

            <!-- Loading Indicator -->
            <div id="loadingIndicator" style="display: none; text-align: center; padding: 2rem;">
                <div style="display: inline-block; width: 3rem; height: 3rem; border: 4px solid rgba(255,255,255,0.3); 
                            border-radius: 50%; border-top-color: white; animation: spin 1s linear infinite;"></div>
                <p style="color: white; margin-top: 1rem; font-weight: 600;">Searching for churches...</p>
            </div>

            <!-- Results Container -->
            <div id="resultsContainer" style="display: none;">
                <!-- Map Container -->
                <div style="background: white; border-radius: 1rem; padding: 1rem; 
                            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); margin-bottom: 2rem;">
                    <div id="map" style="width: 100%; height: 400px; border-radius: 0.5rem;"></div>
                </div>

                <!-- Results Grid -->
                <div id="churchResults" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 1.5rem;">
                    <!-- Church cards will be inserted here -->
                </div>
            </div>

            <!-- No Results Message -->
            <div id="noResults" style="display: none; text-align: center; padding: 3rem;">
                <div style="background: white; border-radius: 1rem; padding: 3rem; 
                            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);">
                    <svg style="width: 4rem; height: 4rem; color: #9ca3af; margin: 0 auto 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3 style="font-size: 1.5rem; font-weight: 700; color: #374151; margin-bottom: 0.5rem;">
                        No Churches Found
                    </h3>
                    <p style="color: #6b7280;">
                        Try adjusting your search location or increasing the search radius
                    </p>
                </div>
            </div>

        </div>
    </div>

    <style>
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>

    <!-- Google Maps API -->
    <script src="https://maps.googleapis.com/maps/api/js?key={{ $apiKey }}&libraries=places"></script>
    
    <script>
        let map;
        let markers = [];
        let userLocation = null;

        document.getElementById('churchSearchForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const location = document.getElementById('location').value;
            const radius = document.getElementById('radius').value;
            
            // Show loading
            document.getElementById('loadingIndicator').style.display = 'block';
            document.getElementById('resultsContainer').style.display = 'none';
            document.getElementById('noResults').style.display = 'none';
            
            try {
                const response = await fetch('{{ route('church-finder.search') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ location, radius })
                });
                
                const data = await response.json();
                
                // Hide loading
                document.getElementById('loadingIndicator').style.display = 'none';
                
                if (data.success && data.churches.length > 0) {
                    userLocation = data.location;
                    displayResults(data.churches, data.location);
                } else {
                    document.getElementById('noResults').style.display = 'block';
                }
                
            } catch (error) {
                console.error('Search failed:', error);
                document.getElementById('loadingIndicator').style.display = 'none';
                alert('Search failed. Please try again.');
            }
        });

        function displayResults(churches, location) {
            // Initialize map
            initMap(location.lat, location.lng);
            
            // Clear previous markers
            markers.forEach(marker => marker.setMap(null));
            markers = [];
            
            // Display church cards
            const resultsContainer = document.getElementById('churchResults');
            resultsContainer.innerHTML = '';
            
            churches.forEach((church, index) => {
                // Add marker to map
                const marker = new google.maps.Marker({
                    position: { lat: church.latitude, lng: church.longitude },
                    map: map,
                    title: church.name,
                    label: (index + 1).toString()
                });
                markers.push(marker);
                
                // Create info window
                const infoWindow = new google.maps.InfoWindow({
                    content: `<div style="padding: 0.5rem;">
                        <h4 style="font-weight: 700; margin-bottom: 0.25rem;">${church.name}</h4>
                        <p style="color: #6b7280; font-size: 0.875rem;">${church.address || 'Address not available'}</p>
                        ${church.rating ? `<p style="color: #f59e0b; font-size: 0.875rem;">⭐ ${church.rating} (${church.user_ratings_total} reviews)</p>` : ''}
                    </div>`
                });
                
                marker.addListener('click', () => {
                    infoWindow.open(map, marker);
                });
                
                // Create church card
                const card = createChurchCard(church, index + 1);
                resultsContainer.appendChild(card);
            });
            
            document.getElementById('resultsContainer').style.display = 'block';
        }

        function initMap(lat, lng) {
            map = new google.maps.Map(document.getElementById('map'), {
                center: { lat, lng },
                zoom: 13,
                styles: [
                    {
                        featureType: 'poi',
                        elementType: 'labels',
                        stylers: [{ visibility: 'off' }]
                    }
                ]
            });
        }

        function createChurchCard(church, number) {
            const card = document.createElement('div');
            card.style.cssText = `
                background: white; 
                border-radius: 1rem; 
                padding: 1.5rem; 
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
                transition: all 0.3s;
            `;
            
            card.innerHTML = `
                <div style="display: flex; align-items: start; gap: 1rem; margin-bottom: 1rem;">
                    <div style="width: 2.5rem; height: 2.5rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
                                border-radius: 0.5rem; display: flex; align-items: center; justify-content: center; 
                                color: white; font-weight: 700; font-size: 1.25rem; flex-shrink: 0;">
                        ${number}
                    </div>
                    <div style="flex: 1;">
                        <h3 style="font-size: 1.125rem; font-weight: 700; color: #1f2937; margin-bottom: 0.5rem;">
                            ${church.name}
                        </h3>
                        <p style="color: #6b7280; font-size: 0.875rem; line-height: 1.5;">
                            📍 ${church.address || 'Address not available'}
                        </p>
                    </div>
                </div>
                
                ${church.rating ? `
                    <div style="margin-bottom: 1rem;">
                        <span style="color: #f59e0b; font-weight: 600;">⭐ ${church.rating}</span>
                        <span style="color: #9ca3af; font-size: 0.875rem;"> (${church.user_ratings_total} reviews)</span>
                    </div>
                ` : ''}
                
                ${church.open_now !== null ? `
                    <div style="margin-bottom: 1rem;">
                        <span style="padding: 0.25rem 0.75rem; border-radius: 0.25rem; font-size: 0.875rem; font-weight: 600;
                                     ${church.open_now ? 'background: #d1fae5; color: #065f46;' : 'background: #fee2e2; color: #991b1b;'}">
                            ${church.open_now ? '🟢 Open Now' : '🔴 Closed'}
                        </span>
                    </div>
                ` : ''}
                
                <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                    <a href="https://www.google.com/maps/dir/?api=1&destination=${church.latitude},${church.longitude}" 
                       target="_blank"
                       style="padding: 0.5rem 1rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
                              color: white; border-radius: 0.5rem; font-weight: 600; text-decoration: none; font-size: 0.875rem;
                              display: inline-block;"
                       onmouseover="this.style.opacity='0.9'"
                       onmouseout="this.style.opacity='1'">
                        📍 Directions
                    </a>
                    @auth
                    <button onclick="toggleFavorite('${church.place_id}', '${church.name.replace(/'/g, "\\'")}', '${church.address || ''}', ${church.latitude}, ${church.longitude})"
                            style="padding: 0.5rem 1rem; background: rgba(239, 68, 68, 0.1); 
                                   color: #dc2626; border: 2px solid #dc2626; border-radius: 0.5rem; 
                                   font-weight: 600; font-size: 0.875rem; cursor: pointer;"
                            onmouseover="this.style.background='#dc2626'; this.style.color='white'"
                            onmouseout="this.style.background='rgba(239, 68, 68, 0.1)'; this.style.color='#dc2626'">
                        ❤️ Save
                    </button>
                    @endauth
                </div>
            `;
            
            card.addEventListener('mouseenter', () => {
                card.style.transform = 'translateY(-4px)';
                card.style.boxShadow = '0 10px 15px -3px rgba(0, 0, 0, 0.1)';
            });
            
            card.addEventListener('mouseleave', () => {
                card.style.transform = 'translateY(0)';
                card.style.boxShadow = '0 4px 6px -1px rgba(0, 0, 0, 0.1)';
            });
            
            return card;
        }

        @auth
        async function toggleFavorite(placeId, name, address, latitude, longitude) {
            try {
                const response = await fetch('{{ route('church-finder.favorite') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        place_id: placeId,
                        name: name,
                        address: address,
                        latitude: latitude,
                        longitude: longitude
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    alert(data.message);
                }
            } catch (error) {
                console.error('Failed to toggle favorite:', error);
                alert('Failed to save favorite. Please try again.');
            }
        }
        @endauth
    </script>
</x-app-layout>
