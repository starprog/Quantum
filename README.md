# 🚀 Quantum - Modular Laravel Application Platform

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-11.x-red?style=for-the-badge&logo=laravel" alt="Laravel 11.x">
  <img src="https://img.shields.io/badge/PHP-8.2+-blue?style=for-the-badge&logo=php" alt="PHP 8.2+">
  <img src="https://img.shields.io/badge/MySQL-8.0+-orange?style=for-the-badge&logo=mysql" alt="MySQL 8.0+">
  <img src="https://img.shields.io/badge/License-MIT-green?style=for-the-badge" alt="MIT License">
</p>

<p align="center">
  <strong>A powerful, modular Laravel application with dynamic module loading, payment processing, and modern UI</strong>
</p>

## ✨ Features

### 🎯 Core Features
- **Modular Architecture** - Database-driven module system with hot-loading
- **Payment Processing** - Integrated Stripe checkout and payment handling
- **User Management** - Complete authentication with Laravel Jetstream
- **Modern UI** - Clean, responsive interface with Tailwind CSS
- **Admin Dashboard** - Module management and system administration

### 🔧 Module System
- **Dynamic Loading** - Modules loaded from database configuration
- **Hot Deployment** - Upload zip files for instant module installation
- **Isolated Architecture** - Completely separate module namespaces
- **Auto-Discovery** - Automatic scanning and registration of new modules
- **PSR-4 Autoloading** - Dynamic namespace registration

### 💳 Payment Integration
- **Stripe Integration** - Secure payment processing
- **Checkout Sessions** - One-click payment flows
- **Environment Configuration** - Easy API key management

## 🚀 Quick Start

### Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js & NPM
- MySQL 8.0+

### Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/starprog/Quantum.git
   cd Quantum
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configure database in `.env`**
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=quantum
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

5. **Configure Stripe (optional)**
   ```env
   STRIPE_KEY=pk_test_your_publishable_key
   STRIPE_SECRET=sk_test_your_secret_key
   ```

6. **Run migrations and seed**
   ```bash
   php artisan migrate
   php artisan db:seed --class=ModuleSeeder
   ```

7. **Build assets and serve**
   ```bash
   npm run build
   php artisan serve
   ```

Visit `http://localhost:8000` to see your application!

## 📱 User Interface

### Public Pages
- **Home** (`/`) - Landing page with feature overview
- **Services** (`/services`) - Available services showcase
- **Checkout** (`/checkout`) - Stripe payment demo

### Authenticated Pages
- **Dashboard** (`/dashboard`) - User dashboard
- **Settings** (`/settings`) - User preferences
- **Admin → Module Manager** - Module administration (admin only)

## 🔌 Module Development

### Module Structure
```
modules/YourModule/
├── module.php              # Module configuration
├── src/                   # PHP classes (PSR-4)
│   └── YourModuleServiceProvider.php
├── routes/
│   └── web.php           # Module routes
├── resources/
│   └── views/            # Module views
└── README.md             # Module documentation
```

### Creating a Module

1. **Module configuration** (`module.php`)
   ```php
   <?php
   return [
       'name' => 'your-module',
       'routes' => 'routes/web.php',
       'views' => 'resources/views',
       'autoload' => [
           'namespace' => 'Modules\\YourModule\\',
           'path' => 'src'
       ],
       'provider' => 'Modules\\YourModule\\YourModuleServiceProvider',
   ];
   ```

2. **Service Provider** (`src/YourModuleServiceProvider.php`)
   ```php
   <?php
   namespace Modules\YourModule;
   
   use Illuminate\Support\ServiceProvider;
   
   class YourModuleServiceProvider extends ServiceProvider
   {
       public function register(): void
       {
           // Register module services
       }
   
       public function boot(): void
       {
           // Boot module
       }
   }
   ```

3. **Routes** (`routes/web.php`)
   ```php
   <?php
   use Illuminate\Support\Facades\Route;
   
   Route::get('/your-module', function () {
       return view('your-module::index');
   });
   ```

### Installing Modules

#### Via Admin Interface
1. Login and navigate to **Admin → Module Manager**
2. Click **"Upload Module"**
3. Select your module zip file
4. Module is automatically extracted and registered
5. Enable the module with one click

#### Via Artisan Commands
```bash
# Scan for new modules
php artisan db:seed --class=ModuleSeeder

# Or manually add to database
```

## 🏗️ Architecture

### Technology Stack
- **Backend**: Laravel 11.x, PHP 8.2+
- **Frontend**: Livewire, Alpine.js, Tailwind CSS
- **Database**: MySQL 8.0+
- **Payments**: Stripe
- **Module System**: Custom PSR-4 autoloader

### Key Components
- **ModuleServiceProvider** - Core module loading system
- **Module Model** - Database representation of modules
- **ModuleController** - Admin interface for module management
- **Dynamic Autoloader** - Runtime PSR-4 namespace registration

## 🔧 Configuration

### Environment Variables
```env
# App Configuration
APP_NAME=Quantum
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=quantum
DB_USERNAME=root
DB_PASSWORD=

# Stripe Payment Processing
STRIPE_KEY=pk_test_your_key
STRIPE_SECRET=sk_test_your_secret
```

## 🤝 Contributing

We welcome contributions! Please see our [Contributing Guidelines](CONTRIBUTING.md) for details.

### Development Setup
1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🙋‍♂️ Support

- **Issues**: [GitHub Issues](https://github.com/starprog/Quantum/issues)
- **Discussions**: [GitHub Discussions](https://github.com/starprog/Quantum/discussions)

## 🌟 Acknowledgments

- Built with [Laravel](https://laravel.com/)
- UI powered by [Tailwind CSS](https://tailwindcss.com/)
- Authentication by [Laravel Jetstream](https://jetstream.laravel.com/)
- Payment processing by [Stripe](https://stripe.com/)

---

<p align="center">Made with ❤️ by the Quantum Team</p>

---

## 🎵 BPM Finder (Demo)

A simple in-app utility to load an audio file, display its embedded cover art, detect the track's estimated BPM, and play the track with a realtime background spectrum visualizer.

- **Route:** `GET /bpm` — visit this page after running the app.
- **UI:** Centered cover image, BPM display beneath the cover, file upload and play/pause controls, and a canvas-based spectrum background synced to playback.

### How to run the BPM demo locally (Windows `cmd.exe`)

1. Install frontend dependencies and start the Vite dev server:

```cmd
npm install
npm run dev
```

2. Start the Laravel app (if not already running):

```cmd
php artisan serve
```

3. Open your browser and visit:

```
http://127.0.0.1:8000/bpm
```

4. Use the page:
- Click the file chooser and select a local audio file (MP3, WAV, etc.).
- The page will attempt to extract embedded cover art and display it.
- The client-side BPM estimator will run and show an estimated BPM below the cover.
- Use Play/Pause to control playback; the background spectrum will sync to the audio.

### Notes & Troubleshooting

- BPM detection runs fully in the browser using the Web Audio API and a lightweight autocorrelation-on-onset algorithm; results vary by genre and audio clarity.
- Embedded cover extraction uses `jsmediatags` (loaded from CDN) and only works when artwork is embedded in the audio file's tags.
- Remote audio files served from other domains may fail due to CORS — use a local file upload or host files with appropriate CORS headers.
- If audio doesn't play automatically, click the page or press Play to resume the AudioContext (some browsers block autoplay).

### Next steps (optional)

- Improve BPM detection accuracy with a dedicated library or server-side analysis.
- Add server-side upload & persistence to support remote access and longer files.
- Add example demo files to `public/` for quick testing.

