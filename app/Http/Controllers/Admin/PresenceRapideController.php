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
    private function isPrimaireClass(?int $classeId): bool
    {
        if (!$classeId) {
            return false;
        }

        $niveau = Classe::find($classeId)?->niveau;

        // Exemples donnés : "CP A" et "6ème A"
        // Règle : primaire = CP/CE/CM (avec ou sans suffixe " A").
        return $niveau !== null && preg_match('/^(CP|CE1|CE2|CM1|CM2)(\s*A)?$/', trim($niveau)) === 1;

    }

    public function create(Request $request)
    {
        $anneeScolaires = AnneeScolaire::orderBy('nom', 'desc')->get();
        $classes = Classe::orderBy('nom')->get();

        $classeId = $request->get('classe_id');
        $anneeScolaireId = $request->get('annee_scolaire_id');
        $date = $request->get('date', now()->toDateString());
        $matiereId = $request->get('matiere_id');
        $enseignantId = $request->get('enseignant_id');

        $isPrimaire = $this->isPrimaireClass($classeId ? (int) $classeId : null);

        $matieres = Matiere::orderBy('nom')->get();
        if ($isPrimaire) {
            $matiereId = null; // Forcer null, mais on garde la liste pour le JS si la classe change côté client
        }

        $enseignants = Enseignant::orderBy('nom')->orderBy('prenom')->get();

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

        $absentsExistants = collect();
        if ($classeId && $anneeScolaireId && $date) {
            $eleveIdsClasse = $eleves->pluck('id');

            $queryAbs = Absence::whereDate('date_absence', $date)
                ->where('annee_scolaire_id', $anneeScolaireId)
                ->whereIn('eleve_id', $eleveIdsClasse);

            if ($isPrimaire) {
                $queryAbs->whereNull('matiere_id');
            } else if ($matiereId) {
                $queryAbs->where('matiere_id', $matiereId);
            }

            $absentsExistants = $queryAbs->pluck('eleve_id')->unique();
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
            'matiere_id' => 'nullable|exists:matieres,id',

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
        $matiereId = isset($validated['matiere_id']) && $validated['matiere_id'] !== null && $validated['matiere_id'] !== ''
            ? (int) $validated['matiere_id']
            : null;
        $enseignantId = $validated['enseignant_id'] ?? null;

        $isPrimaire = $this->isPrimaireClass($classeId);
        if ($isPrimaire) {
            $matiereId = null;
        }

        $eleveIdsClasse = Inscription::where('classe_id', $classeId)
            ->where('annee_scolaire_id', $anneeScolaireId)
            ->whereIn('statut', ['inscrit', 'active', '1', 1, true])
            ->pluck('eleve_id');

        $eleveIdsAbsents = $eleveIdsAbsents->intersect($eleveIdsClasse);

        try {
            DB::beginTransaction();

            $del = Absence::whereDate('date_absence', $date)
                ->where('annee_scolaire_id', $anneeScolaireId)
                ->whereIn('eleve_id', $eleveIdsClasse);

            if ($matiereId) {
                $del->where('matiere_id', $matiereId);
            } else {
                $del->whereNull('matiere_id');
            }

            $del->delete();

            $heureDebut = $validated['heure_debut'] ?? '08:00';
            $heureFin = $validated['heure_fin'] ?? null;
            $motif = $validated['motif'] ?? null;

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

            $query = [
                'classe_id' => $classeId,
                'annee_scolaire_id' => $anneeScolaireId,
                'date' => $date,
                'matiere_id' => $matiereId,
                'enseignant_id' => $enseignantId,
                'justifiee' => $justifiee ? '1' : '0',
            ];

            $query = array_filter($query, fn ($v) => $v !== null);

            return redirect()
                ->route('admin.presences_rapides.create', $query)
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
        $matiereId = $request->get('matiere_id');

        $matiereId = isset($matiereId) && $matiereId !== '' ? (int) $matiereId : null;

        $classe = Classe::find($classeId);
        $anneeScolaire = AnneeScolaire::find($anneeScolaireId);

        $isPrimaire = $this->isPrimaireClass($classeId);
        if ($isPrimaire) {
            $matiereId = null;
        }

        $matiere = $matiereId ? Matiere::find($matiereId) : null;

        $eleveIds = Inscription::where('classe_id', $classeId)
            ->where('annee_scolaire_id', $anneeScolaireId)
            ->whereIn('statut', ['inscrit', 'active', '1', 1, true])
            ->pluck('eleve_id');

        $eleves = Eleve::whereIn('id', $eleveIds)
            ->orderBy('nom')
            ->orderBy('prenom')
            ->get();

        $absentsQuery = Absence::whereDate('date_absence', $date)
            ->where('annee_scolaire_id', $anneeScolaireId)
            ->whereIn('eleve_id', $eleves->pluck('id'));

        if ($matiereId) {
            $absentsQuery->where('matiere_id', $matiereId);
        } else {
            $absentsQuery->whereNull('matiere_id');
        }

        $absents = $absentsQuery->pluck('eleve_id')->unique();

        return view('admin.absences.mark-by-classe-print', compact(
            'classe',
            'anneeScolaire',
            'date',
            'matiere',
            'eleves',
            'absents',
            'isPrimaire'
        ));
    }
}