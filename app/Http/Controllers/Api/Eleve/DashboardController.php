<?php

namespace App\Http\Controllers\Api\Eleve;

use App\Http\Controllers\Controller;
use App\Http\Resources\NoteResource;
use App\Http\Resources\AbsenceResource;
use App\Http\Resources\BulletinResource;
use App\Http\Resources\ClasseResource;
use App\Http\Resources\AnneeScolaireResource;
use App\Http\Resources\EleveResource;
use App\Models\Note;
use App\Models\Absence;
use App\Models\Bulletin;
use App\Models\Eleve;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Get eleve dashboard: own stats, recent notes/absences/bulletins/classe.
     */
    public function index(Request $request): JsonResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user || !$user->isEleve()) abort(403);

        $eleve = $user->eleve;
        if (!$eleve) abort(404, 'Elève non trouvé.');

        $eleve->load(['inscriptionActive.classe.anneeScolaire', 'classe']);
        $classe = $eleve->inscriptionActive?->classe ?? $eleve->classe;
        $annee = $eleve->inscriptionActive?->anneeScolaire ?? ($classe?->anneeScolaire);

        // Recent data
        $notes = Note::query()->where('eleve_id', $eleve->id)
            ->with(['evaluation.matiere'])
            ->latest()
            ->limit(10)
            ->get();

        $absences = Absence::query()->where('eleve_id', $eleve->id)
            ->with(['matiere'])
            ->latest('date_absence')
            ->limit(10)
            ->get();

        $bulletins = Bulletin::query()->where('eleve_id', $eleve->id)
            ->with(['classe', 'anneeScolaire'])
            ->latest()
            ->limit(3)
            ->get();

        $bulletinCourant = $bulletins->first();

        // Calculer les moyennes par matière (comme sur le web)
        $allNotes = Note::query()->where('eleve_id', $eleve->id)
            ->with('evaluation.matiere')
            ->get();

        $notesParMatiere = [];
        foreach ($allNotes as $note) {
            if ($note->evaluation && $note->evaluation->matiere) {
                $matiereId = $note->evaluation->matiere->id;
                $matiereNom = $note->evaluation->matiere->nom;
                if (!isset($notesParMatiere[$matiereId])) {
                    $notesParMatiere[$matiereId] = [
                        'id' => $matiereId,
                        'nom' => $matiereNom,
                        'somme' => 0,
                        'count' => 0
                    ];
                }
                $notesParMatiere[$matiereId]['somme'] += $note->note;
                $notesParMatiere[$matiereId]['count']++;
            }
        }

        $moyennesParMatiere = collect($notesParMatiere)->map(function ($m) {
            return [
                'id' => $m['id'],
                'nom' => $m['nom'],
                'moyenne' => round($m['somme'] / $m['count'], 2),
                'nb_notes' => $m['count'],
            ];
        })->values();

        return response()->json([
            'eleve' => new EleveResource($eleve),
            'classe' => $classe ? new ClasseResource($classe) : null,
            'annee' => $annee ? new AnneeScolaireResource($annee) : null,
            'stats' => [
                'moyenne_generale' => $eleve->moyenne_generale ?? ($allNotes->avg('note') ? round($allNotes->avg('note'), 2) : 0),
                'total_notes' => $allNotes->count(),
                'total_absences' => $eleve->absences()->count(),
                'absences_non_justifiees' => $eleve->absences()->where('justifiee', false)->count(),
                'nb_bulletins' => $eleve->bulletins()->count(),
                'moyennes_par_matiere' => $moyennesParMatiere,
            ],
            'bulletin_recent' => $bulletinCourant ? [
                'id' => $bulletinCourant->id,
                'periode' => $bulletinCourant->periode,
                'moyenne' => $bulletinCourant->moyenne_generale,
                'rang' => $bulletinCourant->rang,
                'appreciation' => $bulletinCourant->appreciation,
            ] : null,
            'recent' => [
                'notes' => NoteResource::collection($notes),
                'absences' => AbsenceResource::collection($absences),
                'bulletins' => BulletinResource::collection($bulletins),
            ],
        ]);
    }
}