# TODO: Fix Absences Seeder Error

## Steps to complete:

- [x] Step 1: Create migration `add_duree_jours_observation_to_absences_table`
- [x] Step 2: Update `app/Models/Absence.php` - add fillable and casts
- [x] Step 3: Update `database/seeders/AbsenceSeeder.php` - fix date format, add heures
- [x] Step 4: Run `php artisan migrate`
- [x] Step 5: Run `php artisan db:seed --class=AbsenceSeeder`
- [ ] Step 6: Verify in tinker or admin panel
- [ ] Step 7: Update this TODO with completion

Status: Fixed absences. Now fixing bulletins error with new migration for `appreciation_generale`. Run `cd scolaire-parcour && php artisan migrate` then `php artisan db:seed --class=BulletinSeeder` manually.
