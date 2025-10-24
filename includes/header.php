<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? htmlspecialchars($pageTitle) : 'World Recipes - Discover Global Flavors'; ?></title>
    <meta name="description" content="Discover authentic recipes from Japan, India, Mexico, America, and Italy. Step-by-step instructions for traditional dishes from around the world.">
    <meta name="keywords" content="recipes, international cuisine, cooking, Japanese recipes, Indian curry, Mexican tacos, American food, Italian pasta">
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="<?php echo isset($pageTitle) ? htmlspecialchars($pageTitle) : 'World Recipes - Discover Global Flavors'; ?>">
    <meta property="og:description" content="Authentic recipes from around the world with step-by-step instructions">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://worldrecipes.com">
    
    <!-- Favicon -->
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🌍</text></svg>">
    
    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/styles.css">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <header class="site-header">
        <nav class="navbar">
            <div class="container">
                <div class="nav-brand">
                    <a href="index.php" class="logo">
                        <span class="logo-icon">🌍</span>
                        <span class="logo-text">World Recipes</span>
                    </a>
                </div>
                
                <div class="nav-menu" id="navMenu">
                    <ul class="nav-list">
                        <li class="nav-item">
                            <a href="index.php" class="nav-link <?php echo ($currentPage ?? '') === 'home' ? 'active' : ''; ?>">Home</a>
                        </li>
                        <li class="nav-item">
                            <a href="country.php?country=Japan" class="nav-link <?php echo ($currentPage ?? '') === 'japan' ? 'active' : ''; ?>">Japan 🇯🇵</a>
                        </li>
                        <li class="nav-item">
                            <a href="country.php?country=India" class="nav-link <?php echo ($currentPage ?? '') === 'india' ? 'active' : ''; ?>">India 🇮🇳</a>
                        </li>
                        <li class="nav-item">
                            <a href="country.php?country=Mexico" class="nav-link <?php echo ($currentPage ?? '') === 'mexico' ? 'active' : ''; ?>">Mexico 🇲🇽</a>
                        </li>
                        <li class="nav-item">
                            <a href="country.php?country=America" class="nav-link <?php echo ($currentPage ?? '') === 'america' ? 'active' : ''; ?>">America 🇺🇸</a>
                        </li>
                        <li class="nav-item">
                            <a href="country.php?country=Italy" class="nav-link <?php echo ($currentPage ?? '') === 'italy' ? 'active' : ''; ?>">Italy 🇮🇹</a>
                        </li>
                        <li class="nav-item">
                            <a href="about.php" class="nav-link <?php echo ($currentPage ?? '') === 'about' ? 'active' : ''; ?>">About</a>
                        </li>
                        <li class="nav-item">
                            <a href="contact.php" class="nav-link <?php echo ($currentPage ?? '') === 'contact' ? 'active' : ''; ?>">Contact</a>
                        </li>
                    </ul>
                </div>
                
                <button class="nav-toggle" id="navToggle" aria-label="Toggle navigation">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>
        </nav>
    </header>