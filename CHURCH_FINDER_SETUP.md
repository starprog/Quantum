# Church Finder Feature - Google Places API Setup Instructions

## Get Your Google Places API Key

1. Go to https://console.cloud.google.com/
2. Create a new project or select an existing one
3. Enable the following APIs:
   - Places API
   - Maps JavaScript API
   - Geocoding API

4. Create credentials:
   - Go to "Credentials" in the left menu
   - Click "Create Credentials" → "API Key"
   - Copy your API key

5. (Optional) Restrict your API key:
   - Click on the API key to edit
   - Under "Application restrictions", select "HTTP referrers"
   - Add your domain (e.g., http://localhost, http://127.0.0.1:8000)
   - Under "API restrictions", select "Restrict key"
   - Select: Places API, Maps JavaScript API, Geocoding API

6. Add the API key to your `.env` file:
   ```
   GOOGLE_PLACES_API_KEY=your_api_key_here
   ```

7. Restart your Laravel server after adding the key

## Free Tier Limits

Google provides a monthly credit of $200, which includes:
- Places API: ~28,000 requests/month
- Geocoding API: ~40,000 requests/month
- Maps JavaScript API: ~28,000 map loads/month

This is more than enough for most small to medium applications.

## Features Implemented

✅ Search churches by zip code or city
✅ Adjustable search radius (2, 5, 10, 25 miles)
✅ Interactive Google Map with markers
✅ Church details (name, address, rating, hours)
✅ Save favorite churches (requires login)
✅ Get directions to church
✅ Purple gradient theme matching the app
✅ Responsive design

## Database Tables Created

- `churches` - Stores church information from Google Places
- `user_churches` - Pivot table for user's favorite churches

## Routes Added

- GET `/church-finder` - Main church finder page
- POST `/church-finder/search` - Search for churches
- GET `/church-finder/details/{placeId}` - Get church details
- POST `/church-finder/favorite` - Toggle favorite (auth required)
- GET `/church-finder/favorites` - Get user's favorites (auth required)

## Testing

1. Add your Google API key to `.env`
2. Visit http://127.0.0.1:8000/church-finder
3. Enter a zip code or city (e.g., "10001" or "New York, NY")
4. Click "Search Churches"
5. View results on map and in cards
6. Click "Directions" to get Google Maps directions
7. Click "Save" to add to favorites (requires login)
