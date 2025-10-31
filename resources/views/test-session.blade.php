<!DOCTYPE html>
<html>
<head>
    <title>Session Test</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body style="padding: 40px; font-family: Arial;">
    <h1>Session & CSRF Test</h1>
    
    <div style="background: #f0f0f0; padding: 20px; margin: 20px 0; border-radius: 8px;">
        <h3>Session Info:</h3>
        <p><strong>Session Lifetime:</strong> {{ config('session.lifetime') }} minutes</p>
        <p><strong>Current CSRF Token:</strong> <code>{{ csrf_token() }}</code></p>
        <p><strong>Session ID:</strong> <code>{{ session()->getId() }}</code></p>
        <p><strong>Current Time:</strong> {{ now() }}</p>
    </div>

    <div style="background: #e3f2fd; padding: 20px; margin: 20px 0; border-radius: 8px;">
        <h3>Test Form:</h3>
        <form method="POST" action="/test-session">
            @csrf
            <input type="text" name="test_value" placeholder="Type something..." style="padding: 10px; width: 300px; margin-right: 10px;">
            <button type="submit" style="padding: 10px 20px; background: #2196F3; color: white; border: none; border-radius: 4px; cursor: pointer;">
                Submit Test
            </button>
        </form>
        
        @if(session('success'))
            <div style="background: #4CAF50; color: white; padding: 15px; margin-top: 15px; border-radius: 4px;">
                {{ session('success') }}
            </div>
        @endif
    </div>

    <div style="background: #fff3e0; padding: 20px; margin: 20px 0; border-radius: 8px;">
        <h3>Browser Instructions:</h3>
        <ol>
            <li>Open your browser's Developer Tools (F12)</li>
            <li>Go to Application tab → Cookies</li>
            <li>Delete all cookies for 127.0.0.1:8000</li>
            <li>Refresh this page (F5)</li>
            <li>Try the form submission</li>
        </ol>
    </div>

    <div style="margin-top: 20px;">
        <a href="/" style="padding: 10px 20px; background: #9C27B0; color: white; text-decoration: none; border-radius: 4px; display: inline-block;">
            Back to Home
        </a>
    </div>
</body>
</html>
