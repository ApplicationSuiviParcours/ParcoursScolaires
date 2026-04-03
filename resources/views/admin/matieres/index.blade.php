@extends('layouts.app')

@section('title', 'Gestion des matières')

@section('header')
<div class="relative overflow-hidden bg-gradient-to-br from-indigo-600 via-indigo-700 to-purple-800 py-8 md:py-12">
    <!-- Éléments décoratifs animés -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-white rounded-full mix-blend-overlay filter blur-3xl animate-pulse"></div>
        <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-purple-300 rounded-full mix-blend-overlay filter blur-3xl animate-pulse delay-1000"></div>
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
                    Gestion des matières
                </h1>
                <p class="text-indigo-200 text-sm md:text-lg animate-fade-in-up animation-delay-200">
                    Gérez les matières enseignées dans l'établissement
                </p>
            </div>
            <div class="flex justify-center md:justify-end animate-fade-in-right">
                <a href="{{ route('admin.matieres.create') }}" 
                   class="group relative inline-flex items-center px-5 py-2.5 md:px-6 md:py-3 bg-white/20 backdrop-blur-lg hover:bg-white/30 text-white font-semibold rounded-xl transition-all duration-300 transform hover:scale-105 border border-white/30 text-sm md:text-base">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Nouvelle matière
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

    @if(session('warning'))
        <div class="mb-6 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-3 md:p-4 rounded-lg shadow-md animate-fade-in-down" role="alert">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <svg class="h-5 w-5 text-yellow-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    <p class="text-sm font-medium">{{ session('warning') }}</p>
                </div>
                <button type="button" class="text-yellow-500 hover:bg-yellow-200 rounded-lg p-1" onclick="this.parentElement.parentElement.remove()">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    @endif

    <!-- Statistiques rapides -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-6 md:mb-8">
        <div class="bg-white rounded-2xl shadow-lg p-4 md:p-6 border-l-4 border-indigo-500 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 font-medium uppercase">Total matières</p>
                    <p class="text-xl md:text-3xl font-bold text-gray-800">{{ $stats['total'] }}</p>
                </div>
                <div class="bg-indigo-100 rounded-xl p-2 md:p-3">
                    <svg class="w-6 h-6 md:w-8 md:h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-2 md:mt-4 flex items-center text-xs md:text-sm text-gray-600">
                <span class="text-green-600 font-medium">{{ $stats['avec_evaluations'] }}</span>
                <span class="mx-1 md:mx-2">avec évaluations</span>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-4 md:p-6 border-l-4 border-green-500 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 font-medium uppercase">Coef. moyen</p>
                    <p class="text-xl md:text-3xl font-bold text-gray-800">{{ $stats['coefficient_moyen'] }}</p>
                </div>
                <div class="bg-green-100 rounded-xl p-2 md:p-3">
                    <svg class="w-6 h-6 md:w-8 md:h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-2 md:mt-4 flex items-center text-xs md:text-sm text-gray-600">
                <span class="text-purple-600 font-medium">Min: {{ $stats['coefficient_min'] }}</span>
                <span class="mx-1">•</span>
                <span class="text-orange-600 font-medium">Max: {{ $stats['coefficient_max'] }}</span>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-4 md:p-6 border-l-4 border-blue-500 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 font-medium uppercase">Évaluations</p>
                    <p class="text-xl md:text-3xl font-bold text-gray-800">{{ $stats['avec_evaluations'] }}</p>
                </div>
                <div class="bg-blue-100 rounded-xl p-2 md:p-3">
                    <svg class="w-6 h-6 md:w-8 md:h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-2 md:mt-4 w-full bg-gray-200 rounded-full h-2">
                @php $pourcentage = $stats['total'] > 0 ? round(($stats['avec_evaluations'] / $stats['total']) * 100) : 0; @endphp
                <div class="bg-blue-500 h-2 rounded-full" style="width: {{ $pourcentage }}%"></div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-4 md:p-6 border-l-4 border-orange-500 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 font-medium uppercase">Avec absences</p>
                    <p class="text-xl md:text-3xl font-bold text-gray-800">{{ $stats['avec_absences'] }}</p>
                </div>
                <div class="bg-orange-100 rounded-xl p-2 md:p-3">
                    <svg class="w-6 h-6 md:w-8 md:h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-2 md:mt-4 w-full bg-gray-200 rounded-full h-2">
                @php $pourcentageAbs = $stats['total'] > 0 ? round(($stats['avec_absences'] / $stats['total']) * 100) : 0; @endphp
                <div class="bg-orange-500 h-2 rounded-full" style="width: {{ $pourcentageAbs }}%"></div>
            </div>
        </div>
    </div>

    <!-- Filtres et recherche -->
    <div class="bg-white rounded-2xl shadow-lg p-4 md:p-6 mb-6 md:mb-8" x-data="{ filters: false }">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-base md:text-lg font-semibold text-gray-800 flex items-center">
                <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                </svg>
                Filtres
            </h2>
            <button @click="filters = !filters" class="text-indigo-600 hover:text-indigo-800 p-1">
                <svg class="w-5 h-5 transition-transform duration-300" :class="{ 'rotate-180': filters }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
        </div>

        <form method="GET" action="{{ route('admin.matieres.index') }}" class="space-y-4">
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
                           class="w-full pl-12 pr-4 py-2.5 md:py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all duration-300 text-sm">
                </div>
                <button type="submit" 
                        class="w-full sm:w-auto px-6 py-2.5 md:py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold rounded-xl transition-all duration-300 transform hover:scale-105 text-sm">
                    Rechercher
                </button>
            </div>

            <!-- Filtres avancés -->
            <div x-show="filters" x-transition.duration.300 class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 pt-4">
                <!-- Coefficient min -->
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Coefficient min</label>
                    <input type="number" 
                           name="coefficient_min" 
                           value="{{ request('coefficient_min') }}"
                           min="1"
                           max="10"
                           placeholder="Min"
                           class="w-full rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 px-4 py-2 text-sm">
                </div>

                <!-- Coefficient max -->
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Coefficient max</label>
                    <input type="number" 
                           name="coefficient_max" 
                           value="{{ request('coefficient_max') }}"
                           min="1"
                           max="10"
                           placeholder="Max"
                           class="w-full rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 px-4 py-2 text-sm">
                </div>

                <!-- Tri -->
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Trier par</label>
                    <select name="order_by" class="w-full rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 px-4 py-2 text-sm">
                        <option value="nom" {{ request('order_by') == 'nom' ? 'selected' : '' }}>Nom</option>
                        <option value="code" {{ request('order_by') == 'code' ? 'selected' : '' }}>Code</option>
                        <option value="coefficient" {{ request('order_by') == 'coefficient' ? 'selected' : '' }}>Coefficient</option>
                        <option value="created_at" {{ request('order_by') == 'created_at' ? 'selected' : '' }}>Date</option>
                    </select>
                </div>

                <!-- Direction du tri -->
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Ordre</label>
                    <select name="order_dir" class="w-full rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 px-4 py-2 text-sm">
                        <option value="asc" {{ request('order_dir') == 'asc' ? 'selected' : '' }}>Croissant</option>
                        <option value="desc" {{ request('order_dir') == 'desc' ? 'selected' : '' }}>Décroissant</option>
                    </select>
                </div>

                <!-- Bouton reset -->
                <div class="flex items-end">
                    <a href="{{ route('admin.matieres.index') }}" 
                       class="w-full text-center px-4 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all duration-300 text-sm font-medium">
                        Réinitialiser
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Tableau des matières -->
    <div class="bg-white rounded-3xl shadow-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-indigo-50 to-purple-50">
                    <tr>
                        <th class="px-3 md:px-6 py-3 md:py-4 text-left text-xs font-semibold text-indigo-700 uppercase tracking-wider">Code</th>
                        <th class="px-3 md:px-6 py-3 md:py-4 text-left text-xs font-semibold text-indigo-700 uppercase tracking-wider">Nom</th>
                        <th class="px-3 md:px-6 py-3 md:py-4 text-left text-xs font-semibold text-indigo-700 uppercase tracking-wider">Coef.</th>
                        <th class="hidden lg:table-cell px-6 py-4 text-left text-xs font-semibold text-indigo-700 uppercase tracking-wider">Description</th>
                        <th class="px-3 md:px-6 py-3 md:py-4 text-left text-xs font-semibold text-indigo-700 uppercase tracking-wider">Stats</th>
                        <th class="px-3 md:px-6 py-3 md:py-4 text-left text-xs font-semibold text-indigo-700 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @forelse($matieres as $matiere)
                        <tr class="hover:bg-indigo-50/50 transition-colors duration-200 group">
                            <td class="px-3 md:px-6 py-3 md:py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2 md:px-3 py-0.5 md:py-1 rounded-full text-xs md:text-sm font-medium bg-indigo-100 text-indigo-700">
                                    {{ $matiere->code }}
                                </span>
                            </td>
                            <td class="px-3 md:px-6 py-3 md:py-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-8 w-8 md:h-10 md:w-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg md:rounded-xl flex items-center justify-center text-white font-bold text-sm md:text-lg shadow-lg group-hover:scale-110 transition-transform duration-300">
                                        {{ substr($matiere->nom, 0, 2) }}
                                    </div>
                                    <div class="ml-3 md:ml-4">
                                        <div class="text-xs md:text-sm font-semibold text-gray-900 group-hover:text-indigo-700 transition-colors duration-300 truncate max-w-[100px] sm:max-w-none">
                                            {{ $matiere->nom }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-3 md:px-6 py-3 md:py-4 whitespace-nowrap">
                                <span class="text-sm md:text-lg font-bold text-gray-800">{{ $matiere->coefficient }}</span>
                                <span class="text-xs text-gray-500 hidden sm:inline">/10</span>
                            </td>
                            <!-- Colonne description masquée sur mobile -->
                            <td class="hidden lg:table-cell px-6 py-4">
                                <p class="text-sm text-gray-600 truncate max-w-xs">{{ $matiere->description ?? 'Aucune description' }}</p>
                            </td>
                            <td class="px-3 md:px-6 py-3 md:py-4 whitespace-nowrap">
                                <div class="flex flex-wrap gap-1 md:gap-2">
                                    <span class="inline-flex items-center px-1.5 md:px-2 py-0.5 md:py-1 rounded-lg text-xs font-medium bg-blue-100 text-blue-700" title="Évaluations">
                                        <svg class="w-3 h-3 mr-0.5 md:mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                        </svg>
                                        {{ $matiere->evaluations_count }}
                                    </span>
                                    <span class="inline-flex items-center px-1.5 md:px-2 py-0.5 md:py-1 rounded-lg text-xs font-medium bg-orange-100 text-orange-700" title="Absences">
                                        <svg class="w-3 h-3 mr-0.5 md:mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $matiere->absences_count }}
                                    </span>
                                    <span class="hidden sm:inline-flex items-center px-1.5 md:px-2 py-0.5 md:py-1 rounded-lg text-xs font-medium bg-green-100 text-green-700" title="Classes">
                                        <svg class="w-3 h-3 mr-0.5 md:mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"></path>
                                        </svg>
                                        {{ $matiere->classe_matieres_count }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-3 md:px-6 py-3 md:py-4 whitespace-nowrap">
                                <div class="flex items-center justify-end gap-1 md:gap-2 whitespace-nowrap">
                                    <a href="{{ route('admin.matieres.show', $matiere) }}" class="p-1.5 md:p-2 text-blue-600 bg-transparent hover:bg-blue-50 rounded-lg transition-colors border-none" title="Voir">
                                        <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>
                                    <a href="{{ route('admin.matieres.edit', $matiere) }}" class="p-1.5 md:p-2 text-amber-600 bg-transparent hover:bg-amber-50 rounded-lg transition-colors border-none" title="Modifier">
                                        <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                    <a href="{{ route('admin.matieres.duplicate', $matiere) }}" class="hidden sm:inline-flex p-1.5 md:p-2 text-emerald-600 bg-transparent hover:bg-emerald-50 rounded-lg transition-colors border-none items-center justify-center cursor-pointer" title="Dupliquer" onclick="return confirm('Créer une copie ?');">
                                        <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                    </a>
                                    <form action="{{ route('admin.matieres.destroy', $matiere) }}" method="POST" class="inline m-0 p-0 delete-form" onsubmit="return confirmSuppression({{ $matiere->evaluations_count }}, {{ $matiere->absences_count }}, {{ $matiere->classe_matieres_count }});">
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
                            <td colspan="6" class="px-6 py-12">
                                <div class="flex flex-col items-center justify-center text-center">
                                    <div class="w-20 h-20 md:w-24 md:h-24 bg-indigo-100 rounded-full flex items-center justify-center mb-4 animate-pulse">
                                        <svg class="w-10 h-10 md:w-12 md:h-12 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-lg md:text-xl font-bold text-gray-800 mb-2">Aucune matière trouvée</h3>
                                    <p class="text-sm md:text-base text-gray-500 max-w-md mb-6">
                                        @if(request()->anyFilled(['search', 'coefficient_min', 'coefficient_max']))
                                            Aucun résultat ne correspond à vos critères.
                                            <a href="{{ route('admin.matieres.index') }}" class="text-indigo-600 hover:text-indigo-800 font-medium block mt-2">
                                                Effacer les filtres
                                            </a>
                                        @else
                                            Commencez par créer une nouvelle matière.
                                        @endif
                                    </p>
                                    @if(!request()->anyFilled(['search', 'coefficient_min', 'coefficient_max']))
                                        <a href="{{ route('admin.matieres.create') }}" 
                                           class="inline-flex items-center px-5 py-2.5 md:px-6 md:py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold rounded-xl transition-all duration-300 transform hover:scale-105 text-sm md:text-base">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                            </svg>
                                            Créer une matière
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
        @if($matieres->hasPages())
            <div class="px-4 md:px-6 py-3 md:py-4 border-t border-gray-200 bg-gray-50 flex flex-col sm:flex-row items-center justify-between gap-3">
                <div class="text-xs md:text-sm text-gray-600 order-2 sm:order-1">
                    Affichage de <span class="font-medium">{{ $matieres->firstItem() }}</span> à 
                    <span class="font-medium">{{ $matieres->lastItem() }}</span> sur 
                    <span class="font-medium">{{ $matieres->total() }}</span>
                </div>
                <div class="order-1 sm:order-2">
                    {{ $matieres->withQueryString()->links() }}
                </div>
            </div>
        @endif
    </div>

    <!-- Boutons d'export -->
    <div class="mt-6 flex justify-center md:justify-end">
        <a href="{{ route('admin.matieres.export') }}" 
           class="w-full sm:w-auto px-5 py-2.5 bg-white border-2 border-gray-300 rounded-xl text-gray-700 hover:bg-gray-50 transition-all duration-300 transform hover:scale-105 flex items-center justify-center text-sm">
            <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
            </svg>
            Exporter les données
        </a>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Animations (conservées) */
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

    /* Animation pour les lignes du tableau */
    tbody tr { transition: all 0.3s ease; }
    tbody tr:hover { background-color: rgba(79, 70, 229, 0.05); }

    /* Style pour la pagination personnalisée si nécessaire */
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
        background: linear-gradient(to right, #6366f1, #8b5cf6);
        color: white;
        border-color: transparent;
    }
    .pagination .page-item .page-link:hover { border-color: #6366f1; transform: scale(1.05); }
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

    // Fonction de confirmation avancée pour la suppression
    function confirmSuppression(evaluations, absences, classes) {
        let message = "⚠️ Êtes-vous sûr de vouloir supprimer cette matière ?\n\n";
        let details = [];
        
        if (evaluations > 0) details.push(`📝 ${evaluations} évaluation(s)`);
        if (absences > 0) details.push(`📅 ${absences} absence(s)`);
        if (classes > 0) details.push(`🏫 ${classes} classe(s)`);
        
        if (details.length > 0) {
            message += "❌ SUPPRESSION IMPOSSIBLE\n\n";
            message += "Cette matière est utilisée dans :\n";
            message += details.join('\n');
            message += "\n\nVeuillez d'abord supprimer ces dépendances.";
            alert(message);
            return false;
        }
        
        return confirm("✅ Aucune dépendance trouvée.\n\nConfirmez-vous la suppression ?");
    }
</script>
@endpush