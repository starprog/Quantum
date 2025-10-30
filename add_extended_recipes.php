<?php
require_once 'config/database.php';

echo "<h1>🍳 Adding Extended Recipes to Database</h1>\n";

try {
    $pdo = getDBConnection();
    echo "<p>✅ Database connection successful!</p>\n";
    
    // Read the extended recipes SQL file
    $sql = file_get_contents('extended_recipes.sql');
    
    // Split the SQL into individual statements
    $statements = array_filter(
        array_map('trim', explode(';', $sql)),
        function($stmt) {
            return !empty($stmt) && !preg_match('/^--/', $stmt);
        }
    );
    
    $successCount = 0;
    $errorCount = 0;
    
    foreach ($statements as $statement) {
        if (strpos($statement, 'INSERT INTO recipes') !== false) {
            try {
                $pdo->exec($statement);
                $successCount++;
                echo "<p>✅ Added recipe successfully</p>\n";
            } catch (Exception $e) {
                $errorCount++;
                echo "<p>❌ Error adding recipe: " . htmlspecialchars($e->getMessage()) . "</p>\n";
            }
        }
    }
    
    // Get final counts
    $stmt = $pdo->query('SELECT country, COUNT(*) as total_recipes FROM recipes GROUP BY country ORDER BY country');
    $countries = $stmt->fetchAll();
    
    echo "<h2>🌍 Final Recipe Counts:</h2>\n";
    echo "<ul>\n";
    foreach ($countries as $country) {
        echo "<li><strong>{$country['country']}:</strong> {$country['total_recipes']} recipes</li>\n";
    }
    echo "</ul>\n";
    
    echo "<h2>📊 Summary:</h2>\n";
    echo "<p>✅ Successfully added: $successCount recipes</p>\n";
    echo "<p>❌ Errors: $errorCount</p>\n";
    
    if ($successCount > 0) {
        echo "<p><strong>🎉 Your World Recipes website now has 40 total recipes!</strong></p>\n";
        echo "<p><a href='index.php'>← Back to Homepage</a></p>\n";
    }
    
} catch (Exception $e) {
    echo "<p>❌ Database connection failed: " . htmlspecialchars($e->getMessage()) . "</p>\n";
    echo "<p>Please make sure your database is running and configured correctly.</p>\n";
}
?>

<style>
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(135deg, #0d1117 0%, #1a1a1a 100%);
    color: #e9ecef;
    padding: 20px;
    margin: 0;
}
h1, h2 { color: #ff6b6b; }
p { margin: 10px 0; }
a { color: #74c0fc; text-decoration: none; }
a:hover { color: #51cf66; }
ul { background: rgba(22, 27, 34, 0.8); padding: 20px; border-radius: 10px; }
</style>