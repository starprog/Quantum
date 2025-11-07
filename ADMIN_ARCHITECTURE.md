# Admin Panel Architecture

```
┌─────────────────────────────────────────────────────────────────┐
│                        ADMIN PANEL                              │
│                   /admin/dashboard                              │
└─────────────────────────────────────────────────────────────────┘
                              │
        ┌─────────────────────┼─────────────────────┐
        │                     │                     │
        ▼                     ▼                     ▼
┌──────────────┐     ┌──────────────┐     ┌──────────────┐
│   VERSES     │     │ CATEGORIES   │     │   IMPORT     │
│   /verses    │     │ /categories  │     │ /verses/     │
│              │     │              │     │  import      │
└──────────────┘     └──────────────┘     └──────────────┘
        │                     │                     │
        │                     │                     │
        ▼                     ▼                     ▼
┌──────────────┐     ┌──────────────┐     ┌──────────────┐
│   • List     │     │   • List     │     │  • Upload    │
│   • Create   │     │   • Create   │     │    CSV       │
│   • Edit     │     │   • Edit     │     │  • Process   │
│   • Delete   │     │   • Delete   │     │  • Report    │
│   • Search   │     │   • Count    │     │    Errors    │
│   • Filter   │     │   • Protect  │     │              │
│   • Feature  │     │              │     │              │
└──────────────┘     └──────────────┘     └──────────────┘
```

## Data Flow

```
┌─────────────┐
│   Browser   │
└──────┬──────┘
       │
       ▼
┌─────────────────────┐
│  Route Middleware   │
│  • auth             │
│  • admin            │
└──────┬──────────────┘
       │
       ▼
┌─────────────────────┐
│   Controllers       │
│  • VerseController  │
│  • CategoryCntrl    │
└──────┬──────────────┘
       │
       ▼
┌─────────────────────┐
│     Models          │
│  • Verse            │
│  • VerseCategory    │
│  • User             │
└──────┬──────────────┘
       │
       ▼
┌─────────────────────┐
│     Database        │
│  • verses           │
│  • verse_categories │
│  • users            │
└─────────────────────┘
```

## Security Layers

```
┌──────────────────────────────────────────┐
│          Public Access                   │
└──────────────────────────────────────────┘
                  │
                  ▼
┌──────────────────────────────────────────┐
│       Auth Middleware                    │
│       (Must be logged in)                │
└──────────────────────────────────────────┘
                  │
                  ▼
┌──────────────────────────────────────────┐
│       Admin Middleware                   │
│       (Must have is_admin = true)        │
└──────────────────────────────────────────┘
                  │
                  ▼
┌──────────────────────────────────────────┐
│       Admin Panel Access                 │
│       Full CRUD Operations               │
└──────────────────────────────────────────┘
```

## File Structure

```
Quantum/
├── app/
│   ├── Console/
│   │   └── Commands/
│   │       └── MakeUserAdmin.php          ← New
│   ├── Http/
│   │   ├── Controllers/
│   │   │   └── Admin/
│   │   │       ├── VerseController.php    ← Updated
│   │   │       └── VerseCategoryCtrl.php  ← New
│   │   └── Middleware/
│   │       └── IsAdmin.php                ← New
│   └── Models/
│       ├── User.php                       ← Updated
│       └── Verse.php                      ← Updated
│
├── database/
│   └── migrations/
│       ├── 2025_11_07_000949_add_is_admin.php      ← New
│       └── 2025_11_07_001203_add_is_featured.php   ← New
│
├── resources/
│   └── views/
│       └── admin/
│           ├── layout.blade.php           ← New
│           ├── dashboard.blade.php        ← New
│           ├── verses/
│           │   ├── index.blade.php        ← New
│           │   ├── create.blade.php       ← New
│           │   ├── edit.blade.php         ← New
│           │   └── import.blade.php       ← New
│           └── categories/
│               ├── index.blade.php        ← New
│               ├── create.blade.php       ← New
│               └── edit.blade.php         ← New
│
├── routes/
│   └── web.php                            ← Updated
│
├── bootstrap/
│   └── app.php                            ← Updated
│
└── Documentation/
    ├── ADMIN_PANEL_COMPLETE.md            ← New
    ├── ADMIN_QUICK_START.md               ← New
    ├── ADMIN_PANEL_SETUP.md               ← New
    ├── ADMIN_IMPLEMENTATION_SUMMARY.md    ← New
    └── ADMIN_ARCHITECTURE.md              ← This file
```

## Database Schema Updates

```sql
-- users table
ALTER TABLE users ADD COLUMN is_admin BOOLEAN DEFAULT FALSE;

-- verses table
ALTER TABLE verses ADD COLUMN is_featured BOOLEAN DEFAULT FALSE;
```

## Request Flow Example

### Creating a Verse

```
User clicks "Add New Verse"
        │
        ▼
GET /admin/verses/create
        │
        ▼
IsAdmin middleware checks user.is_admin
        │
        ▼
VerseController@create()
        │
        ▼
Returns create.blade.php with categories
        │
        ▼
User fills form and submits
        │
        ▼
POST /admin/verses
        │
        ▼
Validate: reference, verse, category_id, is_featured
        │
        ▼
Verse::create([...])
        │
        ▼
Redirect to /admin/verses with success message
```

## Component Relationships

```
┌─────────────┐
│    User     │
│  is_admin   │
└──────┬──────┘
       │
       │ can access
       │
       ▼
┌─────────────────────┐
│   Admin Panel       │
│   • Dashboard       │
│   • Verses          │
│   • Categories      │
└──────┬──────────────┘
       │
       │ manages
       │
       ▼
┌──────────────┐         ┌──────────────┐
│    Verse     │◄───────│   Category   │
│  reference   │  has    │     name     │
│  verse       │         │     slug     │
│  is_featured │         │  description │
└──────────────┘         └──────────────┘
       │
       │ belongs to
       │
       ▼
┌──────────────┐
│   Category   │
└──────────────┘
```

## Admin Dashboard Components

```
┌─────────────────────────────────────────────────────────┐
│                    ADMIN DASHBOARD                      │
├─────────────────────────────────────────────────────────┤
│                                                         │
│  ┌───────────┐  ┌───────────┐  ┌───────────┐         │
│  │  Total    │  │   Total   │  │ Featured  │         │
│  │  Verses   │  │Categories │  │  Verses   │         │
│  │           │  │           │  │           │         │
│  │    150    │  │     10    │  │     12    │         │
│  └───────────┘  └───────────┘  └───────────┘         │
│                                                         │
│  Quick Actions:                                        │
│  ┌────────────┐ ┌────────────┐ ┌────────────┐        │
│  │ Add Verse  │ │Add Category│ │Import CSV  │        │
│  └────────────┘ └────────────┘ └────────────┘        │
│                                                         │
└─────────────────────────────────────────────────────────┘
```

## Middleware Chain

```
Request → Web Middleware → Auth Middleware → Admin Middleware → Controller
   │           │                 │                  │               │
   │           │                 │                  │               │
   │      CSRF Token         Logged In?        is_admin?        Process
   │      Validation           Check             Check          Request
   │           │                 │                  │               │
   │           ▼                 ▼                  ▼               ▼
   └────→  Next  ───────→   Next  ────────→   Next  ────────→  Response
```

## Feature Toggles

### Featured Verse Toggle
```
Verses List Page
    │
    ├─► Click Star Icon
    │       │
    │       ▼
    │   PATCH /admin/verses/{id}/toggle-featured
    │       │
    │       ▼
    │   VerseController@toggleFeatured()
    │       │
    │       ▼
    │   $verse->is_featured = !$verse->is_featured
    │       │
    │       ▼
    │   $verse->save()
    │       │
    │       ▼
    └──► Redirect back with success message
```

## CSV Import Flow

```
┌──────────────┐
│ Select CSV   │
└──────┬───────┘
       │
       ▼
┌──────────────┐
│ Upload File  │
└──────┬───────┘
       │
       ▼
┌──────────────────┐
│ Validate Format  │
└──────┬───────────┘
       │
       ▼
┌────────────────────┐
│ Parse CSV Rows     │
│ For each row:      │
│  • Validate data   │
│  • Check category  │
│  • Check duplicate │
│  • Create verse    │
└──────┬─────────────┘
       │
       ▼
┌──────────────────┐
│ Display Summary: │
│  • Imported: X   │
│  • Skipped: Y    │
│  • Errors: [...]  │
└──────────────────┘
```

---

**Built with Laravel 11, Tailwind CSS, and Blade Templates**
