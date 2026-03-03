<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Models\Eleve;
use App\Models\Note;
use App\Models\Matiere;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class NoteController extends Controller
{
    public function index(Request $request, Eleve $eleve)
    {
        $user = Auth::user();
        
        if (!$user->isParent()) {
            abort(403, 'Accès non autorisé.');
        }

        // Récupérer les notes avec toutes les relations nécessaires
        $query = Note::where('eleve_id', $eleve->id)
            ->with([
                'evaluation' => function($q) {
                    $q->with(['matiere']);
                }
            ]);

        // Appliquer les filtres si présents
        if ($request->filled('matiere_id')) {
            $query->whereHas('evaluation', function($q) use ($request) {
                $q->where('matiere_id', $request->matiere_id);
            });
        }

        if ($request->filled('periode')) {
            $query->whereHas('evaluation', function($q) use ($request) {
                $q->where('periode', $request->periode);
            });
        }

        if ($request->filled('date_debut')) {
            $query->whereHas('evaluation', function($q) use ($request) {
                $q->where('date_evaluation', '>=', $request->date_debut);
            });
        }

        if ($request->filled('date_fin')) {
            $query->whereHas('evaluation', function($q) use ($request) {
                $q->where('date_evaluation', '<=', $request->date_fin);
            });
        }

        $notes = $query->orderBy('created_at', 'desc')->paginate(20);

        // Statistiques
        $stats = [
            'total_notes' => Note::where('eleve_id', $eleve->id)->count(),
            'moyenne_generale' => round(Note::where('eleve_id', $eleve->id)->avg('note') ?? 0, 2),
            'note_max' => Note::where('eleve_id', $eleve->id)->max('note') ?? 0,
            'note_min' => Note::where('eleve_id', $eleve->id)->min('note') ?? 0,
        ];

        // Matières pour les filtres
        $matieres = Matiere::all();

        // Périodes disponibles
        $periodes = Note::where('eleve_id', $eleve->id)
            ->whereHas('evaluation')
            ->get()
            ->pluck('evaluation.periode')
            ->unique()
            ->filter();

        // Debug: Vérifier si les appréciations existent
        if ($notes->isNotEmpty()) {
            $firstNote = $notes->first();
            Log::info('Structure note:', [
                'note_has_appreciation' => isset($firstNote->appreciation),
                'note_appreciation' => $firstNote->appreciation ?? 'null',
                'evaluation_has_appreciation' => isset($firstNote->evaluation->appreciation),
                'evaluation_appreciation' => $firstNote->evaluation->appreciation ?? 'null',
            ]);
        }

        return view('parent.notes-enfant', compact(
            'eleve', 
            'notes', 
            'matieres', 
            'periodes',
            'stats'
        ));
    }
}