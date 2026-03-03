{{-- resources/views/admin/eleves/index.blade.php --}}
@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Gestion des élèves') }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Messages flash avec animation -->
            @if(session('success'))
                <div class="alert alert-success mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded-r-lg shadow-lg animate-slide-down" role="alert">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-error mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded-r-lg shadow-lg animate-slide-down" role="alert">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Stats Cards modernisées -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total élèves -->
                <div class="group bg-white rounded-2xl shadow-lg p-6 border-l-4 border-blue-500 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Total élèves</p>
                            <p class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['total'] }}</p>
                            <p class="text-xs text-gray-400 mt-1">Tous statuts confondus</p>
                        </div>
                        <div class="bg-gradient-to-br from-blue-100 to-blue-200 p-4 rounded-xl group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 h-1.5 w-full bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full w-full bg-gradient-to-r from-blue-500 to-blue-600 rounded-full"></div>
                    </div>
                </div>

                <!-- Élèves actifs -->
                <div class="group bg-white rounded-2xl shadow-lg p-6 border-l-4 border-green-500 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Élèves actifs</p>
                            <p class="text-3xl font-bold text-green-600 mt-1">{{ $stats['actifs'] }}</p>
                            <p class="text-xs text-gray-400 mt-1">Inactifs: {{ $stats['inactifs'] }}</p>
                        </div>
                        <div class="bg-gradient-to-br from-green-100 to-green-200 p-4 rounded-xl group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 h-1.5 w-full bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full" style="width: {{ $stats['total'] > 0 ? ($stats['actifs'] / $stats['total']) * 100 : 0 }}%"></div>
                    </div>
                </div>

                <!-- Garçons -->
                <div class="group bg-white rounded-2xl shadow-lg p-6 border-l-4 border-blue-600 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Garçons</p>
                            <p class="text-3xl font-bold text-blue-600 mt-1">{{ $stats['garcons'] }}</p>
                            <p class="text-xs text-gray-400 mt-1">{{ $stats['total'] > 0 ? round(($stats['garcons'] / $stats['total']) * 100, 1) : 0 }}% des effectifs</p>
                        </div>
                        <div class="bg-gradient-to-br from-blue-100 to-blue-200 p-4 rounded-xl group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 h-1.5 w-full bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full" style="width: {{ $stats['total'] > 0 ? ($stats['garcons'] / $stats['total']) * 100 : 0 }}%"></div>
                    </div>
                </div>

                <!-- Filles -->
                <div class="group bg-white rounded-2xl shadow-lg p-6 border-l-4 border-pink-600 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Filles</p>
                            <p class="text-3xl font-bold text-pink-600 mt-1">{{ $stats['filles'] }}</p>
                            <p class="text-xs text-gray-400 mt-1">{{ $stats['total'] > 0 ? round(($stats['filles'] / $stats['total']) * 100, 1) : 0 }}% des effectifs</p>
                        </div>
                        <div class="bg-gradient-to-br from-pink-100 to-pink-200 p-4 rounded-xl group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                            <svg class="w-8 h-8 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 h-1.5 w-full bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full" style="width: {{ $stats['total'] > 0 ? ($stats['filles'] / $stats['total']) * 100 : 0 }}%"></div>
                    </div>
                </div>
            </div>

            <!-- Search and Actions modernisé -->
            <div class="bg-white rounded-2xl shadow-xl mb-8 overflow-hidden border border-gray-100">
                <div class="bg-gradient-to-r from-gray-50 to-white px-6 py-5 border-b border-gray-200">
                    <div class="flex items-center gap-3">
                        <div class="bg-gradient-to-br from-indigo-100 to-indigo-200 p-2.5 rounded-xl">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <h4 class="text-lg font-bold text-gray-800">Recherche et filtres</h4>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex flex-col lg:flex-row justify-between items-center gap-4">
                        <form method="GET" action="{{ route('admin.eleves.index') }}" class="w-full lg:w-auto" id="searchForm">
                            <div class="flex flex-col sm:flex-row gap-3 w-full">
                                <div class="relative flex-1">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                    </div>
                                    <input type="text" name="search" placeholder="Rechercher par nom, prénom, matricule, téléphone, email ou lieu..." 
                                           value="{{ request('search') }}"
                                           class="block w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-indigo-400 focus:ring-2 focus:ring-indigo-200 transition-all duration-200 placeholder-gray-400">
                                    <span class="absolute inset-y-0 right-0 pr-4 flex items-center">
                                        <kbd class="px-2 py-1 bg-gray-100 text-gray-600 text-xs rounded-md">⌘K</kbd>
                                    </span>
                                </div>

                                <div class="flex gap-2">
                                    <button type="submit" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white rounded-xl hover:from-indigo-700 hover:to-indigo-800 transition-all duration-200 text-sm font-medium shadow-lg shadow-indigo-200 group">
                                        <svg class="w-5 h-5 mr-2 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                        Rechercher
                                    </button>

                                    @if(request('search') || request('statut') || request('genre') || request('classe_id') || request('annee_scolaire_id'))
                                        <a href="{{ route('admin.eleves.index') }}" class="inline-flex items-center px-6 py-3 border-2 border-gray-300 text-gray-700 font-medium rounded-xl hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 group">
                                            <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                            Réinitialiser
                                        </a>
                                    @endif
                                </div>
                            </div>

                            <!-- Filtres supplémentaires -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Filtrer par classe</label>
                                    <select name="classe_id" class="w-full px-4 py-2 border-2 border-gray-200 rounded-xl focus:border-indigo-400 focus:ring-2 focus:ring-indigo-200 transition-all duration-200">
                                        <option value="">Toutes les classes</option>
                                        @foreach($classes as $classe)
                                            <option value="{{ $classe->id }}" {{ request('classe_id') == $classe->id ? 'selected' : '' }}>
                                                {{ $classe->nom }} - {{ $classe->niveau }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Filtrer par année scolaire</label>
                                    <select name="annee_scolaire_id" class="w-full px-4 py-2 border-2 border-gray-200 rounded-xl focus:border-indigo-400 focus:ring-2 focus:ring-indigo-200 transition-all duration-200">
                                        <option value="">Toutes les années</option>
                                        @foreach($anneesScolaires as $annee)
                                            <option value="{{ $annee->id }}" {{ request('annee_scolaire_id') == $annee->id ? 'selected' : '' }}>
                                                {{ $annee->nom }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Filtrer par statut</label>
                                    <select name="statut" class="w-full px-4 py-2 border-2 border-gray-200 rounded-xl focus:border-indigo-400 focus:ring-2 focus:ring-indigo-200 transition-all duration-200">
                                        <option value="">Tous les statuts</option>
                                        <option value="1" {{ request('statut') === '1' ? 'selected' : '' }}>Actifs</option>
                                        <option value="0" {{ request('statut') === '0' ? 'selected' : '' }}>Inactifs</option>
                                    </select>
                                </div>
                            </div>
                        </form>

                        <div class="flex gap-2 w-full lg:w-auto">
                            <!-- BOUTON EXPORT PDF -->
                            <a href="{{ route('admin.eleves.exports.pdf', request()->query()) }}" 
                               class="inline-flex items-center px-6 py-3 bg-red-500 hover:bg-red-600 text-white rounded-xl transition-all duration-200 transform hover:scale-105 shadow-lg group">
                                <svg class="w-5 h-5 mr-2 group-hover:animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path>
                                </svg>
                                Export PDF
                            </a>

                            <!-- BOUTON EXPORT EXCEL -->
                            <a href="{{ route('admin.eleves.export.excel', request()->query()) }}" 
                               class="inline-flex items-center px-6 py-3 bg-green-500 hover:bg-green-600 text-white rounded-xl transition-all duration-200 transform hover:scale-105 shadow-lg group">
                                <svg class="w-5 h-5 mr-2 group-hover:animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path>
                                </svg>
                                Export Excel
                            </a>

                            <a href="{{ route('admin.eleves.create') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 text-white rounded-xl transition-all duration-200 transform hover:scale-105 shadow-lg shadow-indigo-200 group">
                                <svg class="w-5 h-5 mr-2 group-hover:rotate-90 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Ajouter un élève
                            </a>
                        </div>
                    </div>

                    <!-- Quick Filters modernisés -->
                    <div class="mt-6 flex flex-wrap gap-2 items-center">
                        <span class="text-sm font-semibold text-gray-600 mr-2">Filtres rapides:</span>

                        <a href="{{ route('admin.eleves.index', array_merge(request()->except(['statut', 'page']), ['statut' => 1])) }}" 
                           class="inline-flex items-center px-4 py-2 rounded-xl text-xs font-medium transition-all duration-200 group
                                  {{ request('statut') == '1' ? 'bg-gradient-to-r from-green-600 to-green-700 text-white shadow-md' : 'bg-green-50 text-green-700 border border-green-200 hover:bg-green-100' }}">
                            <span class="w-2 h-2 {{ request('statut') == '1' ? 'bg-white' : 'bg-green-500' }} rounded-full mr-2 animate-pulse"></span>
                            Actifs
                            <span class="ml-2 px-1.5 py-0.5 rounded-full {{ request('statut') == '1' ? 'bg-green-500' : 'bg-green-200' }} text-xs">{{ $stats['actifs'] }}</span>
                        </a>

                        <a href="{{ route('admin.eleves.index', array_merge(request()->except(['statut', 'page']), ['statut' => 0])) }}" 
                           class="inline-flex items-center px-4 py-2 rounded-xl text-xs font-medium transition-all duration-200 group
                                  {{ request('statut') == '0' ? 'bg-gradient-to-r from-red-600 to-red-700 text-white shadow-md' : 'bg-red-50 text-red-700 border border-red-200 hover:bg-red-100' }}">
                            <span class="w-2 h-2 {{ request('statut') == '0' ? 'bg-white' : 'bg-red-500' }} rounded-full mr-2"></span>
                            Inactifs
                            <span class="ml-2 px-1.5 py-0.5 rounded-full {{ request('statut') == '0' ? 'bg-red-500' : 'bg-red-200' }} text-xs">{{ $stats['inactifs'] }}</span>
                        </a>

                        <a href="{{ route('admin.eleves.index', array_merge(request()->except(['genre', 'page']), ['genre' => 'm'])) }}" 
                           class="inline-flex items-center px-4 py-2 rounded-xl text-xs font-medium transition-all duration-200 group
                                  {{ request('genre') == 'm' ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-md' : 'bg-blue-50 text-blue-700 border border-blue-200 hover:bg-blue-100' }}">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            Garçons
                            <span class="ml-2 px-1.5 py-0.5 rounded-full {{ request('genre') == 'm' ? 'bg-blue-500' : 'bg-blue-200' }} text-xs">{{ $stats['garcons'] }}</span>
                        </a>

                        <a href="{{ route('admin.eleves.index', array_merge(request()->except(['genre', 'page']), ['genre' => 'f'])) }}" 
                           class="inline-flex items-center px-4 py-2 rounded-xl text-xs font-medium transition-all duration-200 group
                                  {{ request('genre') == 'f' ? 'bg-gradient-to-r from-pink-600 to-pink-700 text-white shadow-md' : 'bg-pink-50 text-pink-700 border border-pink-200 hover:bg-pink-100' }}">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            Filles
                            <span class="ml-2 px-1.5 py-0.5 rounded-full {{ request('genre') == 'f' ? 'bg-pink-500' : 'bg-pink-200' }} text-xs">{{ $stats['filles'] }}</span>
                        </a>

                        <a href="{{ route('admin.eleves.index', array_merge(request()->except(['avec_compte', 'page']), ['avec_compte' => 1])) }}" 
                           class="inline-flex items-center px-4 py-2 rounded-xl text-xs font-medium transition-all duration-200 group
                                  {{ request('avec_compte') == '1' ? 'bg-gradient-to-r from-purple-600 to-purple-700 text-white shadow-md' : 'bg-purple-50 text-purple-700 border border-purple-200 hover:bg-purple-100' }}">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Avec compte
                            <span class="ml-2 px-1.5 py-0.5 rounded-full {{ request('avec_compte') == '1' ? 'bg-purple-500' : 'bg-purple-200' }} text-xs">{{ $stats['avec_compte'] }}</span>
                        </a>

                        <a href="{{ route('admin.eleves.index', array_merge(request()->except(['avec_compte', 'page']), ['avec_compte' => 0])) }}" 
                           class="inline-flex items-center px-4 py-2 rounded-xl text-xs font-medium transition-all duration-200 group
                                  {{ request('avec_compte') == '0' ? 'bg-gradient-to-r from-gray-600 to-gray-700 text-white shadow-md' : 'bg-gray-50 text-gray-700 border border-gray-200 hover:bg-gray-100' }}">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                            Sans compte
                            <span class="ml-2 px-1.5 py-0.5 rounded-full {{ request('avec_compte') == '0' ? 'bg-gray-500' : 'bg-gray-200' }} text-xs">{{ $stats['sans_compte'] }}</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Students Table modernisé -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Matricule</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Photo</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nom & Prénom</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Contact</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date naiss.</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Genre</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Classe</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Statut</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Compte</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Inscription</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($eleves as $eleve)
                                @php
                                    // Récupérer la dernière inscription active
                                    $derniereInscription = $eleve->inscriptions->first();
                                    $classeActuelle = $derniereInscription ? $derniereInscription->classe : null;
                                @endphp
                                <tr class="group hover:bg-indigo-50/50 transition-all duration-200">
                                    <!-- Matricule (nouveau format) -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="bg-indigo-100 p-1.5 rounded-lg mr-2">
                                                <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                                                </svg>
                                            </div>
                                            <span class="px-3 py-1.5 bg-indigo-50 text-indigo-700 rounded-lg text-xs font-mono font-semibold border border-indigo-200">
                                                {{ $eleve->matricule }}
                                            </span>
                                        </div>
                                    </td>

                                    <!-- Photo -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($eleve->photo)
                                            <img class="h-12 w-12 rounded-xl object-cover border-2 border-indigo-200 group-hover:scale-110 transition-transform" 
                                                 src="{{ Storage::url($eleve->photo) }}" 
                                                 alt="{{ $eleve->prenom }}">
                                        @else
                                            <div class="h-12 w-12 rounded-xl bg-gradient-to-br from-indigo-100 to-indigo-200 flex items-center justify-center border-2 border-indigo-200 group-hover:scale-110 transition-transform">
                                                <span class="text-lg font-bold text-indigo-700">
                                                    {{ strtoupper(substr($eleve->prenom, 0, 1)) }}{{ strtoupper(substr($eleve->nom, 0, 1)) }}
                                                </span>
                                            </div>
                                        @endif
                                    </td>

                                    <!-- Nom & Prénom -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-semibold text-gray-900">{{ $eleve->nom }} {{ $eleve->prenom }}</div>
                                        <div class="text-xs text-gray-500 flex items-center mt-1">
                                            <svg class="w-3 h-3 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                            {{ $eleve->lieu_naissance }}
                                        </div>
                                    </td>

                                    <!-- Contact -->
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900 flex items-center">
                                            <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                            </svg>
                                            {{ $eleve->telephone ?? 'Non renseigné' }}
                                        </div>
                                        <div class="text-xs text-gray-500 truncate max-w-xs flex items-center mt-1">
                                            <svg class="w-3 h-3 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                            </svg>
                                            {{ $eleve->email ?? 'Non renseigné' }}
                                        </div>
                                    </td>

                                    <!-- Date naissance -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center text-sm text-gray-600">
                                            <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            {{ $eleve->date_naissance->format('d/m/Y') }}
                                        </div>
                                    </td>

                                    <!-- Genre -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($eleve->genre === 'm')
                                            <span class="px-3 py-1.5 inline-flex items-center text-xs font-semibold rounded-full bg-blue-100 text-blue-800 border border-blue-200">
                                                <span class="w-2 h-2 bg-blue-500 rounded-full mr-2"></span>
                                                Masculin
                                            </span>
                                        @else
                                            <span class="px-3 py-1.5 inline-flex items-center text-xs font-semibold rounded-full bg-pink-100 text-pink-800 border border-pink-200">
                                                <span class="w-2 h-2 bg-pink-500 rounded-full mr-2"></span>
                                                Féminin
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Classe (CORRIGÉ) -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($classeActuelle)
                                            <div class="flex items-center">
                                                <div class="bg-gradient-to-br from-indigo-100 to-indigo-200 p-1.5 rounded-lg mr-2">
                                                    <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <span class="text-sm font-semibold text-gray-900">{{ $classeActuelle->nom }}</span>
                                                    <div class="text-xs text-gray-500">
                                                        {{ $classeActuelle->niveau }} @if($classeActuelle->serie)({{ $classeActuelle->serie }})@endif
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-sm text-gray-400 flex items-center">
                                                <svg class="w-4 h-4 mr-1 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                                                </svg>
                                                Non assigné
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Statut -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($eleve->statut)
                                            <span class="px-3 py-1.5 inline-flex items-center text-xs font-semibold rounded-full bg-gradient-to-r from-green-400 to-emerald-500 text-white shadow-sm">
                                                <span class="w-2 h-2 bg-white rounded-full mr-2 animate-pulse"></span>
                                                Actif
                                            </span>
                                        @else
                                            <span class="px-3 py-1.5 inline-flex items-center text-xs font-semibold rounded-full bg-gradient-to-r from-red-400 to-red-500 text-white shadow-sm">
                                                <span class="w-2 h-2 bg-white rounded-full mr-2"></span>
                                                Inactif
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Compte utilisateur -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($eleve->user)
                                            <span class="px-3 py-1.5 inline-flex items-center text-xs font-semibold rounded-full bg-purple-100 text-purple-800 border border-purple-200">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                Oui
                                            </span>
                                        @else
                                            <span class="px-3 py-1.5 inline-flex items-center text-xs font-semibold rounded-full bg-gray-100 text-gray-600 border border-gray-200">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                                </svg>
                                                Non
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Date inscription -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center text-sm text-gray-600">
                                            <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            {{ $eleve->date_inscription->format('d/m/Y') }}
                                        </div>
                                    </td>

                                    <!-- Actions -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('admin.eleves.show', $eleve) }}" 
                                               class="p-2.5 bg-indigo-50 text-indigo-600 rounded-xl hover:bg-indigo-100 hover:scale-110 transition-all duration-200 shadow-sm"
                                               title="Voir détails">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </a>

                                            <a href="{{ route('admin.eleves.edit', $eleve) }}" 
                                               class="p-2.5 bg-amber-50 text-amber-600 rounded-xl hover:bg-amber-100 hover:scale-110 transition-all duration-200 shadow-sm"
                                               title="Modifier">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </a>

                                            <form action="{{ route('admin.eleves.destroy', $eleve) }}" method="POST" class="inline delete-form">
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

                                            @if(!$eleve->user)
                                                <a href="{{ route('admin.eleves.create-user', $eleve) }}" 
                                                   class="p-2.5 bg-green-50 text-green-600 rounded-xl hover:bg-green-100 hover:scale-110 transition-all duration-200 shadow-sm"
                                                   title="Créer un compte utilisateur"
                                                   onclick="event.preventDefault(); document.getElementById('create-user-{{ $eleve->id }}').submit();">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                                    </svg>
                                                </a>
                                                <form id="create-user-{{ $eleve->id }}" action="{{ route('admin.eleves.create-user', $eleve) }}" method="POST" style="display: none;">
                                                    @csrf
                                                    <input type="hidden" name="password" value="password123">
                                                    <input type="hidden" name="password_confirmation" value="password123">
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" class="px-6 py-16">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="w-20 h-20 bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl flex items-center justify-center mb-4">
                                                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                                </svg>
                                            </div>
                                            <h4 class="text-lg font-bold text-gray-800 mb-2">Aucun élève trouvé</h4>
                                            <p class="text-gray-500 text-center mb-6">Commencez par ajouter un nouvel élève</p>
                                            <a href="{{ route('admin.eleves.create') }}" 
                                               class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white text-sm font-medium rounded-xl hover:from-indigo-700 hover:to-indigo-800 transition-all duration-200 shadow-lg shadow-indigo-200">
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                </svg>
                                                Ajouter un élève
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination modernisée -->
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-t border-gray-200">
                    <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                        <div class="text-sm text-gray-600 flex items-center">
                            <svg class="w-5 h-5 text-indigo-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            @if($eleves->total() > 0)
                                Affichage de <span class="font-semibold text-indigo-600">{{ $eleves->firstItem() }}</span> à 
                                <span class="font-semibold text-indigo-600">{{ $eleves->lastItem() }}</span> sur 
                                <span class="font-semibold text-indigo-600">{{ $eleves->total() }}</span> résultats
                            @else
                                Aucun résultat
                            @endif
                        </div>

                        <div class="flex items-center gap-1">
                            {{ $eleves->appends(request()->query())->links('pagination::tailwind') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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

        .group:hover .group-hover\:-translate-x-1 {
            transform: translateX(-4px);
        }

        .group:hover .group-hover\:animate-bounce {
            animation: bounce 1s infinite;
        }

        @keyframes bounce {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-5px);
            }
        }

        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.5;
            }
        }

        .animate-pulse {
            animation: pulse 2s infinite;
        }

        @keyframes slide-down {
            0% {
                opacity: 0;
                transform: translateY(-10px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-slide-down {
            animation: slide-down 0.3s ease-out;
        }

        /* Transition pour toutes les animations */
        .transition {
            transition: all 0.3s ease-in-out;
        }

        /* Animation de disparition des messages flash */
        .alert {
            transition: opacity 0.5s ease-in-out;
        }
    </style>
    @endpush

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animation de disparition des messages flash
        const flashMessages = document.querySelectorAll('.alert');
        flashMessages.forEach(function(message) {
            setTimeout(function() {
                message.style.opacity = '0';
                setTimeout(function() {
                    message.remove();
                }, 500);
            }, 5000);
        });

        // Gestionnaire pour le raccourci clavier (⌘K)
        document.addEventListener('keydown', function(e) {
            if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
                e.preventDefault();
                document.querySelector('input[name="search"]').focus();
            }
        });

        // Confirmation de suppression avec SweetAlert2
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Êtes-vous sûr ?',
                    text: "Cette action est irréversible ! L'élève sera définitivement supprimé.",
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
    });
    </script>
    @endpush
@endsection