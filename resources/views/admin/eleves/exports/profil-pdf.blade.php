{{-- resources/views/admin/eleves/exports/profil-pdf.blade.php --}}
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil de l'élève - {{ $eleve->nom }} {{ $eleve->prenom }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', 'Helvetica', 'Arial', sans-serif;
            font-size: 11px;
            line-height: 1.5;
            color: #333;
            background: #fff;
            margin: 0;
            padding: 20px;
        }

        /* En-tête du document */
        .header {
            text-align: center;
            margin-bottom: 25px;
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
            font-size: 14px;
            color: #64748b;
        }

        /* Informations générales */
        .info-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        .info-item {
            display: flex;
            flex-direction: column;
        }

        .info-item .label {
            font-size: 9px;
            font-weight: 600;
            text-transform: uppercase;
            color: #64748b;
            margin-bottom: 3px;
        }

        .info-item .value {
            font-size: 12px;
            font-weight: 500;
            color: #1e293b;
        }

        /* Sections */
        .section {
            margin-bottom: 20px;
        }

        .section-title {
            font-size: 14px;
            font-weight: bold;
            color: #1e293b;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 1px solid #e2e8f0;
        }

        /* Tableaux */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        th {
            background: #f1f5f9;
            font-size: 9px;
            font-weight: 600;
            text-transform: uppercase;
            color: #475569;
            padding: 8px 5px;
            text-align: left;
            border: 1px solid #e2e8f0;
        }

        td {
            padding: 6px 5px;
            border: 1px solid #e2e8f0;
            font-size: 10px;
        }

        .badge-success {
            background: #dcfce7;
            color: #166534;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 9px;
            font-weight: 600;
        }

        .badge-danger {
            background: #fee2e2;
            color: #991b1b;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 9px;
            font-weight: 600;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 9px;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
            padding-top: 15px;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>
    <!-- En-tête -->
    <div class="header">
        <h1>Profil de l'élève</h1>
        <div class="subtitle">{{ $eleve->nom }} {{ $eleve->prenom }} - {{ $eleve->matricule }}</div>
    </div>

    <!-- Informations générales -->
    <div class="info-box">
        <div class="info-grid">
            <div class="info-item">
                <span class="label">Nom complet</span>
                <span class="value">{{ $eleve->nom }} {{ $eleve->prenom }}</span>
            </div>
            <div class="info-item">
                <span class="label">Matricule</span>
                <span class="value">{{ $eleve->matricule }}</span>
            </div>
            <div class="info-item">
                <span class="label">Genre</span>
                <span class="value">{{ $eleve->genre === 'm' ? 'Masculin' : 'Féminin' }}</span>
            </div>
            <div class="info-item">
                <span class="label">Date de naissance</span>
                <span class="value">{{ $eleve->date_naissance->format('d/m/Y') }} ({{ $eleve->date_naissance->age }}
                    ans)</span>
            </div>
            <div class="info-item">
                <span class="label">Lieu de naissance</span>
                <span class="value">{{ $eleve->lieu_naissance }}</span>
            </div>
            <div class="info-item">
                <span class="label">Téléphone</span>
                <span class="value">{{ $eleve->telephone ?? 'Non renseigné' }}</span>
            </div>
            <div class="info-item">
                <span class="label">Email</span>
                <span class="value">{{ $eleve->email ?? 'Non renseigné' }}</span>
            </div>
            <div class="info-item">
                <span class="label">Adresse</span>
                <span class="value">{{ $eleve->adresse }}</span>
            </div>
            <div class="info-item">
                <span class="label">Date d'inscription</span>
                <span class="value">{{ $eleve->date_inscription->format('d/m/Y') }}</span>
            </div>
            <div class="info-item">
                <span class="label">Statut</span>
                <span class="value">
                    @if($eleve->statut)
                        <span class="badge-success">Actif</span>
                    @else
                        <span class="badge-danger">Inactif</span>
                    @endif
                </span>
            </div>
            <div class="info-item">
                <span class="label">Classe actuelle</span>
                <span class="value">
                    @if($eleve->classe)
                        {{ $eleve->classe->nom }} - {{ $eleve->classe->niveau }}
                    @else
                        Non assigné
                    @endif
                </span>
            </div>
        </div>
    </div>

    <!-- Parents -->
    <div class="section">
        <h3 class="section-title">Parents / Tuteurs</h3>
        @if($eleve->parents->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>Nom & Prénom</th>
                        <th>Lien</th>
                        <th>Téléphone</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($eleve->parents as $parent)
                        <tr>
                            <td>{{ $parent->nom }} {{ $parent->prenom }}</td>
                            <td>{{ $parent->pivot->lien_parental ?? 'Non spécifié' }}</td>
                            <td>{{ $parent->telephone ?? 'Non renseigné' }}</td>
                            <td>{{ $parent->email ?? 'Non renseigné' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p style="text-align: center; color: #64748b;">Aucun parent associé</p>
        @endif
    </div>

    <!-- Inscriptions -->
    <div class="section">
        <h3 class="section-title">Historique des inscriptions</h3>
        @if($eleve->inscriptions->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>Classe</th>
                        <th>Année scolaire</th>
                        <th>Date d'inscription</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($eleve->inscriptions as $inscription)
                        <tr>
                            <td>{{ $inscription->classe->nom ?? 'Non définie' }}</td>
                            <td>{{ $inscription->classe->anneeScolaire->nom ?? 'N/A' }}</td>
                            <td>{{ $inscription->date_inscription->format('d/m/Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p style="text-align: center; color: #64748b;">Aucune inscription trouvée</p>
        @endif
    </div>

    @if($eleve->absences->count() > 0 || $eleve->notes->count() > 0 || $eleve->bulletins->count() > 0)
        <div class="page-break"></div>

        <!-- Absences -->
        @if($eleve->absences->count() > 0)
            <div class="section">
                <h3 class="section-title">Absences</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Matière</th>
                            <th>Durée</th>
                            <th>Statut</th>
                            <th>Motif</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($eleve->absences as $absence)
                            <tr>
                                <td>{{ $absence->date_absence->format('d/m/Y') }}</td>
                                <td>{{ $absence->matiere->nom ?? 'Non définie' }}</td>
                                <td>
                                    @if($absence->heure_debut && $absence->heure_fin)
                                        {{ \Carbon\Carbon::parse($absence->heure_debut)->format('H:i') }} -
                                        {{ \Carbon\Carbon::parse($absence->heure_fin)->format('H:i') }}
                                    @else
                                        1h
                                    @endif
                                </td>
                                <td>
                                    @if($absence->justifiee)
                                        <span class="badge-success">Justifiée</span>
                                    @else
                                        <span class="badge-danger">Non justifiée</span>
                                    @endif
                                </td>
                                <td>{{ $absence->motif ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <!-- Notes récentes -->
        @if($eleve->notes->count() > 0)
            <div class="section">
                <h3 class="section-title">Dernières notes</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Évaluation</th>
                            <th>Note</th>
                            <th>Observation</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($eleve->notes as $note)
                            <tr>
                                <td>{{ $note->evaluation->nom ?? 'Non définie' }}</td>
                                <td><strong>{{ number_format($note->note, 2) }}/20</strong></td>
                                <td>{{ $note->observation ?? '-' }}</td>
                                <td>{{ $note->created_at->format('d/m/Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <!-- Bulletins -->
        @if($eleve->bulletins->count() > 0)
            <div class="section">
                <h3 class="section-title">Bulletins</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Période</th>
                            <th>Classe</th>
                            <th>Moyenne</th>
                            <th>Rang</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($eleve->bulletins as $bulletin)
                            <tr>
                                <td>{{ $bulletin->periode }}</td>
                                <td>{{ $bulletin->classe->nom ?? 'Non définie' }}</td>
                                <td><strong>{{ number_format($bulletin->moyenne_generale, 2) }}/20</strong></td>
                                <td>{{ $bulletin->rang }} / {{ $bulletin->effectif_classe }}</td>
                                <td>{{ $bulletin->date_bulletin->format('d/m/Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    @endif

    <!-- Pied de page -->
    <div class="footer">
        Document généré le {{ now()->format('d/m/Y à H:i') }} - GEST'PARC &copy; {{ date('Y') }}
    </div>
</body>

</html>