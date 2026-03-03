@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Gestion des Inscriptions') }}
        </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @php
                // Solution temporaire : récupérer les données si elles ne sont pas fournies par le contrôleur
                if (!isset($classes) || !$classes) {
                    $classes = App\Models\Classe::orderBy('nom')->get();
                }
                if (!isset($anneesScolaires) || !$anneesScolaires) {
                    $anneesScolaires = App\Models\AnneeScolaire::orderBy('nom', 'desc')->get();
                }
            @endphp

            <!-- Messages de succès avec animation -->
            @if(session('success'))
                <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded-lg shadow-md animate-pulse" role="alert">
                    <div class="flex items-center">
                        <div class="py-1">
                            <svg class="h-6 w-6 text-green-500 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <span class="block sm:inline font-medium">{{ session('success') }}</span>
                        </div>
                    </div>
                </div>
            @endif

            <!-- En-tête avec statistiques rapides -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white rounded-xl shadow-md p-6 transform hover:scale-105 transition-transform duration-200">
                    <div class="flex items-center">
                        <div class="p-3 bg-green-100 rounded-full">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Total inscriptions</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $inscriptions->total() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md p-6 transform hover:scale-105 transition-transform duration-200">
                    <div class="flex items-center">
                        <div class="p-3 bg-blue-100 rounded-full">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Classes concernées</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $classes->count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md p-6 transform hover:scale-105 transition-transform duration-200">
                    <div class="flex items-center">
                        <div class="p-3 bg-yellow-100 rounded-full">
                            <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Inscriptions actives</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $inscriptions->where('statut', true)->count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md p-6 transform hover:scale-105 transition-transform duration-200">
                    <div class="flex items-center">
                        <div class="p-3 bg-purple-100 rounded-full">
                            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Années scolaires</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $anneesScolaires->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- En-tête avec filtres -->
            <div class="bg-white rounded-xl shadow-lg mb-6 overflow-hidden border border-gray-200">
                <div class="bg-gradient-to-r from-green-600 to-emerald-700 px-6 py-4">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                        <div class="flex items-center space-x-3 mb-4 md:mb-0">
                            <div class="p-2 bg-white bg-opacity-20 rounded-lg backdrop-filter backdrop-blur-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-white">Liste des inscriptions</h3>
                                <p class="text-green-100 text-sm">Gérez toutes les inscriptions des élèves</p>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <button onclick="resetFilters()" class="inline-flex items-center px-4 py-2 bg-white bg-opacity-20 hover:bg-opacity-30 text-white rounded-lg transition duration-200 text-sm font-medium backdrop-filter backdrop-blur-lg">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                Réinitialiser
                            </button>
                            <a href="{{ route('admin.inscriptions.create') }}" class="inline-flex items-center px-4 py-2 bg-white text-green-600 hover:bg-green-50 border border-transparent rounded-lg font-semibold text-sm transition duration-200 ease-in-out transform hover:scale-105 shadow-lg">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Nouvelle inscription
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Filtres avancés -->
                <div class="p-6 bg-gray-50 border-b border-gray-200">
                    <form method="GET" action="{{ route('admin.inscriptions.index') }}" id="filter-form" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="space-y-1">
                            <label class="block text-sm font-medium text-gray-700">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                    Classe
                                </span>
                            </label>
                            <div class="relative">
                                <select name="classe_id" class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 appearance-none bg-white pl-3 pr-10 py-2">
                                    <option value="">Toutes les classes</option>
                                    @forelse($classes as $classe)
                                        <option value="{{ $classe->id }}" {{ request('classe_id') == $classe->id ? 'selected' : '' }}>
                                            {{ $classe->nom }} ({{ $classe->niveau }}{{ $classe->serie ? ' - ' . $classe->serie : '' }})
                                        </option>
                                    @empty
                                        <option value="" disabled>Aucune classe disponible</option>
                                    @endforelse
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-1">
                            <label class="block text-sm font-medium text-gray-700">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    Année scolaire
                                </span>
                            </label>
                            <div class="relative">
                                <select name="annee_scolaire_id" class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 appearance-none bg-white pl-3 pr-10 py-2">
                                    <option value="">Toutes les années</option>
                                    @forelse($anneesScolaires as $annee)
                                        <option value="{{ $annee->id }}" {{ request('annee_scolaire_id') == $annee->id ? 'selected' : '' }}>
                                            {{ $annee->nom }} @if($annee->active) (Active) @endif
                                        </option>
                                    @empty
                                        <option value="" disabled>Aucune année scolaire disponible</option>
                                    @endforelse
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-1">
                            <label class="block text-sm font-medium text-gray-700">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Statut
                                </span>
                            </label>
                            <div class="relative">
                                <select name="statut" class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 appearance-none bg-white pl-3 pr-10 py-2">
                                    <option value="">Tous</option>
                                    <option value="1" {{ request('statut') === '1' ? 'selected' : '' }}>Actif</option>
                                    <option value="0" {{ request('statut') === '0' ? 'selected' : '' }}>Inactif</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-end space-x-2">
                            <button type="submit" class="flex-1 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 font-medium flex items-center justify-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                                </svg>
                                Filtrer
                            </button>
                            <a href="{{ route('admin.inscriptions.index') }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg transition duration-200 font-medium flex items-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Résultats de la recherche -->
                <div class="px-6 py-3 bg-white border-b border-gray-200 flex items-center justify-between">
                    <p class="text-sm text-gray-600">
                        <span class="font-medium">{{ $inscriptions->firstItem() ?? 0 }}</span> - 
                        <span class="font-medium">{{ $inscriptions->lastItem() ?? 0 }}</span> sur 
                        <span class="font-medium">{{ $inscriptions->total() }}</span> inscriptions
                    </p>
                    <div class="flex items-center space-x-2">
                        <span class="text-sm text-gray-500">Trier par:</span>
                        <select class="text-sm border-gray-300 rounded-lg focus:border-green-500 focus:ring-green-200">
                            <option>Date récente</option>
                            <option>Date ancienne</option>
                            <option>Nom élève</option>
                            <option>Classe</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Tableau des inscriptions -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Élève</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Classe</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Année scolaire</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date inscription</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Statut</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Observation</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($inscriptions as $inscription)
                                <tr class="hover:bg-green-50 transition-colors duration-200 group">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center shadow-md group-hover:shadow-lg transition-shadow">
                                                <span class="text-white font-semibold text-sm">
                                                    {{ substr($inscription->eleve->prenom ?? 'N', 0, 1) }}{{ substr($inscription->eleve->nom ?? 'A', 0, 1) }}
                                                </span>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-semibold text-gray-900">
                                                    {{ $inscription->eleve->nom ?? 'N/A' }} {{ $inscription->eleve->prenom ?? '' }}
                                                </div>
                                                <div class="text-xs text-gray-500">
                                                    <span class="bg-gray-100 px-2 py-1 rounded-full">{{ $inscription->eleve->matricule ?? 'N/A' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $inscription->classe->nom ?? 'N/A' }}</div>
                                        <div class="text-xs text-gray-500">{{ $inscription->classe->niveau ?? '' }}{{ isset($inscription->classe->serie) ? ' - ' . $inscription->classe->serie : '' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $inscription->anneeScolaire->nom ?? 'N/A' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $inscription->date_inscription ? \Carbon\Carbon::parse($inscription->date_inscription)->format('d/m/Y') : 'N/A' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $inscription->statut ? 'bg-green-100 text-green-800 border border-green-300' : 'bg-red-100 text-red-800 border border-red-300' }}">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 8 8">
                                                <circle cx="4" cy="4" r="3" />
                                            </svg>
                                            {{ $inscription->statut ? 'Actif' : 'Inactif' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-500 max-w-xs truncate group-hover:text-gray-700 transition-colors" title="{{ $inscription->observation ?? '-' }}">
                                            @if($inscription->observation)
                                                <span class="flex items-center">
                                                    <svg class="w-4 h-4 mr-1 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                                                    </svg>
                                                    {{ Str::limit($inscription->observation, 30) }}
                                                </span>
                                            @else
                                                -
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center space-x-1">
                                            <!-- Voir détails -->
                                            <a href="{{ route('admin.inscriptions.show', $inscription) }}" 
                                               class="text-blue-600 hover:text-blue-900 p-2 hover:bg-blue-50 rounded-lg transition duration-200 group relative"
                                               title="Voir détails">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                                <span class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-900 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">Voir</span>
                                            </a>

                                            <!-- Modifier -->
                                            <a href="{{ route('admin.inscriptions.edit', $inscription) }}" 
                                               class="text-yellow-600 hover:text-yellow-900 p-2 hover:bg-yellow-50 rounded-lg transition duration-200 group relative"
                                               title="Modifier">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                                <span class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-900 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity">Modifier</span>
                                            </a>

                                            <!-- Activer/Désactiver -->
                                            <form action="{{ route('admin.inscriptions.toggle-status', $inscription) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" 
                                                        class="p-2 rounded-lg transition duration-200 group relative
                                                            {{ $inscription->statut ? 'text-red-600 hover:text-red-900 hover:bg-red-50' : 'text-green-600 hover:text-green-900 hover:bg-green-50' }}"
                                                        title="{{ $inscription->statut ? 'Désactiver' : 'Activer' }}">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        @if($inscription->statut)
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                                                        @else
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        @endif
                                                    </svg>
                                                    <span class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-900 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                                                        {{ $inscription->statut ? 'Désactiver' : 'Activer' }}
                                                    </span>
                                                </button>
                                            </form>

                                            <!-- Supprimer -->
                                            <button type="button" 
                                                    class="text-red-600 hover:text-red-900 p-2 hover:bg-red-50 rounded-lg transition duration-200 group relative"
                                                    title="Supprimer"
                                                    onclick="confirmDelete({{ $inscription->id }})">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                                <span class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-900 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity">Supprimer</span>
                                            </button>

                                            <!-- Formulaire de suppression caché -->
                                            <form id="delete-form-{{ $inscription->id }}" 
                                                  action="{{ route('admin.inscriptions.destroy', $inscription) }}" 
                                                  method="POST" 
                                                  class="hidden">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center justify-center text-gray-400">
                                            <svg class="w-20 h-20 mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <p class="text-xl font-medium text-gray-500 mb-2">Aucune inscription trouvée</p>
                                            <p class="text-sm text-gray-400 mb-6">Commencez par créer une nouvelle inscription ou ajustez vos filtres</p>
                                            <div class="flex gap-4">
                                                <button onclick="resetFilters()" class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg transition duration-200 font-medium">
                                                    Réinitialiser les filtres
                                                </button>
                                                <a href="{{ route('admin.inscriptions.create') }}" 
                                                   class="px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white rounded-lg transition duration-200 font-medium shadow-lg hover:shadow-xl transform hover:scale-105">
                                                    <svg class="w-5 h-5 mr-2 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                    </svg>
                                                    Nouvelle inscription
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination améliorée -->
                @if($inscriptions->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                            <!-- Informations de pagination -->
                            <div class="text-sm text-gray-600">
                                <span class="font-medium">{{ $inscriptions->firstItem() }}</span> - 
                                <span class="font-medium">{{ $inscriptions->lastItem() }}</span> sur 
                                <span class="font-medium">{{ $inscriptions->total() }}</span> inscriptions
                            </div>

                            <!-- Liens de pagination -->
                            <div class="flex items-center space-x-2">
                                {{ $inscriptions->links() }}
                            </div>

                            <!-- Sélecteur de nombre d'éléments par page -->
                            <div class="flex items-center space-x-2">
                                <label for="per-page" class="text-sm text-gray-600 hidden sm:block">Afficher</label>
                                <select id="per-page" 
                                        onchange="window.location.href = '{{ route('admin.inscriptions.index') }}?per_page=' + this.value + '&' + new URLSearchParams(window.location.search).toString()"
                                        class="text-sm border-gray-300 rounded-lg focus:border-green-500 focus:ring-green-200 py-2 pl-3 pr-8 appearance-none bg-white"
                                        style="background-image: url('data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 fill=%22none%22 viewBox=%220 0 24 24%22 stroke=%22%236B7280%22><path stroke-linecap=%22round%22 stroke-linejoin=%22round%22 stroke-width=%222%22 d=%22M19 9l-7 7-7-7%22></path></svg>'); background-repeat: no-repeat; background-position: right 0.5rem center; background-size: 1.2rem;">
                                    <option value="15" {{ request('per_page', 15) == 15 ? 'selected' : '' }}>15</option>
                                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                                </select>
                                <span class="text-sm text-gray-600 hidden sm:block">par page</span>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Message quand il n'y a qu'une seule page -->
                    <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                        <div class="text-sm text-gray-600 text-center">
                            <span class="font-medium">{{ $inscriptions->total() }}</span> inscription(s) au total
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
        function confirmDelete(id) {
            if (confirm('Êtes-vous sûr de vouloir supprimer cette inscription ? Cette action est irréversible.')) {
                document.getElementById('delete-form-' + id).submit();
            }
        }

        function resetFilters() {
            window.location.href = "{{ route('admin.inscriptions.index') }}";
        }

        // Animation pour les messages de succès
        document.addEventListener('DOMContentLoaded', function() {
            const alert = document.querySelector('[role="alert"]');
            if (alert) {
                setTimeout(() => {
                    alert.style.transition = 'opacity 0.5s';
                    alert.style.opacity = '0';
                    setTimeout(() => {
                        alert.remove();
                    }, 500);
                }, 5000);
            }
        });

        // Gestionnaire pour le changement du nombre d'éléments par page
        document.getElementById('per-page')?.addEventListener('change', function() {
            const url = new URL(window.location.href);
            url.searchParams.set('per_page', this.value);
            window.location.href = url.toString();
        });
        </script>
    @endpush

    @push('styles')
        <style>
            .animate-pulse {
                animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) 1;
            }

            @keyframes pulse {
                0%, 100% {
                    opacity: 1;
                }
                50% {
                    opacity: .7;
                }
            }

            .group:hover .group-hover\:opacity-100 {
                opacity: 1;
            }

            /* Style pour la pagination */
            .pagination {
                display: flex;
                gap: 0.5rem;
            }

            .pagination .page-item {
                display: inline-block;
            }

            .pagination .page-link {
                padding: 0.5rem 0.75rem;
                border-radius: 0.5rem;
                background-color: white;
                color: #374151;
                font-weight: 500;
                transition: all 0.2s;
                border: 1px solid #e5e7eb;
            }

            .pagination .page-link:hover {
                background-color: #f3f4f6;
                border-color: #10b981;
            }

            .pagination .active .page-link {
                background-color: #10b981;
                color: white;
                border-color: #10b981;
            }
        </style>
    @endpush

@endsection