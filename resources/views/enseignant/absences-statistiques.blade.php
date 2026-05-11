@extends('layouts.app')
@section('header')
    <h2 class="text-sm font-semibold leading-tight text-gray-800">Statistiques des absences</h2>
@endsection
@section('content')
<div class="py-6 sm:py-12">
    <div class="px-4 mx-auto max-w-6xl sm:px-6 lg:px-8">

        {{-- En-tête --}}
        <div class="bg-gradient-to-r from-red-600 to-pink-600 rounded-3xl p-8 mb-8 shadow-2xl">
            <h1 class="text-2xl font-bold text-white">📊 Statistiques des absences</h1>
            <p class="text-red-200 mt-1">Vue d'ensemble de l'assiduité de vos élèves</p>
        </div>

        {{-- Statistiques par classe --}}
        @if(!empty($statsParClasse))
        <div class="bg-white shadow-lg rounded-2xl overflow-hidden mb-6">
            <div class="p-6 bg-gradient-to-r from-orange-600 to-red-600">
                <h3 class="text-lg font-bold text-white">Par classe</h3>
            </div>
            <div class="p-6 overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Classe</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Total absences</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Justifiées</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Taux justification</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($statsParClasse as $stat)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 font-medium text-gray-900">{{ $stat['classe']->nom_complet ?? $stat['classe']->nom }}</td>
                            <td class="px-4 py-3 text-center">
                                <span class="inline-flex items-center px-3 py-1 text-sm font-bold bg-red-100 text-red-800 rounded-full">
                                    {{ $stat['total_absences'] }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="inline-flex items-center px-3 py-1 text-sm font-semibold bg-green-100 text-green-800 rounded-full">
                                    {{ $stat['absences_justifiees'] }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <div class="flex items-center gap-2">
                                    <div class="flex-1 h-2 bg-gray-100 rounded-full overflow-hidden">
                                        <div class="h-full bg-green-500 rounded-full" style="width: {{ $stat['taux_justification'] }}%"></div>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700 w-12">{{ $stat['taux_justification'] }}%</span>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        {{-- Top élèves absents --}}
        @if($topElevesAbsents->count() > 0)
        <div class="bg-white shadow-lg rounded-2xl overflow-hidden mb-6">
            <div class="p-6 bg-gradient-to-r from-red-700 to-red-500">
                <h3 class="text-lg font-bold text-white">🔴 Top 5 — Élèves les plus absents</h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @foreach($topElevesAbsents as $index => $item)
                    <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-xl">
                        <div class="w-10 h-10 flex items-center justify-center rounded-full {{ $index === 0 ? 'bg-red-500 text-white' : 'bg-gray-200 text-gray-600' }} font-bold text-lg">
                            {{ $index + 1 }}
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold text-gray-900">{{ $item->eleve->prenom ?? '—' }} {{ $item->eleve->nom ?? '—' }}</p>
                            <p class="text-xs text-gray-500">{{ $item->eleve->matricule ?? '' }}</p>
                        </div>
                        <span class="px-4 py-2 bg-red-100 text-red-800 font-bold rounded-full text-sm">
                            {{ $item->total_absences }} absence(s)
                        </span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        {{-- Statistiques par mois --}}
        @if($statsParMois->count() > 0)
        <div class="bg-white shadow-lg rounded-2xl overflow-hidden">
            <div class="p-6 bg-gradient-to-r from-indigo-600 to-purple-600">
                <h3 class="text-lg font-bold text-white">Par mois (12 derniers mois)</h3>
            </div>
            <div class="p-6 overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Mois</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Total</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Justifiées</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($statsParMois as $stat)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 font-medium text-gray-900">
                                {{ \Carbon\Carbon::createFromDate($stat->annee, $stat->mois, 1)->translatedFormat('F Y') }}
                            </td>
                            <td class="px-4 py-3 text-center font-bold text-red-600">{{ $stat->total }}</td>
                            <td class="px-4 py-3 text-center font-bold text-green-600">{{ $stat->justifiees }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @else
        <div class="bg-white shadow-lg rounded-2xl p-12 text-center">
            <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>
            <p class="text-gray-500 text-lg">Aucune donnée d'absence disponible.</p>
            <a href="{{ route('enseignant.absences.create') }}" class="mt-4 inline-block px-4 py-2 bg-red-600 text-white rounded-xl hover:bg-red-700">
                Enregistrer une absence
            </a>
        </div>
        @endif

    </div>
</div>
@endsection
