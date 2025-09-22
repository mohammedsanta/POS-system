@echo off
REM --- Change this to your Laravel project path if needed ---
cd /d "%~dp0"

REM Check if something already listens on port 8000
netstat -ano | findstr ":8000" | findstr "LISTENING" >nul
if %errorlevel%==0 (
    echo ********************************************
    echo Laravel server is already running on port 8000.
    echo ********************************************
    goto open_browser
)

REM Start built-in PHP server
start "" php artisan serve

REM Give server a few seconds to boot
timeout /t 3 >nul

:open_browser
REM Open the browser directly on /home
start "" http://127.0.0.1:8000/home
