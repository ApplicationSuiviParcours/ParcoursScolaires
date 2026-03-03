{{-- resources/views/admin/classes/show.blade.php --}}
@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Détails de la Classe') }}
    </h2>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <!-- Messages flash -->
        @if(session('success'))
            <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-r-lg shadow-md animate-slideDown" role="alert">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-r-lg shadow-md animate-slideDown" role="alert">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <!-- En-tête avec infos classe - Design moderne -->
        <div class="bg-white rounded-2xl shadow-xl mb-8 overflow-hidden border border-gray-100">
            <!-- Bannière dégradée -->
            <div class="relative bg-gradient-to-r from-indigo-600 via-indigo-700 to-purple-700 px-8 py-6">
                <!-- Éléments décoratifs -->
                <div class="absolute inset-0 bg-gradient-to-r from-white/10 to-transparent"></div>
                <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -translate-y-32 translate-x-32"></div>
                <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/5 rounded-full translate-y-24 -translate-x-24"></div>
                
                <div class="relative flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                    <div class="flex items-center space-x-4">
                        <div class="bg-white/20 p-3 rounded-xl backdrop-blur-sm">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="flex items-center gap-3 mb-1">
                                <h3 class="text-3xl font-bold text-white">{{ $classe->nom }}</h3>
                                <span class="px-3 py-1 bg-white/20 backdrop-blur-sm rounded-full text-white text-xs font-semibold">
                                    ID: {{ $classe->id }}
                                </span>
                            </div>
                            <div class="flex flex-wrap items-center gap-4 text-indigo-100">
                                <span class="flex items-center text-sm">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                    Niveau: <span class="font-semibold ml-1 text-white">{{ $classe->niveau }}</span>
                                </span>
                                
                                @if($classe->serie)
                                    <span class="flex items-center text-sm">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l5 5a2 2 0 01.586 1.414V19a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z"></path>
                                        </svg>
                                        Série: <span class="font-semibold ml-1 text-white">{{ $classe->serie }}</span>
                                    </span>
                                @endif
                                
                                @if($classe->anneeScolaire)
                                    <span class="flex items-center text-sm">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        {{ $classe->anneeScolaire->nom }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-3">
                        <!-- Bouton PDF -->
                        <a href="{{ route('admin.classes.pdf', $classe) }}" 
                           class="inline-flex items-center px-4 py-2.5 bg-red-500 hover:bg-red-600 text-white rounded-xl transition-all duration-200 transform hover:scale-105 shadow-lg group"
                           title="Télécharger PDF">
                            <svg class="w-5 h-5 mr-2 group-hover:animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path>
                            </svg>
                            <span class="text-sm font-medium">PDF</span>
                        </a>
                        
                        <!-- Bouton Modifier -->
                        <a href="{{ route('admin.classes.edit', $classe) }}" 
                           class="inline-flex items-center px-4 py-2.5 bg-amber-500 hover:bg-amber-600 text-white rounded-xl transition-all duration-200 transform hover:scale-105 shadow-lg group">
                            <svg class="w-5 h-5 mr-2 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            <span class="text-sm font-medium">Modifier</span>
                        </a>
                        
                        <!-- Bouton Retour -->
                        <a href="{{ route('admin.classes.index') }}" 
                           class="inline-flex items-center px-4 py-2.5 bg-gray-600 hover:bg-gray-700 text-white rounded-xl transition-all duration-200 transform hover:scale-105 shadow-lg group">
                            <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            <span class="text-sm font-medium">Retour</span>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Cartes statistiques modernes -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 p-6 bg-gradient-to-br from-gray-50 to-white">
                <!-- Total élèves -->
                <div class="group bg-white rounded-xl shadow-md p-5 border-l-4 border-indigo-500 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Total élèves</p>
                            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $inscriptions->count() }}</p>
                            <p class="text-xs text-gray-400 mt-1">Inscrits</p>
                        </div>
                        <div class="bg-indigo-100 p-3 rounded-lg group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-3 h-1 w-full bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full w-3/4 bg-indigo-500 rounded-full"></div>
                    </div>
                </div>

                <!-- Places disponibles -->
                <div class="group bg-white rounded-xl shadow-md p-5 border-l-4 border-emerald-500 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Places disponibles</p>
                            <p class="text-2xl font-bold text-gray-800 mt-1">{{ max(0, $classe->capacite - $inscriptions->count()) }}</p>
                            <p class="text-xs text-gray-400 mt-1">Sur {{ $classe->capacite }}</p>
                        </div>
                        <div class="bg-emerald-100 p-3 rounded-lg group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-3 h-1 w-full bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full w-2/3 bg-emerald-500 rounded-full"></div>
                    </div>
                </div>

                <!-- Taux d'occupation -->
                <div class="group bg-white rounded-xl shadow-md p-5 border-l-4 border-amber-500 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Taux d'occupation</p>
                            @php $taux = $classe->capacite > 0 ? round(($inscriptions->count() / $classe->capacite) * 100) : 0; @endphp
                            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $taux }}%</p>
                            <p class="text-xs text-gray-400 mt-1">Moyenne</p>
                        </div>
                        <div class="bg-amber-100 p-3 rounded-lg group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-3 h-1 w-full bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full bg-amber-500 rounded-full" style="width: {{ $taux }}%"></div>
                    </div>
                </div>

                <!-- Élèves actifs -->
                <div class="group bg-white rounded-xl shadow-md p-5 border-l-4 border-purple-500 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Élèves actifs</p>
                            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $inscriptions->where('statut', true)->count() }}</p>
                            <p class="text-xs text-gray-400 mt-1">En cours</p>
                        </div>
                        <div class="bg-purple-100 p-3 rounded-lg group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-3 h-1 w-full bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full w-4/5 bg-purple-500 rounded-full"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Liste des élèves inscrits avec design moderne -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
            <!-- En-tête de la section -->
            <div class="bg-gradient-to-r from-gray-50 to-white px-6 py-5 border-b border-gray-200">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <div class="bg-gradient-to-br from-indigo-100 to-indigo-200 p-2.5 rounded-xl">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-gray-800">Liste des élèves inscrits</h4>
                            <p class="text-sm text-gray-500">Gérez les inscriptions des élèves dans cette classe</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-3">
                        <!-- PDF des élèves -->
                        <a href="{{ route('admin.classes.eleves-pdf', $classe) }}" 
                           class="inline-flex items-center px-4 py-2 bg-red-50 text-red-600 rounded-xl hover:bg-red-100 transition-all duration-200 text-sm font-medium group">
                            <svg class="w-5 h-5 mr-2 group-hover:animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path>
                            </svg>
                            PDF Liste
                        </a>
                        
                        <!-- Bouton pour inscrire un élève -->
                        @if(Route::has('admin.inscriptions.create'))
                        <a href="{{ route('admin.inscriptions.create', ['classe_id' => $classe->id]) }}" 
                           class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 text-white rounded-xl transition-all duration-200 text-sm font-medium shadow-lg shadow-indigo-200 group">
                            <svg class="w-5 h-5 mr-2 group-hover:rotate-90 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Inscrire un élève
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Tableau des élèves -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Photo</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                <div class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                                    </svg>
                                    <span>Matricule</span>
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nom</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Prénom</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Classe</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date naiss.</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Genre</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Téléphone</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date inscription</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Statut</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($inscriptions as $inscription)
                            @if($inscription->eleve)
                                <tr class="group hover:bg-indigo-50/50 transition-all duration-200">
                                    <!-- Photo -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($inscription->eleve->photo)
                                            <img class="h-10 w-10 rounded-xl object-cover border-2 border-indigo-200 group-hover:scale-110 transition-transform" 
                                                 src="{{ Storage::url($inscription->eleve->photo) }}" 
                                                 alt="{{ $inscription->eleve->prenom }}">
                                        @else
                                            <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-indigo-100 to-indigo-200 flex items-center justify-center border-2 border-indigo-200 group-hover:scale-110 transition-transform">
                                                <span class="text-sm font-bold text-indigo-700">
                                                    {{ strtoupper(substr($inscription->eleve->prenom, 0, 1)) }}{{ strtoupper(substr($inscription->eleve->nom, 0, 1)) }}
                                                </span>
                                            </div>
                                        @endif
                                    </td>
                                    
                                    <!-- Matricule -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1.5 bg-indigo-50 text-indigo-700 rounded-lg text-xs font-mono font-semibold border border-indigo-200">
                                            {{ $inscription->eleve->matricule ?? '-' }}
                                        </span>
                                    </td>
                                    
                                    <!-- Nom -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-semibold text-gray-900">{{ $inscription->eleve->nom ?? '-' }}</div>
                                    </td>
                                    
                                    <!-- Prénom -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-700">{{ $inscription->eleve->prenom ?? '-' }}</div>
                                    </td>
                                    
                                    <!-- Classe -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="bg-gradient-to-br from-indigo-100 to-indigo-200 p-1.5 rounded-lg mr-2">
                                                <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <span class="text-sm font-semibold text-gray-900">{{ $classe->nom }}</span>
                                                <div class="text-xs text-gray-500">
                                                    {{ $classe->niveau }} @if($classe->serie)- {{ $classe->serie }}@endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <!-- Date naissance -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-600">
                                            {{ $inscription->eleve->date_naissance ? $inscription->eleve->date_naissance->format('d/m/Y') : '-' }}
                                        </div>
                                    </td>
                                    
                                    <!-- Genre -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($inscription->eleve->genre == 'm')
                                            <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full bg-blue-100 text-blue-800 border border-blue-200">
                                                <span class="w-2 h-2 bg-blue-500 rounded-full mr-2 mt-1"></span>
                                                Masculin
                                            </span>
                                        @elseif($inscription->eleve->genre == 'f')
                                            <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full bg-pink-100 text-pink-800 border border-pink-200">
                                                <span class="w-2 h-2 bg-pink-500 rounded-full mr-2 mt-1"></span>
                                                Féminin
                                            </span>
                                        @else
                                            <span class="text-sm text-gray-400">-</span>
                                        @endif
                                    </td>
                                    
                                    <!-- Téléphone -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-600">{{ $inscription->eleve->telephone ?? '-' }}</div>
                                    </td>
                                    
                                    <!-- Date inscription -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-600">
                                            {{ $inscription->date_inscription ? $inscription->date_inscription->format('d/m/Y') : '-' }}
                                        </div>
                                    </td>
                                    
                                    <!-- Statut -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($inscription->statut)
                                            <span class="px-3 py-1 inline-flex items-center text-xs font-semibold rounded-full bg-gradient-to-r from-green-400 to-emerald-500 text-white shadow-sm">
                                                <span class="w-2 h-2 bg-white rounded-full mr-2 animate-pulse"></span>
                                                Actif
                                            </span>
                                        @else
                                            <span class="px-3 py-1 inline-flex items-center text-xs font-semibold rounded-full bg-gradient-to-r from-red-400 to-red-500 text-white shadow-sm">
                                                <span class="w-2 h-2 bg-white rounded-full mr-2"></span>
                                                Inactif
                                            </span>
                                        @endif
                                    </td>
                                    
                                    <!-- Actions -->
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('admin.eleves.show', $inscription->eleve) }}" 
                                               class="p-2 bg-indigo-50 text-indigo-600 rounded-lg hover:bg-indigo-100 hover:scale-110 transition-all duration-200"
                                               title="Voir détails">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </a>
                                            
                                            <a href="{{ route('admin.eleves.edit', $inscription->eleve) }}" 
                                               class="p-2 bg-amber-50 text-amber-600 rounded-lg hover:bg-amber-100 hover:scale-110 transition-all duration-200"
                                               title="Modifier">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </a>
                                            
                                            @if(Route::has('admin.inscriptions.toggle-status'))
                                            <form action="{{ route('admin.inscriptions.toggle-status', $inscription) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" 
                                                        class="p-2 {{ $inscription->statut ? 'bg-red-50 text-red-600 hover:bg-red-100' : 'bg-green-50 text-green-600 hover:bg-green-100' }} rounded-lg hover:scale-110 transition-all duration-200"
                                                        title="{{ $inscription->statut ? 'Désactiver' : 'Activer' }}">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        @if($inscription->statut)
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                                                        @else
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        @endif
                                                    </svg>
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="11" class="px-6 py-16">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-20 h-20 bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl flex items-center justify-center mb-4">
                                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                            </svg>
                                        </div>
                                        <h4 class="text-lg font-bold text-gray-800 mb-2">Aucun élève inscrit</h4>
                                        <p class="text-gray-500 text-center mb-6">Cette classe n'a pas encore d'élèves inscrits</p>
                                        @if(Route::has('admin.inscriptions.create'))
                                        <a href="{{ route('admin.inscriptions.create', ['classe_id' => $classe->id]) }}" 
                                           class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white text-sm font-medium rounded-xl hover:from-indigo-700 hover:to-indigo-800 transition-all duration-200 shadow-lg shadow-indigo-200">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                            </svg>
                                            Inscrire un élève
                                        </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pied de tableau -->
            @if($inscriptions->count() > 0)
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-600 flex items-center">
                        <svg class="w-5 h-5 text-indigo-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Total: <span class="font-semibold text-indigo-600">{{ $inscriptions->count() }}</span> élève(s) inscrit(s)</span>
                    </div>
                    <div class="text-sm text-gray-600">
                        <span class="font-semibold text-green-600">{{ $inscriptions->where('statut', true)->count() }}</span> actif(s) · 
                        <span class="font-semibold text-red-600">{{ $inscriptions->where('statut', false)->count() }}</span> inactif(s)
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Animations */
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
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

    .animate-slideIn {
        animation: slideIn 0.5s ease-out;
    }

    .animate-slideDown {
        animation: slideDown 0.3s ease-out;
    }

    .hover\:scale-105:hover {
        transform: scale(1.05);
    }

    .hover\:scale-110:hover {
        transform: scale(1.1);
    }

    .group:hover .group-hover\:scale-110 {
        transform: scale(1.1);
    }

    .group:hover .group-hover\:rotate-12 {
        transform: rotate(12deg);
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

    /* Transition pour toutes les animations */
    .transition {
        transition: all 0.3s ease-in-out;
    }
</style>
@endpush
@endsection