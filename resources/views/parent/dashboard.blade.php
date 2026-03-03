@extends('layouts.app')

@section('header')
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
        {{ __('Tableau de bord Parent') }}
    </h2>
@endsection

@section('content')
@php
    // Valeurs par défaut pour éviter les erreurs
    $enfants = $enfants ?? collect([]);
    $stats = $stats ?? [
        'total_enfants' => 0,
        'total_notes' => 0,
        'total_absences' => 0,
        'total_bulletins' => 0,
        'absences_non_justifiees' => 0,
    ];
    $donneesEnfants = $donneesEnfants ?? [];
@endphp

<div class="py-12">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        
        <!-- Welcome Banner -->
        <div class="relative mb-8 overflow-hidden group rounded-2xl">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 animate-gradient-x"></div>
            <div class="absolute inset-0 opacity-20">
                <div class="absolute bg-white rounded-full w-96 h-96 -top-48 -right-48 blur-3xl animate-pulse-slow"></div>
                <div class="absolute bg-yellow-300 rounded-full w-96 h-96 -bottom-48 -left-48 blur-3xl animate-pulse-slow animation-delay-2000"></div>
            </div>
            
            <!-- Particules flottantes -->
            <div class="absolute inset-0">
                @for($i = 0; $i < 12; $i++)
                <div class="absolute w-2 h-2 bg-white rounded-full animate-float-random" 
                     style="left: {{ rand(0, 100) }}%; top: {{ rand(0, 100) }}%; animation-delay: {{ rand(0, 5) }}s; opacity: 0.6;"></div>
                @endfor
            </div>
            
            <div class="relative p-8">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div class="flex items-center space-x-6">
                        <!-- Avatar parent -->
                        <div class="relative group">
                            <div class="flex items-center justify-center w-20 h-20 transition-all duration-300 transform border-2 shadow-2xl bg-white/20 backdrop-blur-sm rounded-2xl border-white/30 group-hover:scale-110">
                                <span class="text-3xl font-bold text-white">
                                    {{ substr(Auth::user()->name ?? 'P', 0, 1) }}
                                </span>
                            </div>
                            <div class="absolute w-4 h-4 bg-green-400 border-2 border-indigo-600 rounded-full -bottom-1 -right-1 animate-pulse"></div>
                        </div>
                        
                        <div class="transition-all duration-700 transform animate-slide-in-left">
                            <h3 class="text-3xl font-bold text-white drop-shadow-lg">
                                Bonjour, {{ Auth::user()->name ?? 'Parent' }} !
                            </h3>
                            <p class="flex items-center mt-2 text-blue-100">
                                <svg class="w-5 h-5 mr-2 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ now()->locale('fr')->isoFormat('dddd D MMMM YYYY') }}
                            </p>
                        </div>
                    </div>
                    
                    <div class="hidden transition-all duration-700 transform md:block animate-slide-in-right hover:rotate-12 hover:scale-110">
                        <div class="p-4 border rounded-full bg-white/20 backdrop-blur-sm border-white/30">
                            <svg class="w-16 h-16 text-white animate-float" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <!-- Alertes absences non justifiées -->
                @if($enfants->count() > 0 && !empty($donneesEnfants))
                    @php
                        $alertes = [];
                        foreach($enfants as $enfant) {
                            if(isset($donneesEnfants[$enfant->id]['absences_non_justifiees']) && 
                               $donneesEnfants[$enfant->id]['absences_non_justifiees'] > 0) {
                                $alertes[] = "{$enfant->prenom} a {$donneesEnfants[$enfant->id]['absences_non_justifiees']} absence(s) non justifiée(s)";
                            }
                        }
                    @endphp
                    
                    @if(count($alertes) > 0)
                    <div class="p-4 mt-4 border border-yellow-400 rounded-xl bg-yellow-500/20 backdrop-blur-sm">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 mr-3 text-yellow-300 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                            <div>
                                @foreach($alertes as $alerte)
                                <p class="text-white">{{ $alerte }}</p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif
                @endif
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-2 lg:grid-cols-4">
            <!-- Enfants -->
            <div class="p-6 transition-all duration-500 bg-white border border-gray-100 shadow-xl rounded-2xl hover:shadow-2xl hover:-translate-y-2">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="flex items-center text-sm font-medium text-gray-500">
                            <span class="w-2 h-2 mr-2 bg-blue-500 rounded-full animate-pulse"></span>
                            Mes Enfants
                        </p>
                        <p class="mt-2 text-4xl font-bold text-gray-900 animate-count">
                            {{ $stats['total_enfants'] }}
                        </p>
                    </div>
                    <div class="p-4 shadow-lg bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl animate-float">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Notes -->
            <div class="p-6 transition-all duration-500 bg-white border border-gray-100 shadow-xl rounded-2xl hover:shadow-2xl hover:-translate-y-2">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="flex items-center text-sm font-medium text-gray-500">
                            <span class="w-2 h-2 mr-2 bg-green-500 rounded-full animate-pulse animation-delay-200"></span>
                            Notes
                        </p>
                        <p class="mt-2 text-4xl font-bold text-gray-900 animate-count">
                            {{ $stats['total_notes'] }}
                        </p>
                    </div>
                    <div class="p-4 shadow-lg bg-gradient-to-br from-green-500 to-green-600 rounded-xl animate-float animation-delay-200">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Absences -->
            <div class="p-6 transition-all duration-500 bg-white border border-gray-100 shadow-xl rounded-2xl hover:shadow-2xl hover:-translate-y-2">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="flex items-center text-sm font-medium text-gray-500">
                            <span class="w-2 h-2 mr-2 bg-red-500 rounded-full animate-pulse animation-delay-400"></span>
                            Absences
                        </p>
                        <p class="mt-2 text-4xl font-bold text-gray-900 animate-count">
                            {{ $stats['total_absences'] }}
                        </p>
                        @if($stats['absences_non_justifiees'] > 0)
                        <p class="text-xs text-red-500">{{ $stats['absences_non_justifiees'] }} non justifiée(s)</p>
                        @endif
                    </div>
                    <div class="p-4 shadow-lg bg-gradient-to-br from-red-500 to-red-600 rounded-xl animate-float animation-delay-400">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Bulletins -->
            <div class="p-6 transition-all duration-500 bg-white border border-gray-100 shadow-xl rounded-2xl hover:shadow-2xl hover:-translate-y-2">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="flex items-center text-sm font-medium text-gray-500">
                            <span class="w-2 h-2 mr-2 bg-purple-500 rounded-full animate-pulse animation-delay-600"></span>
                            Bulletins
                        </p>
                        <p class="mt-2 text-4xl font-bold text-gray-900 animate-count">
                            {{ $stats['total_bulletins'] }}
                        </p>
                    </div>
                    <div class="p-4 shadow-lg bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl animate-float animation-delay-600">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Message si aucun enfant -->
        @if($enfants->count() == 0)
        <div class="p-12 text-center bg-white shadow-xl rounded-2xl">
            <div class="relative inline-block animate-float">
                <div class="absolute inset-0 bg-blue-300 rounded-full opacity-50 blur-xl"></div>
                <svg class="relative text-blue-400 w-28 h-28" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
            <h3 class="mt-6 text-2xl font-semibold text-gray-700">Aucun enfant associé</h3>
            <p class="max-w-md mx-auto mt-2 text-gray-500">
                Vous n'avez pas encore d'enfants liés à votre compte parent. 
                Veuillez contacter l'administration.
            </p>
        </div>
        @else
        <!-- Liste des enfants avec leurs dernières activités -->
        <div class="grid grid-cols-1 gap-6 mt-8 lg:grid-cols-2">
            @foreach($enfants as $enfant)
            @php
                // Récupérer l'inscription active pour obtenir la classe
                $inscriptionActive = $enfant->inscriptions()
                    ->where('statut', true)
                    ->with('classe')
                    ->first();
                $classeNom = $inscriptionActive && $inscriptionActive->classe 
                    ? $inscriptionActive->classe->nom 
                    : 'Classe non assignée';
                
                $enfantDonnees = $donneesEnfants[$enfant->id] ?? [
                    'dernieres_notes' => collect([]),
                    'dernieres_absences' => collect([]),
                    'moyenne_generale' => 0,
                    'dernier_bulletin' => null,
                    'absences_non_justifiees' => 0,
                ];
            @endphp
            <div class="overflow-hidden transition-all duration-500 transform bg-white border border-gray-100 shadow-xl rounded-2xl hover:shadow-2xl hover:-translate-y-2">
                <!-- En-tête enfant -->
                <div class="p-6 bg-gradient-to-r from-blue-600 to-indigo-600">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center justify-center w-16 h-16 text-2xl font-bold text-white bg-white/20 rounded-2xl backdrop-blur-sm">
                                {{ substr($enfant->prenom ?? '', 0, 1) }}{{ substr($enfant->nom ?? '', 0, 1) }}
                            </div>
                            <div>
                                <h4 class="text-xl font-bold text-white">{{ $enfant->prenom ?? '' }} {{ $enfant->nom ?? '' }}</h4>
                                <div class="flex items-center mt-1 text-sm text-blue-100">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                    <span>{{ $classeNom }}</span>
                                    @if(isset($enfant->lien_parental))
                                    <span class="ml-2 px-2 py-0.5 text-xs bg-white/20 rounded-full">{{ $enfant->lien_parental }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('parent.enfant.notes', $enfant->id) }}" class="p-2 text-white transition-colors bg-white/20 rounded-xl hover:bg-white/30">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="p-6">
                    <!-- Mini statistiques -->
                    <div class="grid grid-cols-3 gap-2 p-3 mb-4 bg-gray-50 rounded-xl">
                        <div class="text-center">
                            <p class="text-xs text-gray-500">Moyenne</p>
                            <p class="text-lg font-bold {{ $enfantDonnees['moyenne_generale'] >= 10 ? 'text-green-600' : 'text-red-600' }}">
                                {{ number_format($enfantDonnees['moyenne_generale'], 2) }}
                            </p>
                        </div>
                        <div class="text-center">
                            <p class="text-xs text-gray-500">Notes</p>
                            <p class="text-lg font-bold text-blue-600">
                                {{ $enfantDonnees['dernieres_notes']->count() }}
                            </p>
                        </div>
                        <div class="text-center">
                            <p class="text-xs text-gray-500">Absences</p>
                            <p class="text-lg font-bold text-red-600">
                                {{ $enfantDonnees['dernieres_absences']->count() }}
                            </p>
                        </div>
                    </div>

                    <!-- Dernières notes -->
                    @if($enfantDonnees['dernieres_notes']->count() > 0)
                    <div class="mb-4">
                        <h5 class="flex items-center mb-2 text-sm font-semibold text-gray-700">
                            <svg class="w-4 h-4 mr-1 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Dernières notes
                        </h5>
                        <div class="space-y-2">
                            @foreach($enfantDonnees['dernieres_notes'] as $note)
                            <div class="flex items-center justify-between p-2 text-sm rounded-lg bg-gray-50">
                                <div class="flex items-center">
                                    <span class="inline-block w-2 h-2 mr-2 bg-green-500 rounded-full"></span>
                                    <span class="text-gray-600">{{ $note->evaluation->matiere->nom ?? 'Matière' }}</span>
                                </div>
                                <span class="px-2 py-1 font-bold text-green-700 bg-green-100 rounded-md">{{ $note->note }}/20</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Dernières absences -->
                    @if($enfantDonnees['dernieres_absences']->count() > 0)
                    <div class="mb-4">
                        <h5 class="flex items-center mb-2 text-sm font-semibold text-gray-700">
                            <svg class="w-4 h-4 mr-1 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Dernières absences
                        </h5>
                        <div class="space-y-2">
                            @foreach($enfantDonnees['dernieres_absences'] as $absence)
                            <div class="flex items-center justify-between p-2 text-sm rounded-lg bg-gray-50">
                                <div class="flex items-center">
                                    <span class="inline-block w-2 h-2 mr-2 {{ $absence->justifiee ? 'bg-green-500' : 'bg-red-500' }} rounded-full"></span>
                                    <span class="text-gray-600">{{ \Carbon\Carbon::parse($absence->date_absence)->format('d/m/Y') }}</span>
                                </div>
                                <span class="px-2 py-1 text-xs {{ $absence->justifiee ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }} rounded-full">
                                    {{ $absence->justifiee ? 'Justifiée' : 'Non justifiée' }}
                                </span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Dernier bulletin -->
                    @if($enfantDonnees['dernier_bulletin'])
                    <div class="p-3 mb-4 border border-purple-100 bg-purple-50 rounded-xl">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <span class="text-sm text-gray-600">Dernier bulletin:</span>
                            </div>
                            <span class="text-sm font-medium text-purple-700">{{ $enfantDonnees['dernier_bulletin']->periode }}</span>
                        </div>
                    </div>
                    @endif

                    <!-- Actions rapides -->
                    <div class="flex justify-end mt-4 space-x-2">
                        <a href="{{ route('parent.enfant.notes', $enfant->id) }}" class="p-2 text-green-600 transition-colors bg-green-100 rounded-lg hover:bg-green-200" title="Voir les notes">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </a>
                        <a href="{{ route('parent.enfant.absences', $enfant->id) }}" class="p-2 text-red-600 transition-colors bg-red-100 rounded-lg hover:bg-red-200" title="Voir les absences">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </a>
                        <a href="{{ route('parent.enfant.bulletin', $enfant->id) }}" class="p-2 text-purple-600 transition-colors bg-purple-100 rounded-lg hover:bg-purple-200" title="Voir les bulletins">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </a>
                        <a href="{{ route('parent.enfant.emploi-du-temps', $enfant->id) }}" class="p-2 text-blue-600 transition-colors bg-blue-100 rounded-lg hover:bg-blue-200" title="Voir l'emploi du temps">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </a>
                    </div>
                </div>
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
@keyframes count {
    from { opacity: 0; transform: scale(0.5); }
    to { opacity: 1; transform: scale(1); }
}
@keyframes pulse-slow {
    0%, 100% { opacity: 0.6; }
    50% { opacity: 1; }
}

.animate-gradient-x { background-size: 200% 200%; animation: gradient-x 15s ease infinite; }
.animate-float { animation: float 3s ease-in-out infinite; }
.animate-float-random { animation: float-random 10s ease-in-out infinite; }
.animate-slide-in-left { animation: slide-in-left 0.7s ease-out forwards; }
.animate-slide-in-right { animation: slide-in-right 0.7s ease-out forwards; }
.animate-count { animation: count 0.5s ease-out; }
.animate-pulse-slow { animation: pulse-slow 3s ease-in-out infinite; }

.animation-delay-200 { animation-delay: 200ms; }
.animation-delay-400 { animation-delay: 400ms; }
.animation-delay-600 { animation-delay: 600ms; }
.animation-delay-2000 { animation-delay: 2000ms; }

.hover\:-translate-y-2:hover { transform: translateY(-0.5rem); }
</style>

<!-- Alpine.js -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endsection