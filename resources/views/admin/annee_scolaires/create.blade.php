@extends('layouts.app')

@section('title', 'Nouvelle année scolaire')

@section('header')
<div class="relative overflow-hidden bg-gradient-to-br from-emerald-600 via-emerald-700 to-teal-800 py-12">
    <!-- Éléments décoratifs animés -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-white rounded-full mix-blend-overlay filter blur-3xl animate-pulse"></div>
        <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-teal-300 rounded-full mix-blend-overlay filter blur-3xl animate-pulse delay-1000"></div>
    </div>
    
    <!-- Particules flottantes -->
    <div class="absolute inset-0 overflow-hidden">
        @for($i = 1; $i <= 4; $i++)
            <div class="absolute w-1 h-1 bg-white rounded-full opacity-30 animate-float-{{ $i }}"
                 style="left: {{ rand(0, 100) }}%; top: {{ rand(0, 100) }}%; animation-delay: {{ rand(0, 5) }}s;"></div>
        @endfor
    </div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div class="text-center md:text-left">
                <nav class="flex mb-4" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ route('admin.annee_scolaires.index') }}" class="inline-flex items-center text-sm font-medium text-emerald-200 hover:text-white transition-colors duration-300">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                                Années scolaires
                            </a>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-emerald-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="ml-1 text-sm font-medium text-white md:ml-2">Nouvelle année scolaire</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-3xl md:text-4xl font-bold text-white mb-2 animate-fade-in-up">
                    Nouvelle année scolaire
                </h1>
                <p class="text-emerald-200 text-base md:text-lg animate-fade-in-up animation-delay-200">
                    Ajouter une nouvelle année scolaire
                </p>
            </div>
        </div>
    </div>

    <!-- Vague décorative -->
    <div class="absolute bottom-0 left-0 right-0">
        <svg class="fill-current text-gray-50" viewBox="0 0 1440 120">
            <path d="M0,64L80,69.3C160,75,320,85,480,80C640,75,800,53,960,48C1120,43,1280,53,1360,58.7L1440,64L1440,120L1360,120C1280,120,1120,120,960,120C800,120,640,120,480,120C320,120,160,120,80,120L0,120Z"></path>
        </svg>
    </div>
</div>
@endsection

@section('content')
<div class="container mx-auto px-4 py-10 bg-gray-50">
    <div class="max-w-3xl mx-auto">
        <!-- Formulaire -->
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden">
            <div class="bg-gradient-to-r from-emerald-500 to-teal-600 px-8 py-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-14 h-14 bg-white/20 backdrop-blur-lg rounded-2xl flex items-center justify-center mr-5">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-white mb-1">Informations de l'année scolaire</h2>
                            <p class="text-emerald-100 text-sm">Tous les champs avec * sont obligatoires</p>
                        </div>
                    </div>
                    <!-- Indicateur de progression -->
                    <div class="text-right">
                        <span class="text-white/80 text-sm">Complétion</span>
                        <div class="w-32 h-2 bg-white/20 rounded-full mt-1">
                            <div class="bg-white h-2 rounded-full" style="width: 0%" id="progressBar"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-8">
                <form action="{{ route('admin.annee_scolaires.store') }}" method="POST" id="createForm">
                    @csrf

                    <div class="space-y-6">
                        <!-- Nom -->
                        <div class="group">
                            <label for="nom" class="block text-sm font-semibold text-gray-700 mb-2 group-hover:text-emerald-600 transition-colors duration-300">
                                Nom <span class="text-red-500">*</span>
                                <span class="text-xs text-gray-500 ml-2">(Ex: 2023-2024, 2024-2025)</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400 group-hover:text-emerald-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <input type="text" 
                                       name="nom" 
                                       id="nom" 
                                       value="{{ old('nom') }}"
                                       placeholder="Ex: 2024-2025"
                                       class="w-full pl-12 pr-4 py-3 rounded-xl border-2 border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-all duration-300 @error('nom') border-red-500 @enderror"
                                       required>
                            </div>
                            @error('nom')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Dates -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="group">
                                <label for="date_debut" class="block text-sm font-semibold text-gray-700 mb-2 group-hover:text-emerald-600 transition-colors duration-300">
                                    Date de début <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400 group-hover:text-emerald-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <input type="date" 
                                           name="date_debut" 
                                           id="date_debut" 
                                           value="{{ old('date_debut') }}"
                                           class="w-full pl-12 pr-4 py-3 rounded-xl border-2 border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-all duration-300 @error('date_debut') border-red-500 @enderror"
                                           required>
                                </div>
                                @error('date_debut')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="group">
                                <label for="date_fin" class="block text-sm font-semibold text-gray-700 mb-2 group-hover:text-emerald-600 transition-colors duration-300">
                                    Date de fin <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400 group-hover:text-emerald-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <input type="date" 
                                           name="date_fin" 
                                           id="date_fin" 
                                           value="{{ old('date_fin') }}"
                                           class="w-full pl-12 pr-4 py-3 rounded-xl border-2 border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-all duration-300 @error('date_fin') border-red-500 @enderror"
                                           required>
                                </div>
                                @error('date_fin')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Statut actif -->
                        <div class="group">
                            <label class="block text-sm font-semibold text-gray-700 mb-2 group-hover:text-emerald-600 transition-colors duration-300">
                                Statut
                            </label>
                            <div class="relative flex items-center space-x-4 p-4 bg-gray-50 rounded-xl">
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="active" value="1" {{ old('active') == '1' ? 'checked' : '' }} class="w-4 h-4 text-emerald-600 border-gray-300 focus:ring-emerald-500">
                                    <span class="ml-2 text-sm text-gray-700">Activer (définir comme année en cours)</span>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="active" value="0" {{ old('active') == '0' || old('active') === null ? 'checked' : '' }} class="w-4 h-4 text-emerald-600 border-gray-300 focus:ring-emerald-500">
                                    <span class="ml-2 text-sm text-gray-700">Créer comme inactive</span>
                                </label>
                            </div>
                            <p class="mt-2 text-xs text-gray-500 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Si vous activez cette année, toutes les autres années seront automatiquement désactivées.
                            </p>
                            @error('active')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Vérification de chevauchement -->
                        <div id="overlapCheck" class="mt-4 hidden">
                            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-xl">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-yellow-700">
                                            <span class="font-medium" id="overlapMessage">Attention! Cette période chevauche une année scolaire existante.</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Récapitulatif -->
                        <div class="mt-8 p-4 bg-gradient-to-r from-emerald-50 to-teal-50 rounded-2xl border border-emerald-200" id="recapSection" style="display: none;">
                            <h4 class="text-sm font-medium text-emerald-800 mb-3 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Récapitulatif
                            </h4>
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div>
                                    <span class="text-gray-500">Nom:</span>
                                    <p class="font-medium text-gray-800" id="recapNom">-</p>
                                </div>
                                <div>
                                    <span class="text-gray-500">Période:</span>
                                    <p class="font-medium text-gray-800" id="recapPeriode">-</p>
                                </div>
                                <div>
                                    <span class="text-gray-500">Durée:</span>
                                    <p class="font-medium text-gray-800" id="recapDuree">-</p>
                                </div>
                                <div>
                                    <span class="text-gray-500">Statut:</span>
                                    <p class="font-medium text-gray-800" id="recapStatut">-</p>
                                </div>
                            </div>
                        </div>

                        <!-- Boutons d'action -->
                        <div class="flex justify-end space-x-4 pt-6 border-t-2 border-gray-100">
                            <a href="{{ route('admin.annee_scolaires.index') }}" 
                               class="px-8 py-3 bg-white border-2 border-gray-300 rounded-xl text-gray-700 font-semibold hover:bg-gray-50 transition-all duration-300 transform hover:scale-105">
                                Annuler
                            </a>
                            <button type="submit" 
                                    class="px-8 py-3 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-semibold rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-xl">
                                <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                                </svg>
                                Créer l'année scolaire
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Barre de progression
    function updateProgressBar() {
        const requiredFields = document.querySelectorAll('[required]');
        const filledFields = Array.from(requiredFields).filter(field => field.value && field.value.trim() !== '');
        const percentage = Math.round((filledFields.length / requiredFields.length) * 100);
        
        document.getElementById('progressBar').style.width = percentage + '%';
    }

    // Mise à jour du récapitulatif
    function updateRecap() {
        const nom = document.getElementById('nom').value;
        const dateDebut = document.getElementById('date_debut').value;
        const dateFin = document.getElementById('date_fin').value;
        const active = document.querySelector('input[name="active"]:checked')?.value;
        const recapSection = document.getElementById('recapSection');

        if (nom && dateDebut && dateFin) {
            document.getElementById('recapNom').textContent = nom;
            
            const debut = new Date(dateDebut);
            const fin = new Date(dateFin);
            document.getElementById('recapPeriode').textContent = 
                debut.toLocaleDateString('fr-FR') + ' - ' + fin.toLocaleDateString('fr-FR');
            
            const diffTime = Math.abs(fin - debut);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            const diffMonths = Math.round(diffDays / 30.44);
            document.getElementById('recapDuree').textContent = diffDays + ' jours (' + diffMonths + ' mois)';
            
            document.getElementById('recapStatut').textContent = active === '1' ? 'Active' : 'Inactive';

            recapSection.style.display = 'block';
        } else {
            recapSection.style.display = 'none';
        }
    }

    // Vérification des chevauchements
    async function checkOverlap() {
        const dateDebut = document.getElementById('date_debut').value;
        const dateFin = document.getElementById('date_fin').value;
        const overlapCheck = document.getElementById('overlapCheck');
        const overlapMessage = document.getElementById('overlapMessage');

        if (dateDebut && dateFin) {
            try {
                const response = await fetch(`/admin/api/annee-scolaires/check-dates?date_debut=${dateDebut}&date_fin=${dateFin}`);
                const data = await response.json();
                
                if (data.overlap) {
                    overlapCheck.classList.remove('hidden');
                    overlapMessage.textContent = data.message;
                } else {
                    overlapCheck.classList.add('hidden');
                }
            } catch (error) {
                console.error('Erreur lors de la vérification:', error);
            }
        }
    }

    // Validation des dates
    document.getElementById('date_fin').addEventListener('change', function() {
        const debut = document.getElementById('date_debut').value;
        const fin = this.value;
        
        if (debut && fin && fin <= debut) {
            alert('La date de fin doit être postérieure à la date de début');
            this.value = '';
        }
        updateRecap();
        checkOverlap();
    });

    document.getElementById('date_debut').addEventListener('change', function() {
        updateRecap();
        checkOverlap();
    });

    document.getElementById('nom').addEventListener('input', updateRecap);
    
    document.querySelectorAll('input[name="active"]').forEach(radio => {
        radio.addEventListener('change', updateRecap);
    });

    // Ajouter les écouteurs pour la barre de progression
    document.querySelectorAll('[required]').forEach(field => {
        field.addEventListener('change', updateProgressBar);
        field.addEventListener('input', updateProgressBar);
    });

    // Confirmation avant de quitter si le formulaire est modifié
    let formModified = false;
    
    document.querySelectorAll('input, select').forEach(element => {
        element.addEventListener('change', () => formModified = true);
        element.addEventListener('input', () => {
            if (element.tagName === 'INPUT') {
                formModified = true;
            }
        });
    });
    
    window.addEventListener('beforeunload', function(e) {
        if (formModified) {
            e.preventDefault();
            e.returnValue = 'Vous avez des modifications non enregistrées. Êtes-vous sûr de vouloir quitter ?';
        }
    });
    
    document.getElementById('createForm').addEventListener('submit', function() {
        formModified = false;
    });
</script>
@endpush