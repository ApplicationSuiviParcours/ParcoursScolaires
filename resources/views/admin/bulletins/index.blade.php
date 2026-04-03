@extends('layouts.app')

@section('title', 'Gestion des bulletins')

@section('header')
<div class="relative overflow-hidden bg-gradient-to-br from-purple-600 via-purple-700 to-indigo-800 py-8 md:py-12">
    <!-- Éléments décoratifs animés -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-white rounded-full mix-blend-overlay filter blur-3xl animate-pulse"></div>
        <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-indigo-300 rounded-full mix-blend-overlay filter blur-3xl animate-pulse delay-1000"></div>
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
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-white mb-2 animate-fade-in-up">
                    Gestion des bulletins
                </h1>
                <p class="text-purple-200 text-sm md:text-base animate-fade-in-up animation-delay-200">
                    Consultez et gérez les bulletins scolaires des élèves
                </p>
            </div>
            <div class="flex justify-center md:justify-end animate-fade-in-right">
                <a href="{{ route('admin.bulletins.generate') }}" 
                   class="group relative inline-flex items-center justify-center px-5 py-2.5 md:px-6 md:py-3 bg-green-500 hover:bg-green-600 text-white font-semibold rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-xl overflow-hidden text-sm md:text-base w-full sm:w-auto">
                    <span class="absolute inset-0 bg-white opacity-0 group-hover:opacity-20 transition-opacity duration-300"></span>
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Générer des bulletins
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

    <!-- Messages de notification -->
    @if(session('success'))
        <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-3 md:p-4 rounded-lg shadow-md animate-fade-in-down" role="alert">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <svg class="h-5 w-5 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-sm font-medium">{{ session('success') }}</p>
                </div>
                <button type="button" class="text-green-500 hover:bg-green-200 rounded-lg p-1" onclick="this.parentElement.parentElement.remove()">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-3 md:p-4 rounded-lg shadow-md animate-fade-in-down" role="alert">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <svg class="h-5 w-5 text-red-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-sm font-medium">{{ session('error') }}</p>
                </div>
                <button type="button" class="text-red-500 hover:bg-red-200 rounded-lg p-1" onclick="this.parentElement.parentElement.remove()">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    @endif

    <!-- Statistiques rapides -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-6 md:mb-8">
        <div class="bg-white rounded-2xl shadow-lg p-4 md:p-6 border-l-4 border-purple-500 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 font-medium uppercase">Total</p>
                    <p class="text-xl md:text-3xl font-bold text-gray-800">{{ $stats['total'] }}</p>
                </div>
                <div class="bg-purple-100 rounded-xl p-2 md:p-3">
                    <svg class="w-5 h-5 md:w-8 md:h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-2 md:mt-4 flex items-center text-xs md:text-sm text-gray-600">
                <span class="text-green-600 font-medium">{{ $stats['admis'] ?? 0 }}</span>
                <span class="mx-1 md:mx-2">admis</span>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-4 md:p-6 border-l-4 border-green-500 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 font-medium uppercase">Moy. Gén.</p>
                    <p class="text-xl md:text-3xl font-bold text-gray-800">{{ $stats['moyenne_generale'] }}</p>
                </div>
                <div class="bg-green-100 rounded-xl p-2 md:p-3">
                    <svg class="w-5 h-5 md:w-8 md:h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-2 md:mt-4 w-full bg-gray-200 rounded-full h-1.5 md:h-2">
                <div class="bg-green-500 h-1.5 md:h-2 rounded-full" style="width: {{ ($stats['moyenne_generale'] / 20) * 100 }}%"></div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-4 md:p-6 border-l-4 border-blue-500 hover:shadow-xl transition-all duration-300 col-span-2 md:col-span-1">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 font-medium uppercase">Par période</p>
                    <div class="text-sm md:text-lg font-bold text-gray-800 mt-1">
                        @foreach($stats['par_periode'] as $periode => $count)
                            <span class="mr-2">{{ $periode }}: {{ $count }}</span>
                        @endforeach
                    </div>
                </div>
                <div class="bg-blue-100 rounded-xl p-2 md:p-3">
                    <svg class="w-5 h-5 md:w-8 md:h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-4 md:p-6 border-l-4 border-yellow-500 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 font-medium uppercase">Classes</p>
                    <p class="text-xl md:text-3xl font-bold text-gray-800">{{ $classes->count() }}</p>
                </div>
                <div class="bg-yellow-100 rounded-xl p-2 md:p-3">
                    <svg class="w-5 h-5 md:w-8 md:h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtres et recherche -->
    <div class="bg-white rounded-2xl shadow-lg p-4 md:p-6 mb-6 md:mb-8" x-data="{ filters: {{ request()->anyFilled(['annee_scolaire_id', 'classe_id', 'periode', 'eleve_id', 'search']) ? 'true' : 'false' }} }">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-base md:text-lg font-semibold text-gray-800 flex items-center">
                <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                </svg>
                Filtres
            </h2>
            <button @click="filters = !filters" class="text-purple-600 hover:text-purple-800 p-1">
                <svg class="w-5 h-5 transition-transform duration-300" :class="{ 'rotate-180': filters }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
        </div>

        <form method="GET" action="{{ route('admin.bulletins.index') }}" class="space-y-4">
            <!-- Recherche principale -->
            <div class="flex flex-col sm:flex-row gap-3">
                <div class="flex-1 relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Rechercher un élève..."
                           class="w-full pl-12 pr-4 py-2.5 md:py-3 rounded-xl border-2 border-gray-200 focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition-all duration-300 text-sm">
                </div>
                <button type="submit" 
                        class="w-full sm:w-auto px-6 py-2.5 md:py-3 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-semibold rounded-xl transition-all duration-300 transform hover:scale-105 text-sm">
                    Rechercher
                </button>
            </div>

            <!-- Filtres avancés -->
            <div x-show="filters" x-transition.duration.300 class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 pt-4">
                <!-- Année scolaire -->
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Année scolaire</label>
                    <select name="annee_scolaire_id" class="w-full rounded-xl border-2 border-gray-200 focus:border-purple-500 focus:ring-2 focus:ring-purple-200 px-4 py-2 text-sm">
                        <option value="">Toutes</option>
                        @foreach($anneeScolaires as $annee)
                            <option value="{{ $annee->id }}" {{ request('annee_scolaire_id') == $annee->id ? 'selected' : '' }}>
                                {{ $annee->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Classe -->
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Classe</label>
                    <select name="classe_id" class="w-full rounded-xl border-2 border-gray-200 focus:border-purple-500 focus:ring-2 focus:ring-purple-200 px-4 py-2 text-sm">
                        <option value="">Toutes</option>
                        @foreach($classes as $classe)
                            <option value="{{ $classe->id }}" {{ request('classe_id') == $classe->id ? 'selected' : '' }}>
                                {{ $classe->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Période -->
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Période</label>
                    <select name="periode" class="w-full rounded-xl border-2 border-gray-200 focus:border-purple-500 focus:ring-2 focus:ring-purple-200 px-4 py-2 text-sm">
                        <option value="">Toutes</option>
                        @foreach($periodes as $periode)
                            <option value="{{ $periode }}" {{ request('periode') == $periode ? 'selected' : '' }}>
                                {{ $periode }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Bouton reset -->
                <div class="flex items-end">
                    <a href="{{ route('admin.bulletins.index') }}" 
                       class="w-full text-center px-4 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all duration-300 text-sm font-medium">
                        Réinitialiser
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Tableau des bulletins -->
    <div class="bg-white rounded-2xl md:rounded-3xl shadow-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-purple-50 to-indigo-50">
                    <tr>
                        <th class="px-3 md:px-6 py-3 md:py-4 text-left text-xs font-semibold text-purple-700 uppercase tracking-wider">Élève</th>
                        <th class="px-3 md:px-6 py-3 md:py-4 text-left text-xs font-semibold text-purple-700 uppercase tracking-wider">Classe</th>
                        <th class="hidden lg:table-cell px-6 py-4 text-left text-xs font-semibold text-purple-700 uppercase tracking-wider">Année</th>
                        <th class="hidden md:table-cell px-6 py-4 text-left text-xs font-semibold text-purple-700 uppercase tracking-wider">Période</th>
                        <th class="px-3 md:px-6 py-3 md:py-4 text-left text-xs font-semibold text-purple-700 uppercase tracking-wider">Moyenne</th>
                        <th class="hidden sm:table-cell px-3 md:px-6 py-3 md:py-4 text-left text-xs font-semibold text-purple-700 uppercase tracking-wider">Rang</th>
                        <th class="hidden sm:table-cell px-3 md:px-6 py-3 md:py-4 text-left text-xs font-semibold text-purple-700 uppercase tracking-wider">Mention</th>
                        <th class="hidden lg:table-cell px-6 py-4 text-left text-xs font-semibold text-purple-700 uppercase tracking-wider">Date</th>
                        <th class="px-3 md:px-6 py-3 md:py-4 text-left text-xs font-semibold text-purple-700 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($bulletins as $bulletin)
                        <tr class="hover:bg-purple-50/50 transition-colors duration-200 group">
                            <td class="px-3 md:px-6 py-3 md:py-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-8 w-8 md:h-10 md:w-10 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-lg md:rounded-xl flex items-center justify-center text-white font-bold text-sm md:text-lg shadow-lg group-hover:scale-110 transition-transform duration-300">
                                        {{ strtoupper(substr($bulletin->eleve->prenom, 0, 1)) }}{{ strtoupper(substr($bulletin->eleve->nom, 0, 1)) }}
                                    </div>
                                    <div class="ml-3 md:ml-4">
                                        <div class="text-xs md:text-sm font-semibold text-gray-900 group-hover:text-purple-700 transition-colors duration-300 truncate max-w-[120px] md:max-w-none">
                                            {{ $bulletin->eleve->nom }} {{ $bulletin->eleve->prenom }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            {{ $bulletin->eleve->matricule ?? 'N/A' }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-3 md:px-6 py-3 md:py-4 whitespace-nowrap">
                                <span class="px-2 md:px-3 py-0.5 md:py-1 bg-blue-100 text-blue-700 text-xs font-medium rounded-full">
                                    {{ $bulletin->classe->nom }}
                                </span>
                            </td>
                            <td class="hidden lg:table-cell px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                {{ $bulletin->anneeScolaire->nom }}
                            </td>
                            <td class="hidden md:table-cell px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                {{ $bulletin->periode }}
                            </td>
                            <td class="px-3 md:px-6 py-3 md:py-4 whitespace-nowrap">
                                <span class="text-sm md:text-lg font-bold {{ $bulletin->moyenne_generale >= 10 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ number_format($bulletin->moyenne_generale, 2) }}
                                </span>
                                <span class="text-xs text-gray-500 hidden sm:inline">/20</span>
                            </td>
                            <td class="hidden sm:table-cell px-3 md:px-6 py-3 md:py-4 whitespace-nowrap">
                                @if($bulletin->rang)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        {{ $bulletin->rang }}<span class="text-xs hidden md:inline">/{{ $bulletin->effectif_classe }}</span>
                                    </span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="hidden sm:table-cell px-3 md:px-6 py-3 md:py-4 whitespace-nowrap">
                                @php
                                    $mentionColors = [
                                        'Très bien' => 'bg-green-100 text-green-800',
                                        'Bien' => 'bg-blue-100 text-blue-800',
                                        'Assez bien' => 'bg-indigo-100 text-indigo-800',
                                        'Passable' => 'bg-yellow-100 text-yellow-800',
                                        'Insuffisant' => 'bg-red-100 text-red-800',
                                    ];
                                    $mention = $bulletin->mention;
                                    $colorClass = $mentionColors[$mention] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $colorClass }}">
                                    {{ $mention }}
                                </span>
                            </td>
                            <td class="hidden lg:table-cell px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                {{ $bulletin->date_bulletin ?->format('d/m/Y') ?? 'N/A' }}
                            </td>
                            <td class="px-3 md:px-6 py-3 md:py-4 whitespace-nowrap">
                                <!-- CORRECTION : Boutons d'action TOUJOURS visibles, mais compacts sur mobile -->
                                <div class="flex items-center justify-end gap-1 md:gap-2 whitespace-nowrap">
                                    <!-- Voir -->
                                    <a href="{{ route('admin.bulletins.show', $bulletin) }}" class="p-1.5 md:p-2 text-blue-600 bg-transparent hover:bg-blue-50 rounded-lg transition-colors border-none" title="Voir détails">
                                        <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>
                                    <!-- Modifier -->
                                    <a href="{{ route('admin.bulletins.edit', $bulletin) }}" class="p-1.5 md:p-2 text-amber-600 bg-transparent hover:bg-amber-50 rounded-lg transition-colors border-none" title="Modifier">
                                        <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                    <!-- Imprimer -->
                                    <a href="{{ route('admin.bulletins.print', $bulletin) }}" class="p-1.5 md:p-2 text-emerald-600 bg-transparent hover:bg-emerald-50 rounded-lg transition-colors border-none items-center justify-center" title="Imprimer" target="_blank">
                                        <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                    </a>
                                    <!-- Supprimer -->
                                    <form action="{{ route('admin.bulletins.destroy', $bulletin) }}" method="POST" class="inline m-0 p-0 delete-form" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce bulletin ?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-1.5 md:p-2 text-red-600 bg-transparent hover:bg-red-50 rounded-lg transition-colors border-none flex items-center justify-center cursor-pointer" title="Supprimer">
                                            <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-12">
                                <div class="flex flex-col items-center justify-center text-center">
                                    <div class="w-20 h-20 md:w-24 md:h-24 bg-purple-100 rounded-full flex items-center justify-center mb-4 animate-pulse">
                                        <svg class="w-10 h-10 md:w-12 md:h-12 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-lg md:text-xl font-bold text-gray-800 mb-2">Aucun bulletin trouvé</h3>
                                    <p class="text-sm md:text-base text-gray-500 max-w-md mb-6 px-4">
                                        @if(request()->anyFilled(['search', 'annee_scolaire_id', 'classe_id', 'periode']))
                                            Aucun résultat ne correspond à vos critères.
                                            <a href="{{ route('admin.bulletins.index') }}" class="text-purple-600 hover:text-purple-800 font-medium block mt-2">
                                                Effacer les filtres
                                            </a>
                                        @else
                                            Commencez par générer des bulletins.
                                        @endif
                                    </p>
                                    @if(!request()->anyFilled(['search', 'annee_scolaire_id', 'classe_id', 'periode']))
                                        <a href="{{ route('admin.bulletins.generate') }}" 
                                           class="inline-flex items-center px-5 py-2.5 md:px-6 md:py-3 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-semibold rounded-xl transition-all duration-300 transform hover:scale-105 text-sm md:text-base">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                            </svg>
                                            Générer des bulletins
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($bulletins->hasPages())
            <div class="px-4 md:px-6 py-3 md:py-4 border-t border-gray-200 bg-gray-50 flex flex-col sm:flex-row items-center justify-between gap-3">
                <div class="text-xs md:text-sm text-gray-600 order-2 sm:order-1">
                    Affichage de <span class="font-medium">{{ $bulletins->firstItem() }}</span> à 
                    <span class="font-medium">{{ $bulletins->lastItem() }}</span> sur 
                    <span class="font-medium">{{ $bulletins->total() }}</span>
                </div>
                <div class="order-1 sm:order-2">
                    {{ $bulletins->withQueryString()->links() }}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Animations */
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
    @keyframes fadeInDown { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
    
    .animate-fade-in-up { animation: fadeInUp 0.8s ease-out forwards; }
    .animate-fade-in-right { animation: fadeInRight 0.8s ease-out forwards; }
    .animate-fade-in-down { animation: fadeInDown 0.5s ease-out forwards; }
    .animation-delay-200 { animation-delay: 200ms; opacity: 0; }

    /* Table rows */
    tbody tr { transition: all 0.3s ease; }
    tbody tr:hover { background-color: rgba(139, 92, 246, 0.05); }

    /* Pagination */
    .pagination { display: flex; gap: 0.25rem; flex-wrap: wrap; justify-content: center; }
    .pagination .page-item .page-link {
        padding: 0.4rem 0.75rem;
        border-radius: 0.5rem;
        border: 1px solid #e5e7eb;
        color: #4b5563;
        font-size: 0.75rem;
        transition: all 0.3s ease;
    }
    .pagination .page-item.active .page-link {
        background: linear-gradient(to right, #8b5cf6, #6366f1);
        color: white;
        border-color: transparent;
    }
    .pagination .page-item .page-link:hover { border-color: #8b5cf6; transform: scale(1.05); }
</style>
@endpush

@push('scripts')
<script>
    // Auto-fermeture des notifications après 5 secondes
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            const alerts = document.querySelectorAll('[role="alert"]');
            alerts.forEach(function(alert) {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                setTimeout(function() { alert.remove(); }, 500);
            });
        }, 5000);
    });

    // Animation au scroll
    const observerOptions = { threshold: 0.1, rootMargin: '0px 0px -50px 0px' };
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-fade-in-up');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);
    
    document.querySelectorAll('.bg-white').forEach(el => { observer.observe(el); });
</script>
@endpush