<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Bible Verse Widget</title>
    
    <!-- Livewire Styles -->
    <style>
        [wire\:loading], [wire\:loading\.delay], [wire\:loading\.inline-block], [wire\:loading\.inline], [wire\:loading\.block], [wire\:loading\.flex], [wire\:loading\.table], [wire\:loading\.grid], [wire\:loading\.inline-flex] {display: none;}
        [wire\:loading\.delay\.shortest], [wire\:loading\.delay\.shorter], [wire\:loading\.delay\.short], [wire\:loading\.delay\.long], [wire\:loading\.delay\.longer], [wire\:loading\.delay\.longest] {display:none;}
        [wire\:offline] {display: none;}
        [wire\:dirty]:not(textarea):not(input):not(select) {display: none;}
        input:-webkit-autofill, select:-webkit-autofill, textarea:-webkit-autofill {animation-duration: 50000s;animation-name: livewireautofill;}
        @keyframes livewireautofill { from {} }
        
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
