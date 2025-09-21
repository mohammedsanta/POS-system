@echo off
REM --- change this to your Laravel path ---
cd /d "%~dp0"

REM start built-in PHP server
start "" php artisan serve

REM give server a few seconds to boot
timeout /t 3 >nul

REM open the default browser
start "" http://127.0.0.1:8000
