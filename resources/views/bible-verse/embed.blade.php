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
        
        /* Minimal styling */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 1rem;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .widget-container {
            width: 100%;
            max-width: 600px;
        }
    </style>
</head>
<body>
    <div class="widget-container">
        @livewire('bible-verse-embed')
    </div>
    
    <!-- Livewire Scripts -->
    <script src="{{ url('livewire/livewire.js') }}" data-csrf="{{ csrf_token() }}" data-update-uri="{{ url('livewire/update') }}" defer></script>
</body>
</html>
