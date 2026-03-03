{{-- resources/views/admin/eleves/exports/pdf.blade.php --}}
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des élèves</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', 'Helvetica', 'Arial', sans-serif;
            font-size: 10px;
            line-height: 1.4;
            color: #333;
            background: #fff;
            margin: 0;
            padding: 15px;
        }

        /* En-tête */
        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #4f46e5;
        }

        .header h1 {
            font-size: 22px;
            font-weight: bold;
            color: #1e293b;
            margin-bottom: 5px;
        }

        .header .subtitle {
            font-size: 12px;
            color: #64748b;
        }

        /* Informations de génération */
        .info-generation {
            margin-bottom: 20px;
            padding: 10px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 5px;
            font-size: 10px;
        }

        .info-generation p {
            margin: 3px 0;
        }

        /* Statistiques */
        .stats-container {
            margin-bottom: 20px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 8px;
            margin-bottom: 15px;
        }

        .stat-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 5px;
            padding: 8px;
            text-align: center;
        }

        .stat-card .number {
            font-size: 16px;
            font-weight: bold;
            color: #4f46e5;
        }

        .stat-card .label {
            font-size: 8px;
            text-transform: uppercase;
            color: #64748b;
        }

        /* Tableau */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 9px;
        }

        th {
            background: #4f46e5;
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 8px;
            padding: 8px 4px;
            text-align: left;
            border: 1px solid #4338ca;
        }

        td {
            padding: 6px 4px;
            border: 1px solid #e2e8f0;
        }

        tr:nth-child(even) {
            background: #f8fafc;
        }

        tr:hover {
            background: #f1f5f9;
        }

        /* Badges */
        .badge-success {
            background: #22c55e;
            color: white;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 8px;
            font-weight: 600;
            display: inline-block;
        }

        .badge-danger {
            background: #ef4444;
            color: white;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 8px;
            font-weight: 600;
            display: inline-block;
        }

        .badge-warning {
            background: #f59e0b;
            color: white;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 8px;
            font-weight: 600;
            display: inline-block;
        }

        .badge-info {
            background: #3b82f6;
            color: white;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 8px;
            font-weight: 600;
            display: inline-block;
        }

        /* Pied de page */
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 8px;
            color: #94a3b8;
            padding: 10px 0;
            border-top: 1px solid #e2e8f0;
        }

        .page-number {
            text-align: right;
            font-size: 8px;
            color: #94a3b8;
            margin-top: 10px;
        }

        /* Utilitaires */
        .text-left {
            text-align: left;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .font-bold {
            font-weight: bold;
        }

        .mt-2 {
            margin-top: 10px;
        }

        .mb-2 {
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <!-- En-tête -->
    <div class="header">
        <h1>GEST'PARC - Liste des élèves</h1>
        <div class="subtitle">Document généré le {{ now()->format('d/m/Y à H:i') }}</div>
    </div>

    <!-- Informations de génération -->
    <div class="info-generation">
        <p><strong>Généré par :</strong> {{ Auth::user()->name ?? 'Administrateur' }}</p>
        <p><strong>Date d'export :</strong> {{ now()->format('d/m/Y H:i:s') }}</p>
        <p><strong>Nombre total d'élèves :</strong> {{ $eleves->count() }}</p>
    </div>

    

    <!-- Résumé des filtres appliqués -->
    @if(request()->has('search') || request()->has('statut') || request()->has('genre') || request()->has('classe_id'))
        <div class="filters-summary">
            <strong>Filtres appliqués :</strong>
            @if(request('search')) | Recherche: {{ request('search') }} @endif
            @if(request('statut') !== null) | Statut: {{ request('statut') == '1' ? 'Actifs' : 'Inactifs' }} @endif
            @if(request('genre')) | Genre: {{ request('genre') == 'm' ? 'Masculin' : 'Féminin' }} @endif
            @if(request('classe_id')) | Classe ID: {{ request('classe_id') }} @endif
        </div>
    @endif

    <!-- Liste des élèves -->
    <table>
        <thead>
            <tr>
                <th>N°</th>
                <th>Matricule</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Genre</th>
                <th>Date naiss.</th>
                <th>Téléphone</th>
                <th>Email</th>
                <th>Classe</th>
                <th>Statut</th>
                <th>Compte</th>
            </tr>
        </thead>
        <tbody>
            @forelse($eleves as $index => $eleve)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="font-bold">{{ $eleve->matricule }}</td>
                    <td>{{ $eleve->nom }}</td>
                    <td>{{ $eleve->prenom }}</td>
                    <td class="text-center">{{ $eleve->genre === 'm' ? 'M' : 'F' }}</td>
                    <td>{{ $eleve->date_naissance->format('d/m/Y') }}</td>
                    <td>{{ $eleve->telephone ?? '-' }}</td>
                    <td>{{ $eleve->email ?? '-' }}</td>
                    <td>{{ $eleve->classe->nom ?? '-' }}</td>
                    <td class="text-center">
                        @if($eleve->statut)
                            <span class="badge-success">Actif</span>
                        @else
                            <span class="badge-danger">Inactif</span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if($eleve->user)
                            <span class="badge-info">Oui</span>
                        @else
                            <span class="badge-warning">Non</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="11" class="text-center" style="padding: 20px;">
                        Aucun élève trouvé
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Légende -->
    <div style="margin-top: 20px; padding: 10px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 5px;">
        <div style="display: flex; gap: 20px; flex-wrap: wrap;">
            <div>Total des élèves: <span class="font-bold text-black style="margin-right: 5px;">{{ $stats['total'] }}</span></div>
            <div>Total Élève actif: <span class="font-bold text-black style="margin-right: 5px;">{{ $stats['actifs'] }}</span></div>
            <div>Total Élève inactif: <span class="font-bold text-black" style="margin-right: 5px;">{{ $stats['inactifs'] }}</span></div>
            <div>Total Élève Avec compte utilisateur: <span class="font-bold text-black" style="margin-right: 5px;">{{ $stats['avec_compte'] }}</span></span><div>
            <div>Total Élève Sans compte utilisateur: <span class="font-bold text-black" style="margin-right: 5px;">{{ $stats['sans_compte'] }}</span></div>
        </div>
    </div>

    <!-- Pied de page -->
    <div class="footer">
        GEST'PARC - Système de Gestion de Parcours Scolaire
    </div>

    <!-- Numéro de page -->
    <div class="page-number">
        Document généré le {{ now()->format('d/m/Y H:i') }}
    </div>
</body>

</html>