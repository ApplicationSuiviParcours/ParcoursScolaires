{{-- resources/views/admin/classes/create.blade.php --}}
@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Nouvelle Classe') }}
    </h2>
@endsection

@section('content')
<div class="py-6 md:py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Messages flash -->
        @if(session('error'))
            <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-3 md:p-4 rounded-r-lg shadow-md text-sm" role="alert">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <!-- En-tête avec progression -->
        <div class="mb-4 md:mb-6">
            <div class="flex items-center justify-between mb-3">
                <div class="flex items-center space-x-2 md:space-x-3">
                    <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 p-1.5 md:p-2 rounded-lg shadow-md">
                        <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base md:text-lg font-semibold text-gray-800">Création d'une classe</h3>
                        <p class="text-xs md:text-sm text-gray-500 hidden sm:block">Remplissez les informations ci-dessous</p>
                    </div>
                </div>
                <span class="inline-flex items-center px-2.5 py-0.5 md:px-3 md:py-1 bg-indigo-100 text-indigo-800 text-[10px] md:text-xs font-medium rounded-full">
                    Nouvelle
                </span>
            </div>
            <div class="w-full h-1 bg-gray-200 rounded-full overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-600 to-indigo-400 h-1 w-full rounded-full"></div>
            </div>
        </div>

        <!-- Formulaire principal -->
        <div class="bg-white rounded-xl md:rounded-2xl shadow-xl overflow-hidden border border-gray-100">
            <!-- En-tête du formulaire -->
            <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 px-4 md:px-6 py-4 md:py-5">
                <div class="flex items-center">
                    <div class="bg-white/20 p-1.5 md:p-2.5 rounded-lg backdrop-blur-sm">
                        <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </div>
                    <div class="ml-3 md:ml-4">
                        <h3 class="text-base md:text-lg font-bold text-white">Informations de la classe</h3>
                        <p class="text-indigo-200 text-xs md:text-sm hidden sm:block">Les champs marqués * sont obligatoires</p>
                    </div>
                </div>
            </div>

            <!-- Corps du formulaire -->
            <div class="p-4 md:p-8">
                <form action="{{ route('admin.classes.store') }}" method="POST" class="space-y-6 md:space-y-8">
                    @csrf

                    <!-- Section Informations générales -->
                    <div class="bg-gray-50/50 p-4 md:p-6 rounded-xl border border-gray-100">
                        <div class="flex items-center mb-3 md:mb-4 pb-2 border-b border-gray-200">
                            <div class="w-1 h-5 md:h-6 bg-gradient-to-b from-indigo-600 to-indigo-400 rounded-full mr-2 md:mr-3"></div>
                            <h4 class="text-sm md:text-md font-semibold text-gray-700">📋 Informations générales</h4>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                            <!-- Nom de la classe -->
                            <div class="group">
                                <label for="nom" class="block text-xs md:text-sm font-medium text-gray-700 mb-1">
                                    Nom de la classe <span class="text-red-500 ml-1">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-4 w-4 md:h-5 md:w-5 text-gray-400 group-focus-within:text-indigo-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path>
                                        </svg>
                                    </div>
                                    <input type="text"
                                           name="nom"
                                           id="nom"
                                           value="{{ old('nom') }}"
                                           required
                                           maxlength="50"
                                           placeholder="Ex: 6ème A, Terminale S1..."
                                           class="w-full pl-9 md:pl-10 pr-4 py-2.5 md:py-3 border-2 border-gray-200 rounded-lg md:rounded-xl focus:border-indigo-400 focus:ring-2 focus:ring-indigo-200 transition-all text-sm @error('nom') border-red-400 bg-red-50 @enderror">
                                </div>
                                <div class="flex items-center justify-between mt-1">
                                    <p class="text-[10px] md:text-xs text-gray-500">Donnez un nom unique</p>
                                    <span class="text-[10px] md:text-xs text-gray-400" id="nomCounter">0/50</span>
                                </div>
                                @error('nom')
                                    <p class="mt-1 text-xs text-red-600 flex items-center">
                                        <svg class="w-3 h-3 md:w-4 md:h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Capacité -->
                            <div class="group">
                                <label for="capacite" class="block text-xs md:text-sm font-medium text-gray-700 mb-1">
                                    Capacité <span class="text-red-500 ml-1">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-4 w-4 md:h-5 md:w-5 text-gray-400 group-focus-within:text-indigo-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                    </div>
                                    <input type="number"
                                           name="capacite"
                                           id="capacite"
                                           value="{{ old('capacite', 30) }}"
                                           min="1"
                                           max="60"
                                           required
                                           class="w-full pl-9 md:pl-10 pr-4 py-2.5 md:py-3 border-2 border-gray-200 rounded-lg md:rounded-xl focus:border-indigo-400 focus:ring-2 focus:ring-indigo-200 transition-all text-sm @error('capacite') border-red-400 bg-red-50 @enderror">
                                </div>
                                <div class="flex items-center justify-between mt-1">
                                    <p class="text-[10px] md:text-xs text-gray-500">Max 60 élèves</p>
                                    <span class="text-[10px] md:text-xs font-medium px-2 py-0.5 bg-green-100 text-green-700 rounded-full" id="capaciteBadge">
                                        {{ old('capacite', 30) }}/60
                                    </span>
                                </div>
                                @error('capacite')
                                    <p class="mt-1 text-xs text-red-600 flex items-center">
                                        <svg class="w-3 h-3 md:w-4 md:h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Section Niveau et Série -->
                    <div class="bg-gray-50/50 p-4 md:p-6 rounded-xl border border-gray-100">
                        <div class="flex items-center mb-3 md:mb-4 pb-2 border-b border-gray-200">
                            <div class="w-1 h-5 md:h-6 bg-gradient-to-b from-indigo-600 to-indigo-400 rounded-full mr-2 md:mr-3"></div>
                            <h4 class="text-sm md:text-md font-semibold text-gray-700">🎓 Niveau et Série</h4>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                            <!-- Niveau -->
                            <div class="group">
                                <label for="niveau" class="block text-xs md:text-sm font-medium text-gray-700 mb-1">
                                    Niveau <span class="text-red-500 ml-1">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-4 w-4 md:h-5 md:w-5 text-gray-400 group-focus-within:text-indigo-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                        </svg>
                                    </div>
                                    <select name="niveau" id="niveau" required
                                            class="w-full pl-9 md:pl-10 pr-8 md:pr-10 py-2.5 md:py-3 border-2 border-gray-200 rounded-lg md:rounded-xl focus:border-indigo-400 focus:ring-2 focus:ring-indigo-200 transition-all appearance-none bg-white text-sm @error('niveau') border-red-400 bg-red-50 @enderror">
                                        <option value="" disabled selected>Choisir un niveau</option>
                                        <option value="P1" {{ old('niveau') == 'P1' ? 'selected' : '' }}>P1</option>
                                        <option value="P2" {{ old('niveau') == 'P2' ? 'selected' : '' }}>P2</option>
                                        <option value="P3" {{ old('niveau') == 'P3' ? 'selected' : '' }}>P3</option>
                                        <option value="CP" {{ old('niveau') == 'CP' ? 'selected' : '' }}>CP</option>
                                        <option value="CE1" {{ old('niveau') == 'CE1' ? 'selected' : '' }}>CE1</option>
                                        <option value="CE2" {{ old('niveau') == 'CE2' ? 'selected' : '' }}>CE2</option>
                                        <option value="CM1" {{ old('niveau') == 'CM1' ? 'selected' : '' }}>CM1</option>
                                        <option value="CM2" {{ old('niveau') == 'CM2' ? 'selected' : '' }}>CM2</option>
                                        <option value="6ème" {{ old('niveau') == '6ème' ? 'selected' : '' }}>6ème</option>
                                        <option value="5ème" {{ old('niveau') == '5ème' ? 'selected' : '' }}>5ème</option>
                                        <option value="4ème" {{ old('niveau') == '4ème' ? 'selected' : '' }}>4ème</option>
                                        <option value="3ème" {{ old('niveau') == '3ème' ? 'selected' : '' }}>3ème</option>
                                        <option value="Seconde Générale" {{ old('niveau') == 'Seconde Générale' ? 'selected' : '' }}>Seconde (Générale)</option>
                                        <option value="Première Générale" {{ old('niveau') == 'Première Générale' ? 'selected' : '' }}>Première (Générale)</option>
                                        <option value="Terminale Générale" {{ old('niveau') == 'Terminale Générale' ? 'selected' : '' }}>Terminale (Générale)</option>
                                        <option value="Seconde Technique" {{ old('niveau') == 'Seconde Technique' ? 'selected' : '' }}>Seconde (Technique)</option>
                                        <option value="Première Technique" {{ old('niveau') == 'Première Technique' ? 'selected' : '' }}>Première (Technique)</option>
                                        <option value="Terminale Technique" {{ old('niveau') == 'Terminale Technique' ? 'selected' : '' }}>Terminale (Technique)</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <svg class="h-4 w-4 md:h-5 md:w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                                @error('niveau')
                                    <p class="mt-1 text-xs text-red-600 flex items-center">
                                        <svg class="w-3 h-3 md:w-4 md:h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Série -->
                            <div class="group">
                                <label for="serie" class="block text-xs md:text-sm font-medium text-gray-700 mb-1">
                                    Série <span class="text-gray-400 text-[10px]">(optionnel)</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-4 w-4 md:h-5 md:w-5 text-gray-400 group-focus-within:text-indigo-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l5 5a2 2 0 01.586 1.414V19a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z"></path>
                                        </svg>
                                    </div>
                                    <select name="serie" id="serie"
                                            class="w-full pl-9 md:pl-10 pr-8 md:pr-10 py-2.5 md:py-3 border-2 border-gray-200 rounded-lg md:rounded-xl focus:border-indigo-400 focus:ring-2 focus:ring-indigo-200 transition-all appearance-none bg-white text-sm @error('serie') border-red-400 bg-red-50 @enderror">
                                        <option value="" selected>Aucune série</option>
                                        <option value="A" {{ old('serie') == 'A' ? 'selected' : '' }}>A (Générale)</option>
                                        <option value="C" {{ old('serie') == 'C' ? 'selected' : '' }}>C (Générale)</option>
                                        <option value="D" {{ old('serie') == 'D' ? 'selected' : '' }}>D (Générale)</option>
                                        <option value="S" {{ old('serie') == 'S' ? 'selected' : '' }}>S (Générale)</option>
                                        <option value="F1" {{ old('serie') == 'F1' ? 'selected' : '' }}>F1 (Technique)</option>
                                        <option value="F2" {{ old('serie') == 'F2' ? 'selected' : '' }}>F2 (Technique)</option>
                                        <option value="F3" {{ old('serie') == 'F3' ? 'selected' : '' }}>F3 (Technique)</option>
                                        <option value="F4" {{ old('serie') == 'F4' ? 'selected' : '' }}>F4 (Technique)</option>
                                        <option value="G1" {{ old('serie') == 'G1' ? 'selected' : '' }}>G1 (Technique)</option>
                                        <option value="G2" {{ old('serie') == 'G2' ? 'selected' : '' }}>G2 (Technique)</option>
                                        <option value="G3" {{ old('serie') == 'G3' ? 'selected' : '' }}>G3 (Technique)</option>
                                        <option value="H1" {{ old('serie') == 'H1' ? 'selected' : '' }}>H1 (Technique)</option>
                                        <option value="H2" {{ old('serie') == 'H2' ? 'selected' : '' }}>H2 (Technique)</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <svg class="h-4 w-4 md:h-5 md:w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                                @error('serie')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Section Année scolaire -->
                    <div class="bg-gray-50/50 p-4 md:p-6 rounded-xl border border-gray-100">
                        <div class="flex items-center mb-3 md:mb-4 pb-2 border-b border-gray-200">
                            <div class="w-1 h-5 md:h-6 bg-gradient-to-b from-indigo-600 to-indigo-400 rounded-full mr-2 md:mr-3"></div>
                            <h4 class="text-sm md:text-md font-semibold text-gray-700">📅 Année scolaire</h4>
                        </div>

                        <!-- Année scolaire -->
                        <div class="group">
                            <label for="annee_scolaire_id" class="block text-xs md:text-sm font-medium text-gray-700 mb-1">
                                Année scolaire <span class="text-red-500 ml-1">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-4 w-4 md:h-5 md:w-5 text-gray-400 group-focus-within:text-indigo-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <select name="annee_scolaire_id" id="annee_scolaire_id" required
                                        class="w-full pl-9 md:pl-10 pr-8 md:pr-10 py-2.5 md:py-3 border-2 border-gray-200 rounded-lg md:rounded-xl focus:border-indigo-400 focus:ring-2 focus:ring-indigo-200 transition-all appearance-none bg-white text-sm @error('annee_scolaire_id') border-red-400 bg-red-50 @enderror">
                                    <option value="" disabled selected>Choisir une année scolaire</option>
                                    @foreach($anneesScolaires as $annee)
                                        <option value="{{ $annee->id }}" {{ old('annee_scolaire_id') == $annee->id || (isset($anneeScolaireActive) && $annee->id == $anneeScolaireActive->id) ? 'selected' : '' }}>
                                            {{ $annee->nom }} @if($annee->active) (En cours) @endif
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="h-4 w-4 md:h-5 md:w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                            @error('annee_scolaire_id')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Boutons d'action -->
                    <div class="flex flex-col-reverse sm:flex-row justify-end gap-3 pt-4 md:pt-6 border-t border-gray-200">
                        <a href="{{ route('admin.classes.index') }}"
                           class="w-full sm:w-auto px-4 md:px-6 py-2.5 md:py-3 border-2 border-gray-300 text-gray-700 font-medium rounded-lg md:rounded-xl hover:bg-gray-50 text-center text-sm transition-all flex items-center justify-center group">
                            <svg class="w-4 h-4 md:w-5 md:h-5 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Annuler
                        </a>
                        <button type="submit"
                                class="w-full sm:w-auto px-4 md:px-6 py-2.5 md:py-3 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white font-medium rounded-lg md:rounded-xl hover:from-indigo-700 hover:to-indigo-800 text-center text-sm shadow-lg shadow-indigo-200 flex items-center justify-center group">
                            <svg class="w-4 h-4 md:w-5 md:h-5 mr-2 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                            </svg>
                            Créer la classe
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Message d'aide -->
        <div class="mt-4 md:mt-6 bg-gradient-to-r from-indigo-50 to-indigo-100/50 rounded-xl p-4 md:p-5 border border-indigo-100">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <div class="bg-indigo-200 p-1.5 md:p-2 rounded-lg">
                        <svg class="w-4 h-4 md:w-5 md:h-5 text-indigo-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-3 md:ml-4">
                    <h5 class="text-xs md:text-sm font-semibold text-indigo-800 mb-1">Bon à savoir</h5>
                    <p class="text-xs md:text-sm text-indigo-700">
                        Les champs marqués d'un <span class="font-bold text-red-500">*</span> sont obligatoires.
                        La série est optionnelle mais recommandée pour les classes du second cycle.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Compteur de caractères pour le nom
        const nomInput = document.getElementById('nom');
        const nomCounter = document.getElementById('nomCounter');

        if (nomInput && nomCounter) {
            // Initialisation
            nomCounter.textContent = `${nomInput.value.length}/50`;

            nomInput.addEventListener('input', function() {
                const length = this.value.length;
                nomCounter.textContent = `${length}/50`;

                // Changer la couleur selon la longueur
                if (length >= 45) {
                    nomCounter.className = 'text-[10px] md:text-xs text-orange-600 font-medium';
                } else if (length >= 40) {
                    nomCounter.className = 'text-[10px] md:text-xs text-blue-600 font-medium';
                } else {
                    nomCounter.className = 'text-[10px] md:text-xs text-gray-400';
                }
            });
        }

        // Animation de la capacité avec curseur visuel
        const capaciteInput = document.getElementById('capacite');
        const capaciteBadge = document.getElementById('capaciteBadge');

        if (capaciteInput && capaciteBadge) {
            capaciteInput.addEventListener('input', function() {
                const value = this.value;
                capaciteBadge.textContent = `${value}/60`;

                // Changer la couleur selon la valeur
                if (value >= 50) {
                    capaciteBadge.className = 'text-[10px] md:text-xs font-medium px-2 py-0.5 bg-orange-100 text-orange-700 rounded-full';
                } else if (value >= 30) {
                    capaciteBadge.className = 'text-[10px] md:text-xs font-medium px-2 py-0.5 bg-blue-100 text-blue-700 rounded-full';
                } else {
                    capaciteBadge.className = 'text-[10px] md:text-xs font-medium px-2 py-0.5 bg-green-100 text-green-700 rounded-full';
                }
            });
        }

        // Validation visuelle simple au focus perdu (blur)
        const requiredFields = document.querySelectorAll('[required]');
        requiredFields.forEach(field => {
            field.addEventListener('blur', function() {
                 if (!this.value.trim()) {
                    this.classList.add('border-red-400', 'bg-red-50');
                 } else {
                    this.classList.remove('border-red-400', 'bg-red-50');
                    this.classList.add('border-gray-200');
                 }
            });
        });

        // Animation d'apparition
        const formCard = document.querySelector('.bg-white.rounded-xl');
        if (formCard) {
            formCard.style.opacity = '0';
            formCard.style.transform = 'translateY(20px)';

            setTimeout(() => {
                formCard.style.transition = 'all 0.5s ease-out';
                formCard.style.opacity = '1';
                formCard.style.transform = 'translateY(0)';
            }, 100);
        }
    });
</script>
@endpush
