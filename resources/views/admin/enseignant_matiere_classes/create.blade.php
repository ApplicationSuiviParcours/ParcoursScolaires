@extends('layouts.app')

@section('title', 'Nouvelle affectation')

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
                            <a href="{{ route('admin.enseignant_matiere_classes.index') }}" class="inline-flex items-center text-sm font-medium text-emerald-200 hover:text-white transition-colors duration-300">
                                <svg class="w-4 h-4 mr-1 md:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                                <span class="hidden sm:inline">Affectations</span>
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
                    Nouvelle affectation
                </h1>
                <p class="text-emerald-200 text-sm md:text-base animate-fade-in-up animation-delay-200">
                    Affecter un enseignant à une matière et une classe
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
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
                <form action="{{ route('admin.enseignant_matiere_classes.store') }}" method="POST" id="createForm">
                    @csrf

                    <div class="space-y-5 md:space-y-6">
                        <!-- Enseignant -->
                        <div class="group">
                            <label for="enseignant_id" class="block text-xs md:text-sm font-semibold text-gray-700 mb-1 md:mb-2 group-hover:text-emerald-600 transition-colors duration-300">
                                Enseignant <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400 group-hover:text-emerald-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <select name="enseignant_id" 
                                        id="enseignant_id" 
                                        class="w-full pl-12 pr-10 py-2.5 md:py-3 rounded-xl border-2 border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-all duration-300 @error('enseignant_id') border-red-500 @enderror appearance-none bg-white text-sm md:text-base"
                                        required>
                                    <option value="">Sélectionnez...</option>
                                    @foreach($enseignants as $enseignant)
                                        <option value="{{ $enseignant->id }}" {{ old('enseignant_id') == $enseignant->id ? 'selected' : '' }}>
                                            {{ $enseignant->nom }} {{ $enseignant->prenom }} ({{ $enseignant->specialite ?? 'Général' }})
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                            @error('enseignant_id')
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
                                            {{ $matiere->nom }} ({{ $matiere->code }})
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

                        <!-- Classe -->
                        <div class="group">
                            <label for="classe_id" class="block text-xs md:text-sm font-semibold text-gray-700 mb-1 md:mb-2 group-hover:text-emerald-600 transition-colors duration-300">
                                Classe <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400 group-hover:text-emerald-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"></path>
                                    </svg>
                                </div>
                                <select name="classe_id" 
                                        id="classe_id" 
                                        class="w-full pl-12 pr-10 py-2.5 md:py-3 rounded-xl border-2 border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-all duration-300 @error('classe_id') border-red-500 @enderror appearance-none bg-white text-sm md:text-base"
                                        required>
                                    <option value="">Sélectionnez...</option>
                                    @foreach($classes as $classe)
                                        <option value="{{ $classe->id }}" {{ old('classe_id') == $classe->id ? 'selected' : '' }}>
                                            {{ $classe->nom }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                            @error('classe_id')
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

                        <!-- Vérification de doublon -->
                        <div id="duplicateCheck" class="mt-4 hidden">
                            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-xl">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-yellow-700">
                                            <span class="font-medium" id="duplicateMessage">Attention!</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Récapitulatif -->
                        <div class="mt-6 p-4 bg-gradient-to-r from-emerald-50 to-teal-50 rounded-xl border border-emerald-200" id="recapSection" style="display: none;">
                            <h4 class="text-xs md:text-sm font-medium text-emerald-800 mb-3 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Récapitulatif
                            </h4>
                            <div class="grid grid-cols-2 gap-3 md:gap-4 text-xs md:text-sm">
                                <div>
                                    <span class="text-gray-500">Enseignant:</span>
                                    <p class="font-medium text-gray-800 truncate" id="recapEnseignant">-</p>
                                </div>
                                <div>
                                    <span class="text-gray-500">Matière:</span>
                                    <p class="font-medium text-gray-800 truncate" id="recapMatiere">-</p>
                                </div>
                                <div>
                                    <span class="text-gray-500">Classe:</span>
                                    <p class="font-medium text-gray-800 truncate" id="recapClasse">-</p>
                                </div>
                                <div>
                                    <span class="text-gray-500">Année:</span>
                                    <p class="font-medium text-gray-800 truncate" id="recapAnnee">-</p>
                                </div>
                            </div>
                        </div>

                        <!-- Boutons d'action -->
                        <div class="flex flex-col-reverse sm:flex-row justify-end gap-3 sm:gap-4 pt-6 border-t-2 border-gray-100">
                            <a href="{{ route('admin.enseignant_matiere_classes.index') }}" 
                               class="w-full sm:w-auto text-center px-6 py-2.5 md:py-3 bg-white border-2 border-gray-300 rounded-xl text-gray-700 font-semibold hover:bg-gray-50 transition-all duration-300 transform hover:scale-105 text-sm md:text-base">
                                Annuler
                            </a>
                            <button type="submit" 
                                    class="w-full sm:w-auto px-6 py-2.5 md:py-3 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-semibold rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-xl text-sm md:text-base">
                                <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                                </svg>
                                Créer
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

    // Mise à jour du récapitulatif
    function updateRecap() {
        const enseignant = document.getElementById('enseignant_id');
        const matiere = document.getElementById('matiere_id');
        const classe = document.getElementById('classe_id');
        const annee = document.getElementById('annee_scolaire_id');
        const recapSection = document.getElementById('recapSection');

        if (enseignant && matiere && classe && annee && enseignant.value && matiere.value && classe.value && annee.value) {
            const enseignantText = enseignant.options[enseignant.selectedIndex]?.text || '-';
            const matiereText = matiere.options[matiere.selectedIndex]?.text || '-';
            const classeText = classe.options[classe.selectedIndex]?.text || '-';
            const anneeText = annee.options[annee.selectedIndex]?.text || '-';

            document.getElementById('recapEnseignant').textContent = enseignantText;
            document.getElementById('recapMatiere').textContent = matiereText;
            document.getElementById('recapClasse').textContent = classeText;
            document.getElementById('recapAnnee').textContent = anneeText;

            recapSection.style.display = 'block';
        } else if (recapSection) {
            recapSection.style.display = 'none';
        }
    }

    // Vérification des doublons
    async function checkDuplicate() {
        const enseignant = document.getElementById('enseignant_id').value;
        const matiere = document.getElementById('matiere_id').value;
        const classe = document.getElementById('classe_id').value;
        const annee = document.getElementById('annee_scolaire_id').value;
        const duplicateCheck = document.getElementById('duplicateCheck');
        const duplicateMessage = document.getElementById('duplicateMessage');

        if (enseignant && matiere && classe && annee) {
            // Remplacez par votre vrai endpoint API
            // try {
            //     const response = await fetch(`/admin/api/enseignant-matiere-classes/check?enseignant_id=${enseignant}&matiere_id=${matiere}&classe_id=${classe}&annee_scolaire_id=${annee}`);
            //     const data = await response.json();
            //     if (data.exists) { ... }
            // } catch (error) { console.error(error); }
        }
    }

    // Ajouter les écouteurs d'événements
    ['enseignant_id', 'matiere_id', 'classe_id', 'annee_scolaire_id'].forEach(id => {
        const element = document.getElementById(id);
        if (element) {
            element.addEventListener('change', function() {
                updateProgressBar();
                updateRecap();
                checkDuplicate();
            });
        }
    });

    // Confirmation avant de quitter
    let formModified = false;
    const createForm = document.getElementById('createForm');
    
    if (createForm) {
        createForm.querySelectorAll('input, select, textarea').forEach(element => {
            element.addEventListener('change', () => formModified = true);
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