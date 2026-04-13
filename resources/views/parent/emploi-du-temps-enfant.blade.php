@extends('layouts.app')

@section('header')
    <h2 class="text-sm font-semibold leading-tight text-gray-800">
        {{ __('Emploi du temps de ') . $eleve->prenom . ' ' . $eleve->nom }}
    </h2>
@endsection

@section('content')
<div class="py-12">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="relative mb-8 overflow-hidden group rounded-2xl">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 animate-gradient-x"></div>
            <div class="absolute inset-0 opacity-20">
                <div class="absolute bg-white rounded-full w-96 h-96 -top-48 -right-48 blur-3xl animate-pulse-slow"></div>
                <div class="absolute bg-yellow-300 rounded-full w-96 h-96 -bottom-48 -left-48 blur-3xl animate-pulse-slow animation-delay-2000"></div>
            </div>
            
            <!-- Particules -->
            <div class="absolute inset-0">
                @for($i = 0; $i < 12; $i++)
                <div class="absolute w-2 h-2 bg-white rounded-full animate-float-random" 
                     style="left: {{ rand(0, 100) }}%; top: {{ rand(0, 100) }}%; animation-delay: {{ rand(0, 5) }}s; opacity: 0.6;"></div>
                @endfor
            </div>
            
            <div class="relative p-8">
                <div class="flex flex-col md:flex-row items-center md:justify-between space-y-6 md:space-y-0 text-center md:text-left">
                    <div class="flex flex-col sm:flex-row items-center space-y-4 sm:space-y-0 sm:space-x-6">
                        <!-- Avatar élève -->
                        <div class="relative group">
                            <div class="flex items-center justify-center w-20 h-20 transition-all duration-300 transform border-2 shadow-2xl bg-white/20 backdrop-blur-sm rounded-2xl border-white/30 group-hover:scale-110">
                                <span class="text-3xl font-bold text-white">
                                    {{ substr($eleve->prenom, 0, 1) }}{{ substr($eleve->nom, 0, 1) }}
                                </span>
                            </div>
                            <div class="absolute w-4 h-4 bg-green-400 border-2 border-blue-600 rounded-full -bottom-1 -right-1 animate-pulse"></div>
                        </div>
                        
                        <div class="transition-all duration-700 transform animate-slide-in-left">
                            <h3 class="text-3xl font-bold text-white drop-shadow-lg">Emploi du temps de {{ $eleve->prenom }} {{ $eleve->nom }}</h3>
                            <div class="flex flex-wrap items-center justify-center md:justify-start gap-3 mt-2">
                                <span class="inline-flex items-center px-3 py-1 text-sm text-white rounded-full bg-white/20">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                    {{ $classe ? $classe->nom : 'Classe non assignée' }}
                                </span>
                                @if(isset($lienParental))
                                <span class="inline-flex items-center px-3 py-1 text-sm text-white rounded-full bg-white/20">
                                    {{ $lienParental }}
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="hidden transition-all duration-700 transform md:block animate-slide-in-right hover:rotate-12 hover:scale-110">
                        <div class="p-4 border rounded-full bg-white/20 backdrop-blur-sm border-white/30">
                            <svg class="w-16 h-16 text-white animate-float" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('parent.enfants') }}" class="inline-flex items-center px-4 py-2 text-gray-700 transition-all duration-300 bg-gray-100 hover:bg-gray-200 rounded-xl hover:scale-105 hover:shadow-md group">
                <svg class="w-5 h-5 mr-2 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Retour à mes enfants
            </a>
        </div>

        @if(isset($message))
        <!-- Message si pas d'emploi du temps -->
        <div class="p-8 mb-8 text-center bg-white border border-gray-100 shadow-xl rounded-2xl">
            <svg class="w-24 h-24 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <p class="mt-4 text-xl text-gray-500">{{ $message }}</p>
            <a href="{{ route('parent.enfants') }}" class="inline-block mt-6 px-6 py-3 font-semibold text-white bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl hover:from-blue-600 hover:to-indigo-700">
                Retour à mes enfants
            </a>
        </div>
        @else

        <!-- Filtres par jour -->
        <div class="mb-8 overflow-hidden transition-all duration-500 transform bg-white border border-gray-100 shadow-xl rounded-2xl hover:shadow-2xl">
            <div class="p-4 md:p-6 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                <h3 class="flex items-center text-lg font-semibold text-gray-900">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Filtrer par jour
                </h3>
            </div>
            <div class="p-4 md:p-6">
                <form method="GET" action="{{ route('parent.enfant.emploi-du-temps', $eleve->id) }}" class="flex flex-wrap gap-2">
                    @foreach($jours as $jour)
                        <button type="submit" name="jour" value="{{ $jour }}" 
                                class="px-4 py-2 font-medium rounded-xl transition-all duration-300 {{ request('jour') == $jour ? 'bg-gradient-to-r from-blue-500 to-indigo-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            {{ $jour }}
                        </button>
                    @endforeach
                    @if(request('jour'))
                        <a href="{{ route('parent.enfant.emploi-du-temps', $eleve->id) }}" class="px-4 py-2 font-medium text-red-600 bg-red-50 rounded-xl hover:bg-red-100">
                            Tous les jours
                        </a>
                    @endif
                </form>
            </div>
        </div>

        <!-- Grille de l'emploi du temps -->
        @if(count($emploiParJour) > 0 && collect($emploiParJour)->flatten()->count() > 0)
        <!-- Header du planning -->
        <div class="flex flex-col sm:flex-row items-center justify-between p-4 sm:p-6 mb-8 gap-4 sm:gap-0 shadow-lg bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl">
            <h3 class="flex items-center text-lg sm:text-xl font-bold text-white text-center sm:text-left">
                <svg class="hidden sm:block w-6 h-6 mr-3 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                @if(request('jour'))
                    Emploi du temps - {{ request('jour') }}
                @else
                    Aperçu de la semaine
                @endif
            </h3>
            <span class="px-4 py-2 font-semibold text-blue-900 bg-white shadow-sm rounded-full whitespace-nowrap">
                {{ collect($emploiParJour)->flatten()->count() }} cours
            </span>
        </div>

        <div class="space-y-8">
            @foreach($jours as $jour)
                @if(isset($emploiParJour[$jour]) && $emploiParJour[$jour]->count() > 0)
                <div class="relative overflow-hidden bg-white border border-gray-100 shadow-sm transition-all duration-300 rounded-2xl hover:shadow-lg group">
                    <!-- Barre latérale colorée animée -->
                    <div class="absolute top-0 bottom-0 left-0 w-2 transition-all duration-300 bg-gradient-to-b from-blue-400 to-indigo-600 group-hover:w-3"></div>
                    
                    <div class="p-4 pl-6 sm:p-6 sm:pl-8">
                        <div class="flex items-center mb-6">
                            <h4 class="text-xl sm:text-2xl font-black tracking-tight text-gray-800">{{ $jour }}</h4>
                            <div class="flex-1 h-px ml-4 sm:ml-6 bg-gray-100"></div>
                        </div>

                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4">
                            @foreach($emploiParJour[$jour] as $cours)
                            <div class="relative overflow-hidden transition-all duration-300 border p-5 bg-gray-50/80 rounded-xl hover:bg-blue-50/50 hover:shadow-md border-gray-100/50 group/card hover:-translate-y-1">
                                <!-- Background accent -->
                                <div class="absolute w-16 h-16 transition-transform duration-500 bg-blue-100 rounded-full opacity-50 -right-4 -top-4 group-hover/card:scale-150"></div>
                                
                                <!-- Horaire -->
                                <div class="relative z-10 flex items-center mb-3 font-semibold text-indigo-600">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ \Carbon\Carbon::parse($cours->heure_debut)->format('H:i') }} - {{ \Carbon\Carbon::parse($cours->heure_fin)->format('H:i') }}
                                </div>
                                
                                <!-- Matière -->
                                <h5 class="relative z-10 mb-2 text-lg font-bold text-gray-900 truncate" title="{{ $cours->matiere->nom ?? '-' }}">
                                    {{ $cours->matiere->nom ?? '-' }}
                                </h5>
                                
                                <!-- Détails -->
                                <div class="relative z-10 pt-4 mt-4 space-y-2 border-t border-gray-200/60">
                                    <!-- Professeur -->
                                    <div class="flex items-center text-sm text-gray-600">
                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        <span class="truncate">{{ $cours->enseignant ? $cours->enseignant->prenom . ' ' . $cours->enseignant->nom : '-' }}</span>
                                    </div>
                                    
                                    <!-- Salle -->
                                    <div class="flex items-center text-sm text-gray-600">
                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                        <span class="font-medium text-gray-800">{{ $cours->salle ?? 'N/A' }}</span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
            @endforeach
        </div>
        @else
        <div class="p-12 text-center bg-white border border-gray-100 shadow-xl rounded-2xl">
            <svg class="w-24 h-24 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <p class="mt-4 text-xl text-gray-500">Aucun cours prévu</p>
            <p class="text-gray-400">L'emploi du temps n'est pas encore disponible pour cette période</p>
        </div>
        @endif
        @endif
    </div>
</div>

<style>
@keyframes gradient-x { 0%,100% { background-position: 0% 50%; } 50% { background-position: 100% 50%; } }
.animate-gradient-x { background-size: 200% 200%; animation: gradient-x 15s ease infinite; }
@keyframes float { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
.animate-float { animation: float 3s ease-in-out infinite; }
@keyframes float-random { 0%,100% { transform: translate(0,0); } 25% { transform: translate(10px,-10px); } 50% { transform: translate(-10px,5px); } 75% { transform: translate(5px,10px); } }
.animate-float-random { animation: float-random 10s ease-in-out infinite; }
.animate-slide-in-left { animation: slide-in-left 0.7s ease-out forwards; }
.animate-slide-in-right { animation: slide-in-right 0.7s ease-out forwards; }
.animate-fade-in-up { animation: fade-in-up 0.8s ease-out forwards; }
@keyframes slide-in-left { from { opacity:0; transform:translateX(-50px); } to { opacity:1; transform:translateX(0); } }
@keyframes slide-in-right { from { opacity:0; transform:translateX(50px); } to { opacity:1; transform:translateX(0); } }
@keyframes fade-in-up { from { opacity:0; transform:translateY(30px); } to { opacity:1; transform:translateY(0); } }
.animate-pulse-slow { animation: pulse-slow 3s ease-in-out infinite; }
@keyframes pulse-slow { 0%,100% { opacity:0.6; } 50% { opacity:1; } }
.animation-delay-200 { animation-delay: 200ms; }
.animation-delay-2000 { animation-delay: 2000ms; }
</style>

<!-- Alpine.js -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endsection
