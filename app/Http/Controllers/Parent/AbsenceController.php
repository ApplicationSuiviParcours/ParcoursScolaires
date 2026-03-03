<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Models\Eleve;
use App\Models\Absence;
use App\Models\Matiere;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsenceController extends Controller
{
    public function index(Request $request, Eleve $eleve)
    {
        $user = Auth::user();
        
        if (!$user->isParent()) {
            abort(403, 'Accès non autorisé.');
        }

        $query = Absence::where('eleve_id', $eleve->id)
            ->with(['matiere']);

        // Filtres
        if ($request->filled('date_debut')) {
            $query->where('date_absence', '>=', $request->date_debut);
        }
        if ($request->filled('date_fin')) {
            $query->where('date_absence', '<=', $request->date_fin);
        }
        if ($request->filled('matiere_id')) {
            $query->where('matiere_id', $request->matiere_id);
        }
        if ($request->filled('justifiee') && $request->justifiee !== '') {
            $query->where('justifiee', $request->justifiee);
        }
        if ($request->filled('mois')) {
            $query->whereMonth('date_absence', $request->mois);
        }
        if ($request->filled('annee')) {
            $query->whereYear('date_absence', $request->annee);
        }

        $absences = $query->orderBy('date_absence', 'desc')->paginate(15);

        $stats = [
            'total' => Absence::where('eleve_id', $eleve->id)->count(),
            'justifiees' => Absence::where('eleve_id', $eleve->id)->where('justifiee', true)->count(),
            'non_justifiees' => Absence::where('eleve_id', $eleve->id)->where('justifiee', false)->count(),
            'mois_courant' => Absence::where('eleve_id', $eleve->id)
                ->whereMonth('date_absence', now()->month)
                ->whereYear('date_absence', now()->year)
                ->count(),
        ];

        $matieres = Matiere::whereHas('absences', function($q) use ($eleve) {
            $q->where('eleve_id', $eleve->id);
        })->get();

        if ($matieres->isEmpty()) {
            $matieres = Matiere::limit(10)->get();
        }

        $mois = [
            1 => 'Janvier', 2 => 'Février', 3 => 'Mars', 4 => 'Avril', 
            5 => 'Mai', 6 => 'Juin', 7 => 'Juillet', 8 => 'Août', 
            9 => 'Septembre', 10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre'
        ];

        return view('parent.absences-enfant', compact('eleve', 'absences', 'stats', 'matieres', 'mois'));
    }

    public function justifier(Request $request, Absence $absence)
    {
        $user = Auth::user();
        
        if (!$user->isParent()) {
            abort(403, 'Accès non autorisé.');
        }

        $request->validate([
            'motif' => 'required|string|max:500',
        ]);

        try {
            $absence->motif = $request->motif;
            $absence->justifiee = true;
            $absence->save();

            return redirect()->back()->with('success', 'Absence justifiée avec succès.');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la justification.');
        }
    }
}