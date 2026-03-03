@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Gestion des enseignants') }}
    </h2>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header avec titre et actions modernisé -->
        <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="relative">
                <h3 class="text-2xl font-bold bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent">
                    Liste des enseignants
                </h3>
                <p class="text-sm text-gray-500 mt-1 flex items-center gap-2">
                    <span class="w-1 h-1 bg-blue-500 rounded-full"></span>
                    Gérez tous les enseignants de l'établissement
                </p>
            </div>
            <a href="{{ route('admin.enseignants.create') }}" 
               class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white text-sm font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 hover:scale-105 group">
                <svg class="w-5 h-5 mr-2 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                </svg>
                Nouvel enseignant
                <span class="ml-2 px-2 py-0.5 bg-white/20 rounded-full text-xs">+</span>
            </a>
        </div>

        <!-- Filtres et recherche avancée - Design moderne -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 mb-8 overflow-hidden backdrop-blur-sm backdrop-filter">
            <div class="p-6 bg-gradient-to-br from-white to-gray-50">
                <form method="GET" action="{{ route('admin.enseignants.index') }}" id="filterForm">
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-5">
                        <!-- Recherche -->
                        <div class="md:col-span-5">
                            <label for="search" class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                Recherche avancée
                            </label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                                <input type="text" 
                                       name="search" 
                                       id="search"
                                       value="{{ $search ?? '' }}"
                                       placeholder="Nom, prénom, matricule ou email..." 
                                       class="block w-full pl-11 pr-4 py-3.5 border-2 border-gray-200 rounded-xl bg-white focus:bg-white focus:ring-0 focus:border-blue-500 transition-all duration-200 placeholder-gray-400 text-gray-700">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <kbd class="hidden sm:inline-flex items-center px-2 py-1 text-xs font-semibold text-gray-500 bg-gray-100 border border-gray-200 rounded-lg">⌘K</kbd>
                                </div>
                            </div>
                        </div>

                        <!-- Filtre spécialité -->
                        <div class="md:col-span-3">
                            <label for="specialite" class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                                <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                                Spécialité
                            </label>
                            <div class="relative">
                                <select name="specialite" id="specialite" 
                                        class="block w-full px-4 py-3.5 border-2 border-gray-200 rounded-xl bg-white focus:ring-0 focus:border-purple-500 transition-all duration-200 appearance-none cursor-pointer text-gray-700 font-medium">
                                    <option value="" class="text-gray-500">Toutes les spécialités</option>
                                    @foreach($specialites as $specialiteItem)
                                        <option value="{{ $specialiteItem }}" {{ ($specialite ?? '') == $specialiteItem ? 'selected' : '' }} class="py-2">
                                            {{ $specialiteItem }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Filtre statut -->
                        <div class="md:col-span-2">
                            <label for="statut" class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                                <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                                Statut
                            </label>
                            <div class="relative">
                                <select name="statut" id="statut" 
                                        class="block w-full px-4 py-3.5 border-2 border-gray-200 rounded-xl bg-white focus:ring-0 focus:border-green-500 transition-all duration-200 appearance-none cursor-pointer text-gray-700 font-medium">
                                    <option value="" class="text-gray-500">Tous</option>
                                    <option value="1" {{ request('statut') === '1' ? 'selected' : '' }} class="text-green-600">Actifs</option>
                                    <option value="0" {{ request('statut') === '0' ? 'selected' : '' }} class="text-red-600">Inactifs</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Boutons d'action modernisés -->
                        <div class="md:col-span-2 flex items-end gap-2">
                            <button type="submit" 
                                    class="flex-1 px-5 py-3.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white text-sm font-semibold rounded-xl shadow-md hover:shadow-lg transition-all duration-200 transform hover:-translate-y-0.5 flex items-center justify-center group">
                                <svg class="w-5 h-5 mr-2 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                Filtrer
                            </button>
                            
                            <a href="{{ route('admin.enseignants.index') }}" 
                               class="px-5 py-3.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold rounded-xl transition-all duration-200 flex items-center group border-2 border-transparent hover:border-gray-300"
                               title="Réinitialiser tous les filtres">
                                <svg class="w-5 h-5 group-hover:rotate-180 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
            
            <!-- Badges des filtres actifs - Design amélioré -->
            @if($search || $specialite || request('statut') !== null)
                <div class="px-6 pb-6 flex flex-wrap items-center gap-2 border-t border-gray-100 pt-4">
                    <span class="text-xs font-medium text-gray-500 uppercase tracking-wider mr-2">Filtres appliqués :</span>
                    
                    @if($search)
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-xs font-semibold bg-gradient-to-r from-blue-50 to-indigo-50 text-blue-700 border border-blue-200 shadow-sm">
                            <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            "{{ $search }}"
                            <a href="{{ route('admin.enseignants.index', array_merge(request()->except('search'), ['specialite' => $specialite, 'statut' => request('statut')])) }}" 
                               class="ml-2 p-0.5 rounded-full hover:bg-blue-200 transition-colors">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </a>
                        </span>
                    @endif
                    
                    @if($specialite)
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-xs font-semibold bg-gradient-to-r from-purple-50 to-pink-50 text-purple-700 border border-purple-200 shadow-sm">
                            <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                            {{ $specialite }}
                            <a href="{{ route('admin.enseignants.index', array_merge(request()->except('specialite'), ['search' => $search, 'statut' => request('statut')])) }}" 
                               class="ml-2 p-0.5 rounded-full hover:bg-purple-200 transition-colors">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </a>
                        </span>
                    @endif
                    
                    @if(request('statut') !== null)
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-xs font-semibold bg-gradient-to-r from-green-50 to-emerald-50 text-green-700 border border-green-200 shadow-sm">
                            <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                            {{ request('statut') == '1' ? 'Actif' : 'Inactif' }}
                            <a href="{{ route('admin.enseignants.index', array_merge(request()->except('statut'), ['search' => $search, 'specialite' => $specialite])) }}" 
                               class="ml-2 p-0.5 rounded-full hover:bg-green-200 transition-colors">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </a>
                        </span>
                    @endif
                    
                    <a href="{{ route('admin.enseignants.index') }}" class="text-xs font-medium text-red-600 hover:text-red-800 underline-offset-2 hover:underline ml-2 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Tout effacer
                    </a>
                </div>
            @endif
        </div>

        <!-- Statistiques rapides - Design moderne avec cartes -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
            <!-- Total enseignants -->
            <div class="group bg-white rounded-xl border border-gray-100 p-5 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Total enseignants</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $enseignants->total() }}</p>
                        <p class="text-xs text-green-600 mt-2 flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                            +12% ce mois
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="mt-3 h-1 w-full bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full w-3/4 bg-gradient-to-r from-blue-400 to-blue-600 rounded-full"></div>
                </div>
            </div>
            
            <!-- Enseignants actifs -->
            <div class="group bg-white rounded-xl border border-gray-100 p-5 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Actifs</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $enseignantsActifs ?? $enseignants->where('statut', true)->count() }}</p>
                        <p class="text-xs text-green-600 mt-2 flex items-center">
                            <span class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></span>
                            En ligne maintenant
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-gradient-to-br from-green-400 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                </div>
                <div class="mt-3 h-1 w-full bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full w-2/3 bg-gradient-to-r from-green-400 to-emerald-600 rounded-full"></div>
                </div>
            </div>
            
            <!-- Spécialités -->
            <div class="group bg-white rounded-xl border border-gray-100 p-5 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Spécialités</p>
                        <p class="text-3xl font-bold text-gray-900">{{ count($specialites) }}</p>
                        <p class="text-xs text-purple-600 mt-2 flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l5 5a2 2 0 01.586 1.414V19a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z"></path>
                            </svg>
                            Différentes disciplines
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-400 to-pink-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                </div>
                <div class="mt-3 h-1 w-full bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full w-full bg-gradient-to-r from-purple-400 to-pink-600 rounded-full"></div>
                </div>
            </div>
            
            <!-- Avec spécialité -->
            <div class="group bg-white rounded-xl border border-gray-100 p-5 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Avec spécialité</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $enseignantsAvecSpecialite }}</p>
                        <p class="text-xs text-amber-600 mt-2 flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                            </svg>
                            Experts certifiés
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-gradient-to-br from-amber-400 to-orange-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="mt-3 h-1 w-full bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full w-1/2 bg-gradient-to-r from-amber-400 to-orange-600 rounded-full"></div>
                </div>
            </div>
        </div>

        <!-- Tableau des enseignants - Design moderne -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden backdrop-blur-sm backdrop-filter">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                        <tr>
                            <th class="px-6 py-5 text-left">
                                <span class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Matricule</span>
                            </th>
                            <th class="px-6 py-5 text-left">
                                <span class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Enseignant</span>
                            </th>
                            <th class="px-6 py-5 text-left">
                                <span class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Contact</span>
                            </th>
                            <th class="px-6 py-5 text-left">
                                <span class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Spécialité</span>
                            </th>
                            <th class="px-6 py-5 text-left">
                                <span class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Statut</span>
                            </th>
                            <th class="px-6 py-5 text-left">
                                <span class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Âge</span>
                            </th>
                            <th class="px-6 py-5 text-right">
                                <span class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($enseignants as $enseignant)
                            <tr class="hover:bg-gradient-to-r hover:from-blue-50/30 hover:to-indigo-50/30 transition-all duration-300 group">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-gradient-to-br from-gray-100 to-gray-200 rounded-lg flex items-center justify-center mr-3">
                                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                                            </svg>
                                        </div>
                                        <span class="text-sm font-mono font-medium text-gray-700">
                                            {{ $enseignant->matricule ?? 'ENS-'.str_pad($enseignant->id, 4, '0', STR_PAD_LEFT) }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-12 w-12">
                                            @if($enseignant->photo)
                                                <img src="{{ Storage::url($enseignant->photo) }}" alt="{{ $enseignant->prenom }}" 
                                                     class="h-12 w-12 rounded-xl object-cover border-2 border-white shadow-lg group-hover:border-blue-200 transition-all duration-300">
                                            @else
                                                <div class="h-12 w-12 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold text-lg shadow-lg group-hover:scale-105 transition-transform duration-300">
                                                    {{ strtoupper(substr($enseignant->prenom, 0, 1)) }}{{ strtoupper(substr($enseignant->nom, 0, 1)) }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-semibold text-gray-900 group-hover:text-blue-600 transition-colors">
                                                {{ $enseignant->prenom }} {{ $enseignant->nom }}
                                            </div>
                                            <div class="text-xs text-gray-500 flex items-center gap-1 mt-0.5">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                </svg>
                                                {{ $enseignant->nom_complet }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center text-sm text-gray-900">
                                        <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                        {{ $enseignant->email ?? 'Email non défini' }}
                                    </div>
                                    <div class="flex items-center text-xs text-gray-500 mt-1">
                                        <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                        </svg>
                                        {{ $enseignant->telephone ?? 'Téléphone non défini' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($enseignant->specialite)
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-gradient-to-r from-blue-50 to-indigo-50 text-blue-700 border border-blue-200 shadow-sm">
                                            <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                            </svg>
                                            {{ $enseignant->specialite }}
                                        </span>
                                    @else
                                        <span class="text-sm text-gray-400 italic flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                                            </svg>
                                            Non spécifiée
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($enseignant->statut)
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-gradient-to-r from-green-50 to-emerald-50 text-green-700 border border-green-200 shadow-sm">
                                            <span class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></span>
                                            Actif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-gradient-to-r from-red-50 to-rose-50 text-red-700 border border-red-200 shadow-sm">
                                            <span class="w-2 h-2 bg-red-500 rounded-full mr-2"></span>
                                            Inactif
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center text-sm text-gray-700">
                                        <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $enseignant->age ?? 'N/A' }} ans
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <!-- ACTIONS TOUJOURS VISIBLES -->
                                    <div class="flex items-center justify-end space-x-2">
                                        <!-- Voir -->
                                        <a href="{{ route('admin.enseignants.show', $enseignant) }}" 
                                           class="p-2.5 text-blue-600 bg-blue-50 rounded-xl hover:bg-blue-100 transition-all duration-200 transform hover:scale-110 hover:shadow-lg border border-blue-200/50"
                                           title="Voir les détails">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </a>
                                        
                                        <!-- Modifier -->
                                        <a href="{{ route('admin.enseignants.edit', $enseignant) }}" 
                                           class="p-2.5 text-amber-600 bg-amber-50 rounded-xl hover:bg-amber-100 transition-all duration-200 transform hover:scale-110 hover:shadow-lg border border-amber-200/50"
                                           title="Modifier">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                        
                                        <!-- Supprimer -->
                                        <form action="{{ route('admin.enseignants.destroy', $enseignant) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="p-2.5 text-red-600 bg-red-50 rounded-xl hover:bg-red-100 transition-all duration-200 transform hover:scale-110 hover:shadow-lg border border-red-200/50"
                                                    title="Supprimer"
                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet enseignant ? Cette action est irréversible.')">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl flex items-center justify-center mb-4">
                                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                            </svg>
                                        </div>
                                        <p class="text-gray-600 text-lg font-semibold">Aucun enseignant trouvé</p>
                                        <p class="text-gray-400 text-sm mt-1">Commencez par ajouter un nouvel enseignant</p>
                                        <a href="{{ route('admin.enseignants.create') }}" class="mt-6 inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white text-sm font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-1">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                            </svg>
                                            Ajouter un enseignant
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Informations de pagination modernisées -->
            <div class="px-6 py-4 border-t border-gray-200 bg-gradient-to-r from-gray-50 to-white flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="text-sm text-gray-600 flex items-center gap-2">
                    <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                    Affichage de <span class="font-semibold text-gray-900">{{ $enseignants->firstItem() ?? 0 }}</span> 
                    à <span class="font-semibold text-gray-900">{{ $enseignants->lastItem() ?? 0 }}</span> 
                    sur <span class="font-semibold text-gray-900">{{ $enseignants->total() }}</span> enseignants
                </div>
                
                @if($enseignants->hasPages())
                    <div class="flex items-center space-x-2">
                        {{ $enseignants->appends(request()->query())->links('pagination::tailwind') }}
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Export options modernisées -->
        @if($enseignants->total() > 0)
        <div class="mt-6 flex justify-end">
            <div class="inline-flex rounded-xl shadow-lg border border-gray-200 divide-x divide-gray-200 bg-white overflow-hidden">
                <button class="px-6 py-3 text-sm font-semibold text-gray-700 bg-white hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 transition-all duration-200 flex items-center gap-2 group">
                    <svg class="w-5 h-5 text-blue-600 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                    CSV
                </button>
                <button class="px-6 py-3 text-sm font-semibold text-gray-700 bg-white hover:bg-gradient-to-r hover:from-green-50 hover:to-emerald-50 transition-all duration-200 flex items-center gap-2 group">
                    <svg class="w-5 h-5 text-green-600 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    PDF
                </button>
                <button class="px-6 py-3 text-sm font-semibold text-gray-700 bg-white hover:bg-gradient-to-r hover:from-purple-50 hover:to-pink-50 transition-all duration-200 flex items-center gap-2 group">
                    <svg class="w-5 h-5 text-purple-600 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                    </svg>
                    Imprimer
                </button>
            </div>
        </div>
        @endif
    </div>
</div>

@push('styles')
<style>
    /* Styles modernes et animations */
    .group-hover\:rotate-180 {
        transition: transform 0.5s ease-in-out;
    }
    
    .group:hover .group-hover\:rotate-180 {
        transform: rotate(180deg);
    }
    
    @keyframes pulse {
        0%, 100% {
            opacity: 1;
            transform: scale(1);
        }
        50% {
            opacity: 0.8;
            transform: scale(1.1);
        }
    }
    
    .animate-pulse {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
    
    /* Amélioration des transitions */
    .transition-all {
        transition-property: all;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 300ms;
    }
    
    /* Style personnalisé pour la pagination */
    .pagination {
        @apply flex items-center space-x-2;
    }
    
    .page-link {
        @apply px-4 py-2 rounded-lg text-sm font-medium text-gray-700 bg-white border border-gray-200 hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 hover:border-blue-300 hover:text-blue-600 transition-all duration-200 shadow-sm;
    }
    
    .page-item.active .page-link {
        @apply bg-gradient-to-r from-blue-600 to-indigo-600 text-white border-transparent hover:from-blue-700 hover:to-indigo-700 hover:text-white;
    }
    
    .page-item.disabled .page-link {
        @apply text-gray-400 cursor-not-allowed hover:bg-transparent hover:border-gray-200 hover:text-gray-400;
    }
    
    /* Style pour les inputs */
    input, select {
        transition: all 0.2s ease;
    }
    
    input:focus, select:focus {
        outline: none;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
    }
    
    /* Animation pour les boutons d'action */
    .bg-blue-50, .bg-amber-50, .bg-red-50 {
        transition: all 0.2s ease;
    }
    
    /* Tooltips personnalisés */
    [title] {
        position: relative;
        cursor: help;
    }
    
    [title]:hover::after {
        content: attr(title);
        position: absolute;
        bottom: 100%;
        left: 50%;
        transform: translateX(-50%);
        padding: 4px 8px;
        background: rgba(0, 0, 0, 0.8);
        color: white;
        font-size: 12px;
        border-radius: 6px;
        white-space: nowrap;
        z-index: 10;
        margin-bottom: 5px;
    }
    
    /* Style pour les cartes de statistiques */
    .group:hover .w-12 {
        transform: scale(1.1) rotate(5deg);
    }
    
    /* Responsive design amélioré */
    @media (max-width: 768px) {
        .group:hover .opacity-100 {
            opacity: 1 !important;
        }
    }
    
    /* Effet de vague pour les boutons */
    .btn-wave {
        position: relative;
        overflow: hidden;
    }
    
    .btn-wave::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.5);
        transform: translate(-50%, -50%);
        transition: width 0.3s, height 0.3s;
    }
    
    .btn-wave:active::after {
        width: 200px;
        height: 200px;
    }
    
    /* Style pour les badges de spécialité */
    .badge-gradient {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(99, 102, 241, 0.1) 100%);
        border: 1px solid rgba(59, 130, 246, 0.2);
    }
    
    /* Animation de fade pour les icônes d'action */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateX(10px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
    
    .group-hover\:opacity-100 {
        animation: fadeIn 0.3s ease-out;
    }
    
    /* Style pour les boutons d'action - TOUJOURS VISIBLES */
    .action-buttons {
        opacity: 1 !important;
        visibility: visible !important;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-submit avec debounce pour les filtres
        const filterSelects = document.querySelectorAll('#specialite, #statut');
        filterSelects.forEach(select => {
            select.addEventListener('change', function() {
                document.getElementById('filterForm').submit();
            });
        });

        // Debounce intelligent pour la recherche
        let searchTimeout;
        const searchInput = document.getElementById('search');
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    document.getElementById('filterForm').submit();
                }, 500);
            });
        }

        // Confirmation de suppression avec animation
        const deleteForms = document.querySelectorAll('form[method="POST"]');
        deleteForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                if (!confirm('Êtes-vous sûr de vouloir supprimer cet enseignant ? Cette action est irréversible.')) {
                    e.preventDefault();
                }
            });
        });

        // Raccourci clavier pour la recherche (Ctrl+K / Cmd+K)
        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                e.preventDefault();
                document.getElementById('search').focus();
            }
        });

        // Animation des cartes de statistiques
        const statCards = document.querySelectorAll('.group');
        statCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });

        // Effet de vague sur les boutons d'export
        const exportButtons = document.querySelectorAll('.export-btn');
        exportButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                let ripple = document.createElement('span');
                ripple.classList.add('ripple');
                this.appendChild(ripple);
                
                let x = e.clientX - e.target.offsetLeft;
                let y = e.clientY - e.target.offsetTop;
                
                ripple.style.left = `${x}px`;
                ripple.style.top = `${y}px`;
                
                setTimeout(() => {
                    ripple.remove();
                }, 300);
            });
        });
    });
</script>
@endpush
@endsection