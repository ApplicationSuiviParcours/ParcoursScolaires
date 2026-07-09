<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absence;
use App\Models\Eleve;
use App\Models\Classe;
use App\Models\Matiere;
use App\Models\AnneeScolaire;
use App\Models\Enseignant;
use App\Models\Inscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class PresenceRapideController extends Controller
{
    public function create(Request $request)
    {
        $anneeScolaires = AnneeScolaire::orderBy('nom', 'desc')->get();
        $classes = Classe::orderBy('nom')->get();
        $matieres = Matiere::orderBy('nom')->get();

        // Enseignants : pour la liste (optionnel dans l’UI)
        // Attention: l'attribut nom_complet est un accessor (pas une colonne en DB), donc on trie sur (nom, prenom).
        $enseignants = Enseignant::orderBy('nom')->orderBy('prenom')->get();

        $classeId = $request->get('classe_id');
        $anneeScolaireId = $request->get('annee_scolaire_id');
        $date = $request->get('date', now()->toDateString());
        $matiereId = $request->get('matiere_id');
        $enseignantId = $request->get('enseignant_id');

        $eleves = collect();
        if ($classeId && $anneeScolaireId) {
            $eleveIds = Inscription::where('classe_id', $classeId)
                ->where('annee_scolaire_id', $anneeScolaireId)
                ->whereIn('statut', ['inscrit', 'active', '1', 1, true])
                ->pluck('eleve_id');

            $eleves = Eleve::whereIn('id', $eleveIds)
                ->orderBy('nom')
                ->orderBy('prenom')
                ->get();
        }

        // Pré-remplir absents existants pour la sélection
        $absentsExistants = collect();
        if ($classeId && $anneeScolaireId && $matiereId && $date) {
            $absentsExistants = Absence::whereDate('date_absence', $date)
                ->where('annee_scolaire_id', $anneeScolaireId)
                ->where('matiere_id', $matiereId)
                ->whereIn('eleve_id', $eleves->pluck('id'))
                ->pluck('eleve_id')
                ->unique();
        }

        return view('admin.absences.mark-by-classe', compact(
            'anneeScolaires',
            'classes',
            'matieres',
            'enseignants',
            'classeId',
            'anneeScolaireId',
            'date',
            'matiereId',
            'enseignantId',
            'eleves',
            'absentsExistants'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'classe_id' => 'required|exists:classes,id',
            'annee_scolaire_id' => 'required|exists:annee_scolaires,id',
            'date' => 'required|date',
            'matiere_id' => 'required|exists:matieres,id',
            'enseignant_id' => 'nullable|exists:enseignants,id',
            'justifiee' => 'nullable|boolean',
            'eleve_ids_absents' => 'nullable|array',
            'eleve_ids_absents.*' => 'exists:eleves,id',
            // optional
            'motif' => 'nullable|string|max:500',
            'heure_debut' => 'nullable|date_format:H:i',
            'heure_fin' => 'nullable|date_format:H:i|after:heure_debut',
        ]);

        $justifiee = (bool) ($validated['justifiee'] ?? false);
        $eleveIdsAbsents = collect($validated['eleve_ids_absents'] ?? []);

        $classeId = (int) $validated['classe_id'];
        $anneeScolaireId = (int) $validated['annee_scolaire_id'];
        $date = $validated['date'];
        $matiereId = (int) $validated['matiere_id'];
        $enseignantId = $validated['enseignant_id'] ?? null;

        // Liste des élèves de la classe (sécurité)
        $eleveIdsClasse = Inscription::where('classe_id', $classeId)
            ->where('annee_scolaire_id', $anneeScolaireId)
            ->whereIn('statut', ['inscrit', 'active', '1', 1, true])
            ->pluck('eleve_id');

        $eleveIdsAbsents = $eleveIdsAbsents->whereIn('id', $eleveIdsClasse);

        try {
            DB::beginTransaction();

            // Supprimer les absences existantes pour cette date/matiere/classe (et remettre selon coches)
            // Remarque: comme Absence est liée à eleve_id, on filtre sur la classe via eleveIdsClasse.
            Absence::whereDate('date_absence', $date)
                ->where('annee_scolaire_id', $anneeScolaireId)
                ->where('matiere_id', $matiereId)
                ->whereIn('eleve_id', $eleveIdsClasse)
                ->delete();

            $heureDebut = $validated['heure_debut'] ?? null;
            $heureFin = $validated['heure_fin'] ?? null;
            $motif = $validated['motif'] ?? null;

            // Synchronisation explicite: on ne crée une absence que pour les élèves cochés
            $payloads = [];
            foreach ($eleveIdsAbsents as $eleveId) {
                $payloads[] = [
                    'eleve_id' => $eleveId,
                    'matiere_id' => $matiereId,
                    'annee_scolaire_id' => $anneeScolaireId,
                    'date_absence' => $date,
                    'heure_debut' => $heureDebut,
                    'heure_fin' => $heureFin,
                    'motif' => $motif,
                    'justifiee' => $justifiee,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            if (!empty($payloads)) {
                Absence::insert($payloads);
            }

            DB::commit();

            return redirect()
                ->route('admin.presences_rapides.create', [
                    'classe_id' => $classeId,
                    'annee_scolaire_id' => $anneeScolaireId,
                    'date' => $date,
                    'matiere_id' => $matiereId,
                    'enseignant_id' => $enseignantId,
                    'justifiee' => $justifiee ? '1' : '0',
                ])
                ->with('success', 'Présences enregistrées (absences cochées) avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Erreur lors de l\'enregistrement des présences: ' . $e->getMessage());
        }
    }

    public function print(Request $request)
    {
        $classeId = (int) $request->get('classe_id');
        $anneeScolaireId = (int) $request->get('annee_scolaire_id');
        $date = $request->get('date', now()->toDateString());
        $matiereId = (int) $request->get('matiere_id');
        $enseignantId = $request->get('enseignant_id');
        $justifiee = (bool) ($request->get('justifiee') ?? false);

        $classe = Classe::find($classeId);
        $anneeScolaire = AnneeScolaire::find($anneeScolaireId);
        $matiere = Matiere::find($matiereId);

        $eleveIds = Inscription::where('classe_id', $classeId)
            ->where('annee_scolaire_id', $anneeScolaireId)
            ->whereIn('statut', ['inscrit', 'active', '1', 1, true])
            ->pluck('eleve_id');

        $eleves = Eleve::whereIn('id', $eleveIds)
            ->orderBy('nom')
            ->orderBy('prenom')
            ->get();

        $absents = Absence::whereDate('date_absence', $date)
            ->where('annee_scolaire_id', $anneeScolaireId)
            ->where('matiere_id', $matiereId)
            ->whereIn('eleve_id', $eleves->pluck('id'))
            ->pluck('eleve_id')
            ->unique();

        return view('admin.absences.mark-by-classe-print', compact(
            'classe',
            'anneeScolaire',
            'date',
            'matiere',
            'eleves',
            'absents'
        ));
    }
}