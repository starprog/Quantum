# Last.fm API Setup Instructions

## Overview
The BPM Finder now features track statistics and AI-powered recommendations using the Last.fm API.

## Features Added
- **Left Panel**: Track statistics (listeners, play count, tags, description)
- **Right Panel**: Similar track recommendations with match percentages
- **Metadata Extraction**: Automatically reads artist, title, and album art from MP3 files

## Setup Steps

### 1. Get Last.fm API Key (Free)

1. Visit: https://www.last.fm/api/account/create
2. Sign in or create a Last.fm account
3. Fill out the application form:
   - **Application name**: BPM Finder
   - **Application description**: Music BPM detection and recommendation tool
   - **Callback URL**: http://localhost:8000/bpm (or leave blank for non-commercial use)
4. Click "Submit"
5. Copy your **API Key** (the long alphanumeric string)

### 2. Add API Key to .env File

1. Open `c:\Fierce Tech\Github\Quantum\.env`
2. Find the line: `LASTFM_API_KEY=`
3. Paste your API key after the equals sign:
   ```
   LASTFM_API_KEY=your_api_key_here_1234567890abcdef
   ```
4. Save the file

### 3. Rebuild Assets

```powershell
cd "c:\Fierce Tech\Github\Quantum"
npm run dev
```

### 4. Clear Laravel Cache (if needed)

```powershell
php artisan config:clear
php artisan cache:clear
```

## Usage

1. Upload an audio file (MP3 with ID3 tags recommended)
2. Wait for BPM detection to complete
3. If metadata (artist/title) is detected, two buttons will appear:
   - **Stats**: View track statistics, play counts, and description
   - **Similar**: Get AI-powered recommendations for similar tracks

## Supported File Formats

- **Best**: MP3 files with ID3 tags (v2.3 or v2.4)
- **Also supported**: M4A, FLAC, OGG (with metadata tags)

## Troubleshooting

### "Last.fm API key not configured" error
- Make sure you added the API key to `.env`
- Run `php artisan config:clear`
- Restart the Laravel server

### "Track not found" error
- The uploaded file doesn't have artist/title metadata
- Last.fm doesn't have information for this track
- Try uploading a more popular/mainstream track to test

### Metadata buttons don't appear
- File doesn't have ID3 tags embedded
- Use software like Mp3tag (Windows) or Kid3 (cross-platform) to add metadata

## API Limits

Last.fm free tier limits:
- No hard rate limit, but recommended: max 5 requests per second
- Fair use policy applies
- No commercial use without permission

## Privacy

- Audio files are processed locally (client-side)
- Only artist/title metadata is sent to Last.fm API
- No audio data is uploaded to external servers
