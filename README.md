# World Recipes Website

A beautiful, responsive PHP + MySQL website showcasing authentic recipes from around the world.

## 🌍 Features

- **5 Countries**: Japan 🇯🇵, India 🇮🇳, Mexico 🇲🇽, America 🇺🇸, Italy 🇮🇹
- **15 Authentic Recipes**: 3 recipes per country with detailed ingredients and instructions
- **Responsive Design**: Works perfectly on desktop, tablet, and mobile devices
- **Modern UI**: Clean, colorful design with flag icons and smooth animations
- **Database-Driven**: MySQL backend for fast recipe retrieval
- **Interactive Features**: Mobile navigation, search, print recipes, smooth scrolling

## 🚀 Quick Setup

### 1. Database Setup
1. Open phpMyAdmin
2. Import `database.sql` to create the `world_recipes` database and table
3. Import `recipes.sql` to populate with sample recipe data

### 2. Configuration
1. Edit `config/database.php` with your MySQL credentials:
   ```php
   define('DB_HOST', 'localhost');     // Your MySQL host
   define('DB_NAME', 'world_recipes'); // Database name
   define('DB_USER', 'root');          // Your MySQL username
   define('DB_PASS', '');              // Your MySQL password
   ```

### 3. Web Server
1. Place all files in your web server directory (htdocs for XAMPP, www for WAMP)
2. Start Apache and MySQL services
3. Visit `http://localhost/world-recipes` in your browser

## 📁 File Structure

```
world-recipes/
├── assets/
│   ├── css/
│   │   └── styles.css          # Modern responsive CSS
│   └── js/
│       └── script.js           # Interactive JavaScript
├── config/
│   └── database.php            # Database connection
├── includes/
│   ├── header.php             # Site header and navigation
│   └── footer.php             # Site footer
├── index.php                  # Homepage with country cards
├── country.php                # Country-specific recipe listing
├── recipe.php                 # Individual recipe details
├── about.php                  # About page
├── contact.php                # Contact form
├── database.sql               # Database schema
├── recipes.sql                # Sample recipe data
└── README.md                  # This file
```

## 🍳 Recipes Included

### Japan 🇯🇵
- Chicken Katsu
- Tonkatsu Ramen  
- Beef Bowl (Gyudon)

### India 🇮🇳
- Chicken Curry
- Lamb Curry
- Masala Tikki Curry

### Mexico 🇲🇽
- Birria Tacos
- Quesadillas
- Cheesy Homemade Tacos

### America 🇺🇸
- Burgers
- Fries
- Chili Hot Dogs

### Italy 🇮🇹
- Spaghetti
- Chicken Alfredo
- Lasagna

## 💻 Technical Features

- **PHP 7.4+** with PDO for secure database operations
- **MySQL 5.7+** for recipe storage
- **Responsive CSS Grid & Flexbox** layouts
- **Mobile-first design** approach
- **Lazy loading** for images
- **Print-friendly** recipe pages
- **Form validation** with JavaScript
- **Accessibility** features (ARIA labels, keyboard navigation)
- **SEO optimized** with meta tags and semantic HTML

## 🎨 Design Features

- Modern color palette with country-specific accent colors
- Google Fonts (Inter + Playfair Display)
- Smooth CSS transitions and hover effects
- Flag emojis for visual country identification
- Recipe card layouts with high-quality food images
- Mobile hamburger navigation
- Back-to-top button
- Loading animations

## 📱 Mobile Responsive

- Hamburger menu for mobile navigation
- Touch-friendly buttons and cards
- Optimized layouts for small screens
- Fast loading on mobile networks

## 🛠 Customization

### Adding New Recipes
1. Add recipe to database via phpMyAdmin or SQL:
```sql
INSERT INTO recipes (country, name, ingredients, steps, image, source_link) 
VALUES ('CountryName', 'Recipe Name', 'Ingredient list...', 'Step instructions...', 'image_url', 'source_url');
```

### Adding New Countries
1. Update the `$countryData` arrays in the PHP files
2. Add country flag emoji and color
3. Add navigation link in `header.php`

### Styling Changes
- Edit `assets/css/styles.css`
- Modify CSS variables at the top for global changes
- Country colors are defined in `:root` CSS variables

## 🔧 Requirements

- **Web Server**: Apache/Nginx with PHP support
- **PHP**: Version 7.4 or higher
- **MySQL**: Version 5.7 or higher
- **Browser**: Modern browsers with CSS Grid support

## 📄 License

© 2025 World Recipes by Zach Jenkins. All rights reserved.

## 🤝 Contributing

Feel free to submit recipe suggestions or improvements to make this project even better!

---

**Enjoy exploring flavors from around the world! 🌍👨‍🍳**