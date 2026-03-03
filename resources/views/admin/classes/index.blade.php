{{-- resources/views/admin/classes/index.blade.php --}}
@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Gestion des Classes') }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- En-tête moderne avec dégradé -->
            <div class="bg-gradient-to-r from-indigo-600 via-indigo-700 to-purple-700 rounded-2xl shadow-2xl mb-8 overflow-hidden relative group">
                <!-- Éléments décoratifs -->
                <div class="absolute inset-0 bg-gradient-to-r from-white/10 to-transparent"></div>
                <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -translate-y-32 translate-x-32 group-hover:translate-y-0 group-hover:translate-x-0 transition-transform duration-700"></div>
                <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/5 rounded-full translate-y-24 -translate-x-24 group-hover:translate-y-0 group-hover:translate-x-0 transition-transform duration-700"></div>
                
                <div class="relative px-8 py-6">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                        <div class="flex items-center space-x-4 mb-4 md:mb-0">
                            <div class="bg-white/20 p-3 rounded-xl backdrop-blur-sm group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-white">Liste des Classes</h3>
                                @if(isset($anneeScolaire) && $anneeScolaire)
                                    <p class="text-indigo-100 flex items-center mt-1">
                                        <svg class="w-4 h-4 mr-1 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        Année scolaire active: <span class="font-semibold ml-1">{{ $anneeScolaire->nom }}</span>
                                    </p>
                                @else
                                    <p class="text-yellow-200 flex items-center mt-1">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                        </svg>
                                        Aucune année scolaire active
                                    </p>
                                @endif
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <!-- Bouton Export PDF -->
                            <a href="{{ route('admin.classes.exports.pdf', request()->query()) }}" 
                               class="inline-flex items-center px-4 py-3 bg-red-500 border-0 rounded-xl font-semibold text-xs text-white hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-all duration-200 transform hover:scale-105 shadow-lg group"
                               title="Exporter en PDF">
                                <svg class="w-5 h-5 mr-2 group-hover:animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path>
                                </svg>
                                <span class="text-sm">Export PDF</span>
                            </a>
                            
                            <!-- Bouton Export Excel -->
                            <a href="{{ route('admin.classes.exports.excel', request()->query()) }}" 
                               class="inline-flex items-center px-4 py-3 bg-emerald-500 border-0 rounded-xl font-semibold text-xs text-white hover:bg-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition-all duration-200 transform hover:scale-105 shadow-lg group"
                               title="Exporter en Excel">
                                <svg class="w-5 h-5 mr-2 group-hover:animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <span class="text-sm">Export Excel</span>
                            </a>
                            
                            <!-- Bouton Nouvelle Classe -->
                            <a href="{{ route('admin.classes.create') }}" 
                               class="inline-flex items-center px-6 py-3 bg-white border-0 rounded-xl font-semibold text-sm text-indigo-600 hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-indigo-600 transition-all duration-200 transform hover:scale-105 shadow-lg group">
                                <svg class="w-5 h-5 mr-2 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Nouvelle Classe
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cartes statistiques améliorées -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Classes -->
                <div class="group bg-white rounded-2xl shadow-lg p-6 border-l-4 border-indigo-500 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 font-medium flex items-center">
                                <span class="w-2 h-2 bg-indigo-500 rounded-full mr-2 group-hover:animate-pulse"></span>
                                Total Classes
                            </p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $classes->total() }}</p>
                            <p class="text-xs text-gray-400 mt-1">Toutes années confondues</p>
                        </div>
                        <div class="bg-gradient-to-br from-indigo-100 to-indigo-200 p-4 rounded-xl group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                            <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 h-1.5 w-full bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full w-3/4 bg-gradient-to-r from-indigo-500 to-indigo-600 rounded-full progress-bar" style="width: 75%"></div>
                    </div>
                </div>

                <!-- Capacité totale -->
                <div class="group bg-white rounded-2xl shadow-lg p-6 border-l-4 border-emerald-500 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 font-medium flex items-center">
                                <span class="w-2 h-2 bg-emerald-500 rounded-full mr-2 group-hover:animate-pulse"></span>
                                Capacité totale
                            </p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $classes->sum('capacite') }}</p>
                            <p class="text-xs text-gray-400 mt-1">Places disponibles</p>
                        </div>
                        <div class="bg-gradient-to-br from-emerald-100 to-emerald-200 p-4 rounded-xl group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                            <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 h-1.5 w-full bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full w-2/3 bg-gradient-to-r from-emerald-500 to-emerald-600 rounded-full progress-bar" style="width: 66%"></div>
                    </div>
                </div>

                <!-- Élèves inscrits -->
                <div class="group bg-white rounded-2xl shadow-lg p-6 border-l-4 border-blue-500 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 font-medium flex items-center">
                                <span class="w-2 h-2 bg-blue-500 rounded-full mr-2 group-hover:animate-pulse"></span>
                                Élèves inscrits
                            </p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $classes->sum('eleves_count') }}</p>
                            <p class="text-xs text-gray-400 mt-1">Toutes classes confondues</p>
                        </div>
                        <div class="bg-gradient-to-br from-blue-100 to-blue-200 p-4 rounded-xl group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 h-1.5 w-full bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full w-4/5 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full progress-bar" style="width: 80%"></div>
                    </div>
                </div>

                <!-- Taux d'occupation -->
                <div class="group bg-white rounded-2xl shadow-lg p-6 border-l-4 border-amber-500 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 font-medium flex items-center">
                                <span class="w-2 h-2 bg-amber-500 rounded-full mr-2 group-hover:animate-pulse"></span>
                                Taux d'occupation
                            </p>
                            @php
                                $totalCapacite = $classes->sum('capacite');
                                $totalEleves = $classes->sum('eleves_count');
                                $tauxOccupation = $totalCapacite > 0 ? round(($totalEleves / $totalCapacite) * 100) : 0;
                            @endphp
                            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $tauxOccupation }}%</p>
                            <p class="text-xs text-gray-400 mt-1">{{ $totalEleves }} élèves / {{ $totalCapacite }} places</p>
                        </div>
                        <div class="bg-gradient-to-br from-amber-100 to-amber-200 p-4 rounded-xl group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                            <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 h-1.5 w-full bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-amber-500 to-amber-600 rounded-full progress-bar" style="width: {{ $tauxOccupation }}%"></div>
                    </div>
                </div>
            </div>

            <!-- Barre de recherche et filtres améliorée -->
            <div class="bg-white rounded-2xl shadow-lg mb-8 overflow-hidden">
                <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div class="flex items-center gap-2">
                            <div class="bg-gradient-to-br from-indigo-100 to-indigo-200 p-2 rounded-lg">
                                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                                </svg>
                            </div>
                            <h4 class="text-lg font-semibold text-gray-900">Filtres et recherche</h4>
                        </div>
                        <div class="flex gap-2">
                            <span class="px-3 py-1 bg-indigo-100 text-indigo-600 text-xs font-semibold rounded-full">Recherche rapide</span>
                            <span class="px-3 py-1 bg-emerald-100 text-emerald-600 text-xs font-semibold rounded-full">Filtres multiples</span>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <form method="GET" action="{{ route('admin.classes.index') }}" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <!-- Recherche -->
                            <div class="md:col-span-2">
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                    </div>
                                    <input type="text" 
                                           name="search" 
                                           value="{{ request('search') }}"
                                           placeholder="Rechercher une classe (nom, niveau, série)..." 
                                           class="block w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200">
                                </div>
                            </div>

                            <!-- Filtre Niveau -->
                            <div>
                                <select name="niveau" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200">
                                    <option value="">Tous les niveaux</option>
                                    <option value="Préscolaire" {{ request('niveau') == 'Préscolaire' ? 'selected' : '' }}>Préscolaire</option>
                                    <option value="Primaire" {{ request('niveau') == 'Primaire' ? 'selected' : '' }}>Primaire</option>
                                    <option value="Collège" {{ request('niveau') == 'Collège' ? 'selected' : '' }}>Collège</option>
                                    <option value="Lycée" {{ request('niveau') == 'Lycée' ? 'selected' : '' }}>Lycée</option>
                                </select>
                            </div>

                            <!-- Filtre Année Scolaire -->
                            <div>
                                <select name="annee_scolaire_id" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200">
                                    <option value="">Toutes les années</option>
                                    @if(isset($anneesScolaires) && $anneesScolaires)
                                        @foreach($anneesScolaires as $annee)
                                            <option value="{{ $annee->id }}" {{ request('annee_scolaire_id') == $annee->id ? 'selected' : '' }}>
                                                {{ $annee->nom }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="flex justify-end gap-3">
                            <a href="{{ route('admin.classes.index') }}" 
                               class="px-6 py-2.5 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all duration-200 font-medium text-sm flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Réinitialiser
                            </a>
                            <button type="submit" 
                                    class="px-8 py-2.5 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white rounded-xl hover:from-indigo-700 hover:to-indigo-800 transition-all duration-200 font-medium text-sm shadow-lg shadow-indigo-200 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                                </svg>
                                Appliquer les filtres
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Message de succès -->
            @if(session('success'))
                <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-r-lg shadow-md animate-slideDown" role="alert">
                    <div class="flex items-center">
                        <div class="py-1">
                            <svg class="w-6 h-6 text-green-500 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-bold">Succès !</p>
                            <p class="text-sm">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Message d'erreur -->
            @if(session('error'))
                <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-r-lg shadow-md animate-slideDown" role="alert">
                    <div class="flex items-center">
                        <div class="py-1">
                            <svg class="w-6 h-6 text-red-500 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-bold">Erreur !</p>
                            <p class="text-sm">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Tableau des classes amélioré -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="bg-gradient-to-r from-gray-50 to-gray-100">
                                <th class="px-6 py-4 text-left">
                                    <div class="flex items-center">
                                        <input type="checkbox" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" id="selectAll">
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    <div class="flex items-center gap-1 cursor-pointer hover:text-indigo-600">
                                        Niveau
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                                        </svg>
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Classe</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Série</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Capacité</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Année Scolaire</th>
                                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($classes as $classe)
                                <tr class="group hover:bg-indigo-50/50 transition-all duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="checkbox" class="row-checkbox rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" value="{{ $classe->id }}">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-100 to-indigo-200 flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                                                <span class="text-indigo-700 font-bold text-sm">
                                                    {{ strtoupper(substr($classe->niveau, 0, 2)) }}
                                                </span>
                                            </div>
                                            <span class="ml-3 text-sm font-semibold text-gray-900">{{ $classe->niveau }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $classe->nom }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($classe->serie)
                                            <span class="px-3 py-1.5 inline-flex text-xs font-semibold rounded-full bg-gradient-to-r from-violet-100 to-violet-200 text-violet-800 border border-violet-300">
                                                <span class="w-2 h-2 bg-violet-500 rounded-full mr-2 mt-0.5"></span>
                                                {{ $classe->serie }}
                                            </span>
                                        @else
                                            <span class="text-sm text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-16 bg-gray-200 rounded-full h-2 mr-3">
                                                @php
                                                    $pourcentage = $classe->capacite > 0 ? round(($classe->eleves_count / $classe->capacite) * 100) : 0;
                                                @endphp
                                                <div class="bg-gradient-to-r from-emerald-500 to-emerald-600 h-2 rounded-full" style="width: {{ $pourcentage }}%"></div>
                                            </div>
                                            <span class="text-sm font-medium text-gray-900">{{ $classe->eleves_count }}/{{ $classe->capacite }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center mr-2">
                                                <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                            <span class="text-sm text-gray-600">{{ $classe->anneeScolaire->nom ?? '-' }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <!-- Voir -->
                                            <a href="{{ route('admin.classes.show', $classe) }}" 
                                               class="p-2.5 bg-indigo-50 text-indigo-600 rounded-xl hover:bg-indigo-100 hover:scale-110 transition-all duration-200 shadow-sm"
                                               title="Voir les détails">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </a>
                                            
                                            <!-- Modifier -->
                                            <a href="{{ route('admin.classes.edit', $classe) }}" 
                                               class="p-2.5 bg-amber-50 text-amber-600 rounded-xl hover:bg-amber-100 hover:scale-110 transition-all duration-200 shadow-sm"
                                               title="Modifier">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </a>
                                            
                                            <!-- PDF individuel -->
                                            <a href="{{ route('admin.classes.pdf', $classe) }}" 
                                               class="p-2.5 bg-red-50 text-red-600 rounded-xl hover:bg-red-100 hover:scale-110 transition-all duration-200 shadow-sm"
                                               title="Télécharger PDF">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path>
                                                </svg>
                                            </a>
                                            
                                            <!-- Dupliquer -->
                                            <form action="{{ route('admin.classes.duplicate', $classe) }}" method="POST" class="inline duplicate-form">
                                                @csrf
                                                <button type="submit" 
                                                        class="p-2.5 bg-purple-50 text-purple-600 rounded-xl hover:bg-purple-100 hover:scale-110 transition-all duration-200 shadow-sm"
                                                        title="Dupliquer pour la nouvelle année">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                            
                                            <!-- Supprimer -->
                                            <form action="{{ route('admin.classes.destroy', $classe) }}" method="POST" class="inline delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="p-2.5 bg-red-50 text-red-600 rounded-xl hover:bg-red-100 hover:scale-110 transition-all duration-200 shadow-sm"
                                                        title="Supprimer">
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
                                    <td colspan="7" class="px-6 py-16">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="w-20 h-20 bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl flex items-center justify-center mb-4">
                                                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                                </svg>
                                            </div>
                                            <h4 class="text-lg font-bold text-gray-900 mb-2">Aucune classe trouvée</h4>
                                            <p class="text-gray-500 text-center mb-6">Commencez par créer votre première classe</p>
                                            <a href="{{ route('admin.classes.create') }}" 
                                               class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white text-sm font-medium rounded-xl hover:from-indigo-700 hover:to-indigo-800 transition-all duration-200 shadow-lg shadow-indigo-200">
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                </svg>
                                                Créer une classe
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pied du tableau avec pagination et statistiques -->
                @if($classes->hasPages() || $classes->total() > 0)
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-t border-gray-200">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                        <div class="text-sm text-gray-600 flex items-center mb-4 md:mb-0">
                            <svg class="w-5 h-5 text-indigo-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            <span>Affichage de <span class="font-semibold text-indigo-600">{{ $classes->firstItem() ?? 0 }}</span> à <span class="font-semibold text-indigo-600">{{ $classes->lastItem() ?? 0 }}</span> sur <span class="font-semibold text-indigo-600">{{ $classes->total() }}</span> classes</span>
                        </div>
                        <div class="flex items-center gap-2">
                            {{ $classes->onEachSide(2)->links() }}
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Animation pour les lignes du tableau */
        tbody tr {
            transition: all 0.2s ease-in-out;
        }

        /* Style pour la pagination */
        .pagination {
            display: flex;
            gap: 0.5rem;
        }

        .pagination .page-item {
            list-style: none;
        }

        .pagination .page-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 2.5rem;
            height: 2.5rem;
            padding: 0 0.5rem;
            border-radius: 0.75rem;
            background-color: white;
            border: 1px solid #e5e7eb;
            color: #374151;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s;
        }

        .pagination .page-link:hover {
            background-color: #f3f4f6;
            border-color: #d1d5db;
            transform: translateY(-1px);
        }

        .pagination .active .page-link {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-color: #6366f1;
            color: white;
            box-shadow: 0 4px 6px -1px rgba(99, 102, 241, 0.2);
        }

        .pagination .disabled .page-link {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* Animation pour les boutons */
        .group:hover .group-hover\:scale-110 {
            transform: scale(1.1);
        }

        .group:hover .group-hover\:rotate-3 {
            transform: rotate(3deg);
        }

        .group:hover .group-hover\:animate-pulse {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        @keyframes slideDown {
            from {
                transform: translateY(-10px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .animate-slideDown {
            animation: slideDown 0.3s ease-out;
        }

        /* Style pour les barres de progression */
        .progress-bar {
            transition: width 1s ease-out;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animation des barres de progression
            const progressBars = document.querySelectorAll('.progress-bar');
            progressBars.forEach(bar => {
                const width = bar.style.width;
                bar.style.width = '0%';
                setTimeout(() => {
                    bar.style.width = width;
                }, 200);
            });

            // Checkbox "Tout sélectionner"
            const selectAll = document.getElementById('selectAll');
            const rowCheckboxes = document.querySelectorAll('.row-checkbox');

            if (selectAll) {
                selectAll.addEventListener('change', function(e) {
                    rowCheckboxes.forEach(checkbox => {
                        checkbox.checked = e.target.checked;
                    });
                });
            }

            // Confirmation de suppression avec SweetAlert2
            document.querySelectorAll('.delete-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    Swal.fire({
                        title: 'Êtes-vous sûr ?',
                        text: "Cette action est irréversible ! La classe sera définitivement supprimée.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#ef4444',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Oui, supprimer',
                        cancelButtonText: 'Annuler',
                        background: '#ffffff',
                        backdrop: `rgba(0,0,0,0.4)`
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.submit();
                        }
                    });
                });
            });

            // Confirmation pour la duplication
            document.querySelectorAll('.duplicate-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    Swal.fire({
                        title: 'Dupliquer la classe ?',
                        text: "Une nouvelle copie sera créée pour l'année scolaire en cours.",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#8b5cf6',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Oui, dupliquer',
                        cancelButtonText: 'Annuler',
                        background: '#ffffff'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.submit();
                        }
                    });
                });
            });

            // Animation des cartes statistiques
            const cards = document.querySelectorAll('.group');
            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.classList.add('shadow-2xl');
                });
                card.addEventListener('mouseleave', function() {
                    this.classList.remove('shadow-2xl');
                });
            });

            // Gestionnaire pour le raccourci clavier de recherche (Ctrl+F)
            document.addEventListener('keydown', function(e) {
                if ((e.metaKey || e.ctrlKey) && e.key === 'f') {
                    e.preventDefault();
                    document.querySelector('input[name="search"]')?.focus();
                }
            });
        });
    </script>
@endpush