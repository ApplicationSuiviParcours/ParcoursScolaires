@extends('layouts.app')

@section('header')
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
        {{ __('Mes Enfants') }}
    </h2>
@endsection

@section('content')
    @php
        // Valeurs par défaut pour éviter les erreurs
        $enfants = $enfants ?? collect([]);
        $statsGlobales = $statsGlobales ?? [
            'total_notes' => 0,
            'total_absences' => 0,
            'total_bulletins' => 0,
        ];
    @endphp

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

            <!-- Header avec design moderne -->
            <div class="relative mb-8 overflow-hidden group rounded-3xl">
                <div class="absolute inset-0 bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 animate-gradient-xy"></div>
                <div class="absolute inset-0 opacity-20">
                    <div class="absolute rounded-full bg-white/30 w-96 h-96 -top-48 -right-48 blur-3xl animate-pulse-slow"></div>
                    <div class="absolute rounded-full bg-yellow-300/30 w-96 h-96 -bottom-48 -left-48 blur-3xl animate-pulse-slow animation-delay-2000"></div>
                </div>

                <!-- Particules animées -->
                <div class="absolute inset-0">
                    @for($i = 0; $i < 15; $i++)
                        <div class="absolute w-1 h-1 rounded-full bg-white/60 animate-float-random" 
                             style="left: {{ rand(0, 100) }}%; top: {{ rand(0, 100) }}%; animation-delay: {{ rand(0, 5) }}s;"></div>
                    @endfor
                </div>

                <div class="relative p-8">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                        <div class="flex items-center space-x-6">
                            <!-- Avatar parent -->
                            <div class="relative group perspective">
                                <div class="relative transition-all duration-500 transform group-hover:rotate-y-180 preserve-3d">
                                    <div class="flex items-center justify-center w-20 h-20 transition-all duration-300 border-4 shadow-2xl bg-white/20 backdrop-blur-xl rounded-2xl border-white/50 group-hover:scale-110 group-hover:shadow-blue-500/50">
                                        <span class="text-3xl font-bold text-white drop-shadow-lg">
                                            {{ substr(Auth::user()->name ?? 'P', 0, 1) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="absolute w-4 h-4 bg-green-400 border-4 border-white rounded-full -bottom-1 -right-1 animate-pulse ring-2 ring-blue-500/50"></div>
                            </div>

                            <div class="transition-all duration-700 transform animate-slide-in-left">
                                <h3 class="text-4xl font-black tracking-tight text-white drop-shadow-xl">Mes Enfants</h3>
                                <p class="flex items-center mt-2 text-blue-100">
                                    <svg class="w-5 h-5 mr-2 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    <span class="font-semibold">{{ $enfants->count() }}</span> enfant(s) - Suivez leur scolarité
                                </p>
                            </div>
                        </div>

                        <div class="hidden transition-all duration-700 transform md:block animate-slide-in-right hover:rotate-12 hover:scale-110">
                            <div class="p-4 border rounded-full bg-white/20 backdrop-blur-sm border-white/30">
                                <svg class="w-16 h-16 text-white animate-float" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistiques globales avec design moderne -->
            @if($enfants->count() > 0)
                <div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-4">
                    <!-- Total enfants -->
                    <div class="relative p-6 overflow-hidden transition-all duration-500 border shadow-xl group bg-white/90 backdrop-blur-xl border-white/50 rounded-2xl hover:shadow-2xl hover:-translate-y-1">
                        <div class="absolute inset-0 transition-opacity opacity-0 bg-gradient-to-r from-blue-500/10 to-indigo-500/10 group-hover:opacity-100"></div>
                        <div class="relative flex items-center justify-between">
                            <div>
                                <p class="flex items-center text-sm font-medium text-gray-600">
                                    <span class="w-2 h-2 mr-2 bg-blue-500 rounded-full animate-pulse"></span>
                                    Total enfants
                                </p>
                                <p class="mt-2 text-4xl font-black text-blue-600 transition-transform origin-left group-hover:scale-110">{{ $enfants->count() }}</p>
                            </div>
                            <div class="p-4 transition-transform shadow-lg bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl group-hover:scale-110">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="absolute bottom-0 left-0 w-full h-1 transition-transform origin-left transform scale-x-0 bg-gradient-to-r from-blue-500 to-indigo-600 group-hover:scale-x-100"></div>
                    </div>

                    <!-- Total notes -->
                    <div class="relative p-6 overflow-hidden transition-all duration-500 border shadow-xl group bg-white/90 backdrop-blur-xl border-white/50 rounded-2xl hover:shadow-2xl hover:-translate-y-1">
                        <div class="absolute inset-0 transition-opacity opacity-0 bg-gradient-to-r from-green-500/10 to-emerald-500/10 group-hover:opacity-100"></div>
                        <div class="relative flex items-center justify-between">
                            <div>
                                <p class="flex items-center text-sm font-medium text-gray-600">
                                    <span class="w-2 h-2 mr-2 bg-green-500 rounded-full animate-pulse animation-delay-200"></span>
                                    Total notes
                                </p>
                                <p class="mt-2 text-4xl font-black text-green-600">{{ $statsGlobales['total_notes'] }}</p>
                            </div>
                            <div class="p-4 transition-transform shadow-lg bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl group-hover:scale-110">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Total absences -->
                    <div class="relative p-6 overflow-hidden transition-all duration-500 border shadow-xl group bg-white/90 backdrop-blur-xl border-white/50 rounded-2xl hover:shadow-2xl hover:-translate-y-1">
                        <div class="absolute inset-0 transition-opacity opacity-0 bg-gradient-to-r from-red-500/10 to-rose-500/10 group-hover:opacity-100"></div>
                        <div class="relative flex items-center justify-between">
                            <div>
                                <p class="flex items-center text-sm font-medium text-gray-600">
                                    <span class="w-2 h-2 mr-2 bg-red-500 rounded-full animate-pulse animation-delay-400"></span>
                                    Total absences
                                </p>
                                <p class="mt-2 text-4xl font-black text-red-600">{{ $statsGlobales['total_absences'] }}</p>
                            </div>
                            <div class="p-4 transition-transform shadow-lg bg-gradient-to-br from-red-500 to-rose-600 rounded-2xl group-hover:scale-110">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Total bulletins -->
                    <div class="relative p-6 overflow-hidden transition-all duration-500 border shadow-xl group bg-white/90 backdrop-blur-xl border-white/50 rounded-2xl hover:shadow-2xl hover:-translate-y-1">
                        <div class="absolute inset-0 transition-opacity opacity-0 bg-gradient-to-r from-purple-500/10 to-pink-500/10 group-hover:opacity-100"></div>
                        <div class="relative flex items-center justify-between">
                            <div>
                                <p class="flex items-center text-sm font-medium text-gray-600">
                                    <span class="w-2 h-2 mr-2 bg-purple-500 rounded-full animate-pulse animation-delay-600"></span>
                                    Total bulletins
                                </p>
                                <p class="mt-2 text-4xl font-black text-purple-600">{{ $statsGlobales['total_bulletins'] }}</p>
                            </div>
                            <div class="p-4 transition-transform shadow-lg bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl group-hover:scale-110">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Grille des enfants avec design moderne -->
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach($enfants as $index => $enfant)
                        @php
                            // Récupérer l'inscription active (statut true)
                            $inscriptionActive = $enfant->inscriptions()
                                ->where('statut', true)
                                ->with('classe')
                                ->first();
                            
                            // Récupérer la classe actuelle
                            $classeActuelle = $inscriptionActive ? $inscriptionActive->classe : null;
                            $nomClasse = $classeActuelle ? $classeActuelle->nom : 'Classe non assignée';
                            
                            // Date d'inscription formatée
                            $dateInscription = $inscriptionActive && $inscriptionActive->date_inscription 
                                ? $inscriptionActive->date_inscription->format('d/m/Y') 
                                : null;
                            
                            // Statistiques
                            $notesCount = $enfant->notes()->count();
                            $absencesCount = $enfant->absences()->count();
                            $absencesNonJustifiees = $enfant->absences()->where('justifiee', false)->count();
                            $moyenneGenerale = round($enfant->notes()->avg('note') ?? 0, 2);
                            
                            // Dernières activités
                            $derniereNote = $enfant->notes()->latest()->first();
                            $derniereAbsence = $enfant->absences()->latest('date_absence')->first();
                            
                            $moyenneClass = $moyenneGenerale >= 10 ? 'text-green-600' : 'text-red-600';
                            $animationDelay = $index * 100;
                        @endphp

                        <div class="overflow-hidden transition-all duration-500 transform border shadow-xl group bg-white/90 backdrop-blur-xl border-white/50 rounded-2xl hover:shadow-2xl hover:-translate-y-2 animate-fade-in-up" style="animation-delay: {{ $animationDelay }}ms">
                            <!-- En-tête avec dégradé -->
                            <div class="relative h-32 bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600">
                                <div class="absolute inset-0 opacity-20">
                                    <div class="absolute w-40 h-40 bg-white rounded-full -top-20 -right-20 blur-2xl"></div>
                                    <div class="absolute w-40 h-40 bg-yellow-300 rounded-full -bottom-20 -left-20 blur-2xl"></div>
                                </div>

                                <!-- Avatar avec effet 3D -->
                                <div class="absolute -bottom-12 left-6">
                                    <div class="relative group/avatar perspective">
                                        <div class="relative transition-all duration-500 transform group-hover/avatar:rotate-y-180 preserve-3d">
                                            <div class="flex items-center justify-center w-24 h-24 text-3xl font-bold text-white transition-all duration-300 border-4 border-white shadow-2xl rounded-2xl bg-gradient-to-br from-blue-500 to-purple-600 group-hover:scale-110 group-hover:shadow-purple-500/50">
                                                {{ substr($enfant->prenom, 0, 1) }}{{ substr($enfant->nom, 0, 1) }}
                                            </div>
                                        </div>
                                        <div class="absolute w-5 h-5 bg-green-400 border-2 border-white rounded-full -bottom-1 -right-1 animate-pulse"></div>
                                    </div>
                                </div>

                                <!-- Lien parental avec badge -->
                                @if($enfant->lien_parental)
                                    <div class="absolute px-3 py-1.5 text-xs font-bold text-white bg-gradient-to-r from-purple-500 to-pink-600 rounded-full top-4 right-4 shadow-lg">
                                        {{ $enfant->lien_parental }}
                                    </div>
                                @endif

                                <!-- Badge moyenne sur l'en-tête -->
                                <div class="absolute top-4 left-32 px-3 py-1.5 bg-white/20 backdrop-blur-sm rounded-full border border-white/30">
                                    <span class="text-xs font-medium text-white">Moy. {{ number_format($moyenneGenerale, 1) }}</span>
                                </div>
                            </div>

                            <div class="p-6 pt-16">
                                <!-- Infos enfant -->
                                <div class="mb-4">
                                    <h4 class="text-xl font-bold text-gray-900 transition-colors group-hover:text-blue-600">{{ $enfant->prenom }} {{ $enfant->nom }}</h4>
                                    <div class="flex items-center mt-1 text-sm text-gray-500">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                        </svg>
                                        {{ $nomClasse }}
                                    </div>
                                    @if($dateInscription)
                                        <p class="flex items-center mt-1 text-xs text-gray-400">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            Inscrit le {{ $dateInscription }}
                                        </p>
                                    @endif
                                </div>

                                <!-- Statistiques avec jauges -->
                                <div class="grid grid-cols-3 gap-2 p-4 mb-4 bg-gray-50/80 rounded-xl">
                                    <div class="text-center">
                                        <p class="mb-1 text-xs text-gray-500">Notes</p>
                                        <div class="relative inline-flex items-center justify-center">
                                            <span class="text-xl font-bold text-green-600">{{ $notesCount }}</span>
                                        </div>
                                        <div class="w-full h-1 mt-1 overflow-hidden bg-gray-200 rounded-full">
                                            <div class="h-full bg-green-500 rounded-full" style="width: {{ min(($notesCount / 20) * 100, 100) }}%"></div>
                                        </div>
                                    </div>
                                    
                                    <div class="text-center">
                                        <p class="mb-1 text-xs text-gray-500">Absences</p>
                                        <span class="text-xl font-bold {{ $absencesNonJustifiees > 0 ? 'text-red-600' : 'text-gray-900' }}">
                                            {{ $absencesCount }}
                                        </span>
                                        @if($absencesNonJustifiees > 0)
                                            <p class="text-[10px] text-red-500 mt-1">{{ $absencesNonJustifiees }} non just.</p>
                                        @endif
                                        <div class="w-full h-1 mt-1 overflow-hidden bg-gray-200 rounded-full">
                                            <div class="h-full {{ $absencesNonJustifiees > 0 ? 'bg-red-500' : 'bg-gray-400' }} rounded-full" 
                                                 style="width: {{ $absencesCount > 0 ? min(($absencesNonJustifiees / $absencesCount) * 100, 100) : 0 }}%"></div>
                                        </div>
                                    </div>
                                    
                                    <div class="text-center">
                                        <p class="mb-1 text-xs text-gray-500">Moyenne</p>
                                        <div class="relative inline-flex items-center justify-center">
                                            <span class="text-xl font-bold {{ $moyenneClass }}">{{ number_format($moyenneGenerale, 2) }}</span>
                                        </div>
                                        <div class="w-full h-1 mt-1 overflow-hidden bg-gray-200 rounded-full">
                                            <div class="h-full {{ $moyenneGenerale >= 10 ? 'bg-green-500' : 'bg-red-500' }} rounded-full" style="width: {{ ($moyenneGenerale / 20) * 100 }}%"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Actions rapides avec tooltips -->
                                <div class="grid grid-cols-4 gap-2 mb-4">
                                    <a href="{{ route('parent.enfant.notes', $enfant->id) }}" 
                                       class="relative flex flex-col items-center p-3 text-green-700 transition-all duration-300 group/btn bg-green-50 rounded-xl hover:bg-green-100 hover:scale-110"
                                       title="Voir les notes">
                                        <svg class="w-5 h-5 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span class="text-[10px] font-medium">Notes</span>
                                        <span class="absolute px-2 py-1 text-xs text-white transition-opacity transform -translate-x-1/2 bg-gray-900 rounded opacity-0 pointer-events-none -top-8 left-1/2 group-hover/btn:opacity-100 whitespace-nowrap">
                                            Voir les notes
                                        </span>
                                    </a>

                                    <a href="{{ route('parent.enfant.absences', $enfant->id) }}" 
                                       class="relative flex flex-col items-center p-3 text-red-700 transition-all duration-300 group/btn bg-red-50 rounded-xl hover:bg-red-100 hover:scale-110"
                                       title="Voir les absences">
                                        <svg class="w-5 h-5 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                        </svg>
                                        <span class="text-[10px] font-medium">Absences</span>
                                        <span class="absolute px-2 py-1 text-xs text-white transition-opacity transform -translate-x-1/2 bg-gray-900 rounded opacity-0 pointer-events-none -top-8 left-1/2 group-hover/btn:opacity-100 whitespace-nowrap">
                                            Voir les absences
                                        </span>
                                    </a>

                                    <a href="{{ route('parent.enfant.bulletin', $enfant->id) }}" 
                                       class="relative flex flex-col items-center p-3 text-purple-700 transition-all duration-300 group/btn bg-purple-50 rounded-xl hover:bg-purple-100 hover:scale-110"
                                       title="Voir les bulletins">
                                        <svg class="w-5 h-5 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        <span class="text-[10px] font-medium">Bulletins</span>
                                        <span class="absolute px-2 py-1 text-xs text-white transition-opacity transform -translate-x-1/2 bg-gray-900 rounded opacity-0 pointer-events-none -top-8 left-1/2 group-hover/btn:opacity-100 whitespace-nowrap">
                                            Voir les bulletins
                                        </span>
                                    </a>

                                    <a href="{{ route('parent.enfant.emploi-du-temps', $enfant->id) }}" 
                                       class="relative flex flex-col items-center p-3 text-blue-700 transition-all duration-300 group/btn bg-blue-50 rounded-xl hover:bg-blue-100 hover:scale-110"
                                       title="Voir l'emploi du temps">
                                        <svg class="w-5 h-5 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <span class="text-[10px] font-medium">Emploi</span>
                                        <span class="absolute px-2 py-1 text-xs text-white transition-opacity transform -translate-x-1/2 bg-gray-900 rounded opacity-0 pointer-events-none -top-8 left-1/2 group-hover/btn:opacity-100 whitespace-nowrap">
                                            Voir l'emploi du temps
                                        </span>
                                    </a>
                                </div>

                                <!-- Dernière activité avec indicateurs -->
                                <div class="pt-4 mt-4 text-xs border-t border-gray-100">
                                    @if($derniereNote || $derniereAbsence)
                                        <div class="space-y-2">
                                            @if($derniereNote)
                                                <div class="flex items-center justify-between group/activity">
                                                    <span class="flex items-center text-gray-500">
                                                        <span class="w-2 h-2 mr-2 bg-green-500 rounded-full group-hover/activity:animate-pulse"></span>
                                                        Dernière note:
                                                    </span>
                                                    <span class="font-medium text-gray-700">{{ $derniereNote->created_at->format('d/m/Y') }}</span>
                                                </div>
                                            @endif

                                            @if($derniereAbsence)
                                                <div class="flex items-center justify-between group/activity">
                                                    <span class="flex items-center text-gray-500">
                                                        <span class="w-2 h-2 {{ $derniereAbsence->justifiee ? 'bg-green-500' : 'bg-red-500' }} rounded-full mr-2 group-hover/activity:animate-pulse"></span>
                                                        Dernière absence:
                                                    </span>
                                                    <span class="font-medium text-gray-700">{{ \Carbon\Carbon::parse($derniereAbsence->date_absence)->format('d/m/Y') }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    @else
                                        <div class="py-2 text-center text-gray-400">
                                            <span class="flex items-center justify-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                Aucune activité récente
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- État vide amélioré -->
                <div class="relative p-16 overflow-hidden text-center border shadow-xl bg-white/90 backdrop-blur-xl border-white/50 rounded-2xl">
                    <div class="absolute inset-0 opacity-10">
                        <div class="absolute w-64 h-64 bg-blue-300 rounded-full -top-32 -right-32 blur-3xl"></div>
                        <div class="absolute w-64 h-64 bg-purple-300 rounded-full -bottom-32 -left-32 blur-3xl"></div>
                    </div>

                    <div class="relative">
                        <div class="relative inline-block animate-float">
                            <div class="absolute inset-0 bg-blue-300 rounded-full opacity-50 blur-xl"></div>
                            <svg class="relative text-blue-400 w-28 h-28" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                        <h3 class="mt-6 text-2xl font-semibold text-gray-700">Aucun enfant associé</h3>
                        <p class="max-w-md mx-auto mt-2 text-gray-500">
                            Vous n'avez pas encore d'enfants liés à votre compte parent. 
                            Veuillez contacter l'administration pour associer vos enfants.
                        </p>
                        <div class="flex justify-center mt-8 space-x-4">
                            <a href="{{ route('parent.dashboard') }}" 
                               class="inline-flex items-center px-6 py-3 font-semibold text-white transition-all duration-300 transform bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl hover:from-blue-600 hover:to-indigo-700 hover:scale-105 hover:shadow-lg">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                                Tableau de bord
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <style>
        @keyframes gradient-xy {
            0%, 100% { background-position: 0% 50%; }
            25% { background-position: 50% 100%; }
            50% { background-position: 100% 50%; }
            75% { background-position: 50% 0%; }
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        @keyframes float-random {
            0%, 100% { transform: translate(0, 0); }
            25% { transform: translate(10px, -10px); }
            50% { transform: translate(-10px, 5px); }
            75% { transform: translate(5px, 10px); }
        }
        @keyframes slide-in-left {
            from { opacity: 0; transform: translateX(-50px); }
            to { opacity: 1; transform: translateX(0); }
        }
        @keyframes slide-in-right {
            from { opacity: 0; transform: translateX(50px); }
            to { opacity: 1; transform: translateX(0); }
        }
        @keyframes fade-in-up {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes count {
            from { opacity: 0; transform: scale(0.5); }
            to { opacity: 1; transform: scale(1); }
        }
        @keyframes pulse-slow {
            0%, 100% { opacity: 0.6; }
            50% { opacity: 1; }
        }
        @keyframes bounce-subtle {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-3px); }
        }

        .animate-gradient-xy {
            background-size: 300% 300%;
            animation: gradient-xy 15s ease infinite;
        }
        .animate-float {
            animation: float 3s ease-in-out infinite;
        }
        .animate-float-random {
            animation: float-random 10s ease-in-out infinite;
        }
        .animate-slide-in-left {
            animation: slide-in-left 0.7s ease-out forwards;
        }
        .animate-slide-in-right {
            animation: slide-in-right 0.7s ease-out forwards;
        }
        .animate-fade-in-up {
            animation: fade-in-up 0.8s ease-out forwards;
        }
        .animate-count {
            animation: count 0.5s ease-out;
        }
        .animate-pulse-slow {
            animation: pulse-slow 3s ease-in-out infinite;
        }
        .animate-bounce-subtle {
            animation: bounce-subtle 2s ease-in-out infinite;
        }

        .animation-delay-200 { animation-delay: 200ms; }
        .animation-delay-400 { animation-delay: 400ms; }
        .animation-delay-600 { animation-delay: 600ms; }
        .animation-delay-2000 { animation-delay: 2000ms; }

        .hover\:-translate-y-2:hover { transform: translateY(-0.5rem); }
        .hover\:scale-110:hover { transform: scale(1.10); }

        .preserve-3d {
            transform-style: preserve-3d;
        }
        .hover\:rotate-y-180:hover {
            transform: rotateY(180deg);
        }
        .perspective {
            perspective: 1000px;
        }
    </style>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animation des nombres dans les stats
            const counters = document.querySelectorAll('.animate-count');
            counters.forEach(counter => {
                const target = parseInt(counter.innerText);
                if (!isNaN(target) && target > 0) {
                    let count = 0;
                    const updateCounter = () => {
                        if (count < target) {
                            count++;
                            counter.innerText = count;
                            setTimeout(updateCounter, 10);
                        }
                    };
                    updateCounter();
                }
            });

            // Animation au scroll
            const cards = document.querySelectorAll('.group');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate-fade-in-up');
                    }
                });
            }, { threshold: 0.1 });

            cards.forEach(card => observer.observe(card));
        });
    </script>
@endsection