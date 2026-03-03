{{-- resources/views/admin/classes/exports/eleves-pdf.blade.php --}}
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Liste des élèves - {{ $classe->nom }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #4f46e5;
        }

        .header h1 {
            color: #4f46e5;
            margin: 0 0 10px 0;
            font-size: 24px;
        }

        .header .subtitle {
            color: #6b7280;
            font-size: 14px;
            margin: 5px 0;
        }

        .header .date {
            color: #9ca3af;
            font-size: 11px;
            margin-top: 10px;
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
            padding: 15px 20px;
            background: #f3f4f6;
            border-radius: 8px;
            min-width: 120px;
            border-left: 4px solid #4f46e5;
        }

        .stat-box h3 {
            margin: 0 0 5px 0;
            color: #4f46e5;
            font-size: 14px;
            text-transform: uppercase;
        }

        .stat-box .number {
            font-size: 24px;
            font-weight: bold;
            color: #1f2937;
        }

        .class-info {
            background: #eef2ff;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 1px solid #c7d2fe;
        }

        .class-info h2 {
            color: #4f46e5;
            margin: 0 0 10px 0;
            font-size: 18px;
        }

        .class-info p {
            margin: 5px 0;
            color: #374151;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th {
            background: #4f46e5;
            color: white;
            padding: 12px 8px;
            text-align: left;
            font-size: 12px;
            font-weight: 600;
        }

        td {
            padding: 10px 8px;
            border-bottom: 1px solid #e5e7eb;
        }

        tr:nth-child(even) {
            background: #f9fafb;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            color: #6b7280;
            font-size: 10px;
            border-top: 1px solid #e5e7eb;
            padding-top: 20px;
        }

        .page-number {
            text-align: right;
            font-size: 10px;
            color: #9ca3af;
            margin-top: 10px;
        }

        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: 600;
        }

        .badge-m {
            background: #dbeafe;
            color: #1e40af;
        }

        .badge-f {
            background: #fce7f3;
            color: #9d174d;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Liste des élèves</h1>
        <div class="subtitle">{{ $classe->nom }} - {{ $classe->niveau }} @if($classe->serie) (Série
        {{ $classe->serie }}) @endif</div>
        @if($classe->anneeScolaire)
            <div class="subtitle">Année scolaire: {{ $classe->anneeScolaire->nom }}</div>
        @endif
        <div class="date">Généré le: {{ date('d/m/Y H:i') }}</div>
    </div>

    <div class="stats">
        <div class="stat-box">
            <h3>Total élèves</h3>
            <div class="number">{{ $stats['total'] }}</div>
        </div>
        <div class="stat-box">
            <h3>Garçons</h3>
            <div class="number">{{ $stats['garcons'] }}</div>
        </div>
        <div class="stat-box">
            <h3>Filles</h3>
            <div class="number">{{ $stats['filles'] }}</div>
        </div>
    </div>

    <div class="class-info">
        <h2>Informations de la classe</h2>
        <p><strong>Nom:</strong> {{ $classe->nom }}</p>
        <p><strong>Niveau:</strong> {{ $classe->niveau }}</p>
        @if($classe->serie)
            <p><strong>Série:</strong> {{ $classe->serie }}</p>
        @endif
        <p><strong>Capacité:</strong> {{ $classe->capacite }} élèves</p>
        <p><strong>Taux d'occupation:</strong>
            {{ $stats['total'] > 0 ? round(($stats['total'] / $classe->capacite) * 100) : 0 }}%</p>
    </div>

    @if($eleves->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>N°</th>
                    <th>Matricule</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Date naissance</th>
                    <th>Genre</th>
                    <th>Téléphone</th>
                </tr>
            </thead>
            <tbody>
                @foreach($eleves as $index => $eleve)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $eleve->matricule ?? '-' }}</td>
                        <td>{{ $eleve->nom ?? '-' }}</td>
                        <td>{{ $eleve->prenom ?? '-' }}</td>
                        <td>{{ $eleve->date_naissance ? \Carbon\Carbon::parse($eleve->date_naissance)->format('d/m/Y') : '-' }}
                        </td>
                        <td>
                            @if($eleve->genre == 'M')
                                <span class="badge badge-m">Masculin</span>
                            @elseif($eleve->genre == 'F')
                                <span class="badge badge-f">Féminin</span>
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ $eleve->telephone ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div style="text-align: center; padding: 50px; background: #f9fafb; border-radius: 8px;">
            <p style="color: #6b7280;">Aucun élève inscrit dans cette classe</p>
        </div>
    @endif

    <div class="footer">
        <p>Document généré automatiquement - {{ config('app.name') }}</p>
        <p>Ce document contient {{ $eleves->count() }} élève(s)</p>
    </div>

    <div class="page-number">
        Page 1/1
    </div>
</body>

</html>