<?php
require_once 'config/database.php';

echo "<h1>🖼️ Adding Missing Recipe Images</h1>\n";

try {
    $pdo = getDBConnection();
    echo "<p>✅ Database connection successful!</p>\n";
    
    // Array of recipe name patterns and their corresponding images
    $imageUpdates = [
        // Japanese recipes
        'Chicken Teriyaki' => 'https://images.unsplash.com/photo-1546833999-b9f581a1996d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
        'Yakitori' => 'https://images.unsplash.com/photo-1583394838336-acd977736f90?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
        'Japanese' => 'https://images.unsplash.com/photo-1585937421612-70a008356fbe?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
        'Oyakodon' => 'https://images.unsplash.com/photo-1605333396293-49b999616a1f?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
        'Tempura' => 'https://images.unsplash.com/photo-1606491956689-2ea866880c84?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
        
        // Indian recipes
        'Paneer Tikka' => 'https://images.unsplash.com/photo-1599487488170-d11ec9c172f0?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
        'Chole' => 'https://images.unsplash.com/photo-1585937421612-70a008356fbe?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
        'Aloo Gobi' => 'https://images.unsplash.com/photo-1565557623262-b51c2513a641?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
        'Biryani' => 'https://images.unsplash.com/photo-1563379091339-03246963d51a?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
        'Masala Dosa' => 'https://images.unsplash.com/photo-1606491956689-2ea866880c84?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
        
        // Mexican recipes
        'Chiles Rellenos' => 'https://images.unsplash.com/photo-1599487488170-d11ec9c172f0?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
        'Pozole' => 'https://images.unsplash.com/photo-1565299585323-38174c13c7d2?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
        'Carnitas' => 'https://images.unsplash.com/photo-1615870216519-2f9fa2707e93?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
        'Mole' => 'https://images.unsplash.com/photo-1565299507177-b0ac66763828?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
        'Elote' => 'https://images.unsplash.com/photo-1551218808-94e220e084d2?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
        
        // American recipes
        'BBQ Ribs' => 'https://images.unsplash.com/photo-1544025162-d76694265947?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
        'Fried Chicken' => 'https://images.unsplash.com/photo-1569058242253-92a9c755a0ec?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
        'Mac and Cheese' => 'https://images.unsplash.com/photo-1543826173-e1f00b75e6b6?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
        'Apple Pie' => 'https://images.unsplash.com/photo-1621743478914-cc8a86d7e7b5?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
        'Clam Chowder' => 'https://images.unsplash.com/photo-1547592166-23ac45744acd?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
        
        // Italian recipes
        'Risotto' => 'https://images.unsplash.com/photo-1476124369491-e7addf5db371?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
        'Osso Buco' => 'https://images.unsplash.com/photo-1565299507177-b0ac66763828?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
        'Tiramisu' => 'https://images.unsplash.com/photo-1571877227200-a0d98ea607e9?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
        'Pesto' => 'https://images.unsplash.com/photo-1621996346565-e3dbc353d2e5?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
        'Cannoli' => 'https://images.unsplash.com/photo-1606491956689-2ea866880c84?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'
    ];
    
    $updatedCount = 0;
    
    echo "<h2>🔄 Updating Recipe Images:</h2>\n";
    
    foreach ($imageUpdates as $recipeName => $imageUrl) {
        $stmt = $pdo->prepare("UPDATE recipes SET image = ? WHERE name LIKE ? AND (image IS NULL OR image = '' OR image = 'placeholder.jpg')");
        $result = $stmt->execute([$imageUrl, "%{$recipeName}%"]);
        $affectedRows = $stmt->rowCount();
        
        if ($affectedRows > 0) {
            echo "<p>✅ Updated {$affectedRows} recipe(s) matching '{$recipeName}'</p>\n";
            $updatedCount += $affectedRows;
        }
    }
    
    // Get final count of recipes with images
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM recipes");
    $totalRecipes = $stmt->fetch()['total'];
    
    $stmt = $pdo->query("SELECT COUNT(*) as with_images FROM recipes WHERE image IS NOT NULL AND image != '' AND image != 'placeholder.jpg'");
    $recipesWithImages = $stmt->fetch()['with_images'];
    
    echo "<h2>📊 Final Results:</h2>\n";
    echo "<p><strong>Total Recipes:</strong> {$totalRecipes}</p>\n";
    echo "<p><strong>Recipes with Images:</strong> {$recipesWithImages}</p>\n";
    echo "<p><strong>Updated in this run:</strong> {$updatedCount}</p>\n";
    
    if ($recipesWithImages == $totalRecipes) {
        echo "<p style='color: #51cf66;'>🎉 All recipes now have images!</p>\n";
    } else {
        $missing = $totalRecipes - $recipesWithImages;
        echo "<p style='color: #ffd43b;'>⚠️ {$missing} recipe(s) still need images</p>\n";
    }
    
    echo "<p><a href='about.php' style='color: #74c0fc;'>← Back to About Page</a></p>\n";
    echo "<p><a href='check_images.php' style='color: #74c0fc;'>🔍 Check Images Again</a></p>\n";
    
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
p { margin: 8px 0; }
a { color: #74c0fc; text-decoration: none; }
a:hover { color: #51cf66; }
</style>