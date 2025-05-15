@echo off
echo Creating admin user...

REM Set the path to XAMPP's MySQL executable
set MYSQL_PATH=C:\xampp\mysql\bin\mysql.exe

REM The password 'admin' hashed with SHA-1 is 'd033e22ae348aeb5660fc2140aec35850c4da997'
"%MYSQL_PATH%" -u root -e "USE shop_db; INSERT INTO admins (name, password) VALUES ('admin', 'd033e22ae348aeb5660fc2140aec35850c4da997') ON DUPLICATE KEY UPDATE password='d033e22ae348aeb5660fc2140aec35850c4da997';"

if %ERRORLEVEL% EQU 0 (
    echo Admin user created successfully!
    echo Username: admin
    echo Password: admin
) else (
    echo Error creating admin user!
    echo Please make sure:
    echo 1. XAMPP is installed in C:\xampp
    echo 2. MySQL service is running in XAMPP Control Panel
    echo 3. The shop_db database exists
)

pause 