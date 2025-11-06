<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Bible Verse Widget</title>
    
    @livewireStyles
    
    <style>
        /* Theme variables */
        :root {
            --bg-gradient-1: #667eea;
            --bg-gradient-2: #764ba2;
            --widget-bg: #ffffff;
            --text-primary: #1f2937;
            --text-secondary: #6b7280;
        }
        
        body.dark-mode {
            --bg-gradient-1: #1e293b;
            --bg-gradient-2: #0f172a;
            --widget-bg: #1e293b;
            --text-primary: #f1f5f9;
            --text-secondary: #cbd5e1;
        }
        
        /* Minimal styling */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(135deg, var(--bg-gradient-1) 0%, var(--bg-gradient-2) 100%);
            padding: 1rem;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.3s ease;
        }
        
        .widget-container {
            width: 100%;
            max-width: 600px;
            position: relative;
        }
        
        .theme-toggle {
            position: absolute;
            top: -3rem;
            right: 0;
            background: rgba(255, 255, 255, 0.2);
            border: none;
            border-radius: 2rem;
            padding: 0.5rem 1rem;
            color: white;
            cursor: pointer;
            font-size: 0.875rem;
            font-weight: 600;
            transition: all 0.3s;
            backdrop-filter: blur(10px);
        }
        
        .theme-toggle:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .fade-in {
            animation: fadeIn 0.5s ease-out;
        }
        
        /* Widget Card Styles */
        .widget-card {
            background: var(--widget-bg);
            border-radius: 1rem;
            padding: 2rem;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            transition: background 0.3s;
        }
        
        /* Category Filter Styles */
        .category-filter-container {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
            padding: 1rem;
            background: var(--hover-bg);
            border-radius: 0.75rem;
            border: 1px solid var(--border-color);
        }
        
        .category-label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--text-primary);
            white-space: nowrap;
        }
        
        .category-select {
            flex: 1;
            padding: 0.625rem 1rem;
            border: 2px solid var(--border-color);
            border-radius: 0.5rem;
            background: var(--widget-bg);
            color: var(--text-primary);
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            outline: none;
        }
        
        .category-select:hover {
            border-color: #667eea;
        }
        
        .category-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        .btn-clear-filter {
            padding: 0.5rem;
            background: var(--widget-bg);
            border: 2px solid var(--text-secondary);
            border-radius: 0.5rem;
            color: var(--text-secondary);
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .btn-clear-filter:hover {
            background: #ef4444;
            border-color: #ef4444;
            color: white;
            transform: rotate(90deg);
        }
        
        /* Verse Content Styles */
        .verse-content {
            margin-bottom: 2rem;
        }
        
        .verse-text {
            font-size: 1.5rem;
            line-height: 1.6;
            color: var(--text-primary);
            margin-bottom: 1rem;
            font-weight: 500;
        }
        
        .verse-reference {
            font-size: 1.125rem;
            color: var(--text-secondary);
            text-align: right;
            font-style: italic;
            font-weight: 600;
        }
        
        /* Button Base Styles */
        .btn-base {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            font-size: 0.875rem;
            font-weight: 600;
            border-radius: 0.5rem;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .btn-outline {
            background: var(--widget-bg);
            color: var(--text-primary);
            border: 2px solid var(--text-secondary);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .btn-outline:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            box-shadow: 0 4px 6px rgba(102, 126, 234, 0.3);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(102, 126, 234, 0.4);
        }
        
        .btn-social {
            padding: 0.5rem 1rem;
            font-size: 0.75rem;
        }
        
        .btn-social:hover {
            transform: scale(1.05);
        }
        
        /* VOTD Badge */
        .votd-container {
            margin-bottom: 1.5rem;
            text-align: center;
        }
        
        .votd-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: linear-gradient(135deg, #f59e0b 0%, #f97316 100%);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            box-shadow: 0 4px 6px rgba(245, 158, 11, 0.3);
            animation: fadeIn 0.5s ease-in;
        }
        
        /* Utility Styles */
        .action-buttons {
            text-align: center;
            display: flex;
            gap: 0.75rem;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .social-share {
            margin-top: 1.5rem;
            text-align: center;
        }
        
        .social-label {
            font-size: 0.75rem;
            color: var(--text-secondary);
            margin-bottom: 0.75rem;
            font-weight: 600;
        }
        
        .copy-notification {
            display: none;
            margin-top: 1rem;
            padding: 0.75rem;
            background: #10b981;
            color: white;
            border-radius: 0.5rem;
            text-align: center;
            font-size: 0.875rem;
            font-weight: 600;
        }
        
        /* Font Size Controls */
        .font-size-controls {
            margin-top: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
        }
        
        .font-size-label {
            font-size: 0.875rem;
            color: var(--text-secondary);
            font-weight: 600;
        }
        
        .font-size-buttons {
            display: flex;
            gap: 0.5rem;
        }
        
        .btn-font {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 0.5rem;
            border: 2px solid var(--text-secondary);
            background: var(--widget-bg);
            color: var(--text-primary);
            font-size: 0.875rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .btn-font:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }
        
        .btn-font-active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-color: #667eea;
        }
        
        /* Font size classes */
        .verse-text.font-small {
            font-size: 1.125rem !important;
        }
        
        .verse-text.font-medium {
            font-size: 1.5rem !important;
        }
        
        .verse-text.font-large {
            font-size: 1.875rem !important;
        }
        
        /* History Modal Styles */
        .history-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(4px);
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: fadeIn 0.2s ease-out;
        }
        
        .history-modal-content {
            background: var(--card-bg);
            border-radius: 1rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            max-width: 500px;
            width: 90%;
            max-height: 80vh;
            display: flex;
            flex-direction: column;
            animation: slideUp 0.3s ease-out;
        }
        
        .history-modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem;
            border-bottom: 1px solid var(--border-color);
        }
        
        .history-modal-header h3 {
            margin: 0;
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-primary);
        }
        
        .history-close {
            background: none;
            border: none;
            font-size: 2rem;
            line-height: 1;
            color: var(--text-secondary);
            cursor: pointer;
            padding: 0;
            width: 2rem;
            height: 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 0.5rem;
            transition: all 0.2s ease;
        }
        
        .history-close:hover {
            background: var(--hover-bg);
            color: var(--text-primary);
        }
        
        .history-list {
            flex: 1;
            overflow-y: auto;
            padding: 1rem;
            min-height: 200px;
        }
        
        .history-item {
            padding: 1rem;
            border-radius: 0.75rem;
            background: var(--hover-bg);
            margin-bottom: 0.75rem;
            cursor: pointer;
            transition: all 0.2s ease;
            border: 2px solid transparent;
            position: relative;
        }
        
        .history-item:hover {
            background: var(--accent-color);
            transform: translateX(4px);
            border-color: #667eea;
        }
        
        .btn-remove-favorite {
            position: absolute;
            top: 0.5rem;
            right: 0.5rem;
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.3);
            border-radius: 0.375rem;
            width: 1.75rem;
            height: 1.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 1rem;
            line-height: 1;
            transition: all 0.2s ease;
        }
        
        .btn-remove-favorite:hover {
            background: #ef4444;
            color: white;
            transform: scale(1.1);
        }
        
        .history-item-text {
            color: var(--text-primary);
            font-size: 0.95rem;
            margin-bottom: 0.5rem;
            line-height: 1.4;
        }
        
        .history-item-reference {
            color: var(--text-secondary);
            font-size: 0.85rem;
            font-weight: 500;
        }
        
        .history-item-time {
            color: var(--text-muted);
            font-size: 0.75rem;
            margin-top: 0.25rem;
        }
        
        .history-empty {
            text-align: center;
            padding: 3rem 2rem;
            color: var(--text-secondary);
        }
        
        .history-empty svg {
            width: 4rem;
            height: 4rem;
            margin: 0 auto 1rem;
            opacity: 0.5;
        }
        
        .history-modal-footer {
            padding: 1rem 1.5rem;
            border-top: 1px solid var(--border-color);
            display: flex;
            justify-content: center;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Mobile Responsive Styles */
        @media (max-width: 640px) {
            .widget-card {
                padding: 1.5rem !important;
                border-radius: 0.75rem !important;
            }
            
            .category-filter-container {
                flex-wrap: wrap;
                padding: 0.75rem;
            }
            
            .category-label {
                font-size: 0.8rem;
            }
            
            .category-select {
                font-size: 0.8rem;
                padding: 0.5rem 0.75rem;
            }
            
            .verse-text {
                font-size: 1.25rem !important;
            }
            
            .verse-reference {
                font-size: 1rem !important;
            }
            
            .btn-base {
                padding: 0.65rem 1.25rem !important;
                font-size: 0.8rem !important;
            }
            
            .btn-base svg {
                width: 1rem !important;
                height: 1rem !important;
            }
            
            .votd-badge {
                font-size: 0.75rem !important;
                padding: 0.4rem 0.8rem !important;
            }
        }
        
        @media (max-width: 480px) {
            .widget-card {
                padding: 1.25rem !important;
            }
            
            .category-filter-container {
                gap: 0.5rem;
            }
            
            .category-label span {
                display: none;
            }
            
            .verse-text {
                font-size: 1.125rem !important;
            }
            
            .btn-base span:not([wire\:loading]) {
                display: none !important;
            }
            
            .btn-base {
                padding: 0.6rem !important;
                min-width: 44px;
                min-height: 44px;
            }
        }
        
        /* Mobile Responsive Styles */
        @media (max-width: 640px) {
            body {
                padding: 0.5rem;
            }
            
            .widget-container {
                max-width: 100%;
            }
            
            .theme-toggle {
                top: -2.5rem;
                font-size: 0.75rem;
                padding: 0.4rem 0.8rem;
            }
        }
        
        @media (max-width: 480px) {
            body {
                padding: 0.25rem;
                align-items: flex-start;
                padding-top: 3rem;
            }
            
            .theme-toggle {
                position: fixed;
                top: 0.5rem;
                right: 0.5rem;
                z-index: 1000;
            }
        }
    </style>
    
    <script>
        // Verse History Management
        const MAX_HISTORY = 10;
        
        function toggleHistory() {
            const modal = document.getElementById('historyModal');
            if (modal.style.display === 'none') {
                displayHistory();
                modal.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            } else {
                modal.style.display = 'none';
                document.body.style.overflow = '';
            }
        }
        
        function trackVerseView() {
            const verseText = document.getElementById('verseText')?.textContent;
            const verseReference = document.getElementById('verseReference')?.textContent;
            
            if (!verseText || !verseReference) return;
            
            let history = JSON.parse(localStorage.getItem('verseHistory') || '[]');
            
            // Check if this verse is already the most recent
            if (history.length > 0 && history[history.length - 1].reference === verseReference) {
                return;
            }
            
            const entry = {
                text: verseText.length > 80 ? verseText.substring(0, 80) + '...' : verseText,
                reference: verseReference,
                timestamp: Date.now()
            };
            
            history.push(entry);
            
            // Keep only last 10 entries
            if (history.length > MAX_HISTORY) {
                history = history.slice(-MAX_HISTORY);
            }
            
            localStorage.setItem('verseHistory', JSON.stringify(history));
        }
        
        function displayHistory() {
            const historyList = document.getElementById('historyList');
            const history = JSON.parse(localStorage.getItem('verseHistory') || '[]');
            
            if (history.length === 0) {
                historyList.innerHTML = `
                    <div class="history-empty">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p>No verses viewed yet</p>
                    </div>
                `;
                return;
            }
            
            // Display in reverse order (most recent first)
            const reversedHistory = [...history].reverse();
            historyList.innerHTML = reversedHistory.map((entry, index) => {
                const timeAgo = formatTimeAgo(entry.timestamp);
                return `
                    <div class="history-item" onclick="loadHistoricalVerse('${entry.reference.replace(/'/g, "\\'")}')">
                        <div class="history-item-text">${entry.text}</div>
                        <div class="history-item-reference">${entry.reference}</div>
                        <div class="history-item-time">${timeAgo}</div>
                    </div>
                `;
            }).join('');
        }
        
        function formatTimeAgo(timestamp) {
            const seconds = Math.floor((Date.now() - timestamp) / 1000);
            
            if (seconds < 60) return 'Just now';
            if (seconds < 3600) return Math.floor(seconds / 60) + ' min ago';
            if (seconds < 86400) return Math.floor(seconds / 3600) + ' hr ago';
            return Math.floor(seconds / 86400) + ' days ago';
        }
        
        function loadHistoricalVerse(reference) {
            toggleHistory(); // Close modal
            // Trigger new verse load - it will randomly pick one
            // Note: In a full implementation, you'd need to add a Livewire method to load by reference
            document.querySelector('[wire\\:click="refreshVerse"]')?.click();
        }
        
        function clearHistory() {
            if (confirm('Clear all verse history?')) {
                localStorage.removeItem('verseHistory');
                displayHistory();
            }
        }
        
        /* =================================
           Favorites Management
           ================================= */
        
        function toggleFavorite() {
            const verseText = document.getElementById('verseText')?.textContent;
            const verseReference = document.getElementById('verseReference')?.textContent;
            
            if (!verseText || !verseReference) return;
            
            let favorites = JSON.parse(localStorage.getItem('verseFavorites') || '[]');
            const existingIndex = favorites.findIndex(fav => fav.reference === verseReference);
            
            if (existingIndex > -1) {
                // Remove from favorites
                favorites.splice(existingIndex, 1);
                localStorage.setItem('verseFavorites', JSON.stringify(favorites));
                updateFavoriteButton(false);
                alert('Verse removed from favorites!');
            } else {
                // Add to favorites
                const entry = {
                    text: verseText.replace(/^"|"$/g, '').trim(),
                    reference: verseReference.replace(/^—\s*/, '').trim(),
                    timestamp: Date.now()
                };
                favorites.push(entry);
                localStorage.setItem('verseFavorites', JSON.stringify(favorites));
                updateFavoriteButton(true);
                alert('Verse added to favorites!');
            }
            
            updateFavoritesCount();
        }
        
        function updateFavoriteButton(isFavorited) {
            const star = document.getElementById('favoriteStar');
            if (!star) return;
            
            if (isFavorited) {
                star.style.fill = '#f59e0b';
                star.style.stroke = '#f59e0b';
            } else {
                star.style.fill = 'none';
                star.style.stroke = 'currentColor';
            }
        }
        
        function checkIfFavorited() {
            const verseReference = document.getElementById('verseReference')?.textContent;
            if (!verseReference) return;
            
            const favorites = JSON.parse(localStorage.getItem('verseFavorites') || '[]');
            const isFavorited = favorites.some(fav => fav.reference === verseReference);
            updateFavoriteButton(isFavorited);
        }
        
        function updateFavoritesCount() {
            const favorites = JSON.parse(localStorage.getItem('verseFavorites') || '[]');
            const countElement = document.getElementById('favoritesCount');
            if (countElement) {
                countElement.textContent = `View Favorites (${favorites.length})`;
            }
        }
        
        function showFavorites() {
            const modal = document.getElementById('favoritesModal');
            if (modal.style.display === 'none') {
                displayFavorites();
                modal.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            } else {
                modal.style.display = 'none';
                document.body.style.overflow = '';
            }
        }
        
        function displayFavorites() {
            const favoritesList = document.getElementById('favoritesList');
            const favorites = JSON.parse(localStorage.getItem('verseFavorites') || '[]');
            
            if (favorites.length === 0) {
                favoritesList.innerHTML = `
                    <div class="history-empty">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                        <p>No favorite verses yet</p>
                        <p style="font-size: 0.875rem; margin-top: 0.5rem;">Click the star button to save verses!</p>
                    </div>
                `;
                return;
            }
            
            // Display in reverse order (most recent first)
            const reversedFavorites = [...favorites].reverse();
            favoritesList.innerHTML = reversedFavorites.map((entry, index) => {
                const timeAgo = formatTimeAgo(entry.timestamp);
                const truncatedText = entry.text.length > 80 ? entry.text.substring(0, 80) + '...' : entry.text;
                return `
                    <div class="history-item">
                        <div class="history-item-text">"${truncatedText}"</div>
                        <div class="history-item-reference">${entry.reference}</div>
                        <div class="history-item-time">Added ${timeAgo}</div>
                        <button onclick="removeFavorite('${entry.reference.replace(/'/g, "\\'")}'); event.stopPropagation();" 
                                class="btn-remove-favorite" 
                                title="Remove from favorites">
                            ✕
                        </button>
                    </div>
                `;
            }).join('');
        }
        
        function removeFavorite(reference) {
            if (confirm('Remove this verse from favorites?')) {
                let favorites = JSON.parse(localStorage.getItem('verseFavorites') || '[]');
                favorites = favorites.filter(fav => fav.reference !== reference);
                localStorage.setItem('verseFavorites', JSON.stringify(favorites));
                displayFavorites();
                updateFavoritesCount();
                checkIfFavorited();
            }
        }
        
        function clearAllFavorites() {
            if (confirm('Clear all favorite verses?')) {
                localStorage.removeItem('verseFavorites');
                displayFavorites();
                updateFavoritesCount();
                checkIfFavorited();
            }
        }
        
        // Dark mode toggle
        function toggleTheme() {
            document.body.classList.toggle('dark-mode');
            const isDark = document.body.classList.contains('dark-mode');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
            updateThemeButton();
        }
        
        function updateThemeButton() {
            const btn = document.getElementById('themeToggle');
            if (btn) {
                btn.textContent = document.body.classList.contains('dark-mode') ? '☀️ Light' : '🌙 Dark';
            }
        }
        
        // Load saved theme
        document.addEventListener('DOMContentLoaded', function() {
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme === 'dark') {
                document.body.classList.add('dark-mode');
            }
            updateThemeButton();
            
            // Load saved font size
            const savedFontSize = localStorage.getItem('fontSize') || 'medium';
            setFontSize(savedFontSize);
        });
        
        /* =================================
           Font Size Controls
           ================================= */
        
        function setFontSize(size) {
            const verseText = document.getElementById('verseText');
            if (!verseText) return;
            
            // Remove all font size classes
            verseText.classList.remove('font-small', 'font-medium', 'font-large');
            
            // Add the selected size class
            verseText.classList.add(`font-${size}`);
            
            // Update button states
            document.querySelectorAll('.btn-font').forEach(btn => {
                btn.classList.remove('btn-font-active');
            });
            
            const activeBtn = document.getElementById(`font${size.charAt(0).toUpperCase() + size.slice(1)}`);
            if (activeBtn) {
                activeBtn.classList.add('btn-font-active');
            }
            
            // Save preference
            localStorage.setItem('fontSize', size);
        }
        
        /* =================================
           Verse Widget Functions
           ================================= */
        
        // Get verse data from DOM
        function getVerseFromDOM() {
            const verseText = document.getElementById('verseText')?.innerText.replace(/^"|"$/g, '').trim();
            const verseRef = document.getElementById('verseReference')?.innerText.replace(/^—\s*/, '').trim();
            return { verse: verseText, reference: verseRef };
        }
        
        // Print verse
        function printVerse() {
            window.print();
        }
        
        // Copy verse to clipboard
        function copyVerseFromDOM() {
            const { verse, reference } = getVerseFromDOM();
            
            if (verse && reference) {
                copyVerse(verse, reference);
            } else {
                alert('Error: Could not read verse text. Please refresh the page.');
            }
        }
        
        function copyVerse(verse, reference) {
            const text = `"${verse}" — ${reference}`;
            navigator.clipboard.writeText(text).then(() => {
                const notification = document.getElementById('copyNotification');
                if (notification) {
                    notification.style.display = 'block';
                    setTimeout(() => {
                        notification.style.display = 'none';
                    }, 2000);
                }
            }).catch(err => {
                console.error('Failed to copy:', err);
            });
        }
        
        /* =================================
           Social Share Functions
           ================================= */
        
        // Universal share handler that reads from DOM
        function shareFromDOM(platform) {
            const { verse, reference } = getVerseFromDOM();
            
            if (!verse || !reference) {
                alert('Error: Could not read verse text. Please refresh the page.');
                return;
            }
            
            switch(platform) {
                case 'twitter':
                    shareOnTwitter(verse, reference);
                    break;
                case 'facebook':
                    shareOnFacebook(verse, reference);
                    break;
                case 'whatsapp':
                    shareOnWhatsApp(verse, reference);
                    break;
                case 'email':
                    shareViaEmail(verse, reference);
                    break;
                default:
                    console.error('Unknown platform:', platform);
            }
        }
        
        function shareOnTwitter(verse, reference) {
            const text = encodeURIComponent(`"${verse}" — ${reference}`);
            const url = `https://twitter.com/intent/tweet?text=${text}`;
            const popup = window.open(url, '_blank', 'width=550,height=420');
            if (!popup || popup.closed || typeof popup.closed == 'undefined') {
                // Popup blocked, fallback to opening in same window
                alert('Popup blocked! Opening Twitter in a new tab...');
                window.open(url, '_blank');
            }
        }
        
        function shareOnFacebook(verse, reference) {
            const text = encodeURIComponent(`"${verse}" — ${reference}`);
            const url = `https://www.facebook.com/sharer/sharer.php?quote=${text}`;
            const popup = window.open(url, '_blank', 'width=550,height=420');
            if (!popup || popup.closed || typeof popup.closed == 'undefined') {
                alert('Popup blocked! Opening Facebook in a new tab...');
                window.open(url, '_blank');
            }
        }
        
        function shareOnWhatsApp(verse, reference) {
            const text = encodeURIComponent(`"${verse}" — ${reference}`);
            const url = `https://wa.me/?text=${text}`;
            const popup = window.open(url, '_blank');
            if (!popup || popup.closed || typeof popup.closed == 'undefined') {
                alert('Popup blocked! Opening WhatsApp in a new tab...');
                window.open(url, '_blank');
            }
        }
        
        function shareViaEmail(verse, reference) {
            const subject = encodeURIComponent('Bible Verse to Share');
            const body = encodeURIComponent(`"${verse}"\n\n— ${reference}\n\nShared from Bible Verse Widget`);
            const mailtoUrl = `mailto:?subject=${subject}&body=${body}`;
            window.location.href = mailtoUrl;
        }
        
        /* =================================
           Keyboard Shortcuts
           ================================= */
        
        document.addEventListener('keydown', function(e) {
            // Ignore if typing in input field
            if (e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA') return;
            
            const key = e.key.toLowerCase();
            
            // Font size shortcuts (Shift + S/L)
            if (e.shiftKey && key === 's') {
                e.preventDefault();
                setFontSize('small');
            }
            
            if (e.shiftKey && key === 'l') {
                e.preventDefault();
                setFontSize('large');
            }
            
            if (e.shiftKey && key === 'm') {
                e.preventDefault();
                setFontSize('medium');
            }
            
            // N - New Verse
            if (key === 'n') {
                e.preventDefault();
                const newVerseBtn = document.getElementById('newVerseBtn');
                if (newVerseBtn) newVerseBtn.click();
            }
            
            // H - History
            if (key === 'h') {
                e.preventDefault();
                toggleHistory();
            }
            
            // F - Toggle Favorite
            if (key === 'f') {
                e.preventDefault();
                toggleFavorite();
            }
            
            // V - View Favorites
            if (key === 'v') {
                e.preventDefault();
                showFavorites();
            }
            
            // C - Copy
            if (key === 'c') {
                e.preventDefault();
                copyVerseFromDOM();
            }
            
            // P - Print
            if (key === 'p') {
                e.preventDefault();
                printVerse();
            }
            
            // E - Email
            if (key === 'e') {
                e.preventDefault();
                shareFromDOM('email');
            }
        });
        
        // Track verse view on page load and after Livewire updates
        document.addEventListener('DOMContentLoaded', function() {
            // Initial verse tracking
            setTimeout(trackVerseView, 500);
            
            // Initialize favorites UI
            updateFavoritesCount();
            setTimeout(checkIfFavorited, 500);
        });
        
        // Listen for Livewire updates to track new verses
        document.addEventListener('livewire:load', function() {
            Livewire.hook('message.processed', (message, component) => {
                setTimeout(trackVerseView, 500);
                setTimeout(checkIfFavorited, 500);
            });
        });
    </script>
</head>
<body>
    <div class="widget-container">
        <button id="themeToggle" class="theme-toggle" onclick="toggleTheme()">🌙 Dark</button>
        @livewire('bible-verse-embed')
    </div>
    
    <!-- Livewire Scripts -->
    @livewireScripts
</body>
</html>
