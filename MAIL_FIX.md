# Gmail SMTP Fixed - Laravel ScolairesParcours

## Problem
```
Symfony\Component\Mailer\Exception\TransportException
535-5.7.8 Username and Password not accepted
```

## Root Cause
Gmail requires **App Password** (16 chars) when 2FA enabled.

## Solution Steps

### Step 1: Generate App Password
1. https://myaccount.google.com/security → **2-Step Verification** → **ON**
2. **App passwords** → **Mail** → **Generate**
3. **Copy 16-char code** (e.g. `abcdwxyz1234ABCD`)

### Step 2: .env Config (EXACT)
```
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=fortune.email@gmail.com
MAIL_PASSWORD=abcdwxyz1234ABCD
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=fortune.email@gmail.com
MAIL_FROM_NAME="ScolairesParcours"
```

### Step 3: Clear Cache
```bash
cd c:/xampp/htdocs/ScolairesParcours/scolaire-parcour
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

### Step 4: Test
- Login → **Mot de passe oublié?**
- Or `php artisan tinker` → `Mail::raw('test', fn($m) => $m->to('test@email.com'));`

## Verify Working
✅ Port 587 + TLS  
✅ App Password (not account password)  
✅ Config cache cleared  

**Done! Mailer works.**

**Save this file & follow steps exactly.**
