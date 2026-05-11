@extends('layouts.app')
@section('header')
    <h2 class="text-sm font-semibold leading-tight text-gray-800">Mon emploi du temps</h2>
@endsection
@section('content')
<div class="py-6 sm:py-12">
    <div class="px-4 mx-auto max-w-6xl sm:px-6 lg:px-8">

        <div class="bg-gradient-to-r from-purple-600 to-indigo-600 rounded-3xl p-8 mb-8 shadow-2xl">
            <h1 class="text-2xl font-bold text-white">📅 Mon emploi du temps</h1>
            <p class="text-purple-200 mt-1">Semaine du {{ now()->startOfWeek()->format('d/m') }} au {{ now()->endOfWeek()->format('d/m/Y') }}</p>
        </div>

        <div class="bg-white shadow-lg rounded-2xl overflow-hidden">
            <div class="p-6 overflow-x-auto">
                @if(isset($emplois) && $emplois->count() > 0)
                @php
                    $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
                    $emploisParJour = $emplois->groupBy('jour');
                @endphp
                <div class="space-y-6">
                    @foreach($jours as $jour)
                    @if(isset($emploisParJour[$jour]))
                    <div>
                        <h3 class="text-base font-bold text-indigo-700 mb-3 pb-2 border-b border-indigo-100">{{ $jour }}</h3>
                        <div class="space-y-2">
                            @foreach($emploisParJour[$jour]->sortBy('heure_debut') as $emploi)
                            <div class="flex items-center gap-4 p-4 bg-indigo-50 rounded-xl hover:bg-indigo-100 transition-colors">
                                <div class="w-20 text-center">
                                    <span class="text-sm font-bold text-indigo-800">{{ $emploi->heure_debut ?? '--:--' }}</span>
                                    <p class="text-xs text-indigo-500">{{ $emploi->heure_fin ?? '--:--' }}</p>
                                </div>
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-900">{{ $emploi->matiere->nom ?? 'N/A' }}</p>
                                    <p class="text-sm text-gray-500">{{ $emploi->classe->nom_complet ?? $emploi->classe->nom ?? 'N/A' }}</p>
                                </div>
                                @if($emploi->salle)
                                <span class="px-3 py-1 bg-indigo-200 text-indigo-800 text-sm rounded-full font-medium">
                                    Salle {{ $emploi->salle }}
                                </span>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>
                @else
                <div class="text-center py-12">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <p class="text-gray-500 text-lg">Aucun emploi du temps disponible.</p>
                    <p class="text-gray-400 text-sm mt-2">Contactez l'administrateur pour configurer votre emploi du temps.</p>
                </div>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection
