@extends('layouts.app')

@section('header')
    <div class="flex items-center justify-between">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Parcours Académique de ') }} {{ $eleve->nom_complet }}
        </h2>
        <a href="{{ route('admin.eleves.show', $eleve) }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Retour au profil
        </a>
    </div>
@endsection

@section('content')
<div class="py-12">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        
        <!-- En-tête du Parcours -->
        <div class="relative mb-8 overflow-hidden bg-white shadow-2xl rounded-3xl group">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-700 via-indigo-700 to-indigo-900 opacity-95"></div>
            <div class="absolute inset-0 opacity-20">
                <div class="absolute bg-white rounded-full w-96 h-96 -top-48 -right-48 blur-3xl animate-pulse"></div>
            </div>
            
            <div class="relative p-8 md:p-12">
                <div class="flex flex-col md:flex-row items-center gap-8">
                    <div class="relative">
                        <div class="absolute inset-0 bg-white/20 rounded-2xl blur-xl"></div>
                        <div class="relative flex items-center justify-center w-24 h-24 sm:w-32 sm:h-32 bg-white rounded-2xl shadow-xl overflow-hidden border-4 border-white/30">
                            @if($eleve->photo)
                                <img src="{{ asset('storage/' . $eleve->photo) }}" alt="{{ $eleve->nom_complet }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-4xl font-bold text-indigo-700">{{ substr($eleve->prenom, 0, 1) }}{{ substr($eleve->nom, 0, 1) }}</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="text-center md:text-left text-white">
                        <div class="flex flex-col md:flex-row md:items-baseline gap-2">
                            <h1 class="text-3xl md:text-5xl font-extrabold tracking-tight">{{ $eleve->nom_complet }}</h1>
                            <span class="px-3 py-1 bg-white/20 backdrop-blur-sm rounded-full text-xs font-bold uppercase tracking-widest">{{ $eleve->matricule }}</span>
                        </div>
                        <p class="text-lg text-blue-100 mt-2 font-medium">Visualisation administrateur du parcours complet</p>
                        
                        <div class="flex flex-wrap justify-center md:justify-start gap-4 mt-6">
                            <div class="px-4 py-2 bg-white/10 backdrop-blur-md rounded-xl border border-white/20">
                                <span class="text-xs text-blue-200 block uppercase tracking-wider">Moyenne Globale</span>
                                <span class="text-xl font-bold">{{ $statsParcours['moyenne_globale'] ? number_format($statsParcours['moyenne_globale'], 2) : '--' }}/20</span>
                            </div>
                            <div class="px-4 py-2 bg-white/10 backdrop-blur-md rounded-xl border border-white/20">
                                <span class="text-xs text-blue-200 block uppercase tracking-wider">Années</span>
                                <span class="text-xl font-bold">{{ $statsParcours['nombre_annees'] }}</span>
                            </div>
                            <div class="px-4 py-2 bg-white/10 backdrop-blur-md rounded-xl border border-white/20">
                                <span class="text-xs text-blue-200 block uppercase tracking-wider">Absences</span>
                                <span class="text-xl font-bold text-amber-400">{{ $statsParcours['total_absences'] }}</span>
                            </div>
                            <div class="px-4 py-2 bg-white/10 backdrop-blur-md rounded-xl border border-white/20">
                                <span class="text-xs text-blue-200 block uppercase tracking-wider">Bulletins</span>
                                <span class="text-xl font-bold">{{ $statsParcours['total_bulletins'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Timeline du Parcours -->
        <div class="bg-white shadow-xl rounded-3xl overflow-hidden border border-gray-100">
            <div class="p-6 border-b border-gray-100 bg-gray-50/50 flex items-center justify-between">
                <h3 class="text-xl font-bold text-gray-800 flex items-center">
                    <svg class="w-6 h-6 mr-3 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Timeline de Progression Cycle (Primaire → Collège → Lycée)
                </h3>
                <div class="flex gap-2">
                    <a href="{{ route('admin.eleves.exports.profil-pdf', $eleve) }}" class="inline-flex items-center px-3 py-1 bg-red-600 text-white rounded-lg text-xs font-bold hover:bg-red-700 transition-colors">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path></svg>
                        Exporter Parcours
                    </a>
                </div>
            </div>
            
            <div class="p-8 bg-[radial-gradient(#e5e7eb_1px,transparent_1px)] [background-size:20px_20px]">
                @if($historique->count() > 0)
                    <div class="relative">
                        <!-- Ligne verticale de la timeline -->
                        <div class="absolute left-4 md:left-1/2 transform md:-translate-x-1/2 top-0 bottom-0 w-1 bg-gradient-to-b from-blue-600 via-indigo-600 to-purple-600 rounded-full opacity-20"></div>
                        
                        <div class="space-y-16">
                            @foreach($historique as $index => $item)
                                <div class="relative flex flex-col md:flex-row items-center group">
                                    <!-- Point central avec année -->
                                    <div class="absolute left-4 md:left-1/2 transform -translate-x-1/2 flex items-center justify-center w-12 h-12 rounded-full bg-white border-4 border-indigo-600 shadow-xl z-10 transition-all duration-300 group-hover:scale-110 group-hover:bg-indigo-600 group-hover:text-white">
                                        <span class="text-[10px] font-bold">{{ substr($item['annee_scolaire']->nom, -4) }}</span>
                                    </div>
                                    
                                    <!-- Contenu -->
                                    <div class="ml-16 md:ml-0 md:w-1/2 {{ $index % 2 == 0 ? 'md:pr-20 md:text-right' : 'md:pl-20 md:order-last md:text-left' }}">
                                        <div class="p-8 bg-white border border-gray-100 rounded-3xl shadow-sm hover:shadow-2xl transition-all duration-500 border-t-4 border-t-indigo-600">
                                            <div class="flex items-center {{ $index % 2 == 0 ? 'md:justify-end' : 'md:justify-start' }} mb-4">
                                                <span class="px-4 py-1.5 text-sm font-black text-indigo-700 bg-indigo-50 rounded-full">
                                                    {{ $item['annee_scolaire']->nom }}
                                                </span>
                                            </div>
                                            
                                            <h4 class="text-2xl font-black text-gray-900 leading-tight">{{ $item['classe']->nom }}</h4>
                                            
                                            @php
                                                $niveau = strtolower($item['classe']->niveau ?? '');
                                                $cycle = 'Inconnu';
                                                $cycleColor = 'bg-gray-100 text-gray-600';
                                                
                                                if (str_contains($niveau, 'p') || str_contains($niveau, 'c')) {
                                                    $cycle = 'Primaire';
                                                    $cycleColor = 'bg-green-100 text-green-700';
                                                } elseif (str_contains($niveau, '6') || str_contains($niveau, '5') || str_contains($niveau, '4') || str_contains($niveau, '3')) {
                                                    $cycle = 'Collège';
                                                    $cycleColor = 'bg-blue-100 text-blue-700';
                                                } elseif (str_contains($niveau, 'sec') || str_contains($niveau, 'pre') || str_contains($niveau, 'ter')) {
                                                    $cycle = 'Lycée';
                                                    $cycleColor = 'bg-purple-100 text-purple-700';
                                                }
                                            @endphp
                                            
                                            <div class="flex items-center mt-2 gap-2 {{ $index % 2 == 0 ? 'md:justify-end' : 'md:justify-start' }}">
                                                <span class="text-gray-500 font-bold">{{ $item['classe']->niveau }}</span>
                                                <span class="px-2 py-0.5 text-[10px] font-black uppercase rounded {{ $cycleColor }}">{{ $cycle }}</span>
                                            </div>
                                            
                                            <div class="mt-6 flex flex-wrap gap-2 {{ $index % 2 == 0 ? 'md:justify-end' : 'md:justify-start' }}">
                                                <div class="flex items-center text-xs font-bold text-gray-400">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                    Inscrit le {{ \Carbon\Carbon::parse($item['date_inscription'])->format('d/m/Y') }}
                                                </div>
                                            </div>

                                            <!-- Stats de l'année -->
                                            <div class="mt-6 grid grid-cols-2 gap-4">
                                                <div class="p-3 bg-gray-50 rounded-2xl border border-gray-100 text-center">
                                                    <span class="text-[10px] text-gray-500 block uppercase font-bold tracking-widest">Bulletins</span>
                                                    @php
                                                        $bulletinsAnnee = $eleve->bulletins->where('annee_scolaire_id', $item['annee_scolaire']->id);
                                                    @endphp
                                                    <span class="text-lg font-black text-gray-800">{{ $bulletinsAnnee->count() }}</span>
                                                </div>
                                                <div class="p-3 bg-gray-50 rounded-2xl border border-gray-100 text-center">
                                                    <span class="text-[10px] text-gray-500 block uppercase font-bold tracking-widest">Moy. An</span>
                                                    @php
                                                        $moyenneAnnee = $bulletinsAnnee->avg('moyenne');
                                                    @endphp
                                                    <span class="text-lg font-black {{ $moyenneAnnee >= 10 ? 'text-green-600' : 'text-amber-600' }}">
                                                        {{ $moyenneAnnee ? number_format($moyenneAnnee, 2) : '--' }}
                                                    </span>
                                                </div>
                                            </div>
                                            
                                            @if($item['observation'])
                                                <div class="mt-6 p-4 bg-indigo-50/50 rounded-2xl border border-indigo-100/50 italic text-sm text-indigo-700 relative">
                                                    <svg class="absolute -top-3 -left-1 w-6 h-6 text-indigo-200 fill-current" viewBox="0 0 24 24"><path d="M14.017 21L14.017 18C14.017 16.8954 14.9124 16 16.017 16H19.017C19.5693 16 20.017 15.5523 20.017 15V9C20.017 8.44772 19.5693 8 19.017 8H16.017C14.9124 8 14.017 7.10457 14.017 6V5C14.017 3.89543 14.9124 3 16.017 3H19.017C21.2261 3 23.017 4.79086 23.017 7V15C23.017 18.866 19.883 22 16.017 22H14.017V21ZM1 15V7C1 4.79086 2.79086 3 5 3H8C9.10457 3 10 3.89543 10 5V6C10 7.10457 9.10457 8 8 8H5C4.44772 8 4 8.44772 4 9V15C4 15.5523 4.44772 16 5 16H8C9.10457 16 10 16.8954 10 18V21H8V22C4.13401 22 1 18.866 1 15Z"/></svg>
                                                    "{{ $item['observation'] }}"
                                                </div>
                                            @endif

                                            <!-- Actions Admin pour cette année -->
                                            <div class="mt-8 pt-6 border-t border-gray-100 flex flex-wrap gap-2 {{ $index % 2 == 0 ? 'md:justify-end' : 'md:justify-start' }}">
                                                <a href="{{ route('admin.bulletins.index', ['eleve_id' => $eleve->id, 'annee_scolaire_id' => $item['annee_scolaire']->id]) }}" 
                                                   class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-200">
                                                    Bulletins
                                                </a>
                                                <a href="{{ route('admin.notes.by-eleve', $eleve) }}" 
                                                   class="inline-flex items-center px-4 py-2 bg-white border-2 border-gray-100 text-gray-700 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-gray-50 transition-all">
                                                    Notes
                                                </a>
                                                <a href="{{ route('admin.absences.byEleve', $eleve) }}" 
                                                   class="inline-flex items-center px-4 py-2 bg-white border-2 border-gray-100 text-gray-700 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-gray-50 transition-all">
                                                    Absences
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Espace vide pour l'autre côté sur desktop -->
                                    <div class="hidden md:block md:w-1/2"></div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="text-center py-24">
                        <div class="inline-flex items-center justify-center w-32 h-32 bg-gray-100 rounded-full mb-8">
                            <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h4 class="text-2xl font-black text-gray-800">Historique non disponible</h4>
                        <p class="text-gray-500 mt-2 max-w-md mx-auto">Cet élève n'a pas encore d'historique de scolarité enregistré dans le système.</p>
                        <a href="{{ route('admin.inscriptions.create', ['eleve_id' => $eleve->id]) }}" class="mt-8 inline-flex items-center px-6 py-3 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 transition-all">
                            Inscrire à une classe
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Section Conseils/Statistiques Administratives -->
        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="p-8 bg-gradient-to-br from-indigo-900 to-indigo-800 rounded-3xl text-white shadow-xl">
                <h4 class="text-lg font-black mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    Performance Globale
                </h4>
                <p class="text-blue-100 mb-6">Résumé de la trajectoire académique de l'élève à travers les cycles scolaire.</p>
                <div class="space-y-4">
                    @php
                        $progression = [];
                        foreach($historique->reverse() as $item) {
                             $bulletins = $eleve->bulletins->where('annee_scolaire_id', $item['annee_scolaire']->id);
                             if($bulletins->isNotEmpty()) {
                                 $progression[] = $bulletins->avg('moyenne');
                             }
                        }
                    @endphp
                    <div class="flex justify-between items-end h-24 gap-1">
                        @foreach($progression as $moy)
                            <div class="flex-1 bg-white/20 rounded-t-lg transition-all hover:bg-white/40 cursor-help group relative" style="height: {{ $moy * 5 }}%">
                                <div class="absolute -top-8 left-1/2 -translate-x-1/2 bg-white text-indigo-900 text-[10px] font-black px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity">
                                    {{ number_format($moy, 2) }}
                                </div>
                            </div>
                        @endforeach
                        @if(empty($progression))
                            <div class="w-full h-full flex items-center justify-center text-white/30 italic text-sm">Données insuffisantes</div>
                        @endif
                    </div>
                    <div class="flex justify-between text-[10px] font-bold text-blue-300 uppercase tracking-tighter">
                        <span>Début</span>
                        <span>Progression annuelle</span>
                        <span>Actuel</span>
                    </div>
                </div>
            </div>

            <div class="p-8 bg-white border border-gray-100 rounded-3xl shadow-xl">
                <h4 class="text-lg font-black mb-4 text-gray-800 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    Alerte & Suivi
                </h4>
                <ul class="space-y-4">
                    <li class="flex items-start gap-3">
                        <div class="w-2 h-2 rounded-full mt-2 {{ $eleve->statut ? 'bg-green-500' : 'bg-red-500' }}"></div>
                        <p class="text-sm text-gray-600 font-medium">Statut du dossier : <span class="font-bold {{ $eleve->statut ? 'text-green-600' : 'text-red-600' }}">{{ $eleve->statut ? 'ACTIF' : 'INACTIF' }}</span></p>
                    </li>
                    <li class="flex items-start gap-3">
                        <div class="w-2 h-2 rounded-full mt-2 {{ $statsParcours['total_absences'] > 10 ? 'bg-red-500' : 'bg-green-500' }}"></div>
                        <p class="text-sm text-gray-600 font-medium">Assiduité cumulée : <span class="font-bold">{{ $statsParcours['total_absences'] }} absences au total.</span></p>
                    </li>
                    <li class="flex items-start gap-3">
                        <div class="w-2 h-2 rounded-full mt-2 {{ $eleve->user ? 'bg-green-500' : 'bg-amber-500' }}"></div>
                        <p class="text-sm text-gray-600 font-medium">Accès numérique : <span class="font-bold">{{ $eleve->user ? 'Compte activé' : 'Compte non créé' }}</span></p>
                    </li>
                </ul>
                <div class="mt-8">
                    <a href="{{ route('admin.eleves.edit', $eleve) }}" class="w-full flex items-center justify-center px-4 py-3 bg-gray-50 text-gray-700 font-bold rounded-xl hover:bg-gray-100 transition-all border border-gray-200">
                        Modifier le dossier élève
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes pulse-slow {
        0%, 100% { opacity: 0.2; }
        50% { opacity: 0.3; }
    }
    .animate-pulse {
        animation: pulse-slow 4s ease-in-out infinite;
    }
</style>
@endsection
