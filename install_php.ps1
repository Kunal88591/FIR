$url = "https://windows.php.net/downloads/releases/php-8.2.29-Win32-vs16-x64.zip"
$zipPath = "bin\php.zip"
$destPath = "bin\php"

if (-not (Test-Path "bin")) {
    New-Item -ItemType Directory -Path "bin" | Out-Null
}

echo "Downloading PHP..."
Invoke-WebRequest -Uri $url -OutFile $zipPath

echo "Extracting PHP..."
Expand-Archive -Path $zipPath -DestinationPath $destPath -Force

echo "Cleaning up..."
Remove-Item $zipPath

echo "Done."
