@extends('layouts.app')

@section('header')
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
        {{ __('Emploi du Temps') }}
    </h2>
@endsection

@section('content')
<div class="py-12">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

        <!-- Header avec design amélioré -->
        <div class="relative mb-8 overflow-hidden group">
            <div class="absolute inset-0 bg-gradient-to-r from-green-600 via-emerald-600 to-teal-600 animate-gradient-x rounded-xl"></div>
            <div class="absolute inset-0 opacity-20">
                <div class="absolute bg-white rounded-full w-96 h-96 -top-48 -right-48 blur-3xl"></div>
                <div class="absolute bg-yellow-300 rounded-full w-96 h-96 -bottom-48 -left-48 blur-3xl"></div>
            </div>

            <div class="relative p-8">
                <div class="flex items-center justify-between">
                    <div class="transition-all duration-700 transform animate-slide-in-left">
                        <h3 class="text-3xl font-bold text-white drop-shadow-lg">Emploi du Temps</h3>
                        <p class="flex items-center mt-2 text-green-100">
                            <svg class="w-5 h-5 mr-2 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            @if(isset($inscription) && $inscription && isset($classeActuelle) && $classeActuelle)
                                Classe: {{ $classeActuelle->nom }} • Semaine du {{ now()->startOfWeek()->format('d/m') }} au {{ now()->endOfWeek()->format('d/m/Y') }}
                            @else
                                Aucune classe assignée
                            @endif
                        </p>
                    </div>
                    <div class="hidden transition-all duration-700 transform md:block animate-slide-in-right hover:rotate-12 hover:scale-110">
                        <div class="p-5 border rounded-full bg-white/20 backdrop-blur-sm border-white/30">
                            <svg class="w-16 h-16 text-white animate-float" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filtre par jour -->
        <div class="mb-6 overflow-hidden transition-all duration-500 transform bg-white border border-gray-100 shadow-xl rounded-2xl hover:shadow-2xl">
            <div class="p-4 bg-gradient-to-r from-green-50 to-white">
                <form method="GET" action="{{ route('eleve.emploi-du-temps') }}" class="flex flex-wrap items-center gap-4">
                    <label class="flex items-center text-sm font-medium text-gray-700">
                        <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"></path>
                        </svg>
                        Filtrer par jour
                    </label>
                    <select name="jour" class="px-4 py-2 border border-gray-300 rounded-xl focus:border-green-500 focus:ring-green-500">
                        <option value="">Tous les jours</option>
                        @foreach($jours as $jourOption)
                            <option value="{{ $jourOption }}" {{ request('jour') == $jourOption ? 'selected' : '' }}>
                                {{ $jourOption }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="px-4 py-2 text-white transition-all duration-300 transform bg-gradient-to-r from-green-500 to-green-600 rounded-xl hover:from-green-600 hover:to-green-700 hover:scale-105">
                        Filtrer
                    </button>
                    @if(request('jour'))
                        <a href="{{ route('eleve.emploi-du-temps') }}" class="px-4 py-2 text-gray-700 transition-all duration-300 transform bg-gray-100 rounded-xl hover:bg-gray-200 hover:scale-105">
                            Réinitialiser
                        </a>
                    @endif
                </form>
            </div>
        </div>

        @if(!isset($classeActuelle) || !$classeActuelle)
            <div class="p-12 text-center bg-white shadow-xl rounded-2xl">
                <div class="relative inline-block animate-float">
                    <div class="absolute inset-0 bg-green-300 rounded-full opacity-50 blur-xl"></div>
                    <svg class="relative w-24 h-24 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h4 class="mt-4 text-xl font-semibold text-gray-700">Aucune classe assignée</h4>
                <p class="mt-2 text-gray-500">Vous n'êtes pas encore inscrit dans une classe active.</p>
            </div>
        @elseif($emploiDuTemps->isEmpty())
            <div class="p-12 text-center bg-white shadow-xl rounded-2xl">
                <div class="relative inline-block animate-float">
                    <div class="absolute inset-0 bg-yellow-300 rounded-full opacity-50 blur-xl"></div>
                    <svg class="relative w-24 h-24 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h4 class="mt-4 text-xl font-semibold text-gray-700">Aucun cours planifié</h4>
                <p class="mt-2 text-gray-500">Aucun emploi du temps n'est disponible pour votre classe.</p>
            </div>
        @else
            <!-- Emploi du temps par jour -->
            <div class="space-y-6">
                @foreach($jours as $jour)
                    @php $coursDuJour = $emploiParJour[$jour] ?? collect(); @endphp
                    
                    <div class="overflow-hidden transition-all duration-500 transform bg-white border border-gray-100 shadow-xl rounded-2xl hover:shadow-2xl">
                        <div class="p-4 bg-gradient-to-r from-green-600 to-green-500">
                            <h4 class="flex items-center text-xl font-bold text-white">
                                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                {{ $jour }}
                                <span class="px-3 py-1 ml-3 text-sm rounded-full bg-white/20">
                                    {{ $coursDuJour->count() }} cours
                                </span>
                            </h4>
                        </div>

                        @if($coursDuJour->isNotEmpty())
                            <div class="p-6">
                                <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                                    @foreach($coursDuJour as $cours)
                                        @php
                                            $debut = \Carbon\Carbon::parse($cours->heure_debut)->format('H:i');
                                            $fin = \Carbon\Carbon::parse($cours->heure_fin)->format('H:i');
                                        @endphp
                                        <div class="p-5 transition-all duration-300 transform border border-green-100 bg-gradient-to-br from-green-50 to-white rounded-xl hover:shadow-lg hover:scale-102 group">
                                            <div class="flex items-start justify-between">
                                                <div class="flex items-center">
                                                    <div class="p-3 mr-4 bg-white shadow-md rounded-xl">
                                                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <h5 class="text-lg font-bold text-gray-800">{{ $cours->matiere->nom ?? 'Matière' }}</h5>
                                                        <p class="text-sm text-gray-500">{{ $cours->matiere->code ?? '' }}</p>
                                                    </div>
                                                </div>
                                                <span class="px-3 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full">
                                                    {{ $debut }} - {{ $fin }}
                                                </span>
                                            </div>
                                            
                                            <div class="grid grid-cols-2 gap-3 mt-4">
                                                <div class="p-2 text-center bg-white rounded-lg">
                                                    <p class="text-xs text-gray-500">Enseignant</p>
                                                    <p class="font-medium text-gray-700 truncate">
                                                        {{ $cours->enseignant->nom ?? 'N/A' }} {{ $cours->enseignant->prenom ?? '' }}
                                                    </p>
                                                </div>
                                                <div class="p-2 text-center bg-white rounded-lg">
                                                    <p class="text-xs text-gray-500">Salle</p>
                                                    <p class="font-medium text-gray-700">{{ $cours->salle ?? 'N/A' }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div class="p-8 text-center">
                                <p class="text-gray-400">Aucun cours prévu ce jour</p>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

<style>
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
</style>
@endsection