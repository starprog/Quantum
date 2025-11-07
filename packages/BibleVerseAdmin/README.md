# Bible Verse Admin Panel

A simple and elegant Laravel package for managing Bible verses with a beautiful admin interface.

[![Latest Version](https://img.shields.io/badge/version-1.0.0-blue.svg)](https://github.com/starprog/bible-verse-admin)
[![Laravel](https://img.shields.io/badge/Laravel-10%2B%7C11%2B-red.svg)](https://laravel.com)
[![License](https://img.shields.io/badge/license-MIT-green.svg)](LICENSE)

## Features

- ✅ **Full CRUD Operations** - Add, edit, delete verses and categories
- ✅ **Search & Filter** - Find verses quickly by text or reference
- ✅ **CSV Bulk Import** - Import hundreds of verses at once
- ✅ **Featured Verses** - Mark and manage featured verses
- ✅ **Category Management** - Organize verses into categories
- ✅ **Beautiful UI** - Modern, responsive design with Tailwind CSS
- ✅ **Secure** - Protected by authentication and admin middleware
- ✅ **Configurable** - Customize routes, pagination, and models
- ✅ **Easy Setup** - Install and run in minutes

## Screenshots

![Dashboard](https://via.placeholder.com/800x400?text=Dashboard)
![Verses List](https://via.placeholder.com/800x400?text=Verses+List)

## Requirements

- PHP 8.1 or higher
- Laravel 10.x or 11.x
- MySQL, PostgreSQL, or SQLite database

## Installation

### Step 1: Install via Composer

```bash
composer require starprog/bible-verse-admin
```

### Step 2: Publish Package Assets

```bash
# Publish migrations
php artisan vendor:publish --tag=bible-verse-admin-migrations

# Publish configuration (optional)
php artisan vendor:publish --tag=bible-verse-admin-config

# Publish views (optional, if you want to customize)
php artisan vendor:publish --tag=bible-verse-admin-views
```

### Step 3: Run Migrations

```bash
php artisan migrate
```

This will add:
- `is_admin` column to your `users` table
- `is_featured` column to your `verses` table

### Step 4: Create Your First Admin User

```bash
php artisan user:make-admin your-email@example.com
```

### Step 5: Access Admin Panel

Navigate to: `http://your-app.com/admin/dashboard`

## Usage

### Creating Verses

1. Go to `/admin/verses/create`
2. Fill in the verse reference (e.g., "John 3:16")
3. Enter the verse text
4. Select a category
5. Optionally mark as featured
6. Save!

### Bulk Import

1. Prepare a CSV file with format: `Reference, Verse Text, Category Name`
2. Go to `/admin/verses/import`
3. Upload your CSV file
4. Review import results

**CSV Example:**
```csv
Reference,Verse Text,Category Name
John 3:16,"For God so loved the world that he gave his one and only Son...",Love
Psalm 23:1,"The Lord is my shepherd, I lack nothing.",Comfort
```

### Managing Categories

1. Create categories first at `/admin/categories`
2. Add name, slug, and description
3. Assign verses to categories

## Configuration

After publishing the config file, you can customize in `config/bible-verse-admin.php`:

```php
return [
    // Change admin route prefix
    'route_prefix' => 'admin',  // or 'dashboard', 'panel', etc.
    
    // Customize middleware
    'middleware' => ['web', 'auth', 'admin'],
    
    // Adjust pagination
    'pagination' => [
        'verses' => 20,
        'categories' => 20,
    ],
    
    // CSV import settings
    'import' => [
        'max_file_size' => 2048, // KB
        'allowed_mimes' => ['csv', 'txt'],
    ],
    
    // Use custom models
    'models' => [
        'user' => \App\Models\User::class,
        'verse' => \App\Models\Verse::class,
        'verse_category' => \App\Models\VerseCategory::class,
    ],
];
```

## Model Requirements

Your models must have the following structure:

### User Model
```php
// Add to fillable
protected $fillable = ['is_admin'];

// Add to casts
protected function casts(): array {
    return ['is_admin' => 'boolean'];
}
```

### Verse Model
```php
protected $fillable = ['verse', 'reference', 'category_id', 'is_featured'];

protected function casts(): array {
    return ['is_featured' => 'boolean'];
}

public function category() {
    return $this->belongsTo(VerseCategory::class);
}
```

### VerseCategory Model
```php
protected $fillable = ['name', 'slug', 'description'];

public function verses() {
    return $this->hasMany(Verse::class, 'category_id');
}
```

## Available Routes

All routes are prefixed with `/admin` by default:

| Method | URI | Description |
|--------|-----|-------------|
| GET | `/admin/dashboard` | Dashboard with statistics |
| GET | `/admin/verses` | List all verses |
| GET | `/admin/verses/create` | Create verse form |
| POST | `/admin/verses` | Store new verse |
| GET | `/admin/verses/{id}/edit` | Edit verse form |
| PUT | `/admin/verses/{id}` | Update verse |
| DELETE | `/admin/verses/{id}` | Delete verse |
| PATCH | `/admin/verses/{id}/toggle-featured` | Toggle featured status |
| GET | `/admin/verses/import` | Import form |
| POST | `/admin/verses/import` | Process import |
| GET | `/admin/categories` | List categories |
| GET | `/admin/categories/create` | Create category form |
| POST | `/admin/categories` | Store category |
| GET | `/admin/categories/{id}/edit` | Edit category form |
| PUT | `/admin/categories/{id}` | Update category |
| DELETE | `/admin/categories/{id}` | Delete category |

## Artisan Commands

### Make User Admin
```bash
php artisan user:make-admin email@example.com
```

## Customization

### Customize Views

Publish the views to modify them:
```bash
php artisan vendor:publish --tag=bible-verse-admin-views
```

Views will be copied to `resources/views/vendor/bible-verse-admin/`

### Change Route Prefix

In `config/bible-verse-admin.php`:
```php
'route_prefix' => 'dashboard',  // Now accessible at /dashboard
```

### Use Custom Models

In `config/bible-verse-admin.php`:
```php
'models' => [
    'verse' => \App\Models\Scripture::class,  // Use your custom model
],
```

## Security

- All routes require authentication
- Admin middleware protects all admin routes
- CSRF protection on all forms
- File upload validation
- SQL injection protection via Eloquent ORM
- XSS protection via Blade templating

## Troubleshooting

### Cannot Access Admin Panel
**Problem:** 403 Forbidden error
**Solution:** Make sure your user has `is_admin = true`
```bash
php artisan user:make-admin your-email@example.com
```

### CSV Import Fails
**Problem:** Import returns errors
**Solution:** 
- Verify all categories exist before importing
- Check CSV format matches: `Reference, Text, Category`
- Ensure file size is under 2MB

### Views Not Found
**Problem:** View errors after installation
**Solution:** Clear your view cache
```bash
php artisan view:clear
php artisan config:clear
php artisan cache:clear
```

## Support

- **Issues:** [GitHub Issues](https://github.com/starprog/bible-verse-admin/issues)
- **Email:** admin@starprog.com

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This package is open-sourced software licensed under the [MIT license](LICENSE).

## Credits

- **Author:** Starprog
- **Built with:** Laravel, Tailwind CSS, Blade Templates

## Changelog

### v1.0.0 (2025-11-07)
- Initial release
- Full CRUD for verses and categories
- CSV bulk import
- Featured verses functionality
- Admin dashboard with statistics
- Configurable routes and models
- Artisan command for admin management

---

**Made with ❤️ for the Laravel community**
