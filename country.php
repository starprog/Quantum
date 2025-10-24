<?php
require_once 'config/database.php';

// Get and validate country from URL parameter
$country = $_GET['country'] ?? '';
$country = validateCountry($country);

if (!$country) {
    header('Location: index.php');
    exit();
}

// Get recipes for this country using prepared statements
try {
    $pdo = getDBConnection();
    $stmt = $pdo->prepare('SELECT * FROM recipes WHERE country = ? ORDER BY name');
    $stmt->execute([$country]);
    $recipes = $stmt->fetchAll();
} catch (Exception $e) {
    $recipes = [];
    $error = 'Unable to load recipes. Please try again later.';
    error_log('Country page error: ' . $e->getMessage());
}

$pageTitle = $country . ' Recipes - World Recipes';
$currentPage = strtolower($country);
include 'includes/header.php';
?>

<main class="container">
    <section class="country-header">
        <?php
        $countryData = [
            'Japan' => ['flag' => '🇯🇵', 'color' => '#e74c3c'],
            'India' => ['flag' => '🇮🇳', 'color' => '#f39c12'],
            'Mexico' => ['flag' => '🇲🇽', 'color' => '#27ae60'],
            'America' => ['flag' => '🇺🇸', 'color' => '#3498db'],
            'Italy' => ['flag' => '🇮🇹', 'color' => '#9b59b6']
        ];
        $flag = $countryData[$country]['flag'] ?? '🌍';
        $color = $countryData[$country]['color'] ?? '#2c3e50';
        ?>
        <div class="country-banner" style="background: linear-gradient(135deg, <?php echo sanitizeOutput($color); ?>, <?php echo sanitizeOutput($color); ?>88);">
            <span class="country-flag-large"><?php echo $flag; ?></span>
            <h1><?php echo sanitizeOutput($country); ?> Recipes</h1>
            <p><?php echo count($recipes); ?> delicious recipes from <?php echo sanitizeOutput($country); ?></p>
        </div>
    </section>

    <?php if (isset($error)): ?>
        <div class="error-message">
            <p><?php echo htmlspecialchars($error); ?></p>
        </div>
    <?php endif; ?>

    <?php if (empty($recipes)): ?>
        <div class="no-recipes">
            <h2>No recipes found</h2>
            <p>We don't have any recipes from <?php echo htmlspecialchars($country); ?> yet.</p>
            <a href="index.php" class="btn-primary">← Back to Countries</a>
        </div>
    <?php else: ?>
        <section class="recipes-grid">
            <?php foreach ($recipes as $recipe): ?>
                <article class="recipe-card">
                    <div class="recipe-image">
                        <img src="<?php echo sanitizeOutput($recipe['image']); ?>" 
                             alt="<?php echo sanitizeOutput($recipe['name']); ?>" 
                             loading="lazy">
                    </div>
                    <div class="recipe-content">
                        <h3><?php echo sanitizeOutput($recipe['name']); ?></h3>
                        <p class="recipe-preview">
                            <?php 
                            $ingredients = explode('\n', $recipe['ingredients']);
                            echo sanitizeOutput(trim($ingredients[0]));
                            if (count($ingredients) > 1) echo '...';
                            ?>
                        </p>
                        <div class="recipe-meta">
                            <span class="country-tag" style="background-color: <?php echo sanitizeOutput($color); ?>22; color: <?php echo sanitizeOutput($color); ?>">
                                <?php echo $flag; ?> <?php echo sanitizeOutput($country); ?>
                            </span>
                        </div>
                        <a href="recipe.php?id=<?php echo (int)$recipe['id']; ?>" class="btn-view-recipe">View Recipe</a>
                    </div>
                </article>
            <?php endforeach; ?>
        </section>
    <?php endif; ?>

    <section class="back-navigation">
        <a href="index.php" class="btn-secondary">← Explore Other Countries</a>
    </section>
</main>

<?php include 'includes/footer.php'; ?>