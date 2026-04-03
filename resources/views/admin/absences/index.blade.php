@extends('layouts.app')

@section('title', 'Gestion des absences')

@section('header')
<div class="relative overflow-hidden bg-gradient-to-br from-orange-600 via-orange-700 to-red-800 py-8 md:py-12">
    <!-- Éléments décoratifs animés -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-white rounded-full mix-blend-overlay filter blur-3xl animate-pulse"></div>
        <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-red-300 rounded-full mix-blend-overlay filter blur-3xl animate-pulse delay-1000"></div>
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
                    Gestion des absences
                </h1>
                <p class="text-orange-200 text-sm md:text-base animate-fade-in-up animation-delay-200">
                    Consultez et gérez les absences
                </p>
            </div>
            <div class="flex flex-col sm:flex-row justify-center md:justify-end space-y-3 sm:space-y-0 sm:space-x-3 animate-fade-in-right">
                <a href="{{ route('admin.absences.byClasse') }}" 
                   class="group relative inline-flex items-center justify-center px-4 py-2.5 md:px-6 md:py-3 bg-green-500 hover:bg-green-600 text-white font-semibold rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-xl overflow-hidden text-sm">
                    <span class="absolute inset-0 bg-white opacity-0 group-hover:opacity-20 transition-opacity duration-300"></span>
                    <svg class="w-5 h-5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <span class="hidden sm:inline">Vue par classe</span>
                    <span class="sm:hidden">Par classe</span>
                </a>
                <a href="{{ route('admin.absences.create') }}" 
                   class="group relative inline-flex items-center justify-center px-4 py-2.5 md:px-6 md:py-3 bg-white/20 backdrop-blur-lg hover:bg-white/30 text-white font-semibold rounded-xl transition-all duration-300 transform hover:scale-105 border border-white/30 text-sm">
                    <svg class="w-5 h-5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span class="hidden sm:inline">Nouvelle absence</span>
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

    <!-- Statistiques rapides -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-6 md:mb-8">
        <div class="bg-white rounded-xl md:rounded-2xl shadow-lg p-4 md:p-6 border-l-4 border-orange-500 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 font-medium uppercase">Total</p>
                    <p class="text-xl md:text-3xl font-bold text-gray-800">{{ $stats['total'] }}</p>
                </div>
                <div class="bg-orange-100 rounded-lg md:rounded-xl p-2 md:p-3">
                    <svg class="w-5 h-5 md:w-8 md:h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl md:rounded-2xl shadow-lg p-4 md:p-6 border-l-4 border-green-500 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 font-medium uppercase">Justifiées</p>
                    <p class="text-xl md:text-3xl font-bold text-green-600">{{ $stats['justifiees'] }}</p>
                </div>
                <div class="bg-green-100 rounded-lg md:rounded-xl p-2 md:p-3">
                    <svg class="w-5 h-5 md:w-8 md:h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl md:rounded-2xl shadow-lg p-4 md:p-6 border-l-4 border-red-500 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 font-medium uppercase">Non justifiées</p>
                    <p class="text-xl md:text-3xl font-bold text-red-600">{{ $stats['non_justifiees'] }}</p>
                </div>
                <div class="bg-red-100 rounded-lg md:rounded-xl p-2 md:p-3">
                    <svg class="w-5 h-5 md:w-8 md:h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl md:rounded-2xl shadow-lg p-4 md:p-6 border-l-4 border-blue-500 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 font-medium uppercase">Aujourd'hui</p>
                    <p class="text-xl md:text-3xl font-bold text-gray-800">{{ $stats['aujourd_hui'] }}</p>
                </div>
                <div class="bg-blue-100 rounded-lg md:rounded-xl p-2 md:p-3">
                    <svg class="w-5 h-5 md:w-8 md:h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtres -->
    <div class="bg-white rounded-2xl shadow-lg p-4 md:p-6 mb-6 md:mb-8" x-data="{ filters: {{ request()->anyFilled(['annee_scolaire_id', 'classe_id', 'eleve_id', 'matiere_id', 'justifiee', 'date_debut', 'date_fin']) ? 'true' : 'false' }} }">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-base md:text-lg font-semibold text-gray-800 flex items-center">
                <svg class="w-5 h-5 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                </svg>
                Filtres
            </h2>
            <button @click="filters = !filters" class="text-orange-600 hover:text-orange-800 p-1">
                <svg class="w-5 h-5 transition-transform duration-300" :class="{ 'rotate-180': filters }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
        </div>

        <form method="GET" action="{{ route('admin.absences.index') }}" class="space-y-4">
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
                           class="w-full pl-12 pr-4 py-2.5 md:py-3 rounded-xl border-2 border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition-all duration-300 text-sm">
                </div>
                <button type="submit" 
                        class="w-full sm:w-auto px-6 py-2.5 md:py-3 bg-gradient-to-r from-orange-600 to-red-600 hover:from-orange-700 hover:to-red-700 text-white font-semibold rounded-xl transition-all duration-300 transform hover:scale-105 text-sm">
                    Rechercher
                </button>
            </div>

            <!-- Filtres avancés -->
            <div x-show="filters" x-transition.duration.300 class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 pt-4">
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Année scolaire</label>
                    <select name="annee_scolaire_id" class="w-full rounded-xl border-2 border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 px-4 py-2 text-sm">
                        <option value="">Toutes</option>
                        @foreach($anneeScolaires as $annee)
                            <option value="{{ $annee->id }}" {{ request('annee_scolaire_id') == $annee->id ? 'selected' : '' }}>{{ $annee->nom }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Classe</label>
                    <select name="classe_id" id="classe_filter" class="w-full rounded-xl border-2 border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 px-4 py-2 text-sm">
                        <option value="">Toutes</option>
                        @foreach($classes as $classe)
                            <option value="{{ $classe->id }}" {{ request('classe_id') == $classe->id ? 'selected' : '' }}>{{ $classe->nom }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Matière</label>
                    <select name="matiere_id" class="w-full rounded-xl border-2 border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 px-4 py-2 text-sm">
                        <option value="">Toutes</option>
                        @foreach($matieres as $matiere)
                            <option value="{{ $matiere->id }}" {{ request('matiere_id') == $matiere->id ? 'selected' : '' }}>{{ $matiere->nom }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Statut</label>
                    <select name="justifiee" class="w-full rounded-xl border-2 border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 px-4 py-2 text-sm">
                        <option value="">Tous</option>
                        <option value="oui" {{ request('justifiee') == 'oui' ? 'selected' : '' }}>Justifiées</option>
                        <option value="non" {{ request('justifiee') == 'non' ? 'selected' : '' }}>Non justifiées</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Date début</label>
                    <input type="date" name="date_debut" value="{{ request('date_debut') }}" class="w-full rounded-xl border-2 border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 px-4 py-2 text-sm">
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Date fin</label>
                    <input type="date" name="date_fin" value="{{ request('date_fin') }}" class="w-full rounded-xl border-2 border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 px-4 py-2 text-sm">
                </div>

                <div class="sm:col-span-2 lg:col-span-3 flex justify-end">
                    <a href="{{ route('admin.absences.index') }}" 
                       class="px-4 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all duration-300 text-sm font-medium">
                        Réinitialiser
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Tableau des absences -->
    <div class="bg-white rounded-2xl md:rounded-3xl shadow-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-orange-50 to-red-50">
                    <tr>
                        <!-- Colonne Élève sticky -->
                        <th class="px-3 md:px-6 py-3 md:py-4 text-left text-[10px] md:text-xs font-semibold text-orange-700 uppercase tracking-wider sticky left-0 bg-gradient-to-r from-orange-50 to-red-50 z-10 min-w-[140px] md:min-w-[200px]">Élève</th>
                        <th class="hidden md:table-cell px-6 py-4 text-left text-xs font-semibold text-orange-700 uppercase tracking-wider">Matière</th>
                        <th class="px-3 md:px-6 py-3 md:py-4 text-left text-[10px] md:text-xs font-semibold text-orange-700 uppercase tracking-wider min-w-[80px]">Date</th>
                        <th class="hidden lg:table-cell px-6 py-4 text-left text-xs font-semibold text-orange-700 uppercase tracking-wider">Horaire</th>
                        <th class="px-3 md:px-6 py-3 md:py-4 text-left text-[10px] md:text-xs font-semibold text-orange-700 uppercase tracking-wider">Motif</th>
                        <th class="px-3 md:px-6 py-3 md:py-4 text-left text-[10px] md:text-xs font-semibold text-orange-700 uppercase tracking-wider">Statut</th>
                        <th class="px-3 md:px-6 py-3 md:py-4 text-left text-[10px] md:text-xs font-semibold text-orange-700 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($absences as $absence)
                        <tr class="hover:bg-orange-50/50 transition-colors duration-200 group">
                            <!-- Élève (Sticky) -->
                            <td class="px-3 md:px-6 py-3 md:py-4 sticky left-0 bg-white group-hover:bg-orange-50/50 z-10">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-8 w-8 md:h-10 md:w-10 bg-gradient-to-br from-orange-500 to-red-600 rounded-lg md:rounded-xl flex items-center justify-center text-white font-bold text-sm md:text-lg shadow-lg group-hover:scale-110 transition-transform duration-300">
                                        {{ strtoupper(substr($absence->eleve->prenom, 0, 1)) }}{{ strtoupper(substr($absence->eleve->nom, 0, 1)) }}
                                    </div>
                                    <div class="ml-2 md:ml-4 min-w-0">
                                        <div class="text-xs md:text-sm font-semibold text-gray-900 group-hover:text-orange-700 transition-colors duration-300 truncate">
                                            {{ $absence->eleve->nom }} {{ $absence->eleve->prenom }}
                                        </div>
                                        <div class="text-[10px] md:text-xs text-gray-500 hidden sm:block">
                                            {{ $absence->eleve->matricule ?? 'N/A' }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="hidden md:table-cell px-6 py-4">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-2 flex-shrink-0">
                                        <span class="text-purple-700 font-bold text-[10px] md:text-xs">{{ substr($absence->matiere->code ?? 'MT', 0, 3) }}</span>
                                    </div>
                                    <span class="text-sm font-medium text-gray-900 truncate">{{ $absence->matiere->nom }}</span>
                                </div>
                            </td>
                            <td class="px-3 md:px-6 py-3 md:py-4 whitespace-nowrap">
                                <span class="text-xs md:text-sm text-gray-900">{{ $absence->date_absence->format('d/m/Y') }}</span>
                            </td>
                            <td class="hidden lg:table-cell px-6 py-4 whitespace-nowrap">
                                @if($absence->heure_debut && $absence->heure_fin)
                                    <span class="text-sm text-gray-600">{{ $absence->heure_debut->format('H:i') }} - {{ $absence->heure_fin->format('H:i') }}</span>
                                @else
                                    <span class="text-xs text-gray-400">Journée</span>
                                @endif
                            </td>
                            <td class="px-3 md:px-6 py-3 md:py-4">
                                <p class="text-xs md:text-sm text-gray-600 truncate max-w-[100px] md:max-w-xs">{{ $absence->motif ?? 'Aucun' }}</p>
                            </td>
                            <td class="px-3 md:px-6 py-3 md:py-4 whitespace-nowrap">
                                @if($absence->justifiee)
                                    <span class="inline-flex items-center px-2 md:px-3 py-0.5 md:py-1 rounded-full text-[10px] md:text-xs font-medium bg-green-100 text-green-700">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Oui
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 md:px-3 py-0.5 md:py-1 rounded-full text-[10px] md:text-xs font-medium bg-red-100 text-red-700">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        Non
                                    </span>
                                @endif
                            </td>
                            <td class="px-3 md:px-6 py-3 md:py-4 whitespace-nowrap">
                                <div class="flex items-center justify-end gap-1 md:gap-2 whitespace-nowrap">
                                    <a href="{{ route('admin.absences.show', $absence) }}" class="p-1.5 md:p-2 text-blue-600 bg-transparent hover:bg-blue-50 rounded-lg transition-colors border-none" title="Voir">
                                        <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>
                                    <a href="{{ route('admin.absences.edit', $absence) }}" class="p-1.5 md:p-2 text-amber-600 bg-transparent hover:bg-amber-50 rounded-lg transition-colors border-none" title="Modifier">
                                        <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                    @if(!$absence->justifiee)
                                    <button type="button" onclick="showJustifyModal({{ $absence->id }})" class="p-1.5 md:p-2 text-emerald-600 bg-transparent hover:bg-emerald-50 rounded-lg transition-colors border-none cursor-pointer" title="Justifier">
                                        <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </button>
                                    @endif
                                    <form action="{{ route('admin.absences.destroy', $absence) }}" method="POST" class="inline m-0 p-0 delete-form" onsubmit="return confirm('Supprimer ?');">
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
                            <td colspan="7" class="px-6 py-12">
                                <div class="flex flex-col items-center justify-center text-center">
                                    <div class="w-20 h-20 md:w-24 md:h-24 bg-orange-100 rounded-full flex items-center justify-center mb-4 animate-pulse">
                                        <svg class="w-10 h-10 md:w-12 md:h-12 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-lg md:text-xl font-bold text-gray-800 mb-2">Aucune absence</h3>
                                    <p class="text-sm md:text-base text-gray-500 max-w-md mb-6 px-4">
                                        @if(request()->anyFilled(['annee_scolaire_id', 'classe_id', 'matiere_id', 'justifiee']))
                                            Aucun résultat.
                                            <a href="{{ route('admin.absences.index') }}" class="text-orange-600 hover:text-orange-800 font-medium block mt-2">
                                                Effacer les filtres
                                            </a>
                                        @else
                                            Commencez par enregistrer une absence.
                                        @endif
                                    </p>
                                    @if(!request()->anyFilled(['annee_scolaire_id', 'classe_id', 'matiere_id', 'justifiee']))
                                        <a href="{{ route('admin.absences.create') }}" 
                                           class="inline-flex items-center px-5 py-2.5 md:px-6 md:py-3 bg-gradient-to-r from-orange-600 to-red-600 hover:from-orange-700 hover:to-red-700 text-white font-semibold rounded-xl transition-all duration-300 transform hover:scale-105 text-sm md:text-base">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                            </svg>
                                            Ajouter
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
        @if($absences->hasPages())
            <div class="px-4 md:px-6 py-3 md:py-4 border-t border-gray-200 bg-gray-50 flex flex-col sm:flex-row items-center justify-between gap-3">
                <div class="text-xs md:text-sm text-gray-600 order-2 sm:order-1">
                    Affichage de <span class="font-medium">{{ $absences->firstItem() }}</span> à 
                    <span class="font-medium">{{ $absences->lastItem() }}</span> sur 
                    <span class="font-medium">{{ $absences->total() }}</span>
                </div>
                <div class="order-1 sm:order-2">
                    {{ $absences->withQueryString()->links() }}
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Modal de justification -->
<div id="justifyModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" id="modal-backdrop"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">​</span>

        <div class="inline-block align-bottom bg-white rounded-2xl md:rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
             id="modal-content">
            
            <div class="bg-white px-4 md:px-6 pt-5 md:pt-6 pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 md:h-14 md:w-14 rounded-full bg-green-100 sm:mx-0 sm:h-12 sm:w-12">
                        <svg class="h-6 w-6 md:h-7 md:w-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                        <h3 class="text-lg md:text-xl leading-6 font-bold text-gray-900 mb-2" id="modal-title">
                            Justifier l'absence
                        </h3>
                        <div class="mt-2">
                            <p class="text-xs md:text-sm text-gray-500 mb-4">
                                Fournissez un motif de justification.
                            </p>
                            <form id="justifyForm" method="POST">
                                @csrf
                                <input type="hidden" name="absence_id" id="absence_id">
                                <div class="mb-4">
                                    <label for="motif" class="block text-xs font-medium text-gray-700 mb-1">Motif</label>
                                    <textarea name="motif" id="motif" rows="3" required
                                              class="w-full rounded-xl border-2 border-gray-200 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all duration-300 px-4 py-2.5 md:py-3 text-sm"
                                              placeholder="Motif..."></textarea>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="bg-gray-50 px-4 md:px-6 py-3 md:py-4 flex flex-row-reverse gap-3">
                <button type="button" 
                        onclick="submitJustify()"
                        class="w-full sm:w-auto inline-flex justify-center rounded-xl border border-transparent shadow-sm px-6 py-2.5 md:py-3 bg-green-600 text-base font-semibold text-white hover:bg-green-700 sm:text-sm transition-all duration-300 transform hover:scale-105 text-sm">
                    Justifier
                </button>
                <button type="button" 
                        onclick="closeJustifyModal()"
                        class="w-full sm:w-auto inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-6 py-2.5 md:py-3 bg-white text-base font-semibold text-gray-700 hover:bg-gray-50 sm:text-sm transition-all duration-300 transform hover:scale-105 text-sm">
                    Annuler
                </button>
            </div>
        </div>
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
    tbody tr:hover { background-color: rgba(249, 115, 22, 0.05); }

    .pagination { display: flex; gap: 0.25rem; flex-wrap: wrap; justify-content: center; }
    .pagination .page-item .page-link { padding: 0.4rem 0.75rem; border-radius: 0.5rem; border: 1px solid #e5e7eb; color: #4b5563; font-size: 0.75rem; transition: all 0.3s ease; }
    .pagination .page-item.active .page-link { background: linear-gradient(to right, #f97316, #ef4444); color: white; border-color: transparent; }
    .pagination .page-item .page-link:hover { border-color: #f97316; transform: scale(1.05); }

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

    // Modal de justification
    function showJustifyModal(absenceId) {
        document.getElementById('absence_id').value = absenceId;
        document.getElementById('justifyModal').classList.remove('hidden');
    }

    function closeJustifyModal() {
        document.getElementById('justifyModal').classList.add('hidden');
        document.getElementById('motif').value = '';
    }

    function submitJustify() {
        const motif = document.getElementById('motif').value;
        
        if (!motif.trim()) {
            alert('Veuillez saisir un motif');
            return;
        }
        
        const form = document.getElementById('justifyForm');
        // Note: Adjust URL if necessary
        form.action = `/admin/absences/${document.getElementById('absence_id').value}/justify`;
        form.submit();
    }

    // Fermer avec Echap ou backdrop
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeJustifyModal();
    });
    
    const backdrop = document.getElementById('modal-backdrop');
    if (backdrop) {
        backdrop.addEventListener('click', function(e) {
            if (e.target === this) closeJustifyModal();
        });
    }
</script>
@endpush