@echo off
REM Scripts de test exacts pour APIs ScolairesParcours
REM Exécutez depuis C:\xampp\htdocs\ScolairesParcours\scolaire-parcour

echo ========================================
echo TEST API - LOGIN ADMIN
echo ========================================
curl -X POST http://localhost/ScolairesParcours/scolaire-parcour/public/api/login ^
  -H "Content-Type: application/json" ^
  -H "Accept: application/json" ^
  -d "{\"credential\": \"admin@ecole.com\", \"password\": \"password\"}"

echo.
echo ========================================
echo TEST API - PARENT DASHBOARD (après login manuel)
echo ========================================
REM Remplacez VOTRE_TOKEN_ICI par le token obtenu
curl -X GET "http://localhost/ScolairesParcours/scolaire-parcour/public/api/parent/dashboard" ^
  -H "Authorization: Bearer VOTRE_TOKEN_ICI" ^
  -H "Accept: application/json"

echo.
echo ========================================
echo TEST API - ELEVE NOTES (avec matricule)
echo ========================================
REM Login eleve d'abord, puis:
curl -X GET "http://localhost/ScolairesParcours/scolaire-parcour/public/api/eleve/notes" ^
  -H "Authorization: Bearer ELEVE_TOKEN_ICI" ^
  -H "Accept: application/json"

pause
