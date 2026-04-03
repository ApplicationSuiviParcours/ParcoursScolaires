@extends('layouts.app')

@section('title', 'Modifier la réinscription')

@section('header')
<div class="relative overflow-hidden bg-gradient-to-br from-amber-600 via-amber-700 to-orange-800 py-10 sm:py-12 no-print">
    <!-- Éléments décoratifs animés -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute -top-24 -right-24 w-64 sm:w-96 h-64 sm:h-96 bg-white rounded-full mix-blend-overlay filter blur-3xl animate-pulse"></div>
        <div class="absolute -bottom-24 -left-24 w-64 sm:w-96 h-64 sm:h-96 bg-orange-300 rounded-full mix-blend-overlay filter blur-3xl animate-pulse delay-1000"></div>
    </div>

    <!-- Particules flottantes -->
    <div class="absolute inset-0 overflow-hidden">
        @for($i = 1; $i <= 4; $i++)
            <div class="absolute w-1 h-1 bg-white rounded-full opacity-30 animate-float-{{ $i }}"
                 style="left: {{ rand(0, 100) }}%; top: {{ rand(0, 100) }}%; animation-delay: {{ rand(0, 5) }}s;"></div>
        @endfor
    </div>

    <div class="container mx-auto px-4 sm:px-6 relative z-10">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-5">
            <div class="text-center md:text-left">
                {{-- Fil d'Ariane --}}
                <nav class="flex justify-center md:justify-start mb-3 sm:mb-4" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center flex-wrap gap-y-1 space-x-1 md:space-x-2">
                        <li class="inline-flex items-center">
                            <a href="{{ route('admin.reinscriptions.index') }}"
                               class="inline-flex items-center text-xs sm:text-sm font-medium text-amber-200 hover:text-white transition-colors duration-300">
                                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mr-1.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                </svg>
                                Réinscriptions
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-amber-300 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <a href="{{ route('admin.reinscriptions.show', $reinscription) }}"
                                   class="ml-1 text-xs sm:text-sm font-medium text-amber-200 hover:text-white transition-colors duration-300">
                                    Détails #{{ $reinscription->id }}
                                </a>
                            </div>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-amber-300 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <span class="ml-1 text-xs sm:text-sm font-medium text-white">Modification</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-white mb-2 animate-fade-in-up">
                    Modifier la réinscription
                </h1>
                <p class="text-amber-200 text-sm sm:text-base md:text-lg animate-fade-in-up animation-delay-200">
                    Élève : <span class="font-semibold text-white">{{ $reinscription->eleve->nom }} {{ $reinscription->eleve->prenom }}</span>
                </p>
            </div>
            {{-- Boutons --}}
            <div class="flex flex-wrap justify-center md:justify-end gap-2 sm:gap-3 animate-fade-in-right">
                <a href="{{ route('admin.reinscriptions.show', $reinscription) }}"
                   class="group relative inline-flex items-center px-4 sm:px-5 py-2 sm:py-2.5
                          bg-blue-500 hover:bg-blue-600 text-white font-medium rounded-xl
                          transition-all duration-300 transform hover:scale-105 hover:shadow-xl overflow-hidden text-sm">
                    <span class="absolute inset-0 bg-white opacity-0 group-hover:opacity-20 transition-opacity duration-300"></span>
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-1.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    Voir détails
                </a>
                <a href="{{ route('admin.reinscriptions.index') }}"
                   class="group relative inline-flex items-center px-4 sm:px-5 py-2 sm:py-2.5
                          bg-white/10 backdrop-blur-lg hover:bg-white/20 text-white font-medium
                          rounded-xl transition-all duration-300 transform hover:scale-105
                          border border-white/20 text-sm">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-1.5 flex-shrink-0 transform group-hover:-translate-x-1 transition-transform duration-300"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Retour à la liste
                </a>
            </div>
        </div>
    </div>

    <!-- Vague décorative -->
    <div class="absolute bottom-0 left-0 right-0">
        <svg class="fill-current text-gray-50" viewBox="0 0 1440 120" preserveAspectRatio="none">
            <path d="M0,64L80,69.3C160,75,320,85,480,80C640,75,800,53,960,48C1120,43,1280,53,1360,58.7L1440,64L1440,120L1360,120C1280,120,1120,120,960,120C800,120,640,120,480,120C320,120,160,120,80,120L0,120Z"/>
        </svg>
    </div>
</div>
@endsection

@section('content')
<div class="container mx-auto px-3 sm:px-4 lg:px-6 py-8 sm:py-10 bg-gray-50">

    {{-- ── FORMULAIRE PRINCIPAL ─────────────────────────────────────── --}}
    <div class="bg-white rounded-2xl sm:rounded-3xl shadow-xl overflow-hidden mb-6 sm:mb-8 transition-all duration-500 hover:shadow-2xl">

        {{-- En-tête du formulaire --}}
        <div class="bg-gradient-to-r from-amber-500 to-orange-600 px-5 sm:px-8 py-5 sm:py-6">
            <div class="flex items-start sm:items-center gap-4">
                <div class="w-12 h-12 sm:w-14 sm:h-14 bg-white/20 backdrop-blur-lg rounded-xl sm:rounded-2xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 sm:w-7 sm:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl sm:text-2xl font-bold text-white mb-0.5 sm:mb-1">Formulaire de modification</h2>
                    <p class="text-amber-100 text-xs sm:text-sm">Modifiez les informations de réinscription de l'élève</p>
                </div>
            </div>
        </div>

        <div class="p-4 sm:p-6 lg:p-8">
            <form action="{{ route('admin.reinscriptions.update', $reinscription) }}" method="POST" id="editForm">
                @csrf
                @method('PUT')

                {{-- ── INFOS ÉLÈVE (lecture seule) ── --}}
                <div class="mb-6 sm:mb-8 p-4 sm:p-6 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl sm:rounded-2xl border border-blue-100">
                    <div class="flex items-center mb-4 gap-3">
                        <div class="w-9 h-9 sm:w-10 sm:h-10 bg-blue-500 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <h3 class="text-base sm:text-lg font-semibold text-gray-800">Informations de l'élève</h3>
                    </div>
                    {{-- 1 col mobile → 2 col sm → 3 col md --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3 sm:gap-6">
                        <div class="bg-white/60 backdrop-blur-sm rounded-xl p-3 sm:p-4">
                            <p class="text-xs text-gray-500 mb-1">Nom complet</p>
                            <p class="text-sm sm:text-base font-semibold text-gray-800">{{ $reinscription->eleve->nom }} {{ $reinscription->eleve->prenom }}</p>
                        </div>
                        @if($reinscription->eleve->matricule)
                        <div class="bg-white/60 backdrop-blur-sm rounded-xl p-3 sm:p-4">
                            <p class="text-xs text-gray-500 mb-1">Matricule</p>
                            <p class="text-sm sm:text-base font-semibold text-gray-800">{{ $reinscription->eleve->matricule }}</p>
                        </div>
                        @endif
                        <div class="bg-white/60 backdrop-blur-sm rounded-xl p-3 sm:p-4 @if(!$reinscription->eleve->matricule) sm:col-span-2 md:col-span-2 @endif">
                            <p class="text-xs text-gray-500 mb-1">Année scolaire</p>
                            <p class="text-sm sm:text-base font-semibold text-gray-800">{{ $reinscription->anneeScolaire->nom }}</p>
                        </div>
                    </div>
                </div>

                {{-- ── GRILLE DES CHAMPS : 1 col mobile → 2 col lg ── --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 sm:gap-6 lg:gap-8">

                    {{-- Colonne gauche --}}
                    <div class="space-y-5 sm:space-y-6">

                        {{-- Classe --}}
                        <div class="group">
                            <label for="classe_id" class="block text-sm font-semibold text-gray-700 mb-2 group-hover:text-amber-600 transition-colors duration-300">
                                Classe <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 sm:pl-4 flex items-center pointer-events-none">
                                    <svg class="h-4 w-4 sm:h-5 sm:w-5 text-gray-400 group-hover:text-amber-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"/>
                                    </svg>
                                </div>
                                <select name="classe_id" id="classe_id" required
                                        class="w-full pl-10 sm:pl-12 pr-10 py-3 sm:py-4 rounded-xl border-2 border-gray-200
                                               focus:border-amber-500 focus:ring-2 focus:ring-amber-200
                                               transition-all duration-300 @error('classe_id') border-red-500 @enderror
                                               appearance-none bg-white text-sm">
                                    <option value="">Sélectionnez une classe</option>
                                    @foreach($classes as $classe)
                                        <option value="{{ $classe->id }}" {{ old('classe_id', $reinscription->classe_id) == $classe->id ? 'selected' : '' }}>
                                            {{ $classe->nom }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 sm:pr-4 flex items-center pointer-events-none">
                                    <svg class="h-4 w-4 sm:h-5 sm:w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                            </div>
                            @error('classe_id')
                                <p class="mt-2 text-xs sm:text-sm text-red-600 flex items-center gap-1">
                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Date de réinscription --}}
                        <div class="group">
                            <label for="date_reinscription" class="block text-sm font-semibold text-gray-700 mb-2 group-hover:text-amber-600 transition-colors duration-300">
                                Date de réinscription <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 sm:pl-4 flex items-center pointer-events-none">
                                    <svg class="h-4 w-4 sm:h-5 sm:w-5 text-gray-400 group-hover:text-amber-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <input type="date"
                                       name="date_reinscription" id="date_reinscription" required
                                       value="{{ old('date_reinscription', $reinscription->date_reinscription ? $reinscription->date_reinscription->format('Y-m-d') : '') }}"
                                       class="w-full pl-10 sm:pl-12 pr-4 py-3 sm:py-4 rounded-xl border-2 border-gray-200
                                              focus:border-amber-500 focus:ring-2 focus:ring-amber-200
                                              transition-all duration-300 @error('date_reinscription') border-red-500 @enderror text-sm">
                            </div>
                            @error('date_reinscription')
                                <p class="mt-2 text-xs sm:text-sm text-red-600 flex items-center gap-1">
                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    {{-- Colonne droite --}}
                    <div class="space-y-5 sm:space-y-6">

                        {{-- Statut --}}
                        <div class="group">
                            <label for="statut" class="block text-sm font-semibold text-gray-700 mb-2 group-hover:text-amber-600 transition-colors duration-300">
                                Statut <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 sm:pl-4 flex items-center pointer-events-none">
                                    <svg class="h-4 w-4 sm:h-5 sm:w-5 text-gray-400 group-hover:text-amber-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <select name="statut" id="statut" required
                                        class="w-full pl-10 sm:pl-12 pr-10 py-3 sm:py-4 rounded-xl border-2 border-gray-200
                                               focus:border-amber-500 focus:ring-2 focus:ring-amber-200
                                               transition-all duration-300 @error('statut') border-red-500 @enderror
                                               appearance-none bg-white text-sm">
                                    @foreach($statuts as $value => $label)
                                        <option value="{{ $value }}" {{ old('statut', $reinscription->statut) == $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 sm:pr-4 flex items-center pointer-events-none">
                                    <svg class="h-4 w-4 sm:h-5 sm:w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                            </div>
                            @error('statut')
                                <p class="mt-2 text-xs sm:text-sm text-red-600 flex items-center gap-1">
                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Aperçu du statut --}}
                        <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl p-4 sm:p-5 border border-gray-200">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-xs sm:text-sm font-medium text-gray-600">Aperçu du statut :</span>
                                <div id="statusPreview" class="status-badge">
                                    @switch($reinscription->statut)
                                        @case('confirmee')
                                            <span class="inline-flex items-center px-3 sm:px-4 py-1.5 sm:py-2 bg-green-100 text-green-700 text-xs sm:text-sm font-medium rounded-lg">Confirmé</span>
                                            @break
                                        @case('en_attente')
                                            <span class="inline-flex items-center px-3 sm:px-4 py-1.5 sm:py-2 bg-yellow-100 text-yellow-700 text-xs sm:text-sm font-medium rounded-lg">En attente</span>
                                            @break
                                        @case('annulee')
                                            <span class="inline-flex items-center px-3 sm:px-4 py-1.5 sm:py-2 bg-red-100 text-red-700 text-xs sm:text-sm font-medium rounded-lg">Annulé</span>
                                            @break
                                        @default
                                            <span class="inline-flex items-center px-3 sm:px-4 py-1.5 sm:py-2 bg-gray-100 text-gray-700 text-xs sm:text-sm font-medium rounded-lg">{{ $reinscription->statut }}</span>
                                    @endswitch
                                </div>
                            </div>
                            <p class="text-xs text-gray-500">Le statut sera mis à jour automatiquement</p>
                        </div>
                    </div>
                </div>

                {{-- ── OBSERVATION (pleine largeur) ── --}}
                <div class="mt-6 sm:mt-8 group">
                    <label for="observation" class="block text-sm font-semibold text-gray-700 mb-2 group-hover:text-amber-600 transition-colors duration-300">
                        Observation
                    </label>
                    <div class="relative">
                        <div class="absolute top-3 sm:top-4 left-3 sm:left-4 pointer-events-none">
                            <svg class="h-4 w-4 sm:h-5 sm:w-5 text-gray-400 group-hover:text-amber-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                            </svg>
                        </div>
                        <textarea name="observation" id="observation" rows="5"
                                  placeholder="Ajoutez une observation ou un commentaire..."
                                  class="w-full pl-10 sm:pl-12 pr-4 py-3 sm:py-4 rounded-xl border-2 border-gray-200
                                         focus:border-amber-500 focus:ring-2 focus:ring-amber-200
                                         transition-all duration-300 @error('observation') border-red-500 @enderror
                                         text-sm resize-y">{{ old('observation', $reinscription->observation) }}</textarea>
                    </div>
                    <p class="mt-2 text-xs text-gray-500 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Champ optionnel — maximum 1000 caractères
                    </p>
                    @error('observation')
                        <p class="mt-2 text-xs sm:text-sm text-red-600 flex items-center gap-1">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- ── BOUTONS D'ACTION ─────────────────────────────────────
                     Empilés (col-reverse) sur mobile, côte à côte sur sm+
                ──────────────────────────────────────────────────────────── --}}
                <div class="flex flex-col-reverse sm:flex-row sm:justify-end gap-3 sm:gap-4 mt-8 sm:mt-10 pt-5 sm:pt-6 border-t-2 border-gray-100">
                    <a href="{{ route('admin.reinscriptions.show', $reinscription) }}"
                       class="group inline-flex items-center justify-center px-6 sm:px-8 py-3 sm:py-3.5
                              bg-white border-2 border-gray-300 rounded-xl text-gray-700 font-semibold
                              hover:bg-gray-50 hover:border-gray-400 transition-all duration-300 transform hover:scale-105 text-sm">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 flex-shrink-0 group-hover:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Annuler
                    </a>
                    <button type="submit"
                            class="group inline-flex items-center justify-center px-7 sm:px-10 py-3 sm:py-3.5
                                   bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-600 hover:to-orange-700
                                   text-white font-semibold rounded-xl transition-all duration-300
                                   transform hover:scale-105 hover:shadow-xl text-sm">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 flex-shrink-0 group-hover:animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                        </svg>
                        Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ── ZONE DE DANGER ───────────────────────────────────────────── --}}
    <div class="bg-white rounded-2xl sm:rounded-3xl shadow-xl overflow-hidden border-l-4 sm:border-l-8 border-red-500 transition-all duration-500 hover:shadow-2xl">

        {{-- En-tête zone danger --}}
        <div class="bg-gradient-to-r from-red-50 to-red-100 px-5 sm:px-8 py-5 sm:py-6">
            <div class="flex items-center gap-3 sm:gap-5">
                <div class="w-12 h-12 sm:w-14 sm:h-14 bg-red-500 rounded-xl sm:rounded-2xl flex items-center justify-center flex-shrink-0 animate-pulse">
                    <svg class="w-6 h-6 sm:w-7 sm:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg sm:text-xl font-bold text-red-800 mb-0.5 sm:mb-1">Zone de danger</h3>
                    <p class="text-red-600 text-xs sm:text-sm">Actions irréversibles — Manipuler avec précaution</p>
                </div>
            </div>
        </div>

        <div class="p-4 sm:p-8">
            {{-- Empilé sur mobile → côte à côte sur md --}}
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-5 sm:gap-6">
                <div class="flex-1">
                    <h4 class="text-base sm:text-lg font-semibold text-gray-800 mb-2">Supprimer cette réinscription</h4>
                    <p class="text-gray-600 text-xs sm:text-sm leading-relaxed">
                        Une fois supprimée, cette réinscription sera définitivement effacée de la base de données.
                        Cette action est irréversible et ne peut pas être annulée.
                    </p>
                    <div class="mt-3 flex items-center text-xs text-gray-500 gap-1">
                        <svg class="w-4 h-4 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        ID de la réinscription : <span class="font-mono ml-1">#{{ $reinscription->id }}</span>
                    </div>
                </div>

                <div class="md:text-right flex-shrink-0">
                    <form action="{{ route('admin.reinscriptions.destroy', $reinscription) }}"
                          method="POST" id="deleteForm"
                          onsubmit="return confirmDelete(event, '{{ $reinscription->eleve->nom }} {{ $reinscription->eleve->prenom }}');">
                        @csrf
                        @method('DELETE')
                        <div class="flex flex-col gap-3">
                            <label class="flex items-start sm:items-center text-xs sm:text-sm text-gray-600 gap-2 cursor-pointer">
                                <input type="checkbox" id="confirmDeleteCheck"
                                       class="mt-0.5 sm:mt-0 rounded border-gray-300 text-red-600 shadow-sm
                                              focus:border-red-300 focus:ring focus:ring-red-200 focus:ring-opacity-50
                                              flex-shrink-0">
                                <span>Je comprends que cette action est irréversible</span>
                            </label>
                            <button type="submit" id="deleteButton" disabled
                                    class="w-full md:w-auto inline-flex items-center justify-center
                                           px-6 sm:px-8 py-3 sm:py-3.5 bg-red-600 text-white font-semibold
                                           rounded-xl opacity-50 cursor-not-allowed
                                           transition-all duration-300 text-sm">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Supprimer définitivement
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ── MODAL DE CONFIRMATION ─────────────────────────────────────── --}}
<div id="deleteConfirmModal" class="fixed inset-0 z-50 hidden" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-900/75 transition-opacity" id="modal-backdrop"></div>
    <div class="flex min-h-full items-end sm:items-center justify-center p-3 sm:p-6">
        <div class="relative bg-white rounded-2xl sm:rounded-3xl shadow-2xl w-full max-w-lg overflow-hidden" id="modal-content">

            <div class="bg-white px-5 sm:px-6 pt-6 pb-4">
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0 flex items-center justify-center h-12 w-12 sm:h-14 sm:w-14 rounded-full bg-red-100 animate-pulse">
                        <svg class="h-6 w-6 sm:h-8 sm:w-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <h3 class="text-lg sm:text-2xl font-bold text-gray-900 mb-2 sm:mb-3">
                            Confirmation de suppression
                        </h3>
                        <p class="text-sm sm:text-base text-gray-600 mb-3 sm:mb-4">
                            Vous êtes sur le point de supprimer définitivement la réinscription de :
                        </p>
                        <p class="text-sm sm:text-lg font-semibold text-red-700 bg-red-50 rounded-xl p-3 sm:p-4" id="modal-eleve-name">
                            {{ $reinscription->eleve->nom }} {{ $reinscription->eleve->prenom }}
                        </p>
                        <div class="mt-3 sm:mt-4 p-3 sm:p-4 bg-yellow-50 rounded-xl border border-yellow-200">
                            <div class="flex items-start gap-2">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-yellow-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                                <div>
                                    <p class="text-xs sm:text-sm font-medium text-yellow-800">Attention : Cette action est irréversible</p>
                                    <p class="text-xs text-yellow-700 mt-0.5 sm:mt-1">Toutes les données associées seront définitivement perdues.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 px-5 sm:px-6 py-4 flex flex-col-reverse sm:flex-row sm:justify-end gap-3">
                <button type="button" onclick="closeDeleteModal()"
                        class="w-full sm:w-auto inline-flex justify-center items-center px-6 sm:px-8 py-3 sm:py-3.5
                               border border-gray-300 rounded-xl bg-white text-sm font-semibold text-gray-700
                               hover:bg-gray-50 transition-all duration-300 transform hover:scale-105">
                    Annuler
                </button>
                <button type="button" onclick="executeDelete()"
                        class="w-full sm:w-auto inline-flex justify-center items-center px-6 sm:px-8 py-3 sm:py-3.5
                               bg-red-600 hover:bg-red-700 text-white rounded-xl text-sm font-semibold
                               transition-all duration-300 transform hover:scale-105 shadow-md">
                    Oui, supprimer définitivement
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    @keyframes float-1 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(10px,-10px)} }
    @keyframes float-2 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(-15px,5px)} }
    @keyframes float-3 { 0%,100%{transform:translate(0,0) scale(1)} 50%{transform:translate(8px,8px) scale(1.1)} }
    @keyframes float-4 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(-12px,-8px)} }
    .animate-float-1{animation:float-1 8s ease-in-out infinite}
    .animate-float-2{animation:float-2 10s ease-in-out infinite}
    .animate-float-3{animation:float-3 12s ease-in-out infinite}
    .animate-float-4{animation:float-4 9s ease-in-out infinite}

    @keyframes fadeInUp   { from{opacity:0;transform:translateY(20px)} to{opacity:1;transform:translateY(0)} }
    @keyframes fadeInRight{ from{opacity:0;transform:translateX(-20px)} to{opacity:1;transform:translateX(0)} }
    .animate-fade-in-up   { animation: fadeInUp    0.8s ease-out forwards; }
    .animate-fade-in-right{ animation: fadeInRight 0.8s ease-out forwards; }
    .animation-delay-200  { animation-delay: 200ms; opacity: 0; }

    .status-badge { transition: all 0.3s ease; }
    *:focus { outline: none; }

    ::-webkit-scrollbar       { width:8px; height:8px; }
    ::-webkit-scrollbar-track { background:#f1f1f1; border-radius:10px; }
    ::-webkit-scrollbar-thumb { background:#fbbf24; border-radius:10px; }
    ::-webkit-scrollbar-thumb:hover { background:#f59e0b; }

    #deleteButton:not(:disabled) {
        opacity: 1;
        cursor: pointer;
        background: linear-gradient(to right, #dc2626, #b91c1c);
    }
    #deleteButton:not(:disabled):hover {
        transform: scale(1.05);
        box-shadow: 0 20px 25px -5px rgba(220,38,38,.2), 0 10px 10px -5px rgba(220,38,38,.1);
    }

    .group:hover input:not(:focus):not(:disabled),
    .group:hover select:not(:focus):not(:disabled),
    .group:hover textarea:not(:focus):not(:disabled) {
        border-color: #fcd34d;
    }
</style>
@endpush

@push('scripts')
<script>
    // ── Aperçu en direct du statut ─────────────────────────────────
    const statutSelect  = document.getElementById('statut');
    const statusPreview = document.getElementById('statusPreview');
    const statutStyles  = { confirmee:'bg-green-100 text-green-700', en_attente:'bg-yellow-100 text-yellow-700', annulee:'bg-red-100 text-red-700' };
    const statutLabels  = { confirmee:'Confirmé', en_attente:'En attente', annulee:'Annulé' };

    if (statutSelect) {
        statutSelect.addEventListener('change', function () {
            const cls   = statutStyles[this.value] || 'bg-gray-100 text-gray-700';
            const label = statutLabels[this.value]  || this.value;
            statusPreview.innerHTML = `<span class="inline-flex items-center px-3 sm:px-4 py-1.5 sm:py-2 ${cls} text-xs sm:text-sm font-medium rounded-lg">${label}</span>`;
        });
    }

    // ── Checkbox de confirmation suppression ───────────────────────
    const confirmCheckbox = document.getElementById('confirmDeleteCheck');
    const deleteButton    = document.getElementById('deleteButton');

    if (confirmCheckbox && deleteButton) {
        confirmCheckbox.addEventListener('change', function () {
            deleteButton.disabled = !this.checked;
            if (this.checked) {
                deleteButton.classList.remove('opacity-50', 'cursor-not-allowed');
            } else {
                deleteButton.classList.add('opacity-50', 'cursor-not-allowed');
            }
        });
    }

    // ── Modal de confirmation ──────────────────────────────────────
    let deleteForm    = null;

    function confirmDelete(event, eleveName) {
        event.preventDefault();
        if (!document.getElementById('confirmDeleteCheck').checked) {
            alert('Veuillez confirmer que vous comprenez les conséquences de cette action.');
            return false;
        }
        deleteForm = document.getElementById('deleteForm');
        document.getElementById('modal-eleve-name').textContent = eleveName;
        document.getElementById('deleteConfirmModal').classList.remove('hidden');
        return false;
    }

    function closeDeleteModal() {
        document.getElementById('deleteConfirmModal').classList.add('hidden');
    }

    function executeDelete() {
        if (deleteForm) deleteForm.submit();
        closeDeleteModal();
    }

    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeDeleteModal(); });
    document.getElementById('modal-backdrop').addEventListener('click', closeDeleteModal);

    // ── Alerte avant de quitter si modifié ─────────────────────────
    let formModified = false;
    const form = document.getElementById('editForm');
    form.querySelectorAll('input, select, textarea').forEach(el => {
        el.addEventListener('change', () => formModified = true);
    });
    window.addEventListener('beforeunload', e => {
        if (formModified) { e.preventDefault(); e.returnValue = ''; }
    });
    form.addEventListener('submit', () => formModified = false);

    // ── Validation date ────────────────────────────────────────────
    const dateInput = document.getElementById('date_reinscription');
    if (dateInput) {
        dateInput.addEventListener('change', function () {
            const today = new Date(); today.setHours(0,0,0,0);
            if (new Date(this.value) > today) {
                this.setCustomValidity('La date ne peut pas être dans le futur');
            } else {
                this.setCustomValidity('');
            }
        });
    }

    // ── Observer scroll ───────────────────────────────────────────
    const observer = new IntersectionObserver(entries => {
        entries.forEach(e => {
            if (e.isIntersecting) { e.target.classList.add('animate-fade-in-up'); observer.unobserve(e.target); }
        });
    }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });

    document.querySelectorAll('.group').forEach(el => observer.observe(el));
</script>
@endpush