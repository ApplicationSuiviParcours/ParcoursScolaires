<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmploiDuTemps;
use App\Models\Classe;
use App\Models\AnneeScolaire;
use App\Models\Enseignant;
use App\Models\Matiere;

class EmploiDuTempsController extends Controller
{
    /**
     * Affiche la liste des emploi du temps
     */
    public function index(Request $request)
    {
        $classeId = $request->get('classe_id');
        $anneeScolaireId = $request->get('annee_scolaire_id');
        
        if (!$anneeScolaireId) {
            $activeAnnee = AnneeScolaire::where('active', true)->first();
            if ($activeAnnee) {
                $anneeScolaireId = $activeAnnee->id;
            }
        }
        
        $enseignantId = $request->get('enseignant_id');
        $jour = $request->get('jour');
        
        $anneeScolaires = AnneeScolaire::orderBy('nom', 'desc')->get();
        $classes = Classe::orderBy('nom')->get();
        $enseignants = Enseignant::orderBy('nom')->get(); // AJOUT IMPORTANT
        $matieres = Matiere::orderBy('nom')->get();
        
        $emplois = EmploiDuTemps::with(['classe', 'matiere', 'enseignant'])
            ->when($classeId, function ($query) use ($classeId) {
                return $query->where('classe_id', $classeId);
            })
            ->when($enseignantId, function ($query) use ($enseignantId) {
                return $query->where('enseignant_id', $enseignantId);
            })
            ->when($anneeScolaireId, function ($query) use ($anneeScolaireId) {
                return $query->where('annee_scolaire_id', $anneeScolaireId);
            })
            ->when($jour, function ($query) use ($jour) {
                return $query->where('jour', $jour);
            })
            ->orderBy('jour')
            ->orderBy('heure_debut')
            ->get();

        return view('admin.emploi_du_temps.index', compact(
            'emplois', 
            'anneeScolaires', 
            'classes', 
            'enseignants', // AJOUT
            'matieres',
            'classeId', 
            'anneeScolaireId',
            'enseignantId',
            'jour'
        ));
    }

    /**
     * Affiche l'emploi du temps par classe
     */
    public function byClasse(Request $request)
    {
        $classeId = $request->get('classe_id');
        $anneeScolaireId = $request->get('annee_scolaire_id');
        
        if (!$anneeScolaireId) {
            $activeAnnee = AnneeScolaire::where('active', true)->first();
            if ($activeAnnee) {
                $anneeScolaireId = $activeAnnee->id;
            }
        }
        
        $anneeScolaires = AnneeScolaire::orderBy('nom', 'desc')->get();
        $classes = Classe::orderBy('nom')->get();
        $enseignants = Enseignant::orderBy('nom')->get(); // AJOUT
        
        $emplois = [];
        
        if ($classeId && $anneeScolaireId) {
            $emplois = EmploiDuTemps::where('classe_id', $classeId)
                ->where('annee_scolaire_id', $anneeScolaireId)
                ->with(['matiere', 'enseignant'])
                ->orderBy('jour')
                ->orderBy('heure_debut')
                ->get()
                ->groupBy('jour');
        }

        return view('admin.emploi_du_temps.by-classe', compact(
            'classes', 
            'anneeScolaires', 
            'enseignants', // AJOUT
            'emplois', 
            'classeId', 
            'anneeScolaireId'
        ));
    }

    /**
     * Affiche l'emploi du temps par enseignant
     */
    public function byEnseignant(Request $request)
    {
        $enseignantId = $request->get('enseignant_id');
        $anneeScolaireId = $request->get('annee_scolaire_id');
        
        if (!$anneeScolaireId) {
            $activeAnnee = AnneeScolaire::where('active', true)->first();
            if ($activeAnnee) {
                $anneeScolaireId = $activeAnnee->id;
            }
        }
        
        $anneeScolaires = AnneeScolaire::orderBy('nom', 'desc')->get();
        $enseignants = Enseignant::orderBy('nom')->get();
        $classes = Classe::orderBy('nom')->get(); // AJOUT
        
        $emplois = [];
        
        if ($enseignantId && $anneeScolaireId) {
            $emplois = EmploiDuTemps::where('enseignant_id', $enseignantId)
                ->where('annee_scolaire_id', $anneeScolaireId)
                ->with(['matiere', 'classe'])
                ->orderBy('jour')
                ->orderBy('heure_debut')
                ->get()
                ->groupBy('jour');
        }

        return view('admin.emploi_du_temps.by-enseignant', compact(
            'enseignants', 
            'anneeScolaires', 
            'classes', // AJOUT
            'emplois', 
            'enseignantId', 
            'anneeScolaireId'
        ));
    }

    /**
     * Affiche le formulaire de création
     */
    public function create()
    {
        $classes = Classe::orderBy('nom')->get();
        $matieres = Matiere::orderBy('nom')->get();
        $enseignants = Enseignant::orderBy('nom')->get();
        $anneeScolaires = AnneeScolaire::orderBy('nom', 'desc')->get();
        
        return view('admin.emploi_du_temps.create', compact('classes', 'matieres', 'enseignants', 'anneeScolaires'));
    }

    /**
     * Enregistre un nouvel emploi du temps
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'classe_id' => 'required|exists:classes,id',
            'matiere_id' => 'required|exists:matieres,id',
            'enseignant_id' => 'required|exists:enseignants,id',
            'annee_scolaire_id' => 'required|exists:annee_scolaires,id',
            'jour' => 'required|integer|min:1|max:7',
            'heure_debut' => 'required',
            'heure_fin' => 'required|after:heure_debut',
            'salle' => 'nullable|string|max:50',
        ]);

        $conflict = $this->getConflict($validated);
        if ($conflict) {
            return back()->withInput()->withErrors(['conflict' => $conflict]);
        }

        EmploiDuTemps::create($validated);

        return redirect()->route('admin.emploi_du_temps.index')
            ->with('success', 'Cours ajouté à l\'emploi du temps avec succès.');
    }

    /**
     * Affiche les détails d'un cours
     */
    public function show(EmploiDuTemps $emploiDuTemps)
    {
        $emploiDuTemps->load(['classe', 'matiere', 'enseignant', 'anneeScolaire']);
        
        return view('admin.emploi_du_temps.show', compact('emploiDuTemps'));
    }

    /**
     * Affiche le formulaire d'édition
     */
    public function edit(EmploiDuTemps $emploiDuTemps)
    {
        $classes = Classe::orderBy('nom')->get();
        $matieres = Matiere::orderBy('nom')->get();
        $enseignants = Enseignant::orderBy('nom')->get();
        $anneeScolaires = AnneeScolaire::orderBy('nom', 'desc')->get();
        
        return view('admin.emploi_du_temps.edit', compact('emploiDuTemps', 'classes', 'matieres', 'enseignants', 'anneeScolaires'));
    }

    /**
     * Met à jour un cours
     */
    public function update(Request $request, EmploiDuTemps $emploiDuTemps)
    {
        $validated = $request->validate([
            'classe_id' => 'required|exists:classes,id',
            'matiere_id' => 'required|exists:matieres,id',
            'enseignant_id' => 'required|exists:enseignants,id',
            'annee_scolaire_id' => 'required|exists:annee_scolaires,id',
            'jour' => 'required|integer|min:1|max:7',
            'heure_debut' => 'required',
            'heure_fin' => 'required|after:heure_debut',
            'salle' => 'nullable|string|max:50',
        ]);

        $conflict = $this->getConflict($validated, $emploiDuTemps->id);
        if ($conflict) {
            return back()->withInput()->withErrors(['conflict' => $conflict]);
        }

        $emploiDuTemps->update($validated);

        return redirect()->route('admin.emploi_du_temps.index')
            ->with('success', 'Cours mis à jour avec succès.');
    }

    /**
     * Supprime un cours
     */
    public function destroy(EmploiDuTemps $emploiDuTemps)
    {
        $emploiDuTemps->delete();

        return redirect()->route('admin.emploi_du_temps.index')
            ->with('success', 'Cours supprimé de l\'emploi du temps avec succès.');
    }

    /**
     * Exporte l'emploi du temps en PDF
     */
    public function exportPdf(Request $request)
    {
        $data = $this->getEmploiData($request);
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.emploi_du_temps.print', $data);
        
        $filename = 'emploi_du_temps';
        if ($data['classe']) $filename .= '_' . $data['classe']->nom;
        if ($data['enseignant']) $filename .= '_' . $data['enseignant']->nom;
        $filename .= '_' . date('Y-m-d') . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Affiche une version imprimable de l'emploi du temps
     */
    public function imprimer(Request $request)
    {
        $data = $this->getEmploiData($request);
        return view('admin.emploi_du_temps.print', $data);
    }

    /**
     * Récupère les données communes pour l'export et l'impression
     */
    protected function getEmploiData(Request $request)
    {
        $classeId = $request->get('classe_id');
        $anneeScolaireId = $request->get('annee_scolaire_id');
        $enseignantId = $request->get('enseignant_id');
        
        if (!$anneeScolaireId) {
            $activeAnnee = AnneeScolaire::where('active', true)->first();
            $anneeScolaireId = $activeAnnee?->id;
        }
        
        $classe = $classeId ? Classe::find($classeId) : null;
        $enseignant = $enseignantId ? Enseignant::find($enseignantId) : null;
        $anneeScolaire = $anneeScolaireId ? AnneeScolaire::find($anneeScolaireId) : null;
        
        $emplois = EmploiDuTemps::with(['classe', 'matiere', 'enseignant'])
            ->when($classeId, function ($query) use ($classeId) {
                return $query->where('classe_id', $classeId);
            })
            ->when($enseignantId, function ($query) use ($enseignantId) {
                return $query->where('enseignant_id', $enseignantId);
            })
            ->when($anneeScolaireId, function ($query) use ($anneeScolaireId) {
                return $query->where('annee_scolaire_id', $anneeScolaireId);
            })
            ->orderBy('jour')
            ->orderBy('heure_debut')
            ->get();
            
        $jours = [
            1 => 'Lundi', 2 => 'Mardi', 3 => 'Mercredi',
            4 => 'Jeudi', 5 => 'Vendredi', 6 => 'Samedi'
        ];
        
        $emploiParJour = [];
        foreach ($jours as $num => $nom) {
            $emploiParJour[$nom] = $emplois->filter(function($e) use ($num) {
                return (string)$e->jour === (string)$num;
            })->values();
        }
        
        return compact('emploiParJour', 'jours', 'classe', 'enseignant', 'anneeScolaire');
    }

    /**
     * Vérifie s'il y a un conflit pour un créneau donné
     */
    private function getConflict($data, $excludeId = null)
    {
        $query = EmploiDuTemps::where('jour', $data['jour'])
            ->where('annee_scolaire_id', $data['annee_scolaire_id'])
            ->where(function ($q) use ($data) {
                $q->where(function ($inner) use ($data) {
                    $inner->where('heure_debut', '<', $data['heure_fin'])
                          ->where('heure_fin', '>', $data['heure_debut']);
                });
            })
            ->when($excludeId, function ($q) use ($excludeId) {
                return $q->where('id', '!=', $excludeId);
            });

        // 1. Conflit Enseignant
        $enseignantConflict = (clone $query)->where('enseignant_id', $data['enseignant_id'])->first();
        if ($enseignantConflict) {
            $enseignant = Enseignant::find($data['enseignant_id']);
            return "L'enseignant {$enseignant->nom} est déjà occupé sur ce créneau (Classe: {$enseignantConflict->classe->nom_complet}).";
        }

        // 2. Conflit Classe
        $classeConflict = (clone $query)->where('classe_id', $data['classe_id'])->first();
        if ($classeConflict) {
            $classe = Classe::find($data['classe_id']);
            return "La classe {$classe->nom_complet} a déjà un cours prévu ({$classeConflict->matiere->nom}) sur ce créneau.";
        }

        // 3. Conflit Salle
        if (!empty($data['salle'])) {
            $salleConflict = (clone $query)->where('salle', $data['salle'])->first();
            if ($salleConflict) {
                return "La salle {$data['salle']} est déjà occupée par la classe {$salleConflict->classe->nom_complet} sur ce créneau.";
            }
        }

        return null;
    }
}