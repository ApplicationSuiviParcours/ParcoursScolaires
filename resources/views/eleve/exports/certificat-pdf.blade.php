<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Certificat de Réussite - {{ $eleve->nom_complet }}</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 0;
        }
        html, body {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            background-color: #ffffff;
            font-family: 'Times New Roman', Georgia, serif;
            color: #0f172a;
        }
        /* Cadre extérieur double élégant */
        .certificate-border {
            position: absolute;
            top: 20px;
            left: 20px;
            right: 20px;
            bottom: 20px;
            border: 6px double #ca8a04; /* Couleur Or */
            padding: 3px;
            box-sizing: border-box;
        }
        .certificate-inner-border {
            border: 2px solid #1e293b; /* Gris-bleu très foncé */
            height: 100%;
            box-sizing: border-box;
            position: relative;
            padding: 30px 50px;
        }
        /* Ornements de coin */
        .corner-ornament-tl {
            position: absolute;
            top: 10px;
            left: 10px;
            width: 25px;
            height: 25px;
            border-top: 3px solid #ca8a04;
            border-left: 3px solid #ca8a04;
        }
        .corner-ornament-tr {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 25px;
            height: 25px;
            border-top: 3px solid #ca8a04;
            border-right: 3px solid #ca8a04;
        }
        .corner-ornament-bl {
            position: absolute;
            bottom: 10px;
            left: 10px;
            width: 25px;
            height: 25px;
            border-bottom: 3px solid #ca8a04;
            border-left: 3px solid #ca8a04;
        }
        .corner-ornament-br {
            position: absolute;
            bottom: 10px;
            right: 10px;
            width: 25px;
            height: 25px;
            border-bottom: 3px solid #ca8a04;
            border-right: 3px solid #ca8a04;
        }
        /* En-tête */
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .republique {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-weight: bold;
            color: #475569;
            margin: 0;
        }
        .ministere {
            font-size: 8px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #64748b;
            margin-top: 2px;
            margin-bottom: 10px;
        }
        .school-name {
            font-size: 24px;
            font-weight: bold;
            color: #1e293b;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            margin: 3px 0;
        }
        .school-tagline {
            font-size: 9px;
            font-style: italic;
            color: #ca8a04;
            margin: 0;
            letter-spacing: 1px;
        }
        /* Corps du Certificat */
        .title-container {
            text-align: center;
            margin-bottom: 20px;
        }
        .title {
            font-size: 34px;
            font-weight: bold;
            color: #ca8a04;
            text-transform: uppercase;
            letter-spacing: 3px;
            margin: 0;
        }
        .subtitle {
            font-size: 12px;
            font-style: italic;
            color: #475569;
            margin-top: 3px;
            letter-spacing: 1px;
        }
        .certify-text {
            text-align: center;
            font-size: 15px;
            line-height: 1.7;
            margin: 0 auto;
            max-width: 720px;
            color: #334155;
        }
        .student-name {
            font-size: 22px;
            font-weight: bold;
            color: #1e293b;
            border-bottom: 1px dashed #cbd5e1;
            padding-bottom: 2px;
            margin: 5px 0;
            display: inline-block;
            letter-spacing: 0.5px;
        }
        .highlight {
            font-weight: bold;
            color: #1e293b;
        }
        .decision-badge {
            font-size: 18px;
            font-weight: bold;
            color: #16a34a; /* Vert admis */
            letter-spacing: 1.5px;
            text-transform: uppercase;
            margin: 8px 0;
        }
        /* Bas de page / Signatures */
        .footer-table {
            width: 100%;
            margin-top: 35px;
            border-collapse: collapse;
        }
        .footer-cell {
            width: 33.33%;
            vertical-align: top;
            text-align: center;
        }
        .signature-title {
            font-size: 12px;
            font-weight: bold;
            color: #475569;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 50px;
        }
        .signature-name {
            font-size: 11px;
            font-weight: bold;
            color: #1e293b;
            line-height: 1.4;
        }
        .signature-line {
            width: 130px;
            border-bottom: 1px solid #cbd5e1;
            margin: 8px auto;
        }
        .metadata {
            position: absolute;
            bottom: 10px;
            left: 30px;
            font-size: 8px;
            color: #94a3b8;
        }
    </style>
</head>
<body>
    <div class="certificate-border">
        <div class="certificate-inner-border">
            <!-- Ornements de coins -->
            <div class="corner-ornament-tl"></div>
            <div class="corner-ornament-tr"></div>
            <div class="corner-ornament-bl"></div>
            <div class="corner-ornament-br"></div>

            <!-- En-tête de l'établissement -->
            <div class="header">
                <div class="republique">République du Congo</div>
                <div class="ministere">Ministère de l'Enseignement Primaire, Secondary et de l'Alphabétisation</div>
                <div class="school-name">GROUPE SCOLAIRE LE MARIGOT V.F</div>
                <div class="school-tagline">Excellence - Discipline - Succès</div>
            </div>

            <!-- Titre du Certificat -->
            <div class="title-container">
                <h1 class="title">Certificat de Réussite</h1>
                <div class="subtitle">Attestation Officielle de Fin de Cycle Annuel</div>
            </div>

            <!-- Corps du texte -->
            <div class="certify-text">
                Le Conseil d'Administration et la Direction du Groupe Scolaire Le Marigot V.F,<br>
                certifient solennellement par la présente que l'élève :<br>
                <div class="student-name">{{ $eleve->nom_complet }}</div><br>
                Né(e) le <span class="highlight">{{ $eleve->date_naissance->format('d/m/Y') }}</span> à <span class="highlight">{{ $eleve->lieu_naissance }}</span>, titulaire du matricule <span class="highlight">{{ $eleve->matricule }}</span>,<br>
                a suivi avec assiduité les enseignements prescrits pour la classe de :<br>
                <span class="highlight" style="font-size: 17px; color: #ca8a04;">{{ $inscription->classe->nom }}</span><br>
                au cours de l'année scolaire <span class="highlight">{{ $anneeScolaire->nom }}</span>.<br>
                Ayant obtenu une Moyenne Générale Annuelle de <span class="highlight" style="font-size: 16px;">{{ number_format($moyenneAnnee, 2) }}/20</span>,<br>
                l'élève est déclaré(e) officiellement :
                <div class="decision-badge">Admis(e) en classe supérieure</div>
                avec la mention <span class="highlight" style="font-style: italic;">{{ $mention }}</span>.
            </div>

            <!-- Signatures et Sceau -->
            <table class="footer-table">
                <tr>
                    <td class="footer-cell">
                        <div class="signature-title">Le Secrétaire Général</div>
                        <div class="signature-line"></div>
                        <div class="signature-name">Jean-Baptiste MPOUET</div>
                    </td>
                    <td class="footer-cell" style="vertical-align: middle;">
                        <!-- Médaille d'or vectorielle SVG haut de gamme -->
                        <svg width="80" height="110" viewBox="0 0 100 130" style="display: block; margin: 0 auto;">
                            <defs>
                                <linearGradient id="goldGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#fde047" />
                                    <stop offset="50%" stop-color="#eab308" />
                                    <stop offset="100%" stop-color="#854d0e" />
                                </linearGradient>
                            </defs>
                            <!-- Rubans arrières -->
                            <path d="M35 80 L20 130 L40 120 L50 90 Z" fill="#854d0e" />
                            <path d="M65 80 L80 130 L60 120 L50 90 Z" fill="#854d0e" />
                            <path d="M35 80 L20 130 L40 120 L50 90 Z" fill="#eab308" opacity="0.8" />
                            <path d="M65 80 L80 130 L60 120 L50 90 Z" fill="#eab308" opacity="0.8" />
                            <!-- Médaille -->
                            <polygon points="50,5 64,18 82,18 88,35 100,50 88,65 82,82 64,82 50,95 36,82 18,82 12,65 0,50 12,35 18,18 36,18" fill="#ca8a04" stroke="#854d0e" stroke-width="1" />
                            <circle cx="50" cy="50" r="35" fill="url(#goldGradient)" stroke="#ffffff" stroke-width="1.5" />
                            <circle cx="50" cy="50" r="31" fill="none" stroke="#854d0e" stroke-width="1" stroke-dasharray="2,2" />
                            <text x="50" y="44" font-family="'Times New Roman', serif" font-size="7" font-weight="bold" fill="#ffffff" text-anchor="middle">LE MARIGOT</text>
                            <text x="50" y="54" font-family="'Times New Roman', serif" font-size="8" font-weight="bold" fill="#ffffff" text-anchor="middle">V.F</text>
                            <text x="50" y="64" font-family="'Times New Roman', serif" font-size="5" font-weight="bold" fill="#ffffff" text-anchor="middle">★ EXCELLENCE ★</text>
                        </svg>
                    </td>
                    <td class="footer-cell">
                        <div class="signature-title">Le Directeur Général</div>
                        <div class="signature-line"></div>
                        <div class="signature-name">
                            Fait à Brazzaville, le {{ date('d/m/Y') }}<br>
                            Clément OKOMBI
                        </div>
                    </td>
                </tr>
            </table>

            <!-- Identifiant de vérification unique -->
            <div class="metadata">
                Certificat de réussite Groupe Scolaire Le Marigot V.F généré officiellement le {{ date('d/m/Y H:i:s') }} | Code d'authenticité : {{ md5($eleve->matricule . $anneeScolaire->id) }}
            </div>
        </div>
    </div>
</body>
</html>
