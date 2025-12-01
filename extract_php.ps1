$zipPath = "bin\php.zip"
$destPath = "bin\php"

if (-not (Test-Path $zipPath)) {
    echo "Error: php.zip not found!"
    exit
}

echo "Extracting PHP..."
Expand-Archive -Path $zipPath -DestinationPath $destPath -Force

echo "Done."
