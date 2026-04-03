@extends('layouts.app')

@section('title', 'Gestion des parents')

@section('header')
<div class="relative overflow-hidden bg-gradient-to-br from-purple-600 via-purple-700 to-indigo-800 py-10 sm:py-12">
    <!-- Éléments décoratifs animés -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute -top-24 -right-24 w-64 sm:w-96 h-64 sm:h-96 bg-white rounded-full mix-blend-overlay filter blur-3xl animate-pulse"></div>
        <div class="absolute -bottom-24 -left-24 w-64 sm:w-96 h-64 sm:h-96 bg-indigo-300 rounded-full mix-blend-overlay filter blur-3xl animate-pulse delay-1000"></div>
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
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-white mb-2 animate-fade-in-up">
                    Gestion des parents
                </h1>
                <p class="text-purple-200 text-sm sm:text-base md:text-lg animate-fade-in-up animation-delay-200">
                    Gérez les parents et tuteurs des élèves
                </p>
            </div>
            <div class="flex justify-center md:justify-end animate-fade-in-right">
                <a href="{{ route('admin.parents.create') }}"
                   class="group relative inline-flex items-center px-4 sm:px-6 py-2.5 sm:py-3
                          bg-white/20 backdrop-blur-lg hover:bg-white/30 text-white font-semibold
                          rounded-xl transition-all duration-300 transform hover:scale-105
                          border border-white/30 text-sm sm:text-base">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-1.5 sm:mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                    Nouveau parent
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

    {{-- ── STATISTIQUES ─────────────────────────────────────────────
         xs/sm → 2 colonnes
         lg    → 4 colonnes
    ──────────────────────────────────────────────────────────────── --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6 sm:mb-8">

        <!-- Total parents -->
        <div class="bg-white rounded-2xl shadow-lg p-4 sm:p-6 border-l-4 border-purple-500 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div class="min-w-0">
                    <p class="text-xs sm:text-sm text-gray-500 font-medium uppercase tracking-wider leading-tight">Total parents</p>
                    <p class="text-2xl sm:text-3xl font-bold text-gray-800 mt-1">{{ $stats['total'] ?? $parents->total() }}</p>
                    <p class="text-xs text-gray-500 mt-1 hidden sm:block">Tous les parents inscrits</p>
                </div>
                <div class="bg-purple-100 rounded-xl p-2 sm:p-3 flex-shrink-0 ml-2">
                    <svg class="w-6 h-6 sm:w-8 sm:h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-3 flex items-center text-xs flex-wrap gap-1">
                <span class="text-green-600 font-medium">+{{ $stats['actifs'] ?? 0 }} actifs</span>
                <span class="text-gray-400">•</span>
                <span class="text-red-600 font-medium">{{ $stats['inactifs'] ?? 0 }} inactifs</span>
            </div>
        </div>

        <!-- Avec compte -->
        <div class="bg-white rounded-2xl shadow-lg p-4 sm:p-6 border-l-4 border-green-500 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div class="min-w-0">
                    <p class="text-xs sm:text-sm text-gray-500 font-medium uppercase tracking-wider leading-tight">Avec compte</p>
                    <p class="text-2xl sm:text-3xl font-bold text-gray-800 mt-1">{{ $stats['avec_compte'] ?? $parents->where('user_id', '!=', null)->count() }}</p>
                    <p class="text-xs text-gray-500 mt-1 hidden sm:block">Ont un compte utilisateur</p>
                </div>
                <div class="bg-green-100 rounded-xl p-2 sm:p-3 flex-shrink-0 ml-2">
                    <svg class="w-6 h-6 sm:w-8 sm:h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-3 w-full bg-gray-200 rounded-full h-1.5 sm:h-2">
                @php $pourcentageCompte = ($stats['total'] ?? 1) > 0 ? round((($stats['avec_compte'] ?? 0) / ($stats['total'] ?? 1)) * 100) : 0; @endphp
                <div class="bg-green-500 h-full rounded-full" style="width: {{ $pourcentageCompte }}%"></div>
            </div>
        </div>

        <!-- Avec enfants -->
        <div class="bg-white rounded-2xl shadow-lg p-4 sm:p-6 border-l-4 border-blue-500 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div class="min-w-0">
                    <p class="text-xs sm:text-sm text-gray-500 font-medium uppercase tracking-wider leading-tight">Avec enfants</p>
                    <p class="text-2xl sm:text-3xl font-bold text-gray-800 mt-1">{{ $stats['avec_enfants'] ?? $parents->filter(fn($p) => $p->eleves()->count() > 0)->count() }}</p>
                    <p class="text-xs text-gray-500 mt-1 hidden sm:block">Ont des enfants inscrits</p>
                </div>
                <div class="bg-blue-100 rounded-xl p-2 sm:p-3 flex-shrink-0 ml-2">
                    <svg class="w-6 h-6 sm:w-8 sm:h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-2 flex items-center text-xs text-gray-600 gap-1">
                <svg class="w-3.5 h-3.5 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
                <span class="truncate">Moy. {{ $stats['moyenne_enfants'] ?? '2.3' }} enfants</span>
            </div>
        </div>

        <!-- Sans compte -->
        <div class="bg-white rounded-2xl shadow-lg p-4 sm:p-6 border-l-4 border-yellow-500 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div class="min-w-0">
                    <p class="text-xs sm:text-sm text-gray-500 font-medium uppercase tracking-wider leading-tight">Sans compte</p>
                    <p class="text-2xl sm:text-3xl font-bold text-gray-800 mt-1">{{ $stats['inactifs'] ?? $parents->where('user_id', null)->count() }}</p>
                    <p class="text-xs text-gray-500 mt-1 hidden sm:block">N'ont pas de compte</p>
                </div>
                <div class="bg-yellow-100 rounded-xl p-2 sm:p-3 flex-shrink-0 ml-2">
                    <svg class="w-6 h-6 sm:w-8 sm:h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-3 sm:mt-4">
                <a href="#" class="text-xs sm:text-sm text-purple-600 hover:text-purple-800 font-medium">
                    + Créer des comptes →
                </a>
            </div>
        </div>
    </div>

    {{-- ── FILTRES ──────────────────────────────────────────────────── --}}
    <div class="bg-white rounded-2xl shadow-lg p-4 sm:p-6 mb-6 sm:mb-8" x-data="{ filters: false }">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-base sm:text-lg font-semibold text-gray-800 flex items-center gap-2">
                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-purple-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                </svg>
                Recherche et filtres
            </h2>
            <button @click="filters = !filters" class="text-purple-600 hover:text-purple-800 p-1">
                <svg class="w-4 h-4 sm:w-5 sm:h-5 transition-transform duration-300" :class="{ 'rotate-180': filters }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
        </div>

        <form method="GET" action="{{ route('admin.parents.index') }}" class="space-y-4">
            <!-- Recherche principale : empilée sur mobile, en ligne sur md+ -->
            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
                <div class="flex-1 relative">
                    <div class="absolute inset-y-0 left-0 pl-3 sm:pl-4 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 sm:h-5 sm:w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input type="text"
                           name="search"
                           value="{{ $search ?? '' }}"
                           placeholder="Rechercher par nom, prénom, téléphone, email..."
                           class="w-full pl-10 sm:pl-12 pr-4 py-2.5 sm:py-3 rounded-xl border-2 border-gray-200
                                  focus:border-purple-500 focus:ring-2 focus:ring-purple-200
                                  transition-all duration-300 text-sm">
                </div>
                <button type="submit"
                        class="inline-flex items-center justify-center px-6 sm:px-8 py-2.5 sm:py-3
                               bg-gradient-to-r from-purple-600 to-indigo-600
                               hover:from-purple-700 hover:to-indigo-700
                               text-white font-semibold rounded-xl
                               transition-all duration-300 transform hover:scale-105 hover:shadow-lg text-sm">
                    Rechercher
                </button>
            </div>

            <!-- Filtres avancés : 1 col mobile → 2 col sm → 4 col md -->
            <div x-show="filters" x-transition.duration.300ms
                 class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3 sm:gap-4 pt-3 sm:pt-4">
                <div>
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5">Statut du compte</label>
                    <select name="statut"
                            class="w-full px-3 py-2 sm:py-2.5 rounded-xl border-2 border-gray-200
                                   focus:border-purple-500 focus:ring-2 focus:ring-purple-200 text-sm">
                        <option value="">Tous</option>
                        <option value="1" {{ request('statut') === '1' ? 'selected' : '' }}>Avec compte</option>
                        <option value="0" {{ request('statut') === '0' ? 'selected' : '' }}>Sans compte</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5">Genre</label>
                    <select name="genre"
                            class="w-full px-3 py-2 sm:py-2.5 rounded-xl border-2 border-gray-200
                                   focus:border-purple-500 focus:ring-2 focus:ring-purple-200 text-sm">
                        <option value="">Tous</option>
                        <option value="m" {{ request('genre') === 'm' ? 'selected' : '' }}>Masculin</option>
                        <option value="f" {{ request('genre') === 'f' ? 'selected' : '' }}>Féminin</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5">Nombre d'enfants</label>
                    <select name="enfants"
                            class="w-full px-3 py-2 sm:py-2.5 rounded-xl border-2 border-gray-200
                                   focus:border-purple-500 focus:ring-2 focus:ring-purple-200 text-sm">
                        <option value="">Tous</option>
                        <option value="0" {{ request('enfants') === '0' ? 'selected' : '' }}>Sans enfant</option>
                        <option value="1" {{ request('enfants') === '1' ? 'selected' : '' }}>1 enfant</option>
                        <option value="2" {{ request('enfants') === '2' ? 'selected' : '' }}>2 enfants</option>
                        <option value="3" {{ request('enfants') === '3' ? 'selected' : '' }}>3 enfants</option>
                        <option value="4" {{ request('enfants') === '4' ? 'selected' : '' }}>4+ enfants</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5">Profession</label>
                    <input type="text"
                           name="profession"
                           value="{{ request('profession') }}"
                           placeholder="Ex: Enseignant"
                           class="w-full px-3 py-2 sm:py-2.5 rounded-xl border-2 border-gray-200
                                  focus:border-purple-500 focus:ring-2 focus:ring-purple-200 text-sm">
                </div>
            </div>
        </form>
    </div>

    {{-- ── TABLEAU / CARTES ─────────────────────────────────────────── --}}
    <div class="bg-white rounded-2xl sm:rounded-3xl shadow-xl overflow-hidden">

        {{-- TABLEAU — visible sur lg+ --}}
        <div class="hidden lg:block overflow-x-auto">
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
                            {{-- Parent --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-12 w-12 {{ $parent->avatar_color }} rounded-xl flex items-center justify-center text-white font-bold text-lg shadow-lg group-hover:scale-110 transition-transform duration-300">
                                        {{ $parent->initiales }}
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-semibold text-gray-900 group-hover:text-purple-700 transition-colors duration-300">
                                            {{ $parent->full_name }}
                                        </div>
                                        <div class="flex items-center text-xs text-gray-500 mt-1 gap-2">
                                            <span class="bg-gray-100 rounded-full px-2 py-0.5">{{ $parent->genre_text }}</span>
                                            @if($parent->date_naissance)
                                                <span>{{ $parent->date_naissance->age }} ans</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                            {{-- Contact --}}
                            <td class="px-6 py-4">
                                <div class="space-y-1">
                                    @if($parent->telephone)
                                        <div class="flex items-center text-sm text-gray-600 gap-2">
                                            <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                            </svg>
                                            {{ $parent->telephone }}
                                        </div>
                                    @endif
                                    @if($parent->email)
                                        <div class="flex items-center text-sm text-gray-600 gap-2">
                                            <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                            </svg>
                                            {{ $parent->email }}
                                        </div>
                                    @endif
                                </div>
                            </td>
                            {{-- Informations --}}
                            <td class="px-6 py-4">
                                <div class="space-y-1 text-sm text-gray-600">
                                    @if($parent->profession)
                                        <div><span class="font-medium">Profession:</span> {{ $parent->profession }}</div>
                                    @endif
                                    @if($parent->lieu_naissance)
                                        <div><span class="font-medium">Né à:</span> {{ $parent->lieu_naissance }}</div>
                                    @endif
                                    @if($parent->adresse)
                                        <div class="flex items-start gap-1">
                                            <svg class="w-4 h-4 mt-0.5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                            <span class="truncate max-w-[150px]" title="{{ $parent->adresse }}">{{ $parent->adresse }}</span>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            {{-- Enfants --}}
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
                            {{-- Statut --}}
                            <td class="px-6 py-4">
                                <div class="space-y-1">
                                    @if($parent->hasUserAccount())
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-700">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                            Actif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-700">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
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
                            {{-- Actions --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-1 md:gap-2 whitespace-nowrap">
                                    <a href="{{ route('admin.parents.show', $parent) }}" class="p-1.5 md:p-2 text-blue-600 bg-transparent hover:bg-blue-50 rounded-lg transition-colors border-none" title="Voir">
                                        <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>
                                    <a href="{{ route('admin.parents.edit', $parent) }}" class="p-1.5 md:p-2 text-amber-600 bg-transparent hover:bg-amber-50 rounded-lg transition-colors border-none" title="Modifier">
                                        <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                    <form action="{{ route('admin.parents.destroy', $parent) }}" method="POST" class="inline m-0 p-0 delete-form" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce parent ?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-1.5 md:p-2 text-red-600 bg-transparent hover:bg-red-50 rounded-lg transition-colors border-none flex items-center justify-center cursor-pointer" title="Supprimer">
                                            <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                                @if($parent->notes)
                                    <div class="mt-2 text-xs text-gray-500 flex items-center gap-1" title="{{ $parent->notes }}">
                                        <svg class="w-3 h-3 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                                        </svg>
                                        <span class="truncate max-w-[100px]">{{ Str::limit($parent->notes, 20) }}</span>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center gap-4">
                                    <div class="w-20 h-20 bg-purple-100 rounded-full flex items-center justify-center animate-pulse">
                                        <svg class="w-10 h-10 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-800 mb-1">Aucun parent trouvé</h3>
                                        <p class="text-gray-500 text-sm max-w-md">
                                            @if(request()->anyFilled(['search','statut','genre','enfants','profession']))
                                                Aucun résultat ne correspond à vos critères.
                                                <a href="{{ route('admin.parents.index') }}" class="text-purple-600 font-medium block mt-1">Effacer les filtres</a>
                                            @else
                                                Commencez par ajouter un nouveau parent.
                                            @endif
                                        </p>
                                    </div>
                                    @if(!request()->anyFilled(['search','statut','genre','enfants','profession']))
                                        <a href="{{ route('admin.parents.create') }}"
                                           class="px-5 py-2.5 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-semibold rounded-xl transition-all duration-300 transform hover:scale-105 text-sm inline-flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
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

        {{-- CARTES — visible sur mobile/tablette (< lg) --}}
        <div class="lg:hidden divide-y divide-gray-100">
            @forelse($parents as $parent)
                <div class="p-4 hover:bg-purple-50/40 transition-colors duration-200">

                    {{-- Ligne 1 : Avatar + nom + statut --}}
                    <div class="flex items-start justify-between gap-3 mb-3">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="flex-shrink-0 h-11 w-11 {{ $parent->avatar_color }} rounded-xl flex items-center justify-center text-white font-bold shadow-md">
                                {{ $parent->initiales }}
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-gray-900 truncate">{{ $parent->full_name }}</p>
                                <div class="flex items-center text-xs text-gray-500 mt-0.5 gap-1.5 flex-wrap">
                                    <span class="bg-gray-100 rounded-full px-1.5 py-0.5">{{ $parent->genre_text }}</span>
                                    @if($parent->date_naissance)
                                        <span>{{ $parent->date_naissance->age }} ans</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        {{-- Badges statut --}}
                        <div class="flex flex-col gap-1 flex-shrink-0">
                            @if($parent->hasUserAccount())
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                    <svg class="w-3 h-3 mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    Actif
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700">
                                    Sans compte
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Ligne 2 : Méta — grille 2 col sur xs, 4 col sur sm --}}
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-x-3 gap-y-2 text-xs bg-gray-50 rounded-xl p-3 mb-3">
                        @if($parent->telephone)
                        <div>
                            <p class="text-gray-400 uppercase tracking-wide text-[10px] mb-0.5">Téléphone</p>
                            <p class="text-gray-700 font-medium">{{ $parent->telephone }}</p>
                        </div>
                        @endif
                        @if($parent->email)
                        <div class="col-span-1 sm:col-span-1">
                            <p class="text-gray-400 uppercase tracking-wide text-[10px] mb-0.5">Email</p>
                            <p class="text-gray-700 font-medium truncate">{{ $parent->email }}</p>
                        </div>
                        @endif
                        @if($parent->profession)
                        <div>
                            <p class="text-gray-400 uppercase tracking-wide text-[10px] mb-0.5">Profession</p>
                            <p class="text-gray-700 font-medium">{{ $parent->profession }}</p>
                        </div>
                        @endif
                        <div>
                            <p class="text-gray-400 uppercase tracking-wide text-[10px] mb-0.5">Enfants</p>
                            <p class="text-gray-700 font-medium">
                                {{ $parent->enfants_count }} enfant(s)
                                @if($parent->enfants_count > 0)
                                    <span class="text-gray-400 font-normal block">
                                        @foreach($parent->eleves->take(1) as $eleve)
                                            {{ $eleve->prenom }} {{ $eleve->nom }}
                                        @endforeach
                                        @if($parent->enfants_count > 1)
                                            +{{ $parent->enfants_count - 1 }} autre(s)
                                        @endif
                                    </span>
                                @endif
                            </p>
                        </div>
                    </div>

                    {{-- Ligne 3 : Actions --}}
                    <div class="flex items-center gap-2 pt-2 border-t border-gray-100">
                        <a href="{{ route('admin.parents.show', $parent) }}"
                           class="flex-1 inline-flex items-center justify-center gap-1.5 py-2 px-2
                                  bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white
                                  rounded-xl transition-all duration-300 text-xs font-medium">
                            <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            Voir
                        </a>
                        <a href="{{ route('admin.parents.edit', $parent) }}"
                           class="flex-1 inline-flex items-center justify-center gap-1.5 py-2 px-2
                                  bg-yellow-50 text-yellow-600 hover:bg-yellow-600 hover:text-white
                                  rounded-xl transition-all duration-300 text-xs font-medium">
                            <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Modifier
                        </a>
                        <form action="{{ route('admin.parents.destroy', $parent) }}" method="POST" class="flex-1 inline"
                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce parent ?');">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    class="w-full inline-flex items-center justify-center gap-1.5 py-2 px-2
                                           bg-red-50 text-red-600 hover:bg-red-600 hover:text-white
                                           rounded-xl transition-all duration-300 text-xs font-medium">
                                <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Supprimer
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="px-4 py-12 text-center">
                    <div class="flex flex-col items-center gap-4">
                        <div class="w-20 h-20 bg-purple-100 rounded-full flex items-center justify-center animate-pulse">
                            <svg class="w-10 h-10 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-800 mb-1">Aucun parent trouvé</h3>
                            <p class="text-gray-500 text-sm">
                                @if(request()->anyFilled(['search','statut','genre','enfants','profession']))
                                    Aucun résultat ne correspond à vos critères.
                                    <a href="{{ route('admin.parents.index') }}" class="text-purple-600 font-medium block mt-1">Effacer les filtres</a>
                                @else
                                    Commencez par ajouter un nouveau parent.
                                @endif
                            </p>
                        </div>
                        @if(!request()->anyFilled(['search','statut','genre','enfants','profession']))
                            <a href="{{ route('admin.parents.create') }}"
                               class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-semibold rounded-xl text-sm transition-all duration-300">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                Ajouter un parent
                            </a>
                        @endif
                    </div>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($parents->hasPages())
            <div class="px-4 sm:px-6 py-4 border-t border-gray-200 bg-gray-50">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 text-xs sm:text-sm text-gray-600">
                    <div>
                        Affichage de <span class="font-medium">{{ $parents->firstItem() }}</span> à
                        <span class="font-medium">{{ $parents->lastItem() }}</span> sur
                        <span class="font-medium">{{ $parents->total() }}</span> parents
                    </div>
                    <div class="overflow-x-auto">
                        {{ $parents->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>

    {{-- ── OPTIONS D'EXPORT ─────────────────────────────────────────── --}}
    <div class="mt-4 sm:mt-6 flex flex-wrap justify-end gap-2 sm:gap-3">
        <button class="inline-flex items-center px-4 py-2 bg-white border-2 border-gray-300 rounded-xl text-gray-700
                       hover:bg-gray-50 transition-all duration-300 transform hover:scale-105 text-sm">
            <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-1.5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
            </svg>
            Exporter CSV
        </button>
        <button class="inline-flex items-center px-4 py-2 bg-white border-2 border-gray-300 rounded-xl text-gray-700
                       hover:bg-gray-50 transition-all duration-300 transform hover:scale-105 text-sm">
            <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-1.5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
            </svg>
            Imprimer la liste
        </button>
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

    /* Hover lignes tableau */
    tbody tr { transition: all 0.3s ease; }
    @media (min-width: 1024px) {
        tbody tr:hover { background-color: rgba(139,92,246,.05); transform: translateX(5px); }
    }
</style>
@endpush