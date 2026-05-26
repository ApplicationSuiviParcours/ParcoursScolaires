<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votre compte Scolaire Parcours</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Arial, sans-serif; background-color: #f0f4f8; color: #1e293b; }
        .wrapper { max-width: 600px; margin: 40px auto; background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.08); }

        /* Header */
        .header { background: linear-gradient(135deg, #1e3a8a 0%, #1d4ed8 100%); padding: 40px 32px; text-align: center; }
        .header .logo { font-size: 28px; font-weight: 800; color: #ffffff; letter-spacing: -0.5px; }
        .header .logo span { color: #fbbf24; }
        .header .subtitle { color: #93c5fd; font-size: 14px; margin-top: 6px; }

        /* Badge rôle */
        .role-badge { display: inline-block; margin-top: 16px; padding: 6px 18px; background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.3); border-radius: 50px; color: #ffffff; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; }

        /* Body */
        .body { padding: 40px 32px; }
        .greeting { font-size: 22px; font-weight: 700; color: #1e3a8a; margin-bottom: 12px; }
        .intro { font-size: 15px; color: #475569; line-height: 1.7; margin-bottom: 28px; }

        /* Credentials box */
        .credentials-box { background: linear-gradient(135deg, #eff6ff 0%, #f0f9ff 100%); border: 2px solid #bfdbfe; border-radius: 12px; padding: 24px; margin-bottom: 28px; }
        .credentials-box h3 { font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #1d4ed8; margin-bottom: 16px; }
        .cred-item { display: flex; align-items: center; margin-bottom: 14px; }
        .cred-item:last-child { margin-bottom: 0; }
        .cred-label { font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; width: 120px; flex-shrink: 0; }
        .cred-value { font-size: 15px; font-weight: 700; color: #0f172a; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 8px 14px; flex: 1; word-break: break-all; }
        .cred-value.password { color: #dc2626; font-family: 'Courier New', monospace; font-size: 17px; letter-spacing: 2px; border-color: #fca5a5; background: #fff5f5; }

        /* CTA Button */
        .cta-wrapper { text-align: center; margin-bottom: 28px; }
        .cta-btn { display: inline-block; padding: 14px 36px; background: linear-gradient(135deg, #1e3a8a 0%, #1d4ed8 100%); color: #ffffff; font-size: 15px; font-weight: 700; text-decoration: none; border-radius: 10px; letter-spacing: 0.3px; }

        /* Warning */
        .warning-box { background: #fffbeb; border: 1px solid #fcd34d; border-radius: 10px; padding: 16px 20px; margin-bottom: 28px; display: flex; align-items: flex-start; gap: 12px; }
        .warning-icon { font-size: 20px; flex-shrink: 0; margin-top: 2px; }
        .warning-text { font-size: 13px; color: #92400e; line-height: 1.6; }
        .warning-text strong { color: #78350f; }

        /* Info items */
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 28px; }
        .info-item { background: #f8fafc; border-radius: 10px; padding: 14px 16px; border: 1px solid #e2e8f0; }
        .info-item-label { font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px; }
        .info-item-value { font-size: 14px; font-weight: 600; color: #334155; }

        /* Footer */
        .footer { background: #f8fafc; padding: 24px 32px; text-align: center; border-top: 1px solid #e2e8f0; }
        .footer p { font-size: 12px; color: #94a3b8; line-height: 1.6; }
        .footer .school-name { font-weight: 700; color: #1e3a8a; }
        .divider { height: 1px; background: #e2e8f0; margin: 20px 0; }
    </style>
</head>
<body>
<div class="wrapper">

    {{-- Header --}}
    <div class="header">
        <div class="logo">Scolaire<span>Parcours</span></div>
        <div class="subtitle">Système de Gestion Scolaire</div>
        <div class="role-badge">
            @if($role === 'eleve') 🎓 Élève
            @elseif($role === 'enseignant') 📚 Enseignant
            @elseif($role === 'parent') 👨‍👩‍👧 Parent
            @else {{ ucfirst($role) }}
            @endif
        </div>
    </div>

    {{-- Body --}}
    <div class="body">
        <div class="greeting">Bonjour, {{ $nomComplet }} !</div>
        <p class="intro">
            Votre compte sur la plateforme <strong>Scolaire Parcours</strong> vient d'être créé par l'administration.
            Vous trouverez ci-dessous vos identifiants de connexion. Veuillez les conserver précieusement.
        </p>

        {{-- Credentials --}}
        <div class="credentials-box">
            <h3>🔐 Vos identifiants de connexion</h3>
            <div class="cred-item">
                <span class="cred-label">Matricule</span>
                <span class="cred-value">{{ $matricule }}</span>
            </div>
            <div class="cred-item">
                <span class="cred-label">Email</span>
                <span class="cred-value">{{ $email }}</span>
            </div>
            <div class="cred-item">
                <span class="cred-label">Mot de passe</span>
                <span class="cred-value password">{{ $motDePasse }}</span>
            </div>
        </div>

        {{-- Info grid --}}
        <div class="info-grid">
            <div class="info-item">
                <div class="info-item-label">Nom complet</div>
                <div class="info-item-value">{{ $nomComplet }}</div>
            </div>
            <div class="info-item">
                <div class="info-item-label">Rôle</div>
                <div class="info-item-value">
                    @if($role === 'eleve') Élève
                    @elseif($role === 'enseignant') Enseignant
                    @elseif($role === 'parent') Parent d'élève
                    @else {{ ucfirst($role) }}
                    @endif
                </div>
            </div>
        </div>

        {{-- CTA --}}
        <div class="cta-wrapper">
            <a href="{{ url('/login') }}" class="cta-btn">Se connecter à la plateforme →</a>
        </div>

        {{-- Warning --}}
        <div class="warning-box">
            <span class="warning-icon">⚠️</span>
            <div class="warning-text">
                <strong>Important :</strong> Pour la sécurité de votre compte, nous vous recommandons vivement de
                <strong>changer votre mot de passe</strong> dès votre première connexion depuis les paramètres de votre profil.
                Ne partagez jamais ce mot de passe avec qui que ce soit.
            </div>
        </div>

        <div class="divider"></div>
        <p style="font-size:13px; color:#64748b; line-height:1.7;">
            Si vous n'êtes pas à l'origine de cette demande ou si vous pensez avoir reçu cet email par erreur,
            veuillez contacter l'administration de votre établissement.
        </p>
    </div>

    {{-- Footer --}}
    <div class="footer">
        <p>
            Cet email a été envoyé automatiquement par la plateforme<br>
            <span class="school-name">Scolaire Parcours</span> — Système de Gestion Scolaire<br>
            © {{ date('Y') }} — Ne pas répondre à cet email.
        </p>
    </div>

</div>
</body>
</html>
