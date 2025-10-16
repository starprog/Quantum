<div style="min-height: 100vh; display: flex; flex-direction: column; justify-content: center; align-items: center; 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 2rem;">
    
    <!-- Logo -->
    <div style="width: 80px; height: 80px; margin-bottom: 2rem; display: flex; justify-content: center; align-items: center;">
        {{ $logo }}
    </div>

    <!-- Card Container -->
    <div style="width: 100%; max-width: 420px; background: white; border-radius: 1rem; 
                box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); 
                padding: 2.5rem;">
        {{ $slot }}
    </div>
</div>
