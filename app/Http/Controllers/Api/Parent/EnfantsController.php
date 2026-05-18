<?php

namespace App\Http\Controllers\Api\Parent;

use App\Http\Controllers\Controller;
use App\Http\Resources\EleveResource;
use App\Models\ParentEleve;
use App\Models\Eleve;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class EnfantsController extends Controller
{
    /**
     * List all enfants for authenticated parent.
     */
    public function index(): AnonymousResourceCollection
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user || !$user->isParent()) {
            abort(403, 'Accès réservé aux parents.');
        }

        $parentEleve = ParentEleve::query()->whereHas('user', fn($q) => $q->where('id', $user->id))->first();
        if (!$parentEleve) {
            return EleveResource::collection(collect([]));
        }

        $enfants = $parentEleve->eleves()
            ->with(['classe', 'inscriptionActive.classe.anneeScolaire'])
            ->orderBy('nom', 'asc')
            ->paginate(20);

        // Add quick stats per enfant
        $enfants->getCollection()->transform(function ($eleve) {
            $classeId = $eleve->inscriptionActive?->classe_id ?? $eleve->classe_id;
            $moyenneClasse = 'N/A';
            if ($classeId) {
                $avg = \App\Models\Note::whereHas('evaluation', function($q) use ($classeId) {
                    $q->where('classe_id', $classeId);
                })->avg('note');
                if ($avg !== null) {
                    $moyenneClasse = round($avg, 2);
                }
            }
            $eleve->setAttribute('quick_stats', [
                'moyenne' => round($eleve->notes()->avg('note') ?? 0, 2),
                'moyenne_classe' => $moyenneClasse,
                'absences' => $eleve->absences()->count(),
                'bulletins' => $eleve->bulletins()->count(),
            ]);
            return $eleve;
        });

        $enfants->additional([
            'stats' => [
                'total_enfants' => $enfants->total(),
            ]
        ]);

        return EleveResource::collection($enfants);
    }

    /**
     * Get an enfant's full academic career (parcours).
     */
    public function parcoursEnfant(Request $request, $eleve_id): JsonResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user || !$user->isParent()) {
            abort(403, 'Accès réservé aux parents.');
        }

        $eleve = Eleve::find($eleve_id);
        if (!$eleve) {
            abort(404, 'Enfant non trouvé.');
        }

        // Check if this child belongs to the parent
        $parentEleve = ParentEleve::query()->whereHas('user', fn($q) => $q->where('id', $user->id))->first();
        if (!$parentEleve || !$parentEleve->eleves()->where('eleve_id', $eleve->id)->exists()) {
            abort(403, 'Vous n\'avez pas accès au parcours de cet élève.');
        }

        $historique = $eleve->historique_classes;

        return response()->json([
            'eleve' => [
                'id' => $eleve->id,
                'nom_complet' => $eleve->nom_complet,
                'matricule' => $eleve->matricule,
                'photo' => $eleve->photo ? asset('storage/' . $eleve->photo) : null,
            ],
            'stats' => [
                'nombre_annees' => $historique->count(),
                'moyenne_globale' => round($eleve->moyenne_generale ?? 0, 2),
                'total_bulletins' => $eleve->bulletins->count(),
            ],
            'historique' => $historique->map(function ($item) use ($eleve) {
                $bulletinsAnnee = $eleve->bulletins
                    ->where('annee_scolaire_id', $item['annee_scolaire']->id);

                $bT1 = $bulletinsAnnee->firstWhere('periode', 'Trimestre 1');
                $bT2 = $bulletinsAnnee->firstWhere('periode', 'Trimestre 2');
                $bT3 = $bulletinsAnnee->firstWhere('periode', 'Trimestre 3');

                $moyenneAnnuelle = $bulletinsAnnee->isNotEmpty()
                    ? round($bulletinsAnnee->avg('moyenne_generale'), 2)
                    : null;

                return [
                    'annee_scolaire' => [
                        'id'  => $item['annee_scolaire']->id,
                        'nom' => $item['annee_scolaire']->nom,
                    ],
                    'classe' => [
                        'id'     => $item['classe']->id,
                        'nom'    => $item['classe']->nom,
                        'niveau' => $item['classe']->niveau,
                    ],
                    'date_inscription'  => $item['date_inscription'],
                    'statut'            => $item['statut'],
                    'observation'       => $item['observation'],
                    'est_redoublant'    => $item['est_redoublant'] ?? false,
                    'moyenne_annuelle'  => $moyenneAnnuelle,
                    'trimestres' => [
                        'Trimestre 1' => $bT1 ? ['moyenne' => round($bT1->moyenne_generale, 2), 'rang' => $bT1->rang, 'effectif' => $bT1->effectif_classe] : null,
                        'Trimestre 2' => $bT2 ? ['moyenne' => round($bT2->moyenne_generale, 2), 'rang' => $bT2->rang, 'effectif' => $bT2->effectif_classe] : null,
                        'Trimestre 3' => $bT3 ? ['moyenne' => round($bT3->moyenne_generale, 2), 'rang' => $bT3->rang, 'effectif' => $bT3->effectif_classe] : null,
                    ],
                ];
            }),
        ]);
    }

    /**
     * Export the child's success certificate as a PDF file for mobile.
     */
    public function certificat(Request $request, $eleve_id, $anneeScolaireId)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user || !$user->isParent()) {
            abort(403, 'Accès réservé aux parents.');
        }

        $eleve = Eleve::find($eleve_id);
        if (!$eleve) {
            abort(404, 'Enfant non trouvé.');
        }

        // Check relationship
        $parentEleve = ParentEleve::query()->whereHas('user', fn($q) => $q->where('id', $user->id))->first();
        if (!$parentEleve || !$parentEleve->eleves()->where('eleve_id', $eleve->id)->exists()) {
            abort(403, 'Vous n\'avez pas accès au parcours de cet élève.');
        }

        $anneeScolaire = \App\Models\AnneeScolaire::findOrFail($anneeScolaireId);

        $inscription = \App\Models\Inscription::where('eleve_id', $eleve->id)
            ->where('annee_scolaire_id', $anneeScolaire->id)
            ->with('classe')
            ->first();

        if (!$inscription) {
            return response()->json(['error' => 'Aucune inscription trouvée pour cette année scolaire.'], 404);
        }

        $bulletinsAnnee = $eleve->bulletins->where('annee_scolaire_id', $anneeScolaire->id);
        $moyenneAnnee = $bulletinsAnnee->isNotEmpty() ? round($bulletinsAnnee->avg('moyenne_generale'), 2) : null;

        if ($moyenneAnnee === null || $moyenneAnnee < 10) {
            return response()->json(['error' => 'Le certificat n\'est pas disponible (moyenne insuffisante).'], 400);
        }

        $mention = 'Passable';
        if ($moyenneAnnee >= 16) {
            $mention = 'Très Bien';
        } elseif ($moyenneAnnee >= 14) {
            $mention = 'Bien';
        } elseif ($moyenneAnnee >= 12) {
            $mention = 'Assez Bien';
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('eleve.exports.certificat-pdf', compact('eleve', 'anneeScolaire', 'inscription', 'moyenneAnnee', 'mention'));
        $pdf->setPaper('A4', 'landscape');

        $filename = 'certificat_reussite_' . $eleve->matricule . '_' . str_replace('/', '-', $anneeScolaire->nom) . '.pdf';

        return response($pdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $filename . '"',
        ]);
    }
}