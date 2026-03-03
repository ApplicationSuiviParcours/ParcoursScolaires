<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ParentEleve;
use App\Models\Eleve;
use App\Models\EleveParent; // IMPORTANT: Ajouter ce modèle
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;

class ParentAdminController extends Controller
{
    /**
     * Affiche la liste des parents
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $statut = $request->get('statut');

        $parents = ParentEleve::with(['user', 'eleves' => function($query) {
                $query->withPivot('lien_parental');
            }])
            ->when($search, function ($query, $search) {
                return $query->where(function($q) use ($search) {
                    $q->where('nom', 'like', "%{$search}%")
                      ->orWhere('prenom', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when($statut !== null, function ($query) use ($statut) {
                return $statut ? $query->where('statut', true) : $query->where('statut', false);
            })
            ->orderBy('nom')
            ->orderBy('prenom')
            ->paginate(15);

        // Statistiques pour l'en-tête
        $stats = [
            'total' => ParentEleve::count(),
            'actifs' => ParentEleve::where('statut', true)->count(),
            'inactifs' => ParentEleve::where('statut', false)->count(),
            'avec_compte' => ParentEleve::whereNotNull('user_id')->count(),
            'avec_enfants' => EleveParent::distinct('parent_eleve_id')->count('parent_eleve_id'),
        ];

        return view('admin.parents.index', compact('parents', 'search', 'statut', 'stats'));
    }

    /**
     * Show the form for creating a new parent.
     */
    public function create()
    {
        $users = User::whereDoesntHave('roles')
                     ->orderBy('name')
                     ->get();
        
        $eleves = Eleve::orderBy('nom')
                       ->orderBy('prenom')
                       ->get();
        
        return view('admin.parents.create', compact('users', 'eleves'));
    }

    /**
     * Store a newly created parent in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'genre' => 'required|in:m,f',
            'profession' => 'nullable|string|max:255',
            'telephone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255|unique:parent_eleves,email',
            'adresse' => 'required|string|max:500',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'date_naissance' => 'nullable|date|before:today',
            'lieu_naissance' => 'nullable|string|max:255',
            'statut' => 'sometimes|boolean',
            'notes' => 'nullable|string|max:1000',
            'eleve_ids' => 'nullable|array',
            'eleve_ids.*' => 'exists:eleves,id',
            'liens_parentaux' => 'nullable|array',
            'liens_parentaux.*' => 'string|in:pere,mere,tuteur,autre',
        ]);

        $data = $request->except(['eleve_ids', 'liens_parentaux', 'photo']);
        
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('parents/photos', 'public');
            $data['photo'] = $path;
        }

        if (!isset($data['statut'])) {
            $data['statut'] = true;
        }

        $parent = ParentEleve::create($data);

        // Création des relations avec les élèves
        if ($request->has('eleve_ids')) {
            foreach ($request->eleve_ids as $index => $eleveId) {
                $lien = $request->liens_parentaux[$index] ?? 'parent';
                
                EleveParent::create([
                    'parent_eleve_id' => $parent->id,
                    'eleve_id' => $eleveId,
                    'lien_parental' => $lien,
                ]);
            }
        }

        return redirect()
            ->route('admin.parents.show', $parent)
            ->with('success', 'Parent créé avec succès.');
    }

    /**
     * Display the specified parent.
     */
    public function show(ParentEleve $parent)
    {
        // CORRECTION: Charger les relations via EleveParent
        // On charge les élèves avec leurs inscriptions pour pouvoir utiliser classe_actuelle
        $relations = EleveParent::with(['eleve' => function($query) {
                $query->with(['inscriptions' => function($q) {
                    $q->with('classe')->latest();
                }]);
            }])
            ->where('parent_eleve_id', $parent->id)
            ->get();

        $parent->load('user');

        return view('admin.parents.show', compact('parent', 'relations'));
    }

    /**
     * Show the form for editing the specified parent.
     */
    public function edit(ParentEleve $parent)
    {
        $users = User::whereDoesntHave('roles')
                     ->orWhere('id', $parent->user_id)
                     ->orderBy('name')
                     ->get();
        
        $eleves = Eleve::orderBy('nom')
                       ->orderBy('prenom')
                       ->get();
        
        // Récupérer les relations via EleveParent
        $relations = EleveParent::where('parent_eleve_id', $parent->id)->get();
        
        $elevesIds = $relations->pluck('eleve_id')->toArray();
        
        $liensExistants = $relations->pluck('lien_parental', 'eleve_id')->toArray();
        
        return view('admin.parents.edit', compact('parent', 'users', 'eleves', 'elevesIds', 'liensExistants'));
    }

    /**
     * Update the specified parent in storage.
     */
    public function update(Request $request, ParentEleve $parent)
    {
        $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'genre' => 'required|in:m,f',
            'profession' => 'nullable|string|max:255',
            'telephone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255|unique:parent_eleves,email,' . $parent->id,
            'adresse' => 'required|string|max:500',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'date_naissance' => 'nullable|date|before:today',
            'lieu_naissance' => 'nullable|string|max:255',
            'statut' => 'sometimes|boolean',
            'notes' => 'nullable|string|max:1000',
            'eleve_ids' => 'nullable|array',
            'eleve_ids.*' => 'exists:eleves,id',
            'liens_parentaux' => 'nullable|array',
            'liens_parentaux.*' => 'string|in:pere,mere,tuteur,autre',
        ]);

        $data = $request->except(['eleve_ids', 'liens_parentaux', 'photo']);

        if ($request->hasFile('photo')) {
            if ($parent->photo) {
                Storage::disk('public')->delete($parent->photo);
            }
            
            $path = $request->file('photo')->store('parents/photos', 'public');
            $data['photo'] = $path;
        }

        $parent->update($data);

        // Mise à jour des relations avec les élèves
        if ($request->has('eleve_ids')) {
            // Supprimer les anciennes relations
            EleveParent::where('parent_eleve_id', $parent->id)->delete();
            
            // Créer les nouvelles relations
            foreach ($request->eleve_ids as $index => $eleveId) {
                $lien = $request->liens_parentaux[$index] ?? 'parent';
                
                EleveParent::create([
                    'parent_eleve_id' => $parent->id,
                    'eleve_id' => $eleveId,
                    'lien_parental' => $lien,
                ]);
            }
        } else {
            // Si aucun élève sélectionné, supprimer toutes les relations
            EleveParent::where('parent_eleve_id', $parent->id)->delete();
        }

        return redirect()
            ->route('admin.parents.show', $parent)
            ->with('success', 'Parent mis à jour avec succès.');
    }

    /**
     * Remove the specified parent from storage.
     */
    public function destroy(ParentEleve $parent)
    {
        try {
            if ($parent->photo) {
                Storage::disk('public')->delete($parent->photo);
            }
            
            // Supprimer d'abord les relations dans la table pivot
            EleveParent::where('parent_eleve_id', $parent->id)->delete();
            
            $parent->delete();
            
            return redirect()
                ->route('admin.parents.index')
                ->with('success', 'Parent supprimé avec succès.');
                
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.parents.index')
                ->with('error', 'Impossible de supprimer ce parent : ' . $e->getMessage());
        }
    }

    /**
     * Activer un parent
     */
    public function activer(ParentEleve $parent)
    {
        $parent->update(['statut' => true]);
        
        return redirect()
            ->back()
            ->with('success', 'Parent activé avec succès.');
    }

    /**
     * Désactiver un parent
     */
    public function desactiver(ParentEleve $parent)
    {
        $parent->update(['statut' => false]);
        
        return redirect()
            ->back()
            ->with('success', 'Parent désactivé avec succès.');
    }

    /**
     * Export de la liste des parents
     */
    public function export(Request $request)
    {
        $parents = ParentEleve::with('user')
            ->when($request->get('statut') !== null, function ($query) use ($request) {
                return $request->statut ? $query->where('statut', true) : $query->where('statut', false);
            })
            ->orderBy('nom')
            ->orderBy('prenom')
            ->get()
            ->map(function($parent) {
                $enfantsCount = EleveParent::where('parent_eleve_id', $parent->id)->count();
                $parent->enfants_count = $enfantsCount;
                return $parent;
            });

        return redirect()
            ->back()
            ->with('info', 'Fonctionnalité d\'export à implémenter.');
    }
}