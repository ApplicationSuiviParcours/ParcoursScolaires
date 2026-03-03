@extends('layouts.app')

@section('title', 'Gestion des parents')

@section('header')
<div class="relative overflow-hidden bg-gradient-to-br from-purple-600 via-purple-700 to-indigo-800 py-12">
    <!-- Éléments décoratifs animés -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-white rounded-full mix-blend-overlay filter blur-3xl animate-pulse"></div>
        <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-indigo-300 rounded-full mix-blend-overlay filter blur-3xl animate-pulse delay-1000"></div>
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
                <h1 class="text-3xl md:text-4xl font-bold text-white mb-2 animate-fade-in-up">
                    Gestion des parents
                </h1>
                <p class="text-purple-200 text-base md:text-lg animate-fade-in-up animation-delay-200">
                    Gérez les parents et tuteurs des élèves
                </p>
            </div>
            <div class="mt-6 md:mt-0 flex justify-center md:justify-end animate-fade-in-right">
                <a href="{{ route('admin.parents.create') }}" 
                   class="group relative inline-flex items-center px-6 py-3 bg-white/20 backdrop-blur-lg hover:bg-white/30 text-white font-semibold rounded-xl transition-all duration-300 transform hover:scale-105 border border-white/30">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                    Nouveau parent
                </a>
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
    <!-- Statistiques rapides avec les données du contrôleur -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total parents -->
        <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-purple-500 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium uppercase tracking-wider">Total parents</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $stats['total'] ?? $parents->total() }}</p>
                    <p class="text-xs text-gray-500 mt-1">Tous les parents inscrits</p>
                </div>
                <div class="bg-purple-100 rounded-xl p-3">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <span class="text-green-600 font-medium">+{{ $stats['actifs'] ?? 0 }} actifs</span>
                <span class="text-gray-400 mx-2">•</span>
                <span class="text-red-600 font-medium">{{ $stats['inactifs'] ?? 0 }} inactifs</span>
            </div>
        </div>

        <!-- Avec compte -->
        <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-green-500 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium uppercase tracking-wider">Avec compte</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $stats['avec_compte'] ?? $parents->where('user_id', '!=', null)->count() }}</p>
                    <p class="text-xs text-gray-500 mt-1">Ont un compte utilisateur</p>
                </div>
                <div class="bg-green-100 rounded-xl p-3">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4 w-full bg-gray-200 rounded-full h-2">
                @php
                    $pourcentageCompte = $stats['total'] > 0 ? round(($stats['avec_compte'] / $stats['total']) * 100) : 0;
                @endphp
                <div class="bg-green-500 h-2 rounded-full" style="width: {{ $pourcentageCompte }}%"></div>
            </div>
        </div>

        <!-- Avec enfants -->
        <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-blue-500 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium uppercase tracking-wider">Avec enfants</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $stats['avec_enfants'] ?? $parents->filter(fn($p) => $p->eleves()->count() > 0)->count() }}</p>
                    <p class="text-xs text-gray-500 mt-1">Ont des enfants inscrits</p>
                </div>
                <div class="bg-blue-100 rounded-xl p-3">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-2 flex items-center text-sm text-gray-600">
                <svg class="w-4 h-4 mr-1 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
                <span>Moyenne de {{ $stats['moyenne_enfants'] ?? '2.3' }} enfants par parent</span>
            </div>
        </div>

        <!-- Sans compte -->
        <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-yellow-500 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium uppercase tracking-wider">Sans compte</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $stats['inactifs'] ?? $parents->where('user_id', null)->count() }}</p>
                    <p class="text-xs text-gray-500 mt-1">N'ont pas de compte</p>
                </div>
                <div class="bg-yellow-100 rounded-xl p-3">
                    <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <a href="#" class="text-sm text-purple-600 hover:text-purple-800 font-medium">
                    + Créer des comptes →
                </a>
            </div>
        </div>
    </div>

    <!-- Filtres avancés -->
    <div class="bg-white rounded-2xl shadow-lg p-6 mb-8" x-data="{ filters: false }">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                </svg>
                Recherche et filtres
            </h2>
            <button @click="filters = !filters" class="text-purple-600 hover:text-purple-800">
                <svg class="w-5 h-5" :class="{ 'rotate-180': filters }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
        </div>

        <form method="GET" action="{{ route('admin.parents.index') }}" class="space-y-4">
            <!-- Recherche principale -->
            <div class="flex flex-col md:flex-row gap-4">
                <div class="flex-1 relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" 
                           name="search" 
                           value="{{ $search ?? '' }}"
                           placeholder="Rechercher par nom, prénom, téléphone, email..."
                           class="w-full pl-12 pr-4 py-3 rounded-xl border-2 border-gray-200 focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition-all duration-300">
                </div>
                <button type="submit" 
                        class="px-8 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-semibold rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                    Rechercher
                </button>
            </div>

            <!-- Filtres avancés -->
            <div x-show="filters" x-transition.duration.300ms class="grid grid-cols-1 md:grid-cols-4 gap-4 pt-4">
                <!-- Filtre par statut -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Statut du compte</label>
                    <select name="statut" class="w-full rounded-xl border-2 border-gray-200 focus:border-purple-500 focus:ring-2 focus:ring-purple-200">
                        <option value="">Tous</option>
                        <option value="1" {{ request('statut') === '1' ? 'selected' : '' }}>Avec compte</option>
                        <option value="0" {{ request('statut') === '0' ? 'selected' : '' }}>Sans compte</option>
                    </select>
                </div>

                <!-- Filtre par genre -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Genre</label>
                    <select name="genre" class="w-full rounded-xl border-2 border-gray-200 focus:border-purple-500 focus:ring-2 focus:ring-purple-200">
                        <option value="">Tous</option>
                        <option value="m" {{ request('genre') === 'm' ? 'selected' : '' }}>Masculin</option>
                        <option value="f" {{ request('genre') === 'f' ? 'selected' : '' }}>Féminin</option>
                    </select>
                </div>

                <!-- Filtre par nombre d'enfants -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nombre d'enfants</label>
                    <select name="enfants" class="w-full rounded-xl border-2 border-gray-200 focus:border-purple-500 focus:ring-2 focus:ring-purple-200">
                        <option value="">Tous</option>
                        <option value="0" {{ request('enfants') === '0' ? 'selected' : '' }}>Sans enfant</option>
                        <option value="1" {{ request('enfants') === '1' ? 'selected' : '' }}>1 enfant</option>
                        <option value="2" {{ request('enfants') === '2' ? 'selected' : '' }}>2 enfants</option>
                        <option value="3" {{ request('enfants') === '3' ? 'selected' : '' }}>3 enfants</option>
                        <option value="4" {{ request('enfants') === '4' ? 'selected' : '' }}>4+ enfants</option>
                    </select>
                </div>

                <!-- Filtre par profession -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Profession</label>
                    <input type="text" 
                           name="profession" 
                           value="{{ request('profession') }}"
                           placeholder="Ex: Enseignant"
                           class="w-full rounded-xl border-2 border-gray-200 focus:border-purple-500 focus:ring-2 focus:ring-purple-200">
                </div>
            </div>
        </form>
    </div>

    <!-- Tableau des parents -->
    <div class="bg-white rounded-3xl shadow-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-purple-50 to-indigo-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-purple-700 uppercase tracking-wider">Parent</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-purple-700 uppercase tracking-wider">Contact</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-purple-700 uppercase tracking-wider">Informations</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-purple-700 uppercase tracking-wider">Enfants</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-purple-700 uppercase tracking-wider">Statut</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-purple-700 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($parents as $parent)
                        <tr class="hover:bg-purple-50/50 transition-colors duration-200 group">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-12 w-12 {{ $parent->avatar_color }} rounded-xl flex items-center justify-center text-white font-bold text-lg shadow-lg group-hover:scale-110 transition-transform duration-300">
                                        {{ $parent->initiales }}
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-semibold text-gray-900 group-hover:text-purple-700 transition-colors duration-300">
                                            {{ $parent->full_name }}
                                        </div>
                                        <div class="flex items-center text-xs text-gray-500 mt-1">
                                            <span class="bg-gray-100 rounded-full px-2 py-0.5">{{ $parent->genre_text }}</span>
                                            @if($parent->date_naissance)
                                                <span class="mx-2">•</span>
                                                <span>{{ $parent->date_naissance->age }} ans</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="space-y-1">
                                    @if($parent->telephone)
                                        <div class="flex items-center text-sm text-gray-600">
                                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                            </svg>
                                            {{ $parent->telephone }}
                                        </div>
                                    @endif
                                    @if($parent->email)
                                        <div class="flex items-center text-sm text-gray-600">
                                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                            </svg>
                                            {{ $parent->email }}
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="space-y-1">
                                    @if($parent->profession)
                                        <div class="text-sm text-gray-600">
                                            <span class="font-medium">Profession:</span> {{ $parent->profession }}
                                        </div>
                                    @endif
                                    @if($parent->lieu_naissance)
                                        <div class="text-sm text-gray-600">
                                            <span class="font-medium">Né à:</span> {{ $parent->lieu_naissance }}
                                        </div>
                                    @endif
                                    @if($parent->adresse)
                                        <div class="text-sm text-gray-600 flex items-start">
                                            <svg class="w-4 h-4 mr-1 mt-0.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                            <span class="truncate max-w-[150px]" title="{{ $parent->adresse }}">{{ $parent->adresse }}</span>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col space-y-1">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-700 w-fit">
                                        {{ $parent->enfants_count }} enfant(s)
                                    </span>
                                    @if($parent->enfants_count > 0)
                                        <div class="text-xs text-gray-500">
                                            @foreach($parent->eleves->take(2) as $eleve)
                                                <div class="truncate max-w-[150px]">{{ $eleve->prenom }} {{ $eleve->nom }}</div>
                                            @endforeach
                                            @if($parent->enfants_count > 2)
                                                <div class="text-purple-600">+{{ $parent->enfants_count - 2 }} autre(s)</div>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="space-y-1">
                                    @if($parent->hasUserAccount())
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-700">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            Actif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-700">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                            </svg>
                                            Sans compte
                                        </span>
                                    @endif
                                    @if($parent->statut !== null)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $parent->statut ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }} w-fit">
                                            {{ $parent->statut ? 'Actif' : 'Inactif' }}
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('admin.parents.show', $parent) }}" 
                                       class="p-2 bg-blue-100 text-blue-600 rounded-xl hover:bg-blue-600 hover:text-white transition-all duration-300 transform hover:scale-110"
                                       title="Voir détails">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>
                                    <a href="{{ route('admin.parents.edit', $parent) }}" 
                                       class="p-2 bg-yellow-100 text-yellow-600 rounded-xl hover:bg-yellow-600 hover:text-white transition-all duration-300 transform hover:scale-110"
                                       title="Modifier">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.parents.destroy', $parent) }}" 
                                          method="POST" 
                                          class="inline"
                                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce parent ? Cette action est irréversible.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="p-2 bg-red-100 text-red-600 rounded-xl hover:bg-red-600 hover:text-white transition-all duration-300 transform hover:scale-110"
                                                title="Supprimer">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                                @if($parent->notes)
                                    <div class="mt-2 text-xs text-gray-500 flex items-center" title="{{ $parent->notes }}">
                                        <svg class="w-3 h-3 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                                        </svg>
                                        <span class="truncate max-w-[100px]">Note: {{ Str::limit($parent->notes, 20) }}</span>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12">
                                <div class="flex flex-col items-center justify-center text-center">
                                    <div class="w-24 h-24 bg-purple-100 rounded-full flex items-center justify-center mb-4 animate-pulse">
                                        <svg class="w-12 h-12 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-bold text-gray-800 mb-2">Aucun parent trouvé</h3>
                                    <p class="text-gray-500 max-w-md mb-6">
                                        @if(request()->anyFilled(['search', 'statut', 'genre', 'enfants', 'profession']))
                                            Aucun résultat ne correspond à vos critères de recherche.
                                            <a href="{{ route('admin.parents.index') }}" class="text-purple-600 hover:text-purple-800 font-medium block mt-2">
                                                Effacer tous les filtres
                                            </a>
                                        @else
                                            Commencez par ajouter un nouveau parent.
                                        @endif
                                    </p>
                                    @if(!request()->anyFilled(['search', 'statut', 'genre', 'enfants', 'profession']))
                                        <a href="{{ route('admin.parents.create') }}" 
                                           class="px-6 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-semibold rounded-xl transition-all duration-300 transform hover:scale-105">
                                            <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                            </svg>
                                            Ajouter un parent
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Informations de pagination -->
        @if($parents->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 flex items-center justify-between">
                <div class="text-sm text-gray-600">
                    Affichage de <span class="font-medium">{{ $parents->firstItem() }}</span> à 
                    <span class="font-medium">{{ $parents->lastItem() }}</span> sur 
                    <span class="font-medium">{{ $parents->total() }}</span> parents
                </div>
                <div class="flex items-center space-x-2">
                    {{ $parents->withQueryString()->links() }}
                </div>
            </div>
        @endif
    </div>

    <!-- Export options -->
    <div class="mt-6 flex justify-end space-x-3">
        <button class="px-4 py-2 bg-white border-2 border-gray-300 rounded-xl text-gray-700 hover:bg-gray-50 transition-all duration-300 transform hover:scale-105 flex items-center">
            <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
            </svg>
            Exporter CSV
        </button>
        <button class="px-4 py-2 bg-white border-2 border-gray-300 rounded-xl text-gray-700 hover:bg-gray-50 transition-all duration-300 transform hover:scale-105 flex items-center">
            <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
            </svg>
            Imprimer la liste
        </button>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

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

    /* Animation pour les lignes du tableau */
    tbody tr {
        transition: all 0.3s ease;
    }
    
    tbody tr:hover {
        background-color: rgba(139, 92, 246, 0.05);
        transform: translateX(5px);
    }

    /* Style pour la pagination */
    .pagination {
        display: flex;
        gap: 0.5rem;
    }
    
    .pagination .page-item .page-link {
        padding: 0.5rem 1rem;
        border-radius: 0.75rem;
        border: 2px solid #e5e7eb;
        color: #4b5563;
        transition: all 0.3s ease;
    }
    
    .pagination .page-item.active .page-link {
        background: linear-gradient(to right, #8b5cf6, #6366f1);
        color: white;
        border-color: transparent;
    }
    
    .pagination .page-item .page-link:hover {
        border-color: #8b5cf6;
        transform: scale(1.05);
    }
</style>
@endpush