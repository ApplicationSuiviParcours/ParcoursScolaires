@extends('layouts.app')

@section('header')
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
        {{ __('Bulletin de ') . $eleve->prenom . ' ' . $eleve->nom . ' - ' . ($bulletin->periode ?? 'Bulletin') }}
    </h2>
@endsection

@section('content')
    @php
        // Valeurs par défaut pour éviter les erreurs
        $moyenneGenerale = $moyenneGenerale ?? 0;
        $moyenneClasse = $moyenneClasse ?? 0;
        $totalPoints = $totalPoints ?? 0;
        $totalCoefficients = $totalCoefficients ?? 0;
        $notesParMatiere = $notesParMatiere ?? [];
        $mention = $mention ?? 'Non définie';
        $estAdmis = $estAdmis ?? false;
        $appreciations = $appreciations ?? [];
        
        $hasNotes = count($notesParMatiere) > 0;
        $mentionClass = $mention == 'Très bien' ? 'from-green-500 to-emerald-600' :
                       ($mention == 'Bien' ? 'from-blue-500 to-cyan-600' :
                       ($mention == 'Assez bien' ? 'from-yellow-500 to-amber-600' :
                       ($mention == 'Passable' ? 'from-orange-500 to-amber-600' : 'from-red-500 to-rose-600')));
    @endphp

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

            <!-- Header avec design moderne -->
            <div class="relative mb-8 overflow-hidden group rounded-3xl">
                <div class="absolute inset-0 bg-gradient-to-r from-purple-700 via-purple-600 to-indigo-700 animate-gradient-xy"></div>
                <div class="absolute inset-0 opacity-20">
                    <div class="absolute rounded-full bg-white/30 w-96 h-96 -top-48 -right-48 blur-3xl animate-pulse-slow"></div>
                    <div class="absolute rounded-full bg-yellow-300/30 w-96 h-96 -bottom-48 -left-48 blur-3xl animate-pulse-slow animation-delay-2000"></div>
                </div>

                <!-- Particules animées -->
                <div class="absolute inset-0">
                    @for($i = 0; $i < 15; $i++)
                        <div class="absolute w-1 h-1 rounded-full bg-white/60 animate-float-random"
                            style="left: {{ rand(0, 100) }}%; top: {{ rand(0, 100) }}%; animation-delay: {{ rand(0, 5) }}s;">
                        </div>
                    @endfor
                </div>

                <div class="relative p-8">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                        <div class="flex items-center space-x-6">
                            <!-- Avatar élève avec effet 3D -->
                            <div class="relative group perspective">
                                <div class="relative transition-all duration-500 transform group-hover:rotate-y-180 preserve-3d">
                                    <div class="flex items-center justify-center w-24 h-24 transition-all duration-300 border-4 shadow-2xl bg-white/20 backdrop-blur-xl rounded-2xl border-white/50 group-hover:scale-110 group-hover:shadow-purple-500/50">
                                        <span class="text-4xl font-bold text-white drop-shadow-lg">
                                            {{ substr($eleve->prenom, 0, 1) }}{{ substr($eleve->nom, 0, 1) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="absolute w-5 h-5 bg-green-400 border-4 border-white rounded-full -bottom-1 -right-1 animate-pulse ring-2 ring-purple-500/50"></div>
                            </div>

                            <div class="transition-all duration-700 transform animate-slide-in-left">
                                <h3 class="text-4xl font-black tracking-tight text-white drop-shadow-xl">Bulletin scolaire</h3>
                                <div class="flex flex-wrap items-center gap-2 mt-3">
                                    <span class="inline-flex items-center px-4 py-2 text-sm font-medium text-white transition-all border rounded-full bg-white/20 backdrop-blur-sm border-white/30 hover:bg-white/30">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        {{ $eleve->prenom }} {{ $eleve->nom }}
                                    </span>
                                    <span class="inline-flex items-center px-4 py-2 text-sm font-medium text-white transition-all border rounded-full bg-white/20 backdrop-blur-sm border-white/30 hover:bg-white/30">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                        </svg>
                                        {{ $bulletin->classe->nom ?? 'Classe' }}
                                    </span>
                                    <span class="inline-flex items-center px-4 py-2 text-sm font-medium text-white transition-all border rounded-full bg-white/20 backdrop-blur-sm border-white/30 hover:bg-white/30">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        {{ $bulletin->periode ?? 'Période' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 text-center lg:mt-0 lg:text-right">
                            <p class="text-sm font-medium tracking-wider text-purple-200 uppercase">Moyenne générale</p>
                            <div class="flex items-center justify-center lg:justify-end">
                                <span class="text-6xl font-black text-white drop-shadow-2xl">{{ number_format($moyenneGenerale, 2) }}</span>
                                <span class="ml-2 text-2xl font-light text-purple-200">/20</span>
                            </div>
                            <div class="mt-2 px-4 py-1.5 bg-white/20 backdrop-blur-sm rounded-full inline-flex items-center">
                                <span class="w-2 h-2 mr-2 bg-green-400 rounded-full animate-pulse"></span>
                                <span class="text-xs text-white">Mise à jour récente</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Navigation et actions -->
            <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
                <a href="{{ route('parent.enfant.bulletin', $eleve->id) }}"
                    class="group inline-flex items-center px-5 py-2.5 text-gray-700 bg-white/80 backdrop-blur-sm hover:bg-white rounded-xl transition-all duration-300 shadow-md hover:shadow-xl border border-gray-200/50">
                    <svg class="w-5 h-5 mr-2 text-purple-600 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    <span class="font-medium">Retour aux bulletins</span>
                </a>

                <div class="flex space-x-2">
                    <button onclick="window.print()" class="p-3 text-gray-600 transition-all border shadow-md bg-white/80 backdrop-blur-sm hover:bg-white rounded-xl hover:shadow-lg border-gray-200/50 group" title="Imprimer">
                        <svg class="w-5 h-5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                        </svg>
                    </button>
                    <a href="{{ route('parent.telecharger-bulletin', [$eleve->id, $bulletin->id]) }}"
                        class="inline-flex items-center px-5 py-3 font-semibold text-white transition-all shadow-lg bg-gradient-to-r from-purple-600 to-indigo-600 rounded-xl hover:from-purple-700 hover:to-indigo-700 hover:shadow-xl group">
                        <svg class="w-5 h-5 mr-2 group-hover:animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        Télécharger PDF
                    </a>
                </div>
            </div>

            <!-- Informations générales avec design moderne -->
            <div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-4">
                <!-- Rang -->
                <div class="relative p-6 overflow-hidden transition-all duration-500 border shadow-xl group bg-white/90 backdrop-blur-xl border-white/50 rounded-2xl hover:shadow-2xl hover:-translate-y-1">
                    <div class="absolute inset-0 transition-opacity opacity-0 bg-gradient-to-r from-blue-500/10 to-indigo-500/10 group-hover:opacity-100"></div>
                    <div class="relative flex items-center justify-between">
                        <div>
                            <p class="flex items-center text-sm font-medium text-gray-600">
                                <span class="w-2 h-2 mr-2 bg-blue-500 rounded-full animate-pulse"></span>
                                Rang
                            </p>
                            <p class="mt-2 text-4xl font-black text-gray-900">{{ $bulletin->rang ?? '-' }}</p>
                            @if($bulletin->effectif_classe)
                                <p class="mt-1 text-xs text-gray-500">sur {{ $bulletin->effectif_classe }} élèves</p>
                            @endif
                        </div>
                        <div class="p-4 transition-transform shadow-lg bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl group-hover:scale-110">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Moyenne classe -->
                <div class="relative p-6 overflow-hidden transition-all duration-500 border shadow-xl group bg-white/90 backdrop-blur-xl border-white/50 rounded-2xl hover:shadow-2xl hover:-translate-y-1">
                    <div class="absolute inset-0 transition-opacity opacity-0 bg-gradient-to-r from-green-500/10 to-emerald-500/10 group-hover:opacity-100"></div>
                    <div class="relative flex items-center justify-between">
                        <div>
                            <p class="flex items-center text-sm font-medium text-gray-600">
                                <span class="w-2 h-2 mr-2 bg-green-500 rounded-full animate-pulse animation-delay-200"></span>
                                Moyenne classe
                            </p>
                            <p class="mt-2 text-4xl font-black text-gray-900">{{ number_format($moyenneClasse, 2) }}</p>
                            <p class="mt-1 text-xs text-gray-500">/20</p>
                        </div>
                        <div class="p-4 transition-transform shadow-lg bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl group-hover:scale-110">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Écart -->
                <div class="relative p-6 overflow-hidden transition-all duration-500 border shadow-xl group bg-white/90 backdrop-blur-xl border-white/50 rounded-2xl hover:shadow-2xl hover:-translate-y-1">
                    @php $ecart = $moyenneGenerale - $moyenneClasse; @endphp
                    <div class="absolute inset-0 transition-opacity opacity-0 bg-gradient-to-r from-purple-500/10 to-pink-500/10 group-hover:opacity-100"></div>
                    <div class="relative flex items-center justify-between">
                        <div>
                            <p class="flex items-center text-sm font-medium text-gray-600">
                                <span class="w-2 h-2 mr-2 bg-purple-500 rounded-full animate-pulse animation-delay-400"></span>
                                Écart
                            </p>
                            <p class="mt-2 text-4xl font-black {{ $ecart >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                {{ $ecart >= 0 ? '+' : '' }}{{ number_format($ecart, 2) }}
                            </p>
                            <p class="mt-1 text-xs text-gray-500">par rapport à la classe</p>
                        </div>
                        <div class="p-4 transition-transform shadow-lg bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl group-hover:scale-110">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7l.01 0M7 3h5c.512 0 1.024.195 1.414.586l5 5a2 2 0 01.586 1.414V19a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Total points -->
                <div class="relative p-6 overflow-hidden transition-all duration-500 border shadow-xl group bg-white/90 backdrop-blur-xl border-white/50 rounded-2xl hover:shadow-2xl hover:-translate-y-1">
                    <div class="absolute inset-0 transition-opacity opacity-0 bg-gradient-to-r from-orange-500/10 to-red-500/10 group-hover:opacity-100"></div>
                    <div class="relative flex items-center justify-between">
                        <div>
                            <p class="flex items-center text-sm font-medium text-gray-600">
                                <span class="w-2 h-2 mr-2 bg-orange-500 rounded-full animate-pulse animation-delay-600"></span>
                                Total points
                            </p>
                            <p class="mt-2 text-4xl font-black text-gray-900">{{ number_format($totalPoints, 2) }}</p>
                            <p class="mt-1 text-xs text-gray-500">Coeff. {{ $totalCoefficients }}</p>
                        </div>
                        <div class="p-4 transition-transform shadow-lg bg-gradient-to-br from-orange-500 to-red-600 rounded-2xl group-hover:scale-110">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mention et statut avec design moderne -->
            <div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-2">
                <div class="relative p-6 overflow-hidden transition-all duration-500 border shadow-xl group bg-white/90 backdrop-blur-xl border-white/50 rounded-2xl hover:shadow-2xl hover:-translate-y-1">
                    <div class="absolute inset-0 transition-opacity opacity-0 bg-gradient-to-r from-purple-500/10 to-pink-500/10 group-hover:opacity-100"></div>
                    <div class="relative flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Mention</p>
                            <div class="flex items-center mt-2">
                                <div class="w-12 h-12 bg-gradient-to-br {{ $mentionClass }} rounded-xl flex items-center justify-center shadow-lg mr-4">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-3xl font-black {{ $mention == 'Très bien' ? 'text-green-600' : 
                                        ($mention == 'Bien' ? 'text-blue-600' : 
                                        ($mention == 'Assez bien' ? 'text-yellow-600' : 
                                        ($mention == 'Passable' ? 'text-orange-600' : 'text-red-600'))) }}">
                                        {{ $mention }}
                                    </p>
                                    <p class="text-xs text-gray-500">Mention obtenue</p>
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-6xl font-black {{ $moyenneGenerale >= 10 ? 'text-green-600' : 'text-red-600' }} opacity-20">{{ number_format($moyenneGenerale, 1) }}</div>
                        </div>
                    </div>
                </div>

                <div class="relative p-6 overflow-hidden transition-all duration-500 border shadow-xl group bg-white/90 backdrop-blur-xl border-white/50 rounded-2xl hover:shadow-2xl hover:-translate-y-1">
                    <div class="absolute inset-0 transition-opacity opacity-0 bg-gradient-to-r from-green-500/10 to-emerald-500/10 group-hover:opacity-100"></div>
                    <div class="relative flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Statut</p>
                            <div class="flex items-center mt-2">
                                <div class="w-12 h-12 {{ $estAdmis ? 'bg-gradient-to-br from-green-500 to-emerald-600' : 'bg-gradient-to-br from-red-500 to-rose-600' }} rounded-xl flex items-center justify-center shadow-lg mr-4">
                                    @if($estAdmis)
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    @else
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-3xl font-black {{ $estAdmis ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $estAdmis ? 'ADMIS' : 'NON ADMIS' }}
                                    </p>
                                    <p class="text-xs text-gray-500">Seuil d'admission : 10/20</p>
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="relative w-20 h-20">
                                <svg class="w-20 h-20 transform -rotate-90">
                                    <circle cx="40" cy="40" r="36" fill="none" stroke="#e5e7eb" stroke-width="4"/>
                                    <circle cx="40" cy="40" r="36" fill="none" 
                                        stroke="{{ $estAdmis ? '#10b981' : '#ef4444' }}" 
                                        stroke-width="4"
                                        stroke-dasharray="226.2"
                                        stroke-dashoffset="{{ 226.2 * (1 - min($moyenneGenerale/20, 1)) }}"
                                        stroke-linecap="round"
                                        class="transition-all duration-1000"/>
                                </svg>
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <span class="text-sm font-bold">{{ number_format(($moyenneGenerale/20)*100, 0) }}%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Appréciation générale -->
            @if($bulletin->appreciation)
                <div class="p-6 mb-8 border shadow-lg border-yellow-200/50 bg-gradient-to-r from-yellow-50/80 to-amber-50/80 backdrop-blur-sm rounded-2xl">
                    <div class="flex items-start space-x-4">
                        <div class="p-3 shadow-lg bg-gradient-to-br from-yellow-500 to-amber-500 rounded-xl">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                                </path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="mb-2 text-sm font-semibold tracking-wider text-gray-600 uppercase">Appréciation générale</p>
                            <p class="text-xl italic leading-relaxed text-gray-700">"{{ $bulletin->appreciation }}"</p>
                            <p class="flex items-center mt-2 text-xs text-gray-500">
                                <span class="w-1 h-1 mr-2 bg-gray-400 rounded-full"></span>
                                {{ $bulletin->date_bulletin ? \Carbon\Carbon::parse($bulletin->date_bulletin)->format('d F Y') : '' }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Message si aucune note -->
            @if(!$hasNotes)
            <div class="p-8 mb-6 text-center border border-yellow-200 bg-gradient-to-r from-yellow-50 to-amber-50 rounded-2xl">
                <div class="inline-flex items-center justify-center w-20 h-20 mb-4 bg-yellow-100 rounded-full">
                    <svg class="w-10 h-10 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <h4 class="mb-2 text-xl font-semibold text-gray-800">Aucune note disponible</h4>
                <p class="text-gray-600">Les notes pour ce bulletin n'ont pas encore été saisies.</p>
            </div>
            @endif

            <!-- Détail des notes par matière avec design moderne -->
            @if($hasNotes)
            <div class="overflow-hidden border shadow-xl bg-white/90 backdrop-blur-xl border-white/50 rounded-2xl">
                <div class="p-6 border-b border-gray-100/50 bg-gradient-to-r from-purple-50/80 to-indigo-50/80">
                    <div class="flex items-center justify-between">
                        <h4 class="flex items-center text-xl font-semibold text-gray-900">
                            <svg class="w-6 h-6 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                </path>
                            </svg>
                            Détail des notes par matière
                        </h4>
                        <span class="px-4 py-2 text-sm text-gray-600 border border-gray-200 rounded-full bg-white/50 backdrop-blur-sm">
                            {{ collect($notesParMatiere)->sum(fn($m) => count($m['notes'])) }} note(s) au total
                        </span>
                    </div>
                </div>

                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-6 py-4 text-xs font-bold tracking-wider text-left text-gray-600 uppercase bg-gray-50/50 rounded-tl-xl">Matière</th>
                                    <th class="px-6 py-4 text-xs font-bold tracking-wider text-left text-gray-600 uppercase bg-gray-50/50">Coefficient</th>
                                    <th class="px-6 py-4 text-xs font-bold tracking-wider text-left text-gray-600 uppercase bg-gray-50/50">Notes</th>
                                    <th class="px-6 py-4 text-xs font-bold tracking-wider text-left text-gray-600 uppercase bg-gray-50/50">Moyenne</th>
                                    <th class="px-6 py-4 text-xs font-bold tracking-wider text-left text-gray-600 uppercase bg-gray-50/50 rounded-tr-xl">Appréciation</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @foreach($notesParMatiere as $matiereId => $data)
                                    @php
                                        $moyenneMatiere = $data['moyenne'] ?? 0;
                                        $gradientClass = $moyenneMatiere >= 16 ? 'from-green-500 to-emerald-600' :
                                                         ($moyenneMatiere >= 14 ? 'from-blue-500 to-cyan-600' :
                                                         ($moyenneMatiere >= 10 ? 'from-yellow-500 to-amber-600' :
                                                         'from-red-500 to-rose-600'));
                                    @endphp
                                    <tr class="transition-all duration-300 group hover:bg-gradient-to-r hover:from-purple-50/50 hover:to-indigo-50/50">
                                        <td class="px-6 py-5">
                                            <div class="flex items-center">
                                                <div class="flex items-center justify-center w-10 h-10 mr-3 transition-transform shadow-lg bg-gradient-to-br from-purple-500 to-indigo-600 rounded-xl group-hover:scale-110">
                                                    <span class="text-sm font-bold text-white">{{ substr($data['matiere_nom'] ?? 'M', 0, 3) }}</span>
                                                </div>
                                                <span class="font-semibold text-gray-800">{{ $data['matiere_nom'] ?? 'Matière inconnue' }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-5">
                                            <span class="px-4 py-2 text-sm font-bold text-purple-700 bg-purple-100 border border-purple-200 rounded-full">
                                                x{{ $data['coefficient'] ?? 1 }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-5">
                                            <div class="flex flex-wrap gap-2">
                                                @forelse($data['notes'] ?? [] as $note)
                                                    @php
                                                        $couleurNote = $note['valeur'] >= 16 ? 'from-green-500 to-emerald-600' :
                                                                      ($note['valeur'] >= 14 ? 'from-blue-500 to-cyan-600' :
                                                                      ($note['valeur'] >= 10 ? 'from-yellow-500 to-amber-600' :
                                                                      'from-red-500 to-rose-600'));
                                                        $bgColor = $note['valeur'] >= 16 ? 'bg-green-100 text-green-800 border-green-200' :
                                                                  ($note['valeur'] >= 14 ? 'bg-blue-100 text-blue-800 border-blue-200' :
                                                                  ($note['valeur'] >= 10 ? 'bg-yellow-100 text-yellow-800 border-yellow-200' :
                                                                  'bg-red-100 text-red-800 border-red-200'));
                                                    @endphp
                                                    <span class="relative group/note">
                                                        <span class="inline-flex items-center px-3 py-1.5 text-xs font-bold {{ $bgColor }} rounded-lg border shadow-sm cursor-help">
                                                            {{ number_format($note['valeur'] ?? 0, 1) }}
                                                        </span>
                                                        <div class="absolute z-10 px-3 py-2 mb-2 text-xs text-white transition-opacity transform -translate-x-1/2 bg-gray-900 rounded-lg opacity-0 pointer-events-none bottom-full left-1/2 group-hover/note:opacity-100 whitespace-nowrap">
                                                            {{ $note['evaluation'] ?? 'Évaluation' }}
                                                            @if(!empty($note['date']))
                                                                <br><span class="text-gray-400">{{ \Carbon\Carbon::parse($note['date'])->format('d/m/Y') }}</span>
                                                            @endif
                                                        </div>
                                                    </span>
                                                @empty
                                                    <span class="text-sm italic text-gray-400">Aucune note</span>
                                                @endforelse
                                            </div>
                                        </td>
                                        <td class="px-6 py-5">
                                            <div class="relative inline-block">
                                                <span class="px-5 py-2.5 text-sm font-black rounded-xl bg-gradient-to-r {{ $gradientClass }} text-white shadow-lg group-hover:shadow-xl transition-all">
                                                    {{ number_format($moyenneMatiere, 2) }}/20
                                                </span>
                                                <span class="absolute w-3 h-3 bg-green-400 border-2 border-white rounded-full -top-2 -right-2 animate-pulse"></span>
                                            </div>
                                        </td>
                                        <td class="max-w-xs px-6 py-5">
                                            @php
                                                $appreciationTrouvee = '-';
                                                foreach($data['notes'] ?? [] as $note) {
                                                    if(!empty($note['appreciation'])) {
                                                        $appreciationTrouvee = $note['appreciation'];
                                                        break;
                                                    }
                                                }
                                            @endphp
                                            @if($appreciationTrouvee != '-')
                                                <div class="flex items-center space-x-2 group/appreciation">
                                                    <svg class="flex-shrink-0 w-4 h-4 text-purple-500" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    <span class="text-sm italic text-gray-600 truncate transition-colors group-hover/appreciation:text-purple-600 cursor-help" title="{{ $appreciationTrouvee }}">
                                                        "{{ Str::limit($appreciationTrouvee, 30) }}"
                                                    </span>
                                                </div>
                                            @else
                                                <span class="text-sm italic text-gray-400">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach

                                <!-- Ligne récapitulative -->
                                <tr class="font-semibold bg-gradient-to-r from-purple-50 to-indigo-50">
                                    <td colspan="2" class="px-6 py-5 text-sm text-gray-700">
                                        <span class="flex items-center">
                                            <span class="w-2 h-2 mr-2 bg-purple-600 rounded-full"></span>
                                            Total général
                                        </span>
                                    </td>
                                    <td class="px-6 py-5 text-sm text-gray-700">
                                        <span class="font-bold">{{ number_format($totalPoints, 2) }}</span> points
                                    </td>
                                    <td class="px-6 py-5 text-sm text-gray-700">
                                        <span class="font-bold">{{ $totalCoefficients }}</span> coeff.
                                    </td>
                                    <td class="px-6 py-5 text-sm text-gray-700">
                                        Moy. <span class="font-bold {{ $moyenneGenerale >= 10 ? 'text-green-600' : 'text-red-600' }}">{{ number_format($moyenneGenerale, 2) }}</span>/20
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

            <!-- Appréciations des professeurs -->
            @if(count($appreciations) > 0)
            <div class="mt-8 overflow-hidden border shadow-xl bg-white/90 backdrop-blur-xl border-white/50 rounded-2xl">
                <div class="p-6 border-b border-gray-100/50 bg-gradient-to-r from-yellow-50/80 to-amber-50/80">
                    <h4 class="flex items-center text-xl font-semibold text-gray-900">
                        <svg class="w-6 h-6 mr-2 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                        </svg>
                        Appréciations des professeurs
                    </h4>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        @foreach($appreciations as $appreciation)
                        <div class="p-5 transition-all border border-yellow-100 group bg-gradient-to-br from-yellow-50 to-amber-50/50 rounded-xl hover:shadow-lg hover:-translate-y-1">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex items-center">
                                    <div class="flex items-center justify-center w-10 h-10 mr-3 rounded-lg shadow-md bg-gradient-to-br from-yellow-500 to-amber-600">
                                        <span class="text-sm font-bold text-white">{{ substr($appreciation->professeur->nom ?? 'P', 0, 2) }}</span>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $appreciation->professeur->nom ?? 'Professeur' }}</p>
                                        <p class="text-xs text-gray-500">{{ $appreciation->matiere->nom ?? 'Général' }}</p>
                                    </div>
                                </div>
                                <span class="px-2 py-1 text-xs text-gray-400 rounded-full bg-white/50">
                                    {{ $appreciation->created_at ? $appreciation->created_at->format('d/m/Y') : '' }}
                                </span>
                            </div>
                            <p class="italic leading-relaxed text-gray-700">"{{ $appreciation->contenu ?? '' }}"</p>
                            <div class="flex justify-end mt-2">
                                <span class="text-xs text-gray-400">Professeur principal</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Mini graphique de progression -->
            @if($hasNotes && count($notesParMatiere) > 0)
            <div class="p-6 mt-8 border shadow-xl bg-white/90 backdrop-blur-xl border-white/50 rounded-2xl">
                <h4 class="flex items-center mb-4 text-lg font-semibold text-gray-900">
                    <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    Comparatif des moyennes par matière
                </h4>
                <div class="space-y-3">
                    @foreach($notesParMatiere as $data)
                        @php
                            $pourcentage = ($data['moyenne'] / 20) * 100;
                            $barColor = $data['moyenne'] >= 16 ? 'bg-gradient-to-r from-green-500 to-emerald-500' :
                                       ($data['moyenne'] >= 14 ? 'bg-gradient-to-r from-blue-500 to-cyan-500' :
                                       ($data['moyenne'] >= 10 ? 'bg-gradient-to-r from-yellow-500 to-amber-500' :
                                       'bg-gradient-to-r from-red-500 to-rose-500'));
                        @endphp
                        <div>
                            <div class="flex justify-between mb-1 text-sm">
                                <span class="font-medium text-gray-700">{{ $data['matiere_nom'] }}</span>
                                <span class="font-bold {{ $data['moyenne'] >= 10 ? 'text-green-600' : 'text-red-600' }}">{{ number_format($data['moyenne'], 2) }}/20</span>
                            </div>
                            <div class="w-full h-3 overflow-hidden bg-gray-200 rounded-full">
                                <div class="h-full {{ $barColor }} rounded-full transition-all duration-1000" style="width: {{ $pourcentage }}%"></div>
                            </div>
                        </div>
                    @endforeach
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
        @keyframes pulse-slow {
            0%, 100% { opacity: 0.6; }
            50% { opacity: 1; }
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
        .animate-pulse-slow {
            animation: pulse-slow 3s ease-in-out infinite;
        }
        .animation-delay-200 {
            animation-delay: 200ms;
        }
        .animation-delay-400 {
            animation-delay: 400ms;
        }
        .animation-delay-600 {
            animation-delay: 600ms;
        }
        .animation-delay-2000 {
            animation-delay: 2000ms;
        }
        .hover\:-translate-y-2:hover {
            transform: translateY(-0.5rem);
        }
        .preserve-3d {
            transform-style: preserve-3d;
        }
        .hover\:rotate-y-180:hover {
            transform: rotateY(180deg);
        }
        .perspective {
            perspective: 1000px;
        }

        @media print {
            .no-print {
                display: none;
            }
            body {
                background: white;
            }
            .bg-gradient-to-r {
                background: #f3f4f6 !important;
                color: black !important;
            }
            .text-white {
                color: black !important;
            }
        }
    </style>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animation des nombres
            const counters = document.querySelectorAll('.animate-count');
            counters.forEach(counter => {
                const target = parseInt(counter.innerText);
                let count = 0;
                const updateCounter = () => {
                    if (count < target) {
                        count++;
                        counter.innerText = count;
                        setTimeout(updateCounter, 10);
                    }
                };
                updateCounter();
            });

            // Tooltips pour les notes
            const notes = document.querySelectorAll('.group/note');
            notes.forEach(note => {
                note.addEventListener('mouseenter', function() {
                    const tooltip = this.querySelector('.opacity-0');
                    if (tooltip) {
                        tooltip.classList.remove('opacity-0');
                        tooltip.classList.add('opacity-100');
                    }
                });
                note.addEventListener('mouseleave', function() {
                    const tooltip = this.querySelector('.opacity-100');
                    if (tooltip) {
                        tooltip.classList.remove('opacity-100');
                        tooltip.classList.add('opacity-0');
                    }
                });
            });
        });
    </script>
@endsection