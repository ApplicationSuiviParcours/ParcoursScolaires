<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emploi du temps - {{ $classe->nom ?? ($enseignant->nom ?? 'Scolaire') }}</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 1cm;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            color: #1a202c;
            line-height: 1.5;
            background: white;
            padding: 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #2d3748;
            padding-bottom: 15px;
        }

        .school-info h1 {
            font-size: 24px;
            color: #2d3748;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .document-title {
            text-align: right;
        }

        .document-title h2 {
            font-size: 20px;
            color: #4a5568;
        }

        .document-title p {
            font-size: 14px;
            color: #718096;
        }

        .info-bar {
            background: #f7fafc;
            padding: 10px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            gap: 20px;
            font-size: 14px;
            border: 1px solid #e2e8f0;
        }

        .info-item span {
            font-weight: bold;
            color: #2d3748;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        th {
            background: #2d3748;
            color: white;
            padding: 12px 8px;
            font-size: 14px;
            text-transform: uppercase;
            border: 1px solid #2d3748;
        }

        td {
            border: 1px solid #cbd5e0;
            vertical-align: top;
            padding: 8px;
            height: 100px;
            background: #fff;
        }

        .cours-item {
            background: #edf2f7;
            border-left: 4px solid #4299e1;
            padding: 8px;
            margin-bottom: 8px;
            border-radius: 4px;
            font-size: 12px;
        }

        .cours-time {
            font-weight: bold;
            color: #2b6cb0;
            margin-bottom: 3px;
            display: block;
        }

        .cours-matiere {
            font-weight: bold;
            color: #1a202c;
            display: block;
            margin-bottom: 2px;
        }

        .cours-prof, .cours-salle {
            color: #4a5568;
            font-size: 11px;
            display: block;
        }

        .footer {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
            font-size: 10px;
            color: #a0aec0;
        }

        @media print {
            body { padding: 0; }
            .no-print { display: none; }
            td { background: transparent !important; }
            .cours-item { 
                background: #f7fafc !important;
                -webkit-print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="school-info">
            <h1>Scolaire Parcours</h1>
            <p>Excellence et Réussite</p>
        </div>
        <div class="document-title">
            <h2>EMPLOI DU TEMPS</h2>
            <p>Année Scolaire {{ $anneeScolaire->nom ?? date('Y') }}</p>
        </div>
    </div>

    <div class="info-bar">
        @if(isset($classe))
            <div class="info-item">Classe : <span>{{ $classe->nom_complet }}</span></div>
        @endif
        @if(isset($enseignant))
            <div class="info-item">Enseignant : <span>{{ $enseignant->nom }} {{ $enseignant->prenom }}</span></div>
        @endif
        @if(isset($eleve))
            <div class="info-item">Élève : <span>{{ $eleve->nom }} {{ $eleve->prenom }}</span></div>
        @endif
        <div class="info-item">Généré le : <span>{{ now()->format('d/m/Y') }}</span></div>
    </div>

    <table>
        <thead>
            <tr>
                @foreach($jours as $jour)
                    <th>{{ $jour }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            <tr>
                @foreach($jours as $jour)
                    <td>
                        @if(isset($emploiParJour[$jour]))
                            @foreach($emploiParJour[$jour] as $emploi)
                                <div class="cours-item">
                                    <span class="cours-time">
                                        {{ \Carbon\Carbon::parse($emploi->heure_debut)->format('H:i') }} - 
                                        {{ \Carbon\Carbon::parse($emploi->heure_fin)->format('H:i') }}
                                    </span>
                                    <span class="cours-matiere">{{ $emploi->matiere->nom ?? 'Matière' }}</span>
                                    @if(!isset($enseignant))
                                        <span class="cours-prof">{{ $emploi->enseignant->nom ?? '' }} {{ $emploi->enseignant->prenom ?? '' }}</span>
                                    @endif
                                    @if(!isset($classe) && isset($emploi->classe))
                                        <span class="cours-prof">Classe: {{ $emploi->classe->nom }}</span>
                                    @endif
                                    @if($emploi->salle)
                                        <span class="cours-salle">Salle: {{ $emploi->salle }}</span>
                                    @endif
                                </div>
                            @endforeach
                        @endif
                    </td>
                @endforeach
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <div>Document officiel - Scolaire Parcours</div>
        <div>Page 1/1</div>
    </div>

    <script>
        window.onload = function() {
            if (window.location.search.indexOf('print=true') !== -1 || window.location.pathname.indexOf('imprimer') !== -1) {
                window.print();
            }
        }
    </script>
</body>
</html>
