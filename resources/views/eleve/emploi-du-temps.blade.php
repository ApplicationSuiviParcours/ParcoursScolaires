@extends('layouts.app')

@section('header')
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
        {{ __('Emploi du Temps') }}
    </h2>
@endsection

@section('content')
<div class="py-6 sm:py-12 overflow-x-hidden">
    <div class="px-3 mx-auto max-w-7xl sm:px-6 lg:px-8">

        <!-- Header avec design amélioré -->
        <div class="relative mb-6 overflow-hidden group sm:mb-8 rounded-xl sm:rounded-2xl">
            <div class="absolute inset-0 bg-gradient-to-r from-green-600 via-emerald-600 to-teal-600 animate-gradient-x"></div>
            <div class="absolute inset-0 opacity-20">
                <div class="absolute bg-white rounded-full w-64 h-64 sm:w-96 sm:h-96 -top-48 -right-48 blur-3xl"></div>
                <div class="absolute bg-yellow-300 rounded-full w-64 h-64 sm:w-96 sm:h-96 -bottom-48 -left-48 blur-3xl"></div>
            </div>

            <div class="relative p-4 sm:p-6 md:p-8">
                <div class="flex flex-col items-start justify-between sm:flex-row sm:items-center">
                    <div class="mb-3 transition-all duration-700 transform sm:mb-0 animate-slide-in-left">
                        <h3 class="text-2xl font-bold text-white sm:text-3xl drop-shadow-lg">Emploi du Temps</h3>
                        <p class="flex items-center mt-1 text-xs text-green-100 sm:text-sm">
                            <svg class="w-4 h-4 mr-1 sm:w-5 sm:h-5 sm:mr-2 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            @if(isset($inscription) && $inscription && isset($classeActuelle) && $classeActuelle)
                                Classe: {{ $classeActuelle->nom }} • Semaine du {{ now()->startOfWeek()->format('d/m') }} au {{ now()->endOfWeek()->format('d/m/Y') }}
                            @else
                                Aucune classe assignée
                            @endif
                        </p>
                    </div>
                    <div class="hidden transition-all duration-700 transform sm:block animate-slide-in-right hover:rotate-12 hover:scale-110">
                        <div class="p-3 border rounded-full sm:p-5 bg-white/20 backdrop-blur-sm border-white/30">
                            <svg class="w-10 h-10 text-white sm:w-16 sm:h-16 animate-float" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filtre par jour -->
        <div class="mb-6 overflow-hidden transition-all duration-500 transform bg-white border border-gray-100 shadow-xl sm:mb-8 rounded-xl sm:rounded-2xl hover:shadow-2xl">
            <div class="p-4 bg-gradient-to-r from-green-50 to-white sm:p-6">
                <form method="GET" action="{{ route('eleve.emploi-du-temps') }}" class="flex flex-wrap items-center gap-3 sm:gap-4">
                    <label class="flex items-center text-xs font-medium text-gray-700 sm:text-sm">
                        <svg class="w-4 h-4 mr-1 text-green-500 sm:w-5 sm:h-5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"></path>
                        </svg>
                        Filtrer par jour
                    </label>
                    <select name="jour" class="flex-1 px-3 py-2 text-sm border border-gray-300 rounded-lg sm:flex-none sm:px-4 sm:py-2 sm:rounded-xl focus:border-green-500 focus:ring-green-500 sm:text-base">
                        <option value="">Tous les jours</option>
                        @foreach($jours as $jourOption)
                            <option value="{{ $jourOption }}" {{ request('jour') == $jourOption ? 'selected' : '' }}>
                                {{ $jourOption }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="px-3 py-2 text-sm text-white transition-all duration-300 transform bg-gradient-to-r from-green-500 to-green-600 rounded-lg sm:px-4 sm:py-2 sm:text-base hover:from-green-600 hover:to-green-700 hover:scale-105">
                        Filtrer
                    </button>
                    @if(request('jour'))
                        <a href="{{ route('eleve.emploi-du-temps') }}" class="px-3 py-2 text-sm text-gray-700 transition-all duration-300 transform bg-gray-100 rounded-lg sm:px-4 sm:py-2 sm:text-base hover:bg-gray-200 hover:scale-105">
                            Réinitialiser
                        </a>
                    @endif
                </form>
            </div>
        </div>

        @if(!isset($classeActuelle) || !$classeActuelle)
            <div class="p-8 text-center bg-white shadow-xl sm:p-12 rounded-xl sm:rounded-2xl">
                <div class="relative inline-block animate-float">
                    <div class="absolute inset-0 bg-green-300 rounded-full opacity-50 blur-xl"></div>
                    <svg class="relative w-16 h-16 text-green-400 sm:w-24 sm:h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h4 class="mt-3 text-lg font-semibold text-gray-700 sm:mt-4 sm:text-xl">Aucune classe assignée</h4>
                <p class="mt-1 text-sm text-gray-500 sm:mt-2 sm:text-base">Vous n'êtes pas encore inscrit dans une classe active.</p>
            </div>
        @elseif($emploiDuTemps->isEmpty())
            <div class="p-8 text-center bg-white shadow-xl sm:p-12 rounded-xl sm:rounded-2xl">
                <div class="relative inline-block animate-float">
                    <div class="absolute inset-0 bg-yellow-300 rounded-full opacity-50 blur-xl"></div>
                    <svg class="relative w-16 h-16 text-yellow-400 sm:w-24 sm:h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h4 class="mt-3 text-lg font-semibold text-gray-700 sm:mt-4 sm:text-xl">Aucun cours planifié</h4>
                <p class="mt-1 text-sm text-gray-500 sm:mt-2 sm:text-base">Aucun emploi du temps n'est disponible pour votre classe.</p>
            </div>
        @else
            <!-- Emploi du temps par jour -->
            <div class="space-y-4 sm:space-y-6">
                @foreach($jours as $jour)
                    @php $coursDuJour = $emploiParJour[$jour] ?? collect(); @endphp
                    
                    <div class="overflow-hidden transition-all duration-500 transform bg-white border border-gray-100 shadow-xl rounded-xl sm:rounded-2xl hover:shadow-2xl">
                        <div class="p-3 bg-gradient-to-r from-green-600 to-green-500 sm:p-4">
                            <h4 class="flex flex-wrap items-center text-lg font-bold text-white sm:text-xl">
                                <svg class="w-5 h-5 mr-1 sm:w-6 sm:h-6 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                {{ $jour }}
                                <span class="px-2 py-0.5 ml-2 text-xs rounded-full sm:px-3 sm:py-1 sm:ml-3 sm:text-sm bg-white/20">
                                    {{ $coursDuJour->count() }} cours
                                </span>
                            </h4>
                        </div>

                        @if($coursDuJour->isNotEmpty())
                            <div class="p-3 sm:p-4 md:p-6">
                                <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 sm:gap-4 lg:grid-cols-3">
                                    @foreach($coursDuJour as $cours)
                                        @php
                                            $debut = \Carbon\Carbon::parse($cours->heure_debut)->format('H:i');
                                            $fin = \Carbon\Carbon::parse($cours->heure_fin)->format('H:i');
                                        @endphp
                                        <div class="p-3 transition-all duration-300 transform border border-green-100 sm:p-4 md:p-5 bg-gradient-to-br from-green-50 to-white rounded-lg sm:rounded-xl hover:shadow-lg hover:scale-102 group">
                                            <div class="flex flex-col items-start justify-between space-y-3 sm:flex-row sm:items-start sm:space-y-0">
                                                <div class="flex items-center w-full sm:w-auto">
                                                    <div class="flex-shrink-0 p-2 mr-3 bg-white shadow-md sm:p-3 sm:mr-4 rounded-lg sm:rounded-xl">
                                                        <svg class="w-5 h-5 text-green-600 sm:w-6 sm:h-6 md:w-8 md:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                                        </svg>
                                                    </div>
                                                    <div class="flex-1 min-w-0">
                                                        <h5 class="text-base font-bold text-gray-800 truncate sm:text-lg">{{ $cours->matiere->nom ?? 'Matière' }}</h5>
                                                        <p class="text-xs text-gray-500 sm:text-sm">{{ $cours->matiere->code ?? '' }}</p>
                                                    </div>
                                                </div>
                                                <span class="flex-shrink-0 px-2 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full sm:px-3 sm:py-1">
                                                    @if($cours->heure_debut && $cours->heure_fin)
                                                        {{ \Carbon\Carbon::parse($cours->heure_debut)->format('H:i') }} - {{ \Carbon\Carbon::parse($cours->heure_fin)->format('H:i') }}
                                                    @elseif($cours->heure_debut)
                                                        {{ \Carbon\Carbon::parse($cours->heure_debut)->format('H:i') }}
                                                    @else
                                                        Heure non définie
                                                    @endif
                                                </span>
                                            </div>
                                            
                                            <div class="grid grid-cols-2 gap-2 mt-3 sm:gap-3 sm:mt-4">
                                                <div class="p-2 text-center bg-white rounded-lg sm:p-3">
                                                    <p class="text-[10px] text-gray-500 sm:text-xs">Enseignant</p>
                                                    <p class="text-xs font-medium text-gray-700 truncate sm:text-sm">
                                                        {{ $cours->enseignant->nom ?? 'N/A' }} {{ $cours->enseignant->prenom ?? '' }}
                                                    </p>
                                                </div>
                                                <div class="p-2 text-center bg-white rounded-lg sm:p-3">
                                                    <p class="text-[10px] text-gray-500 sm:text-xs">Salle</p>
                                                    <p class="text-xs font-medium text-gray-700 truncate sm:text-sm">{{ $cours->salle ?? 'N/A' }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div class="p-6 text-center sm:p-8">
                                <p class="text-sm text-gray-400 sm:text-base">Aucun cours prévu ce jour</p>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

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

@keyframes gradient-x {
    0%, 100% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}

@keyframes slide-in-left {
    from {
        opacity: 0;
        transform: translateX(-50px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes slide-in-right {
    from {
        opacity: 0;
        transform: translateX(50px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.animate-gradient-x {
    background-size: 200% 200%;
    animation: gradient-x 15s ease infinite;
}

.animate-float {
    animation: float 3s ease-in-out infinite;
}

.animate-slide-in-left {
    animation: slide-in-left 0.7s ease-out forwards;
}

.animate-slide-in-right {
    animation: slide-in-right 0.7s ease-out forwards;
}

.animate-pulse {
    animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

.hover\:scale-102:hover {
    transform: scale(1.02);
}

/* Empêcher le débordement horizontal */
.overflow-x-hidden {
    overflow-x: hidden !important;
}

/* Ajustement pour les très petits écrans */
@media (max-width: 480px) {
    .container, .max-w-7xl {
        padding-left: 0.75rem !important;
        padding-right: 0.75rem !important;
    }
    
    /* Ajuster les tailles de police sur mobile */
    .text-xs {
        font-size: 0.7rem;
    }
    
    /* Réduire les paddings */
    .px-3 {
        padding-left: 0.75rem;
        padding-right: 0.75rem;
    }
    
    .py-3 {
        padding-top: 0.75rem;
        padding-bottom: 0.75rem;
    }
}
</style>
@endsection