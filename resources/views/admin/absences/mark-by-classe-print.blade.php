<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Impression présences - {{ $classe?->nom_complet ?? '' }}</title>
    <style>
        body { font-family: Arial, Helvetica, sans-serif; font-size: 12px; color:#111; padding: 16px; }
        .page { max-width: 900px; margin: 0 auto; }
        .header { border-bottom: 2px solid #333; padding-bottom: 10px; margin-bottom: 12px; display:flex; justify-content:space-between; }
        .title { text-align:center; font-weight:bold; text-transform:uppercase; letter-spacing:1px; margin: 8px 0; }
        table { width:100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #888; padding: 6px 8px; }
        th { background:#eee; text-transform:uppercase; font-size: 11px; }
        .badge { display:inline-block; padding: 2px 6px; border-radius: 999px; font-size: 11px; font-weight:bold; }
        .abs { background:#fee2e2; color:#b91c1c; }
        .pres { background:#dcfce7; color:#166534; }
        @media print { body { padding: 0; } * { -webkit-print-color-adjust: exact; print-color-adjust: exact; } }
    </style>
</head>
<body>
<div class="page">
    <div class="header">
        <div>
            <div style="font-weight:bold;">ECOLE</div>
            <div style="margin-top:4px;">Liste des présences</div>
        </div>
        <div style="text-align:right; font-size: 11px; line-height: 1.4;">
            <div><b>Classe :</b> {{ $classe?->nom_complet ?? '-' }}</div>
            <div><b>Année scolaire :</b> {{ $anneeScolaire?->nom ?? '-' }}</div>
            <div><b>Date :</b> {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}</div>
            <div><b>Matière :</b> {{ $matiere?->nom ?? '-' }}</div>
        </div>
    </div>

    <div class="title">Présent / Absent</div>

    <table>
        <thead>
        <tr>
            <th style="width:60%;">Élève</th>
            <th style="width:20%; text-align:center;">Statut</th>
            <th style="width:20%;">Matière</th>
        </tr>
        </thead>
        <tbody>
        @foreach($eleves as $eleve)
            @php $isAbsent = $absents->contains($eleve->id); @endphp
            <tr>
                <td>
                    {{ $eleve->nom }} {{ $eleve->prenom }}
                    <div style="font-size:10px; color:#555; margin-top:2px;">{{ $eleve->matricule ?? 'N/A' }}</div>
                </td>
                <td style="text-align:center;">
                    <span class="badge {{ $isAbsent ? 'abs' : 'pres' }}">{{ $isAbsent ? 'Absent' : 'Présent' }}</span>
                </td>
                <td>{{ $matiere?->nom ?? '-' }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<script>
    window.onload = function() { window.print(); };
</script>
</body>
</html>

