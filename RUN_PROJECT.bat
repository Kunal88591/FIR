@echo off
title FIR System Launcher
color 0A

set PHP_PATH=%~dp0bin\php\php.exe

echo ===================================================
echo       FIR MANAGEMENT SYSTEM LAUNCHER
echo ===================================================
echo.

echo [1/3] Checking environment...
if not exist "%PHP_PATH%" (
    echo [ERROR] PHP is not found at %PHP_PATH%!
    echo Please check your WAMP installation.
    pause
    exit
)

echo [2/3] Starting PHP Server on port 8000...
echo.
echo ---------------------------------------------------
echo    Server is running at: http://localhost:8000
echo    Admin Panel: http://localhost:8000/admin
echo ---------------------------------------------------
echo.
echo [NOTE] Keep this window OPEN while using the app.
echo [NOTE] Make sure WAMP is running for the database!
echo.

start http://localhost:8000
"%PHP_PATH%" -S localhost:8000
pause
