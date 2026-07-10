<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Liste de Présences – {{ $classe?->nom_complet ?? '' }} – {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}</title>
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

        .badge {
            display: inline-block;
            padding: 2px 9px;
            border-radius: 999px;
            font-size: 10.5px;
            font-weight: bold;
        }
        .abs  { background: #fee2e2; color: #b91c1c; border: 1px solid #fca5a5; }
        .pres { background: #dcfce7; color: #166534; border: 1px solid #86efac; }

        /* ─── PIED DE PAGE ─── */
        .footer {
            margin-top: 18px;
            display: flex;
            justify-content: space-between;
            font-size: 10.5px;
            border-top: 1px solid #ccc;
            padding-top: 8px;
            color: #444;
        }
        .stats {
            margin-top: 12px;
            display: flex;
            gap: 20px;
            font-size: 11px;
        }
        .stat-box {
            padding: 6px 14px;
            border-radius: 6px;
            font-weight: bold;
        }
        .stat-pres { background: #dcfce7; color: #166534; }
        .stat-abs  { background: #fee2e2; color: #b91c1c; }
        .stat-total { background: #e0e7ff; color: #3730a3; }

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
        <h2>Liste de Présences / Absences</h2>
    </div>

    {{-- ══════ MÉTA ══════ --}}
    <div class="meta">
        <div>
            <b>Classe :</b> {{ $classe?->nom_complet ?? '—' }}<br>
            <b>Année scolaire :</b> {{ $anneeScolaire?->nom ?? '—' }}
        </div>
        <div>
            <b>Date :</b> {{ \Carbon\Carbon::parse($date)->translatedFormat('l d F Y') }}<br>
            @if(!$isPrimaire)
                <b>Matière :</b> {{ $matiere?->nom ?? '—' }}
            @endif
        </div>
        <div>
            <b>Effectif :</b> {{ $eleves->count() }} élève(s)<br>
            <b>Imprimé le :</b> {{ now()->format('d/m/Y à H:i') }}
        </div>
    </div>

    {{-- ══════ TABLEAU ══════ --}}
    <table>
        <thead>
            <tr>
                <th style="width:5%; text-align:center;">#</th>
                <th style="width: {{ $isPrimaire ? '55%' : '38%' }};">Nom & Prénom</th>
                <th style="width: {{ $isPrimaire ? '15%' : '12%' }}; text-align:center;">Matricule</th>
                <th style="width:10%; text-align:center;">Genre</th>
                <th style="width: {{ $isPrimaire ? '15%' : '18%' }}; text-align:center;">Statut</th>
                @if(!$isPrimaire)
                    <th style="width:17%;">Matière</th>
                @endif
            </tr>
        </thead>
        <tbody>
        @foreach($eleves as $i => $eleve)
            @php $isAbsent = $absents->contains($eleve->id); @endphp
            <tr>
                <td style="text-align:center; color:#888;">{{ $i + 1 }}</td>
                <td>
                    {{ strtoupper($eleve->nom) }} {{ $eleve->prenom }}
                </td>
                <td style="text-align:center;" class="matricule">{{ $eleve->matricule ?? 'N/A' }}</td>
                <td style="text-align:center;">
                    @if(strtolower($eleve->genre ?? '') === 'm')
                        <span class="genre-m">M</span>
                    @elseif(strtolower($eleve->genre ?? '') === 'f')
                        <span class="genre-f">F</span>
                    @else
                        <span style="color:#aaa;">—</span>
                    @endif
                </td>
                <td style="text-align:center;">
                    <span class="badge {{ $isAbsent ? 'abs' : 'pres' }}">
                        {{ $isAbsent ? 'Absent(e)' : 'Présent(e)' }}
                    </span>
                </td>
                @if(!$isPrimaire)
                    <td>{{ $matiere?->nom ?? '—' }}</td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>

    {{-- ══════ STATISTIQUES ══════ --}}
    @php
        $nbAbsents  = $absents->count();
        $nbPresents = $eleves->count() - $nbAbsents;
    @endphp
    <div class="stats">
        <div class="stat-box stat-total">Total : {{ $eleves->count() }}</div>
        <div class="stat-box stat-pres">Présents : {{ $nbPresents }}</div>
        <div class="stat-box stat-abs">Absents : {{ $nbAbsents }}</div>
    </div>

    {{-- ══════ PIED ══════ --}}
    <div class="footer">
        <div>Document généré le {{ now()->format('d/m/Y à H:i') }}</div>
        <div>
            Signature du responsable : ________________________________
        </div>
    </div>

</div>
<script>
    window.onload = function() { window.print(); };
</script>
</body>
</html>
