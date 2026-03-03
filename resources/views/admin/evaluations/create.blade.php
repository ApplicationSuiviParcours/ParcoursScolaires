@extends('layouts.app')

@section('title', 'Nouvelle évaluation')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête avec animation -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 space-y-4 sm:space-y-0 animate__animated animate__fadeInDown">
            <div class="flex items-center space-x-3">
                <div class="p-3 bg-gradient-to-r from-blue-600 to-purple-600 rounded-xl shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-800">Nouvelle évaluation</h1>
            </div>
            <a href="{{ route('admin.evaluations.index') }}" 
               class="group inline-flex items-center px-6 py-3 bg-gray-100 text-gray-700 font-medium rounded-xl hover:bg-gray-200 hover:shadow-md transform hover:-translate-y-1 transition-all duration-300">
                <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Retour à la liste
            </a>
        </div>

        <!-- Messages d'erreur -->
        @if($errors->any())
            <div class="mb-6 animate__animated animate__fadeInDown">
                <div class="flex items-start p-4 bg-red-100 border-l-4 border-red-500 rounded-lg shadow-md" role="alert">
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Veuillez corriger les erreurs suivantes :</h3>
                        <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-red-100 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex h-8 w-8" onclick="this.parentElement.remove()">
                        <span class="sr-only">Fermer</span>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
            </div>
        @endif

        <!-- Formulaire -->
        <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl overflow-hidden border border-white/20 animate__animated animate__fadeInUp">
            <div class="p-6 sm:p-8">
                <form method="POST" action="{{ route('admin.evaluations.store') }}" class="space-y-6">
                    @csrf
                    
                    <!-- Classe et Matière -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Classe -->
                        <div class="space-y-2">
                            <label for="classe_id" class="block text-sm font-medium text-gray-700">
                                <span class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                    <span>Classe <span class="text-red-500">*</span></span>
                                </span>
                            </label>
                            <select class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 @error('classe_id') border-red-500 ring-2 ring-red-200 @enderror" 
                                    id="classe_id" name="classe_id" required>
                                <option value="">Sélectionner une classe</option>
                                @foreach($classes as $classe)
                                    <option value="{{ $classe->id }}" {{ old('classe_id') == $classe->id ? 'selected' : '' }} data-niveau="{{ $classe->niveau ?? '' }}">
                                        {{ $classe->nom }} {{ $classe->niveau ? '(' . $classe->niveau . ')' : '' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('classe_id')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Matière -->
                        <div class="space-y-2">
                            <label for="matiere_id" class="block text-sm font-medium text-gray-700">
                                <span class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                    <span>Matière <span class="text-red-500">*</span></span>
                                </span>
                            </label>
                            <select class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 @error('matiere_id') border-red-500 ring-2 ring-red-200 @enderror" 
                                    id="matiere_id" name="matiere_id" required>
                                <option value="">Sélectionner une matière</option>
                                @foreach($matieres as $matiere)
                                    <option value="{{ $matiere->id }}" {{ old('matiere_id') == $matiere->id ? 'selected' : '' }} data-code="{{ $matiere->code ?? '' }}">
                                        {{ $matiere->nom }} {{ $matiere->code ? '(' . $matiere->code . ')' : '' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('matiere_id')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Année scolaire et Type -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Année scolaire -->
                        <div class="space-y-2">
                            <label for="annee_scolaire_id" class="block text-sm font-medium text-gray-700">
                                <span class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span>Année scolaire <span class="text-red-500">*</span></span>
                                </span>
                            </label>
                            <select class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 @error('annee_scolaire_id') border-red-500 ring-2 ring-red-200 @enderror" 
                                    id="annee_scolaire_id" name="annee_scolaire_id" required>
                                <option value="">Sélectionner une année scolaire</option>
                                @foreach($anneeScolaires as $annee)
                                    <option value="{{ $annee->id }}" {{ old('annee_scolaire_id') == $annee->id ? 'selected' : ($annee->active ? 'selected' : '') }}>
                                        {{ $annee->nom }} {{ $annee->active ? '(Année en cours)' : '' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('annee_scolaire_id')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Type -->
                        <div class="space-y-2">
                            <label for="type" class="block text-sm font-medium text-gray-700">
                                <span class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l5 5a2 2 0 01.586 1.414V19a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z"></path>
                                    </svg>
                                    <span>Type d'évaluation <span class="text-red-500">*</span></span>
                                </span>
                            </label>
                            <select class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 @error('type') border-red-500 ring-2 ring-red-200 @enderror" 
                                    id="type" name="type" required>
                                <option value="">Sélectionner un type</option>
                                <option value="devoir" {{ old('type') == 'devoir' ? 'selected' : '' }}>📝 Devoir</option>
                                <option value="examen" {{ old('type') == 'examen' ? 'selected' : '' }}>📋 Examen</option>
                                <option value="test" {{ old('type') == 'test' ? 'selected' : '' }}>✏️ Test</option>
                                <option value="projet" {{ old('type') == 'projet' ? 'selected' : '' }}>🎯 Projet</option>
                                <option value="autre" {{ old('type') == 'autre' ? 'selected' : '' }}>🔖 Autre</option>
                            </select>
                            @error('type')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Nom et Date -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nom -->
                        <div class="space-y-2">
                            <label for="nom" class="block text-sm font-medium text-gray-700">
                                <span class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                                    </svg>
                                    <span>Nom de l'évaluation <span class="text-red-500">*</span></span>
                                </span>
                            </label>
                            <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 @error('nom') border-red-500 ring-2 ring-red-200 @enderror" 
                                   id="nom" name="nom" value="{{ old('nom') }}" 
                                   placeholder="Ex: Contrôle continu n°1" required>
                            @error('nom')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Date -->
                        <div class="space-y-2">
                            <label for="date_evaluation" class="block text-sm font-medium text-gray-700">
                                <span class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span>Date de l'évaluation <span class="text-red-500">*</span></span>
                                </span>
                            </label>
                            <input type="date" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 @error('date_evaluation') border-red-500 ring-2 ring-red-200 @enderror" 
                                   id="date_evaluation" name="date_evaluation" 
                                   value="{{ old('date_evaluation', now()->format('Y-m-d')) }}" 
                                   min="{{ now()->format('Y-m-d') }}" required>
                            @error('date_evaluation')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Coefficient et Barème -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Coefficient -->
                        <div class="space-y-2">
                            <label for="coefficient" class="block text-sm font-medium text-gray-700">
                                <span class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                                    </svg>
                                    <span>Coefficient <span class="text-red-500">*</span></span>
                                </span>
                            </label>
                            <div class="relative">
                                <input type="number" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 @error('coefficient') border-red-500 ring-2 ring-red-200 @enderror" 
                                       id="coefficient" name="coefficient" value="{{ old('coefficient', 1) }}" 
                                       min="1" max="10" step="0.5" required>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <span class="text-gray-500">pts</span>
                                </div>
                            </div>
                            @error('coefficient')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Barème -->
                        <div class="space-y-2">
                            <label for="bareme" class="block text-sm font-medium text-gray-700">
                                <span class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                    <span>Barème <span class="text-red-500">*</span></span>
                                </span>
                            </label>
                            <div class="relative">
                                <input type="number" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 @error('bareme') border-red-500 ring-2 ring-red-200 @enderror" 
                                       id="bareme" name="bareme" value="{{ old('bareme', 20) }}" 
                                       min="0" max="100" step="0.5" required>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <span class="text-gray-500">/20</span>
                                </div>
                            </div>
                            @error('bareme')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Période -->
                    <div class="space-y-2">
                        <label for="periode" class="block text-sm font-medium text-gray-700">
                            <span class="flex items-center space-x-2">
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l5 5a2 2 0 01.586 1.414V19a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z"></path>
                                </svg>
                                <span>Période</span>
                            </span>
                        </label>
                        <select class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 @error('periode') border-red-500 ring-2 ring-red-200 @enderror" 
                                id="periode" name="periode">
                            <option value="">Sélectionner une période (optionnel)</option>
                            <option value="Trimestre 1" {{ old('periode') == 'Trimestre 1' ? 'selected' : '' }}>Trimestre 1</option>
                            <option value="Trimestre 2" {{ old('periode') == 'Trimestre 2' ? 'selected' : '' }}>Trimestre 2</option>
                            <option value="Trimestre 3" {{ old('periode') == 'Trimestre 3' ? 'selected' : '' }}>Trimestre 3</option>
                            <option value="Semestre 1" {{ old('periode') == 'Semestre 1' ? 'selected' : '' }}>Semestre 1</option>
                            <option value="Semestre 2" {{ old('periode') == 'Semestre 2' ? 'selected' : '' }}>Semestre 2</option>
                            <option value="Annuelle" {{ old('periode') == 'Annuelle' ? 'selected' : '' }}>Annuelle</option>
                        </select>
                        @error('periode')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="space-y-2">
                        <label for="description" class="block text-sm font-medium text-gray-700">
                            <span class="flex items-center space-x-2">
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                                </svg>
                                <span>Description</span>
                            </span>
                        </label>
                        <textarea class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 @error('description') border-red-500 ring-2 ring-red-200 @enderror" 
                                  id="description" name="description" rows="4" 
                                  placeholder="Description détaillée de l'évaluation (objectifs, consignes, etc.)">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500">Maximum 500 caractères</p>
                    </div>

                    <!-- Boutons d'action -->
                    <div class="flex flex-wrap justify-end gap-3 pt-6 border-t border-gray-200">
                        <a href="{{ route('admin.evaluations.index') }}" 
                           class="inline-flex items-center px-6 py-3 bg-gray-100 text-gray-700 font-medium rounded-xl hover:bg-gray-200 hover:shadow-md transform hover:-translate-y-0.5 transition-all duration-300">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Annuler
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-medium rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Créer l'évaluation
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Aide contextuelle -->
        <div class="mt-6 bg-blue-50/80 backdrop-blur-sm rounded-xl p-4 border border-blue-200 animate__animated animate__fadeInUp animate__delay-1s">
            <div class="flex items-start space-x-3">
                <div class="flex-shrink-0">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <h4 class="text-sm font-medium text-blue-800">Informations importantes</h4>
                    <ul class="mt-2 text-sm text-blue-700 space-y-1 list-disc list-inside">
                        <li>Les champs marqués d'un <span class="text-red-500">*</span> sont obligatoires</li>
                        <li>Le coefficient doit être compris entre 1 et 10</li>
                        <li>Le barème est généralement sur 20, mais peut être personnalisé</li>
                        <li>Vous pourrez saisir les notes après la création de l'évaluation</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script pour la validation et l'autocomplétion -->
@push('scripts')
<script>
    // Validation du formulaire côté client
    document.querySelector('form').addEventListener('submit', function(e) {
        const coefficient = document.getElementById('coefficient').value;
        const bareme = document.getElementById('bareme').value;
        const date = new Date(document.getElementById('date_evaluation').value);
        const today = new Date();
        
        if (coefficient < 1 || coefficient > 10) {
            e.preventDefault();
            alert('Le coefficient doit être compris entre 1 et 10');
            return false;
        }
        
        if (bareme < 0 || bareme > 100) {
            e.preventDefault();
            alert('Le barème doit être compris entre 0 et 100');
            return false;
        }
        
        if (date < today.setHours(0,0,0,0)) {
            if (!confirm('La date est dans le passé. Voulez-vous continuer ?')) {
                e.preventDefault();
                return false;
            }
        }
    });

    // Auto-formatage du nom
    document.getElementById('nom').addEventListener('blur', function() {
        if (this.value) {
            this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1);
        }
    });
</script>
@endpush

<!-- Styles supplémentaires -->
@push('styles')
<style>
    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .animate__animated {
        animation-duration: 0.6s;
        animation-fill-mode: both;
    }
    
    .animate__fadeInDown {
        animation-name: fadeInDown;
    }
    
    .animate__fadeInUp {
        animation-name: fadeInUp;
    }
    
    .animate__delay-1s {
        animation-delay: 0.2s;
    }
</style>
@endpush
@endsection