@extends('layouts.app')

@section('header')
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
        {{ __('Détails de l\'absence') }}
    </h2>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <!-- Header avec bouton retour -->
        <div class="p-6 mb-8 shadow-lg bg-gradient-to-r from-red-600 to-red-400 rounded-xl">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <a href="{{ route('enseignant.absences.index') }}" class="mr-4 text-white hover:text-red-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                    </a>
                    <div>
                        <h3 class="text-2xl font-bold text-white">Détails de l'absence</h3>
                        <p class="mt-1 text-red-100">Informations complètes</p>
                    </div>
                </div>
                <div class="flex space-x-2">
                    <a href="{{ route('enseignant.absences.edit', $absence->id) }}" 
                       class="flex items-center px-4 py-2 text-white transition-colors bg-yellow-500 rounded-lg hover:bg-yellow-600">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Modifier
                    </a>
                </div>
            </div>
        </div>

        <!-- Carte des détails -->
        <div class="overflow-hidden bg-white shadow-md rounded-xl">
            <div class="p-6 border-b border-gray-100">
                <h4 class="text-lg font-semibold text-gray-900">Informations générales</h4>
            </div>
            
            <div class="p-6">
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <!-- Élève -->
                    <div class="p-4 rounded-lg bg-gray-50">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 p-3 bg-red-100 rounded-full">
                                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Élève</p>
                                <p class="text-lg font-semibold text-gray-900">
                                    {{ $absence->eleve->nom ?? '' }} {{ $absence->eleve->prenom ?? '' }}
                                </p>
                                <p class="text-sm text-gray-500">Matricule: {{ $absence->eleve->matricule ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Classe -->
                    <div class="p-4 rounded-lg bg-gray-50">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 p-3 bg-blue-100 rounded-full">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Classe</p>
                                <p class="text-lg font-semibold text-gray-900">{{ $absence->eleve->classe->nom ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Matière -->
                    <div class="p-4 rounded-lg bg-gray-50">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 p-3 bg-green-100 rounded-full">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Matière</p>
                                <p class="text-lg font-semibold text-gray-900">{{ $absence->matiere->nom ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Date -->
                    <div class="p-4 rounded-lg bg-gray-50">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 p-3 bg-purple-100 rounded-full">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Date</p>
                                <p class="text-lg font-semibold text-gray-900">
                                    {{ \Carbon\Carbon::parse($absence->date_absence)->format('d/m/Y') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Heures d'absence -->
                <div class="grid grid-cols-1 gap-6 mt-6 md:grid-cols-2">
                    <div class="p-4 rounded-lg bg-gray-50">
                        <p class="mb-2 text-sm font-medium text-gray-500">Heure de début</p>
                        <p class="text-xl font-semibold text-gray-900">
                            {{ substr($absence->heure_debut, 0, 5) ?? '--:--' }}
                        </p>
                    </div>
                    <div class="p-4 rounded-lg bg-gray-50">
                        <p class="mb-2 text-sm font-medium text-gray-500">Heure de fin</p>
                        <p class="text-xl font-semibold text-gray-900">
                            {{ substr($absence->heure_fin, 0, 5) ?? '--:--' }}
                        </p>
                    </div>
                </div>

                <!-- Durée calculée -->
                <div class="p-4 mt-6 rounded-lg bg-gray-50">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Durée de l'absence</p>
                            <p class="text-2xl font-bold text-gray-900">
                                @php
                                    $debut = \Carbon\Carbon::parse($absence->heure_debut);
                                    $fin = \Carbon\Carbon::parse($absence->heure_fin);
                                    $duree = $debut->diffInHours($fin);
                                @endphp
                                {{ $duree }} heure(s)
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-medium text-gray-500">Statut</p>
                            @if($absence->justifiee)
                                <span class="inline-flex px-3 py-1 text-sm font-semibold leading-5 text-green-800 bg-green-100 rounded-full">
                                    Justifiée
                                </span>
                            @else
                                <span class="inline-flex px-3 py-1 text-sm font-semibold leading-5 text-red-800 bg-red-100 rounded-full">
                                    Non justifiée
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Motif -->
                @if($absence->motif)
                <div class="mt-6">
                    <div class="p-4 rounded-lg bg-gray-50">
                        <p class="mb-2 text-sm font-medium text-gray-500">Motif</p>
                        <p class="text-gray-900">{{ $absence->motif }}</p>
                    </div>
                </div>
                @endif

                <!-- Métadonnées -->
                <div class="pt-6 mt-6 border-t border-gray-200">
                    <div class="grid grid-cols-2 gap-4 text-sm text-gray-500">
                        <div>
                            <span class="font-medium">Créé le:</span> 
                            {{ $absence->created_at ? $absence->created_at->format('d/m/Y à H:i') : 'N/A' }}
                        </div>
                        <div>
                            <span class="font-medium">Dernière modification:</span> 
                            {{ $absence->updated_at ? $absence->updated_at->format('d/m/Y à H:i') : 'N/A' }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Boutons d'action -->
            <div class="flex justify-end px-6 py-4 space-x-3 border-t border-gray-100 bg-gray-50">
                <a href="{{ route('enseignant.absences.index') }}" 
                   class="px-4 py-2 text-white transition-colors bg-gray-500 rounded-lg hover:bg-gray-600">
                    Retour à la liste
                </a>
                @if(!$absence->justifiee)
                <form action="{{ route('enseignant.absences.justify', $absence->id) }}" method="POST" class="inline">
                    @csrf
                    @method('PUT')
                    <button type="submit" onclick="return confirm('Voulez-vous justifier cette absence ?')"
                            class="px-4 py-2 text-white transition-colors bg-green-600 rounded-lg hover:bg-green-700">
                        Justifier
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection