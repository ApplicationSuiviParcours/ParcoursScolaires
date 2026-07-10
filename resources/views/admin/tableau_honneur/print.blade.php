<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Tableau d’honneur – {{ $classe?->nom_complet ?? '' }} – {{ $periode }}</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family: Arial, Helvetica, sans-serif; font-size: 11.5px; color:#111; padding: 18px 24px; }
        .page { max-width: 960px; margin: 0 auto; }

        /* ─── EN-TÊTE ─── */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 3px double #1e3a5f;
            padding-bottom: 10px;
            margin-bottom: 14px;
        }
        .header-left {
            width: 38%;
            font-size: 10.5px;
            line-height: 1.55;
            color: #1a1a1a;
        }
        .header-left strong { font-size: 11px; display:block; }
        .stars { color: #c8a000; letter-spacing: 1px; font-size: 10px; }

        .header-center {
            width: 20%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .logo-circle {
            width: 70px; height: 70px;
            border-radius: 50%;
            border: 3px solid #1e3a5f;
            display: flex; align-items: center; justify-content: center;
            font-weight: bold; font-size: 12px; color: #1e3a5f;
            text-align: center; line-height: 1.2;
            background: #f0f4ff;
        }

        .header-right {
            width: 38%;
            text-align: right;
            font-size: 10.5px;
            line-height: 1.55;
        }
        .school-name {
            font-weight: bold;
            font-size: 12.5px;
            color: #1e3a5f;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* ─── SÉPARATEUR & TITRE ─── */
        .doc-title {
            text-align: center;
            margin: 12px 0 4px;
        }
        .doc-title h2 {
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #1e3a5f;
            border-top: 1.5px solid #1e3a5f;
            border-bottom: 1.5px solid #1e3a5f;
            padding: 5px 0;
            display: inline-block;
        }

        /* ─── MÉTA INFOS ─── */
        .meta {
            display: flex;
            justify-content: space-between;
            font-size: 10.5px;
            margin: 10px 0 14px;
            background: #f7f9fc;
            border: 1px solid #d0d9ea;
            border-radius: 4px;
            padding: 7px 12px;
        }
        .meta div { line-height: 1.7; }
        .meta b { color: #1e3a5f; }

        /* ─── TABLEAU ─── */
        table { width: 100%; border-collapse: collapse; margin-top: 6px; }
        thead th {
            background: #1e3a5f;
            color: #fff;
            text-transform: uppercase;
            font-size: 10px;
            letter-spacing: 0.5px;
            padding: 7px 8px;
            border: 1px solid #1e3a5f;
        }
        tbody td { border: 1px solid #b0b8c8; padding: 6px 8px; vertical-align: middle; }
        tbody tr:nth-child(even) { background: #f3f6fb; }
        tbody tr:hover { background: #eaf0fb; }

        .matricule { font-size: 9.5px; color: #666; margin-top: 1px; }
        .genre-m { color: #1d4ed8; font-weight: bold; }
        .genre-f { color: #be185d; font-weight: bold; }

        /* ─── PIED DE PAGE ─── */
        .footer {
            margin-top: 24px;
            display: flex;
            justify-content: space-between;
            font-size: 10.5px;
            border-top: 1px solid #ccc;
            padding-top: 8px;
            color: #444;
        }

        @media print {
            body { padding: 0; }
            * { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        }
    </style>
</head>
<body>
<div class="page">

    {{-- ══════ EN-TÊTE ══════ --}}
    <div class="header">
        <div class="header-left">
            <strong>MINISTÈRE DE L'ÉDUCATION NATIONALE</strong>
            CHARGÉ DE LA FORMATION CIVIQUE<br>
            <span class="stars">★★★★★★★★★</span><br>
            <strong>SECRÉTARIAT GÉNÉRAL</strong><br>
            <span class="stars">★★★★★★★★★</span><br>
            DIRECTION D'ACADÉMIE PROVINCIALE
        </div>
        <div class="header-center">
            <div class="logo-circle">JEAN<br>PIAGET</div>
        </div>
        <div class="header-right">
            <div class="school-name">ÉCOLE PRIVÉE LAÏQUE JEAN PIAGET</div>
            Pré-primaire / Primaire<br>
            Discipline Panéénième-Résuelle<br>
            <strong>Tél :</strong> 66327443 / 74145088<br>
            <strong>B.P :</strong> 20256<br>
            jeanpiaget094@gmail.com
        </div>
    </div>

    {{-- ══════ TITRE ══════ --}}
    <div class="doc-title">
        <h2>Tableau d’honneur par niveau</h2>
    </div>

    {{-- ══════ MÉTA ══════ --}}
    <div class="meta">
        <div>
            <b>Classe :</b> {{ $classe?->nom_complet ?? '—' }}<br>
            <b>Année scolaire :</b> {{ $anneeScolaire?->nom ?? '—' }}
        </div>
        <div>
            <b>Période :</b> {{ $periode }}<br>
            <b>Sélection :</b> {{ $top ? ('Top ' . $top) : 'L\'ensemble' }}
        </div>
        <div>
            <b>Imprimé le :</b> {{ now()->format('d/m/Y à H:i') }}
        </div>
    </div>

    {{-- ══════ TABLEAU ══════ --}}
    <table>
        <thead>
            <tr>
                <th style="width:10%; text-align:center;">Rang</th>
                <th style="width:45%;">Nom & Prénom</th>
                <th style="width:15%; text-align:center;">Genre</th>
                <th style="width:15%; text-align:center;">Moyenne</th>
                <th style="width:15%; text-align:center;">Mention</th>
            </tr>
        </thead>
        <tbody>
        @foreach($tableau as $b)
            <tr>
                <td style="text-align:center; font-weight:bold; font-size:12px; color:#1e3a5f;">{{ $b->rang ?? '-' }}</td>
                <td>
                    <strong>{{ strtoupper($b->eleve->nom) }}</strong> {{ $b->eleve->prenom }}
                    <div class="matricule">{{ $b->eleve->matricule ?? 'N/A' }}</div>
                </td>
                <td style="text-align:center;">
                    @if(strtolower($b->eleve->genre ?? '') === 'm')
                        <span class="genre-m">M</span>
                    @elseif(strtolower($b->eleve->genre ?? '') === 'f')
                        <span class="genre-f">F</span>
                    @else
                        <span style="color:#aaa;">—</span>
                    @endif
                </td>
                <td style="text-align:center; font-weight:bold;">
                    {{ number_format($b->moyenne_generale, 2) }}/20
                </td>
                <td style="text-align:center;">
                    <span style="font-weight: 500; font-size: 11px;">{{ $b->mention ?? '-' }}</span>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{-- ══════ PIED ══════ --}}
    <div class="footer">
        <div>Date : {{ now()->format('d/m/Y') }}</div>
        <div>
            Signature de la Direction : ________________________________
        </div>
    </div>

</div>
<script>
    window.onload = function() { window.print(); };
</script>
</body>
</html>
