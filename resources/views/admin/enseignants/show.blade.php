@extends('layouts.app')

@section('header')
<h2 class="font-semibold text-xl text-gray-800 leading-tight">
    {{ __('Détails de l\'enseignant') }}
</h2>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <!-- Messages flash -->
        @if(session('success'))
            <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-r-lg shadow-md animate-slideDown" role="alert">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-green-500 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-sm font-medium">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-r-lg shadow-md animate-slideDown" role="alert">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-red-500 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-sm font-medium">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        <!-- Header avec navigation -->
        <div class="bg-gradient-to-r from-indigo-600 via-indigo-700 to-purple-700 rounded-2xl shadow-2xl mb-8 overflow-hidden relative group">
            <div class="absolute inset-0 bg-gradient-to-r from-white/10 to-transparent"></div>
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -translate-y-32 translate-x-32 group-hover:translate-y-0 group-hover:translate-x-0 transition-transform duration-700"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/5 rounded-full translate-y-24 -translate-x-24 group-hover:translate-y-0 group-hover:translate-x-0 transition-transform duration-700"></div>

            <div class="relative px-8 py-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div class="flex items-center space-x-4 mb-4 md:mb-0">
                        <div class="bg-white/20 p-3 rounded-xl backdrop-blur-sm group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-white">Profil enseignant</h3>
                            <p class="text-indigo-100 text-sm mt-1">Informations détaillées et affectations</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('admin.enseignants.index') }}"
                           class="inline-flex items-center px-4 py-2 bg-white/20 hover:bg-white/30 text-white text-sm font-medium rounded-xl transition-all duration-200 backdrop-blur-sm border border-white/30 group">
                            <svg class="w-4 h-4 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Retour à la liste
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Carte principale avec photo et infos -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-700 px-8 py-8">
                <div class="flex flex-col md:flex-row md:items-center gap-6">
                    <!-- Avatar / Photo -->
                    <div class="flex-shrink-0 relative group/photo">
                        <div class="h-28 w-28 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center border-4 border-white/30 shadow-xl group-hover/photo:scale-105 transition-transform duration-300 overflow-hidden">
                            @if($enseignant->photo)
                                <img src="{{ Storage::url($enseignant->photo) }}" alt="{{ $enseignant->prenom ?? '' }}" class="h-full w-full object-cover">
                            @else
                                <span class="text-4xl font-bold text-white">
                                    {{ strtoupper(substr($enseignant->prenom ?? '', 0, 1)) }}{{ strtoupper(substr($enseignant->nom ?? '', 0, 1)) }}
                                </span>
                            @endif
                        </div>
                        <div class="absolute -bottom-2 -right-2">
                            @if($enseignant->statut)
                                <span class="flex h-8 w-8 items-center justify-center rounded-full bg-green-500 text-white shadow-lg border-2 border-white">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </span>
                            @else
                                <span class="flex h-8 w-8 items-center justify-center rounded-full bg-red-500 text-white shadow-lg border-2 border-white">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Infos principales -->
                    <div class="flex-1">
                        <h1 class="text-3xl md:text-4xl font-bold text-white mb-3">
                            {{ $enseignant->prenom ?? '' }} {{ $enseignant->nom ?? '' }}
                        </h1>
                        <div class="flex flex-wrap gap-2">
                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-white/20 text-white border border-white/30">
                                <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                {{ $enseignant->genre === 'm' ? 'Masculin' : 'Féminin' }}
                            </span>
                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-white/20 text-white border border-white/30">
                                <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                {{ $enseignant->specialite ?? 'Spécialité non définie' }}
                            </span>
                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-white/20 text-white border border-white/30">
                                <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                                </svg>
                                Matricule: {{ $enseignant->matricule ?? 'ENS-'.str_pad($enseignant->id ?? 0, 4, '0', STR_PAD_LEFT) }}
                            </span>
                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-white/20 text-white border border-white/30">
                                <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Âge: {{ $enseignant->age ?? 'N/A' }} ans
                            </span>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex flex-col gap-2 min-w-[140px]">
                        <a href="{{ route('admin.enseignants.edit', $enseignant) }}"
                           class="inline-flex items-center justify-center px-4 py-2.5 bg-white/20 hover:bg-white/30 text-white text-sm font-medium rounded-xl transition-all duration-200 backdrop-blur-sm border border-white/30 group hover:scale-105">
                            <svg class="w-4 h-4 mr-2 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Modifier
                        </a>
                        <button type="button"
                                class="inline-flex items-center justify-center px-4 py-2.5 bg-red-500/20 hover:bg-red-500/30 text-white text-sm font-medium rounded-xl transition-all duration-200 backdrop-blur-sm border border-red-500/30 group hover:scale-105 delete-btn"
                                data-id="{{ $enseignant->id ?? 0 }}"
                                data-name="{{ ($enseignant->prenom ?? '') . ' ' . ($enseignant->nom ?? '') }}">
                            <svg class="w-4 h-4 mr-2 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Supprimer
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grille d'informations -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
            <!-- Informations personnelles -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center">
                        <div class="bg-blue-200 p-2 rounded-lg">
                            <svg class="w-5 h-5 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <h3 class="ml-3 text-lg font-semibold text-gray-900">Informations personnelles</h3>
                    </div>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex justify-between items-center border-b border-gray-100 pb-2">
                        <span class="text-sm font-medium text-gray-500">Nom complet</span>
                        <span class="text-sm font-semibold text-gray-900">{{ $enseignant->nom_complet ?? $enseignant->prenom . ' ' . $enseignant->nom }}</span>
                    </div>
                    <div class="flex justify-between items-center border-b border-gray-100 pb-2">
                        <span class="text-sm font-medium text-gray-500">Date de naissance</span>
                        <span class="text-sm font-semibold text-gray-900">{{ $enseignant->date_naissance?->format('d/m/Y') ?? 'Non définie' }}</span>
                    </div>
                    <div class="flex justify-between items-center border-b border-gray-100 pb-2">
                        <span class="text-sm font-medium text-gray-500">Lieu de naissance</span>
                        <span class="text-sm font-semibold text-gray-900">{{ $enseignant->lieu_naissance ?? 'Non défini' }}</span>
                    </div>
                    <div class="flex justify-between items-center border-b border-gray-100 pb-2">
                        <span class="text-sm font-medium text-gray-500">Âge</span>
                        <span class="text-sm font-semibold text-gray-900">{{ $enseignant->age ?? 'N/A' }} ans</span>
                    </div>
                    <div class="flex justify-between items-center border-b border-gray-100 pb-2">
                        <span class="text-sm font-medium text-gray-500">Genre</span>
                        <span class="text-sm font-semibold text-gray-900">
                            @if($enseignant->genre === 'm')
                                <span class="text-blue-600">Masculin</span>
                            @else
                                <span class="text-pink-600">Féminin</span>
                            @endif
                        </span>
                    </div>
                </div>
            </div>

            <!-- Coordonnées -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center">
                        <div class="bg-green-200 p-2 rounded-lg">
                            <svg class="w-5 h-5 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h3 class="ml-3 text-lg font-semibold text-gray-900">Coordonnées</h3>
                    </div>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex justify-between items-center border-b border-gray-100 pb-2">
                        <span class="text-sm font-medium text-gray-500">Email</span>
                        <span class="text-sm font-semibold text-gray-900">{{ $enseignant->email ?? 'Non défini' }}</span>
                    </div>
                    <div class="flex justify-between items-center border-b border-gray-100 pb-2">
                        <span class="text-sm font-medium text-gray-500">Téléphone</span>
                        <span class="text-sm font-semibold text-gray-900">{{ $enseignant->telephone ?? 'Non défini' }}</span>
                    </div>
                    <div class="flex justify-between items-center border-b border-gray-100 pb-2">
                        <span class="text-sm font-medium text-gray-500">Adresse</span>
                        <span class="text-sm font-semibold text-gray-900 text-right">{{ $enseignant->adresse ?? 'Non définie' }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-medium text-gray-500">Utilisateur associé</span>
                        <span class="text-sm font-semibold text-gray-900">
                            @if($enseignant->user)
                                <a href="{{ route('admin.users.show', $enseignant->user) }}" class="text-blue-600 hover:underline">
                                    {{ $enseignant->user->name }}
                                </a>
                            @else
                                Non associé
                            @endif
                        </span>
                    </div>
                </div>
            </div>

            <!-- Statistiques -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-purple-50 to-pink-50 px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center">
                        <div class="bg-purple-200 p-2 rounded-lg">
                            <svg class="w-5 h-5 text-purple-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <h3 class="ml-3 text-lg font-semibold text-gray-900">Statistiques</h3>
                    </div>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-blue-50 rounded-xl p-4 text-center">
                            <p class="text-2xl font-bold text-blue-600">{{ $enseignant->nombre_classes }}</p>
                            <p class="text-xs text-gray-500 mt-1">Classes</p>
                        </div>
                        <div class="bg-green-50 rounded-xl p-4 text-center">
                            <p class="text-2xl font-bold text-green-600">{{ $enseignant->nombre_matieres }}</p>
                            <p class="text-xs text-gray-500 mt-1">Matières</p>
                        </div>
                        <div class="bg-purple-50 rounded-xl p-4 text-center">
                            <p class="text-2xl font-bold text-purple-600">{{ $enseignant->evaluations_count ?? $enseignant->evaluations->count() }}</p>
                            <p class="text-xs text-gray-500 mt-1">Évaluations</p>
                        </div>
                        <div class="bg-yellow-50 rounded-xl p-4 text-center">
                            <p class="text-2xl font-bold text-yellow-600">
                                {{ $enseignant->enseignantMatiereClasses->unique('classe_id')->count() }}
                            </p>
                            <p class="text-xs text-gray-500 mt-1">Classes distinctes</p>
                        </div>
                    </div>

                    @if($enseignant->created_at)
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <p class="text-xs text-gray-500 text-center">
                            Enseignant depuis le {{ $enseignant->created_at->format('d/m/Y') }}
                        </p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Tabs pour les affectations et évaluations -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden mb-6">
            <div class="border-b border-gray-200">
                <nav class="flex -mb-px">
                    <button class="tab-btn active px-6 py-4 text-sm font-medium text-blue-600 border-b-2 border-blue-600 flex items-center" data-tab="classes">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        Classes & Matières
                    </button>
                    <button class="tab-btn px-6 py-4 text-sm font-medium text-gray-500 hover:text-gray-700 border-b-2 border-transparent flex items-center" data-tab="evaluations">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                        </svg>
                        Évaluations
                    </button>
                </nav>
            </div>

            <!-- Contenu des tabs -->
            <div class="p-6">
                <!-- Tab Classes & Matières -->
                <div id="tab-classes" class="tab-content">
                    @if($enseignant->enseignantMatiereClasses->isNotEmpty())
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($enseignant->enseignantMatiereClasses as $assignation)
                                <div class="bg-gray-50 rounded-xl p-5 border border-gray-200 hover:shadow-md transition-shadow duration-200">
                                    <div class="flex items-start justify-between">
                                        <div>
                                            <h4 class="font-semibold text-gray-900">{{ $assignation->classe->nom ?? 'Classe' }}</h4>
                                            <div class="flex items-center mt-2">
                                                <span class="text-xs px-2 py-1 bg-indigo-100 text-indigo-800 rounded-full">
                                                    {{ $assignation->matiere->nom ?? 'Matière' }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <span class="text-xs text-gray-500">Année scolaire</span>
                                            <p class="text-sm font-medium">{{ $assignation->anneeScolaire->libelle ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            <p class="text-gray-500 text-lg">Aucune classe assignée</p>
                            <p class="text-gray-400 text-sm mt-1">Cet enseignant n'enseigne pas encore dans une classe</p>
                            <a href="{{ route('admin.enseignants.create', ['enseignant' => $enseignant->id]) }}"
                               class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Assigner une classe
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Tab Évaluations -->
                <div id="tab-evaluations" class="tab-content hidden">
                    @if($enseignant->evaluations->isNotEmpty())
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Évaluation</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Classe</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Matière</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Coefficient</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($enseignant->evaluations as $evaluation)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ $evaluation->titre }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $evaluation->classe->nom ?? 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $evaluation->matiere->nom ?? 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                @if($evaluation->date)
                                                    {{ $evaluation->date->format('d/m/Y') }}
                                                @else
                                                    <span class="text-gray-400 italic">Non définie</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $evaluation->coefficient }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            <p class="text-gray-500 text-lg">Aucune évaluation</p>
                            <p class="text-gray-400 text-sm mt-1">Cet enseignant n'a pas encore créé d'évaluation</p>
                            <a href="{{ route('admin.evaluations.create', ['enseignant_id' => $enseignant->id]) }}"
                               class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Créer une évaluation
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Timeline des dernières activités (optionnel) -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-white border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Dernières activités</h3>
            </div>
            <div class="p-6">
                <div class="flow-root">
                    <ul class="-mb-8">
                        @if($enseignant->created_at)
                        <li>
                            <div class="relative pb-8">
                                <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                <div class="relative flex space-x-3">
                                    <div>
                                        <span class="h-8 w-8 rounded-full bg-green-500 flex items-center justify-center ring-8 ring-white">
                                            <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-1.5">
                                        <div>
                                            <p class="text-sm text-gray-500">Enseignant créé dans le système</p>
                                        </div>
                                        <div class="whitespace-nowrap text-right text-sm text-gray-500">
                                            <time datetime="{{ $enseignant->created_at->format('Y-m-d') }}">
                                                {{ $enseignant->created_at->diffForHumans() }}
                                            </time>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        @endif

                        @if($enseignant->updated_at && $enseignant->updated_at != $enseignant->created_at)
                        <li>
                            <div class="relative pb-8">
                                <div class="relative flex space-x-3">
                                    <div>
                                        <span class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center ring-8 ring-white">
                                            <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-1.5">
                                        <div>
                                            <p class="text-sm text-gray-500">Dernière modification du profil</p>
                                        </div>
                                        <div class="whitespace-nowrap text-right text-sm text-gray-500">
                                            <time datetime="{{ $enseignant->updated_at->format('Y-m-d') }}">
                                                {{ $enseignant->updated_at->diffForHumans() }}
                                            </time>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        @endif

                        @if($enseignant->enseignantMatiereClasses->isNotEmpty())
                        <li>
                            <div class="relative flex space-x-3">
                                <div>
                                    <span class="h-8 w-8 rounded-full bg-purple-500 flex items-center justify-center ring-8 ring-white">
                                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                        </svg>
                                    </span>
                                </div>
                                <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-1.5">
                                    <div>
                                        <p class="text-sm text-gray-500">
                                            {{ $enseignant->nombre_matieres }} matière(s) enseignée(s) dans {{ $enseignant->nombre_classes }} classe(s)
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

@push('styles')
<style>
    /* Animations */
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

    .animate-slideDown {
        animation: slideDown 0.3s ease-out;
    }

    /* Transitions pour les tabs */
    .tab-content {
        transition: opacity 0.2s ease-in-out;
    }

    .tab-content.hidden {
        display: none;
    }

    /* Hover effects */
    .hover\:scale-105:hover {
        transform: scale(1.05);
    }

    /* Style pour les badges */
    .badge {
        @apply inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gestion des tabs
    const tabBtns = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');

    tabBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const tabId = this.dataset.tab;

            // Désactiver tous les tabs
            tabBtns.forEach(b => {
                b.classList.remove('active', 'text-blue-600', 'border-blue-600');
                b.classList.add('text-gray-500', 'border-transparent');
            });

            // Activer le tab courant
            this.classList.add('active', 'text-blue-600', 'border-blue-600');
            this.classList.remove('text-gray-500', 'border-transparent');

            // Cacher tous les contenus
            tabContents.forEach(content => {
                content.classList.add('hidden');
            });

            // Afficher le contenu correspondant
            document.getElementById(`tab-${tabId}`).classList.remove('hidden');
        });
    });

    // Gestion de la suppression avec SweetAlert2
    const deleteBtns = document.querySelectorAll('.delete-btn');
    deleteBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const enseignantId = this.dataset.id;
            const enseignantName = this.dataset.name;

            Swal.fire({
                title: 'Êtes-vous sûr ?',
                text: `L'enseignant ${enseignantName} sera définitivement supprimé. Cette action est irréversible !`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Oui, supprimer',
                cancelButtonText: 'Annuler',
                background: '#fff',
                backdrop: `rgba(0,0,0,0.4)`,
                customClass: {
                    title: 'text-lg font-semibold',
                    htmlContainer: 'text-sm text-gray-600',
                    confirmButton: 'px-4 py-2 rounded-lg',
                    cancelButton: 'px-4 py-2 rounded-lg'
                }
            }).then((result) => {
                if(result.isConfirmed){
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

    // Animation d'apparition progressive des éléments
    const cards = document.querySelectorAll('.bg-white');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        setTimeout(() => {
            card.style.transition = 'all 0.5s ease-out';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, 100 * index);
    });
});
</script>
@endpush
@endsection
