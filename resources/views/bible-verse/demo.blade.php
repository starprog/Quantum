<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bible Verse Widget - Demo & Documentation</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background: #f8f9fa;
        }
        
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 3rem 2rem;
            text-align: center;
        }
        
        .header h1 {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }
        
        .header p {
            font-size: 1.125rem;
            opacity: 0.9;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }
        
        .section {
            background: white;
            border-radius: 1rem;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .section h2 {
            color: #667eea;
            margin-bottom: 1rem;
            font-size: 1.75rem;
        }
        
        .section h3 {
            color: #4a5568;
            margin-top: 1.5rem;
            margin-bottom: 0.75rem;
        }
        
        .demo-widget {
            margin: 2rem 0;
            display: flex;
            justify-content: center;
        }
        
        .demo-widget iframe {
            border-radius: 1rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        
        .code-block {
            background: #2d3748;
            color: #e2e8f0;
            padding: 1.5rem;
            border-radius: 0.5rem;
            overflow-x: auto;
            margin: 1rem 0;
            font-family: 'Courier New', monospace;
            font-size: 0.875rem;
        }
        
        .code-block code {
            display: block;
            white-space: pre;
        }
        
        .feature-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin: 2rem 0;
        }
        
        .feature-card {
            background: #f7fafc;
            padding: 1.5rem;
            border-radius: 0.75rem;
            border-left: 4px solid #667eea;
        }
        
        .feature-card h4 {
            color: #667eea;
            margin-bottom: 0.5rem;
        }
        
        .btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: transform 0.3s;
        }
        
        .btn:hover {
            transform: translateY(-2px);
        }
        
        .footer {
            text-align: center;
            padding: 2rem;
            color: #718096;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>📖 Bible Verse Widget</h1>
        <p>Beautiful, embeddable widget with 100 curated verses</p>
    </div>
    
    <div class="container">
        <!-- Live Demo Section -->
        <div class="section">
            <h2>🎯 Live Demo</h2>
            <p>Interact with the widget below - try filtering by category and copying verses!</p>
            
            <div class="demo-widget">
                <iframe 
                    src="{{ url('/bible-verse/embed') }}" 
                    width="600" 
                    height="550" 
                    frameborder="0">
                </iframe>
            </div>
        </div>
        
        <!-- Features Section -->
        <div class="section">
            <h2>✨ Features</h2>
            <div class="feature-grid">
                <div class="feature-card">
                    <h4>📚 100 Curated Verses</h4>
                    <p>Hand-picked impactful verses across 10 meaningful categories</p>
                </div>
                <div class="feature-card">
                    <h4>🎨 Category Filtering</h4>
                    <p>Filter by Hope, Faith, Love, Wisdom, and 6 other categories</p>
                </div>
                <div class="feature-card">
                    <h4>📋 One-Click Copy</h4>
                    <p>Copy verses to clipboard with visual feedback</p>
                </div>
                <div class="feature-card">
                    <h4>⚡ Performance Cached</h4>
                    <p>Daily verse cached for lightning-fast load times</p>
                </div>
                <div class="feature-card">
                    <h4>📱 Fully Responsive</h4>
                    <p>Works beautifully on desktop, tablet, and mobile</p>
                </div>
                <div class="feature-card">
                    <h4>🔌 Easy to Embed</h4>
                    <p>Drop into any website with a simple iframe</p>
                </div>
            </div>
        </div>
        
        <!-- Embed Code Section -->
        <div class="section">
            <h2>🔌 Embed in Your Website</h2>
            
            <h3>Basic Embed</h3>
            <p>Copy and paste this code into your website:</p>
            <div class="code-block">
                <code>&lt;iframe 
  src="{{ url('/bible-verse/embed') }}" 
  width="600" 
  height="550" 
  frameborder="0"
  style="border-radius: 1rem; box-shadow: 0 10px 25px rgba(0,0,0,0.1);"&gt;
&lt;/iframe&gt;</code>
            </div>
            
            <h3>Responsive Embed</h3>
            <p>For responsive design that adapts to screen size:</p>
            <div class="code-block">
                <code>&lt;div style="position: relative; padding-bottom: 83.33%; height: 0; overflow: hidden; max-width: 600px;"&gt;
  &lt;iframe 
    src="{{ url('/bible-verse/embed') }}" 
    style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: 0; border-radius: 1rem;"&gt;
  &lt;/iframe&gt;
&lt;/div&gt;</code>
            </div>
            
            <h3>WordPress Integration</h3>
            <p>Add to WordPress using the HTML widget:</p>
            <div class="code-block">
                <code>&lt;!-- In HTML Widget --&gt;
&lt;iframe 
  src="{{ url('/bible-verse/embed') }}" 
  width="100%" 
  height="550" 
  frameborder="0"&gt;
&lt;/iframe&gt;</code>
            </div>
        </div>
        
        <!-- Categories Section -->
        <div class="section">
            <h2>📂 Verse Categories</h2>
            <p>Our 100 verses are organized into 10 meaningful categories:</p>
            <ul style="margin-left: 2rem; margin-top: 1rem; line-height: 2;">
                <li><strong>Gospel & Salvation</strong> - Core salvation messages</li>
                <li><strong>Faith & Trust</strong> - Building faith and trust in God</li>
                <li><strong>Love & Compassion</strong> - God's love and caring for others</li>
                <li><strong>Hope & Encouragement</strong> - Messages of hope</li>
                <li><strong>Strength & Courage</strong> - Finding strength in difficult times</li>
                <li><strong>Wisdom & Guidance</strong> - Seeking God's wisdom</li>
                <li><strong>Love & Relationships</strong> - Biblical love and relationships</li>
                <li><strong>Prayer & Worship</strong> - Prayer and worship guidance</li>
                <li><strong>Peace & Comfort</strong> - Finding peace and comfort</li>
                <li><strong>Grace & Forgiveness</strong> - God's grace and forgiveness</li>
            </ul>
        </div>
        
        <!-- Technical Details -->
        <div class="section">
            <h2>⚙️ Technical Details</h2>
            <h3>Built With</h3>
            <ul style="margin-left: 2rem; margin-top: 1rem; line-height: 2;">
                <li><strong>Laravel 11.x</strong> - Modern PHP framework</li>
                <li><strong>Livewire 3.x</strong> - Real-time interactions</li>
                <li><strong>MySQL 8.0+</strong> - Robust database</li>
                <li><strong>PHP 8.2+</strong> - Latest PHP features</li>
            </ul>
            
            <h3>Performance</h3>
            <p>The widget is optimized for speed:</p>
            <ul style="margin-left: 2rem; margin-top: 1rem; line-height: 2;">
                <li>Daily verse cached until midnight</li>
                <li>Efficient database queries with eager loading</li>
                <li>Sub-second page load times</li>
                <li>Minimal JavaScript footprint</li>
            </ul>
        </div>
        
        <!-- GitHub & Documentation -->
        <div class="section" style="text-align: center;">
            <h2>📚 Documentation & Source</h2>
            <p style="margin-bottom: 1.5rem;">Full documentation and source code available on GitHub</p>
            <a href="https://github.com/starprog/Quantum" class="btn" target="_blank">View on GitHub</a>
        </div>
    </div>
    
    <div class="footer">
        <p>Made with ❤️ using Laravel & Livewire</p>
        <p style="margin-top: 0.5rem;">© 2025 Quantum Bible Verse Widget</p>
    </div>
</body>
</html>
