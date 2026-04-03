@echo off
cd /d "c:/xampp/htdocs/ScolairesParcours/scolaire-parcour"
echo Clearing Laravel caches...
php artisan config:clear
php artisan cache:clear
php artisan view:clear
echo.
echo Test forgot password: http://localhost/scolairesparcours/scolaire-parcour/public/login
echo Click "Mot de passe oublie?"
echo.
echo Test in tinker: php artisan tinker then Mail::raw('test', fn($m)=^> $m-^>to('test@email.com')^);
pause

