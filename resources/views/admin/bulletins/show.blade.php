@extends('layouts.app')

@section('title', 'Détails du bulletin')

@section('header')
<div class="relative overflow-hidden bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 py-12">
    <!-- Éléments décoratifs animés -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-white rounded-full mix-blend-overlay filter blur-3xl animate-pulse"></div>
        <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-indigo-300 rounded-full mix-blend-overlay filter blur-3xl animate-pulse delay-1000"></div>
    </div>

    <!-- Particules flottantes -->
    <div class="absolute inset-0 overflow-hidden">
        @for($i = 1; $i <= 4; $i++)
            <div class="absolute w-1 h-1 bg-white rounded-full opacity-30 animate-float-{{ $i }}"
                 style="left: {{ rand(0, 100) }}%; top: {{ rand(0, 100) }}%; animation-delay: {{ rand(0, 5) }}s;"></div>
        @endfor
    </div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div class="text-center md:text-left">
                <nav class="flex mb-4" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ route('admin.bulletins.index') }}" class="inline-flex items-center text-sm font-medium text-blue-200 hover:text-white transition-colors duration-300">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                                Bulletins
                            </a>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-blue-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="ml-1 text-sm font-medium text-white md:ml-2">
                                    {{ $bulletin->eleve->nom }} {{ $bulletin->eleve->prenom }} - {{ $bulletin->periode }}
                                </span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-3xl md:text-4xl font-bold text-white mb-2 animate-fade-in-up">
                    Bulletin de {{ $bulletin->eleve->prenom }} {{ $bulletin->eleve->nom }}
                </h1>
                <p class="text-blue-200 text-base md:text-lg animate-fade-in-up animation-delay-200">
                    {{ $bulletin->classe->nom }} • {{ $bulletin->periode }} • {{ $bulletin->anneeScolaire->nom }}
                </p>
            </div>
            <div class="mt-6 md:mt-0 flex justify-center md:justify-end space-x-3 animate-fade-in-right">
                <a href="{{ route('admin.bulletins.edit', $bulletin) }}"
                   class="group relative inline-flex items-center px-5 py-2.5 bg-yellow-500 hover:bg-yellow-600 text-white font-medium rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-xl overflow-hidden">
                    <span class="absolute inset-0 bg-white opacity-0 group-hover:opacity-20 transition-opacity duration-300"></span>
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Modifier
                </a>
                <a href="{{ route('admin.bulletins.print', $bulletin) }}"
                   class="group relative inline-flex items-center px-5 py-2.5 bg-green-500 hover:bg-green-600 text-white font-medium rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-xl overflow-hidden"
                   target="_blank">
                    <span class="absolute inset-0 bg-white opacity-0 group-hover:opacity-20 transition-opacity duration-300"></span>
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                    </svg>
                    Imprimer
                </a>
                <a href="{{ route('admin.bulletins.index') }}"
                   class="group relative inline-flex items-center px-5 py-2.5 bg-white/10 backdrop-blur-lg hover:bg-white/20 text-white font-medium rounded-xl transition-all duration-300 transform hover:scale-105 border border-white/20">
                    <svg class="w-5 h-5 mr-2 transform group-hover:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Retour à la liste
                </a>
            </div>
        </div>
    </div>

    <!-- Vague décorative -->
    <div class="absolute bottom-0 left-0 right-0">
        <svg class="fill-current text-gray-50" viewBox="0 0 1440 120">
            <path d="M0,64L80,69.3C160,75,320,85,480,80C640,75,800,53,960,48C1120,43,1280,53,1360,58.7L1440,64L1440,120L1360,120C1280,120,1120,120,960,120C800,120,640,120,480,120C320,120,160,120,80,120L0,120Z"></path>
        </svg>
    </div>
</div>
@endsection

@section('content')
<div class="container mx-auto px-4 py-10 bg-gray-50">
    <!-- Informations principales -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        <!-- Carte Élève -->
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden">
            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 px-6 py-4">
                <h3 class="text-lg font-semibold text-white">Élève</h3>
            </div>
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 h-16 w-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center text-white font-bold text-2xl shadow-lg">
                        {{ strtoupper(substr($bulletin->eleve->prenom, 0, 1)) }}{{ strtoupper(substr($bulletin->eleve->nom, 0, 1)) }}
                    </div>
                    <div class="ml-4">
                        <h2 class="text-xl font-bold text-gray-800">{{ $bulletin->eleve->nom }} {{ $bulletin->eleve->prenom }}</h2>
                        <p class="text-sm text-gray-600">Matricule: {{ $bulletin->eleve->matricule ?? 'N/A' }}</p>
                        <p class="text-sm text-gray-600">Né(e) le: {{ $bulletin->eleve->date_naissance?->format('d/m/Y') ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Carte Classe & Année -->
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden">
            <div class="bg-gradient-to-r from-green-500 to-emerald-600 px-6 py-4">
                <h3 class="text-lg font-semibold text-white">Classe & Année</h3>
            </div>
            <div class="p-6">
                <div class="space-y-3">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"></path>
                        </svg>
                        <div>
                            <p class="text-xs text-gray-500">Classe</p>
                            <p class="font-medium text-gray-800">{{ $bulletin->classe->nom }}</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <div>
                            <p class="text-xs text-gray-500">Année scolaire</p>
                            <p class="font-medium text-gray-800">{{ $bulletin->anneeScolaire->nom }}</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <div>
                            <p class="text-xs text-gray-500">Période</p>
                            <p class="font-medium text-gray-800">{{ $bulletin->periode }}</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <div>
                            <p class="text-xs text-gray-500">Date du bulletin</p>
                            <p class="font-medium text-gray-800">{{ $bulletin->date_bulletin ?->format('d/m/Y') ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Carte Résultats -->
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden">
            <div class="bg-gradient-to-r from-purple-500 to-pink-600 px-6 py-4">
                <h3 class="text-lg font-semibold text-white">Résultats</h3>
            </div>
            <div class="p-6">
                <div class="text-center mb-4">
                    <span class="text-sm text-gray-500">Moyenne générale</span>
                    <div class="text-5xl font-bold {{ $stats['moyenne'] >= 10 ? 'text-green-600' : 'text-red-600' }}">
                        {{ number_format($stats['moyenne'], 2) }}
                        <span class="text-2xl text-gray-400">/20</span>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4 mt-4">
                    <div class="bg-gray-50 rounded-xl p-3 text-center">
                        <p class="text-xs text-gray-500">Rang</p>
                        <p class="text-xl font-bold text-gray-800">
                            {{ $stats['rang'] ?? '-' }}/{{ $stats['effectif'] }}
                        </p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-3 text-center">
                        <p class="text-xs text-gray-500">Mention</p>
                        <p class="text-sm font-bold {{ $stats['moyenne'] >= 10 ? 'text-green-600' : 'text-red-600' }}">
                            {{ $stats['mention'] }}
                        </p>
                    </div>
                </div>
                @if($stats['est_admis'])
                    <div class="mt-4 bg-green-100 text-green-700 rounded-xl p-3 text-center font-medium">
                        ✅ Admis(e)
                    </div>
                @else
                    <div class="mt-4 bg-red-100 text-red-700 rounded-xl p-3 text-center font-medium">
                        ❌ Non admis(e)
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Tableau des notes par matière -->
    <div class="bg-white rounded-3xl shadow-xl overflow-hidden mb-8">
        <div class="bg-gradient-to-r from-gray-800 to-gray-900 px-8 py-5">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-white/10 backdrop-blur-lg rounded-xl flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-white">Détail des notes par matière</h2>
                </div>
                <span class="px-4 py-2 bg-white/10 backdrop-blur-lg text-white rounded-xl text-sm font-medium">
                    {{ count($notesParMatiere) }} matière(s)
                </span>
            </div>
        </div>

        <div class="p-6">
            @if(count($notesParMatiere) > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Matière</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Notes</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Moyenne</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Coefficient</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($notesParMatiere as $matiereId => $data)
                                @php
                                    // Vérifier le format des données
                                    $matiereNom = isset($data['matiere_nom']) ? $data['matiere_nom'] :
                                                 (isset($data['matiere']) && is_object($data['matiere']) ? $data['matiere']->nom :
                                                 (isset($data['matiere']) && is_array($data['matiere']) ? ($data['matiere']['nom'] ?? 'Matière inconnue') : 'Matière inconnue'));

                                    $matiereCode = isset($data['matiere_code']) ? $data['matiere_code'] :
                                                  (isset($data['matiere']) && is_object($data['matiere']) ? ($data['matiere']->code ?? '') :
                                                  (isset($data['matiere']) && is_array($data['matiere']) ? ($data['matiere']['code'] ?? '') : ''));

                                    $notes = isset($data['notes']) ? $data['notes'] : [];
                                    $moyenne = isset($data['moyenne']) ? $data['moyenne'] :
                                              (isset($data['moyenne_ponderee']) ? $data['moyenne_ponderee'] : 0);
                                    $coefficient = isset($data['coefficient_total']) ? $data['coefficient_total'] :
                                                   (isset($data['coefficient']) ? $data['coefficient'] : 1);
                                @endphp
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $matiereNom }}
                                        </div>
                                        @if($matiereCode)
                                            <div class="text-xs text-gray-500">{{ $matiereCode }}</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="space-y-2">
                                            @forelse($notes as $note)
                                                @php
                                                    $noteValue = is_object($note) ? ($note->note ?? $note->valeur ?? 0) :
                                                                (is_array($note) ? ($note['note'] ?? $note['valeur'] ?? 0) : 0);
                                                    $evaluation = is_object($note) ? ($note->evaluation ?? null) : (is_array($note) ? ($note['evaluation'] ?? null) : null);
                                                    $evalType = $evaluation ? ($evaluation->type ?? 'Évaluation') : 'Évaluation';
                                                    $evalNom = $evaluation ? ($evaluation->nom ?? '') : '';
                                                    $evalDate = $evaluation ? ($evaluation->date_evaluation ?? null) : null;
                                                    $evalCoeff = $evaluation ? ($evaluation->coefficient ?? 1) : 1;
                                                @endphp
                                                <div class="flex items-center justify-between bg-gray-50 rounded-lg px-3 py-2">
                                                    <div class="flex items-center gap-2">
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $noteValue >= 10 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                            {{ number_format($noteValue, 2) }}/20
                                                        </span>
                                                        <span class="text-xs text-gray-500">
                                                            ({{ $evalType }})
                                                        </span>
                                                    </div>
                                                    <div class="text-xs text-gray-400">
                                                        @if($evalNom)
                                                            <span class="mr-2">{{ $evalNom }}</span>
                                                        @endif
                                                        @if($evalDate)
                                                            <span>{{ $evalDate->format('d/m') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            @empty
                                                <span class="text-gray-400 text-sm">Aucune note</span>
                                            @endforelse
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-lg font-bold {{ $moyenne >= 10 ? 'text-green-600' : 'text-red-600' }}">
                                            {{ number_format($moyenne, 2) }}
                                        </span>
                                        <span class="text-xs text-gray-500">/20</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                            x{{ $coefficient }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <p class="text-gray-500">Aucune note disponible pour ce bulletin</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Appréciation -->
    @if($bulletin->appreciation)
    <div class="bg-white rounded-3xl shadow-xl overflow-hidden mb-8">
        <div class="bg-gradient-to-r from-amber-500 to-orange-600 px-8 py-5">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-white/20 backdrop-blur-lg rounded-xl flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-white">Appréciation</h2>
            </div>
        </div>
        <div class="p-8">
            <p class="text-gray-700 text-lg leading-relaxed">{{ $bulletin->appreciation }}</p>
        </div>
    </div>
    @endif

    <!-- Informations système -->
    <div class="bg-white rounded-3xl shadow-xl overflow-hidden">
        <div class="bg-gradient-to-r from-gray-800 to-gray-900 px-6 py-4">
            <h3 class="text-lg font-semibold text-white">Informations système</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="text-gray-500">Créé le</span>
                    <p class="font-medium text-gray-800">{{ $bulletin->created_at ?->format('d/m/Y à H:i') ?? 'N/A' }}</p>
                </div>
                <div>
                    <span class="text-gray-500">Dernière mise à jour</span>
                    <p class="font-medium text-gray-800">{{ $bulletin->updated_at ?->format('d/m/Y à H:i') ?? 'N/A' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    @keyframes float-1 {
        0%, 100% { transform: translate(0, 0); }
        50% { transform: translate(10px, -10px); }
    }

    @keyframes float-2 {
        0%, 100% { transform: translate(0, 0); }
        50% { transform: translate(-15px, 5px); }
    }

    @keyframes float-3 {
        0%, 100% { transform: translate(0, 0) scale(1); }
        50% { transform: translate(8px, 8px) scale(1.1); }
    }

    @keyframes float-4 {
        0%, 100% { transform: translate(0, 0); }
        50% { transform: translate(-12px, -8px); }
    }

    .animate-float-1 { animation: float-1 8s ease-in-out infinite; }
    .animate-float-2 { animation: float-2 10s ease-in-out infinite; }
    .animate-float-3 { animation: float-3 12s ease-in-out infinite; }
    .animate-float-4 { animation: float-4 9s ease-in-out infinite; }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInRight {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .animate-fade-in-up {
        animation: fadeInUp 0.8s ease-out forwards;
    }

    .animate-fade-in-right {
        animation: fadeInRight 0.8s ease-out forwards;
    }

    .animation-delay-200 {
        animation-delay: 200ms;
        opacity: 0;
    }
</style>
@endpush
