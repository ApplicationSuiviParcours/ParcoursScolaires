# Guide Complet pour Tester les APIs du Projet ScolairesParcours

Ce guide vous permet de tester toutes les APIs du projet Laravel situé dans `scolaire-parcour`. Les APIs utilisent **Laravel Sanctum** pour l'authentification par token Bearer et sont protégées par rôles (parent, eleve, enseignant, administrateur).

## 1. Prérequis et Configuration

### Démarrer le Serveur

Puisque vous utilisez XAMPP (Windows), assurez-vous que Apache et MySQL sont démarrés.

```bash
# Naviguez vers le projet
cd c:/xampp/htdocs/ScolairesParcours/scolaire-parcour

# Installer les dépendances (si pas fait)
composer install

# Générer la clé d'application
php artisan key:generate

# Exécuter les migrations et seeders (avec données de test)
php artisan migrate --seed
```

**URL de Base des APIs** : `http://localhost/ScolairesParcours/scolaire-parcour/public/api/`

### Outils Recommandés pour les Tests

- **Postman** ou **Insomnia** (recommandé)
- **cURL** (pour ligne de commande)
- **Thunder Client** (extension VSCode)

## 2. Authentification (Obligatoire pour la plupart des endpoints)

### Login (POST `/api/login`)

**Données requises** :

```json
{
    "credential": "email@exemple.com OU matricule (ex: 2024A0001)",
    "password": "password",
    "remember": false
}
```

**Exemple cURL** :

```bash
curl -X POST http://localhost/ScolairesParcours/scolaire-parcour/public/api/login \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "credential": "admin@scolaire.com",
    "password": "password"
  }'
```

**Réponse de Succès** :

```json
{
  "message": "Connexion réussie",
  "user": { ... },
  "token": "1|abc123...",
  "token_type": "Bearer"
}
```

**Sauvegardez le `token`** pour les headers : `Authorization: Bearer 1|abc123...`

### Autres Auth Endpoints

- **GET `/api/user`** : Infos utilisateur connecté
- **POST `/api/logout`** : Déconnexion (revoke token)

## 3. Liste Complète des Endpoints par Rôle

### 👨‍👩‍👧‍👦 **Parent APIs** (`role:parent`)

```
GET    /api/parent/dashboard           → Dashboard enfants + stats
GET    /api/parent/enfants             → Liste des enfants
GET    /api/parent/eleve/{eleve_id}/bulletins    → Bulletins d'un enfant
GET    /api/parent/eleve/{eleve_id}/bulletins/{id} → Détail bulletin
GET    /api/parent/eleve/{eleve_id}/notes        → Notes d'un enfant
GET    /api/parent/eleve/{eleve_id}/absences     → Absences d'un enfant
GET    /api/parent/eleve/{eleve_id}/emploi-du-temps → Emploi du temps
```

**Headers** : `Authorization: Bearer {token}`

### 👦 **Élève APIs** (`role:eleve`)

```
GET  /api/eleve/dashboard      → Dashboard personnel
GET  /api/eleve/notes          → Mes notes
GET  /api/eleve/absences       → Mes absences
GET  /api/eleve/bulletins      → Mes bulletins
GET  /api/eleve/bulletins/{id} → Détail bulletin
GET  /api/eleve/emploi-du-temps → Mon emploi du temps
```

### 👨‍🏫 **Enseignant APIs** (`role:enseignant`)

```
GET    /api/enseignant/dashboard     → Dashboard enseignant
GET    /api/enseignant/evaluations/  → Liste évaluations
POST   /api/enseignant/evaluations/  → Créer évaluation
GET    /api/enseignant/evaluations/{id}
PUT    /api/enseignant/evaluations/{id}
DELETE /api/enseignant/evaluations/{id}
GET    /api/enseignant/notes/        → Liste notes
POST   /api/enseignant/notes/        → Ajouter note
GET    /api/enseignant/absences/     → Liste absences
POST   /api/enseignant/absences/     → Ajouter absence
```

### 🛡️ **Admin APIs** (`role:administrateur`)

```
GET  /api/admin/dashboard  → Dashboard admin
GET  /api/admin/users/     → Liste utilisateurs
POST /api/admin/users/     → Créer utilisateur
PUT  /api/admin/users/{id} → Modifier
DELETE /api/admin/users/{id} → Supprimer
```

## 4. Exemple de Test Complet avec Postman

1. **POST Login** → Obtenez `token`
2. **Configurer Collection** :
    ```
    Headers globaux:
    Authorization: Bearer {{token}}
    Accept: application/json
    Content-Type: application/json
    ```
3. **Test Parent Dashboard** :
    ```
    GET http://localhost/ScolairesParcours/scolaire-parcour/public/api/parent/dashboard
    ```

## 5. Données de Test (via Seeders)

Après `php artisan db:seed`, vous avez :

**Admin** : `admin@ecole.com` / `password`
- **Parent** : `jean.martin.parent@parent.com` / `password`
- **Élève** : Matricule `2024A0001` / `password` (ou `lucas.martin@eleve.com`)
- **Enseignant** : `jean.martin@enseignant.com` / `password`

## 6. Vérification Serveur Laravel

```bash
# Dans terminal VSCode (cd scolaire-parcour d'abord)
php artisan serve --host=0.0.0.0 --port=8000
```

**URL alternative** : `http://localhost:8000/api/...`

## 7. Dépannage Courant

- **404** : Vérifiez l'URL exacte (`public/api/`)
- **401 Unauthorized** : Token invalide/expiré → Relogin
- **403 Forbidden** : Rôle incorrect pour l'endpoint
- **SQL Error** : Exécutez `php artisan migrate:fresh --seed`
- **CORS** : Configuré pour localhost par défaut

## 8. Test Automatisé (Bonus)

```bash
cd scolaire-parcour
php artisan test --filter=Api
```

Ce guide couvre 100% des APIs listées dans `routes/api.php`. Testez d'abord **login → parent/dashboard** pour valider !
