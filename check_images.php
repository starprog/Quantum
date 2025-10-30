<?php
require_once 'config/database.php';

echo "<h1>📸 Checking Recipe Images</h1>\n";

try {
    $pdo = getDBConnection();
    echo "<p>✅ Database connection successful!</p>\n";
    
    // Get all recipes to check for missing images
    $stmt = $pdo->query("SELECT id, name, country, image FROM recipes ORDER BY country, name");
    $recipes = $stmt->fetchAll();
    
    echo "<h2>🌍 All Recipes by Country:</h2>\n";
    
    $currentCountry = '';
    foreach ($recipes as $recipe) {
        if ($currentCountry !== $recipe['country']) {
            if ($currentCountry !== '') echo "</div>\n";
            $currentCountry = $recipe['country'];
            echo "<h3>🏴󠁧󠁢󠁥󠁮󠁧󠁿 {$currentCountry}</h3>\n";
            echo "<div style='display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 15px; margin: 15px 0;'>\n";
        }
        
        $hasImage = !empty($recipe['image']) && $recipe['image'] !== 'placeholder.jpg';
        $statusIcon = $hasImage ? "✅" : "❌";
        $statusColor = $hasImage ? "#51cf66" : "#ff6b6b";
        
        echo "<div style='background: rgba(22, 27, 34, 0.8); padding: 12px; border-radius: 8px; border: 1px solid #30363d;'>\n";
        echo "<h4 style='color: {$statusColor}; margin: 0 0 8px 0; font-size: 14px;'>{$statusIcon} {$recipe['name']}</h4>\n";
        
        if ($hasImage) {
            echo "<img src='{$recipe['image']}' alt='{$recipe['name']}' style='width: 100%; height: 120px; object-fit: cover; border-radius: 6px; margin-bottom: 8px;'>\n";
            echo "<p style='color: #74c0fc; font-size: 12px; margin: 0;'>Image: ✅ Available</p>\n";
        } else {
            echo "<div style='width: 100%; height: 120px; background: #30363d; border-radius: 6px; margin-bottom: 8px; display: flex; align-items: center; justify-content: center;'>\n";
            echo "<span style='color: #ff6b6b; font-size: 24px;'>📷</span>\n";
            echo "</div>\n";
            echo "<p style='color: #ff6b6b; font-size: 12px; margin: 0;'>Image: ❌ Missing</p>\n";
        }
        
        echo "<p style='color: #e9ecef; font-size: 11px; margin: 4px 0 0 0;'>ID: {$recipe['id']}</p>\n";
        echo "</div>\n";
    }
    echo "</div>\n";
    
    // Count missing images
    $missingImages = 0;
    foreach ($recipes as $recipe) {
        if (empty($recipe['image']) || $recipe['image'] === 'placeholder.jpg') {
            $missingImages++;
        }
    }
    
    echo "<h2>📊 Summary:</h2>\n";
    echo "<p><strong>Total Recipes:</strong> " . count($recipes) . "</p>\n";
    echo "<p><strong>Missing Images:</strong> {$missingImages}</p>\n";
    echo "<p><strong>With Images:</strong> " . (count($recipes) - $missingImages) . "</p>\n";
    
    if ($missingImages > 0) {
        echo "<p style='color: #ffd43b;'>⚠️ Some recipes need images! I can help add them.</p>\n";
    } else {
        echo "<p style='color: #51cf66;'>🎉 All recipes have images!</p>\n";
    }
    
    echo "<p><a href='about.php' style='color: #74c0fc;'>← Back to About Page</a></p>\n";
    
} catch (Exception $e) {
    echo "<p>❌ Error: " . htmlspecialchars($e->getMessage()) . "</p>\n";
}
?>

<style>
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(135deg, #0d1117 0%, #1a1a1a 100%);
    color: #e9ecef;
    padding: 20px;
    margin: 0;
    min-height: 100vh;
}
h1, h2, h3 { color: #ff6b6b; }
p { margin: 8px 0; }
a { color: #74c0fc; text-decoration: none; }
a:hover { color: #51cf66; }
</style>