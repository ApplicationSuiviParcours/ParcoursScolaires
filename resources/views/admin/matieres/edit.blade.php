@extends('layouts.app')

@section('title', 'Modifier la matière')

@section('header')
<div class="relative overflow-hidden bg-gradient-to-br from-amber-600 via-amber-700 to-orange-800 py-8 md:py-12">
    <!-- Éléments décoratifs animés -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-white rounded-full mix-blend-overlay filter blur-3xl animate-pulse"></div>
        <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-orange-300 rounded-full mix-blend-overlay filter blur-3xl animate-pulse delay-1000"></div>
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
            <div class="text-center md:text-left mb-6 md:mb-0">
                <nav class="flex mb-4 justify-center md:justify-start" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3 flex-wrap">
                        <li class="inline-flex items-center">
                            <a href="{{ route('admin.matieres.index') }}" class="inline-flex items-center text-sm font-medium text-amber-200 hover:text-white transition-colors duration-300">
                                <svg class="w-4 h-4 mr-1 md:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                                <span class="hidden sm:inline">Matières</span>
                                <span class="sm:hidden">Liste</span>
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-5 h-5 md:w-6 md:h-6 text-amber-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <a href="{{ route('admin.matieres.show', $matiere) }}" class="ml-1 text-sm font-medium text-amber-200 hover:text-white md:ml-2 transition-colors duration-300 truncate max-w-[100px] md:max-w-none">
                                    {{ $matiere->nom }}
                                </a>
                            </div>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 md:w-6 md:h-6 text-amber-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="ml-1 text-sm font-medium text-white md:ml-2">Modification</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-white mb-2 animate-fade-in-up">
                    Modifier la matière
                </h1>
                <p class="text-amber-200 text-sm md:text-base animate-fade-in-up animation-delay-200">
                    {{ $matiere->code }} • {{ $matiere->nom }}
                </p>
            </div>
            <div class="flex flex-col sm:flex-row justify-center md:justify-end space-y-3 sm:space-y-0 sm:space-x-3 animate-fade-in-right">
                <a href="{{ route('admin.matieres.show', $matiere) }}" 
                   class="group relative inline-flex items-center justify-center px-4 py-2.5 md:px-5 bg-blue-500 hover:bg-blue-600 text-white font-medium rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-xl overflow-hidden text-sm">
                    <span class="absolute inset-0 bg-white opacity-0 group-hover:opacity-20 transition-opacity duration-300"></span>
                    <svg class="w-5 h-5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    <span class="hidden sm:inline">Voir détails</span>
                </a>
                <a href="{{ route('admin.matieres.index') }}" 
                   class="group relative inline-flex items-center justify-center px-4 py-2.5 md:px-5 bg-white/10 backdrop-blur-lg hover:bg-white/20 text-white font-medium rounded-xl transition-all duration-300 transform hover:scale-105 border border-white/20 text-sm">
                    <svg class="w-5 h-5 sm:mr-2 transform group-hover:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    <span class="hidden sm:inline">Retour</span>
                    <span class="sm:hidden">Liste</span>
                </a>
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
            <div class="bg-gradient-to-r from-amber-500 to-orange-600 px-4 md:px-8 py-4 md:py-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="flex items-center">
                        <div class="w-12 h-12 md:w-14 md:h-14 bg-white/20 backdrop-blur-lg rounded-xl md:rounded-2xl flex items-center justify-center mr-4 md:mr-5 flex-shrink-0">
                            <svg class="w-6 h-6 md:w-7 md:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl md:text-2xl font-bold text-white mb-1">Modifier les informations</h2>
                            <p class="text-amber-100 text-xs md:text-sm">Modifiez les informations de la matière</p>
                        </div>
                    </div>
                    <!-- Indicateur de progression (Masqué sur très petits écrans) -->
                    <div class="hidden sm:block text-right">
                        <span class="text-white/80 text-xs">Complétion</span>
                        <div class="w-32 h-2 bg-white/20 rounded-full mt-1">
                            <div class="bg-white h-2 rounded-full" style="width: 100%" id="progressBar"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-4 md:p-8">
                <!-- Aperçu rapide -->
                <div class="mb-6 md:mb-8 p-4 bg-gradient-to-r from-amber-50 to-orange-50 rounded-xl md:rounded-2xl border border-amber-200">
                    <div class="flex flex-col sm:flex-row items-center text-center sm:text-left">
                        <div class="w-14 h-14 md:w-16 md:h-16 bg-gradient-to-br from-amber-500 to-orange-600 rounded-xl flex items-center justify-center text-white font-bold text-xl md:text-2xl mb-3 sm:mb-0 sm:mr-4 flex-shrink-0" id="previewInitiales">
                            {{ substr($matiere->nom, 0, 2) }}
                        </div>
                        <div>
                            <p class="text-xs text-amber-700">Modification en cours pour</p>
                            <p class="text-base md:text-lg font-bold text-gray-800 truncate" id="previewNom">{{ $matiere->nom }}</p>
                            <div class="flex items-center justify-center sm:justify-start space-x-2 mt-1">
                                <span class="text-xs bg-amber-100 text-amber-700 px-2 py-0.5 rounded-lg" id="previewCode">{{ $matiere->code }}</span>
                                <span class="text-xs bg-orange-100 text-orange-700 px-2 py-0.5 rounded-lg" id="previewCoefficient">Coef. {{ $matiere->coefficient }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <form action="{{ route('admin.matieres.update', $matiere) }}" method="POST" id="editForm">
                    @csrf
                    @method('PUT')

                    <div class="space-y-5 md:space-y-6">
                        <!-- Code -->
                        <div class="group">
                            <label for="code" class="block text-xs md:text-sm font-semibold text-gray-700 mb-2 group-hover:text-amber-600 transition-colors duration-300">
                                Code <span class="text-red-500">*</span>
                                <span class="text-xs text-gray-500 ml-1 hidden sm:inline">(Lettres majuscules et chiffres uniquement)</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400 group-hover:text-amber-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                                    </svg>
                                </div>
                                <input type="text" 
                                       name="code" 
                                       id="code" 
                                       value="{{ old('code', $matiere->code) }}"
                                       placeholder="Ex: MATH, FR, ANG..."
                                       class="w-full pl-12 pr-4 py-2.5 md:py-3 rounded-xl border-2 border-gray-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 transition-all duration-300 @error('code') border-red-500 @enderror uppercase text-sm md:text-base"
                                       required
                                       maxlength="10">
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center">
                                    <span class="text-xs text-gray-400" id="codeLength">{{ strlen($matiere->code) }}/10</span>
                                </div>
                            </div>
                            <div class="mt-1 flex items-center text-xs text-gray-500">
                                <span id="codeStatus" class="flex items-center">
                                    <svg class="w-3 h-3 mr-1 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Code valide
                                </span>
                            </div>
                            @error('code')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nom -->
                        <div class="group">
                            <label for="nom" class="block text-xs md:text-sm font-semibold text-gray-700 mb-2 group-hover:text-amber-600 transition-colors duration-300">
                                Nom de la matière <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400 group-hover:text-amber-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <input type="text" 
                                       name="nom" 
                                       id="nom" 
                                       value="{{ old('nom', $matiere->nom) }}"
                                       placeholder="Ex: Mathématiques, Français, Anglais..."
                                       class="w-full pl-12 pr-4 py-2.5 md:py-3 rounded-xl border-2 border-gray-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 transition-all duration-300 @error('nom') border-red-500 @enderror text-sm md:text-base"
                                       required
                                       maxlength="255">
                            </div>
                            @error('nom')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Coefficient -->
                        <div class="group">
                            <label for="coefficient" class="block text-xs md:text-sm font-semibold text-gray-700 mb-2 group-hover:text-amber-600 transition-colors duration-300">
                                Coefficient <span class="text-red-500">*</span>
                                <span class="text-xs text-gray-500 ml-1">(entre 1 et 10)</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400 group-hover:text-amber-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                </div>
                                <input type="number" 
                                       name="coefficient" 
                                       id="coefficient" 
                                       value="{{ old('coefficient', $matiere->coefficient) }}"
                                       min="1"
                                       max="10"
                                       step="1"
                                       class="w-full pl-12 pr-4 py-2.5 md:py-3 rounded-xl border-2 border-gray-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 transition-all duration-300 @error('coefficient') border-red-500 @enderror text-sm md:text-base"
                                       required>
                            </div>
                            <div class="mt-2 flex flex-wrap items-center gap-2">
                                <span class="text-xs text-gray-500">Valeurs rapides :</span>
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
                            <label for="description" class="block text-xs md:text-sm font-semibold text-gray-700 mb-2 group-hover:text-amber-600 transition-colors duration-300">
                                Description
                                <span class="text-xs text-gray-500 ml-1">(optionnel)</span>
                            </label>
                            <div class="relative">
                                <div class="absolute top-3 md:top-4 left-4 pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400 group-hover:text-amber-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                                    </svg>
                                </div>
                                <textarea name="description" 
                                          id="description" 
                                          rows="4"
                                          placeholder="Description de la matière, objectifs pédagogiques, etc..."
                                          class="w-full pl-12 pr-4 py-2.5 md:py-3 rounded-xl border-2 border-gray-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 transition-all duration-300 @error('description') border-red-500 @enderror text-sm md:text-base">{{ old('description', $matiere->description) }}</textarea>
                            </div>
                            <p class="mt-2 text-xs text-gray-500 flex items-center">
                                <svg class="w-4 h-4 mr-1 hidden sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Maximum 1000 caractères • {{ strlen($matiere->description ?? '') }} caractères
                            </p>
                            @error('description')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Informations système (lecture seule) -->
                        <div class="mt-6 md:mt-8 p-4 bg-gray-50 rounded-xl border border-gray-200">
                            <h4 class="text-xs md:text-sm font-medium text-gray-700 mb-3 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Informations système
                            </h4>
                            <div class="grid grid-cols-2 gap-4 text-xs md:text-sm">
                                <div>
                                    <span class="text-gray-500">Créé le</span>
                                    <p class="font-medium text-gray-800">{{ $matiere->created_at->format('d/m/Y à H:i') }}</p>
                                </div>
                                <div>
                                    <span class="text-gray-500">Dernière modification</span>
                                    <p class="font-medium text-gray-800">{{ $matiere->updated_at->format('d/m/Y à H:i') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Boutons d'action -->
                        <div class="flex flex-col-reverse sm:flex-row justify-end gap-3 sm:gap-4 pt-6 border-t-2 border-gray-100">
                            <a href="{{ route('admin.matieres.show', $matiere) }}" 
                               class="w-full sm:w-auto px-6 py-2.5 md:py-3 bg-white border-2 border-gray-300 rounded-xl text-gray-700 font-semibold hover:bg-gray-50 transition-all duration-300 transform hover:scale-105 text-center text-sm md:text-base">
                                Annuler
                            </a>
                            <button type="submit" 
                                    class="w-full sm:w-auto px-6 py-2.5 md:py-3 bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-600 hover:to-orange-700 text-white font-semibold rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-xl text-sm md:text-base">
                                <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                                </svg>
                                Mettre à jour
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Zone de danger (suppression) -->
        <div class="mt-6 md:mt-8 bg-white rounded-2xl md:rounded-3xl shadow-xl overflow-hidden border-l-4 md:border-l-8 border-red-500">
            <div class="bg-gradient-to-r from-red-50 to-red-100 px-4 md:px-8 py-4 md:py-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 md:w-14 md:h-14 bg-red-500 rounded-xl md:rounded-2xl flex items-center justify-center mr-4 md:mr-5 flex-shrink-0">
                        <svg class="w-6 h-6 md:w-7 md:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg md:text-xl font-bold text-red-800 mb-1">Zone de danger</h3>
                        <p class="text-red-600 text-xs md:text-sm">Actions irréversibles - Manipuler avec précaution</p>
                    </div>
                </div>
            </div>
            
            <div class="p-4 md:p-8">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                    <div class="flex-1">
                        <h4 class="text-base md:text-lg font-semibold text-gray-800 mb-2">Supprimer cette matière</h4>
                        <p class="text-gray-600 text-xs md:text-sm leading-relaxed">
                            Une fois supprimée, cette matière sera définitivement effacée de la base de données.
                            @if($stats['total_evaluations'] > 0 || $stats['total_absences'] > 0 || $stats['total_classes'] > 0)
                                <span class="block mt-2 text-red-600 font-medium text-xs md:text-sm">
                                    Attention : Cette matière est utilisée dans {{ $stats['total_evaluations'] }} évaluation(s), 
                                    {{ $stats['total_absences'] }} absence(s) et {{ $stats['total_classes'] }} classe(s).
                                </span>
                            @endif
                        </p>
                        <div class="mt-3 flex items-center text-xs text-gray-500">
                            <svg class="w-4 h-4 mr-1 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                            ID : <span class="font-mono ml-1">#{{ $matiere->id }}</span>
                        </div>
                    </div>
                    
                    <div class="w-full md:w-auto">
                        <form action="{{ route('admin.matieres.destroy', $matiere) }}" 
                              method="POST" 
                              onsubmit="return confirm('Êtes-vous absolument sûr de vouloir supprimer cette matière ? Cette action est irréversible.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="w-full md:w-auto px-6 py-2.5 md:py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed text-sm md:text-base"
                                    {{ ($stats['total_evaluations'] > 0 || $stats['total_absences'] > 0 || $stats['total_classes'] > 0) ? 'disabled' : '' }}>
                                <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Supprimer
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Animations conservées */
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
    
    const formElement = document.getElementById('editForm');
    if (formElement) {
        formElement.querySelectorAll('input, select, textarea').forEach(element => {
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
    
    if (formElement) {
        formElement.addEventListener('submit', function() {
            formModified = false;
        });
    }

    // Gestion du code (majuscules automatiques)
    const codeInput = document.getElementById('code');
    const codeLength = document.getElementById('codeLength');
    const codeStatus = document.getElementById('codeStatus');

    if (codeInput) {
        codeInput.addEventListener('input', function() {
            this.value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
            if (codeLength) codeLength.textContent = this.value.length + '/10';
            
            // Simuler la vérification d'unicité (sauf si c'est le même code)
            if (this.value !== '{{ $matiere->code }}') {
                if (codeStatus) codeStatus.innerHTML = '<span class="text-yellow-600"><svg class="w-3 h-3 mr-1 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>Vérification...</span>';
                
                setTimeout(() => {
                    if (this.value.length >= 2 && codeStatus) {
                        codeStatus.innerHTML = '<span class="text-green-600"><svg class="w-3 h-3 mr-1 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Code disponible</span>';
                    }
                }, 500);
            } else {
                if (codeStatus) codeStatus.innerHTML = '<span class="text-green-600"><svg class="w-3 h-3 mr-1 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Code valide</span>';
            }
        });
    }

    // Prévisualisation en temps réel
    function updatePreview() {
        const nomEl = document.getElementById('nom');
        const codeEl = document.getElementById('code');
        const coefEl = document.getElementById('coefficient');

        const nom = nomEl ? nomEl.value : '';
        const code = codeEl ? codeEl.value : '';
        const coefficient = coefEl ? coefEl.value : '';

        const previewNom = document.getElementById('previewNom');
        const previewCode = document.getElementById('previewCode');
        const previewCoefficient = document.getElementById('previewCoefficient');
        const previewInitiales = document.getElementById('previewInitiales');

        if (previewNom) previewNom.textContent = nom || '{{ $matiere->nom }}';
        if (previewCode) previewCode.textContent = code || '{{ $matiere->code }}';
        if (previewCoefficient) previewCoefficient.textContent = `Coef. ${coefficient || {{ $matiere->coefficient }}}`;

        // Initiales
        const initiales = nom ? nom.split(' ').map(word => word[0]).join('').substring(0, 2).toUpperCase() : '{{ substr($matiere->nom, 0, 2) }}';
        if (previewInitiales) previewInitiales.textContent = initiales;
    }

    const nomInput = document.getElementById('nom');
    const coefInput = document.getElementById('coefficient');

    if (nomInput) nomInput.addEventListener('input', updatePreview);
    if (codeInput) codeInput.addEventListener('input', updatePreview);
    if (coefInput) coefInput.addEventListener('input', updatePreview);

    // Set coefficient
    window.setCoefficient = function(value) {
        const coefInput = document.getElementById('coefficient');
        if (coefInput) {
            coefInput.value = value;
            updatePreview();
        }
    }

    // Initial preview
    updatePreview();
</script>
@endpush