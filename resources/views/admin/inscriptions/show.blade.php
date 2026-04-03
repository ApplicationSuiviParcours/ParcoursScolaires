@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-lg sm:text-xl text-gray-800 leading-tight">
        {{ __('Détails de l\'inscription') }}
    </h2>
@endsection

@section('content')
    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <!-- En-tête -->
                <div class="bg-gradient-to-r from-green-600 to-green-800 px-4 sm:px-6 py-4 sm:py-5">
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                        <h3 class="text-lg sm:text-xl font-bold text-white">Fiche d'inscription</h3>
                        <div class="flex space-x-2 w-full sm:w-auto justify-center">
                            <a href="{{ route('admin.inscriptions.edit', $inscription) }}"
                                class="inline-flex items-center justify-center flex-1 sm:flex-none px-3 sm:px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-medium rounded-lg transition duration-200">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                    </path>
                                </svg>
                                Modifier
                            </a>
                            <a href="{{ route('admin.inscriptions.index') }}"
                                class="inline-flex items-center justify-center flex-1 sm:flex-none px-3 sm:px-4 py-2 bg-white/20 hover:bg-white/30 text-white text-sm font-medium rounded-lg transition duration-200 border border-white/30">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                Retour
                            </a>
                        </div>
                    </div>
                </div>

                <div class="p-4 sm:p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                        <!-- Informations élève -->
                        <div class="bg-gray-50 rounded-lg p-4 sm:p-6">
                            <h4 class="text-base sm:text-lg font-semibold text-gray-900 mb-3 sm:mb-4 flex items-center">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Élève
                            </h4>
                            <div class="space-y-2 sm:space-y-3 text-sm sm:text-base">
                                <div class="flex flex-col sm:flex-row sm:justify-between">
                                    <span class="font-medium text-gray-600">Nom complet:</span>
                                    <span class="text-gray-900 mt-0.5 sm:mt-0">{{ $inscription->eleve->nom }} {{ $inscription->eleve->prenom }}</span>
                                </div>
                                <div class="flex flex-col sm:flex-row sm:justify-between">
                                    <span class="font-medium text-gray-600">Matricule:</span>
                                    <span class="text-gray-900 mt-0.5 sm:mt-0 bg-gray-200 px-2 py-0.5 rounded text-xs sm:text-sm inline-block sm:bg-transparent sm:p-0 sm:text-base">{{ $inscription->eleve->matricule ?? 'N/A' }}</span>
                                </div>
                                <div class="flex flex-col sm:flex-row sm:justify-between">
                                    <span class="font-medium text-gray-600">Date naissance:</span>
                                    <span class="text-gray-900 mt-0.5 sm:mt-0">{{ $inscription->eleve->date_naissance ? \Carbon\Carbon::parse($inscription->eleve->date_naissance)->format('d/m/Y') : 'N/A' }}</span>
                                </div>
                                <div class="flex flex-col sm:flex-row sm:justify-between">
                                    <span class="font-medium text-gray-600">Genre:</span>
                                    <span class="text-gray-900 mt-0.5 sm:mt-0">{{ $inscription->eleve->genre == 'M' ? 'Masculin' : ($inscription->eleve->genre == 'F' ? 'Féminin' : 'N/A') }}</span>
                                </div>
                                <div class="flex flex-col sm:flex-row sm:justify-between">
                                    <span class="font-medium text-gray-600">Téléphone:</span>
                                    <span class="text-gray-900 mt-0.5 sm:mt-0">{{ $inscription->eleve->telephone ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Informations classe -->
                        <div class="bg-gray-50 rounded-lg p-4 sm:p-6">
                            <h4 class="text-base sm:text-lg font-semibold text-gray-900 mb-3 sm:mb-4 flex items-center">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                    </path>
                                </svg>
                                Classe
                            </h4>
                            <div class="space-y-2 sm:space-y-3 text-sm sm:text-base">
                                <div class="flex flex-col sm:flex-row sm:justify-between">
                                    <span class="font-medium text-gray-600">Classe:</span>
                                    <span class="text-gray-900 font-semibold mt-0.5 sm:mt-0">{{ $inscription->classe->nom }}</span>
                                </div>
                                <div class="flex flex-col sm:flex-row sm:justify-between">
                                    <span class="font-medium text-gray-600">Niveau:</span>
                                    <span class="text-gray-900 mt-0.5 sm:mt-0">{{ $inscription->classe->niveau }}</span>
                                </div>
                                @if($inscription->classe->serie)
                                    <div class="flex flex-col sm:flex-row sm:justify-between">
                                        <span class="font-medium text-gray-600">Série:</span>
                                        <span class="text-gray-900 mt-0.5 sm:mt-0">{{ $inscription->classe->serie }}</span>
                                    </div>
                                @endif
                                <div class="flex flex-col sm:flex-row sm:justify-between">
                                    <span class="font-medium text-gray-600">Capacité:</span>
                                    <span class="text-gray-900 mt-0.5 sm:mt-0">{{ $inscription->classe->capacite }} élèves</span>
                                </div>
                            </div>
                        </div>

                        <!-- Informations inscription -->
                        <div class="bg-gray-50 rounded-lg p-4 sm:p-6 md:col-span-2">
                            <h4 class="text-base sm:text-lg font-semibold text-gray-900 mb-3 sm:mb-4 flex items-center">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Détails de l'inscription
                            </h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3 sm:gap-4">
                                <div class="bg-white p-3 rounded-lg border border-gray-100">
                                    <p class="text-xs text-gray-500 mb-1">Année scolaire</p>
                                    <p class="text-sm sm:text-base font-semibold text-gray-900">{{ $inscription->anneeScolaire->nom }}</p>
                                </div>
                                <div class="bg-white p-3 rounded-lg border border-gray-100">
                                    <p class="text-xs text-gray-500 mb-1">Date d'inscription</p>
                                    <p class="text-sm sm:text-base font-semibold text-gray-900">
                                        {{ \Carbon\Carbon::parse($inscription->date_inscription)->format('d/m/Y') }}</p>
                                </div>
                                <div class="bg-white p-3 rounded-lg border border-gray-100 sm:col-span-2 md:col-span-1">
                                    <p class="text-xs text-gray-500 mb-1">Statut</p>
                                    <span class="px-2.5 py-1 inline-flex text-xs sm:text-sm leading-5 font-semibold rounded-full {{ $inscription->statut ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $inscription->statut ? 'Actif' : 'Inactif' }}
                                    </span>
                                </div>
                                @if($inscription->observation)
                                    <div class="sm:col-span-2 md:col-span-3 mt-2">
                                        <p class="text-xs sm:text-sm font-medium text-gray-600 mb-1">Observation:</p>
                                        <p class="text-xs sm:text-sm text-gray-700 bg-white p-3 rounded-lg border border-gray-100">{{ $inscription->observation }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection