# Admin Panel Setup Guide

## Overview
The admin panel provides comprehensive management capabilities for Bible verses, including:
- Add/Edit/Delete verses
- Manage categories
- Bulk import verses from CSV
- Set featured verses

## Features Implemented

### 1. Admin Authentication
- **Middleware**: `IsAdmin` middleware protects all admin routes
- **Access Control**: Only users with `is_admin = true` can access the admin panel
- **Location**: `/admin/dashboard`

### 2. Verse Management
**Routes:**
- `GET /admin/verses` - List all verses with search and filter
- `GET /admin/verses/create` - Create new verse form
- `POST /admin/verses` - Store new verse
- `GET /admin/verses/{id}/edit` - Edit verse form
- `PUT /admin/verses/{id}` - Update verse
- `DELETE /admin/verses/{id}` - Delete verse
- `PATCH /admin/verses/{id}/toggle-featured` - Toggle featured status

**Features:**
- Search by verse text or reference
- Filter by category
- Paginated results (20 per page)
- Quick featured toggle with star icon
- Field validation

### 3. Category Management
**Routes:**
- `GET /admin/categories` - List all categories
- `GET /admin/categories/create` - Create category form
- `POST /admin/categories` - Store category
- `GET /admin/categories/{id}/edit` - Edit category form
- `PUT /admin/categories/{id}` - Update category
- `DELETE /admin/categories/{id}` - Delete category

**Features:**
- Display verse count per category
- Auto-generate slug from name
- Prevent deletion of categories with verses
- Full CRUD operations

### 4. Bulk Import
**Route:** `GET /admin/verses/import`

**CSV Format:**
```csv
Reference, Verse Text, Category Name
John 3:16, "For God so loved the world...", Love
Psalm 23:1, "The Lord is my shepherd...", Comfort
```

**Features:**
- Upload CSV file (max 2MB)
- Validates category existence
- Skips duplicate references
- Displays import summary (imported/skipped counts)
- Shows detailed error messages
- Downloadable sample CSV

### 5. Featured Verses
**Database Field:** `is_featured` (boolean) on `verses` table

**Features:**
- Toggle featured status from verses list
- Filter featured verses
- Featured count on dashboard
- Visual indicator (star icon)

## Database Changes

### Migration 1: Add is_admin to users
```php
Schema::table('users', function (Blueprint $table) {
    $table->boolean('is_admin')->default(false)->after('email');
});
```

### Migration 2: Add is_featured to verses
```php
Schema::table('verses', function (Blueprint $table) {
    $table->boolean('is_featured')->default(false)->after('category_id');
});
```

## Setup Instructions

### 1. Run Migrations
```bash
php artisan migrate
```

### 2. Create Admin User
You need to set a user as admin. Use one of these methods:

**Option A: Using Artisan Command (Recommended)**
```bash
php artisan user:make-admin your-email@example.com
```

**Option B: Using Tinker**
```bash
php artisan tinker
```
```php
$user = User::where('email', 'your-email@example.com')->first();
$user->is_admin = true;
$user->save();
```

**Option C: Using SQL**
```sql
UPDATE users SET is_admin = 1 WHERE email = 'your-email@example.com';
```

### 3. Access Admin Panel
Once a user is marked as admin:
1. Log in to the application
2. Navigate to `/admin/dashboard`
3. Start managing verses and categories!

## Files Created/Modified

### New Files
- `app/Http/Middleware/IsAdmin.php` - Admin authentication middleware
- `app/Http/Controllers/Admin/VerseCategoryController.php` - Category CRUD controller
- `app/Console/Commands/MakeUserAdmin.php` - Artisan command to make users admin
- `resources/views/admin/layout.blade.php` - Admin panel layout
- `resources/views/admin/dashboard.blade.php` - Admin dashboard
- `resources/views/admin/verses/index.blade.php` - Verses list
- `resources/views/admin/verses/create.blade.php` - Create verse form
- `resources/views/admin/verses/edit.blade.php` - Edit verse form
- `resources/views/admin/verses/import.blade.php` - CSV import form
- `resources/views/admin/categories/index.blade.php` - Categories list
- `resources/views/admin/categories/create.blade.php` - Create category form
- `resources/views/admin/categories/edit.blade.php` - Edit category form

### Modified Files
- `app/Http/Controllers/Admin/VerseController.php` - Updated field names and added toggle featured
- `app/Models/Verse.php` - Added is_featured field and cast
- `bootstrap/app.php` - Registered admin middleware
- `routes/web.php` - Added admin routes group

### New Migrations
- `2025_11_07_000949_add_is_admin_to_users_table.php`
- `2025_11_07_001203_add_is_featured_to_verses_table.php`

## Usage Examples

### Creating a Verse
1. Go to `/admin/verses/create`
2. Fill in reference (e.g., "John 3:16")
3. Enter verse text
4. Select category
5. Optionally check "Mark as Featured"
6. Click "Create Verse"

### Importing Verses from CSV
1. Ensure all categories exist first
2. Prepare CSV file with format: `Reference, Text, Category`
3. Go to `/admin/verses/import`
4. Upload CSV file
5. Review import results

### Managing Categories
1. Go to `/admin/categories`
2. View all categories with verse counts
3. Add new categories or edit existing ones
4. Note: Cannot delete categories that have verses

### Setting Featured Verses
**Method 1:** Toggle from verses list
- Click the star icon next to any verse

**Method 2:** Set during creation/editing
- Check the "Mark as Featured" checkbox

## Security Notes

- All admin routes require authentication (`auth` middleware)
- All admin routes require admin privileges (`admin` middleware)
- Unauthorized access returns 403 Forbidden
- CSRF protection enabled on all forms
- File upload validation (CSV only, 2MB max)

## Dashboard Statistics

The admin dashboard displays:
- Total verses count
- Total categories count
- Featured verses count
- Quick action buttons for common tasks

## Tips

1. **Categories First**: Create your categories before adding verses
2. **CSV Import**: Test with sample CSV first
3. **Featured Verses**: Use sparingly for best verses to highlight
4. **Search**: Use search to quickly find verses to edit
5. **Bulk Operations**: Use CSV import for adding many verses at once

## Troubleshooting

**Problem:** Cannot access admin panel
- **Solution:** Ensure user has `is_admin = true` in database

**Problem:** CSV import fails
- **Solution:** Verify categories exist and CSV format matches template

**Problem:** Cannot delete category
- **Solution:** Reassign or delete all verses in that category first

**Problem:** Validation errors
- **Solution:** Check for duplicate references or missing required fields

## Future Enhancements (Optional)

- [ ] Export verses to CSV
- [ ] Bulk edit operations
- [ ] Category reassignment tool
- [ ] Advanced filtering (by date, featured status)
- [ ] Verse statistics and analytics
- [ ] Role-based permissions (editor, admin, super admin)
- [ ] Activity log/audit trail
