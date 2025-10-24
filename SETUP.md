# 🌍 World Recipes - Setup Instructions

## 📋 Quick Setup (3 Steps)

### Step 1: Import Database
1. Open **phpMyAdmin** in your browser
2. Click **"Import"** tab
3. Choose file: `world_recipes_complete.sql`
4. Click **"Go"** to import
   - ✅ Creates `world_recipes` database
   - ✅ Creates `recipes` table
   - ✅ Imports all 15 recipes

### Step 2: Configure Database
1. Open `config/database.php`
2. Update these settings for your setup:
   ```php
   define('DB_HOST', 'localhost');     // Your MySQL host
   define('DB_NAME', 'world_recipes'); // Database name
   define('DB_USER', 'root');          // Your username
   define('DB_PASS', '');              // Your password
   ```

### Step 3: Launch Website
1. Place all files in your web server folder:
   - **XAMPP**: `htdocs/world-recipes/`
   - **WAMP**: `www/world-recipes/`
   - **MAMP**: `htdocs/world-recipes/`

2. Start Apache & MySQL services
3. Visit: `http://localhost/world-recipes`

---

## 🎯 Your Recipes (15 Total)

### 🇯🇵 Japan (3 recipes)
1. **Chicken Katsu** - Crispy breaded chicken cutlet
2. **Tonkatsu (Pork Cutlet)** - Golden fried pork with cabbage
3. **Gyūdon (Beef Bowl)** - Sweet beef over rice

### 🇮🇳 India (3 recipes)
4. **Chicken Curry** - Aromatic spiced chicken
5. **Lamb Curry** - Rich slow-cooked lamb
6. **Masala Tikki Curry** - Spiced potato patties in curry

### 🇺🇸 America (3 recipes)
7. **Classic Burger** - All-American beef burger
8. **Fries** - Double-fried crispy potatoes  
9. **Chili Hot Dogs** - Loaded hot dogs with chili

### 🇲🇽 Mexico (3 recipes)
10. **Birria Tacos** - Dipped tacos with consommé
11. **Quesadillas** - Cheesy folded tortillas
12. **Cheesy Homemade Tacos** - Loaded taco shells

### 🇮🇹 Italy (3 recipes)
13. **Spaghetti** - Classic pasta with sauce
14. **Chicken Alfredo** - Creamy fettuccine with chicken
15. **Lasagna** - Layered pasta bake

---

## 🔒 Security Features (PUBLIC SITE)

✅ **NO LOGIN SYSTEM** - All pages are publicly accessible  
✅ **Prepared Statements** - SQL injection protection  
✅ **Input Sanitization** - XSS prevention  
✅ **Input Validation** - Data integrity  
✅ **Error Logging** - Security monitoring  

---

## 📂 File Structure

```
world-recipes/
├── 📄 world_recipes_complete.sql   # Single file to import into phpMyAdmin
├── 📁 config/
│   └── database.php               # Database connection & security
├── 📁 includes/
│   ├── header.php                 # Navigation & head
│   └── footer.php                 # Footer & scripts  
├── 📁 assets/
│   ├── 📁 css/
│   │   └── styles.css             # Modern responsive design
│   └── 📁 js/
│       └── script.js              # Interactive features
├── index.php                      # Homepage with country cards
├── country.php                    # Recipes by country
├── recipe.php                     # Individual recipe details
├── about.php                      # About page
├── contact.php                    # Contact form (no real email)
└── README.md                      # This file
```

---

## 🎨 Features Included

### 🖥️ Frontend
- **Responsive Design** - Mobile, tablet, desktop
- **Country Cards** - Flag icons with hover effects  
- **Recipe Cards** - Images, descriptions, links
- **Modern CSS** - Grid, flexbox, animations
- **Mobile Menu** - Hamburger navigation
- **Search Feature** - Filter recipes
- **Print Recipes** - Printer-friendly pages

### ⚡ Backend  
- **PHP 7.4+** with PDO
- **MySQL Database** with indexes
- **Prepared Statements** for security
- **Input Validation** and sanitization
- **Error Handling** with logging
- **UTF-8 Support** for international text

### 📱 Interactive
- **Smooth Animations** - Scroll reveals, hovers
- **Form Validation** - Real-time feedback
- **Lazy Loading** - Optimized image loading  
- **Back to Top** - Smooth scrolling
- **Print Function** - Recipe printing

---

## 🛠️ Customization

### Add New Recipe
```sql
INSERT INTO recipes (country, name, ingredients, steps, image, source_link) 
VALUES ('Country', 'Recipe Name', 'Ingredients...', 'Steps...', 'image_url', 'source_url');
```

### Add New Country
1. Update `$countryData` arrays in PHP files
2. Add country flag emoji and color
3. Add navigation link in `header.php`

### Styling Changes
- Edit `assets/css/styles.css`
- Modify CSS variables in `:root` for global changes
- Country colors: `--japan-color`, `--india-color`, etc.

---

## 📧 Support

For questions or issues:
- Check the recipes work by visiting each page
- Verify database connection in browser
- Check browser console for JavaScript errors
- Review server error logs for PHP issues

---

**🎉 Your World Recipes website is ready!**  
**© 2025 World Recipes by Zach Jenkins**