<?php
require_once 'config/database.php';

// Get and validate recipe ID from URL parameter
$recipeId = $_GET['id'] ?? 0;
$recipeId = validateRecipeId($recipeId);

if (!$recipeId) {
    header('Location: index.php');
    exit();
}

// Get recipe details using prepared statements
try {
    $pdo = getDBConnection();
    $stmt = $pdo->prepare('SELECT * FROM recipes WHERE id = ?');
    $stmt->execute([$recipeId]);
    $recipe = $stmt->fetch();
} catch (Exception $e) {
    $recipe = null;
    $error = 'Unable to load recipe. Please try again later.';
    error_log('Recipe page error: ' . $e->getMessage());
}

if (!$recipe) {
    header('Location: index.php');
    exit();
}

$pageTitle = $recipe['name'] . ' - ' . $recipe['country'] . ' Recipe';
$currentPage = '';
include 'includes/header.php';
?>

<main class="container">
    <article class="recipe-detail">
        <header class="recipe-header">
            <div class="recipe-breadcrumb">
                <a href="index.php">Home</a>
                <span>→</span>
                <a href="country.php?country=<?php echo urlencode($recipe['country']); ?>"><?php echo sanitizeOutput($recipe['country']); ?></a>
                <span>→</span>
                <span><?php echo sanitizeOutput($recipe['name']); ?></span>
            </div>
            
            <?php
            $countryData = [
                'Japan' => ['flag' => '🇯🇵', 'color' => '#e74c3c'],
                'India' => ['flag' => '🇮🇳', 'color' => '#f39c12'],
                'Mexico' => ['flag' => '🇲🇽', 'color' => '#27ae60'],
                'America' => ['flag' => '🇺🇸', 'color' => '#3498db'],
                'Italy' => ['flag' => '🇮🇹', 'color' => '#9b59b6']
            ];
            $flag = $countryData[$recipe['country']]['flag'] ?? '🌍';
            $color = $countryData[$recipe['country']]['color'] ?? '#2c3e50';
            ?>
            
            <div class="recipe-title-section">
                <h1><?php echo sanitizeOutput($recipe['name']); ?></h1>
                <div class="recipe-origin">
                    <span class="country-tag" style="background-color: <?php echo sanitizeOutput($color); ?>22; color: <?php echo sanitizeOutput($color); ?>">
                        <?php echo $flag; ?> <?php echo sanitizeOutput($recipe['country']); ?>
                    </span>
                </div>
            </div>
        </header>

        <div class="recipe-content">
            <div class="recipe-image-section">
                <img src="<?php echo htmlspecialchars($recipe['image']); ?>" 
                     alt="<?php echo htmlspecialchars($recipe['name']); ?>" 
                     class="recipe-main-image">
            </div>

            <div class="recipe-details">
                <section class="ingredients-section">
                    <h2>🥘 Ingredients</h2>
                    <ul class="ingredients-list">
                        <?php
                        $ingredients = explode("\n", $recipe['ingredients']);
                        foreach ($ingredients as $ingredient) {
                            $ingredient = trim($ingredient);
                            if (!empty($ingredient)) {
                                echo '<li>' . htmlspecialchars($ingredient) . '</li>';
                            }
                        }
                        ?>
                    </ul>
                </section>

                <section class="instructions-section">
                    <h2>👨‍🍳 Instructions</h2>
                    <ol class="instructions-list">
                        <?php
                        $steps = explode("\n", $recipe['steps']);
                        foreach ($steps as $step) {
                            $step = trim($step);
                            if (!empty($step)) {
                                // Remove numbers at the beginning if they exist
                                $step = preg_replace('/^\d+\.\s*/', '', $step);
                                echo '<li>' . htmlspecialchars($step) . '</li>';
                            }
                        }
                        ?>
                    </ol>
                </section>

                <?php if (!empty($recipe['source_link'])): ?>
                <section class="source-section">
                    <h3>📖 Recipe Source</h3>
                    <a href="<?php echo htmlspecialchars($recipe['source_link']); ?>" 
                       target="_blank" 
                       rel="noopener noreferrer" 
                       class="source-link">View Original Recipe</a>
                </section>
                <?php endif; ?>
            </div>
        </div>

        <div class="recipe-actions">
            <a href="country.php?country=<?php echo urlencode($recipe['country']); ?>" 
               class="btn-secondary">← More <?php echo htmlspecialchars($recipe['country']); ?> Recipes</a>
            <button onclick="window.print()" class="btn-primary">🖨️ Print Recipe</button>
        </div>
    </article>
</main>

<?php include 'includes/footer.php'; ?>