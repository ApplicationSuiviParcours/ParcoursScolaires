@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Gestion des Absences') }}
    </h2>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header avec bouton de création -->
        <div class="bg-gradient-to-r from-red-600 to-red-400 rounded-xl shadow-lg mb-8 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-2xl font-bold text-white">Gestion des Absences</h3>
                    <p class="text-red-100 mt-1">Suivre, créer et gérer les absences</p>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('enseignant.absences.create') }}" 
                       class="bg-white text-red-600 px-4 py-2 rounded-lg font-semibold hover:bg-red-50 transition-colors flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Nouvelle absence
                    </a>
                    <div class="hidden md:block">
                        <div class="bg-white/20 rounded-full p-4">
                            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filtres de recherche -->
        <div class="bg-white rounded-xl shadow-md mb-8 p-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Date début</label>
                    <input type="date" id="filter_date_debut" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Date fin</label>
                    <input type="date" id="filter_date_fin" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Classe</label>
                    <select id="filter_classe" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500">
                        <option value="">Toutes les classes</option>
                        @foreach($classes ?? [] as $classe)
                            <option value="{{ $classe->id }}">{{ $classe->nom }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Statut</label>
                    <select id="filter_statut" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500">
                        <option value="">Tous</option>
                        <option value="justifie">Justifiées</option>
                        <option value="non_justifie">Non justifiées</option>
                    </select>
                </div>
            </div>
            <div class="flex justify-end mt-4">
                <button onclick="appliquerFiltres()" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                    Appliquer les filtres
                </button>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total absences</p>
                        <p class="text-3xl font-bold text-gray-900 mt-1">{{ $absences->total() ?? $absences->count() }}</p>
                    </div>
                    <div class="bg-red-100 rounded-full p-3">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Heures d'absence</p>
                        <p class="text-3xl font-bold text-gray-900 mt-1">
                            @php
                                $totalHeures = $absences->sum('nombre_heures');
                                echo $totalHeures ?? 0;
                            @endphp
                        </p>
                    </div>
                    <div class="bg-orange-100 rounded-full p-3">
                        <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Non justifiées</p>
                        <p class="text-3xl font-bold text-gray-900 mt-1">
                            @php
                                $nonJustifiees = $absences->where('justifie', false)->count();
                                echo $nonJustifiees;
                            @endphp
                        </p>
                    </div>
                    <div class="bg-yellow-100 rounded-full p-3">
                        <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Taux de présence</p>
                        <p class="text-3xl font-bold text-gray-900 mt-1">
                            @php
                                $taux = $statistiques['taux_justification'] ?? 0;
                                echo $taux . '%';
                            @endphp
                        </p>
                    </div>
                    <div class="bg-green-100 rounded-full p-3">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Absences Table avec actions -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-900">Historique des absences</h3>
                <span class="text-sm text-gray-500">Total: {{ $absences->total() ?? $absences->count() }} absence(s)</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Élève</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Classe</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Matière</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Heure</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Durée</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($absences as $absence)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ \Carbon\Carbon::parse($absence->date_absence)->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $absence->eleve->nom ?? '-' }} {{ $absence->eleve->prenom ?? '' }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{ $absence->eleve->matricule ?? '' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $absence->eleve->classe->nom ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $absence->matiere->nom ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ substr($absence->heure_debut, 0, 5) ?? '-' }} - {{ substr($absence->heure_fin, 0, 5) ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $absence->nombre_heures ?? 1 }}h
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($absence->justifie)
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Justifiée
                                </span>
                                @else
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    Non justifiée
                                </span>
                                @endif
                                @if($absence->motif)
                                <button onclick="afficherMotif('{{ $absence->motif }}')" class="ml-2 text-gray-400 hover:text-gray-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </button>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <!-- Voir détails -->
                                    <a href="{{ route('enseignant.absences.show', $absence->id) }}" 
                                       class="text-blue-600 hover:text-blue-900" title="Voir détails">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>

                                    <!-- Modifier -->
                                    <a href="{{ route('enseignant.absences.edit', $absence->id) }}" 
                                       class="text-green-600 hover:text-green-900" title="Modifier">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>

                                    <!-- Justifier (si non justifiée) -->
                                    @if(!$absence->justifie)
                                    <button onclick="ouvrirModalJustification({{ $absence->id }})" 
                                            class="text-yellow-600 hover:text-yellow-900" title="Justifier">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </button>
                                    @endif

                                    <!-- Supprimer -->
                                    <button onclick="confirmerSuppression({{ $absence->id }})" 
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
                            <td colspan="8" class="px-6 py-12 text-center text-gray-500">
                                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                                <p class="text-lg">Aucune absence trouvée</p>
                                <p class="text-sm mt-2">Commencez par enregistrer une absence</p>
                                <a href="{{ route('enseignant.absences.create') }}" 
                                   class="mt-4 inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Nouvelle absence
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if(method_exists($absences, 'links'))
            <div class="p-4 border-t border-gray-100">
                {{ $absences->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal de justification -->
<div id="modalJustification" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-md shadow-lg rounded-lg bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-semibold text-gray-900">Justifier l'absence</h3>
            <button onclick="fermerModalJustification()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <form id="formJustification" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Motif de justification</label>
                <textarea name="motif" rows="4" required 
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500"
                          placeholder="Veuillez fournir une explication..."></textarea>
            </div>
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="fermerModalJustification()" 
                        class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
                    Annuler
                </button>
                <button type="submit" 
                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                    Justifier
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal de motif -->
<div id="modalMotif" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-md shadow-lg rounded-lg bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-semibold text-gray-900">Motif de l'absence</h3>
            <button onclick="fermerModalMotif()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div id="motifContent" class="text-gray-700 p-4 bg-gray-50 rounded-lg">
        </div>
        <div class="flex justify-end mt-4">
            <button onclick="fermerModalMotif()" 
                    class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
                Fermer
            </button>
        </div>
    </div>
</div>

<!-- Formulaire de suppression caché -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script>
// Variables globales
let absenceIdASupprimer = null;

// Fonctions pour les modales
function ouvrirModalJustification(absenceId) {
    const modal = document.getElementById('modalJustification');
    const form = document.getElementById('formJustification');
    form.action = '/enseignant/absences/' + absenceId + '/justify';
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function fermerModalJustification() {
    document.getElementById('modalJustification').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

function afficherMotif(motif) {
    document.getElementById('motifContent').textContent = motif;
    document.getElementById('modalMotif').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function fermerModalMotif() {
    document.getElementById('modalMotif').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Fonction de suppression
function confirmerSuppression(id) {
    if(confirm('Êtes-vous sûr de vouloir supprimer cette absence ?')) {
        let form = document.getElementById('deleteForm');
        form.action = '/enseignant/absences/' + id;
        form.submit();
    }
}

// Fonction pour les filtres
function appliquerFiltres() {
    const dateDebut = document.getElementById('filter_date_debut').value;
    const dateFin = document.getElementById('filter_date_fin').value;
    const classe = document.getElementById('filter_classe').value;
    const statut = document.getElementById('filter_statut').value;
    
    let url = new URL(window.location.href);
    
    if(dateDebut) url.searchParams.set('date_debut', dateDebut);
    else url.searchParams.delete('date_debut');
    
    if(dateFin) url.searchParams.set('date_fin', dateFin);
    else url.searchParams.delete('date_fin');
    
    if(classe) url.searchParams.set('classe_id', classe);
    else url.searchParams.delete('classe_id');
    
    if(statut) url.searchParams.set('statut', statut);
    else url.searchParams.delete('statut');
    
    window.location.href = url.toString();
}

// Fermer les modales en cliquant en dehors
window.onclick = function(event) {
    const modalJustification = document.getElementById('modalJustification');
    const modalMotif = document.getElementById('modalMotif');
    
    if (event.target == modalJustification) {
        fermerModalJustification();
    }
    if (event.target == modalMotif) {
        fermerModalMotif();
    }
}

// Remplir les filtres avec les valeurs de l'URL au chargement
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    
    if(urlParams.has('date_debut')) {
        document.getElementById('filter_date_debut').value = urlParams.get('date_debut');
    }
    if(urlParams.has('date_fin')) {
        document.getElementById('filter_date_fin').value = urlParams.get('date_fin');
    }
    if(urlParams.has('classe_id')) {
        document.getElementById('filter_classe').value = urlParams.get('classe_id');
    }
    if(urlParams.has('statut')) {
        document.getElementById('filter_statut').value = urlParams.get('statut');
    }
});
</script>

<style>
/* Animation des modales */
#modalJustification, #modalMotif {
    transition: opacity 0.3s ease;
}

#modalJustification .relative, #modalMotif .relative {
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

/* Style des boutons d'action */
.hover\:bg-gray-50:hover {
    background-color: #f9fafb;
}
</style>
@endsection