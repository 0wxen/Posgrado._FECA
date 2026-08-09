# Carga las variables de conexión desde php/.env en la sesión actual de PowerShell.
# Uso (parado en la carpeta php/): . .\tools\cargar_env.ps1
$envPath = Join-Path $PSScriptRoot '..\.env'
if (-not (Test-Path $envPath)) {
    Write-Host "No existe $envPath -- créalo con PGHOST/PGPORT/PGDATABASE/PGUSER/PGPASSWORD." -ForegroundColor Yellow
    return
}
Get-Content $envPath | ForEach-Object {
    if ($_ -match '^\s*([A-Z_]+)\s*=\s*(.*)\s*$') {
        Set-Item -Path "env:$($Matches[1])" -Value $Matches[2]
    }
}
Write-Host "Variables de conexión cargadas (PGDATABASE=$env:PGDATABASE)." -ForegroundColor Green
