@extends('layouts.app')

@section('title', 'Enregistrer une absence')

@section('header')
<div class="relative overflow-hidden bg-gradient-to-br from-emerald-600 via-emerald-700 to-teal-800 py-8 md:py-12">
    <!-- Éléments décoratifs animés -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-white rounded-full mix-blend-overlay filter blur-3xl animate-pulse"></div>
        <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-teal-300 rounded-full mix-blend-overlay filter blur-3xl animate-pulse delay-1000"></div>
    </div>
    
    <!-- Particules flottantes (masquées sur mobile) -->
    <div class="absolute inset-0 overflow-hidden hidden sm:block">
        @for($i = 1; $i <= 4; $i++)
            <div class="absolute w-1 h-1 bg-white rounded-full opacity-30 animate-float-{{ $i }}"
                 style="left: {{ rand(0, 100) }}%; top: {{ rand(0, 100) }}%; animation-delay: {{ rand(0, 5) }}s;"></div>
        @endfor
    </div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div class="text-center md:text-left">
                <nav class="flex mb-4 justify-center md:justify-start" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ route('admin.absences.index') }}" class="inline-flex items-center text-sm font-medium text-emerald-200 hover:text-white transition-colors duration-300">
                                <svg class="w-4 h-4 mr-1 md:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                                <span class="hidden sm:inline">Absences</span>
                                <span class="sm:hidden">Liste</span>
                            </a>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 md:w-6 md:h-6 text-emerald-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="ml-1 text-sm font-medium text-white md:ml-2">Nouvelle</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-white mb-2 animate-fade-in-up">
                    Enregistrer une absence
                </h1>
                <p class="text-emerald-200 text-sm md:text-base animate-fade-in-up animation-delay-200">
                    Ajouter une absence pour un élève
                </p>
            </div>
        </div>
    </div>

    <!-- Vague décorative -->
    <div class="absolute bottom-0 left-0 right-0">
        <svg class="fill-current text-gray-50" viewBox="0 0 1440 120" preserveAspectRatio="none">
            <path d="M0,64L80,69.3C160,75,320,85,480,80C640,75,800,53,960,48C1120,43,1280,53,1360,58.7L1440,64L1440,120L1360,120C1280,120,1120,120,960,120C800,120,640,120,480,120C320,120,160,120,80,120L0,120Z"></path>
        </svg>
    </div>
</div>
@endsection

@section('content')
<div class="container mx-auto px-4 py-6 md:py-10 bg-gray-50">
    <div class="max-w-3xl mx-auto">
        <!-- Formulaire -->
        <div class="bg-white rounded-2xl md:rounded-3xl shadow-xl overflow-hidden">
            <div class="bg-gradient-to-r from-emerald-500 to-teal-600 px-4 md:px-8 py-4 md:py-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-12 h-12 md:w-14 md:h-14 bg-white/20 backdrop-blur-lg rounded-xl md:rounded-2xl flex items-center justify-center mr-4 md:mr-5 flex-shrink-0">
                            <svg class="w-6 h-6 md:w-7 md:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <h2 class="text-xl md:text-2xl font-bold text-white mb-1">Informations</h2>
                            <p class="text-emerald-100 text-xs md:text-sm">* Champs obligatoires</p>
                        </div>
                    </div>
                    <!-- Indicateur de progression (texte caché sur mobile) -->
                    <div class="text-right hidden sm:block">
                        <span class="text-white/80 text-sm">Complétion</span>
                        <div class="w-32 h-2 bg-white/20 rounded-full mt-1">
                            <div class="bg-white h-2 rounded-full transition-all duration-300" style="width: 0%" id="progressBar"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-4 md:p-8">
                <form action="{{ route('admin.absences.store') }}" method="POST" id="createForm">
                    @csrf

                    <div class="space-y-5 md:space-y-6">
                        <!-- Élève -->
                        <div class="group">
                            <label for="eleve_id" class="block text-xs md:text-sm font-semibold text-gray-700 mb-1 md:mb-2 group-hover:text-emerald-600 transition-colors duration-300">
                                Élève <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400 group-hover:text-emerald-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <select name="eleve_id" 
                                        id="eleve_id" 
                                        class="w-full pl-12 pr-10 py-2.5 md:py-3 rounded-xl border-2 border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-all duration-300 @error('eleve_id') border-red-500 @enderror appearance-none bg-white text-sm md:text-base"
                                        required>
                                    <option value="">Sélectionnez...</option>
                                    @foreach($eleves as $eleve)
                                        <option value="{{ $eleve->id }}" {{ old('eleve_id') == $eleve->id ? 'selected' : '' }}>
                                            {{ $eleve->nom }} {{ $eleve->prenom }} ({{ $eleve->matricule ?? 'N/A' }})
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                            @error('eleve_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Matière -->
                        <div class="group">
                            <label for="matiere_id" class="block text-xs md:text-sm font-semibold text-gray-700 mb-1 md:mb-2 group-hover:text-emerald-600 transition-colors duration-300">
                                Matière <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400 group-hover:text-emerald-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                </div>
                                <select name="matiere_id" 
                                        id="matiere_id" 
                                        class="w-full pl-12 pr-10 py-2.5 md:py-3 rounded-xl border-2 border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-all duration-300 @error('matiere_id') border-red-500 @enderror appearance-none bg-white text-sm md:text-base"
                                        required>
                                    <option value="">Sélectionnez...</option>
                                    @foreach($matieres as $matiere)
                                        <option value="{{ $matiere->id }}" {{ old('matiere_id') == $matiere->id ? 'selected' : '' }}>
                                            {{ $matiere->nom }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                            @error('matiere_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Année scolaire -->
                        <div class="group">
                            <label for="annee_scolaire_id" class="block text-xs md:text-sm font-semibold text-gray-700 mb-1 md:mb-2 group-hover:text-emerald-600 transition-colors duration-300">
                                Année scolaire <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400 group-hover:text-emerald-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <select name="annee_scolaire_id" 
                                        id="annee_scolaire_id" 
                                        class="w-full pl-12 pr-10 py-2.5 md:py-3 rounded-xl border-2 border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-all duration-300 @error('annee_scolaire_id') border-red-500 @enderror appearance-none bg-white text-sm md:text-base"
                                        required>
                                    <option value="">Sélectionnez...</option>
                                    @foreach($anneeScolaires as $annee)
                                        <option value="{{ $annee->id }}" {{ old('annee_scolaire_id') == $annee->id ? 'selected' : '' }}>
                                            {{ $annee->nom }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                            @error('annee_scolaire_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Date d'absence -->
                        <div class="group">
                            <label for="date_absence" class="block text-xs md:text-sm font-semibold text-gray-700 mb-1 md:mb-2 group-hover:text-emerald-600 transition-colors duration-300">
                                Date d'absence <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400 group-hover:text-emerald-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <input type="date" 
                                       name="date_absence" 
                                       id="date_absence" 
                                       value="{{ old('date_absence', date('Y-m-d')) }}"
                                       class="w-full pl-12 pr-4 py-2.5 md:py-3 rounded-xl border-2 border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-all duration-300 @error('date_absence') border-red-500 @enderror text-sm md:text-base"
                                       required>
                            </div>
                            @error('date_absence')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Heures -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 md:gap-6">
                            <div class="group">
                                <label for="heure_debut" class="block text-xs md:text-sm font-semibold text-gray-700 mb-1 md:mb-2 group-hover:text-emerald-600 transition-colors duration-300">
                                    Heure début <span class="text-xs text-gray-500">(optionnel)</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400 group-hover:text-emerald-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <input type="time" 
                                           name="heure_debut" 
                                           id="heure_debut" 
                                           value="{{ old('heure_debut') }}"
                                           class="w-full pl-12 pr-4 py-2.5 md:py-3 rounded-xl border-2 border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-all duration-300 @error('heure_debut') border-red-500 @enderror text-sm md:text-base">
                                </div>
                                @error('heure_debut')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="group">
                                <label for="heure_fin" class="block text-xs md:text-sm font-semibold text-gray-700 mb-1 md:mb-2 group-hover:text-emerald-600 transition-colors duration-300">
                                    Heure fin <span class="text-xs text-gray-500">(optionnel)</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400 group-hover:text-emerald-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <input type="time" 
                                           name="heure_fin" 
                                           id="heure_fin" 
                                           value="{{ old('heure_fin') }}"
                                           class="w-full pl-12 pr-4 py-2.5 md:py-3 rounded-xl border-2 border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-all duration-300 @error('heure_fin') border-red-500 @enderror text-sm md:text-base">
                                </div>
                                @error('heure_fin')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Motif -->
                        <div class="group">
                            <label for="motif" class="block text-xs md:text-sm font-semibold text-gray-700 mb-1 md:mb-2 group-hover:text-emerald-600 transition-colors duration-300">
                                Motif <span class="text-xs text-gray-500">(optionnel)</span>
                            </label>
                            <div class="relative">
                                <div class="absolute top-3 md:top-4 left-4 pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400 group-hover:text-emerald-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                                    </svg>
                                </div>
                                <textarea name="motif" 
                                          id="motif" 
                                          rows="3"
                                          placeholder="Motif de l'absence..."
                                          class="w-full pl-12 pr-4 py-2.5 md:py-3 rounded-xl border-2 border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-all duration-300 @error('motif') border-red-500 @enderror text-sm md:text-base">{{ old('motif') }}</textarea>
                            </div>
                            @error('motif')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Justifiée ? -->
                        <div class="group">
                            <label class="block text-xs md:text-sm font-semibold text-gray-700 mb-1 md:mb-2 group-hover:text-emerald-600 transition-colors duration-300">
                                Statut
                            </label>
                            <div class="relative flex items-center justify-center sm:justify-start space-x-6 p-4 bg-gray-50 rounded-xl">
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="justifiee" value="1" {{ old('justifiee') == '1' ? 'checked' : '' }} class="w-4 h-4 text-emerald-600 border-gray-300 focus:ring-emerald-500">
                                    <span class="ml-2 text-xs md:text-sm text-gray-700">Justifiée</span>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="justifiee" value="0" {{ old('justifiee') == '0' || old('justifiee') === null ? 'checked' : '' }} class="w-4 h-4 text-emerald-600 border-gray-300 focus:ring-emerald-500">
                                    <span class="ml-2 text-xs md:text-sm text-gray-700">Non justifiée</span>
                                </label>
                            </div>
                            @error('justifiee')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Boutons d'action -->
                        <div class="flex flex-col-reverse sm:flex-row justify-end gap-3 sm:gap-4 pt-6 border-t-2 border-gray-100">
                            <a href="{{ route('admin.absences.index') }}" 
                               class="w-full sm:w-auto text-center px-6 py-2.5 md:py-3 bg-white border-2 border-gray-300 rounded-xl text-gray-700 font-semibold hover:bg-gray-50 transition-all duration-300 transform hover:scale-105 text-sm md:text-base">
                                Annuler
                            </a>
                            <button type="submit" 
                                    class="w-full sm:w-auto px-6 py-2.5 md:py-3 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-semibold rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-xl text-sm md:text-base">
                                <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                                </svg>
                                Enregistrer
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Prévention du zoom sur les inputs iOS */
    input, select, textarea {
        font-size: 16px;
    }
</style>
@endpush

@push('scripts')
<script>
    // Barre de progression
    function updateProgressBar() {
        const requiredFields = document.querySelectorAll('#createForm [required]');
        const filledFields = Array.from(requiredFields).filter(field => field.value && field.value.trim() !== '');
        const percentage = Math.round((filledFields.length / requiredFields.length) * 100);
        
        const progressBar = document.getElementById('progressBar');
        if (progressBar) {
            progressBar.style.width = percentage + '%';
        }
    }

    // Ajouter les écouteurs d'événements
    document.querySelectorAll('#createForm [required]').forEach(field => {
        field.addEventListener('change', updateProgressBar);
        field.addEventListener('input', updateProgressBar);
    });

    // Validation des heures
    const heureFinInput = document.getElementById('heure_fin');
    const heureDebutInput = document.getElementById('heure_debut');

    if (heureFinInput && heureDebutInput) {
        heureFinInput.addEventListener('change', function() {
            const debut = heureDebutInput.value;
            const fin = this.value;
            
            if (debut && fin && fin <= debut) {
                alert('L\'heure de fin doit être postérieure à l\'heure de début');
                this.value = '';
            }
        });
    }

    // Confirmation avant de quitter
    let formModified = false;
    const createForm = document.getElementById('createForm');
    
    if (createForm) {
        createForm.querySelectorAll('input, select, textarea').forEach(element => {
            element.addEventListener('change', () => formModified = true);
            element.addEventListener('input', () => formModified = true);
        });
        
        createForm.addEventListener('submit', () => formModified = false);
    }
    
    window.addEventListener('beforeunload', function(e) {
        if (formModified) {
            e.preventDefault();
            e.returnValue = 'Modifications non enregistrées. Quitter ?';
        }
    });
</script>
@endpush