@echo off
title Frizzly — Share with client
color 0A

echo.
echo  ============================================
echo   FRIZZLY — Starting local sharing setup
echo  ============================================
echo.

:: ── 1. Go to project root ────────────────────────────────────────────────────
cd /d "%~dp0"

:: ── 2. Clear all caches ──────────────────────────────────────────────────────
echo [1/5] Clearing caches...
php artisan config:clear >nul 2>&1
php artisan cache:clear  >nul 2>&1
php artisan route:clear  >nul 2>&1
php artisan view:clear   >nul 2>&1
echo       Done.

:: ── 3. Make sure storage link exists ────────────────────────────────────────
echo [2/5] Checking storage link...
php artisan storage:link >nul 2>&1
echo       Done.

:: ── 4. Start Laravel in a new window ─────────────────────────────────────────
echo [3/5] Starting Laravel server on port 8000...
start "Laravel Server" cmd /k "cd /d %~dp0 && php artisan serve --host=127.0.0.1 --port=8000"
timeout /t 2 /nobreak >nul

:: ── 5. Choose tunnel ─────────────────────────────────────────────────────────
echo [4/5] Choose your tunnel method:
echo.
echo   [1] ngrok  (requires free account + authtoken)
echo   [2] serveo (no account needed — works right now)
echo.
set /p CHOICE="Enter 1 or 2: "

if "%CHOICE%"=="1" goto NGROK
if "%CHOICE%"=="2" goto SERVEO

:NGROK
echo.
echo [5/5] Starting ngrok tunnel...
echo       Your public URL will appear below.
echo       Share the https://xxxxx.ngrok-free.app URL with your client.
echo.
start "ngrok Tunnel" cmd /k "ngrok http 8000"
echo.
echo  TIP: Open http://localhost:4040 in your browser to see the live URL.
goto END

:SERVEO
echo.
echo [5/5] Starting serveo tunnel...
echo       Your public URL will appear below (wait 5 seconds).
echo       Share the https://xxxxx.serveo.net URL with your client.
echo.
start "Serveo Tunnel" cmd /k "ssh -o StrictHostKeyChecking=no -R 80:localhost:8000 serveo.net"
goto END

:END
echo.
echo  ============================================
echo   All done! Check the new terminal windows.
echo  ============================================
echo.
pause
