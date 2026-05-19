@extends('layouts.app')
@section('header')
    <h2 class="text-sm font-semibold leading-tight text-gray-800">
        Emploi du temps — {{ $classe->nom_complet ?? $classe->nom }}
    </h2>
@endsection
@section('content')
<div class="py-6 sm:py-12">
    <div class="px-4 mx-auto max-w-6xl sm:px-6 lg:px-8">

        <div class="bg-blue-900 rounded-3xl p-6 mb-8 shadow-2xl">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-white">
                        📅 Emploi du temps — {{ $classe->nom_complet ?? $classe->nom }}
                    </h1>
                    <p class="text-purple-200 mt-1">{{ $emplois->count() }} créneaux configurés</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('admin.emploi-du-temps.create') }}"
                        class="px-4 py-2 bg-white text-blue-900 font-semibold rounded-xl hover:bg-purple-50 transition-colors">
                        + Ajouter un créneau
                    </a>
                    <a href="{{ route('admin.classes.show', $classe) }}"
                        class="px-4 py-2 bg-white/20 text-white rounded-xl hover:bg-white/30 transition-colors">
                        ← Retour
                    </a>
                </div>
            </div>
        </div>

        @if($emplois->count() > 0)
        @php
            $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
            $emploisParJour = $emplois->groupBy('jour_semaine');
        @endphp
        <div class="space-y-6">
            @foreach($jours as $jour)
            @if(isset($emploisParJour[$jour]) && $emploisParJour[$jour]->count() > 0)
            <div class="bg-white shadow-lg rounded-2xl overflow-hidden">
                <div class="px-6 py-4 bg-blue-50 border-b border-indigo-100">
                    <h3 class="font-bold text-indigo-800 text-lg">{{ $jour }}</h3>
                </div>
                <div class="p-4 space-y-3">
                    @foreach($emploisParJour[$jour]->sortBy('heure_debut') as $emploi)
                    <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors">
                        <div class="w-24 text-center shrink-0">
                            <span class="text-sm font-bold text-indigo-800 block">{{ $emploi->heure_debut ?? '--:--' }}</span>
                            <span class="text-xs text-gray-500">{{ $emploi->heure_fin ?? '--:--' }}</span>
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold text-gray-900">{{ $emploi->matiere->nom ?? 'N/A' }}</p>
                            @if($emploi->professeur ?? $emploi->enseignant ?? null)
                            <p class="text-sm text-gray-500">{{ $emploi->enseignant->prenom ?? '' }} {{ $emploi->enseignant->nom ?? '' }}</p>
                            @endif
                        </div>
                        @if($emploi->salle ?? null)
                        <span class="px-3 py-1 bg-blue-100 text-indigo-800 text-sm font-medium rounded-full shrink-0">
                            Salle {{ $emploi->salle }}
                        </span>
                        @endif
                        <div class="flex gap-2 shrink-0">
                            <a href="{{ route('admin.emploi-du-temps.edit', $emploi) }}"
                                class="p-2 text-yellow-600 bg-yellow-100 rounded-lg hover:bg-yellow-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
            @endforeach
        </div>
        @else
        <div class="bg-white shadow-lg rounded-2xl p-12 text-center">
            <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <p class="text-gray-500 text-lg mb-4">Aucun emploi du temps configuré pour cette classe.</p>
            <a href="{{ route('admin.emploi-du-temps.create') }}"
                class="px-6 py-3 bg-blue-900 text-white font-semibold rounded-xl hover:bg-blue-800 transition-colors">
                Créer un créneau
            </a>
        </div>
        @endif

    </div>
</div>
@endsection
