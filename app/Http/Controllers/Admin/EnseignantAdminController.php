<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Enseignant;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class EnseignantAdminController extends Controller
{
    /**
     * Affiche la liste des enseignants
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $specialite = $request->get('specialite');
        $statut = $request->get('statut');
        
        $enseignants = Enseignant::with('user')
            ->when($search, function ($query) use ($search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('nom', 'like', "%{$search}%")
                      ->orWhere('prenom', 'like', "%{$search}%")
                      ->orWhere('matricule', 'like', "%{$search}%");
                });
            })
            ->when($specialite, function ($query) use ($specialite) {
                return $query->where('specialite', $specialite);
            })
            ->when($statut !== null, function ($query) use ($statut) {
                return $query->where('statut', $statut);
            })
            ->orderBy('nom')
            ->orderBy('prenom')
            ->paginate(15);

        $specialites = Enseignant::whereNotNull('specialite')
                                 ->distinct()
                                 ->orderBy('specialite')
                                 ->pluck('specialite')
                                 ->toArray();

        $enseignantsAvecSpecialite = Enseignant::whereNotNull('specialite')->count();

        return view('admin.enseignants.index', compact(
            'enseignants', 
            'search', 
            'specialite',
            'statut',
            'specialites',
            'enseignantsAvecSpecialite'
        ));
    }

    public function create()
    {
        $users = User::whereDoesntHave('enseignant')->get();
        return view('admin.enseignants.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'genre' => 'required|in:m,f',
            'date_naissance' => 'required|date',
            'lieu_naissance' => 'required|string|max:255',
            'telephone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'adresse' => 'required|string',
            'specialite' => 'nullable|string|max:255',
            'photo' => 'nullable|image|max:2048',
            'statut' => 'sometimes|boolean',
        ]);

        $validated['matricule'] = Enseignant::genererMatricule($validated['nom']);
        $validated['statut'] = $validated['statut'] ?? true;

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('enseignants', 'public');
            $validated['photo'] = $path;
        }

        Enseignant::create($validated);

        return redirect()->route('admin.enseignants.index')
            ->with('success', 'Enseignant créé avec succès.');
    }

    public function show(Enseignant $enseignant)
    {
        $enseignant->load([
            'user', 
            'enseignantMatiereClasses.matiere', 
            'enseignantMatiereClasses.classe',
            'evaluations' => function ($query) {
                $query->latest()->take(5);
            }
        ]);
        
        return view('admin.enseignants.show', compact('enseignant'));
    }

    public function edit(Enseignant $enseignant)
    {
        $users = User::whereDoesntHave('enseignant')
                     ->orWhere('id', $enseignant->user_id)
                     ->get();
        
        return view('admin.enseignants.edit', compact('enseignant', 'users'));
    }

    public function update(Request $request, Enseignant $enseignant)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'genre' => 'required|in:m,f',
            'date_naissance' => 'required|date',
            'lieu_naissance' => 'required|string|max:255',
            'telephone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'adresse' => 'required|string',
            'specialite' => 'nullable|string|max:255',
            'photo' => 'nullable|image|max:2048',
            'statut' => 'sometimes|boolean',
        ]);

        unset($validated['matricule']);

        if ($request->hasFile('photo')) {
            if ($enseignant->photo) {
                Storage::disk('public')->delete($enseignant->photo);
            }
            $path = $request->file('photo')->store('enseignants', 'public');
            $validated['photo'] = $path;
        }

        $enseignant->update($validated);

        return redirect()->route('admin.enseignants.show', $enseignant)
            ->with('success', 'Enseignant mis à jour avec succès.');
    }

    public function destroy(Enseignant $enseignant)
    {
        if ($enseignant->evaluations()->exists()) {
            return redirect()->route('admin.enseignants.index')
                ->with('error', 'Impossible de supprimer cet enseignant car il a des évaluations associées.');
        }

        if ($enseignant->photo) {
            Storage::disk('public')->delete($enseignant->photo);
        }

        $enseignant->delete();

        return redirect()->route('admin.enseignants.index')
            ->with('success', 'Enseignant supprimé avec succès.');
    }

    public function toggleStatut(Enseignant $enseignant)
    {
        $enseignant->update(['statut' => !$enseignant->statut]);
        
        $message = $enseignant->statut 
            ? 'Enseignant activé avec succès.' 
            : 'Enseignant désactivé avec succès.';
        
        return redirect()->route('admin.enseignants.show', $enseignant)
            ->with('success', $message);
    }
}