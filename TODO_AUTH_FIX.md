# TODO: Fix Authentication - Matricule/Login Issues

**Status**: Approved plan - Implementing seeder fixes for proper matricule format

## Steps to Complete:

### 1. Fix Seeder Matricules (Generate proper format) ✅

- ✅ database/seeders/EleveSeeder.php: Fixed - uses Eleve::genererMatricule()
- ✅ database/seeders/EnseignantSeeder.php: Fixed - uses Enseignant::genererMatricule()
- ✅ database/seeders/ParentEleveSeeder.php: Confirmed - model auto-generates via boot()
- Expected: ELE-2024-M0001, ENS-2024-N0001, PAR-2024-I0001

### 2. Update DatabaseSeeder

- [ ] Ensure correct order: Roles → Users → Profiles → Link users
- [ ] Call UserSeeder last for re-linking

### 3. Test Data Generation

- [ ] php artisan migrate:fresh --seed
- [ ] Verify matricules in DB: SELECT matricule FROM eleves LIMIT 5;

### 4. Test Logins

```
Élève: ELE-2024-M0001 → /eleve/dashboard
Enseignant: ENS-2024-N0001 → /enseignant/dashboard
Parent: PAR-2024-I0001 → /parent/dashboard
Admin: admin@ecole.com / password → /admin/dashboard
```

### 5. Debug Dashboard Redirects

- [ ] tail -f storage/logs/laravel.log
- [ ] Look for DashboardController logs during login

### 6. Add Test Instructions to Views

- ✅ login.blade.php & admin-login.blade.php: Enhanced error display (test credentials removed)

### 7. Cleanup

- [ ] php artisan permission:cache-reset
- [ ] Mark complete ✅

**Current Progress**: ✅ Seeders fixed | Next: Test data generation
