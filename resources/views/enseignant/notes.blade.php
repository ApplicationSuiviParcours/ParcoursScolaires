@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Saisie des Notes') }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header avec bouton de création -->
            <div class="bg-gradient-to-r from-green-700 to-green-500 rounded-xl shadow-lg mb-8 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-2xl font-bold text-white">Saisie des Notes</h3>
                        <p class="text-green-100 mt-1">Enregistrer, modifier et gérer les notes des élèves</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('enseignant.notes.create') }}"
                            class="bg-white text-green-600 px-4 py-2 rounded-lg font-semibold hover:bg-green-50 transition-colors flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                                </path>
                            </svg>
                            Nouvelle note
                        </a>
                        <div class="hidden md:block">
                            <div class="bg-white/20 rounded-full p-4">
                                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-md p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Total notes</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalNotes ?? 0 }}</p>
                        </div>
                        <div class="bg-blue-100 rounded-full p-3">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-md p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Moyenne générale</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $moyenneGenerale ?? 0 }}/20</p>
                        </div>
                        <div class="bg-green-100 rounded-full p-3">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-md p-6">
                    <div class=" flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Classes</p>
                        <p class="text-3xl font-bold text-gray-900 mt-1">{{ $classesCount ?? 0 }}</p>
                    </div>
                    <div class="bg-purple-100 rounded-full p-3">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Évaluations</p>
                        <p class="text-3xl font-bold text-gray-900 mt-1">{{ $evaluationsCount ?? 0 }}</p>
                    </div>
                    <div class="bg-orange-100 rounded-full p-3">
                        <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filtres de recherche -->
        <div class="bg-white rounded-xl shadow-md mb-8 p-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Classe</label>
                        <select
                            id="filter_classe" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
                            <option value="">Toutes les classes</option>
                                @foreach($classes ?? [] as $classe)
                                    <option value="{{ $classe->id }}">{{ $classe->nom }}</option>
                                @endforeach
                        </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Matière</label>
                    <select id="filter_matiere"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
                        <option value="">Toutes les matières</option>
                        @foreach($matieres ?? [] as $matiere)
                            <option value="{{ $matiere->id }}">{{ $matiere->nom }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Évaluation</label>
                    <select id="filter_evaluation"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
                        <option value="">Toutes les évaluations</option>
                        @foreach($evaluations ?? [] as $evaluation)
                            <option value="{{ $evaluation->id }}">{{ $evaluation->nom }} ({{ $evaluation->type }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Élève</label>
                    <input type="text" id="filter_eleve" placeholder="Rechercher un élève..."
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
                </div>
            </div>
            <div class="flex justify-end mt-4 space-x-2">
                <button onclick="reinitialiserFiltres()"
                    class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                    Réinitialiser
                </button>
                <button onclick="appliquerFiltres()"
                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                    Appliquer les filtres
                </button>
            </div>
        </div>

        <!-- Notes Table avec actions -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-900">Liste des notes</h3>
                <span class="text-sm text-gray-500">Total: {{ $notes->total() ?? $notes->count() }} note(s)</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full" id="notesTable">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">N°
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Élève
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Classe</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Évaluation</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Matière</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Note
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Observation</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($notes as $index => $note)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $index + 1 }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $note->eleve->nom ?? '-' }} {{ $note->eleve->prenom ?? '' }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        {{ $note->eleve->matricule ?? '' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $note->eleve->classe->nom ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $note->evaluation->nom ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $note->evaluation->matiere->nom ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($note->evaluation)
                                        <span class="px-2 py-1 text-xs rounded-full 
                                                @if($note->evaluation->type == 'devoir') bg-blue-100 text-blue-800
                                                @elseif($note->evaluation->type == 'examen') bg-purple-100 text-purple-800
                                                @elseif($note->evaluation->type == 'interrogation') bg-green-100 text-green-800
                                                @else bg-gray-100 text-gray-800
                                                @endif">
                                            {{ ucfirst($note->evaluation->type ?? 'N/A') }}
                                        </span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $note->note >= 10 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $note->note }}/20
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 max-w-xs truncate">
                                    {{ $note->observation ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <!-- Voir détails -->
                                        <a href="{{ route('enseignant.notes.show', $note->id) }}"
                                            class="text-blue-600 hover:text-blue-900" title="Voir détails">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                </path>
                                            </svg>
                                        </a>

                                        <!-- Modifier -->
                                        <a href="{{ route('enseignant.notes.edit', $note->id) }}"
                                            class="text-green-600 hover:text-green-900" title="Modifier">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            </svg>
                                        </a>

                                        <!-- Supprimer -->
                                        <button onclick="confirmerSuppression({{ $note->id }})"
                                            class="text-red-600 hover:text-red-900" title="Supprimer">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-6 py-12 text-center text-gray-500">
                                    <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                        </path>
                                    </svg>
                                    <p class="text-lg">Aucune note trouvée</p>
                                    <p class="text-sm mt-2">Commencez par saisir une note</p>
                                    <a href="{{ route('enseignant.notes.create') }}"
                                        class="mt-4 inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4v16m8-8H4"></path>
                                        </svg>
                                        Nouvelle note
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if(method_exists($notes, 'links'))
                <div class="p-4 border-t border-gray-100">
                    {{ $notes->links() }}
                </div>
            @endif
        </div>
    </div>
    </div>

    <!-- Modal de confirmation de suppression -->
    <div id="modalSuppression" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-full max-w-md shadow-lg rounded-lg bg-white">
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                    <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                        </path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Confirmer la suppression</h3>
                <p class="text-sm text-gray-500 mb-4">Êtes-vous sûr de vouloir supprimer cette note ? Cette action est
                    irréversible.</p>
                <div class="flex justify-center space-x-3">
                    <button onclick="fermerModalSuppression()"
                        class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                        Annuler
                    </button>
                    <button onclick="supprimerNote()"
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                        Supprimer
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
        // Variables globales
        let noteIdASupprimer = null;

        // Fonctions pour les filtres
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

        // Fonctions pour la suppression
        function confirmerSuppression(id) {
            noteIdASupprimer = id;
            document.getElementById('modalSuppression').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function fermerModalSuppression() {
            document.getElementById('modalSuppression').classList.add('hidden');
            document.body.style.overflow = 'auto';
            noteIdASupprimer = null;
        }

        function supprimerNote() {
            if (noteIdASupprimer) {
                let form = document.getElementById('deleteForm');
                form.action = '/enseignant/notes/' + noteIdASupprimer;
                form.submit();
            }
        }

        // Recherche en temps réel dans le tableau
        document.getElementById('filter_eleve').addEventListener('keyup', function () {
            const recherche = this.value.toLowerCase();
            const lignes = document.querySelectorAll('#notesTable tbody tr');

            lignes.forEach(ligne => {
                if (ligne.querySelector('td[colspan]')) return;

                const eleve = ligne.cells[1]?.textContent.toLowerCase() || '';
                const classe = ligne.cells[2]?.textContent.toLowerCase() || '';
                const evaluation = ligne.cells[3]?.textContent.toLowerCase() || '';

                if (eleve.includes(recherche) || classe.includes(recherche) || evaluation.includes(recherche)) {
                    ligne.style.display = '';
                } else {
                    ligne.style.display = 'none';
                }
            });
        });

        // Fermer le modal en cliquant en dehors
        window.onclick = function (event) {
            const modal = document.getElementById('modalSuppression');
            if (event.target == modal) {
                fermerModalSuppression();
            }
        }

        // Remplir les filtres avec les valeurs de l'URL au chargement
        document.addEventListener('DOMContentLoaded', function () {
            const urlParams = new URLSearchParams(window.location.search);

            if (urlParams.has('classe')) {
                document.getElementById('filter_classe').value = urlParams.get('classe');
            }
            if (urlParams.has('matiere')) {
                document.getElementById('filter_matiere').value = urlParams.get('matiere');
            }
            if (urlParams.has('evaluation')) {
                document.getElementById('filter_evaluation').value = urlParams.get('evaluation');
            }
            if (urlParams.has('eleve')) {
                document.getElementById('filter_eleve').value = urlParams.get('eleve');
            }
        });
    </script>

    <style>
        /* Animation du modal */
        #modalSuppression {
            transition: opacity 0.3s ease;
        }

        #modalSuppression .relative {
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

        /* Style pour les notes */
        .bg-green-100 {
            background-color: #d1fae5;
        }

        .text-green-800 {
            color: #065f46;
        }

        .bg-red-100 {
            background-color: #fee2e2;
        }

        .text-red-800 {
            color: #991b1b;
        }
    </style>
@endsection