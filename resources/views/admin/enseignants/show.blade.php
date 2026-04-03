@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Détails de l\'enseignant') }}
    </h2>
@endsection

@section('content')
    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Messages flash -->
            @if(session('success'))
                <div class="mb-4 sm:mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-3 sm:p-4 rounded-r-lg shadow-md"
                    role="alert">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-green-500 mr-3 sm:mr-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-xs sm:text-sm font-medium">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 sm:mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-3 sm:p-4 rounded-r-lg shadow-md"
                    role="alert">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-red-500 mr-3 sm:mr-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-xs sm:text-sm font-medium">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            <!-- Header avec navigation -->
            <div
                class="bg-gradient-to-r from-indigo-600 via-indigo-700 to-purple-700 rounded-xl sm:rounded-2xl shadow-xl sm:shadow-2xl mb-6 sm:mb-8 overflow-hidden relative group">
                <div class="absolute inset-0 bg-gradient-to-r from-white/10 to-transparent"></div>

                <div class="relative px-4 sm:px-8 py-4 sm:py-6">
                    <div class="flex flex-col gap-4">
                        <!-- Ligne du haut : Retour -->
                        <div class="flex justify-start">
                            <a href="{{ route('admin.enseignants.index') }}"
                                class="inline-flex items-center px-3 py-1.5 sm:px-4 sm:py-2 bg-white/20 hover:bg-white/30 text-white text-xs sm:text-sm font-medium rounded-lg sm:rounded-xl transition-all duration-200 backdrop-blur-sm border border-white/30">
                                <svg class="w-4 h-4 mr-1 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                Retour
                            </a>
                        </div>

                        <!-- Ligne principale : Avatar + Infos -->
                        <div class="flex flex-col sm:flex-row sm:items-center gap-4 sm:gap-6">
                            <!-- Avatar -->
                            <div class="flex-shrink-0 relative self-center sm:self-auto">
                                <div
                                    class="h-24 w-24 sm:h-28 sm:w-28 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center border-4 border-white/30 shadow-xl overflow-hidden">
                                    @if($enseignant->photo)
                                        <img src="{{ Storage::url($enseignant->photo) }}" alt="{{ $enseignant->prenom ?? '' }}"
                                            class="h-full w-full object-cover">
                                    @else
                                        <span class="text-3xl sm:text-4xl font-bold text-white">
                                            {{ strtoupper(substr($enseignant->prenom ?? '', 0, 1)) }}{{ strtoupper(substr($enseignant->nom ?? '', 0, 1)) }}
                                        </span>
                                    @endif
                                </div>
                                <div class="absolute -bottom-1 -right-1">
                                    @if($enseignant->statut)
                                        <span
                                            class="flex h-6 w-6 sm:h-8 sm:w-8 items-center justify-center rounded-full bg-green-500 text-white shadow-lg border-2 border-white">
                                            <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </span>
                                    @else
                                        <span
                                            class="flex h-6 w-6 sm:h-8 sm:w-8 items-center justify-center rounded-full bg-red-500 text-white shadow-lg border-2 border-white">
                                            <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Infos Texte -->
                            <div class="flex-1 text-center sm:text-left">
                                <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-white mb-2 sm:mb-3">
                                    {{ $enseignant->prenom ?? '' }} {{ $enseignant->nom ?? '' }}
                                </h1>
                                <div class="flex flex-wrap gap-1.5 sm:gap-2 justify-center sm:justify-start">
                                    <span
                                        class="inline-flex items-center px-2 sm:px-3 py-0.5 sm:py-1.5 rounded-full text-xs font-medium bg-white/20 text-white border border-white/30">
                                        {{ $enseignant->genre === 'm' ? 'Masculin' : 'Féminin' }}
                                    </span>
                                    <span
                                        class="inline-flex items-center px-2 sm:px-3 py-0.5 sm:py-1.5 rounded-full text-xs font-medium bg-white/20 text-white border border-white/30">
                                        {{ $enseignant->specialite ?? 'Spécialité non définie' }}
                                    </span>
                                    <span
                                        class="inline-flex items-center px-2 sm:px-3 py-0.5 sm:py-1.5 rounded-full text-xs font-medium bg-white/20 text-white border border-white/30 hidden sm:inline-flex">
                                        Matricule: {{ $enseignant->matricule ?? 'N/A' }}
                                    </span>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex flex-row sm:flex-col gap-2 justify-center sm:justify-end sm:min-w-[140px]">
                                <a href="{{ route('admin.enseignants.edit', $enseignant) }}"
                                    class="flex-1 sm:flex-none inline-flex items-center justify-center px-3 py-2 sm:px-4 sm:py-2.5 bg-white/20 hover:bg-white/30 text-white text-xs sm:text-sm font-medium rounded-lg sm:rounded-xl transition-all duration-200 border border-white/30">
                                    <svg class="w-4 h-4 mr-1 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                        </path>
                                    </svg>
                                    Modifier
                                </a>
                                <button type="button"
                                    class="flex-1 sm:flex-none inline-flex items-center justify-center px-3 py-2 sm:px-4 sm:py-2.5 bg-red-500/20 hover:bg-red-500/30 text-white text-xs sm:text-sm font-medium rounded-lg sm:rounded-xl transition-all duration-200 border border-red-500/30 delete-btn"
                                    data-id="{{ $enseignant->id ?? 0 }}"
                                    data-name="{{ ($enseignant->prenom ?? '') . ' ' . ($enseignant->nom ?? '') }}">
                                    <svg class="w-4 h-4 mr-1 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                        </path>
                                    </svg>
                                    Supprimer
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grille d'informations -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6 mb-6">
                <!-- Informations personnelles -->
                <div class="bg-white rounded-xl sm:rounded-2xl shadow border border-gray-100 overflow-hidden">
                    <div
                        class="bg-gradient-to-r from-blue-50 to-indigo-50 px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200">
                        <div class="flex items-center">
                            <div class="bg-blue-200 p-1.5 sm:p-2 rounded-lg">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-blue-700" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <h3 class="ml-2 sm:ml-3 text-base sm:text-lg font-semibold text-gray-900">Infos personnelles
                            </h3>
                        </div>
                    </div>
                    <div class="p-4 sm:p-6 space-y-3 sm:space-y-4">
                        <div
                            class="flex flex-col sm:flex-row sm:justify-between sm:items-center border-b border-gray-100 pb-2 gap-1">
                            <span class="text-xs sm:text-sm font-medium text-gray-500">Nom complet</span>
                            <span
                                class="text-xs sm:text-sm font-semibold text-gray-900">{{ $enseignant->nom_complet ?? $enseignant->prenom . ' ' . $enseignant->nom }}</span>
                        </div>
                        <div
                            class="flex flex-col sm:flex-row sm:justify-between sm:items-center border-b border-gray-100 pb-2 gap-1">
                            <span class="text-xs sm:text-sm font-medium text-gray-500">Date de naissance</span>
                            <span
                                class="text-xs sm:text-sm font-semibold text-gray-900">{{ $enseignant->date_naissance?->format('d/m/Y') ?? 'Non définie' }}</span>
                        </div>
                        <div
                            class="flex flex-col sm:flex-row sm:justify-between sm:items-center border-b border-gray-100 pb-2 gap-1">
                            <span class="text-xs sm:text-sm font-medium text-gray-500">Lieu</span>
                            <span
                                class="text-xs sm:text-sm font-semibold text-gray-900">{{ $enseignant->lieu_naissance ?? '-' }}</span>
                        </div>
                        <div
                            class="flex flex-col sm:flex-row sm:justify-between sm:items-center border-b border-gray-100 pb-2 gap-1">
                            <span class="text-xs sm:text-sm font-medium text-gray-500">Genre</span>
                            <span
                                class="text-xs sm:text-sm font-semibold text-gray-900">{{ $enseignant->genre === 'm' ? 'Masculin' : 'Féminin' }}</span>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-1">
                            <span class="text-xs sm:text-sm font-medium text-gray-500">Âge</span>
                            <span class="text-xs sm:text-sm font-semibold text-gray-900">{{ $enseignant->age ?? 'N/A' }}
                                ans</span>
                        </div>
                    </div>
                </div>

                <!-- Coordonnées -->
                <div class="bg-white rounded-xl sm:rounded-2xl shadow border border-gray-100 overflow-hidden">
                    <div
                        class="bg-gradient-to-r from-green-50 to-emerald-50 px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200">
                        <div class="flex items-center">
                            <div class="bg-green-200 p-1.5 sm:p-2 rounded-lg">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-green-700" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="ml-2 sm:ml-3 text-base sm:text-lg font-semibold text-gray-900">Coordonnées</h3>
                        </div>
                    </div>
                    <div class="p-4 sm:p-6 space-y-3 sm:space-y-4">
                        <div
                            class="flex flex-col sm:flex-row sm:justify-between sm:items-center border-b border-gray-100 pb-2 gap-1">
                            <span class="text-xs sm:text-sm font-medium text-gray-500">Email</span>
                            <span
                                class="text-xs sm:text-sm font-semibold text-gray-900 break-all">{{ $enseignant->email ?? '-' }}</span>
                        </div>
                        <div
                            class="flex flex-col sm:flex-row sm:justify-between sm:items-center border-b border-gray-100 pb-2 gap-1">
                            <span class="text-xs sm:text-sm font-medium text-gray-500">Téléphone</span>
                            <span
                                class="text-xs sm:text-sm font-semibold text-gray-900">{{ $enseignant->telephone ?? '-' }}</span>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-1">
                            <span class="text-xs sm:text-sm font-medium text-gray-500">Adresse</span>
                            <span
                                class="text-xs sm:text-sm font-semibold text-gray-900 text-right">{{ $enseignant->adresse ?? '-' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Statistiques -->
                <div class="bg-white rounded-xl sm:rounded-2xl shadow border border-gray-100 overflow-hidden">
                    <div
                        class="bg-gradient-to-r from-purple-50 to-pink-50 px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200">
                        <div class="flex items-center">
                            <div class="bg-purple-200 p-1.5 sm:p-2 rounded-lg">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-purple-700" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="ml-2 sm:ml-3 text-base sm:text-lg font-semibold text-gray-900">Statistiques</h3>
                        </div>
                    </div>
                    <div class="p-4 sm:p-6">
                        <div class="grid grid-cols-2 gap-3 sm:gap-4">
                            <div class="bg-blue-50 rounded-lg sm:rounded-xl p-3 sm:p-4 text-center">
                                <p class="text-xl sm:text-2xl font-bold text-blue-600">{{ $enseignant->nombre_classes }}</p>
                                <p class="text-xs text-gray-500 mt-1">Classes</p>
                            </div>
                            <div class="bg-green-50 rounded-lg sm:rounded-xl p-3 sm:p-4 text-center">
                                <p class="text-xl sm:text-2xl font-bold text-green-600">{{ $enseignant->nombre_matieres }}
                                </p>
                                <p class="text-xs text-gray-500 mt-1">Matières</p>
                            </div>
                            <div class="bg-purple-50 rounded-lg sm:rounded-xl p-3 sm:p-4 text-center">
                                <p class="text-xl sm:text-2xl font-bold text-purple-600">
                                    {{ $enseignant->evaluations_count ?? $enseignant->evaluations->count() }}</p>
                                <p class="text-xs text-gray-500 mt-1">Évaluations</p>
                            </div>
                            <div class="bg-yellow-50 rounded-lg sm:rounded-xl p-3 sm:p-4 text-center">
                                <p class="text-xl sm:text-2xl font-bold text-yellow-600">
                                    {{ $enseignant->enseignantMatiereClasses->unique('classe_id')->count() }}</p>
                                <p class="text-xs text-gray-500 mt-1">Distinctes</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabs pour les affectations et évaluations -->
            <div class="bg-white rounded-xl sm:rounded-2xl shadow border border-gray-100 overflow-hidden mb-6">
                <div class="border-b border-gray-200 overflow-x-auto">
                    <nav class="flex whitespace-nowrap">
                        <button
                            class="tab-btn active px-4 sm:px-6 py-3 sm:py-4 text-xs sm:text-sm font-medium text-blue-600 border-b-2 border-blue-600 flex items-center"
                            data-tab="classes">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-1 sm:mr-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                </path>
                            </svg>
                            Classes & Matières
                        </button>
                        <button
                            class="tab-btn px-4 sm:px-6 py-3 sm:py-4 text-xs sm:text-sm font-medium text-gray-500 hover:text-gray-700 border-b-2 border-transparent flex items-center"
                            data-tab="evaluations">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-1 sm:mr-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                                </path>
                            </svg>
                            Évaluations
                        </button>
                    </nav>
                </div>

                <div class="p-4 sm:p-6">
                    <!-- Tab Classes -->
                    <div id="tab-classes" class="tab-content">
                        @if($enseignant->enseignantMatiereClasses->isNotEmpty())
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4">
                                @foreach($enseignant->enseignantMatiereClasses as $assignation)
                                    <div
                                        class="bg-gray-50 rounded-lg sm:rounded-xl p-4 sm:p-5 border border-gray-200 hover:shadow-sm transition-shadow">
                                        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-2">
                                            <div>
                                                <h4 class="font-semibold text-gray-900 text-sm sm:text-base">
                                                    {{ $assignation->classe->nom ?? 'Classe' }}</h4>
                                                <span
                                                    class="text-xs px-2 py-1 bg-indigo-100 text-indigo-800 rounded-full mt-1 inline-block">
                                                    {{ $assignation->matiere->nom ?? 'Matière' }}
                                                </span>
                                            </div>
                                            <div class="text-left sm:text-right">
                                                <span class="text-xs text-gray-500">Année</span>
                                                <p class="text-xs sm:text-sm font-medium">
                                                    {{ $assignation->anneeScolaire->libelle ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8 sm:py-12">
                                <svg class="w-12 h-12 sm:w-16 sm:h-16 text-gray-300 mx-auto mb-3 sm:mb-4" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                    </path>
                                </svg>
                                <p class="text-gray-500 text-sm sm:text-base">Aucune classe assignée</p>
                            </div>
                        @endif
                    </div>

                    <!-- Tab Évaluations -->
                    <div id="tab-evaluations" class="tab-content hidden">
                        @if($enseignant->evaluations->isNotEmpty())
                            <!-- Version Mobile : Cartes -->
                            <div class="md:hidden space-y-3">
                                @foreach($enseignant->evaluations as $evaluation)
                                    <div class="bg-white border rounded-lg p-4 shadow-sm">
                                        <div class="flex justify-between items-start mb-2">
                                            <h4 class="font-semibold text-gray-900 text-sm">{{ $evaluation->titre }}</h4>
                                            <span class="text-xs bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full">Coef.
                                                {{ $evaluation->coefficient }}</span>
                                        </div>
                                        <div class="grid grid-cols-2 gap-2 text-xs text-gray-600 mt-3">
                                            <div>
                                                <span class="text-gray-400 block">Classe</span>
                                                {{ $evaluation->classe->nom ?? 'N/A' }}
                                            </div>
                                            <div>
                                                <span class="text-gray-400 block">Matière</span>
                                                {{ $evaluation->matiere->nom ?? 'N/A' }}
                                            </div>
                                            <div class="col-span-2">
                                                <span class="text-gray-400 block">Date</span>
                                                {{ $evaluation->date ? $evaluation->date->format('d/m/Y') : '-' }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Version Desktop : Tableau -->
                            <div class="hidden md:block overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                                Évaluation</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Classe
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Matière
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Coef.
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($enseignant->evaluations as $evaluation)
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    {{ $evaluation->titre }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $evaluation->classe->nom ?? 'N/A' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $evaluation->matiere->nom ?? 'N/A' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $evaluation->date ? $evaluation->date->format('d/m/Y') : '-' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $evaluation->coefficient }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-8 sm:py-12">
                                <svg class="w-12 h-12 sm:w-16 sm:h-16 text-gray-300 mx-auto mb-3 sm:mb-4" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                    </path>
                                </svg>
                                <p class="text-gray-500 text-sm sm:text-base">Aucune évaluation</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Timeline -->
            <div class="bg-white rounded-xl sm:rounded-2xl shadow border border-gray-100 overflow-hidden">
                <div class="px-4 sm:px-6 py-3 sm:py-4 bg-gradient-to-r from-gray-50 to-white border-b border-gray-200">
                    <h3 class="text-base sm:text-lg font-semibold text-gray-900">Dernières activités</h3>
                </div>
                <div class="p-4 sm:p-6">
                    <div class="flow-root">
                        <ul class="-mb-6 sm:-mb-8">
                            @if($enseignant->created_at)
                                <li>
                                    <div class="relative pb-6 sm:pb-8">
                                        <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200"
                                            aria-hidden="true"></span>
                                        <div class="relative flex space-x-3 sm:space-x-4">
                                            <div>
                                                <span
                                                    class="h-6 w-6 sm:h-8 sm:w-8 rounded-full bg-green-500 flex items-center justify-center ring-4 sm:ring-8 ring-white">
                                                    <svg class="h-3 w-3 sm:h-5 sm:w-5 text-white" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                    </svg>
                                                </span>
                                            </div>
                                            <div class="flex min-w-0 flex-1 justify-between space-x-2 sm:space-x-4 pt-1.5">
                                                <div>
                                                    <p class="text-xs sm:text-sm text-gray-500">Enseignant créé</p>
                                                </div>
                                                <div class="whitespace-nowrap text-right text-xs sm:text-sm text-gray-500">
                                                    {{ $enseignant->created_at->diffForHumans() }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endif

                            @if($enseignant->updated_at && $enseignant->updated_at != $enseignant->created_at)
                                <li>
                                    <div class="relative pb-6 sm:pb-8">
                                        <div class="relative flex space-x-3 sm:space-x-4">
                                            <div>
                                                <span
                                                    class="h-6 w-6 sm:h-8 sm:w-8 rounded-full bg-blue-500 flex items-center justify-center ring-4 sm:ring-8 ring-white">
                                                    <svg class="h-3 w-3 sm:h-5 sm:w-5 text-white" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                        </path>
                                                    </svg>
                                                </span>
                                            </div>
                                            <div class="flex min-w-0 flex-1 justify-between space-x-2 sm:space-x-4 pt-1.5">
                                                <div>
                                                    <p class="text-xs sm:text-sm text-gray-500">Dernière modification</p>
                                                </div>
                                                <div class="whitespace-nowrap text-right text-xs sm:text-sm text-gray-500">
                                                    {{ $enseignant->updated_at->diffForHumans() }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endif

                            <!-- Ajout d'une activité pour les classes si existantes -->
                            @if($enseignant->enseignantMatiereClasses->isNotEmpty())
                                <li>
                                    <div class="relative flex space-x-3 sm:space-x-4">
                                        <div>
                                            <span
                                                class="h-6 w-6 sm:h-8 sm:w-8 rounded-full bg-purple-500 flex items-center justify-center ring-4 sm:ring-8 ring-white">
                                                <svg class="h-3 w-3 sm:h-5 sm:w-5 text-white" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                                    </path>
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="flex min-w-0 flex-1 justify-between space-x-2 sm:space-x-4 pt-1.5">
                                            <div>
                                                <p class="text-xs sm:text-sm text-gray-500">
                                                    {{ $enseignant->nombre_matieres }} matière(s) enseignée(s) dans
                                                    {{ $enseignant->nombre_classes }} classe(s)
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Gestion des tabs
                const tabBtns = document.querySelectorAll('.tab-btn');
                const tabContents = document.querySelectorAll('.tab-content');

                tabBtns.forEach(btn => {
                    btn.addEventListener('click', function () {
                        const tabId = this.dataset.tab;

                        tabBtns.forEach(b => {
                            b.classList.remove('active', 'text-blue-600', 'border-blue-600');
                            b.classList.add('text-gray-500', 'border-transparent');
                        });

                        this.classList.add('active', 'text-blue-600', 'border-blue-600');
                        this.classList.remove('text-gray-500', 'border-transparent');

                        tabContents.forEach(content => content.classList.add('hidden'));
                        document.getElementById(`tab-${tabId}`).classList.remove('hidden');
                    });
                });

                // Gestion suppression
                const deleteBtns = document.querySelectorAll('.delete-btn');
                deleteBtns.forEach(btn => {
                    btn.addEventListener('click', function (e) {
                        e.preventDefault();
                        const enseignantId = this.dataset.id;
                        const enseignantName = this.dataset.name;

                        Swal.fire({
                            title: 'Êtes-vous sûr ?',
                            text: `Supprimer ${enseignantName} ?`,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#ef4444',
                            cancelButtonColor: '#6b7280',
                            confirmButtonText: 'Oui, supprimer',
                            cancelButtonText: 'Annuler'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                const form = document.createElement('form');
                                form.method = 'POST';
                                form.action = '{{ route("admin.enseignants.destroy", ":id") }}'.replace(':id', enseignantId);

                                const csrfInput = document.createElement('input');
                                csrfInput.type = 'hidden';
                                csrfInput.name = '_token';
                                csrfInput.value = '{{ csrf_token() }}';
                                form.appendChild(csrfInput);

                                const methodInput = document.createElement('input');
                                methodInput.type = 'hidden';
                                methodInput.name = '_method';
                                methodInput.value = 'DELETE';
                                form.appendChild(methodInput);

                                document.body.appendChild(form);
                                form.submit();
                            }
                        });
                    });
                });
            });
        </script>
    @endpush
@endsection