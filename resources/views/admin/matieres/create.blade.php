@extends('layouts.app')

@section('title', 'Nouvelle matière')

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
                            <a href="{{ route('admin.matieres.index') }}" class="inline-flex items-center text-sm font-medium text-emerald-200 hover:text-white transition-colors duration-300">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                                Matières
                            </a>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-emerald-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="ml-1 text-sm font-medium text-white md:ml-2">Nouvelle matière</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-3xl md:text-4xl font-bold text-white mb-2 animate-fade-in-up">
                    Nouvelle matière
                </h1>
                <p class="text-emerald-200 text-base md:text-lg animate-fade-in-up animation-delay-200">
                    Ajouter une nouvelle matière à l'établissement
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-white mb-1">Informations de la matière</h2>
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
                <form action="{{ route('admin.matieres.store') }}" method="POST" id="createForm">
                    @csrf

                    <div class="space-y-6">
                        <!-- Code -->
                        <div class="group">
                            <label for="code" class="block text-sm font-semibold text-gray-700 mb-2 group-hover:text-emerald-600 transition-colors duration-300">
                                Code <span class="text-red-500">*</span>
                                <span class="text-xs text-gray-500 ml-2">(Lettres majuscules et chiffres uniquement)</span>
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
                                       class="w-full pl-12 pr-4 py-3 rounded-xl border-2 border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-all duration-300 @error('code') border-red-500 @enderror uppercase"
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
                            <label for="nom" class="block text-sm font-semibold text-gray-700 mb-2 group-hover:text-emerald-600 transition-colors duration-300">
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
                                       class="w-full pl-12 pr-4 py-3 rounded-xl border-2 border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-all duration-300 @error('nom') border-red-500 @enderror"
                                       required
                                       maxlength="255">
                            </div>
                            @error('nom')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Coefficient -->
                        <div class="group">
                            <label for="coefficient" class="block text-sm font-semibold text-gray-700 mb-2 group-hover:text-emerald-600 transition-colors duration-300">
                                Coefficient <span class="text-red-500">*</span>
                                <span class="text-xs text-gray-500 ml-2">(entre 1 et 10)</span>
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
                                       class="w-full pl-12 pr-4 py-3 rounded-xl border-2 border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-all duration-300 @error('coefficient') border-red-500 @enderror"
                                       required>
                            </div>
                            <div class="mt-2 flex items-center space-x-2">
                                <span class="text-xs text-gray-500">Valeur recommandée :</span>
                                <button type="button" onclick="setCoefficient(1)" class="px-2 py-1 bg-gray-100 rounded-lg text-xs hover:bg-gray-200">1</button>
                                <button type="button" onclick="setCoefficient(2)" class="px-2 py-1 bg-gray-100 rounded-lg text-xs hover:bg-gray-200">2</button>
                                <button type="button" onclick="setCoefficient(3)" class="px-2 py-1 bg-gray-100 rounded-lg text-xs hover:bg-gray-200">3</button>
                                <button type="button" onclick="setCoefficient(4)" class="px-2 py-1 bg-gray-100 rounded-lg text-xs hover:bg-gray-200">4</button>
                                <button type="button" onclick="setCoefficient(5)" class="px-2 py-1 bg-gray-100 rounded-lg text-xs hover:bg-gray-200">5</button>
                            </div>
                            @error('coefficient')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="group">
                            <label for="description" class="block text-sm font-semibold text-gray-700 mb-2 group-hover:text-emerald-600 transition-colors duration-300">
                                Description
                                <span class="text-xs text-gray-500 ml-2">(optionnel)</span>
                            </label>
                            <div class="relative">
                                <div class="absolute top-4 left-4 pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400 group-hover:text-emerald-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                                    </svg>
                                </div>
                                <textarea name="description" 
                                          id="description" 
                                          rows="4"
                                          placeholder="Description de la matière, objectifs pédagogiques, etc..."
                                          class="w-full pl-12 pr-4 py-3 rounded-xl border-2 border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-all duration-300 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                            </div>
                            <p class="mt-2 text-xs text-gray-500 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Maximum 1000 caractères
                            </p>
                            @error('description')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Aperçu -->
                        <div class="mt-8 p-4 bg-gradient-to-r from-emerald-50 to-teal-50 rounded-2xl border border-emerald-200">
                            <h4 class="text-sm font-medium text-emerald-800 mb-3 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                Aperçu de la matière
                            </h4>
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0 w-16 h-16 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center text-white font-bold text-2xl shadow-lg" id="previewInitiales">
                                    ?
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center space-x-2">
                                        <span class="text-xs font-medium text-emerald-700 bg-emerald-100 px-2 py-1 rounded-lg" id="previewCode"></span>
                                        <span class="text-xs font-medium text-teal-700 bg-teal-100 px-2 py-1 rounded-lg" id="previewCoefficient">Coef. 1</span>
                                    </div>
                                    <p class="text-lg font-bold text-gray-800 mt-1" id="previewNom">Nom de la matière</p>
                                    <p class="text-sm text-gray-600 line-clamp-2" id="previewDescription">Aperçu de la description...</p>
                                </div>
                            </div>
                        </div>

                        <!-- Boutons d'action -->
                        <div class="flex justify-end space-x-4 pt-6 border-t-2 border-gray-100">
                            <a href="{{ route('admin.matieres.index') }}" 
                               class="px-8 py-3 bg-white border-2 border-gray-300 rounded-xl text-gray-700 font-semibold hover:bg-gray-50 transition-all duration-300 transform hover:scale-105">
                                Annuler
                            </a>
                            <button type="submit" 
                                    class="px-8 py-3 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-semibold rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-xl">
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
    @keyframes float-1 {
        0%, 100% { transform: translate(0, 0); }
        50% { transform: translate(10px, -10px); }
    }
    
    @keyframes float-2 {
        0%, 100% { transform: translate(0, 0); }
        50% { transform: translate(-15px, 5px); }
    }
    
    @keyframes float-3 {
        0%, 100% { transform: translate(0, 0) scale(1); }
        50% { transform: translate(8px, 8px) scale(1.1); }
    }
    
    @keyframes float-4 {
        0%, 100% { transform: translate(0, 0); }
        50% { transform: translate(-12px, -8px); }
    }
    
    .animate-float-1 { animation: float-1 8s ease-in-out infinite; }
    .animate-float-2 { animation: float-2 10s ease-in-out infinite; }
    .animate-float-3 { animation: float-3 12s ease-in-out infinite; }
    .animate-float-4 { animation: float-4 9s ease-in-out infinite; }
    
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
    
    @keyframes fadeInRight {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
    
    .animate-fade-in-up {
        animation: fadeInUp 0.8s ease-out forwards;
    }
    
    .animate-fade-in-right {
        animation: fadeInRight 0.8s ease-out forwards;
    }
    
    .animation-delay-200 {
        animation-delay: 200ms;
        opacity: 0;
    }
    
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endpush

@push('scripts')
<script>
    // Confirmation avant de quitter si le formulaire est modifié
    let formModified = false;
    
    document.querySelectorAll('input, select, textarea').forEach(element => {
        element.addEventListener('change', () => formModified = true);
        element.addEventListener('keyup', () => {
            if (element.tagName === 'INPUT' || element.tagName === 'TEXTAREA') {
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
    
    document.querySelector('form').addEventListener('submit', function() {
        formModified = false;
    });

    // Barre de progression
    function updateProgressBar() {
        const requiredFields = document.querySelectorAll('[required]');
        const filledFields = Array.from(requiredFields).filter(field => field.value && field.value.trim() !== '');
        const percentage = Math.round((filledFields.length / requiredFields.length) * 100);
        
        document.getElementById('progressBar').style.width = percentage + '%';
    }

    document.querySelectorAll('[required]').forEach(field => {
        field.addEventListener('input', updateProgressBar);
        field.addEventListener('change', updateProgressBar);
    });

    // Gestion du code (majuscules automatiques)
    const codeInput = document.getElementById('code');
    const codeLength = document.getElementById('codeLength');
    const codeStatus = document.getElementById('codeStatus');

    codeInput.addEventListener('input', function() {
        this.value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
        codeLength.textContent = this.value.length + '/10';
        
        // Vérifier l'unicité du code (simulé)
        if (this.value.length >= 2) {
            codeStatus.innerHTML = '<span class="text-green-600"><svg class="w-3 h-3 mr-1 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Code disponible</span>';
        } else {
            codeStatus.innerHTML = '';
        }
    });

    // Prévisualisation en temps réel
    function updatePreview() {
        const nom = document.getElementById('nom').value;
        const code = document.getElementById('code').value;
        const coefficient = document.getElementById('coefficient').value;
        const description = document.getElementById('description').value;

        document.getElementById('previewNom').textContent = nom || 'Nom de la matière';
        document.getElementById('previewCode').textContent = code || 'CODE';
        document.getElementById('previewCoefficient').textContent = `Coef. ${coefficient || 1}`;
        document.getElementById('previewDescription').textContent = description || 'Aperçu de la description...';

        // Initiales
        const initiales = nom ? nom.split(' ').map(word => word[0]).join('').substring(0, 2).toUpperCase() : '?';
        document.getElementById('previewInitiales').textContent = initiales;
    }

    document.getElementById('nom').addEventListener('input', updatePreview);
    document.getElementById('code').addEventListener('input', updatePreview);
    document.getElementById('coefficient').addEventListener('input', updatePreview);
    document.getElementById('description').addEventListener('input', updatePreview);

    // Set coefficient
    function setCoefficient(value) {
        document.getElementById('coefficient').value = value;
        updatePreview();
        updateProgressBar();
    }

    // Initial preview
    updatePreview();
</script>
@endpush