<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bulletin;
use App\Models\Classe;
use App\Models\AnneeScolaire;
use Illuminate\Http\Request;

class TableauHonneurController extends Controller
{
    public function index(Request $request)
    {
        $anneeScolaires = AnneeScolaire::orderBy('nom', 'desc')->get();
        $classes = Classe::orderBy('nom')->get();

        $classeId = $request->get('classe_id');
        $anneeScolaireId = $request->get('annee_scolaire_id');
        $periode = $request->get('periode', 'Trimestre 1');
        $top = $request->get('top'); // null means all

        $tableau = collect();

        if ($classeId && $anneeScolaireId) {
            $query = Bulletin::with(['eleve', 'classe', 'anneeScolaire'])
                ->where('classe_id', $classeId)
                ->where('annee_scolaire_id', $anneeScolaireId)
                ->where('periode', $periode);

            $tableau = $query
                ->orderBy('rang')
                ->orderBy('moyenne_generale', 'desc')
                ->get();

            if ($top !== null && $top !== '' && is_numeric($top)) {
                $tableau = $tableau->take((int)$top);
            }
        }

        return view('admin.tableau_honneur.index', compact(
            'anneeScolaires',
            'classes',
            'classeId',
            'anneeScolaireId',
            'periode',
            'top',
            'tableau'
        ));

    }

    public function print(Request $request)
    {
        $classeId = $request->get('classe_id');
        $anneeScolaireId = $request->get('annee_scolaire_id');
        $periode = $request->get('periode', 'Trimestre 1');
        $top = $request->get('top');

        $classe = null;
        $anneeScolaire = null;
        $tableau = collect();

        if ($classeId && $anneeScolaireId) {
            $classe = Classe::find($classeId);
            $anneeScolaire = AnneeScolaire::find($anneeScolaireId);

            $query = Bulletin::with(['eleve', 'classe', 'anneeScolaire'])
                ->where('classe_id', $classeId)
                ->where('annee_scolaire_id', $anneeScolaireId)
                ->where('periode', $periode);

            $tableau = $query
                ->orderBy('rang')
                ->orderBy('moyenne_generale', 'desc')
                ->get();

            if ($top !== null && $top !== '' && is_numeric($top)) {
                $tableau = $tableau->take((int)$top);
            }
        }

        return view('admin.tableau_honneur.print', compact(
            'tableau',
            'classe',
            'anneeScolaire',
            'periode',
            'top'
        ));
    }
}