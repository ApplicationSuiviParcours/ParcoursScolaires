<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Tableau d’honneur - {{ $classe?->nom_complet ?? '' }} - {{ $periode }}</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family: Arial, Helvetica, sans-serif; font-size: 12px; color:#111; padding: 16px; }
        .page { max-width: 900px; margin: 0 auto; }

        .header {
            display:flex; justify-content:space-between; align-items:flex-start;
            border-bottom: 2px solid #333; padding-bottom: 10px; margin-bottom: 12px;
        }
        .header .left { width: 55%; }
        .header .right { width: 45%; text-align:right; font-size: 11px; line-height: 1.4; }
        .title { text-align:center; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; margin: 8px 0; }

        table { width:100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #888; padding: 6px 8px; }
        th { background: #eee; font-weight: bold; text-transform: uppercase; font-size: 11px; }

        .footer { margin-top: 16px; font-size: 11px; display:flex; justify-content:space-between; }
        @media print {
            body { padding: 0; }
            * { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        }
    </style>
</head>
<body>
<div class="page">
    <div class="header">
        <div class="left">
            <div style="font-weight:bold;">ECOLE</div>
            <div style="margin-top:4px;">Tableau d’honneur par niveau</div>
        </div>
        <div class="right">
            <div><b>Période :</b> {{ $periode }}</div>
            <div><b>Année scolaire :</b> {{ $anneeScolaire?->nom ?? '-' }}</div>
            <div><b>Classe :</b> {{ $classe?->nom_complet ?? '-' }}</div>
            <div><b>Affichage :</b> {{ $top ? ('Top ' . $top) : 'Ensemble' }}</div>
        </div>
    </div>

    <div class="title">Classement des élèves</div>

    <table>
        <thead>
        <tr>
            <th style="width:10%;">Rang</th>
            <th style="width:55%;">Élève</th>
            <th style="width:20%;">Moyenne</th>
            <th style="width:15%;">Mention</th>
        </tr>
        </thead>
        <tbody>
        @foreach($tableau as $b)
            <tr>
                <td style="text-align:center; font-weight:bold;">{{ $b->rang ?? '-' }}</td>
                <td>
                    {{ $b->eleve->nom }} {{ $b->eleve->prenom }}
                    <div style="font-size:10px; color:#555; margin-top:2px;">{{ $b->eleve->matricule ?? 'N/A' }}</div>
                </td>
                <td style="text-align:center; font-weight:bold;">
                    {{ number_format($b->moyenne_generale, 2) }}/20
                </td>
                <td style="text-align:center;">{{ $b->mention ?? '-' }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="footer">
        <div>Date : {{ now()->format('d/m/Y') }}</div>
        <div>Signature : ____________________</div>
    </div>
</div>

<script>
    window.onload = function() { window.print(); };
</script>
</body>
</html>

