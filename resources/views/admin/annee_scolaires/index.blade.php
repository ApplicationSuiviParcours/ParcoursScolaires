@extends('layouts.app')

@section('title', 'Gestion des années scolaires')

@section('header')
<div class="relative overflow-hidden bg-gradient-to-br from-teal-600 via-teal-700 to-cyan-800 py-8 md:py-12">
    <!-- Éléments décoratifs animés -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-white rounded-full mix-blend-overlay filter blur-3xl animate-pulse"></div>
        <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-cyan-300 rounded-full mix-blend-overlay filter blur-3xl animate-pulse delay-1000"></div>
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
                    Années scolaires
                </h1>
                <p class="text-teal-200 text-sm md:text-base animate-fade-in-up animation-delay-200">
                    Gérez les années scolaires de l'établissement
                </p>
            </div>
            <div class="flex justify-center md:justify-end animate-fade-in-right">
                <a href="{{ route('admin.annee_scolaires.create') }}" 
                   class="group relative inline-flex items-center justify-center px-4 py-2.5 md:px-6 md:py-3 bg-white/20 backdrop-blur-lg hover:bg-white/30 text-white font-semibold rounded-xl transition-all duration-300 transform hover:scale-105 border border-white/30 text-sm">
                    <svg class="w-5 h-5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span class="hidden sm:inline">Nouvelle année</span>
                    <span class="sm:hidden">Ajouter</span>
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

    @if(session('info'))
        <div class="mb-6 bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-3 md:p-4 rounded-lg shadow-md animate-fade-in-down" role="alert">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <svg class="h-5 w-5 text-blue-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-sm font-medium">{{ session('info') }}</p>
                </div>
                <button type="button" class="text-blue-500 hover:bg-blue-200 rounded-lg p-1" onclick="this.parentElement.parentElement.remove()">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    @endif

    <!-- Statistiques rapides -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-6 md:mb-8">
        <div class="bg-white rounded-xl md:rounded-2xl shadow-lg p-4 md:p-6 border-l-4 border-teal-500 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 font-medium uppercase">Total</p>
                    <p class="text-xl md:text-3xl font-bold text-gray-800">{{ $stats['total'] }}</p>
                </div>
                <div class="bg-teal-100 rounded-lg md:rounded-xl p-2 md:p-3">
                    <svg class="w-5 h-5 md:w-8 md:h-8 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl md:rounded-2xl shadow-lg p-4 md:p-6 border-l-4 border-green-500 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 font-medium uppercase">Active</p>
                    <p class="text-xl md:text-3xl font-bold text-green-600">{{ $stats['active'] }}</p>
                </div>
                <div class="bg-green-100 rounded-lg md:rounded-xl p-2 md:p-3">
                    <svg class="w-5 h-5 md:w-8 md:h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl md:rounded-2xl shadow-lg p-4 md:p-6 border-l-4 border-blue-500 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 font-medium uppercase">Inscriptions</p>
                    <p class="text-xl md:text-3xl font-bold text-gray-800">{{ $stats['avec_inscriptions'] }}</p>
                </div>
                <div class="bg-blue-100 rounded-lg md:rounded-xl p-2 md:p-3">
                    <svg class="w-5 h-5 md:w-8 md:h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl md:rounded-2xl shadow-lg p-4 md:p-6 border-l-4 border-orange-500 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 font-medium uppercase">Évaluations</p>
                    <p class="text-xl md:text-3xl font-bold text-gray-800">{{ $stats['avec_evaluations'] }}</p>
                </div>
                <div class="bg-orange-100 rounded-lg md:rounded-xl p-2 md:p-3">
                    <svg class="w-5 h-5 md:w-8 md:h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtres -->
    <div class="bg-white rounded-2xl shadow-lg p-4 md:p-6 mb-6 md:mb-8" x-data="{ filters: {{ request()->anyFilled(['search', 'active', 'date_debut_min', 'date_debut_max']) ? 'true' : 'false' }} }">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-base md:text-lg font-semibold text-gray-800 flex items-center">
                <svg class="w-5 h-5 mr-2 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                </svg>
                Filtres
            </h2>
            <button @click="filters = !filters" class="text-teal-600 hover:text-teal-800 p-1">
                <svg class="w-5 h-5 transition-transform duration-300" :class="{ 'rotate-180': filters }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
        </div>

        <form method="GET" action="{{ route('admin.annee_scolaires.index') }}" class="space-y-4">
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
                           placeholder="Rechercher..."
                           class="w-full pl-12 pr-4 py-2.5 md:py-3 rounded-xl border-2 border-gray-200 focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-all duration-300 text-sm">
                </div>
                <button type="submit" 
                        class="w-full sm:w-auto px-6 py-2.5 md:py-3 bg-gradient-to-r from-teal-600 to-cyan-600 hover:from-teal-700 hover:to-cyan-700 text-white font-semibold rounded-xl transition-all duration-300 transform hover:scale-105 text-sm">
                    Rechercher
                </button>
            </div>

            <!-- Filtres avancés -->
            <div x-show="filters" x-transition.duration.300 class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 pt-4">
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Statut</label>
                    <select name="active" class="w-full rounded-xl border-2 border-gray-200 focus:border-teal-500 focus:ring-2 focus:ring-teal-200 px-4 py-2 text-sm">
                        <option value="">Tous</option>
                        <option value="oui" {{ request('active') == 'oui' ? 'selected' : '' }}>Actives</option>
                        <option value="non" {{ request('active') == 'non' ? 'selected' : '' }}>Inactives</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Date début min</label>
                    <input type="date" name="date_debut_min" value="{{ request('date_debut_min') }}" class="w-full rounded-xl border-2 border-gray-200 focus:border-teal-500 focus:ring-2 focus:ring-teal-200 px-4 py-2 text-sm">
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Date début max</label>
                    <input type="date" name="date_debut_max" value="{{ request('date_debut_max') }}" class="w-full rounded-xl border-2 border-gray-200 focus:border-teal-500 focus:ring-2 focus:ring-teal-200 px-4 py-2 text-sm">
                </div>

                <div class="sm:col-span-2 lg:col-span-3 flex justify-end">
                    <a href="{{ route('admin.annee_scolaires.index') }}" 
                       class="px-4 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all duration-300 text-sm font-medium">
                        Réinitialiser
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Tableau -->
    <div class="bg-white rounded-2xl md:rounded-3xl shadow-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-teal-50 to-cyan-50">
                    <tr>
                        <!-- Colonne Nom sticky -->
                        <th class="px-3 md:px-6 py-3 md:py-4 text-left text-[10px] md:text-xs font-semibold text-teal-700 uppercase tracking-wider sticky left-0 bg-gradient-to-r from-teal-50 to-cyan-50 z-10 min-w-[140px] md:min-w-[200px]">Nom</th>
                        <th class="hidden md:table-cell px-6 py-4 text-left text-xs font-semibold text-teal-700 uppercase tracking-wider">Période</th>
                        <th class="px-3 md:px-6 py-3 md:py-4 text-left text-[10px] md:text-xs font-semibold text-teal-700 uppercase tracking-wider min-w-[80px]">Statut</th>
                        <th class="hidden lg:table-cell px-6 py-4 text-left text-xs font-semibold text-teal-700 uppercase tracking-wider">Statistiques</th>
                        <th class="px-3 md:px-6 py-3 md:py-4 text-left text-[10px] md:text-xs font-semibold text-teal-700 uppercase tracking-wider min-w-[120px]">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($anneeScolaires as $annee)
                        <tr class="hover:bg-teal-50/50 transition-colors duration-200 group">
                            <!-- Nom (Sticky) -->
                            <td class="px-3 md:px-6 py-3 md:py-4 sticky left-0 bg-white group-hover:bg-teal-50/50 z-10">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-8 w-8 md:h-10 md:w-10 bg-gradient-to-br from-teal-500 to-cyan-600 rounded-lg md:rounded-xl flex items-center justify-center text-white font-bold text-sm md:text-lg shadow group-hover:scale-110 transition-transform duration-300">
                                        {{ substr($annee->nom, 0, 2) }}
                                    </div>
                                    <div class="ml-2 md:ml-4 min-w-0">
                                        <div class="text-xs md:text-sm font-semibold text-gray-900 group-hover:text-teal-700 transition-colors duration-300 truncate">
                                            {{ $annee->nom }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="hidden md:table-cell px-6 py-4">
                                <div class="text-xs md:text-sm text-gray-900">
                                    <div>du {{ $annee->date_debut->format('d/m/Y') }}</div>
                                    <div>au {{ $annee->date_fin->format('d/m/Y') }}</div>
                                </div>
                            </td>
                            <td class="px-3 md:px-6 py-3 md:py-4 whitespace-nowrap">
                                @if($annee->active)
                                    <span class="inline-flex items-center px-2 md:px-3 py-0.5 md:py-1 rounded-full text-[10px] md:text-xs font-medium bg-green-100 text-green-700">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 md:px-3 py-0.5 md:py-1 rounded-full text-[10px] md:text-xs font-medium bg-gray-100 text-gray-700">
                                        Inactive
                                    </span>
                                @endif
                            </td>
                            <td class="hidden lg:table-cell px-6 py-4">
                                <div class="flex space-x-2">
                                    <span class="inline-flex items-center px-2 py-1 rounded-lg text-[10px] md:text-xs font-medium bg-blue-100 text-blue-700" title="Inscriptions">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                        </svg>
                                        {{ $annee->inscriptions_count }}
                                    </span>
                                    <span class="inline-flex items-center px-2 py-1 rounded-lg text-[10px] md:text-xs font-medium bg-orange-100 text-orange-700" title="Évaluations">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                        </svg>
                                        {{ $annee->evaluations_count }}
                                    </span>
                                    <span class="inline-flex items-center px-2 py-1 rounded-lg text-[10px] md:text-xs font-medium bg-purple-100 text-purple-700" title="Emplois du temps">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $annee->emploi_du_temps_count }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-3 md:px-6 py-3 md:py-4 whitespace-nowrap">
                                <div class="flex items-center justify-end gap-1 md:gap-2 whitespace-nowrap">
                                    <a href="{{ route('admin.annee_scolaires.show', $annee) }}" class="p-1.5 md:p-2 text-blue-600 bg-transparent hover:bg-blue-50 rounded-lg transition-colors border-none" title="Voir">
                                        <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>
                                    <a href="{{ route('admin.annee_scolaires.edit', $annee) }}" class="p-1.5 md:p-2 text-amber-600 bg-transparent hover:bg-amber-50 rounded-lg transition-colors border-none" title="Modifier">
                                        <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                    @if(!$annee->active)
                                        <form action="{{ route('admin.annee_scolaires.activate', $annee) }}" method="POST" class="inline m-0 p-0" onsubmit="return confirm('Activer ?');">
                                            @csrf
                                            <button type="submit" class="p-1.5 md:p-2 text-emerald-600 bg-transparent hover:bg-emerald-50 rounded-lg transition-colors border-none flex items-center justify-center cursor-pointer" title="Activer">
                                                <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.annee_scolaires.deactivate', $annee) }}" method="POST" class="inline m-0 p-0" onsubmit="return confirm('Désactiver ?');">
                                            @csrf
                                            <button type="submit" class="p-1.5 md:p-2 text-gray-600 bg-transparent hover:bg-gray-50 rounded-lg transition-colors border-none flex items-center justify-center cursor-pointer" title="Désactiver">
                                                <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            </button>
                                        </form>
                                    @endif
                                    <form action="{{ route('admin.annee_scolaires.destroy', $annee) }}" method="POST" class="inline m-0 p-0 delete-form" onsubmit="return confirm('Supprimer ?');">
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
                            <td colspan="5" class="px-6 py-12">
                                <div class="flex flex-col items-center justify-center text-center">
                                    <div class="w-20 h-20 md:w-24 md:h-24 bg-teal-100 rounded-full flex items-center justify-center mb-4 animate-pulse">
                                        <svg class="w-10 h-10 md:w-12 md:h-12 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-lg md:text-xl font-bold text-gray-800 mb-2">Aucune année trouvée</h3>
                                    <p class="text-gray-500 max-w-md mb-6 px-4 text-sm md:text-base">
                                        @if(request()->anyFilled(['search', 'active', 'date_debut_min', 'date_debut_max']))
                                            Aucun résultat.
                                            <a href="{{ route('admin.annee_scolaires.index') }}" class="text-teal-600 hover:text-teal-800 font-medium block mt-2">
                                                Effacer les filtres
                                            </a>
                                        @else
                                            Commencez par créer une nouvelle année.
                                        @endif
                                    </p>
                                    @if(!request()->anyFilled(['search', 'active', 'date_debut_min', 'date_debut_max']))
                                        <a href="{{ route('admin.annee_scolaires.create') }}" 
                                           class="inline-flex items-center px-5 py-2.5 md:px-6 md:py-3 bg-gradient-to-r from-teal-600 to-cyan-600 hover:from-teal-700 hover:to-cyan-700 text-white font-semibold rounded-xl transition-all duration-300 transform hover:scale-105 text-sm md:text-base">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                            </svg>
                                            Créer
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
        @if($anneeScolaires->hasPages())
            <div class="px-4 md:px-6 py-3 md:py-4 border-t border-gray-200 bg-gray-50 flex flex-col sm:flex-row items-center justify-between gap-3">
                <div class="text-xs md:text-sm text-gray-600 order-2 sm:order-1">
                    Affichage de <span class="font-medium">{{ $anneeScolaires->firstItem() }}</span> à 
                    <span class="font-medium">{{ $anneeScolaires->lastItem() }}</span> sur 
                    <span class="font-medium">{{ $anneeScolaires->total() }}</span>
                </div>
                <div class="order-1 sm:order-2">
                    {{ $anneeScolaires->withQueryString()->links() }}
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

    tbody tr { transition: all 0.3s ease; }
    tbody tr:hover { background-color: rgba(20, 184, 166, 0.05); }

    .pagination { display: flex; gap: 0.25rem; flex-wrap: wrap; justify-content: center; }
    .pagination .page-item .page-link { padding: 0.4rem 0.75rem; border-radius: 0.5rem; border: 1px solid #e5e7eb; color: #4b5563; font-size: 0.75rem; transition: all 0.3s ease; }
    .pagination .page-item.active .page-link { background: linear-gradient(to right, #14b8a6, #06b6d4); color: white; border-color: transparent; }
    .pagination .page-item .page-link:hover { border-color: #14b8a6; transform: scale(1.05); }

    /* Prévention du zoom sur les inputs iOS */
    input, select, textarea { font-size: 16px; }
</style>
@endpush

@push('scripts')
<script>
    // Auto-fermeture des notifications
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
</script>
@endpush