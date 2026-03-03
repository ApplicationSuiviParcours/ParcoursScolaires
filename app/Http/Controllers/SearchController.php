<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Eleve;
use App\Models\Classe;
use App\Models\Enseignant;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->get('q');
        
        $results = [
            'eleves' => [],
            'classes' => [],
            'enseignants' => [],
        ];
        
        if ($query && strlen($query) >= 2) {
            $results['eleves'] = Eleve::where('nom', 'like', "%{$query}%")
                ->orWhere('prenom', 'like', "%{$query}%")
                ->orWhere('matricule', 'like', "%{$query}%")
                ->limit(5)
                ->get();
                
            $results['classes'] = Classe::where('nom', 'like', "%{$query}%")
                ->limit(5)
                ->get();
                
            $results['enseignants'] = Enseignant::where('nom', 'like', "%{$query}%")
                ->orWhere('prenom', 'like', "%{$query}%")
                ->limit(5)
                ->get();
        }
        
        return view('search.results', compact('results', 'query'));
    }
    
    public function live(Request $request)
    {
        $query = $request->get('q');
        
        // Version simplifiée pour AJAX
        $results = [
            'eleves' => Eleve::where('nom', 'like', "%{$query}%")
                ->orWhere('prenom', 'like', "%{$query}%")
                ->limit(3)
                ->get(['id', 'nom', 'prenom', 'matricule']),
                
            'classes' => Classe::where('nom', 'like', "%{$query}%")
                ->limit(3)
                ->get(['id', 'nom']),
        ];
        
        return response()->json($results);
    }
}