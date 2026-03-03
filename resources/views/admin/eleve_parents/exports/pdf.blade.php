{{-- resources/views/admin/eleve_parents/exports/pdf.blade.php --}}
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Relations Élèves-Parents</title>
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
            border-bottom: 2px solid #4e73df;
        }

        .header h1 {
            color: #4e73df;
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
        }

        .stat-box {
            text-align: center;
            padding: 15px;
            background: #f8f9fc;
            border-radius: 8px;
            width: 30%;
        }

        .stat-box h3 {
            margin: 0 0 5px 0;
            color: #4e73df;
            font-size: 18px;
        }

        .stat-box .number {
            font-size: 24px;
            font-weight: bold;
            color: #1cc88a;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th {
            background: #4e73df;
            color: white;
            padding: 12px;
            text-align: left;
            font-size: 12px;
        }

        td {
            padding: 10px;
            border-bottom: 1px solid #e3e6f0;
        }

        tr:nth-child(even) {
            background: #f8f9fc;
        }

        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: bold;
        }

        .badge-primary {
            background: #4e73df;
            color: white;
        }

        .badge-danger {
            background: #e74a3b;
            color: white;
        }

        .badge-info {
            background: #36b9cc;
            color: white;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            color: #666;
            font-size: 10px;
            border-top: 1px solid #e3e6f0;
            padding-top: 20px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Relations Élèves-Parents</h1>
        <p>Liste complète des relations</p>
        <p>Généré le : {{ date('d/m/Y H:i') }}</p>
    </div>

    <div class="stats">
        <div class="stat-box">
            <h3>Total relations</h3>
            <div class="number">{{ $stats['total'] }}</div>
        </div>
        <div class="stat-box">
            <h3>Élèves concernés</h3>
            <div class="number">{{ $stats['eleves'] }}</div>
        </div>
        <div class="stat-box">
            <h3>Parents actifs</h3>
            <div class="number">{{ $stats['parents'] }}</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Élève</th>
                <th>Classe</th>
                <th>Parent</th>
                <th>Lien parental</th>
                <th>Contact parent</th>
                <th>Date création</th>
            </tr>
        </thead>
        <tbody>
            @foreach($relations as $relation)
                <tr>
                    <td>{{ $relation->eleve->prenom }} {{ $relation->eleve->nom }}</td>
                    <td>{{ $relation->eleve->classe->nom ?? 'N/A' }}</td>
                    <td>{{ $relation->parentEleve->prenom }} {{ $relation->parentEleve->nom }}</td>
                    <td>
                        <span
                            class="badge badge-{{ $relation->lien_parental == 'Père' ? 'primary' : ($relation->lien_parental == 'Mère' ? 'danger' : 'info') }}">
                            {{ $relation->lien_parental }}
                        </span>
                    </td>
                    <td>
                        {{ $relation->parentEleve->email }}<br>
                        @if($relation->parentEleve->telephone)
                            Tél: {{ $relation->parentEleve->telephone }}
                        @endif
                    </td>
                    <td>{{ $relation->created_at->format('d/m/Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Document généré automatiquement - {{ config('app.name') }}</p>
    </div>
</body>

</html>