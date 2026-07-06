<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Bulletin de Notes — {{ $bulletin->eleve->nom }} {{ $bulletin->eleve->prenom }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10px;
            background: #f5f0e0;
            color: #111;
            padding: 15px;
        }

        .page {
            background: #fffdf5;
            border: 2px solid #333;
            max-width: 780px;
            margin: 0 auto;
            padding: 12px 16px;
        }

        /* ─── EN-TÊTE ─── */
        .header {
            display: table;
            width: 100%;
            border-bottom: 2px solid #333;
            padding-bottom: 8px;
            margin-bottom: 8px;
        }
        .header-left, .header-center, .header-right {
            display: table-cell;
            vertical-align: top;
        }
        .header-left { width: 33%; font-size: 8px; line-height: 1.5; }
        .header-center { width: 34%; text-align: center; }
        .header-right { width: 33%; text-align: right; font-size: 8px; line-height: 1.5; }

        .school-name {
            font-size: 13px;
            font-weight: bold;
            text-transform: uppercase;
            text-align: right;
        }
        .header-left strong { font-size: 8.5px; text-transform: uppercase; }

        .logo-circle {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            border: 2px solid #555;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 7px;
            text-align: center;
            background: #f0e8d0;
            font-weight: bold;
        }

        /* ─── TITRE ─── */
        .bulletin-title {
            text-align: center;
            font-size: 13px;
            font-weight: bold;
            text-transform: uppercase;
            border: 1.5px solid #333;
            padding: 4px 10px;
            margin-bottom: 8px;
            letter-spacing: 1px;
        }

        /* ─── FICHE ÉLÈVE ─── */
        .eleve-section {
            display: table;
            width: 100%;
            border: 1px solid #888;
            margin-bottom: 8px;
        }
        .eleve-photo {
            display: table-cell;
            width: 55px;
            border-right: 1px solid #888;
            vertical-align: middle;
            text-align: center;
            padding: 4px;
        }
        .eleve-photo .photo-box {
            width: 48px;
            height: 55px;
            border: 1px solid #aaa;
            display: inline-block;
            background: #eee;
            line-height: 55px;
            text-align: center;
            font-size: 8px;
            color: #777;
        }
        .eleve-photo .photo-box img {
            width: 48px;
            height: 55px;
            object-fit: cover;
        }
        .eleve-infos {
            display: table-cell;
            padding: 6px 10px;
            vertical-align: top;
        }
        .eleve-infos table { width: 100%; border: none; }
        .eleve-infos td { padding: 1px 4px; font-size: 9px; border: none; }
        .eleve-infos .lbl { font-weight: bold; white-space: nowrap; }

        /* ─── TABLEAU NOTES ─── */
        .notes-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
            font-size: 8.5px;
        }
        .notes-table th, .notes-table td {
            border: 1px solid #888;
            padding: 2px 4px;
            text-align: center;
        }
        .notes-table th {
            background: #ddd;
            font-weight: bold;
            font-size: 8px;
            text-transform: uppercase;
        }
        .notes-table .matiere-name {
            text-align: left;
            font-size: 8.5px;
        }
        .notes-table .classe-header {
            background: #ccc;
            font-size: 7.5px;
        }
        .notes-table .maitrise-header {
            background: #ccc;
            font-size: 7.5px;
        }
        .notes-table .total-row td {
            background: #f0f0f0;
            font-weight: bold;
            font-size: 8px;
        }
        .notes-table .total-row .total-label {
            text-align: right;
            padding-right: 6px;
        }
        .notes-table .sous-total-label {
            text-align: right;
            font-weight: bold;
            font-size: 8px;
        }
        .checkbox-cell {
            font-size: 12px;
            line-height: 1;
        }
        .note-eleve-cell {
            font-weight: bold;
            font-size: 9px;
        }

        /* ─── PIED DE PAGE ─── */
        .footer-section {
            border: 1.5px solid #555;
            margin-bottom: 8px;
        }
        .footer-grid {
            display: table;
            width: 100%;
        }
        .footer-col {
            display: table-cell;
            vertical-align: top;
            padding: 6px 8px;
            border-right: 1px solid #888;
            font-size: 8.5px;
        }
        .footer-col:last-child { border-right: none; }
        .footer-col .label { font-weight: bold; text-transform: uppercase; font-size: 7.5px; }
        .footer-col .value { font-size: 10px; font-weight: bold; }

        .observation-box {
            border-left: 1px solid #888;
            padding: 6px 10px;
            min-height: 50px;
        }

        /* ─── SIGNATURES ─── */
        .signatures {
            display: table;
            width: 100%;
            margin-top: 10px;
        }
        .sig-cell {
            display: table-cell;
            text-align: center;
            width: 33.33%;
            padding: 0 10px;
        }
        .sig-cell .sig-title {
            font-weight: bold;
            font-size: 8.5px;
            text-transform: uppercase;
            margin-bottom: 30px;
        }
        .sig-cell .sig-line {
            border-top: 1px solid #555;
            margin-top: 5px;
            padding-top: 2px;
            font-size: 7.5px;
        }

        @media print {
            body { padding: 0; background: white; }
            .page { border: 2px solid #333; margin: 0; }
            * { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        }
    </style>
</head>
<body>
<div class="page">

    {{-- ══════ EN-TÊTE ══════ --}}
    <div class="header">
        <div class="header-left">
            <strong>MINISTÈRE DE L'ÉDUCATION NATIONALE</strong><br>
            , CHARGÉ DE LA FORMATION CIVIQUE<br>
            ★★★★★★★★★<br>
            <strong>SECRÉTARIAT GÉNÉRAL</strong><br>
            ★★★★★★★★★<br>
            DIRECTION D'ACADÉMIE PROVINCIALE
        </div>
        <div class="header-center">
            <div class="logo-circle">
                @if(isset($bulletin->classe) && $bulletin->classe)
                    <span>JEAN<br>PIAGET</span>
                @else
                    <span>JP</span>
                @endif
            </div>
        </div>
        <div class="header-right">
            <div class="school-name">ECOLE PRIVEE LAIQUE JEAN PIAGET</div>
            Pré-primaire / Primaire<br>
            Discipline Panéénième-Résuelle<br>
            66327443 / 74145088<br>
            B.P: 20256<br>
            jeanpiaget094@gmail.com
        </div>
    </div>

    {{-- ══════ TITRE ══════ --}}
    <div class="bulletin-title">
        BULLETIN DE NOTES {{ strtoupper($bulletin->periode) }}
    </div>

    {{-- ══════ INFORMATIONS ÉLÈVE ══════ --}}
    @php
        $eleve = $bulletin->eleve;
        $classe = $bulletin->classe;
        $anneeScolaire = $bulletin->anneeScolaire;
        $sexe = $eleve->genre === 'm' ? 'M' : 'F';

        // Récupérer l'enseignant principal de la classe si disponible
        $enseignantNom = '';
        if ($classe) {
            $enseignantClasse = \App\Models\EnseignantMatiereClasse::with('enseignant')
                ->where('classe_id', $classe->id)
                ->first();
            $enseignantNom = $enseignantClasse?->enseignant?->nom_complet ?? '';
        }

        // Effectif de la classe
        $effectif = $bulletin->effectif_classe ?? \App\Models\Inscription::where('classe_id', $bulletin->classe_id)
            ->where('annee_scolaire_id', $bulletin->annee_scolaire_id)
            ->whereIn('statut', ['inscrit', 'active', '1', 1, true])
            ->count();
    @endphp

    <div class="eleve-section">
        <div class="eleve-photo">
            <div class="photo-box">
                @if($eleve->photo)
                    @php
                        // public_path() pour DomPDF (chemin système absolu)
                        // asset() pour le navigateur (URL web)
                        $photoPath = public_path('storage/' . $eleve->photo);
                        $photoUrl = asset('storage/' . $eleve->photo);
                    @endphp
                    <img src="{{ $photoUrl }}" 
                         alt="Photo {{ $eleve->prenom }}"
                         style="width:100%; height:100%; object-fit:cover;">
                @else
                    <div style="display:flex; flex-direction:column; align-items:center; justify-content:center; height:100%; color:#aaa; font-size:8px;">
                        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span>Photo</span>
                    </div>
                @endif
            </div>
        </div>
        <div class="eleve-infos">
            <table>
                <tr>
                    <td class="lbl">Noms &amp; Prénoms :</td>
                    <td><strong>{{ strtoupper($eleve->nom) }} {{ $eleve->prenom }}</strong></td>
                    <td class="lbl">Sexe :</td>
                    <td>{{ $sexe }}</td>
                </tr>
                <tr>
                    <td class="lbl">Né(e) le :</td>
                    <td>{{ $eleve->date_naissance ? $eleve->date_naissance->format('d/m/Y') : 'N/A' }} à {{ $eleve->lieu_naissance ?? 'N/A' }}</td>
                    <td class="lbl">Classe :</td>
                    <td>{{ $classe?->nom ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="lbl">Matricule :</td>
                    <td>{{ $eleve->matricule }}</td>
                    <td class="lbl">Effectif :</td>
                    <td>{{ $effectif }}</td>
                </tr>
                <tr>
                    <td class="lbl">Enseignant(e) :</td>
                    <td colspan="3">{{ $enseignantNom ?: 'N/A' }}</td>
                </tr>
            </table>
        </div>
    </div>

    {{-- ══════ TABLEAU DES NOTES (avec sous-totaux par domaine) ══════ --}}
    @php
        // Regrouper les matières par VRAI domaine pédagogique.
        // On ne déduit plus le domaine depuis le code (CB1/CB2 se répète dans
        // plusieurs domaines sur le bulletin papier, donc ce n'était pas fiable).
        // Ici on suppose que chaque matière a un champ/relation "domaine".
        // Adapter la ligne ci-dessous si ta structure de données est différente.
        $domainesData = [];
        foreach ($notesParMatiere as $matiereId => $data) {
            $nomMatiere = strtolower($data['matiere_nom'] ?? ($data['matiere']->nom ?? ''));
            $codeMatiere = strtoupper($data['matiere_code'] ?? ($data['matiere']->code ?? ''));
            
            if (str_contains($nomMatiere, 'math') || str_contains($codeMatiere, 'MATH') || str_contains($nomMatiere, 'numér') || str_contains($nomMatiere, 'géom') || str_contains($codeMatiere, 'MAT')) {
                $domaine = 'MATHEMATIQUES';
            } elseif (str_contains($nomMatiere, 'fran') || str_contains($nomMatiere, 'anglais') || str_contains($nomMatiere, 'lang') || str_contains($nomMatiere, 'lect') || str_contains($nomMatiere, 'écri') || str_contains($codeMatiere, 'FRA') || str_contains($codeMatiere, 'ANG')) {
                $domaine = 'COMMUNICATION';
            } else {
                $domaine = 'EVEIL';
            }
            $domainesData[$domaine][$matiereId] = $data;
        }

        // Libellés d'affichage pour chaque domaine (adapter selon tes valeurs réelles en base)
        $libellesDomaines = [
            'COMMUNICATION' => 'COMMUNICATION ET EXPRESSION',
            'EVEIL'         => 'EVEIL',
            'MATHEMATIQUES' => 'MATHÉMATIQUES',
            'AUTRES'        => 'AUTRES MATIÈRES',
        ];

        // Statistiques de classe par matière (MAX, MOY, MIN)
        $statsClasse = [];
        $tousLesBulletins = \App\Models\Bulletin::where('classe_id', $bulletin->classe_id)
            ->where('annee_scolaire_id', $bulletin->annee_scolaire_id)
            ->where('periode', $bulletin->periode)
            ->with(['eleve'])
            ->get();

        foreach ($notesParMatiere as $matiereId => $data) {
            $notes_classe = [];
            foreach ($tousLesBulletins as $b) {
                $notesEleve = \App\Models\Note::where('eleve_id', $b->eleve_id)
                    ->whereHas('evaluation', function($q) use ($bulletin, $matiereId) {
                        $q->where('annee_scolaire_id', $bulletin->annee_scolaire_id)
                          ->where('classe_id', $bulletin->classe_id)
                          ->where('periode', $bulletin->periode)
                          ->where('matiere_id', $matiereId);
                    })
                    ->get();

                if ($notesEleve->isNotEmpty()) {
                    $totalP = 0; $totalC = 0;
                    foreach ($notesEleve as $n) {
                        $c = $n->evaluation?->coefficient ?? 1;
                        $totalP += $n->note * $c;
                        $totalC += $c;
                    }
                    if ($totalC > 0) $notes_classe[] = round($totalP / $totalC, 2);
                }
            }
            $statsClasse[$matiereId] = [
                'max' => !empty($notes_classe) ? max($notes_classe) : 0,
                'moy' => !empty($notes_classe) ? round(array_sum($notes_classe) / count($notes_classe), 2) : 0,
                'min' => !empty($notes_classe) ? min($notes_classe) : 0,
            ];
        }

        // Moyennes des paliers précédents (depuis les autres bulletins de l'élève)
        $paliers = ['Trimestre 1', 'Trimestre 2', 'Trimestre 3'];
        $moyennesPaliers = [];
        foreach ($paliers as $idx => $palier) {
            $b = \App\Models\Bulletin::where('eleve_id', $eleve->id)
                ->where('annee_scolaire_id', $bulletin->annee_scolaire_id)
                ->where('periode', $palier)
                ->first();
            $moyennesPaliers[$idx + 1] = $b ? number_format($b->moyenne_generale, 2) : '--';
        }

        // Totaux généraux (toutes matières confondues, tous domaines)
        $totalPointsGeneral = 0;
        $totalCoeffsGeneral = 0;
        foreach ($notesParMatiere as $mId => $d) {
            $coeff = $d['coefficient_total'] ?? $d['coefficient'] ?? 1;
            $totalPointsGeneral += ($d['moyenne'] ?? 0) * $coeff;
            $totalCoeffsGeneral += $coeff;
        }
        $totalNotes = array_sum(array_map(fn($d) => $d['moyenne'] ?? 0, $notesParMatiere));
        $moyenneCalc = $totalCoeffsGeneral > 0 ? round($totalPointsGeneral / $totalCoeffsGeneral, 2) : 0;
    @endphp

    <table class="notes-table">
        <thead>
            <tr>
                <th rowspan="2" style="width:34%; text-align:left; padding-left:5px;">MATIÈRES</th>
                <th colspan="3" class="classe-header">NOTES DE LA CLASSE</th>
                <th rowspan="2" style="width:12%;">NOTES DE L'ÉLÈVE</th>
                <th colspan="4" class="maitrise-header">NIVEAU DE MAITRISE</th>
            </tr>
            <tr>
                <th class="classe-header" style="width:7%;">MAX</th>
                <th class="classe-header" style="width:7%;">MOY</th>
                <th class="classe-header" style="width:7%;">MIN</th>
                <th style="width:5%; background:#ddd;">A</th>
                <th style="width:5%; background:#ddd;">B</th>
                <th style="width:5%; background:#ddd;">C</th>
                <th style="width:5%; background:#ddd;">D</th>
            </tr>
        </thead>
        <tbody>
            @foreach($domainesData as $domaineKey => $matieresDuDomaine)
                @php
                    $totalPointsDomaine = 0;
                    $totalCoeffsDomaine = 0;
                    $sommeNotesDomaine = 0;
                @endphp

                @foreach($matieresDuDomaine as $matiereId => $data)
                    @php
                        $matiereNom = $data['matiere_nom'] ?? ($data['matiere']->nom ?? 'Matière');
                        $code = $data['matiere_code'] ?? ($data['matiere']->code ?? '');
                        $noteEleve = $data['moyenne'] ?? 0;
                        $sc = $statsClasse[$matiereId] ?? ['max' => 0, 'moy' => 0, 'min' => 0];
                        $coeffMatiere = $data['coefficient_total'] ?? $data['coefficient'] ?? 1;

                        $totalPointsDomaine += $noteEleve * $coeffMatiere;
                        $totalCoeffsDomaine += $coeffMatiere;
                        $sommeNotesDomaine  += $noteEleve;

                        // Niveau de maîtrise selon la note
                        $niveauA = $noteEleve >= 9 ? '☑' : '☐';
                        $niveauB = ($noteEleve >= 6 && $noteEleve < 9) ? '☑' : '☐';
                        $niveauC = ($noteEleve >= 3 && $noteEleve < 6) ? '☑' : '☐';
                        $niveauD = $noteEleve < 3 ? '☑' : '☐';
                    @endphp
                    <tr>
                        <td class="matiere-name">
                            @if($code)<span style="font-weight:bold; font-size:7.5px;">{{ $code }}</span> @endif
                            {{ $matiereNom }}
                            @if(!empty($data['notes']))
                                <div style="font-size: 7px; color: #666; margin-top: 2px; font-weight: normal; font-style: italic;">
                                    Notes : 
                                    @php
                                        $formattedNotes = [];
                                        foreach ($data['notes'] as $n) {
                                            $val = is_object($n) ? ($n->note ?? $n->valeur ?? 0) : ($n['valeur'] ?? $n['note'] ?? 0);
                                            $formattedNotes[] = number_format($val, 2);
                                        }
                                    @endphp
                                    {{ implode(' ; ', $formattedNotes) }}
                                </div>
                            @endif
                        </td>
                        <td>{{ number_format($sc['max'], 2) }}</td>
                        <td>{{ number_format($sc['moy'], 2) }}</td>
                        <td>{{ number_format($sc['min'], 2) }}</td>
                        <td class="note-eleve-cell">{{ number_format($noteEleve, 2) }}</td>
                        <td class="checkbox-cell">{{ $niveauA }}</td>
                        <td class="checkbox-cell">{{ $niveauB }}</td>
                        <td class="checkbox-cell">{{ $niveauC }}</td>
                        <td class="checkbox-cell">{{ $niveauD }}</td>
                    </tr>
                @endforeach

                {{-- ─── Sous-total du domaine (ex: TOTAL EVEIL / MOYENNE EVEIL) ─── --}}
                @php
                    $moyenneDomaine = $totalCoeffsDomaine > 0 ? round($totalPointsDomaine / $totalCoeffsDomaine, 2) : 0;
                    $libelle = $libellesDomaines[$domaineKey] ?? strtoupper($domaineKey);
                @endphp
                <tr class="total-row">
                    <td colspan="4" class="sous-total-label">
                        TOTAL {{ $libelle }}<br>MOYENNE {{ $libelle }}
                    </td>
                    <td style="font-weight:bold;">
                        {{ number_format($sommeNotesDomaine, 2) }}<br>{{ number_format($moyenneDomaine, 2) }}
                    </td>
                    <td colspan="4" style="font-size:7.5px;">Maîtrise maximale</td>
                </tr>
            @endforeach

            {{-- ─── TOTAL GÉNÉRAL ─── --}}
            <tr class="total-row">
                <td class="sous-total-label">TOTAL GÉNÉRAL</td>
                <td colspan="3"></td>
                <td style="font-weight:bold;">{{ number_format($totalNotes, 2) }}</td>
                <td colspan="4" style="font-size:7.5px; text-align:left; padding-left:4px;">Maîtrise maximale</td>
            </tr>
            <tr class="total-row">
                <td class="sous-total-label">MOYENNE GÉNÉRALE</td>
                <td colspan="3"></td>
                <td style="font-weight:bold; font-size:10px;">{{ number_format($moyenneGenerale ?? $moyenneCalc, 2) }}</td>
                <td colspan="4"></td>
            </tr>
        </tbody>
    </table>

    {{-- ══════ PIED DE PAGE ══════ --}}
    <div class="footer-section">
        <div class="footer-grid">
            <div class="footer-col" style="width: 35%;">
                <div>
                    <span class="label">TOTAL GÉNÉRAL</span>
                    <span style="float:right; font-weight:bold;">{{ number_format($totalNotes, 2) }}</span>
                </div>
                <div style="margin-top:3px;">
                    <span class="label">MOY. GÉNÉRALE DE L'ÉLÈVE</span>
                    <span style="float:right; font-weight:bold;">{{ number_format($moyenneGenerale ?? $moyenneCalc, 2) }}</span>
                </div>
                <div style="margin-top:3px;">
                    <span class="label">RANG</span>
                    <span style="float:right; font-weight:bold;">{{ $bulletin->rang ?? '--' }}</span>
                </div>
                <div style="margin-top:3px;">
                    <span class="label">MOY. ANNUELLE</span>
                    <span style="float:right; font-weight:bold;">
                        @php
                            $allBulletinsEleve = \App\Models\Bulletin::where('eleve_id', $eleve->id)
                                ->where('annee_scolaire_id', $bulletin->annee_scolaire_id)
                                ->get();
                            $moyAnnuelle = $allBulletinsEleve->avg('moyenne_generale');
                        @endphp
                        {{ $moyAnnuelle ? number_format($moyAnnuelle, 2) : '--' }}
                    </span>
                </div>
                <div style="margin-top:3px;">
                    <span class="label">FORTE MOY.</span>
                    <span style="float:right;">{{ number_format($tousLesBulletins->max('moyenne_generale') ?? 0, 2) }}</span>
                </div>
                <div style="margin-top:3px;">
                    <span class="label">FAIBLE MOY.</span>
                    <span style="float:right;">{{ number_format($tousLesBulletins->min('moyenne_generale') ?? 0, 2) }}</span>
                </div>
                <div style="margin-top:3px;">
                    <span class="label">MOY. DE CLASSE</span>
                    <span style="float:right;">{{ number_format($bulletin->moyenne_classe ?? $tousLesBulletins->avg('moyenne_generale') ?? 0, 2) }}</span>
                </div>
            </div>

            <div class="footer-col" style="width: 30%;">
                <div class="label" style="margin-bottom:4px;">MOY. DES PALIERS</div>
                @foreach(['1er Palier', '2e Palier', '3e Palier', '4e Palier', '5e Palier'] as $idx => $palierLabel)
                    @php $numPalier = $idx + 1; @endphp
                    <div style="margin-top:2px;">
                        <span>MOY. {{ $palierLabel }}</span>
                        <span style="float:right; font-weight:bold;">
                            @if($numPalier <= 3)
                                {{ $moyennesPaliers[$numPalier] ?? '--' }}
                            @else
                                --
                            @endif
                        </span>
                    </div>
                @endforeach
            </div>

            <div class="footer-col observation-box" style="width: 35%;">
                <div class="label" style="margin-bottom:6px;">OBSERVATION DU CONSEIL ACADÉMIQUE</div>
                <div style="font-size:14px; font-family: Georgia, serif; color: #c00; margin-top:8px; font-style:italic;">
                    {{ $bulletin->appreciation ?? '' }}
                </div>
            </div>
        </div>
    </div>

    {{-- ══════ SIGNATURES ══════ --}}
    <div class="signatures">
        <div class="sig-cell">
            <div class="sig-title">SIGNATURE DIRECTEUR/TRICE</div>
        </div>
        <div class="sig-cell">
            <div class="sig-title">SIGNATURE ENSEIGNANT(E)</div>
        </div>
        <div class="sig-cell">
            <div class="sig-title">SIGNATURE PARENT</div>
        </div>
    </div>

</div>

<script>
    window.onload = function() { window.print(); }
</script>
</body>
</html>