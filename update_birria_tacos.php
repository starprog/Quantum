<?php
require_once 'config/database.php';

echo "<h1>🌮 Updating Birria Tacos Image</h1>\n";

try {
    $pdo = getDBConnection();
    echo "<p>✅ Database connection successful!</p>\n";
    
    // Show current image first
    $stmt = $pdo->prepare("SELECT id, name, image FROM recipes WHERE name LIKE '%Birria%'");
    $stmt->execute();
    $recipe = $stmt->fetch();
    
    if ($recipe) {
        echo "<h2>📸 Current Image:</h2>\n";
        echo "<div style='background: rgba(22, 27, 34, 0.8); padding: 20px; border-radius: 10px; border: 1px solid #30363d; margin: 20px 0;'>\n";
        echo "<h3 style='color: #ff6b6b; margin-bottom: 15px;'>{$recipe['name']}</h3>\n";
        echo "<img src='{$recipe['image']}' alt='{$recipe['name']}' style='width: 100%; max-width: 400px; height: 250px; object-fit: cover; border-radius: 8px; margin-bottom: 15px;'>\n";
        echo "<p style='color: #e9ecef; font-size: 14px;'>Old Image URL: {$recipe['image']}</p>\n";
        echo "</div>\n";
        
        // Update with a proper taco image instead of cheeseburger
        $newImageUrl = 'https://images.unsplash.com/photo-1551504734-5ee1c4a1479b?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80';
        
        $updateStmt = $pdo->prepare("UPDATE recipes SET image = ? WHERE id = ?");
        $updateStmt->execute([$newImageUrl, $recipe['id']]);
        
        echo "<h2>🆕 New Image:</h2>\n";
        echo "<div style='background: rgba(22, 27, 34, 0.8); padding: 20px; border-radius: 10px; border: 1px solid #30363d; margin: 20px 0;'>\n";
        echo "<h3 style='color: #51cf66; margin-bottom: 15px;'>{$recipe['name']} - Updated!</h3>\n";
        echo "<img src='{$newImageUrl}' alt='{$recipe['name']}' style='width: 100%; max-width: 400px; height: 250px; object-fit: cover; border-radius: 8px; margin-bottom: 15px;'>\n";
        echo "<p style='color: #e9ecef; font-size: 14px;'>New Image: Proper tacos instead of cheeseburger</p>\n";
        echo "<p style='color: #e9ecef; font-size: 14px;'>URL: {$newImageUrl}</p>\n";
        echo "</div>\n";
        
        echo "<p style='color: #51cf66;'>✅ Successfully updated Birria Tacos image with proper tacos instead of cheeseburger!</p>\n";
        
    } else {
        echo "<p style='color: #ff6b6b;'>❌ Birria Tacos recipe not found!</p>\n";
    }
    
    echo "<p><a href='country.php?country=Mexico' style='color: #74c0fc;'>🇲🇽 View Mexican Recipes</a></p>\n";
    echo "<p><a href='index.php' style='color: #74c0fc;'>← Back to Homepage</a></p>\n";
    
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
p { margin: 10px 0; }
a { color: #74c0fc; text-decoration: none; }
a:hover { color: #51cf66; }
</style>