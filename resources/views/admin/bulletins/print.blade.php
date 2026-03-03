<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bulletin de {{ $bulletin->eleve->nom }} {{ $bulletin->eleve->prenom }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background: white;
            padding: 20px;
            color: #333;
        }

        .bulletin-container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #1e40af 0%, #3730a3 100%);
            color: white;
            padding: 30px 40px;
            text-align: center;
        }

        .header h1 {
            font-size: 32px;
            margin-bottom: 10px;
            font-weight: bold;
        }

        .header h2 {
            font-size: 24px;
            margin-bottom: 5px;
            font-weight: normal;
        }

        .header p {
            font-size: 16px;
            opacity: 0.9;
        }

        .school-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 40px;
            background: #f8fafc;
            border-bottom: 2px solid #e2e8f0;
        }

        .school-name {
            font-size: 20px;
            font-weight: bold;
            color: #1e293b;
        }

        .school-year {
            font-size: 16px;
            color: #475569;
        }

        .student-info {
            padding: 30px 40px;
            background: white;
            border-bottom: 1px solid #e2e8f0;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }

        .info-item {
            display: flex;
            flex-direction: column;
        }

        .info-label {
            font-size: 12px;
            color: #64748b;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        .info-value {
            font-size: 16px;
            font-weight: bold;
            color: #0f172a;
        }

        .results-summary {
            padding: 30px 40px;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border-bottom: 2px solid #e2e8f0;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }

        .summary-item {
            text-align: center;
            padding: 15px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .summary-label {
            font-size: 12px;
            color: #64748b;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        .summary-value {
            font-size: 24px;
            font-weight: bold;
        }

        .moyenne-10 {
            color: #059669;
        }

        .moyenne-moins-10 {
            color: #dc2626;
        }

        .subjects-table {
            padding: 30px 40px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th {
            background: #f1f5f9;
            color: #475569;
            font-size: 14px;
            font-weight: 600;
            padding: 12px;
            text-align: left;
            border-bottom: 2px solid #cbd5e1;
        }

        td {
            padding: 12px;
            border-bottom: 1px solid #e2e8f0;
            color: #334155;
            vertical-align: top;
        }

        .subject-name {
            font-weight: 600;
            color: #0f172a;
            width: 20%;
        }

        .notes-section {
            width: 50%;
        }

        .notes-row {
            display: flex;
            gap: 20px;
            margin-bottom: 5px;
        }

        .notes-label {
            font-size: 12px;
            font-weight: 600;
            color: #64748b;
            width: 80px;
        }

        .notes-list {
            display: flex;
            gap: 5px;
            flex-wrap: wrap;
            flex: 1;
        }

        .note-badge {
            padding: 2px 8px;
            border-radius: 9999px;
            font-size: 11px;
            font-weight: 600;
            min-width: 35px;
            text-align: center;
        }

        .note-good {
            background: #dcfce7;
            color: #059669;
        }

        .note-bad {
            background: #fee2e2;
            color: #dc2626;
        }

        .average-cell {
            width: 15%;
        }

        .average {
            font-size: 18px;
            font-weight: bold;
        }

        .average-good {
            color: #059669;
        }

        .average-bad {
            color: #dc2626;
        }

        .coefficient-cell {
            width: 15%;
            text-align: center;
        }

        .coefficient-badge {
            background: #e2e8f0;
            color: #475569;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }

        .appreciation {
            margin: 30px 40px;
            padding: 20px;
            background: #fef3c7;
            border-left: 4px solid #f59e0b;
            border-radius: 8px;
        }

        .appreciation h3 {
            font-size: 16px;
            color: #92400e;
            margin-bottom: 10px;
        }

        .appreciation p {
            font-size: 14px;
            color: #78350f;
            line-height: 1.6;
        }

        .footer {
            padding: 20px 40px;
            background: #f8fafc;
            border-top: 2px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 12px;
            color: #64748b;
        }

        .signature {
            text-align: right;
        }

        .legend {
            margin: 20px 40px;
            padding: 15px;
            background: #f8fafc;
            border-radius: 8px;
            font-size: 12px;
            color: #64748b;
        }

        .legend-item {
            display: inline-flex;
            align-items: center;
            margin-right: 20px;
        }

        .legend-color {
            width: 12px;
            height: 12px;
            border-radius: 3px;
            margin-right: 5px;
        }

        .legend-devoir { background: #bfdbfe; }
        .legend-examen { background: #fed7aa; }

        @media print {
            body {
                padding: 0;
            }
            
            .bulletin-container {
                box-shadow: none;
                border-radius: 0;
            }
            
            .header {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>
    <div class="bulletin-container">
        <!-- En-tête -->
        <div class="header">
            <h1>BULLETIN SCOLAIRE</h1>
            <h2>{{ $bulletin->periode }}</h2>
            <p>{{ $bulletin->anneeScolaire->nom }}</p>
        </div>

        <!-- Informations école -->
        <div class="school-info">
            <div class="school-name">Établissement Scolaire</div>
            <div class="school-year">Année scolaire {{ $bulletin->anneeScolaire->nom }}</div>
        </div>

        <!-- Informations élève -->
        <div class="student-info">
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Nom et prénom</span>
                    <span class="info-value">{{ $bulletin->eleve->nom }} {{ $bulletin->eleve->prenom }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Matricule</span>
                    <span class="info-value">{{ $bulletin->eleve->matricule ?? 'N/A' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Classe</span>
                    <span class="info-value">{{ $bulletin->classe->nom }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Date</span>
                    <span class="info-value">{{ $bulletin->date_bulletin ?->format('d/m/Y') ?? 'N/A' }}</span>
                </div>
            </div>
        </div>

        <!-- Résumé des résultats -->
        <div class="results-summary">
            <div class="summary-grid">
                <div class="summary-item">
                    <div class="summary-label">Moyenne générale</div>
                    <div class="summary-value {{ ($moyenneGenerale ?? $bulletin->moyenne_generale) >= 10 ? 'moyenne-10' : 'moyenne-moins-10' }}">
                        {{ number_format($moyenneGenerale ?? $bulletin->moyenne_generale, 2) }}/20
                    </div>
                </div>
                <div class="summary-item">
                    <div class="summary-label">Rang</div>
                    <div class="summary-value">
                        {{ $bulletin->rang ?? '-' }}/{{ $bulletin->effectif_classe ?? '?' }}
                    </div>
                </div>
                <div class="summary-item">
                    <div class="summary-label">Mention</div>
                    <div class="summary-value {{ ($moyenneGenerale ?? $bulletin->moyenne_generale) >= 10 ? 'moyenne-10' : 'moyenne-moins-10' }}">
                        {{ $bulletin->mention }}
                    </div>
                </div>
                <div class="summary-item">
                    <div class="summary-label">Admission</div>
                    <div class="summary-value {{ $bulletin->est_admis ? 'moyenne-10' : 'moyenne-moins-10' }}">
                        {{ $bulletin->est_admis ? 'ADMIS' : 'NON ADMIS' }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Légende -->
        <div class="legend">
            <span class="legend-item">
                <span class="legend-color legend-devoir"></span>
                Devoirs/Contrôles
            </span>
            <span class="legend-item">
                <span class="legend-color legend-examen"></span>
                Examens/Compositions
            </span>
        </div>

        <!-- Tableau des notes par matière -->
        <div class="subjects-table">
            <table>
                <thead>
                    <tr>
                        <th>Matière</th>
                        <th>Notes</th>
                        <th>Moyenne</th>
                        <th>Coefficient</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($notesParMatiere as $matiereId => $data)
                        @php
                            // Séparer les notes par type
                            $notesDevoir = [];
                            $notesExamen = [];
                            
                            foreach ($data['notes'] as $note) {
                                $noteValue = is_object($note) ? ($note->note ?? $note->valeur ?? 0) : ($note['valeur'] ?? $note['note'] ?? 0);
                                $noteType = is_object($note) ? ($note->evaluation->type ?? 'devoir') : ($note['type'] ?? 'devoir');
                                
                                if (strtolower($noteType) == 'examen' || strtolower($noteType) == 'composition') {
                                    $notesExamen[] = $noteValue;
                                } else {
                                    $notesDevoir[] = $noteValue;
                                }
                            }
                            
                            $moyenne = $data['moyenne'] ?? $data['moyenne_ponderee'] ?? 0;
                        @endphp
                        <tr>
                            <td class="subject-name">
                                @if(isset($data['matiere_nom']))
                                    {{ $data['matiere_nom'] }}
                                @elseif(isset($data['matiere']))
                                    {{ $data['matiere']->nom ?? 'Matière' }}
                                @else
                                    Matière #{{ $matiereId }}
                                @endif
                                @if(isset($data['matiere_code']) || (isset($data['matiere']) && isset($data['matiere']->code)))
                                    <div style="font-size: 11px; color: #64748b;">
                                        {{ $data['matiere_code'] ?? $data['matiere']->code }}
                                    </div>
                                @endif
                            </td>
                            <td class="notes-section">
                                @if(!empty($notesDevoir))
                                <div class="notes-row">
                                    <span class="notes-label">Devoirs:</span>
                                    <div class="notes-list">
                                        @foreach($notesDevoir as $note)
                                            <span class="note-badge {{ $note >= 10 ? 'note-good' : 'note-bad' }}">
                                                {{ number_format($note, 2) }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                                
                                @if(!empty($notesExamen))
                                <div class="notes-row">
                                    <span class="notes-label">Examens:</span>
                                    <div class="notes-list">
                                        @foreach($notesExamen as $note)
                                            <span class="note-badge {{ $note >= 10 ? 'note-good' : 'note-bad' }}">
                                                {{ number_format($note, 2) }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                            </td>
                            <td class="average-cell">
                                <span class="average {{ $moyenne >= 10 ? 'average-good' : 'average-bad' }}">
                                    {{ number_format($moyenne, 2) }}
                                </span>
                            </td>
                            <td class="coefficient-cell">
                                <span class="coefficient-badge">
                                    x{{ $data['coefficient_total'] ?? $data['coefficient'] ?? 1 }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center; padding: 20px;">
                                Aucune note disponible pour ce bulletin
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Appréciation -->
        @if($bulletin->appreciation)
        <div class="appreciation">
            <h3>Appréciation du professeur principal</h3>
            <p>{{ $bulletin->appreciation }}</p>
        </div>
        @endif

        <!-- Pied de page -->
        <div class="footer">
            <div>Document généré le {{ now()->format('d/m/Y à H:i:s') }}</div>
            <div class="signature">
                <div>Le chef d'établissement</div>
                <div style="margin-top: 20px;">____________________</div>
            </div>
        </div>
    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>