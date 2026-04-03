{{-- resources/views/search/results.blade.php --}}
@extends('layouts.app')

@section('title', 'Résultats de recherche')

@section('content')
<div class="py-6 sm:py-8 md:py-12 overflow-x-hidden">
    <div class="mx-auto max-w-7xl px-3 sm:px-4 lg:px-6">
        <!-- En-tête - Responsive -->
        <div class="mb-4 sm:mb-6 md:mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Résultats de recherche</h1>
            <p class="mt-1 sm:mt-2 text-sm sm:text-base text-gray-600 break-words">
                Recherche pour : "<strong class="break-all">{{ $query }}</strong>"
            </p>
        </div>

        @if(empty($results['eleves']) && empty($results['enseignants']) && empty($results['classes']))
            <!-- Aucun résultat - Responsive -->
            <div class="p-6 sm:p-8 md:p-12 text-center bg-white shadow-sm rounded-lg sm:rounded-xl">
                <svg class="w-12 h-12 sm:w-16 sm:h-16 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <h3 class="mt-3 sm:mt-4 text-base sm:text-lg font-medium text-gray-900">Aucun résultat trouvé</h3>
                <p class="mt-1 sm:mt-2 text-xs sm:text-sm text-gray-500 break-words">
                    Aucun élément ne correspond à votre recherche "{{ $query }}".
                </p>
                <div class="mt-4 sm:mt-6">
                    <a href="{{ url()->previous() }}" class="inline-flex items-center px-3 sm:px-4 py-1.5 sm:py-2 text-xs font-semibold tracking-widest text-white uppercase bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700 transition duration-200">
                        Retour
                    </a>
                </div>
            </div>
        @else
            <!-- Résultats -->
            <div class="space-y-4 sm:space-y-6 md:space-y-8">

                <!-- Résultats Élèves - Responsive -->
                @if(count($results['eleves']) > 0)
                <div class="overflow-hidden bg-white shadow-sm rounded-lg sm:rounded-xl">
                    <div class="px-3 sm:px-4 md:px-6 py-2.5 sm:py-3 md:py-4 border-b border-indigo-100 bg-indigo-50">
                        <h2 class="text-sm sm:text-base md:text-lg font-semibold text-indigo-900">
                            Élèves ({{ count($results['eleves']) }})
                        </h2>
                    </div>
                    <div class="divide-y divide-gray-200">
                        @foreach($results['eleves'] as $eleve)
                        <div class="px-3 sm:px-4 md:px-6 py-3 sm:py-4 transition duration-150 hover:bg-gray-50">
                            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 sm:gap-4">
                                <div class="flex-1 w-full sm:w-auto">
                                    <div class="flex items-center space-x-2 sm:space-x-3">
                                        <div class="flex-shrink-0">
                                            <div class="flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 bg-indigo-100 rounded-full">
                                                <span class="text-xs sm:text-sm font-medium text-indigo-600">
                                                    {{ strtoupper(substr($eleve->prenom, 0, 1)) }}{{ strtoupper(substr($eleve->nom, 0, 1)) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <p class="text-sm font-medium text-gray-900 truncate">
                                                <a href="{{ route('admin.eleves.show', $eleve) }}" class="hover:text-indigo-600">
                                                    {{ $eleve->nom }} {{ $eleve->prenom }}
                                                </a>
                                            </p>
                                            <p class="text-xs sm:text-sm text-gray-500 truncate">
                                                Matricule: {{ $eleve->matricule }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <a href="{{ route('admin.eleves.show', $eleve) }}"
                                   class="inline-flex items-center px-2.5 sm:px-3 py-1 text-xs sm:text-sm font-medium leading-5 text-indigo-700 bg-indigo-100 border border-transparent rounded-md hover:bg-indigo-200 transition duration-200 whitespace-nowrap">
                                    Voir
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Résultats Enseignants - Responsive -->
                @if(count($results['enseignants']) > 0)
                <div class="overflow-hidden bg-white shadow-sm rounded-lg sm:rounded-xl">
                    <div class="px-3 sm:px-4 md:px-6 py-2.5 sm:py-3 md:py-4 border-b border-green-100 bg-green-50">
                        <h2 class="text-sm sm:text-base md:text-lg font-semibold text-green-900">
                            Enseignants ({{ count($results['enseignants']) }})
                        </h2>
                    </div>
                    <div class="divide-y divide-gray-200">
                        @foreach($results['enseignants'] as $enseignant)
                        <div class="px-3 sm:px-4 md:px-6 py-3 sm:py-4 transition duration-150 hover:bg-gray-50">
                            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 sm:gap-4">
                                <div class="flex-1 w-full sm:w-auto">
                                    <div class="flex items-center space-x-2 sm:space-x-3">
                                        <div class="flex-shrink-0">
                                            <div class="flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 bg-green-100 rounded-full">
                                                <span class="text-xs sm:text-sm font-medium text-green-600">
                                                    {{ strtoupper(substr($enseignant->prenom, 0, 1)) }}{{ strtoupper(substr($enseignant->nom, 0, 1)) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <p class="text-sm font-medium text-gray-900 truncate">
                                                <a href="{{ route('admin.enseignants.show', $enseignant) }}" class="hover:text-green-600">
                                                    {{ $enseignant->nom }} {{ $enseignant->prenom }}
                                                </a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <a href="{{ route('admin.enseignants.show', $enseignant) }}"
                                   class="inline-flex items-center px-2.5 sm:px-3 py-1 text-xs sm:text-sm font-medium leading-5 text-green-700 bg-green-100 border border-transparent rounded-md hover:bg-green-200 transition duration-200 whitespace-nowrap">
                                    Voir
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Résultats Classes - Responsive -->
                @if(count($results['classes']) > 0)
                <div class="overflow-hidden bg-white shadow-sm rounded-lg sm:rounded-xl">
                    <div class="px-3 sm:px-4 md:px-6 py-2.5 sm:py-3 md:py-4 border-b border-blue-100 bg-blue-50">
                        <h2 class="text-sm sm:text-base md:text-lg font-semibold text-blue-900">
                            Classes ({{ count($results['classes']) }})
                        </h2>
                    </div>
                    <div class="divide-y divide-gray-200">
                        @foreach($results['classes'] as $classe)
                        <div class="px-3 sm:px-4 md:px-6 py-3 sm:py-4 transition duration-150 hover:bg-gray-50">
                            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 sm:gap-4">
                                <div class="flex-1 w-full sm:w-auto">
                                    <div class="flex items-center space-x-2 sm:space-x-3">
                                        <div class="flex-shrink-0">
                                            <div class="flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 bg-blue-100 rounded-full">
                                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <p class="text-sm font-medium text-gray-900 truncate">
                                                <a href="{{ route('admin.classes.show', $classe) }}" class="hover:text-blue-600">
                                                    {{ $classe->nom }}
                                                </a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <a href="{{ route('admin.classes.show', $classe) }}"
                                   class="inline-flex items-center px-2.5 sm:px-3 py-1 text-xs sm:text-sm font-medium leading-5 text-blue-700 bg-blue-100 border border-transparent rounded-md hover:bg-blue-200 transition duration-200 whitespace-nowrap">
                                    Voir
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Lien pour voir tous les résultats - Responsive -->
                <div class="mt-4 sm:mt-5 md:mt-6 text-center">
                    <a href="{{ route('search', ['q' => $query]) }}" class="text-sm sm:text-base text-indigo-600 hover:text-indigo-900 transition duration-200">
                        Voir tous les résultats →
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Styles pour éviter le débordement horizontal */
    * {
        max-width: 100%;
        box-sizing: border-box;
    }
    
    body, html {
        overflow-x: hidden;
        width: 100%;
        position: relative;
    }
    
    .overflow-x-hidden {
        overflow-x: hidden !important;
    }
    
    /* Ajustement pour les très petits écrans */
    @media (max-width: 480px) {
        .max-w-7xl {
            padding-left: 0.75rem !important;
            padding-right: 0.75rem !important;
        }
        
        /* Ajuster les tailles de police */
        .text-sm {
            font-size: 0.75rem;
        }
        
        .text-xs {
            font-size: 0.65rem;
        }
        
        /* Réduire les paddings */
        .py-12 {
            padding-top: 1rem;
            padding-bottom: 1rem;
        }
        
        .px-6 {
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }
        
        .py-4 {
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
        }
    }
    
    /* Amélioration de la lisibilité sur mobile */
    @media (max-width: 640px) {
        /* Espacements réduits */
        .space-y-8 {
            margin-top: 1rem;
        }
        
        /* Ajuster les conteneurs */
        .rounded-xl {
            border-radius: 0.75rem;
        }
        
        /* Gérer les textes longs */
        .break-words {
            word-break: break-word;
        }
        
        .break-all {
            word-break: break-all;
        }
        
        /* Améliorer la troncature */
        .truncate {
            max-width: 100%;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    }
    
    /* Transition fluide pour les liens */
    a, button {
        transition: all 0.2s ease;
    }
    
    /* Effet hover amélioré */
    .hover\:bg-gray-50:hover {
        background-color: rgba(249, 250, 251, 0.8);
    }
</style>
@endpush