@extends('layouts.app')

@section('header')
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
        {{ __('Mon Parcours Scolaire') }}
    </h2>
@endsection

@section('content')
<div class="py-12">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        
        <!-- En-tête du Parcours -->
        <div class="relative mb-8 overflow-hidden bg-white shadow-2xl rounded-3xl group">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 opacity-90"></div>
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
                                <span class="text-4xl font-bold text-indigo-600">{{ substr($eleve->prenom, 0, 1) }}{{ substr($eleve->nom, 0, 1) }}</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="text-center md:text-left text-white">
                        <h1 class="text-3xl md:text-5xl font-extrabold tracking-tight">{{ $eleve->nom_complet }}</h1>
                        <p class="text-lg text-blue-100 mt-2 font-medium">Matricule: <span class="font-bold">{{ $eleve->matricule }}</span></p>
                        
                        <div class="flex flex-wrap justify-center md:justify-start gap-4 mt-6">
                            <div class="px-4 py-2 bg-white/10 backdrop-blur-md rounded-xl border border-white/20">
                                <span class="text-xs text-blue-200 block uppercase tracking-wider">Moyenne Globale</span>
                                <span class="text-xl font-bold">{{ $statsParcours['moyenne_globale'] ? number_format($statsParcours['moyenne_globale'], 2) : '--' }}/20</span>
                            </div>
                            <div class="px-4 py-2 bg-white/10 backdrop-blur-md rounded-xl border border-white/20">
                                <span class="text-xs text-blue-200 block uppercase tracking-wider">Années de parcours</span>
                                <span class="text-xl font-bold">{{ $statsParcours['nombre_annees'] }}</span>
                            </div>
                            <div class="px-4 py-2 bg-white/10 backdrop-blur-md rounded-xl border border-white/20">
                                <span class="text-xs text-blue-200 block uppercase tracking-wider">Bulletins émis</span>
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
                    Historique de scolarité
                </h3>
            </div>
            
            <div class="p-8">
                @if($historique->count() > 0)
                    <div class="relative">
                        <!-- Ligne verticale de la timeline -->
                        <div class="absolute left-4 md:left-1/2 transform md:-translate-x-1/2 top-0 bottom-0 w-1 bg-gradient-to-b from-indigo-500 via-purple-500 to-pink-500 rounded-full opacity-20"></div>
                        
                        <div class="space-y-12">
                            @foreach($historique as $index => $item)
                                <div class="relative flex flex-col md:flex-row items-center group">
                                    <!-- Point central -->
                                    <div class="absolute left-4 md:left-1/2 transform -translate-x-1/2 w-8 h-8 rounded-full bg-white border-4 border-indigo-600 shadow-lg z-10 transition-all duration-300 group-hover:scale-125 group-hover:bg-indigo-600 group-hover:border-white"></div>
                                    
                                    <!-- Contenu -->
                                    <div class="ml-12 md:ml-0 md:w-1/2 {{ $index % 2 == 0 ? 'md:pr-16 md:text-right' : 'md:pl-16 md:order-last md:text-left' }}">
                                        <div class="p-6 bg-white border border-gray-100 rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                                            <span class="inline-block px-3 py-1 text-sm font-bold text-indigo-600 bg-indigo-50 rounded-full mb-3">
                                                {{ $item['annee_scolaire']->nom }}
                                            </span>
                                            <h4 class="text-xl font-bold text-gray-900">{{ $item['classe']->nom }}</h4>
                                            <p class="text-gray-500 mt-1 font-medium">{{ $item['classe']->niveau }}</p>
                                            
                                            <div class="mt-4 flex flex-wrap gap-2 {{ $index % 2 == 0 ? 'md:justify-end' : 'md:justify-start' }}">
                                                <span class="px-3 py-1 bg-gray-100 text-gray-600 text-xs font-semibold rounded-lg">
                                                    Inscrit le {{ \Carbon\Carbon::parse($item['date_inscription'])->format('d/m/Y') }}
                                                </span>
                                                @if($item['statut'])
                                                    <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-lg">
                                                        {{ is_bool($item['statut']) ? ($item['statut'] ? 'Actif' : 'Inactif') : $item['statut'] }}
                                                    </span>
                                                @endif
                                            </div>
                                            
                                            @if($item['observation'])
                                                <div class="mt-4 p-3 bg-blue-50/50 rounded-xl border border-blue-100/50 italic text-sm text-gray-600">
                                                    "{{ $item['observation'] }}"
                                                </div>
                                            @endif

                                            <!-- Actions pour cette année -->
                                            <div class="mt-6 pt-4 border-t border-gray-100 grid grid-cols-3 gap-2">
                                                <a href="{{ route('eleve.bulletin', ['annee_scolaire_id' => $item['annee_scolaire']->id]) }}" 
                                                   class="flex flex-col items-center p-2 rounded-xl bg-purple-50 text-purple-700 hover:bg-purple-100 transition-colors group/link">
                                                    <svg class="w-5 h-5 mb-1 group-hover/link:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                    </svg>
                                                    <span class="text-[10px] font-bold uppercase tracking-wider">Bulletins</span>
                                                </a>
                                                <a href="{{ route('eleve.notes', ['annee_scolaire_id' => $item['annee_scolaire']->id]) }}" 
                                                   class="flex flex-col items-center p-2 rounded-xl bg-green-50 text-green-700 hover:bg-green-100 transition-colors group/link">
                                                    <svg class="w-5 h-5 mb-1 group-hover/link:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                                    </svg>
                                                    <span class="text-[10px] font-bold uppercase tracking-wider">Notes</span>
                                                </a>
                                                <a href="{{ route('eleve.absences', ['annee_scolaire_id' => $item['annee_scolaire']->id]) }}" 
                                                   class="flex flex-col items-center p-2 rounded-xl bg-red-50 text-red-700 hover:bg-red-100 transition-colors group/link">
                                                    <svg class="w-5 h-5 mb-1 group-hover/link:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    <span class="text-[10px] font-bold uppercase tracking-wider">Absences</span>
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
                    <div class="text-center py-20">
                        <div class="inline-flex items-center justify-center w-24 h-24 bg-gray-100 rounded-full mb-6">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h4 class="text-xl font-bold text-gray-800">Aucun historique trouvé</h4>
                        <p class="text-gray-500 mt-2">Votre parcours scolaire commencera à s'afficher ici dès que vos inscriptions seront validées.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Footer d'encouragement -->
        <div class="mt-8 p-6 bg-gradient-to-r from-indigo-50 to-purple-50 rounded-2xl border border-indigo-100 text-center">
            <p class="text-indigo-800 font-medium">
                <span class="text-2xl mr-2">🚀</span> Chaque année est une nouvelle étape vers votre succès. Continuez vos efforts !
            </p>
        </div>
    </div>
</div>

<style>
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }
    .animate-float {
        animation: float 3s ease-in-out infinite;
    }
</style>
@endsection
