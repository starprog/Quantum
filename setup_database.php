<?php
/**
 * Database Setup Script for World Recipes
 * Run this file once to create the database and tables
 */

// Database configuration
$host = 'localhost';
$username = 'root';      // Default XAMPP username
$password = '';          // Default XAMPP password (empty)
$database = 'world_recipes';

echo "<h1>🌍 World Recipes - Database Setup</h1>";

try {
    // First, connect without specifying database to create it
    $pdo = new PDO("mysql:host=$host;charset=utf8mb4", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    
    echo "<p>✅ Connected to MySQL server successfully!</p>";
    
    // Create database
    $pdo->exec("CREATE DATABASE IF NOT EXISTS $database CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "<p>✅ Database '$database' created successfully!</p>";
    
    // Now connect to the specific database
    $pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8mb4", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    
    // Create recipes table
    $createTable = "
    CREATE TABLE IF NOT EXISTS recipes (
        id INT(11) NOT NULL AUTO_INCREMENT,
        country VARCHAR(50) NOT NULL,
        name VARCHAR(100) NOT NULL,
        ingredients TEXT NOT NULL,
        steps TEXT NOT NULL,
        image VARCHAR(255) NOT NULL,
        source_link VARCHAR(255) DEFAULT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        INDEX idx_country (country)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $pdo->exec($createTable);
    echo "<p>✅ Table 'recipes' created successfully!</p>";
    
    // Check if recipes already exist
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM recipes");
    $count = $stmt->fetch()['count'];
    
    if ($count == 0) {
        echo "<p>📝 Inserting recipe data...</p>";
        
        // Insert all recipes
        $recipes = [
            // Japan
            ['Japan', 'Chicken Katsu', "Chicken breasts\nFlour\nEggs\nPanko breadcrumbs\nOil for frying\nSalt\nPepper\nTonkatsu sauce\nSteamed rice", "1. Pound chicken to even thickness\n2. Season with salt and pepper\n3. Dredge in flour, dip in beaten egg, then coat with panko\n4. Fry in hot oil (350°F / 175°C) until golden brown, about 3–4 min each side\n5. Drain on paper towels\n6. Serve with tonkatsu sauce and rice", "https://images.unsplash.com/photo-1546833999-b9f581a1996d?w=600&h=400&fit=crop", "https://www.justonecookbook.com/katsu/"],
            
            ['Japan', 'Tonkatsu (Pork Cutlet)', "Pork loin\nFlour\nEgg\nPanko breadcrumbs\nOil for frying\nSalt\nPepper\nShredded cabbage\nTonkatsu sauce", "1. Trim fat and pound pork cutlets thin\n2. Season with salt and pepper\n3. Coat with flour → egg → panko\n4. Fry at 350°F until crisp and golden (2–3 min each side)\n5. Drain and slice\n6. Serve with shredded cabbage and tonkatsu sauce", "https://images.unsplash.com/photo-1565299624946-b28f40a0ca4b?w=600&h=400&fit=crop", "https://www.seriouseats.com/tonkatsu-recipe"],
            
            ['Japan', 'Gyūdon (Beef Bowl)', "Thinly sliced beef\nOnions\nSoy sauce\nMirin\nSugar\nDashi stock\nSteamed rice\nPickled ginger\nGreen onion", "1. Cook onions in dashi + soy sauce + mirin + sugar until soft\n2. Add sliced beef; simmer until tender\n3. Serve over steamed rice\n4. Top with pickled ginger and green onion if desired", "https://images.unsplash.com/photo-1603133872878-684f208fb84b?w=600&h=400&fit=crop", "https://www.justonecookbook.com/gyudon/"],
            
            // India
            ['India', 'Chicken Curry', "Chicken pieces\nOnion\nTomato\nGarlic\nGinger\nCurry powder\nCoconut milk or yogurt\nOil\nCilantro\nSalt and spices", "1. Sauté onions, garlic, ginger until soft\n2. Add spices (curry powder, chili, turmeric)\n3. Add chicken and brown it\n4. Add tomatoes and coconut milk/yogurt\n5. Simmer 20–30 min until chicken is cooked and sauce thickens\n6. Garnish with cilantro", "https://images.unsplash.com/photo-1565557623262-b51c2513a641?w=600&h=400&fit=crop", "https://www.indianhealthyrecipes.com/chicken-curry-recipe/"],
            
            ['India', 'Lamb Curry', "Lamb pieces\nOnion\nTomato\nGarlic\nGinger\nCurry paste or garam masala\nYogurt\nOil\nFresh mint\nBasmati rice", "1. Brown lamb in oil; remove\n2. Sauté onions, garlic, ginger\n3. Stir in spices or curry paste\n4. Add tomatoes and return lamb\n5. Simmer 45 min–1 hr until tender\n6. Finish with yogurt and garnish", "https://images.unsplash.com/photo-1588166524941-3bf61a9c41db?w=600&h=400&fit=crop", "https://www.recipetineats.com/lamb-curry/"],
            
            ['India', 'Masala Tikki Curry', "Boiled potatoes\nPeas\nGaram masala\nChili powder\nFlour\nOil\nCurry sauce ingredients\nTomato\nOnion\nSpices", "1. Mash potatoes + peas + spices into patties\n2. Coat lightly in flour\n3. Shallow fry until golden\n4. Prepare a curry sauce (tomato + onion + spices)\n5. Add tikkis to sauce and simmer briefly", "https://images.unsplash.com/photo-1567188040759-fb8a883dc6d8?w=600&h=400&fit=crop", "https://www.vegrecipesofindia.com/aloo-tikki-curry/"],
            
            // America
            ['America', 'Classic Burger', "Ground beef\nSalt\nPepper\nBurger buns\nCheese\nToppings (lettuce, tomato, onion)\nCondiments", "1. Shape beef into patties; season with salt and pepper\n2. Grill or pan-sear 3–4 min per side\n3. Add cheese on top to melt\n4. Toast buns and assemble with toppings", "https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=600&h=400&fit=crop", "https://www.allrecipes.com/recipe/49404/juiciest-hamburgers-ever/"],
            
            ['America', 'Fries', "Russet potatoes\nOil for frying\nSalt", "1. Cut potatoes into sticks; soak in water 30 min\n2. Dry well\n3. Fry at 325°F until tender; remove\n4. Fry again at 375°F until crisp and golden\n5. Salt immediately", "https://images.unsplash.com/photo-1573080496219-bb080dd4f877?w=600&h=400&fit=crop", "https://www.seriouseats.com/the-best-roasted-potatoes-ever-recipe"],
            
            ['America', 'Chili Hot Dogs', "Hot dogs\nHot dog buns\nChili\nCheese\nOnion\nMustard", "1. Grill or boil hot dogs\n2. Warm chili\n3. Place hot dogs in buns, top with chili, cheese, and onion", "https://images.unsplash.com/photo-1612392166886-ee7c818526ee?w=600&h=400&fit=crop", "https://www.allrecipes.com/recipe/16354/chili-dog/"],
            
            // Mexico
            ['Mexico', 'Birria Tacos', "Beef chuck\nChili peppers\nGarlic\nOnion\nBroth\nCorn tortillas\nCheese\nSpices", "1. Blend soaked dried chiles with garlic, onion, spices → make sauce\n2. Marinate beef in sauce; simmer 3 hr until tender\n3. Shred beef; dip tortillas in broth and fry slightly\n4. Fill with beef + cheese, fold, and crisp both sides\n5. Serve with broth for dipping", "https://images.unsplash.com/photo-1565299624946-b28f40a0ca4b?w=600&h=400&fit=crop", "https://www.mexicoinmykitchen.com/birria-recipe/"],
            
            ['Mexico', 'Quesadillas', "Tortillas\nCheese\nFillings (optional)\nButter or oil\nSalsa\nGuacamole", "1. Heat tortilla on skillet; add cheese and filling\n2. Fold and cook both sides until cheese melts\n3. Slice and serve with salsa or guacamole", "https://images.unsplash.com/photo-1618040996337-56904b7850b9?w=600&h=400&fit=crop", "https://www.allrecipes.com/recipe/96547/quesadillas/"],
            
            ['Mexico', 'Cheesy Homemade Tacos', "Taco shells\nGround beef\nTaco seasoning\nCheese\nLettuce\nTomato\nSour cream", "1. Brown beef with taco seasoning\n2. Fill shells with beef and cheese\n3. Add toppings and serve hot", "https://images.unsplash.com/photo-1565299507177-b0ac66763828?w=600&h=400&fit=crop", "https://www.tacobell.com/food/tacos"],
            
            // Italy
            ['Italy', 'Spaghetti', "Pasta\nTomato sauce\nGarlic\nBasil\nOlive oil\nParmesan cheese", "1. Boil spaghetti until al dente\n2. Sauté garlic in olive oil, add tomato sauce, simmer\n3. Toss pasta in sauce, top with basil and cheese", "https://images.unsplash.com/photo-1551892374-ecf8754cf8b0?w=600&h=400&fit=crop", "https://www.bonappetit.com/recipe/cacio-e-pepe"],
            
            ['Italy', 'Chicken Alfredo', "Chicken breast\nFettuccine\nCream\nButter\nParmesan\nGarlic\nSalt and pepper", "1. Cook fettuccine\n2. Cook chicken and slice\n3. In pan, melt butter, add garlic, cream, parmesan → simmer to thicken\n4. Combine with pasta and chicken", "https://images.unsplash.com/photo-1621996346565-e3dbc92d2e36?w=600&h=400&fit=crop", "https://www.allrecipes.com/recipe/22831/chicken-alfredo/"],
            
            ['Italy', 'Lasagna', "Lasagna noodles\nGround beef\nTomato sauce\nRicotta\nMozzarella\nParmesan\nEgg", "1. Cook noodles; brown beef with sauce\n2. Layer sauce, noodles, and cheeses in pan\n3. Repeat layers; top with cheese\n4. Bake at 375°F for 40 min\n5. Rest 10 min before slicing", "https://images.unsplash.com/photo-1574894709920-11b28e7367e3?w=600&h=400&fit=crop", "https://www.allrecipes.com/recipe/23600/worlds-best-lasagna/"]
        ];
        
        $stmt = $pdo->prepare("INSERT INTO recipes (country, name, ingredients, steps, image, source_link) VALUES (?, ?, ?, ?, ?, ?)");
        
        foreach ($recipes as $recipe) {
            $stmt->execute($recipe);
        }
        
        echo "<p>✅ All 15 recipes inserted successfully!</p>";
    } else {
        echo "<p>ℹ️ Database already has $count recipes.</p>";
    }
    
    // Show success message
    echo "<div style='background: #d4edda; color: #155724; padding: 20px; border-radius: 5px; margin: 20px 0;'>";
    echo "<h3>🎉 Setup Complete!</h3>";
    echo "<p><strong>Database:</strong> $database</p>";
    echo "<p><strong>Table:</strong> recipes</p>";
    echo "<p><strong>Recipes:</strong> 15 total (3 per country)</p>";
    echo "<p><strong>Countries:</strong> Japan 🇯🇵, India 🇮🇳, America 🇺🇸, Mexico 🇲🇽, Italy 🇮🇹</p>";
    echo "</div>";
    
    echo "<p><a href='index.php' style='background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>🌍 Visit World Recipes Website</a></p>";
    
} catch (PDOException $e) {
    echo "<div style='background: #f8d7da; color: #721c24; padding: 20px; border-radius: 5px; margin: 20px 0;'>";
    echo "<h3>❌ Database Setup Error</h3>";
    echo "<p><strong>Error:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p><strong>Common Solutions:</strong></p>";
    echo "<ul>";
    echo "<li>Make sure XAMPP/WAMP is running</li>";
    echo "<li>Check if MySQL service is started</li>";
    echo "<li>Verify username/password in this file</li>";
    echo "<li>Try using 'root' with empty password for XAMPP</li>";
    echo "</ul>";
    echo "</div>";
}
?>

<style>
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    max-width: 800px;
    margin: 40px auto;
    padding: 20px;
    background: #f8f9fa;
}
h1 {
    color: #2c3e50;
    text-align: center;
    margin-bottom: 30px;
}
p {
    margin: 10px 0;
    font-size: 16px;
}
</style>