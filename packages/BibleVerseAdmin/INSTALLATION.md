# Installation Guide - Bible Verse Admin

## Quick Install (5 Minutes)

### Option A: For New Laravel Projects

```bash
# 1. Install the package
composer require starprog/bible-verse-admin

# 2. Publish and run migrations
php artisan vendor:publish --tag=bible-verse-admin-migrations
php artisan migrate

# 3. Create admin user
php artisan user:make-admin your-email@example.com

# 4. Done! Access at /admin/dashboard
```

### Option B: For Existing Projects with Verses

If you already have `verses` and `verse_categories` tables:

```bash
# 1. Install package
composer require starprog/bible-verse-admin

# 2. Only run the new migrations (is_admin, is_featured)
php artisan vendor:publish --tag=bible-verse-admin-migrations
php artisan migrate

# 3. Make user admin
php artisan user:make-admin your-email@example.com

# 4. Configure models if needed
php artisan vendor:publish --tag=bible-verse-admin-config
```

## Detailed Installation

### Step 1: Requirements Check

Make sure you have:
- ✅ PHP 8.1 or higher
- ✅ Laravel 10.x or 11.x
- ✅ Database configured (MySQL/PostgreSQL/SQLite)
- ✅ User authentication set up (Breeze/Jetstream/Fortify)

### Step 2: Install Package

#### Via Composer (Recommended)
```bash
composer require starprog/bible-verse-admin
```

#### Via Local Path (Development)
Add to your `composer.json`:
```json
{
    "repositories": [
        {
            "type": "path",
            "url": "./packages/BibleVerseAdmin"
        }
    ],
    "require": {
        "starprog/bible-verse-admin": "*"
    }
}
```

Then run:
```bash
composer update starprog/bible-verse-admin
```

### Step 3: Publish Assets

#### Publish Migrations (Required)
```bash
php artisan vendor:publish --tag=bible-verse-admin-migrations
```

This creates:
- `xxxx_add_is_admin_to_users_table.php`
- `xxxx_add_is_featured_to_verses_table.php`

#### Publish Configuration (Optional)
```bash
php artisan vendor:publish --tag=bible-verse-admin-config
```

Creates: `config/bible-verse-admin.php`

#### Publish Views (Optional)
Only if you want to customize views:
```bash
php artisan vendor:publish --tag=bible-verse-admin-views
```

Creates views in: `resources/views/vendor/bible-verse-admin/`

### Step 4: Run Migrations

```bash
php artisan migrate
```

This adds:
- `is_admin` boolean column to `users` table
- `is_featured` boolean column to `verses` table

### Step 5: Update Models

#### User Model (`app/Models/User.php`)

Add to fillable:
```php
protected $fillable = [
    'name',
    'email',
    'password',
    'is_admin',  // Add this
];
```

Add to casts:
```php
protected function casts(): array
{
    return [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_admin' => 'boolean',  // Add this
    ];
}
```

#### Verse Model (`app/Models/Verse.php`)

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Verse extends Model
{
    protected $fillable = [
        'verse',
        'reference',
        'category_id',
        'is_featured',  // Add this
    ];

    protected $casts = [
        'is_featured' => 'boolean',  // Add this
    ];

    public function category()
    {
        return $this->belongsTo(VerseCategory::class);
    }
}
```

#### VerseCategory Model (`app/Models/VerseCategory.php`)

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VerseCategory extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    public function verses()
    {
        return $this->hasMany(Verse::class, 'category_id');
    }
}
```

### Step 6: Create Admin User

```bash
php artisan user:make-admin your-email@example.com
```

Output:
```
✓ User 'Your Name' (your-email@example.com) is now an admin!
They can access the admin panel at: /admin/dashboard
```

### Step 7: Access Admin Panel

Open your browser and go to:
```
http://your-app.com/admin/dashboard
```

Login with your admin credentials!

## Configuration

### Customize Route Prefix

Edit `config/bible-verse-admin.php`:
```php
'route_prefix' => 'dashboard',  // Change from 'admin'
```

Now accessible at: `/dashboard` instead of `/admin`

### Customize Middleware

```php
'middleware' => ['web', 'auth', 'admin', 'verified'],  // Add more middleware
```

### Adjust Pagination

```php
'pagination' => [
    'verses' => 50,      // Show 50 verses per page
    'categories' => 30,  // Show 30 categories per page
],
```

### Use Custom Models

```php
'models' => [
    'user' => \App\Models\CustomUser::class,
    'verse' => \App\Models\Scripture::class,
    'verse_category' => \App\Models\Category::class,
],
```

## Database Setup

If you don't have the tables yet, create these migrations:

### Verses Table
```php
Schema::create('verses', function (Blueprint $table) {
    $table->id();
    $table->string('reference');
    $table->text('verse');
    $table->foreignId('category_id')->constrained('verse_categories');
    $table->boolean('is_featured')->default(false);
    $table->timestamps();
});
```

### Verse Categories Table
```php
Schema::create('verse_categories', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('slug')->unique();
    $table->text('description')->nullable();
    $table->timestamps();
});
```

## Testing Installation

### 1. Check Routes
```bash
php artisan route:list --name=admin
```

You should see 16 admin routes.

### 2. Check Middleware
```bash
php artisan route:list | Select-String "admin.dashboard"
```

Should show: `web, auth, admin` middleware

### 3. Test Access
1. Go to `/admin/dashboard` (should redirect to login if not logged in)
2. Login as admin user
3. Should see dashboard with statistics
4. Try creating a category
5. Try creating a verse
6. Test CSV import

## Troubleshooting

### "Class not found" Error
```bash
composer dump-autoload
php artisan config:clear
php artisan cache:clear
```

### Views Not Loading
```bash
php artisan view:clear
php artisan vendor:publish --tag=bible-verse-admin-views --force
```

### Routes Not Working
```bash
php artisan route:clear
php artisan config:clear
php artisan optimize:clear
```

### Cannot Access Admin Panel

**Check 1:** Is user marked as admin?
```bash
php artisan tinker
>>> \App\Models\User::where('email', 'your@email.com')->first()->is_admin
```

Should return `true`.

**Check 2:** Is middleware registered?
```bash
php artisan route:list --name=admin.dashboard
```

Should show middleware includes `admin`.

### Migration Already Exists

If migrations conflict:
```bash
# Delete the published migrations
rm database/migrations/*_add_is_admin_to_users_table.php
rm database/migrations/*_add_is_featured_to_verses_table.php

# Manually add columns
php artisan tinker
>>> Schema::table('users', function($table) { $table->boolean('is_admin')->default(false); });
>>> Schema::table('verses', function($table) { $table->boolean('is_featured')->default(false); });
```

## Updating

To update to the latest version:
```bash
composer update starprog/bible-verse-admin
php artisan vendor:publish --tag=bible-verse-admin-views --force
php artisan config:clear
```

## Uninstalling

```bash
# Remove package
composer remove starprog/bible-verse-admin

# Optional: Remove migrations (will lose data!)
php artisan migrate:rollback --step=2

# Optional: Remove config
rm config/bible-verse-admin.php

# Optional: Remove published views
rm -rf resources/views/vendor/bible-verse-admin
```

## Next Steps

After installation:
1. ✅ Create your first category
2. ✅ Add some verses manually
3. ✅ Try CSV bulk import
4. ✅ Mark verses as featured
5. ✅ Customize the views (optional)
6. ✅ Configure route prefix (optional)

## Support

Need help? 
- 📖 Check the [README](README.md)
- 🐛 [Report Issues](https://github.com/starprog/bible-verse-admin/issues)
- 💬 [Discussions](https://github.com/starprog/bible-verse-admin/discussions)

---

**Installation Time:** ~5 minutes
**Difficulty:** Easy
**Support:** PHP 8.1+, Laravel 10+, 11+
