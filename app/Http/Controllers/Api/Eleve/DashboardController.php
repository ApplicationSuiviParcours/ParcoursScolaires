<?php

namespace App\Http\Controllers\Api\Eleve;

use App\Http\Controllers\Controller;
use App\Http\Resources\NoteResource;
use App\Http\Resources\AbsenceResource;
use App\Http\Resources\BulletinResource;
use App\Http\Resources\ClasseResource;
use App\Models\Note;
use App\Models\Absence;
use App\Models\Bulletin;
use App\Models\Eleve;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Get eleve dashboard: own stats, recent notes/absences/bulletins/classe.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        if (!$user->isEleve()) abort(403);

        $eleve = $user->eleve;
        if (!$eleve) abort(404, 'Elève non trouvé.');

        $classe = $eleve->classe ?? $eleve->inscriptionActive?->classe;
        $annee = $eleve->inscriptionActive?->anneeScolaire;

        // Recent data (last 30 days or current periode)
        $notes = Note::where('eleve_id', $eleve->id)
            ->with(['evaluation.matiere'])
            ->latest()
            ->limit(10)
            ->get();

        $absences = Absence::where('eleve_id', $eleve->id)
            ->with(['matiere'])
            ->where('date_absence', '>=', now()->subDays(30))
            ->latest('date_absence')
            ->limit(10)
            ->get();

        $bulletins = Bulletin::where('eleve_id', $eleve->id)
            ->latest()
            ->limit(3)
            ->get();

        return response()->json([
            'eleve' => new \App\Http\Resources\EleveResource($eleve),
            'classe' => $classe ? new ClasseResource($classe) : null,
            'annee' => $annee ? new \App\Http\Resources\AnneeScolaireResource($annee) : null,
            'stats' => [
                'moyenne_generale' => round($notes->avg('note') ?? 0, 2),
                'total_notes' => $notes->count(),
                'total_absences' => $absences->count(),
                'absences_non_justifiees' => $absences->where('justifiee', false)->count(),
                'nb_bulletins' => $bulletins->count(),
            ],
            'recent' => [
                'notes' => NoteResource::collection($notes),
                'absences' => AbsenceResource::collection($absences),
                'bulletins' => BulletinResource::collection($bulletins),
            ],
        ]);
    }
}