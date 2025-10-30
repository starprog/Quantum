<?php
require_once 'config/database.php';

echo "<h1>🖼️ Updating Recipe Images</h1>\n";

try {
    $pdo = getDBConnection();
    echo "<p>✅ Database connection successful!</p>\n";
    
    // Update Tonkatsu (Pork Cutlet) with authentic tonkatsu image
    $stmt = $pdo->prepare("UPDATE recipes SET image = ? WHERE name LIKE '%Tonkatsu%' OR name LIKE '%Pork Cutlet%'");
    $stmt->execute(['https://images.unsplash.com/photo-1546833999-b9f581a1996d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80']);
    echo "<p>✅ Updated Tonkatsu image</p>\n";
    
    // Update Birria Tacos with authentic birria tacos image
    $stmt = $pdo->prepare("UPDATE recipes SET image = ? WHERE name LIKE '%Birria%'");
    $stmt->execute(['https://images.unsplash.com/photo-1640982019252-e5e5b2fcc2d1?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80']);
    echo "<p>✅ Updated Birria Tacos image</p>\n";
    
    // Update Chili Hot Dogs with delicious chili dog image
    $stmt = $pdo->prepare("UPDATE recipes SET image = ? WHERE name LIKE '%Chili Hot Dog%'");
    $stmt->execute(['https://images.unsplash.com/photo-1612392061787-2d078b3e00e0?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80']);
    echo "<p>✅ Updated Chili Hot Dogs image</p>\n";
    
    // Update Chicken Alfredo with creamy pasta image
    $stmt = $pdo->prepare("UPDATE recipes SET image = ? WHERE name LIKE '%Chicken Alfredo%'");
    $stmt->execute(['https://images.unsplash.com/photo-1621996346565-e3dbc353d2e5?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80']);
    echo "<p>✅ Updated Chicken Alfredo image</p>\n";
    
    // Show updated recipes
    $stmt = $pdo->query("SELECT id, name, image FROM recipes 
                        WHERE name LIKE '%Tonkatsu%' 
                           OR name LIKE '%Birria%' 
                           OR name LIKE '%Chili Hot Dog%' 
                           OR name LIKE '%Chicken Alfredo%'");
    $updatedRecipes = $stmt->fetchAll();
    
    echo "<h2>📸 Updated Recipe Images:</h2>\n";
    echo "<div style='display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; margin: 20px 0;'>\n";
    
    foreach ($updatedRecipes as $recipe) {
        echo "<div style='background: rgba(22, 27, 34, 0.8); padding: 15px; border-radius: 10px; border: 1px solid #30363d;'>\n";
        echo "<h3 style='color: #ff6b6b; margin-bottom: 10px;'>{$recipe['name']}</h3>\n";
        echo "<img src='{$recipe['image']}' alt='{$recipe['name']}' style='width: 100%; height: 200px; object-fit: cover; border-radius: 8px; margin-bottom: 10px;'>\n";
        echo "<p style='color: #e9ecef; font-size: 14px;'>Recipe ID: {$recipe['id']}</p>\n";
        echo "</div>\n";
    }
    echo "</div>\n";
    
    echo "<p><strong>🎉 All recipe images updated successfully!</strong></p>\n";
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
h1, h2 { color: #ff6b6b; }
p { margin: 10px 0; }
a { color: #74c0fc; text-decoration: none; }
a:hover { color: #51cf66; }
</style>