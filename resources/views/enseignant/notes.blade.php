@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-sm text-gray-800 leading-tight">
        {{ __('Gestion des Notes') }}
    </h2>
@endsection

@section('content')
<div class="py-6 sm:py-12 bg-gray-50 min-h-screen">
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-8">
        
        <!-- Header Section -->
        <div class="bg-gradient-to-r from-emerald-600 to-teal-600 rounded-3xl shadow-xl p-8 relative overflow-hidden">
            <!-- Decorative Background Element -->
            <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 bg-white opacity-10 rounded-full blur-3xl"></div>
            
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 relative z-10">
                <div>
                    <h3 class="text-3xl font-extrabold text-white mb-2">Historique des Notes</h3>
                    <p class="text-emerald-100 text-base font-medium">Consultez, modifiez et gérez l'ensemble des notes de vos évaluations.</p>
                </div>
                <div class="flex items-center gap-4">
                    <a href="{{ route('enseignant.notes.create') }}"
                        class="bg-white text-emerald-600 px-6 py-3 rounded-xl font-bold shadow-lg hover:shadow-xl hover:bg-emerald-50 transform hover:-translate-y-0.5 transition-all duration-300 flex items-center whitespace-nowrap">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Saisir de nouvelles notes
                    </a>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total Notes -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex items-center justify-between hover:shadow-md transition-shadow">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Total notes</p>
                    <p class="text-3xl font-black text-gray-900">{{ $totalNotes ?? 0 }}</p>
                </div>
                <div class="bg-blue-50 text-blue-500 rounded-2xl p-4 shadow-inner">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
            </div>

            <!-- Moyenne -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex items-center justify-between hover:shadow-md transition-shadow">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Moyenne Globale</p>
                    <p class="text-3xl font-black {{ ($moyenneGenerale ?? 0) >= 10 ? 'text-emerald-600' : 'text-red-600' }}">
                        {{ number_format((float)($moyenneGenerale ?? 0), 2) }}<span class="text-lg text-gray-400 font-bold">/20</span>
                    </p>
                </div>
                <div class="bg-emerald-50 text-emerald-500 rounded-2xl p-4 shadow-inner">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
            </div>

            <!-- Classes -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex items-center justify-between hover:shadow-md transition-shadow">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Classes engagées</p>
                    <p class="text-3xl font-black text-gray-900">{{ $classesCount ?? 0 }}</p>
                </div>
                <div class="bg-purple-50 text-purple-500 rounded-2xl p-4 shadow-inner">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
            </div>

            <!-- Evaluations -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex items-center justify-between hover:shadow-md transition-shadow">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Évaluations</p>
                    <p class="text-3xl font-black text-gray-900">{{ $evaluationsCount ?? 0 }}</p>
                </div>
                <div class="bg-orange-50 text-orange-500 rounded-2xl p-4 shadow-inner">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Filtres Section -->
        <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-6">
            <h4 class="text-sm font-bold text-gray-700 mb-4 flex items-center uppercase tracking-wide">
                <svg class="w-4 h-4 mr-2 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                </svg>
                Filtres de recherche
            </h4>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-2">CLASSE</label>
                    <select id="filter_classe" 
                        class="w-full bg-gray-50 border-gray-200 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 py-2.5">
                        <option value="">Toutes les classes</option>
                        @foreach($classes ?? [] as $classe)
                            <option value="{{ $classe->id }}">{{ $classe->nom }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-2">MATIÈRE</label>
                    <select id="filter_matiere"
                        class="w-full bg-gray-50 border-gray-200 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 py-2.5">
                        <option value="">Toutes les matières</option>
                        @foreach($matieres ?? [] as $matiere)
                            <option value="{{ $matiere->id }}">{{ $matiere->nom }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-2">ÉVALUATION</label>
                    <select id="filter_evaluation"
                        class="w-full bg-gray-50 border-gray-200 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 py-2.5">
                        <option value="">Toutes les évaluations</option>
                        @foreach($evaluations ?? [] as $evaluation)
                            <option value="{{ $evaluation->id }}">{{ $evaluation->nom }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-2">RECHERCHE ÉLÈVE</label>
                    <div class="relative">
                        <input type="text" id="filter_eleve" placeholder="Ex: Jean Dupont..."
                            class="w-full pl-10 pr-4 bg-gray-50 border-gray-200 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 py-2.5">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex flex-col sm:flex-row justify-end mt-6 gap-3 pt-4 border-t border-gray-100">
                <button onclick="reinitialiserFiltres()"
                    class="px-5 py-2.5 text-sm font-bold bg-white text-gray-700 border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors">
                    Réinitialiser
                </button>
                <button onclick="appliquerFiltres()"
                    class="px-5 py-2.5 text-sm font-bold bg-emerald-600 text-white rounded-xl shadow-md hover:bg-emerald-700 transition-colors">
                    Filtrer les résultats
                </button>
            </div>
        </div>

        <!-- Data Table -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
            <div class="flex flex-col sm:flex-row justify-between items-center bg-gray-50/50 p-6 border-b border-gray-100">
                <h3 class="text-xl font-bold text-gray-900 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                    </svg>
                    Registre des évaluations
                </h3>
                <span class="bg-white border border-gray-200 text-gray-600 text-sm font-bold py-1.5 px-4 rounded-full shadow-sm mt-3 sm:mt-0">
                    Total: {{ $notes->total() ?? $notes->count() }}
                </span>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse" id="notesTable">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200 text-xs font-black text-gray-500 uppercase tracking-wider">
                            <th class="p-4 w-16 text-center">N°</th>
                            <th class="p-4">Élève</th>
                            <th class="p-4">Classe</th>
                            <th class="p-4">Évaluation</th>
                            <th class="p-4 text-center">Type</th>
                            <th class="p-4 text-center">Note</th>
                            <th class="p-4 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse($notes as $index => $note)
                            <tr class="hover:bg-gray-50/50 transition-colors group">
                                <td class="p-4 text-center text-sm font-semibold text-gray-400">
                                    {{ $notes->firstItem() + $index }}
                                </td>
                                
                                <td class="p-4">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 shrink-0 rounded-full bg-gradient-to-br from-indigo-100 to-emerald-100 flex items-center justify-center text-indigo-700 font-bold border border-white shadow-sm mr-3">
                                            {{ substr($note->eleve->prenom, 0, 1) }}{{ substr($note->eleve->nom, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="text-sm font-bold text-gray-900">{{ $note->eleve->prenom }} {{ $note->eleve->nom }}</div>
                                            <div class="text-xs font-semibold text-gray-500 mt-0.5">{{ $note->eleve->matricule }}</div>
                                        </div>
                                    </div>
                                </td>

                                <td class="p-4">
                                    <span class="inline-flex items-center text-sm font-bold text-gray-700 bg-gray-100 px-3 py-1 rounded-lg">
                                        <!-- Correction d'affichage de la classe: On recupere la classe liée à l'évaluation pour laquelle cette note a ete saisie -->
                                        {{ $note->evaluation->classe->nom ?? '-' }}
                                    </span>
                                </td>

                                <td class="p-4">
                                    <div class="text-sm font-bold text-gray-900 truncate max-w-[200px]" title="{{ $note->evaluation->nom }}">{{ $note->evaluation->nom }}</div>
                                    <div class="text-xs font-semibold text-blue-600 mt-0.5">{{ $note->evaluation->matiere->nom ?? '-' }}</div>
                                </td>

                                <td class="p-4 text-center">
                                    <span class="inline-flex px-3 py-1 text-xs font-bold rounded-full 
                                        @if(($note->evaluation->type ?? '') == 'devoir') bg-blue-100 text-blue-700 border border-blue-200
                                        @elseif(($note->evaluation->type ?? '') == 'examen') bg-purple-100 text-purple-700 border border-purple-200
                                        @elseif(($note->evaluation->type ?? '') == 'interrogation') bg-orange-100 text-orange-700 border border-orange-200
                                        @else bg-gray-100 text-gray-700 border border-gray-200
                                        @endif">
                                        {{ ucfirst($note->evaluation->type ?? 'N/A') }}
                                    </span>
                                </td>

                                <td class="p-4 text-center">
                                    <div class="inline-flex items-center justify-center min-w-[70px] px-3 py-1.5 rounded-lg font-black text-sm {{ $note->note >= 10 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }} border {{ $note->note >= 10 ? 'border-green-200' : 'border-red-200' }} shadow-sm">
                                        {{ $note->note }}/20
                                    </div>
                                </td>

                                <td class="p-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <!-- Voir détails -->
                                        <a href="{{ route('enseignant.notes.show', $note->id) }}"
                                            class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition-all duration-200 shadow-sm" title="Voir détails">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </a>

                                        <!-- Modifier -->
                                        <a href="{{ route('enseignant.notes.edit', $note->id) }}"
                                            class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-amber-50 text-amber-600 hover:bg-amber-500 hover:text-white transition-all duration-200 shadow-sm" title="Modifier">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>

                                        <!-- Supprimer -->
                                        <button onclick="confirmerSuppression({{ $note->id }})"
                                            class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-red-50 text-red-600 hover:bg-red-600 hover:text-white transition-all duration-200 shadow-sm" title="Supprimer">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-16 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="bg-gray-100 rounded-full p-4 mb-4">
                                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                            </svg>
                                        </div>
                                        <p class="text-xl font-bold text-gray-900 mb-2">Aucune note enregistrée</p>
                                        <p class="text-gray-500 max-w-sm mx-auto mb-6">Il semble que vous n'ayez pas encore évalué d'élèves ou que la recherche ne donne aucun résultat.</p>
                                        <a href="{{ route('enseignant.notes.create') }}"
                                            class="inline-flex items-center px-6 py-3 bg-emerald-600 text-white font-bold rounded-xl shadow-lg hover:bg-emerald-700 transition-colors">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                            </svg>
                                            Créer une évaluation
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if(method_exists($notes, 'links') && $notes->hasPages())
                <div class="p-6 border-t border-gray-100 bg-gray-50">
                    {{ $notes->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal de confirmation de suppression -->
<div id="modalSuppression" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Overlay -->
        <div class="fixed inset-0 bg-gray-900/70 backdrop-blur-sm transition-opacity" aria-hidden="true" onclick="fermerModalSuppression()"></div>
        
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        
        <!-- Modal Panel -->
        <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md w-full border border-gray-100">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-black text-gray-900" id="modal-title">
                            Supprimer cette note
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500 font-medium">
                                Êtes-vous certain de vouloir supprimer cette note ? Cette action est irréversible et pourrait affecter la moyenne de l'élève.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-4 sm:px-6 sm:flex sm:flex-row-reverse border-t border-gray-100 gap-2">
                <button type="button" onclick="supprimerNote()" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-bold text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:w-auto sm:text-sm transition-colors">
                    Oui, supprimer
                </button>
                <button type="button" onclick="fermerModalSuppression()" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-bold text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 sm:mt-0 sm:w-auto sm:text-sm transition-colors">
                    Annuler
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Formulaire de suppression caché -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script>
    let noteIdASupprimer = null;

    function appliquerFiltres() {
        const classe = document.getElementById('filter_classe').value;
        const matiere = document.getElementById('filter_matiere').value;
        const evaluation = document.getElementById('filter_evaluation').value;
        const eleve = document.getElementById('filter_eleve').value;

        let url = new URL(window.location.href);

        if (classe) url.searchParams.set('classe', classe);
        else url.searchParams.delete('classe');
        if (matiere) url.searchParams.set('matiere', matiere);
        else url.searchParams.delete('matiere');
        if (evaluation) url.searchParams.set('evaluation', evaluation);
        else url.searchParams.delete('evaluation');
        if (eleve) url.searchParams.set('eleve', eleve);
        else url.searchParams.delete('eleve');

        window.location.href = url.toString();
    }

    function reinitialiserFiltres() {
        window.location.href = window.location.pathname;
    }

    function confirmerSuppression(id) {
        noteIdASupprimer = id;
        document.getElementById('modalSuppression').classList.remove('hidden');
        document.body.style.overflow = 'hidden'; // Stop scrolling
    }

    function fermerModalSuppression() {
        document.getElementById('modalSuppression').classList.add('hidden');
        document.body.style.overflow = '';
        noteIdASupprimer = null;
    }

    function supprimerNote() {
        if (noteIdASupprimer) {
            let form = document.getElementById('deleteForm');
            form.action = '/enseignant/notes/' + noteIdASupprimer;
            form.submit();
        }
    }

    // Recherche réactive client-side
    const filterEleve = document.getElementById('filter_eleve');
    if (filterEleve) {
        filterEleve.addEventListener('keyup', function () {
            const recherche = this.value.toLowerCase();
            const lignes = document.querySelectorAll('#notesTable tbody tr');

            lignes.forEach(ligne => {
                if (ligne.querySelector('td[colspan]')) return;

                const cells = ligne.querySelectorAll('td');
                if (cells.length < 2) return;
                
                const nomEleve = cells[1]?.textContent.toLowerCase() || '';
                const matricule = cells[1]?.textContent.toLowerCase() || '';
                
                if (nomEleve.includes(recherche) || matricule.includes(recherche)) {
                    ligne.style.display = '';
                } else {
                    ligne.style.display = 'none';
                }
            });
        });
    }

    // Hydratation des filtres depuis l'URL
    document.addEventListener('DOMContentLoaded', function () {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('classe')) document.getElementById('filter_classe').value = urlParams.get('classe');
        if (urlParams.has('matiere')) document.getElementById('filter_matiere').value = urlParams.get('matiere');
        if (urlParams.has('evaluation')) document.getElementById('filter_evaluation').value = urlParams.get('evaluation');
        if (urlParams.has('eleve')) document.getElementById('filter_eleve').value = urlParams.get('eleve');
    });

    // Échapper au clavier
    document.addEventListener('keydown', function(event) {
        if (event.key === "Escape" && !document.getElementById('modalSuppression').classList.contains('hidden')) {
            fermerModalSuppression();
        }
    });
</script>
@endsection