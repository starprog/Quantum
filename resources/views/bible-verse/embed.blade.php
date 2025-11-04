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
        
        /* Mobile Responsive Styles */
        @media (max-width: 640px) {
            .widget-card {
                padding: 1.5rem !important;
                border-radius: 0.75rem !important;
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
        });
        
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
            console.log('copyVerseFromDOM called');
            const { verse, reference } = getVerseFromDOM();
            console.log('Copy - Verse data:', { verse, reference });
            
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
            console.log('shareFromDOM called with platform:', platform);
            const { verse, reference } = getVerseFromDOM();
            console.log('Verse data:', { verse, reference });
            
            if (!verse || !reference) {
                console.error('Could not read verse from DOM');
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
            
            // N - New Verse
            if (key === 'n') {
                e.preventDefault();
                const newVerseBtn = document.getElementById('newVerseBtn');
                if (newVerseBtn) newVerseBtn.click();
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
