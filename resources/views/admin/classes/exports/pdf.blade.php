{{-- resources/views/admin/classes/exports/pdf.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Liste des Classes</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #6366f1;
        }
        .header h1 {
            color: #6366f1;
            margin: 0 0 10px 0;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .stats {
            margin-bottom: 30px;
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            gap: 15px;
        }
        .stat-box {
            text-align: center;
            padding: 15px;
            background: #f8f9fc;
            border-radius: 8px;
            width: 200px;
            border-left: 4px solid #6366f1;
        }
        .stat-box h3 {
            margin: 0 0 5px 0;
            color: #6366f1;
            font-size: 14px;
        }
        .stat-box .number {
            font-size: 24px;
            font-weight: bold;
            color: #1f2937;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th {
            background: #6366f1;
            color: white;
            padding: 12px;
            text-align: left;
            font-size: 12px;
        }
        td {
            padding: 10px;
            border-bottom: 1px solid #e5e7eb;
        }
        tr:nth-child(even) {
            background: #f9fafb;
        }
        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 11px;
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
        .footer {
            margin-top: 30px;
            text-align: center;
            color: #666;
            font-size: 10px;
            border-top: 1px solid #e5e7eb;
            padding-top: 20px;
        }
        .watermark {
            position: fixed;
            bottom: 20px;
            right: 20px;
            opacity: 0.1;
            font-size: 60px;
            transform: rotate(-15deg);
        }
    </style>
</head>
<body>
    <div class="watermark">GESTION SCOLAIRE</div>

    <div class="header">
        <h1>Liste des Classes</h1>
        <p>État des classes - Année Scolaire {{ date('Y') }}</p>
        <p>Généré le : {{ date('d/m/Y H:i') }}</p>
    </div>

    <div class="stats">
        <div class="stat-box">
            <h3>Total Classes</h3>
            <div class="number">{{ $stats['total'] }}</div>
        </div>
        <div class="stat-box">
            <h3>Capacité totale</h3>
            <div class="number">{{ $stats['capacite_totale'] }}</div>
        </div>
        <div class="stat-box">
            <h3>Niveaux</h3>
            <div class="number">{{ $stats['niveaux'] }}</div>
        </div>
        <div class="stat-box">
            <h3>Séries</h3>
            <div class="number">{{ $stats['series'] }}</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Niveau</th>
                <th>Classe</th>
                <th>Série</th>
                <th>Capacité</th>
                <th>Année Scolaire</th>
                <th>Date création</th>
            </tr>
        </thead>
        <tbody>
            @foreach($classes as $classe)
            <tr>
                <td>{{ $classe->niveau }}</td>
                <td><strong>{{ $classe->nom }}</strong></td>
                <td>
                    @if($classe->serie)
                        <span class="badge badge-primary">{{ $classe->serie }}</span>
                    @else
                        -
                    @endif
                </td>
                <td>{{ $classe->capacite }} places</td>
                <td>{{ $classe->anneeScolaire->nom ?? 'N/A' }}</td>
                <td>{{ $classe->created_at->format('d/m/Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Document généré automatiquement - {{ config('app.name') }}</p>
        <p>Ce document contient {{ $classes->count() }} classe(s)</p>
    </div>
</body>
</html>