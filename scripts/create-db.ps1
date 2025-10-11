<#
Create MySQL database for Quantum via mysql CLI.
Run this script from an Administrator PowerShell in the project root.
This will run a CREATE DATABASE IF NOT EXISTS ... statement. If you don't have mysql in PATH, use the PHP script (create-db.php) instead.
#>
param(
    [string]$DbName = "quantum",
    [string]$DbHost = "127.0.0.1",
    [int]$DbPort = 3306,
    [string]$DbUser = "root",
    [string]$DbPassword = ""
)

function Write-Info($m) { Write-Host "[INFO]  $m" -ForegroundColor Cyan }
function Write-Err($m) { Write-Host "[ERROR] $m" -ForegroundColor Red }

Write-Info "Create database: ${DbName} on ${DbHost}:${DbPort} as ${DbUser}"

# Check mysql CLI
$mysql = Get-Command mysql -ErrorAction SilentlyContinue
if (-not $mysql) {
    Write-Err "mysql CLI not found in PATH. Please install MySQL client or use php scripts/create-db.php instead."
    exit 2
}

# Build the command. Warning: passing password on CLI can expose it in process list.
if ($DbPassword -ne "") {
    # Passing password on CLI is insecure (visible in process list). Use with care.
    $pwArg = "-p$DbPassword"
} else {
    # Using -p without value will make mysql prompt for password interactively.
    $pwArg = "-p"
}

$cmdArgs = @('-h', $DbHost, '-P', $DbPort.ToString(), '-u', $DbUser, $pwArg, '-e', "CREATE DATABASE IF NOT EXISTS `${DbName}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;")
Write-Info "Running mysql with args: ${($cmdArgs -join ' ')}"

try {
    $proc = Start-Process -FilePath "mysql" -ArgumentList $cmdArgs -NoNewWindow -Wait -PassThru -ErrorAction Stop
    if ($proc.ExitCode -eq 0) {
        Write-Info "Database '${DbName}' created or already exists."
        exit 0
    } else {
        Write-Err "mysql returned exit code $($proc.ExitCode)"
        exit $proc.ExitCode
    }
} catch {
    Write-Err $_.Exception.Message
    exit 1
}
