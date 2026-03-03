@extends('layouts.app')

@section('header')
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
        {{ __('Créer une absence') }}
    </h2>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <!-- Header avec bouton retour -->
        <div class="p-6 mb-8 shadow-lg bg-gradient-to-r from-red-600 to-red-400 rounded-xl">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <a href="{{ route('enseignant.absences.index') }}" class="mr-4 text-white hover:text-red-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                    </a>
                    <div>
                        <h3 class="text-2xl font-bold text-white">Nouvelle absence</h3>
                        <p class="mt-1 text-red-100">Enregistrer une absence pour un élève</p>
                    </div>
                </div>
                <div class="hidden md:block">
                    <div class="p-3 rounded-full bg-white/20">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Formulaire -->
        <div class="overflow-hidden bg-white shadow-md rounded-xl">
            <div class="p-6 border-b border-gray-100">
                <h4 class="text-lg font-semibold text-gray-900">Informations de l'absence</h4>
                <p class="mt-1 text-sm text-gray-500">Remplissez tous les champs obligatoires</p>
            </div>

            <form action="{{ route('enseignant.absences.store') }}" method="POST" class="p-6">
                @csrf

                <div class="space-y-6">
                    <!-- Sélection de la classe -->
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">
                            Classe <span class="text-red-500">*</span>
                        </label>
                        <select id="classe_select" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 @error('classe_id') border-red-500 @enderror" required>
                            <option value="">Sélectionner une classe</option>
                            @foreach($classes as $classe)
                                <option value="{{ $classe->id }}" data-eleves='@json($classe->eleves)'>
                                    {{ $classe->nom }} - {{ $classe->niveau ?? '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Sélection de l'élève -->
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">
                            Élève <span class="text-red-500">*</span>
                        </label>
                        <select name="eleve_id" id="eleve_select" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 @error('eleve_id') border-red-500 @enderror">
                            <option value="">Sélectionnez d'abord une classe</option>
                        </select>
                        @error('eleve_id')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Sélection de la matière -->
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">
                            Matière <span class="text-red-500">*</span>
                        </label>
                        <select name="matiere_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 @error('matiere_id') border-red-500 @enderror">
                            <option value="">Sélectionner une matière</option>
                            @foreach($matieres as $matiere)
                                <option value="{{ $matiere->id }}">{{ $matiere->nom }}</option>
                            @endforeach
                        </select>
                        @error('matiere_id')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Date de l'absence -->
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">
                            Date de l'absence <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="date_absence" value="{{ old('date_absence', date('Y-m-d')) }}" 
                               min="{{ date('Y-m-d') }}" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 @error('date_absence') border-red-500 @enderror"
                               required>
                        @error('date_absence')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Vous ne pouvez créer des absences que pour aujourd'hui et les jours à venir.</p>
                    </div>

                    <!-- Heures d'absence -->
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-700">
                                Heure de début <span class="text-red-500">*</span>
                            </label>
                            <input type="time" name="heure_debut" value="{{ old('heure_debut', '08:00') }}" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 @error('heure_debut') border-red-500 @enderror"
                                   required>
                            @error('heure_debut')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-700">
                                Heure de fin <span class="text-red-500">*</span>
                            </label>
                            <input type="time" name="heure_fin" value="{{ old('heure_fin', '10:00') }}" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 @error('heure_fin') border-red-500 @enderror"
                                   required>
                            @error('heure_fin')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Durée (calculée automatiquement) -->
                    <div class="p-4 rounded-lg bg-gray-50">
                        <label class="block mb-2 text-sm font-medium text-gray-700">
                            Durée de l'absence
                        </label>
                        <div class="flex items-center">
                            <span id="duree_display" class="text-2xl font-bold text-gray-900">2</span>
                            <span class="ml-2 text-gray-600">heure(s)</span>
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Calculée automatiquement</p>
                    </div>

                    <!-- Motif (optionnel) -->
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">
                            Motif (optionnel)
                        </label>
                        <textarea name="motif" rows="3" 
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                  placeholder="Raison de l'absence...">{{ old('motif') }}</textarea>
                    </div>

                    <!-- Justification -->
                    <div class="flex items-center">
                        <input type="checkbox" name="justifie" id="justifie" value="1" {{ old('justifie') ? 'checked' : '' }}
                               class="w-4 h-4 text-red-600 border-gray-300 rounded focus:ring-red-500">
                        <label for="justifie" class="block ml-2 text-sm text-gray-900">
                            Absence justifiée
                        </label>
                    </div>

                    <!-- Message d'avertissement -->
                    <div class="p-4 border-l-4 border-yellow-400 bg-yellow-50">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-yellow-700">
                                    <strong>Attention :</strong> En créant cette absence, vous confirmez que l'élève était absent pendant cette période. 
                                    Cette information sera visible par l'administration et les parents.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Boutons d'action -->
                    <div class="flex justify-end pt-6 space-x-3 border-t">
                        <a href="{{ route('enseignant.absences.index') }}" 
                           class="px-6 py-2 text-gray-700 transition-colors border border-gray-300 rounded-lg hover:bg-gray-50">
                            Annuler
                        </a>
                        <button type="submit" 
                                class="flex items-center px-6 py-2 text-white transition-colors bg-red-600 rounded-lg hover:bg-red-700">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                            </svg>
                            Enregistrer l'absence
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const classeSelect = document.getElementById('classe_select');
    const eleveSelect = document.getElementById('eleve_select');
    const heureDebut = document.querySelector('input[name="heure_debut"]');
    const heureFin = document.querySelector('input[name="heure_fin"]');
    const dureeDisplay = document.getElementById('duree_display');

    // Charger les élèves quand une classe est sélectionnée
    classeSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        let eleves = [];
        
        try {
            eleves = selectedOption.dataset.eleves ? JSON.parse(selectedOption.dataset.eleves) : [];
        } catch (e) {
            eleves = [];
        }
        
        eleveSelect.innerHTML = '<option value="">Sélectionner un élève</option>';
        
        eleves.forEach(eleve => {
            const option = document.createElement('option');
            option.value = eleve.id;
            option.textContent = (eleve.nom || '') + ' ' + (eleve.prenom || '');
            eleveSelect.appendChild(option);
        });
    });

    // Calculer automatiquement la durée
    function calculerDuree() {
        if (heureDebut.value && heureFin.value) {
            const debut = heureDebut.value.split(':');
            const fin = heureFin.value.split(':');
            
            const debutMinutes = parseInt(debut[0]) * 60 + parseInt(debut[1]);
            const finMinutes = parseInt(fin[0]) * 60 + parseInt(fin[1]);
            
            let diffHeures = (finMinutes - debutMinutes) / 60;
            
            if (diffHeures > 0) {
                dureeDisplay.textContent = diffHeures.toFixed(1);
            } else {
                dureeDisplay.textContent = '0';
            }
        }
    }

    heureDebut.addEventListener('change', calculerDuree);
    heureFin.addEventListener('change', calculerDuree);
    
    // Calcul initial
    calculerDuree();
});
</script>
@endsection