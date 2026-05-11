<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Parents - Scolaire Parcours</title>
    <style>
        @page {
            size: A4;
            margin: 1cm;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            line-height: 1.4;
            margin: 0;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #4a148c;
            padding-bottom: 10px;
        }

        .header h1 {
            color: #4a148c;
            margin: 0;
            font-size: 24px;
            text-transform: uppercase;
        }

        .header p {
            margin: 5px 0 0;
            color: #666;
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 11px;
        }

        th {
            background-color: #f3e5f5;
            color: #4a148c;
            text-align: left;
            padding: 10px;
            border-bottom: 2px solid #ce93d8;
        }

        td {
            padding: 8px 10px;
            border-bottom: 1px solid #eee;
        }

        tr:nth-child(even) {
            background-color: #fafafa;
        }

        .statut-active {
            color: #2e7d32;
            font-weight: bold;
        }

        .statut-inactive {
            color: #c62828;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 10px;
            color: #999;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Liste des Parents</h1>
        <p>Scolaire Parcours - État au {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Matricule</th>
                <th>Nom & Prénom</th>
                <th>Genre</th>
                <th>Téléphone</th>
                <th>Email</th>
                <th>Profession</th>
                <th>Enfants</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            @foreach($parents as $parent)
            <tr>
                <td>{{ $parent->matricule }}</td>
                <td><strong>{{ $parent->nom }}</strong> {{ $parent->prenom }}</td>
                <td>{{ $parent->genre == 'm' ? 'M' : 'F' }}</td>
                <td>{{ $parent->telephone }}</td>
                <td>{{ $parent->email }}</td>
                <td>{{ $parent->profession }}</td>
                <td>{{ $parent->eleves->count() }}</td>
                <td>
                    <span class="{{ $parent->statut ? 'statut-active' : 'statut-inactive' }}">
                        {{ $parent->statut ? 'Actif' : 'Inactif' }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Document généré automatiquement par Scolaire Parcours - Page 1
    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>
