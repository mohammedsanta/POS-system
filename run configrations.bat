@echo off
REM === Change this to your Laravel project path if needed ===
cd /d "%~dp0"

echo =========================================
echo  Creating database tables and seeding data ...
echo =========================================

REM Run migrations with seeding
php artisan migrate --seed

if %errorlevel% neq 0 (
    echo.
    echo [ERROR] Migration or seeding failed!
    echo Please check the errors above.
    pause
    exit /b %errorlevel%
)

echo.
echo =========================================
echo  Database migrated and seeded successfully!
echo =========================================
pause
