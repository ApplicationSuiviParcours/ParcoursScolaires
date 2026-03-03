{{-- resources/views/admin/classes/exports/single-pdf.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Fiche de classe</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 14px;
            color: #333;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #6366f1;
            padding-bottom: 20px;
        }
        .header h1 {
            color: #6366f1;
            margin: 0;
            font-size: 28px;
        }
        .header .date {
            color: #666;
            font-size: 12px;
            margin-top: 5px;
        }
        .card {
            background: #f8fafc;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            border-left: 4px solid #6366f1;
        }
        .card h2 {
            color: #6366f1;
            margin: 0 0 15px 0;
            font-size: 18px;
        }
        .info-row {
            margin-bottom: 10px;
            padding: 5px 0;
            border-bottom: 1px dashed #e2e8f0;
        }
        .info-label {
            font-weight: bold;
            color: #4b5563;
            width: 150px;
            display: inline-block;
        }
        .info-value {
            color: #1f2937;
        }
        .badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: bold;
        }
        .badge-primary {
            background: #6366f1;
            color: white;
        }
        .badge-success {
            background: #10b981;
            color: white;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin: 20px 0;
        }
        .stat-item {
            text-align: center;
            padding: 15px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .stat-number {
            font-size: 24px;
            font-weight: bold;
            color: #6366f1;
        }
        .stat-label {
            font-size: 12px;
            color: #6b7280;
            margin-top: 5px;
        }
        .progress-bar {
            width: 100%;
            height: 20px;
            background: #e5e7eb;
            border-radius: 10px;
            overflow: hidden;
            margin: 10px 0;
        }
        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #6366f1, #8b5cf6);
            color: white;
            font-size: 11px;
            line-height: 20px;
            text-align: center;
        }
        .signature {
            margin-top: 50px;
            padding-top: 30px;
            border-top: 2px solid #e5e7eb;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            color: #6b7280;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Fiche de classe</h1>
            <div class="date">Créée le {{ $classe->created_at->format('d/m/Y') }}</div>
        </div>

        <!-- Informations générales -->
        <div class="card">
            <h2>📚 Informations générales</h2>
            <div class="info-row">
                <span class="info-label">Niveau :</span>
                <span class="info-value">{{ $classe->niveau }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Nom de la classe :</span>
                <span class="info-value"><strong>{{ $classe->nom }}</strong></span>
            </div>
            <div class="info-row">
                <span class="info-label">Série :</span>
                <span class="info-value">
                    @if($classe->serie)
                        <span class="badge badge-primary">{{ $classe->serie }}</span>
                    @else
                        Non définie
                    @endif
                </span>
            </div>
            <div class="info-row">
                <span class="info-label">Année scolaire :</span>
                <span class="info-value">{{ $classe->anneeScolaire->nom ?? 'Non définie' }}</span>
            </div>
        </div>

        <!-- Statistiques -->
        <div class="stats-grid">
            <div class="stat-item">
                <div class="stat-number">{{ $stats['total_eleves'] }}</div>
                <div class="stat-label">Élèves inscrits</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">{{ $classe->capacite }}</div>
                <div class="stat-label">Capacité totale</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">{{ $stats['places_disponibles'] }}</div>
                <div class="stat-label">Places disponibles</div>
            </div>
        </div>

        <!-- Barre de progression -->
        <div class="card">
            <h2>📊 Taux d'occupation</h2>
            <div class="progress-bar">
                <div class="progress-fill" style="width: {{ $stats['taux_occupation'] }}%">
                    {{ $stats['taux_occupation'] }}%
                </div>
            </div>
            <div style="display: flex; justify-content: space-between; margin-top: 5px;">
                <span>0</span>
                <span>{{ $classe->capacite }}</span>
            </div>
        </div>

        <!-- Liste des élèves -->
        @if($classe->eleves->count() > 0)
        <div class="card">
            <h2>👥 Liste des élèves ({{ $classe->eleves->count() }})</h2>
            <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
                <thead>
                    <tr style="background: #6366f1; color: white;">
                        <th style="padding: 8px; text-align: left;">N°</th>
                        <th style="padding: 8px; text-align: left;">Nom</th>
                        <th style="padding: 8px; text-align: left;">Prénom</th>
                        <th style="padding: 8px; text-align: left;">Matricule</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($classe->eleves as $index => $eleve)
                    <tr style="border-bottom: 1px solid #e5e7eb;">
                        <td style="padding: 8px;">{{ $index + 1 }}</td>
                        <td style="padding: 8px;">{{ $eleve->nom }}</td>
                        <td style="padding: 8px;">{{ $eleve->prenom }}</td>
                        <td style="padding: 8px;">{{ $eleve->matricule ?? 'N/A' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

        <!-- Signature -->
        <div class="signature">
            <table style="width: 100%;">
                <tr>
                    <td style="text-align: center;">
                        <div style="border-bottom: 1px solid #333; width: 200px; margin: 0 auto;"></div>
                        <p style="margin-top: 5px;">Signature du responsable</p>
                    </td>
                    <td style="text-align: center;">
                        <div style="border-bottom: 1px solid #333; width: 200px; margin: 0 auto;"></div>
                        <p style="margin-top: 5px;">Cachet de l'établissement</p>
                    </td>
                </tr>
            </table>
        </div>

        <div class="footer">
            <p>Document officiel - {{ config('app.name') }}</p>
            <p>Imprimé le {{ date('d/m/Y H:i') }}</p>
        </div>
    </div>
</body>
</html>