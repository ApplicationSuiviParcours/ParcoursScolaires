<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Enseignants - Scolaire Parcours</title>
    <style>
        @page {
            size: A4 landscape;
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
            border-bottom: 2px solid #1e88e5;
            padding-bottom: 10px;
        }

        .header h1 {
            color: #1e88e5;
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
            background-color: #e3f2fd;
            color: #1e88e5;
            text-align: left;
            padding: 10px;
            border-bottom: 2px solid #90caf9;
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
        <h1>Liste des Enseignants</h1>
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
                <th>Spécialité</th>
                <th>Âge</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            @foreach($enseignants as $enseignant)
            <tr>
                <td>{{ $enseignant->matricule }}</td>
                <td><strong>{{ $enseignant->nom }}</strong> {{ $enseignant->prenom }}</td>
                <td>{{ $enseignant->genre == 'm' ? 'M' : 'F' }}</td>
                <td>{{ $enseignant->telephone }}</td>
                <td>{{ $enseignant->email }}</td>
                <td>{{ $enseignant->specialite }}</td>
                <td>{{ $enseignant->age ?? 'N/A' }}</td>
                <td>
                    <span class="{{ $enseignant->statut ? 'statut-active' : 'statut-inactive' }}">
                        {{ $enseignant->statut ? 'Actif' : 'Inactif' }}
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
            // Uniquement si on n'est pas en train de générer un PDF via DomPDF
            if (!window.isDomPDF) {
                window.print();
            }
        }
    </script>
</body>
</html>
