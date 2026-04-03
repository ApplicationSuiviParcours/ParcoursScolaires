@extends('layouts.app')

@section('title', 'Nouvelle matière')

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
                            <a href="{{ route('admin.matieres.index') }}" class="inline-flex items-center text-sm font-medium text-emerald-200 hover:text-white transition-colors duration-300">
                                <svg class="w-4 h-4 mr-1 md:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                                <span class="hidden sm:inline">Matières</span>
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
                    Nouvelle matière
                </h1>
                <p class="text-emerald-200 text-sm md:text-base animate-fade-in-up animation-delay-200">
                    Ajouter une nouvelle matière à l'établissement
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
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="flex items-center">
                        <div class="w-12 h-12 md:w-14 md:h-14 bg-white/20 backdrop-blur-lg rounded-xl md:rounded-2xl flex items-center justify-center mr-4 md:mr-5 flex-shrink-0">
                            <svg class="w-6 h-6 md:w-7 md:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl md:text-2xl font-bold text-white mb-1">Informations de la matière</h2>
                            <p class="text-emerald-100 text-xs md:text-sm">Tous les champs avec * sont obligatoires</p>
                        </div>
                    </div>
                    <!-- Indicateur de progression (Masqué sur mobile) -->
                    <div class="hidden sm:block text-right">
                        <span class="text-white/80 text-xs">Complétion</span>
                        <div class="w-32 h-2 bg-white/20 rounded-full mt-1">
                            <div class="bg-white h-2 rounded-full transition-all duration-300" style="width: 0%" id="progressBar"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-4 md:p-8">
                <form action="{{ route('admin.matieres.store') }}" method="POST" id="createForm">
                    @csrf

                    <div class="space-y-5 md:space-y-6">
                        <!-- Code -->
                        <div class="group">
                            <label for="code" class="block text-xs md:text-sm font-semibold text-gray-700 mb-2 group-hover:text-emerald-600 transition-colors duration-300">
                                Code <span class="text-red-500">*</span>
                                <span class="text-xs text-gray-500 ml-1 hidden sm:inline">(Lettres majuscules et chiffres uniquement)</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400 group-hover:text-emerald-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                                    </svg>
                                </div>
                                <input type="text" 
                                       name="code" 
                                       id="code" 
                                       value="{{ old('code') }}"
                                       placeholder="Ex: MATH, FR, ANG..."
                                       class="w-full pl-12 pr-4 py-2.5 md:py-3 rounded-xl border-2 border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-all duration-300 @error('code') border-red-500 @enderror uppercase text-sm md:text-base"
                                       required
                                       maxlength="10">
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center">
                                    <span class="text-xs text-gray-400" id="codeLength">0/10</span>
                                </div>
                            </div>
                            <div class="mt-1 flex items-center text-xs text-gray-500">
                                <span id="codeStatus" class="flex items-center"></span>
                            </div>
                            @error('code')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nom -->
                        <div class="group">
                            <label for="nom" class="block text-xs md:text-sm font-semibold text-gray-700 mb-2 group-hover:text-emerald-600 transition-colors duration-300">
                                Nom de la matière <span class="text-red-500">*</span>
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
                                       placeholder="Ex: Mathématiques, Français, Anglais..."
                                       class="w-full pl-12 pr-4 py-2.5 md:py-3 rounded-xl border-2 border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-all duration-300 @error('nom') border-red-500 @enderror text-sm md:text-base"
                                       required
                                       maxlength="255">
                            </div>
                            @error('nom')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Coefficient -->
                        <div class="group">
                            <label for="coefficient" class="block text-xs md:text-sm font-semibold text-gray-700 mb-2 group-hover:text-emerald-600 transition-colors duration-300">
                                Coefficient <span class="text-red-500">*</span>
                                <span class="text-xs text-gray-500 ml-1">(entre 1 et 10)</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400 group-hover:text-emerald-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                </div>
                                <input type="number" 
                                       name="coefficient" 
                                       id="coefficient" 
                                       value="{{ old('coefficient', 1) }}"
                                       min="1"
                                       max="10"
                                       step="1"
                                       class="w-full pl-12 pr-4 py-2.5 md:py-3 rounded-xl border-2 border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-all duration-300 @error('coefficient') border-red-500 @enderror text-sm md:text-base"
                                       required>
                            </div>
                            <div class="mt-2 flex flex-wrap items-center gap-2">
                                <span class="text-xs text-gray-500">Valeur recommandée :</span>
                                <div class="flex flex-wrap gap-1">
                                    <button type="button" onclick="setCoefficient(1)" class="px-2.5 py-1 bg-gray-100 rounded-lg text-xs hover:bg-gray-200">1</button>
                                    <button type="button" onclick="setCoefficient(2)" class="px-2.5 py-1 bg-gray-100 rounded-lg text-xs hover:bg-gray-200">2</button>
                                    <button type="button" onclick="setCoefficient(3)" class="px-2.5 py-1 bg-gray-100 rounded-lg text-xs hover:bg-gray-200">3</button>
                                    <button type="button" onclick="setCoefficient(4)" class="px-2.5 py-1 bg-gray-100 rounded-lg text-xs hover:bg-gray-200">4</button>
                                    <button type="button" onclick="setCoefficient(5)" class="px-2.5 py-1 bg-gray-100 rounded-lg text-xs hover:bg-gray-200">5</button>
                                </div>
                            </div>
                            @error('coefficient')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="group">
                            <label for="description" class="block text-xs md:text-sm font-semibold text-gray-700 mb-2 group-hover:text-emerald-600 transition-colors duration-300">
                                Description
                                <span class="text-xs text-gray-500 ml-1">(optionnel)</span>
                            </label>
                            <div class="relative">
                                <div class="absolute top-3 md:top-4 left-4 pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400 group-hover:text-emerald-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                                    </svg>
                                </div>
                                <textarea name="description" 
                                          id="description" 
                                          rows="4"
                                          placeholder="Description de la matière, objectifs pédagogiques, etc..."
                                          class="w-full pl-12 pr-4 py-2.5 md:py-3 rounded-xl border-2 border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-all duration-300 @error('description') border-red-500 @enderror text-sm md:text-base">{{ old('description') }}</textarea>
                            </div>
                            <p class="mt-2 text-xs text-gray-500 flex items-center">
                                <svg class="w-4 h-4 mr-1 hidden sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Maximum 1000 caractères
                            </p>
                            @error('description')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Aperçu -->
                        <div class="mt-6 md:mt-8 p-4 bg-gradient-to-r from-emerald-50 to-teal-50 rounded-xl md:rounded-2xl border border-emerald-200">
                            <h4 class="text-xs md:text-sm font-medium text-emerald-800 mb-3 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                Aperçu de la matière
                            </h4>
                            <div class="flex flex-col sm:flex-row items-center text-center sm:text-left space-y-3 sm:space-y-0 sm:space-x-4">
                                <div class="flex-shrink-0 w-14 h-14 md:w-16 md:h-16 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center text-white font-bold text-xl md:text-2xl shadow-lg" id="previewInitiales">
                                    ?
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-center sm:justify-start space-x-2">
                                        <span class="text-xs font-medium text-emerald-700 bg-emerald-100 px-2 py-0.5 rounded-lg" id="previewCode">CODE</span>
                                        <span class="text-xs font-medium text-teal-700 bg-teal-100 px-2 py-0.5 rounded-lg" id="previewCoefficient">Coef. 1</span>
                                    </div>
                                    <p class="text-base md:text-lg font-bold text-gray-800 mt-1 truncate" id="previewNom">Nom de la matière</p>
                                    <p class="text-xs md:text-sm text-gray-600 line-clamp-2" id="previewDescription">Aperçu de la description...</p>
                                </div>
                            </div>
                        </div>

                        <!-- Boutons d'action -->
                        <div class="flex flex-col-reverse sm:flex-row justify-end gap-3 sm:gap-4 pt-6 border-t-2 border-gray-100">
                            <a href="{{ route('admin.matieres.index') }}" 
                               class="w-full sm:w-auto px-6 py-2.5 md:py-3 bg-white border-2 border-gray-300 rounded-xl text-gray-700 font-semibold hover:bg-gray-50 transition-all duration-300 transform hover:scale-105 text-center text-sm md:text-base">
                                Annuler
                            </a>
                            <button type="submit" 
                                    class="w-full sm:w-auto px-6 py-2.5 md:py-3 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-semibold rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-xl text-sm md:text-base">
                                <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                                </svg>
                                Créer la matière
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
    /* Animations */
    @keyframes float-1 { 0%, 100% { transform: translate(0, 0); } 50% { transform: translate(10px, -10px); } }
    @keyframes float-2 { 0%, 100% { transform: translate(0, 0); } 50% { transform: translate(-15px, 5px); } }
    @keyframes float-3 { 0%, 100% { transform: translate(0, 0) scale(1); } 50% { transform: translate(8px, 8px) scale(1.1); } }
    @keyframes float-4 { 0%, 100% { transform: translate(0, 0); } 50% { transform: translate(-12px, -8px); } }
    
    .animate-float-1 { animation: float-1 8s ease-in-out infinite; }
    .animate-float-2 { animation: float-2 10s ease-in-out infinite; }
    .animate-float-3 { animation: float-3 12s ease-in-out infinite; }
    .animate-float-4 { animation: float-4 9s ease-in-out infinite; }
    
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes fadeInRight { from { opacity: 0; transform: translateX(-20px); } to { opacity: 1; transform: translateX(0); } }
    
    .animate-fade-in-up { animation: fadeInUp 0.8s ease-out forwards; }
    .animate-fade-in-right { animation: fadeInRight 0.8s ease-out forwards; }
    .animation-delay-200 { animation-delay: 200ms; opacity: 0; }
    
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    /* Désactive le zoom sur les inputs iOS */
    input[type="text"], input[type="number"], textarea, select {
        font-size: 16px;
    }
</style>
@endpush

@push('scripts')
<script>
    // Confirmation avant de quitter si le formulaire est modifié
    let formModified = false;
    
    const createForm = document.getElementById('createForm');
    
    if (createForm) {
        createForm.querySelectorAll('input, select, textarea').forEach(element => {
            element.addEventListener('change', () => formModified = true);
            element.addEventListener('keyup', () => {
                if (element.tagName === 'INPUT' || element.tagName === 'TEXTAREA') {
                    formModified = true;
                }
            });
        });
    }
    
    window.addEventListener('beforeunload', function(e) {
        if (formModified) {
            e.preventDefault();
            e.returnValue = 'Vous avez des modifications non enregistrées. Êtes-vous sûr de vouloir quitter ?';
        }
    });
    
    if (createForm) {
        createForm.addEventListener('submit', function() {
            formModified = false;
        });
    }

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

    document.querySelectorAll('#createForm [required]').forEach(field => {
        field.addEventListener('input', updateProgressBar);
        field.addEventListener('change', updateProgressBar);
    });

    // Gestion du code (majuscules automatiques)
    const codeInput = document.getElementById('code');
    const codeLength = document.getElementById('codeLength');
    const codeStatus = document.getElementById('codeStatus');

    if (codeInput) {
        codeInput.addEventListener('input', function() {
            this.value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
            if (codeLength) codeLength.textContent = this.value.length + '/10';
            
            // Vérifier l'unicité du code (simulé)
            if (this.value.length >= 2) {
                if (codeStatus) codeStatus.innerHTML = '<span class="text-green-600"><svg class="w-3 h-3 mr-1 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Code disponible</span>';
            } else {
                if (codeStatus) codeStatus.innerHTML = '';
            }
            updatePreview();
            updateProgressBar();
        });
    }

    // Prévisualisation en temps réel
    function updatePreview() {
        const nomEl = document.getElementById('nom');
        const codeEl = document.getElementById('code');
        const coefEl = document.getElementById('coefficient');
        const descEl = document.getElementById('description');

        const nom = nomEl ? nomEl.value : '';
        const code = codeEl ? codeEl.value : '';
        const coefficient = coefEl ? coefEl.value : 1;
        const description = descEl ? descEl.value : '';

        const previewNom = document.getElementById('previewNom');
        const previewCode = document.getElementById('previewCode');
        const previewCoefficient = document.getElementById('previewCoefficient');
        const previewDescription = document.getElementById('previewDescription');
        const previewInitiales = document.getElementById('previewInitiales');

        if (previewNom) previewNom.textContent = nom || 'Nom de la matière';
        if (previewCode) previewCode.textContent = code || 'CODE';
        if (previewCoefficient) previewCoefficient.textContent = `Coef. ${coefficient || 1}`;
        if (previewDescription) previewDescription.textContent = description || 'Aperçu de la description...';

        // Initiales
        const initiales = nom ? nom.split(' ').map(word => word[0]).join('').substring(0, 2).toUpperCase() : '?';
        if (previewInitiales) previewInitiales.textContent = initiales;
    }

    const nomInput = document.getElementById('nom');
    const coefInput = document.getElementById('coefficient');
    const descInput = document.getElementById('description');

    if (nomInput) nomInput.addEventListener('input', updatePreview);
    if (coefInput) coefInput.addEventListener('input', updatePreview);
    if (descInput) descInput.addEventListener('input', updatePreview);

    // Set coefficient
    window.setCoefficient = function(value) {
        const coefInput = document.getElementById('coefficient');
        if (coefInput) {
            coefInput.value = value;
            updatePreview();
            updateProgressBar();
        }
    }

    // Initialisation
    updatePreview();
    updateProgressBar();
</script>
@endpush