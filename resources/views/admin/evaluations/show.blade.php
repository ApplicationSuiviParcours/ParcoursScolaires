@extends('layouts.app')

@section('title', 'Détails de l\'évaluation')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- En-tête -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 space-y-4 sm:space-y-0 animate__animated animate__fadeInDown">
            <div class="flex flex-wrap items-center gap-2 min-w-0">
                <div class="p-3 bg-gradient-to-r from-blue-600 to-purple-600 rounded-xl shadow-lg flex-shrink-0">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-800 truncate max-w-xs sm:max-w-sm lg:max-w-lg">
                    {{ $evaluation->nom }}
                </h1>
                @if($evaluation->date_evaluation->isFuture())
                    <span class="px-3 py-1 bg-green-100 text-green-800 text-xs sm:text-sm font-semibold rounded-full flex-shrink-0">À venir</span>
                @elseif($evaluation->date_evaluation->isToday())
                    <span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-xs sm:text-sm font-semibold rounded-full flex-shrink-0">Aujourd'hui</span>
                @else
                    <span class="px-3 py-1 bg-gray-100 text-gray-800 text-xs sm:text-sm font-semibold rounded-full flex-shrink-0">Passée</span>
                @endif
            </div>
            <!-- Boutons : pleine largeur sur mobile, auto sur sm+ -->
            <div class="flex flex-wrap gap-2 w-full sm:w-auto">
                <a href="{{ route('admin.evaluations.index') }}"
                   class="group inline-flex items-center px-4 py-2 sm:px-6 sm:py-3 bg-gray-100 text-gray-700 font-medium rounded-xl hover:bg-gray-200 hover:shadow-md transform hover:-translate-y-1 transition-all duration-300 text-sm">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-1.5 sm:mr-2 flex-shrink-0 group-hover:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Retour à la liste
                </a>
                <a href="{{ route('admin.evaluations.edit', $evaluation) }}"
                   class="group inline-flex items-center px-4 py-2 sm:px-6 sm:py-3 bg-yellow-100 text-yellow-700 font-medium rounded-xl hover:bg-yellow-200 hover:shadow-md transform hover:-translate-y-1 transition-all duration-300 text-sm">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-1.5 sm:mr-2 flex-shrink-0 group-hover:rotate-45 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Modifier
                </a>
            </div>
        </div>

        <!-- Alertes -->
        @if(session('success'))
            <div class="mb-6 animate__animated animate__fadeInDown">
                <div class="flex items-center p-4 bg-green-100 border-l-4 border-green-500 rounded-lg shadow-md" role="alert">
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-3"><p class="text-sm font-medium text-green-700">{{ session('success') }}</p></div>
                    <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-green-100 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex h-8 w-8" onclick="this.parentElement.remove()">
                        <span class="sr-only">Fermer</span>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </button>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 animate__animated animate__fadeInDown">
                <div class="flex items-center p-4 bg-red-100 border-l-4 border-red-500 rounded-lg shadow-md" role="alert">
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-3"><p class="text-sm font-medium text-red-700">{{ session('error') }}</p></div>
                    <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-red-100 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex h-8 w-8" onclick="this.parentElement.remove()">
                        <span class="sr-only">Fermer</span>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </button>
                </div>
            </div>
        @endif

        @if(session('info'))
            <div class="mb-6 animate__animated animate__fadeInDown">
                <div class="flex items-center p-4 bg-blue-100 border-l-4 border-blue-500 rounded-lg shadow-md" role="alert">
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-3"><p class="text-sm font-medium text-blue-700">{{ session('info') }}</p></div>
                    <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-blue-100 text-blue-500 rounded-lg focus:ring-2 focus:ring-blue-400 p-1.5 hover:bg-blue-200 inline-flex h-8 w-8" onclick="this.parentElement.remove()">
                        <span class="sr-only">Fermer</span>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </button>
                </div>
            </div>
        @endif

        <!-- Statistiques : 2 colonnes mobile → 4 colonnes md+ -->
        @if(isset($statistiques))
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6 mb-8 animate__animated animate__fadeInUp">
            <div class="bg-white/80 backdrop-blur-lg rounded-xl shadow-lg p-4 sm:p-6 border border-white/20 transform hover:scale-105 transition-transform duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs sm:text-sm text-gray-600 font-medium">Notes saisies</p>
                        <p class="text-xl sm:text-2xl font-bold text-gray-800">{{ $statistiques['notes_count'] ?? 0 }}</p>
                    </div>
                    <div class="p-2 sm:p-3 bg-blue-100 rounded-lg">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white/80 backdrop-blur-lg rounded-xl shadow-lg p-4 sm:p-6 border border-white/20 transform hover:scale-105 transition-transform duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs sm:text-sm text-gray-600 font-medium">Moyenne</p>
                        <p class="text-lg sm:text-2xl font-bold text-gray-800">
                            {{ $statistiques['moyenne'] ? number_format($statistiques['moyenne'], 2) . '/' . $evaluation->bareme : 'N/A' }}
                        </p>
                    </div>
                    <div class="p-2 sm:p-3 bg-green-100 rounded-lg">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white/80 backdrop-blur-lg rounded-xl shadow-lg p-4 sm:p-6 border border-white/20 transform hover:scale-105 transition-transform duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs sm:text-sm text-gray-600 font-medium">Taux de réussite</p>
                        <p class="text-xl sm:text-2xl font-bold text-gray-800">
                            {{ isset($statistiques['taux_reussite']) ? number_format($statistiques['taux_reussite'], 1) . '%' : 'N/A' }}
                        </p>
                    </div>
                    <div class="p-2 sm:p-3 bg-purple-100 rounded-lg">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white/80 backdrop-blur-lg rounded-xl shadow-lg p-4 sm:p-6 border border-white/20 transform hover:scale-105 transition-transform duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs sm:text-sm text-gray-600 font-medium">Min / Max</p>
                        <p class="text-lg sm:text-2xl font-bold text-gray-800">
                            @if($statistiques['notes_count'] > 0)
                                {{ number_format($statistiques['notes_min'], 2) }} / {{ number_format($statistiques['notes_max'], 2) }}
                            @else
                                N/A
                            @endif
                        </p>
                    </div>
                    <div class="p-2 sm:p-3 bg-orange-100 rounded-lg">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Informations principales : colonne unique sur mobile, 3 colonnes sur lg+ -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8 mb-8">

            <!-- Informations détaillées (2/3) -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl overflow-hidden border border-white/20 animate__animated animate__fadeInUp">
                    <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-4 sm:px-6 py-4">
                        <h2 class="text-lg sm:text-xl font-semibold text-white flex items-center">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Informations détaillées
                        </h2>
                    </div>
                    <div class="p-4 sm:p-6">
                        <!-- 1 col mobile → 2 col md+ -->
                        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="space-y-1">
                                <dt class="text-xs sm:text-sm font-medium text-gray-500">Nom de l'évaluation</dt>
                                <dd class="text-sm sm:text-base font-semibold text-gray-900">{{ $evaluation->nom }}</dd>
                            </div>

                            <div class="space-y-1">
                                <dt class="text-xs sm:text-sm font-medium text-gray-500">Type</dt>
                                <dd>
                                    @php
                                        $typeColors = [
                                            'devoir'  => 'bg-blue-100 text-blue-800',
                                            'examen'  => 'bg-red-100 text-red-800',
                                            'test'    => 'bg-green-100 text-green-800',
                                            'projet'  => 'bg-purple-100 text-purple-800',
                                            'autre'   => 'bg-gray-100 text-gray-800',
                                        ];
                                        $colorClass = $typeColors[$evaluation->type] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span class="px-3 py-1 inline-flex text-xs sm:text-sm leading-5 font-semibold rounded-full {{ $colorClass }}">
                                        {{ ucfirst($evaluation->type) }}
                                    </span>
                                </dd>
                            </div>

                            <div class="space-y-1">
                                <dt class="text-xs sm:text-sm font-medium text-gray-500">Classe</dt>
                                <dd class="text-sm sm:text-base text-gray-900">{{ $evaluation->classe->nom ?? '-' }}</dd>
                            </div>

                            <div class="space-y-1">
                                <dt class="text-xs sm:text-sm font-medium text-gray-500">Matière</dt>
                                <dd class="text-sm sm:text-base text-gray-900">{{ $evaluation->matiere->nom ?? '-' }}</dd>
                            </div>

                            <div class="space-y-1">
                                <dt class="text-xs sm:text-sm font-medium text-gray-500">Année scolaire</dt>
                                <dd class="text-sm sm:text-base text-gray-900">{{ $evaluation->anneeScolaire->nom ?? $evaluation->anneeScolaire->annee ?? '-' }}</dd>
                            </div>

                            <div class="space-y-1">
                                <dt class="text-xs sm:text-sm font-medium text-gray-500">Date</dt>
                                <dd class="text-sm sm:text-base text-gray-900 flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    {{ $evaluation->date_evaluation->format('d/m/Y') }}
                                </dd>
                            </div>

                            <div class="space-y-1">
                                <dt class="text-xs sm:text-sm font-medium text-gray-500">Coefficient</dt>
                                <dd>
                                    <span class="px-3 py-1 bg-gray-100 rounded-full text-sm font-medium">{{ $evaluation->coefficient }}</span>
                                </dd>
                            </div>

                            <div class="space-y-1">
                                <dt class="text-xs sm:text-sm font-medium text-gray-500">Barème</dt>
                                <dd>
                                    <span class="px-3 py-1 bg-purple-100 rounded-full text-sm font-medium text-purple-700">{{ $evaluation->bareme }}</span>
                                </dd>
                            </div>

                            <div class="space-y-1 sm:col-span-2">
                                <dt class="text-xs sm:text-sm font-medium text-gray-500">Période</dt>
                                <dd class="text-sm sm:text-base text-gray-900">{{ $evaluation->periode ?? 'Non spécifiée' }}</dd>
                            </div>

                            <div class="space-y-1 sm:col-span-2">
                                <dt class="text-xs sm:text-sm font-medium text-gray-500">Description</dt>
                                <dd class="text-sm sm:text-base text-gray-900 bg-gray-50 p-3 sm:p-4 rounded-lg">
                                    {{ $evaluation->description ?? 'Aucune description fournie' }}
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>

            <!-- Colonne droite : Actions + Enseignant -->
            <div class="space-y-6">
                <!-- Actions rapides -->
                <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl overflow-hidden border border-white/20 animate__animated animate__fadeInUp">
                    <div class="bg-gradient-to-r from-purple-600 to-pink-600 px-4 sm:px-6 py-4">
                        <h2 class="text-lg sm:text-xl font-semibold text-white flex items-center">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                            </svg>
                            Actions
                        </h2>
                    </div>
                    <!-- Sur mobile : grille 2 colonnes pour les boutons. Sur lg : colonne unique -->
                    <div class="p-4 sm:p-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-1 gap-3">
                        <a href="{{ route('admin.evaluations.edit', $evaluation) }}"
                           class="w-full inline-flex items-center justify-center px-5 py-3 bg-yellow-100 text-yellow-700 font-medium rounded-xl hover:bg-yellow-200 hover:shadow-md transform hover:-translate-y-1 transition-all duration-300 text-sm">
                            <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Modifier l'évaluation
                        </a>

                        <a href="{{ route('admin.evaluations.duplicate', $evaluation) }}"
                           class="w-full inline-flex items-center justify-center px-5 py-3 bg-green-100 text-green-700 font-medium rounded-xl hover:bg-green-200 hover:shadow-md transform hover:-translate-y-1 transition-all duration-300 text-sm"
                           onclick="return confirm('Créer une copie de cette évaluation ?')">
                            <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                            </svg>
                            Dupliquer
                        </a>

                        @if($evaluation->notes()->count() > 0)
                            <a href="{{ route('admin.evaluations.export', $evaluation) }}"
                               class="w-full inline-flex items-center justify-center px-5 py-3 bg-purple-100 text-purple-700 font-medium rounded-xl hover:bg-purple-200 hover:shadow-md transform hover:-translate-y-1 transition-all duration-300 text-sm">
                                <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Exporter les notes
                            </a>
                        @endif

                        <form action="{{ route('admin.evaluations.destroy', $evaluation) }}" method="POST" class="w-full sm:col-span-2 lg:col-span-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="w-full inline-flex items-center justify-center px-5 py-3 bg-red-100 text-red-700 font-medium rounded-xl hover:bg-red-200 hover:shadow-md transform hover:-translate-y-1 transition-all duration-300 text-sm"
                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette évaluation ? Cette action est irréversible.')">
                                <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Supprimer
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Enseignant responsable -->
                <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl overflow-hidden border border-white/20 animate__animated animate__fadeInUp">
                    <div class="bg-gradient-to-r from-indigo-600 to-blue-600 px-4 sm:px-6 py-4">
                        <h3 class="text-base sm:text-lg font-semibold text-white flex items-center">
                            <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Enseignant responsable
                        </h3>
                    </div>
                    <div class="p-4 sm:p-6">
                        @if($evaluation->enseignant)
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 sm:w-12 sm:h-12 flex-shrink-0 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center text-white font-bold text-base sm:text-lg">
                                    {{ substr($evaluation->enseignant->nom ?? 'U', 0, 1) }}{{ substr($evaluation->enseignant->prenom ?? '', 0, 1) }}
                                </div>
                                <div class="min-w-0">
                                    <p class="font-semibold text-gray-900 text-sm sm:text-base truncate">
                                        {{ $evaluation->enseignant->nom ?? '' }} {{ $evaluation->enseignant->prenom ?? '' }}
                                    </p>
                                    <p class="text-xs sm:text-sm text-gray-500 truncate">{{ $evaluation->enseignant->email ?? '' }}</p>
                                </div>
                            </div>
                        @else
                            <p class="text-gray-500 text-sm">Aucun enseignant assigné</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Notes de l'évaluation -->
        <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl overflow-hidden border border-white/20 animate__animated animate__fadeInUp">
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-4 sm:px-6 py-4 flex flex-wrap items-center justify-between gap-2">
                <h2 class="text-lg sm:text-xl font-semibold text-white flex items-center">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Notes ({{ $evaluation->notes->count() }})
                </h2>
                @if($evaluation->notes->count() > 0)
                    <span class="px-3 py-1 bg-white/20 text-white rounded-full text-xs sm:text-sm">
                        Moyenne : {{ $statistiques['moyenne'] ? number_format($statistiques['moyenne'], 2) . '/' . $evaluation->bareme : 'N/A' }}
                    </span>
                @endif
            </div>

            <div class="p-4 sm:p-6">
                @if($evaluation->notes->count() > 0)

                    <!-- TABLEAU — visible sur md+ -->
                    <div class="hidden md:block overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Élève</th>
                                    <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Note</th>
                                    <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ramenée sur 20</th>
                                    <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Appréciation</th>
                                    <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($evaluation->notes as $note)
                                    <tr class="hover:bg-gray-50 transition-colors duration-300">
                                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-9 w-9 sm:h-10 sm:w-10 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center text-white font-semibold text-sm">
                                                    {{ substr($note->eleve->nom ?? 'U', 0, 1) }}{{ substr($note->eleve->prenom ?? '', 0, 1) }}
                                                </div>
                                                <div class="ml-3 sm:ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $note->eleve->nom ?? '' }} {{ $note->eleve->prenom ?? '' }}
                                                    </div>
                                                    <div class="text-xs text-gray-500">{{ $note->eleve->matricule ?? '' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                            <span class="text-lg font-bold {{ $note->note >= 10 ? 'text-green-600' : 'text-red-600' }}">
                                                {{ number_format($note->note, 2) }}
                                            </span>
                                            <span class="text-sm text-gray-500 ml-1">/{{ $evaluation->bareme }}</span>
                                        </td>
                                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                            @php $noteSur20 = ($note->note / $evaluation->bareme) * 20; @endphp
                                            <span class="text-sm {{ $noteSur20 >= 10 ? 'text-green-600' : 'text-red-600' }}">
                                                {{ number_format($noteSur20, 2) }}/20
                                            </span>
                                        </td>
                                        <td class="px-4 sm:px-6 py-4">
                                            <p class="text-sm text-gray-900">{{ $note->commentaire ?? '-' }}</p>
                                        </td>
                                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                            @if($note->est_abscent)
                                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Absent</span>
                                            @elseif($note->est_rapport)
                                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Rapport</span>
                                            @else
                                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Présent</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- CARTES NOTES — visible sur mobile uniquement (< md) -->
                    <div class="md:hidden space-y-3">
                        @foreach($evaluation->notes as $note)
                            @php $noteSur20 = ($note->note / $evaluation->bareme) * 20; @endphp
                            <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                                <!-- Élève + Statut -->
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center space-x-3 min-w-0">
                                        <div class="flex-shrink-0 h-9 w-9 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center text-white font-semibold text-sm">
                                            {{ substr($note->eleve->nom ?? 'U', 0, 1) }}{{ substr($note->eleve->prenom ?? '', 0, 1) }}
                                        </div>
                                        <div class="min-w-0">
                                            <p class="text-sm font-medium text-gray-900 truncate">
                                                {{ $note->eleve->nom ?? '' }} {{ $note->eleve->prenom ?? '' }}
                                            </p>
                                            <p class="text-xs text-gray-500">{{ $note->eleve->matricule ?? '' }}</p>
                                        </div>
                                    </div>
                                    @if($note->est_abscent)
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800 flex-shrink-0">Absent</span>
                                    @elseif($note->est_rapport)
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800 flex-shrink-0">Rapport</span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 flex-shrink-0">Présent</span>
                                    @endif
                                </div>
                                <!-- Notes -->
                                <div class="grid grid-cols-2 gap-3 mb-2">
                                    <div>
                                        <p class="text-xs text-gray-500 uppercase tracking-wide mb-0.5">Note</p>
                                        <p>
                                            <span class="text-base font-bold {{ $note->note >= 10 ? 'text-green-600' : 'text-red-600' }}">
                                                {{ number_format($note->note, 2) }}
                                            </span>
                                            <span class="text-xs text-gray-500">/{{ $evaluation->bareme }}</span>
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 uppercase tracking-wide mb-0.5">Sur 20</p>
                                        <p class="text-base font-bold {{ $noteSur20 >= 10 ? 'text-green-600' : 'text-red-600' }}">
                                            {{ number_format($noteSur20, 2) }}<span class="text-xs font-normal text-gray-500">/20</span>
                                        </p>
                                    </div>
                                </div>
                                @if($note->commentaire)
                                    <p class="text-xs text-gray-500 uppercase tracking-wide mb-0.5">Appréciation</p>
                                    <p class="text-sm text-gray-700">{{ $note->commentaire }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>

                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Aucune note</h3>
                        <p class="mt-1 text-sm text-gray-500">Aucune note n'a encore été enregistrée pour cette évaluation.</p>
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>

@push('styles')
<style>
    @keyframes fadeInDown {
        from { opacity: 0; transform: translateY(-20px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .animate__animated   { animation-duration: 0.6s; animation-fill-mode: both; }
    .animate__fadeInDown { animation-name: fadeInDown; }
    .animate__fadeInUp   { animation-name: fadeInUp; }
    .animate__delay-1s   { animation-delay: 0.2s; }
</style>
@endpush
@endsection