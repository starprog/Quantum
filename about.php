<?php
$pageTitle = 'About - World Recipes';
$currentPage = 'about';
include 'includes/header.php';
?>

<main class="container">
    <section class="about-hero">
        <h1>About World Recipes</h1>
        <p class="lead orange-text">Connecting cultures through the universal language of food</p>
    </section>

    <section class="about-content">
        <div class="about-grid">
            <div class="about-text">
                <h2>Our Mission</h2>
                <p>World Recipes is a culinary journey that brings together authentic recipes from five incredible countries: Japan, India, Mexico, America, and Italy. We believe that food is one of the most powerful ways to connect with different cultures and understand the world around us.</p>
                
                <p>Each recipe in our collection has been carefully selected to represent the true essence of its country's culinary tradition. From the delicate flavors of Japanese cuisine to the bold spices of Indian cooking, from the vibrant tastes of Mexican food to the comfort of American classics and the timeless elegance of Italian dishes.</p>

                <h3>What Makes Us Different</h3>
                <ul class="feature-list">
                    <li>🌍 <strong>Authentic Recipes:</strong> Each recipe represents traditional cooking methods and ingredients</li>
                    <li>📝 <strong>Detailed Instructions:</strong> Step-by-step guides that make cooking accessible to everyone</li>
                    <li>🥘 <strong>Complete Ingredient Lists:</strong> Everything you need to recreate these dishes at home</li>
                    <li>📱 <strong>Mobile-Friendly:</strong> Cook from your phone or tablet with our responsive design</li>
                    <li>🔗 <strong>Source Links:</strong> Links to original recipes for deeper exploration</li>
                </ul>

                <h3>The Countries We Feature</h3>
                <div class="country-showcase">
                    <div class="country-highlight">
                        <span class="flag">🇯🇵</span>
                        <div>
                            <strong>Japan</strong>
                            <p>Discover the art of Japanese cooking with recipes like Chicken Katsu, Tonkatsu Ramen, and Gyudon</p>
                        </div>
                    </div>
                    <div class="country-highlight">
                        <span class="flag">🇮🇳</span>
                        <div>
                            <strong>India</strong>
                            <p>Explore the rich spices and flavors of Indian cuisine through curries and traditional dishes</p>
                        </div>
                    </div>
                    <div class="country-highlight">
                        <span class="flag">🇲🇽</span>
                        <div>
                            <strong>Mexico</strong>
                            <p>Experience the vibrant and bold flavors of Mexican cooking with tacos, quesadillas, and birria</p>
                        </div>
                    </div>
                    <div class="country-highlight">
                        <span class="flag">🇺🇸</span>
                        <div>
                            <strong>America</strong>
                            <p>Enjoy classic American comfort foods including burgers, fries, and chili hot dogs</p>
                        </div>
                    </div>
                    <div class="country-highlight">
                        <span class="flag">🇮🇹</span>
                        <div>
                            <strong>Italy</strong>
                            <p>Savor the timeless elegance of Italian cuisine with pasta, alfredo, and lasagna recipes</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="tech-section">
        <h2>Built with Modern Technology</h2>
        <p>World Recipes is built using PHP and MySQL, creating a fast and reliable platform for sharing recipes. Our responsive design ensures you can access recipes on any device, whether you're shopping for ingredients on your phone or cooking from your tablet in the kitchen.</p>
        
        <div class="tech-features">
            <div class="tech-feature">
                <h3>🗄️ Database-Driven</h3>
                <p>All recipes are stored in a MySQL database for fast retrieval and easy management</p>
            </div>
            <div class="tech-feature">
                <h3>📱 Responsive Design</h3>
                <p>Mobile-first design that works perfectly on phones, tablets, and desktop computers</p>
            </div>
            <div class="tech-feature">
                <h3>🚀 Fast Loading</h3>
                <p>Optimized code and images for quick page loads and smooth browsing experience</p>
            </div>
        </div>
    </section>

    <section class="cta-section">
        <h2>Start Your Culinary Adventure</h2>
        <p>Ready to explore flavors from around the world? Browse our collection of authentic recipes and start cooking today!</p>
        <a href="index.php" class="btn-primary">Explore Recipes</a>
    </section>
</main>

<?php include 'includes/footer.php'; ?>