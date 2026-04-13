@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-sm text-gray-800 leading-tight">
        <a href="{{ route('enseignant.notes.index') }}" class="text-gray-500 hover:text-emerald-600 transition-colors mr-2">Notes</a> 
        <span class="text-gray-300">/</span> 
        <span class="text-emerald-600 ml-2">{{ __('Saisir une Note') }}</span>
    </h2>
@endsection

@section('content')
<div class="py-12 bg-gradient-to-br from-emerald-50 via-white to-teal-50 min-h-screen">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        
        <!-- Main Form Card -->
        <div class="bg-white/80 backdrop-blur-xl overflow-hidden shadow-2xl sm:rounded-3xl border border-white/50">
            <div class="p-8 sm:p-10">
                
                @if ($errors->any())
                    <div class="mb-8 bg-red-50 border-l-4 border-red-500 rounded-r-2xl p-5 shadow-sm transform transition-all hover:scale-[1.01]">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-red-100 rounded-full p-2">
                                <svg class="h-6 w-6 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-bold text-red-800 uppercase tracking-wider">Erreurs avec votre soumission</h3>
                                <ul class="mt-2 text-sm text-red-700 list-disc list-inside space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
                
                <!-- Form Header -->
                <div class="flex items-center mb-10 pb-6 border-b border-gray-100">
                    <div class="bg-gradient-to-br from-emerald-400 to-teal-500 text-white p-4 rounded-2xl shadow-lg shadow-emerald-500/30 mr-5 transform hover:rotate-3 transition-transform duration-300">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-2xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 to-teal-800">
                            Saisir une nouvelle note
                        </h3>
                        <p class="text-gray-500 text-sm mt-1 font-medium">Sélectionnez une évaluation pour commencer à noter vos élèves.</p>
                    </div>
                </div>

                <form action="{{ route('enseignant.notes.store') }}" method="POST" id="noteForm">
                    @csrf

                    <div class="space-y-8">
                        <!-- Évaluation Selection -->
                        <div class="group">
                            <label for="evaluation_id" class="block text-sm font-semibold text-gray-700 mb-2 group-hover:text-emerald-600 transition-colors">
                                Choisir l'évaluation <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <select id="evaluation_id" name="evaluation_id" required 
                                    class="block w-full rounded-xl border-gray-200 bg-gray-50 text-gray-800 py-3 pl-4 pr-10 shadow-sm focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-all duration-300 appearance-none cursor-pointer">
                                    <option value="">-- Sélectionnez une évaluation --</option>
                                    @foreach($evaluations as $evaluation)
                                        <option value="{{ $evaluation->id }}" 
                                            data-bareme="{{ $evaluation->bareme ?? 20 }}"
                                            {{ (old('evaluation_id') == $evaluation->id || (request('classe_id') == $evaluation->classe_id && request('matiere_id') == $evaluation->matiere_id)) ? 'selected' : '' }}>
                                            {{ $evaluation->nom }} - {{ $evaluation->classe->nom ?? 'Classe' }} ({{ $evaluation->matiere->nom ?? 'Matière' }}) 
                                            - {{ \Carbon\Carbon::parse($evaluation->date_evaluation)->format('d/m/Y') }} 
                                            - Type: {{ ucfirst($evaluation->type) }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 mt-2 font-medium">S'il n'y a pas d'évaluation pour cette classe, <a href="{{ route('enseignant.evaluations.create') }}" class="text-emerald-600 hover:text-emerald-800 hover:underline transition-colors">créez-en une d'abord</a>.</p>
                        </div>

                        <!-- Élève Selection (Loaded via AJAX) -->
                        <div class="group">
                            <label for="eleve_id" class="block text-sm font-semibold text-gray-700 mb-2 group-hover:text-emerald-600 transition-colors">
                                Sélectionner l'élève <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <select id="eleve_id" name="eleve_id" required 
                                    class="block w-full rounded-xl border-gray-200 bg-gray-50 text-gray-800 py-3 pl-4 pr-10 shadow-sm focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-all duration-300 appearance-none cursor-pointer disabled:opacity-60 disabled:cursor-not-allowed" disabled>
                                    <option value="">-- Sélectionnez d'abord une évaluation --</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                            <div class="mt-2 flex items-center">
                                <div id="loading_indicator" class="hidden mr-2">
                                    <svg class="animate-spin h-4 w-4 text-emerald-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                </div>
                                <p id="eleve_helper_text" class="text-xs text-gray-500 font-medium">Vous ne verrez que les élèves qui n'ont pas encore de note pour cette évaluation.</p>
                            </div>
                            @error('eleve_id')
                                <p class="text-sm text-red-600 mt-2 font-medium flex items-center"><svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Ligne Note et Barème -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="group">
                                <label for="note" class="block text-sm font-semibold text-gray-700 mb-2 group-hover:text-emerald-600 transition-colors">
                                    Note de l'élève <span class="text-red-500">*</span>
                                </label>
                                <div class="relative rounded-xl shadow-sm overflow-hidden flex ring-1 ring-gray-200 focus-within:ring-2 focus-within:ring-emerald-500 transition-all duration-300">
                                    <input type="number" step="0.25" min="0" max="20" id="note" name="note" required value="{{ old('note') }}"
                                        class="block w-full border-0 bg-gray-50 focus:bg-white text-lg font-bold text-emerald-700 py-4 pl-5 focus:ring-0 transition-colors" placeholder="Ex: 14.5">
                                    <div class="flex items-center justify-center px-5 bg-gray-100 border-l border-gray-200">
                                        <span class="text-gray-600 font-black text-lg" id="bareme_display">/ 20</span>
                                    </div>
                                </div>
                                @error('note')
                                    <p class="text-sm text-red-600 mt-2 font-medium flex items-center"><svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Observation -->
                        <div class="group">
                            <label for="observation" class="block text-sm font-semibold text-gray-700 mb-2 group-hover:text-emerald-600 transition-colors">
                                Observation / Appréciation <span class="text-gray-400 font-normal">(Optionnel)</span>
                            </label>
                            <textarea id="observation" name="observation" rows="4"
                                class="block w-full rounded-xl border-gray-200 bg-gray-50 text-gray-800 p-4 shadow-sm focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-all duration-300 resize-y"
                                placeholder="Ajoutez un commentaire motivant ou une remarque sur le travail de l'élève...">{{ old('observation') }}</textarea>
                            @error('observation')
                                <p class="text-sm text-red-600 mt-2 font-medium flex items-center"><svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-12 flex flex-col sm:flex-row justify-end gap-4 pt-6 border-t border-gray-100">
                        <a href="{{ route('enseignant.notes.index') }}" 
                            class="px-6 py-3 bg-white text-gray-700 font-semibold border-2 border-gray-200 rounded-xl shadow-sm hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-200 transition-all duration-300 text-center">
                            Annuler
                        </a>
                        <button type="submit" 
                            class="px-8 py-3 bg-gradient-to-r from-emerald-500 to-teal-500 text-white font-bold rounded-xl shadow-lg shadow-emerald-500/30 hover:shadow-xl hover:from-emerald-600 hover:to-teal-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transform hover:-translate-y-0.5 transition-all duration-300 flex items-center justify-center">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Enregistrer la note
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const evaluationSelect = document.getElementById('evaluation_id');
        const eleveSelect = document.getElementById('eleve_id');
        const baremeDisplay = document.getElementById('bareme_display');
        const noteInput = document.getElementById('note');
        const eleveHelperText = document.getElementById('eleve_helper_text');
        const loadingIndicator = document.getElementById('loading_indicator');

        // Charger les élèves si une évaluation est déjà sélectionnée
        if (evaluationSelect.value) {
            chargerEleves(evaluationSelect.value);
            mettreAJourBareme();
        }

        evaluationSelect.addEventListener('change', function() {
            if (this.value) {
                chargerEleves(this.value);
                mettreAJourBareme();
            } else {
                reinitialiserEleveSelect();
            }
        });

        function mettreAJourBareme() {
            const selectedOption = evaluationSelect.options[evaluationSelect.selectedIndex];
            if (selectedOption && selectedOption.dataset.bareme) {
                const bareme = selectedOption.dataset.bareme;
                baremeDisplay.textContent = '/ ' + bareme;
                noteInput.max = bareme;
            }
        }

        function chargerEleves(evaluationId) {
            eleveSelect.disabled = true;
            eleveSelect.innerHTML = '<option value="">Chargement des élèves en cours...</option>';
            eleveSelect.classList.add('bg-gray-100', 'animate-pulse');
            loadingIndicator.classList.remove('hidden');
            
            fetch(`/enseignant/notes/eleves/${evaluationId}`)
                .then(response => response.json())
                .then(data => {
                    loadingIndicator.classList.add('hidden');
                    eleveSelect.classList.remove('animate-pulse', 'bg-gray-100');
                    
                    if (data.success) {
                        eleveSelect.innerHTML = '<option value="">-- Sélectionnez un élève pour le noter --</option>';
                        
                        if (data.data.length === 0) {
                            eleveSelect.innerHTML = '<option value="">Aucun élève disponible (ou tous ont déjà une note)</option>';
                            eleveHelperText.innerHTML = '<span class="text-orange-500 font-bold flex items-center"><svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg> Tous les élèves ont déjà une note pour cette évaluation, ou la classe correspondante est vide.</span>';
                        } else {
                            data.data.forEach(eleve => {
                                const option = document.createElement('option');
                                option.value = eleve.id;
                                if ('{{ old("eleve_id") }}' == eleve.id) {
                                    option.selected = true;
                                }
                                option.textContent = `${eleve.nom} ${eleve.prenom} — Matricule: ${eleve.matricule}`;
                                eleveSelect.appendChild(option);
                            });
                            eleveSelect.disabled = false;
                            eleveHelperText.innerHTML = '<span class="text-emerald-600">Liste des élèves mise à jour avec succès.</span>';
                        }
                        
                        // Update bareme if returned
                        if(data.bareme) {
                            baremeDisplay.textContent = '/ ' + data.bareme;
                            noteInput.max = data.bareme;
                        }

                    } else {
                        reinitialiserEleveSelect('Erreur lors du chargement des élèves');
                        eleveHelperText.innerHTML = '<span class="text-red-500 font-medium">Une erreur est survenue lors de la récupération des élèves.</span>';
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    loadingIndicator.classList.add('hidden');
                    eleveSelect.classList.remove('animate-pulse', 'bg-gray-100');
                    reinitialiserEleveSelect('Impossible de contacter le serveur');
                    eleveHelperText.innerHTML = '<span class="text-red-500 font-medium">Problème de connexion au serveur.</span>';
                });
        }

        function reinitialiserEleveSelect(message = '-- Sélectionnez d\'abord une évaluation --') {
            eleveSelect.innerHTML = `<option value="">${message}</option>`;
            eleveSelect.disabled = true;
            baremeDisplay.textContent = '/ 20';
            noteInput.max = 20;
            eleveHelperText.innerHTML = 'Vous ne verrez que les élèves qui n\'ont pas encore de note pour cette évaluation.';
        }
    });
</script>
@endsection
