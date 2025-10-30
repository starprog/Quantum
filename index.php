<?php
require_once 'config/database.php';

// Get recipe counts by country
try {
    $pdo = getDBConnection();
    $stmt = $pdo->query('SELECT country, COUNT(*) as recipe_count FROM recipes GROUP BY country');
    $countries = $stmt->fetchAll();
} catch (Exception $e) {
    $countries = [];
    $error = 'Database connection failed. Please check your configuration.';
}

$pageTitle = 'World Recipes - Discover Global Flavors';
$currentPage = 'home';
include 'includes/header.php';
?>

<main class="container">
    <section class="hero">
        <h1>🌍 World Recipes</h1>
    </section>
    
    <section class="hero-description">
        <div class="container">
            <p>Discover authentic recipes from around the globe. From Japanese comfort food to Italian classics, explore the world through flavors.</p>
        </div>
    </section>

    <?php if (isset($error)): ?>
        <div class="error-message">
            <p><?php echo htmlspecialchars($error); ?></p>
            <p>Make sure to:</p>
            <ol>
                <li>Import database.sql into phpMyAdmin</li>
                <li>Import recipes.sql to add sample data</li>
                <li>Update config/database.php with your settings</li>
            </ol>
        </div>
    <?php endif; ?>

    <section class="countries-grid">
        <h2>Explore by Country</h2>
        <div class="country-cards">
            <?php
            $countryData = [
                'Japan' => ['flag' => '🇯🇵', 'color' => '#ff6b6b', 'description' => 'Traditional Japanese cuisine with fresh ingredients'],
                'India' => ['flag' => '🇮🇳', 'color' => '#ffd43b', 'description' => 'Aromatic spices and rich curries from India'],
                'Mexico' => ['flag' => '🇲🇽', 'color' => '#51cf66', 'description' => 'Bold flavors and vibrant Mexican dishes'],
                'America' => ['flag' => '🇺🇸', 'color' => '#74c0fc', 'description' => 'Classic American comfort foods and favorites'],
                'Italy' => ['flag' => '🇮🇹', 'color' => '#cc5de8', 'description' => 'Authentic Italian pasta and traditional recipes']
            ];
            
            foreach ($countryData as $countryName => $data):
                $recipeCount = 0;
                foreach ($countries as $country) {
                    if ($country['country'] === $countryName) {
                        $recipeCount = $country['recipe_count'];
                        break;
                    }
                }
            ?>
            <div class="country-card" data-country="<?php echo strtolower(sanitizeOutput($countryName)); ?>" style="--accent-color: <?php echo sanitizeOutput($data['color']); ?>">
                <div class="country-flag"><?php echo $data['flag']; ?></div>
                <h3><?php echo sanitizeOutput($countryName); ?></h3>
                <p><?php echo sanitizeOutput($data['description']); ?></p>
                <div class="recipe-count"><?php echo (int)$recipeCount; ?> Recipes</div>
                <a href="country.php?country=<?php echo urlencode($countryName); ?>" class="btn-explore">Explore Recipes</a>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="featured-section">
        <h2>Why World Recipes?</h2>
        <div class="features">
            <div class="feature">
                <div class="feature-icon">👨‍🍳</div>
                <h3>Authentic Recipes</h3>
                <p>Hand-picked traditional recipes from native cooks around the world</p>
            </div>
            <div class="feature">
                <div class="feature-icon">🌶️</div>
                <h3>Step by Step</h3>
                <p>Detailed instructions with ingredients and cooking methods</p>
            </div>
            <div class="feature">
                <div class="feature-icon">📱</div>
                <h3>Mobile Friendly</h3>
                <p>Cook anywhere with our responsive design and easy navigation</p>
            </div>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>