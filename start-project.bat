@echo off
setlocal

set "PROJECT_ROOT=%~dp0"
if "%PROJECT_ROOT:~-1%"=="\" set "PROJECT_ROOT=%PROJECT_ROOT:~0,-1%"

set "PHP_EXE="
where php >nul 2>nul
if %errorlevel%==0 (
    set "PHP_EXE=php"
) else if exist "C:\Users\Admin\AppData\Local\Microsoft\WinGet\Packages\PHP.PHP.8.4_Microsoft.Winget.Source_8wekyb3d8bbwe\php.exe" (
    set "PHP_EXE=C:\Users\Admin\AppData\Local\Microsoft\WinGet\Packages\PHP.PHP.8.4_Microsoft.Winget.Source_8wekyb3d8bbwe\php.exe"
)

if not defined PHP_EXE (
    echo PHP was not found. Install PHP or add php.exe to PATH first.
    pause
    exit /b 1
)

powershell -NoProfile -Command "try { $client = New-Object Net.Sockets.TcpClient('127.0.0.1', 8000); $client.Close(); exit 0 } catch { exit 1 }"
if %errorlevel%==0 (
    echo PHP server already running on http://127.0.0.1:8000
    start "" "http://127.0.0.1:8000/HTML/HomePages/index.html"
    exit /b 0
)

echo Starting DragonGod project server...
start "DragonGod PHP Server" powershell -NoExit -Command "Set-Location -LiteralPath '%PROJECT_ROOT%'; & '%PHP_EXE%' -S 127.0.0.1:8000"
timeout /t 2 /nobreak >nul
start "" "http://127.0.0.1:8000/HTML/HomePages/index.html"

echo Project opened at http://127.0.0.1:8000/HTML/HomePages/index.html
echo Close the "DragonGod PHP Server" window to stop the server.

endlocal