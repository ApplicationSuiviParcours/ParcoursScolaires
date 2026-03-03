@extends('layouts.app')

@section('header')
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
        {{ __('Mes Évaluations') }}
    </h2>
@endsection

@section('content')
<div class="py-12">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <!-- Header avec bouton de création -->
        <div class="p-6 mb-8 shadow-lg bg-gradient-to-r from-indigo-700 to-indigo-500 rounded-xl">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-2xl font-bold text-white">Mes Évaluations</h3>
                    <p class="mt-1 text-indigo-100">Gérer et créer mes évaluations</p>
                </div>
                <div class="flex items-center space-x-4">
                    <button onclick="openCreateModal()" class="flex items-center px-4 py-2 font-semibold text-indigo-600 transition-colors bg-white rounded-lg hover:bg-indigo-50">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Nouvelle évaluation
                    </button>
                    <div class="hidden md:block">
                        <div class="p-4 rounded-full bg-white/20">
                            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-4">
            <div class="p-6 bg-white shadow-md rounded-xl">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total évaluations</p>
                        <p class="mt-1 text-3xl font-bold text-gray-900">{{ $evaluations->count() }}</p>
                    </div>
                    <div class="p-3 bg-indigo-100 rounded-full">
                        <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="p-6 bg-white shadow-md rounded-xl">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Ce mois</p>
                        <p class="mt-1 text-3xl font-bold text-gray-900">
                            {{ $evaluations->filter(function($e) { return \Carbon\Carbon::parse($e->date_evaluation)->isCurrentMonth(); })->count() }}
                        </p>
                    </div>
                    <div class="p-3 bg-blue-100 rounded-full">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="p-6 bg-white shadow-md rounded-xl">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">À venir</p>
                        <p class="mt-1 text-3xl font-bold text-gray-900">
                            {{ $evaluations->filter(function($e) { return \Carbon\Carbon::parse($e->date_evaluation)->isFuture(); })->count() }}
                        </p>
                    </div>
                    <div class="p-3 bg-green-100 rounded-full">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="p-6 bg-white shadow-md rounded-xl">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Moyenne générale</p>
                        <p class="mt-1 text-3xl font-bold text-gray-900">
                            @php
                                $moyenne = 0;
                                $count = 0;
                                foreach($evaluations as $evaluation) {
                                    if($evaluation->notes && $evaluation->notes->count() > 0) {
                                        $moyenne += $evaluation->notes->avg('valeur');
                                        $count++;
                                    }
                                }
                                echo $count > 0 ? round($moyenne/$count, 1) : '-';
                            @endphp
                        </p>
                    </div>
                    <div class="p-3 bg-purple-100 rounded-full">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de création d'évaluation -->
        <div id="createModal" class="fixed inset-0 z-50 hidden w-full h-full overflow-y-auto bg-gray-600 bg-opacity-50">
            <div class="relative w-full max-w-2xl p-5 mx-auto bg-white border rounded-lg shadow-lg top-20">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-semibold text-gray-900">Créer une nouvelle évaluation</h3>
                    <button onclick="closeCreateModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <form action="{{ route('enseignant.evaluations.store') }}" method="POST" class="space-y-4">
                    @csrf
                    
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <!-- Nom de l'évaluation -->
                        <div class="col-span-2">
                            <label class="block mb-2 text-sm font-medium text-gray-700">Nom de l'évaluation *</label>
                            <input type="text" name="nom" required 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500"
                                   placeholder="Ex: Devoir de contrôle n°1">
                        </div>

                        <!-- Classe -->
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-700">Classe *</label>
                            <select name="classe_id" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Sélectionner une classe</option>
                                @foreach($classes as $classe)
                                    <option value="{{ $classe->id }}">{{ $classe->nom }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Matière -->
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-700">Matière *</label>
                            <select name="matiere_id" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Sélectionner une matière</option>
                                @foreach($matieres as $matiere)
                                    <option value="{{ $matiere->id }}">{{ $matiere->nom }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Type d'évaluation -->
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-700">Type *</label>
                            <select name="type" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Sélectionner un type</option>
                                <option value="devoir">Devoir</option>
                                <option value="examen">Examen</option>
                                <option value="interrogation">Interrogation</option>
                                <option value="projet">Projet</option>
                            </select>
                        </div>

                        <!-- Période -->
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-700">Période *</label>
                            <select name="periode" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Sélectionner une période</option>
                                <option value="1">Période 1</option>
                                <option value="2">Période 2</option>
                                <option value="3">Période 3</option>
                                <option value="4">Période 4</option>
                                <option value="5">Période 5</option>
                            </select>
                        </div>

                        <!-- Date -->
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-700">Date de l'évaluation *</label>
                            <input type="date" name="date_evaluation" required 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500"
                                   value="{{ date('Y-m-d') }}">
                        </div>

                        <!-- Coefficient -->
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-700">Coefficient *</label>
                            <input type="number" name="coefficient" step="0.5" min="0.5" max="10" required 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500"
                                   value="1">
                        </div>

                        <!-- Barème -->
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-700">Barème *</label>
                            <input type="number" name="bareme" step="0.5" min="0" max="40" required 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500"
                                   value="20">
                        </div>

                        <!-- Année scolaire (caché si une seule année active) -->
                        @if(isset($anneeScolaireActive))
                            <input type="hidden" name="annee_scolaire_id" value="{{ $anneeScolaireActive->id }}">
                        @else
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-700">Année scolaire *</label>
                                <select name="annee_scolaire_id" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="">Sélectionner une année</option>
                                    @foreach($anneesScolaires as $annee)
                                        <option value="{{ $annee->id }}">{{ $annee->libelle }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        <!-- Description -->
                        <div class="col-span-2">
                            <label class="block mb-2 text-sm font-medium text-gray-700">Description (optionnelle)</label>
                            <textarea name="description" rows="3" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500"
                                      placeholder="Ajouter une description..."></textarea>
                        </div>
                    </div>

                    <div class="flex justify-end pt-4 space-x-3 border-t">
                        <button type="button" onclick="closeCreateModal()" 
                                class="px-4 py-2 text-gray-700 transition-colors bg-gray-100 rounded-lg hover:bg-gray-200">
                            Annuler
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 text-white transition-colors bg-indigo-600 rounded-lg hover:bg-indigo-700">
                            Créer l'évaluation
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Evaluations Table avec actions améliorées -->
        <div class="overflow-hidden bg-white shadow-md rounded-xl">
            <div class="flex items-center justify-between p-6 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900">Historique des évaluations</h3>
                <div class="flex space-x-2">
                    <input type="text" id="searchEvaluation" placeholder="Rechercher..." 
                           class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                    <select id="filterClasse" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Toutes les classes</option>
                        @foreach($classes as $classe)
                            <option value="{{ $classe->id }}">{{ $classe->nom }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full" id="evaluationsTable">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Date</th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Classe</th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Matière</th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Type</th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Coefficient</th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Statut</th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($evaluations as $evaluation)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($evaluation->date_evaluation)->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">
                                <span class="font-medium">{{ $evaluation->classe->nom ?? '-' }}</span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">
                                {{ $evaluation->matiere->nom ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs rounded-full 
                                    @if($evaluation->type == 'devoir') bg-blue-100 text-blue-800
                                    @elseif($evaluation->type == 'examen') bg-purple-100 text-purple-800
                                    @elseif($evaluation->type == 'interrogation') bg-green-100 text-green-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ ucfirst($evaluation->type ?? 'N/A') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">
                                {{ $evaluation->coefficient }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $dateEval = \Carbon\Carbon::parse($evaluation->date_evaluation);
                                @endphp
                                @if($dateEval->isToday())
                                    <span class="px-2 py-1 text-xs text-yellow-800 bg-yellow-100 rounded-full">Aujourd'hui</span>
                                @elseif($dateEval->isFuture())
                                    <span class="px-2 py-1 text-xs text-green-800 bg-green-100 rounded-full">À venir</span>
                                @else
                                    <span class="px-2 py-1 text-xs text-gray-800 bg-gray-100 rounded-full">Passée</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm font-medium whitespace-nowrap">
                                <div class="flex space-x-3">
                                    <a href="{{ route('enseignant.evaluations.show', $evaluation->id) }}" 
                                       class="text-indigo-600 hover:text-indigo-900" title="Voir détails">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>
                                    <a href="{{ route('enseignant.evaluations.edit', $evaluation->id) }}" 
                                       class="text-blue-600 hover:text-blue-900" title="Modifier">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    <a href="{{ route('enseignant.notes.create', ['evaluation' => $evaluation->id]) }}" 
                                       class="text-green-600 hover:text-green-900" title="Saisir notes">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    <button onclick="deleteEvaluation({{ $evaluation->id }})" 
                                            class="text-red-600 hover:text-red-900" title="Supprimer">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                <p class="text-lg">Aucune évaluation trouvée</p>
                                <p class="mt-2 text-sm">Commencez par créer votre première évaluation</p>
                                <button onclick="openCreateModal()" class="px-4 py-2 mt-4 text-white bg-indigo-600 rounded-lg hover:bg-indigo-700">
                                    Créer une évaluation
                                </button>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination si nécessaire -->
            @if(method_exists($evaluations, 'links'))
                <div class="p-4 border-t border-gray-100">
                    {{ $evaluations->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Formulaire de suppression caché -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script>
// Fonctions pour le modal
function openCreateModal() {
    document.getElementById('createModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeCreateModal() {
    document.getElementById('createModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Fonction de suppression
function deleteEvaluation(id) {
    if(confirm('Êtes-vous sûr de vouloir supprimer cette évaluation ?')) {
        let form = document.getElementById('deleteForm');
        form.action = '/enseignant/evaluations/' + id;
        form.submit();
    }
}

// Fermer le modal en cliquant en dehors
window.onclick = function(event) {
    let modal = document.getElementById('createModal');
    if (event.target == modal) {
        closeCreateModal();
    }
}

// Recherche en temps réel
document.getElementById('searchEvaluation').addEventListener('keyup', function() {
    filterTable();
});

document.getElementById('filterClasse').addEventListener('change', function() {
    filterTable();
});

function filterTable() {
    let searchText = document.getElementById('searchEvaluation').value.toLowerCase();
    let classeFilter = document.getElementById('filterClasse').value;
    let rows = document.querySelectorAll('#evaluationsTable tbody tr');
    
    rows.forEach(row => {
        if (row.querySelector('td[colspan]')) return; // Ignorer la ligne "aucune donnée"
        
        let date = row.cells[0]?.textContent.toLowerCase() || '';
        let classe = row.cells[1]?.textContent.toLowerCase() || '';
        let matiere = row.cells[2]?.textContent.toLowerCase() || '';
        let type = row.cells[3]?.textContent.toLowerCase() || '';
        let classeId = row.cells[1]?.querySelector('span')?.getAttribute('data-classe-id') || '';
        
        let matchesSearch = date.includes(searchText) || 
                           classe.includes(searchText) || 
                           matiere.includes(searchText) || 
                           type.includes(searchText);
        
        let matchesClasse = !classeFilter || classeId === classeFilter;
        
        if (matchesSearch && matchesClasse) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}
</script>

<style>
/* Animation du modal */
#createModal {
    transition: opacity 0.3s ease;
}

#createModal .relative {
    animation: slideIn 0.3s ease-out;
}

@keyframes slideIn {
    from {
        transform: translateY(-50px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}
</style>
@endsection