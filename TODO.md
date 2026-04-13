# TODO - Fix users.role NULL Issue

## Plan approved ✅

**Étapes à compléter:**

### 1. Update UserSeeder.php [✅ DONE]

Ajouté `'role'` dans tous les `User::create()` (admin, enseignants, élèves, parents).

### 2. Run seeder [PENDING]

```bash
php artisan db:seed --class=UserSeeder
```

### 3. Verify database [PENDING]

```sql
SELECT id, name, email, role FROM users LIMIT 10;
```

### 4. Test API login [PENDING]

- Login avec compte seedé
- Vérifier `user.role` dans réponse JSON

### 5. Test mobile app [PENDING]

- Build & test sur émulateur/device

```

```
