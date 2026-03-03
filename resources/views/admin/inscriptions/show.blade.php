@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Détails de l\'inscription') }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-green-600 to-green-800 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-bold text-white">Fiche d'inscription</h3>
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.inscriptions.edit', $inscription) }}"
                                class="inline-flex items-center px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg transition duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                    </path>
                                </svg>
                                Modifier
                            </a>
                            <a href="{{ route('admin.inscriptions.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg transition duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                Retour
                            </a>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Informations élève -->
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Élève
                            </h4>
                            <div class="space-y-3">
                                <p><span class="font-medium text-gray-600">Nom complet:</span>
                                    {{ $inscription->eleve->nom }} {{ $inscription->eleve->prenom }}</p>
                                <p><span class="font-medium text-gray-600">Matricule:</span>
                                    {{ $inscription->eleve->matricule ?? 'N/A' }}</p>
                                <p><span class="font-medium text-gray-600">Date naissance:</span>
                                    {{ $inscription->eleve->date_naissance ? \Carbon\Carbon::parse($inscription->eleve->date_naissance)->format('d/m/Y') : 'N/A' }}
                                </p>
                                <p><span class="font-medium text-gray-600">Genre:</span>
                                    {{ $inscription->eleve->genre == 'M' ? 'Masculin' : ($inscription->eleve->genre == 'F' ? 'Féminin' : 'N/A') }}
                                </p>
                                <p><span class="font-medium text-gray-600">Téléphone:</span>
                                    {{ $inscription->eleve->telephone ?? 'N/A' }}</p>
                            </div>
                        </div>

                        <!-- Informations classe -->
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                    </path>
                                </svg>
                                Classe
                            </h4>
                            <div class="space-y-3">
                                <p><span class="font-medium text-gray-600">Classe:</span> {{ $inscription->classe->nom }}
                                </p>
                                <p><span class="font-medium text-gray-600">Niveau:</span> {{ $inscription->classe->niveau }}
                                </p>
                                @if($inscription->classe->serie)
                                    <p><span class="font-medium text-gray-600">Série:</span> {{ $inscription->classe->serie }}
                                    </p>
                                @endif
                                <p><span class="font-medium text-gray-600">Capacité:</span>
                                    {{ $inscription->classe->capacite }} élèves</p>
                            </div>
                        </div>

                        <!-- Informations inscription -->
                        <div class="bg-gray-50 rounded-lg p-6 md:col-span-2">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Détails de l'inscription
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <p><span class="font-medium text-gray-600">Année scolaire:</span></p>
                                    <p class="text-lg">{{ $inscription->anneeScolaire->nom }}</p>
                                </div>
                                <div>
                                    <p><span class="font-medium text-gray-600">Date d'inscription:</span></p>
                                    <p class="text-lg">
                                        {{ \Carbon\Carbon::parse($inscription->date_inscription)->format('d/m/Y') }}</p>
                                </div>
                                <div>
                                    <p><span class="font-medium text-gray-600">Statut:</span></p>
                                    <p>
                                        <span
                                            class="px-2 inline-flex text-sm leading-5 font-semibold rounded-full {{ $inscription->statut ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $inscription->statut ? 'Actif' : 'Inactif' }}
                                        </span>
                                    </p>
                                </div>
                                @if($inscription->observation)
                                    <div class="md:col-span-3">
                                        <p><span class="font-medium text-gray-600">Observation:</span></p>
                                        <p class="text-gray-700 bg-white p-3 rounded-lg">{{ $inscription->observation }}</p>
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