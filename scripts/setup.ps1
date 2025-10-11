<#
PowerShell setup script for Quantum Laravel app (Windows / XAMPP)
Run this from the repository root in an elevated PowerShell (Run as Administrator) when necessary.
#>

param(
    [switch]$SkipComposer,
    [switch]$SkipNpm,
    [switch]$SkipMigrate,
    [switch]$Dev
)

function Write-Info($msg) { Write-Host "[INFO]  $msg" -ForegroundColor Cyan }
function Write-Warn($msg) { Write-Host "[WARN]  $msg" -ForegroundColor Yellow }
function Write-Err($msg) { Write-Host "[ERROR] $msg" -ForegroundColor Red }

Write-Info "Running Quantum setup script"

# Check for composer
if (-not $SkipComposer) {
    Write-Info "Checking for Composer..."
    $composer = Get-Command composer -ErrorAction SilentlyContinue
    if (-not $composer) {
        Write-Warn "Composer not found in PATH. You can install Composer or run the required commands manually."
        $choice = Read-Host "Continue without running composer install? (y/N)"
        if ($choice -ne 'y') { Write-Err "Aborting."; exit 1 }
    } else {
        Write-Info "Running: composer install"
        composer install
        if ($LASTEXITCODE -ne 0) { Write-Err "composer install failed (exit $LASTEXITCODE)."; exit $LASTEXITCODE }
    }
}

# NPM install
if (-not $SkipNpm) {
    Write-Info "Checking for npm..."
    $npm = Get-Command npm -ErrorAction SilentlyContinue
    if (-not $npm) {
        Write-Warn "npm not found in PATH. Skip or install Node/npm."
        $choice = Read-Host "Continue without running npm install? (y/N)"
        if ($choice -ne 'y') { Write-Err "Aborting."; exit 1 }
    } else {
        Write-Info "Running: npm install"
        npm install
        if ($LASTEXITCODE -ne 0) { Write-Err "npm install failed (exit $LASTEXITCODE)."; exit $LASTEXITCODE }
    }
}

# Copy .env if missing
if (-not (Test-Path .env)) {
    if (Test-Path .env.example) {
        Write-Info "Creating .env from .env.example"
        copy .env.example .env | Out-Null
    } else {
        Write-Warn ".env.example not found — create a .env file manually."
    }
} else {
    Write-Info ".env already exists — leaving it in place."
}

# Generate app key
Write-Info "Generating APP key (php artisan key:generate)"
php artisan key:generate
if ($LASTEXITCODE -ne 0) { Write-Warn "key:generate returned exit code $LASTEXITCODE — continue if you already have an APP_KEY." }

# Run migrations
if (-not $SkipMigrate) {
    $migrateChoice = Read-Host "Run migrations and seeders now? (y/N)"
    if ($migrateChoice -eq 'y') {
        Write-Info "Running: php artisan migrate --seed"
        php artisan migrate --seed
        if ($LASTEXITCODE -ne 0) { Write-Err "migrate failed (exit $LASTEXITCODE). Check DB settings in .env."; exit $LASTEXITCODE }
    } else {
        Write-Info "Skipping migrations."
    }
}

# Build assets
if ($Dev) {
    Write-Info "Starting dev asset build: npm run dev"
    npm run dev
} else {
    $buildChoice = Read-Host "Run production asset build (npm run build)? (y/N)"
    if ($buildChoice -eq 'y') {
        Write-Info "Running: npm run build"
        npm run build
        if ($LASTEXITCODE -ne 0) { Write-Err "npm run build failed (exit $LASTEXITCODE)."; exit $LASTEXITCODE }
    } else {
        Write-Info "Skipping asset build. Use 'npm run dev' or 'npm run build' later as needed."
    }
}

Write-Info "Clearing and warming caches"
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan optimize:clear

Write-Info "Setup complete. Next steps:"
Write-Host " - If using XAMPP, ensure the vhost is configured and Apache restarted."
Write-Host " - To run the app: php artisan serve --host=127.0.0.1 --port=8000 or open http://quantum.test after configuring hosts and vhost."

exit 0
