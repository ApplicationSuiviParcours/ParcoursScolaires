@extends('layouts.app')
@section('header')
    <h2 class="text-sm font-semibold leading-tight text-gray-800">Calendrier des absences</h2>
@endsection
@section('content')
<div class="py-6 sm:py-12">
    <div class="px-4 mx-auto max-w-6xl sm:px-6 lg:px-8">

        {{-- Navigation mois --}}
        <div class="bg-blue-900 rounded-3xl p-6 mb-8 shadow-2xl">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-white">📅 Calendrier des absences</h1>
                    <p class="text-red-200 mt-1">{{ \Carbon\Carbon::createFromDate($annee, $mois, 1)->translatedFormat('F Y') }}</p>
                </div>
                <div class="flex gap-3">
                    @php
                        $prevDate = \Carbon\Carbon::createFromDate($annee, $mois, 1)->subMonth();
                        $nextDate = \Carbon\Carbon::createFromDate($annee, $mois, 1)->addMonth();
                    @endphp
                    <a href="{{ route('enseignant.absences.calendrier', ['mois' => $prevDate->month, 'annee' => $prevDate->year]) }}"
                        class="px-4 py-2 bg-white/20 text-white rounded-xl hover:bg-white/30 transition-colors">
                        ← Précédent
                    </a>
                    <a href="{{ route('enseignant.absences.calendrier', ['mois' => now()->month, 'annee' => now()->year]) }}"
                        class="px-4 py-2 bg-white text-red-700 font-semibold rounded-xl hover:bg-red-50 transition-colors">
                        Aujourd'hui
                    </a>
                    <a href="{{ route('enseignant.absences.calendrier', ['mois' => $nextDate->month, 'annee' => $nextDate->year]) }}"
                        class="px-4 py-2 bg-white/20 text-white rounded-xl hover:bg-white/30 transition-colors">
                        Suivant →
                    </a>
                </div>
            </div>
        </div>

        {{-- Calendrier --}}
        @php
            $debutMois = \Carbon\Carbon::createFromDate($annee, $mois, 1);
            $finMois = $debutMois->copy()->endOfMonth();
            $premierJour = $debutMois->dayOfWeek === 0 ? 7 : $debutMois->dayOfWeek;
            $joursOuvrables = ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'];
        @endphp

        <div class="bg-white shadow-lg rounded-2xl overflow-hidden mb-6">
            <div class="grid grid-cols-7 bg-gray-50">
                @foreach($joursOuvrables as $jour)
                <div class="p-3 text-center text-xs font-semibold text-gray-500 uppercase border-b border-gray-200">
                    {{ $jour }}
                </div>
                @endforeach
            </div>

            <div class="grid grid-cols-7">
                {{-- Cases vides avant le 1er du mois --}}
                @for($i = 1; $i < $premierJour; $i++)
                <div class="p-2 h-24 bg-gray-50 border-b border-r border-gray-100"></div>
                @endfor

                {{-- Jours du mois --}}
                @for($jour = 1; $jour <= $finMois->day; $jour++)
                @php
                    $date = \Carbon\Carbon::createFromDate($annee, $mois, $jour)->format('Y-m-d');
                    $absencesDuJour = $absences[$date] ?? collect();
                    $isToday = $date === now()->format('Y-m-d');
                @endphp
                <div class="p-2 h-24 border-b border-r border-gray-100 hover:bg-gray-50 transition-colors {{ $isToday ? 'bg-blue-50' : '' }}">
                    <span class="text-sm font-semibold {{ $isToday ? 'bg-blue-600 text-white w-6 h-6 flex items-center justify-center rounded-full' : 'text-gray-700' }}">
                        {{ $jour }}
                    </span>
                    @if($absencesDuJour->count() > 0)
                        <div class="mt-1 space-y-1 overflow-hidden">
                            @foreach($absencesDuJour->take(2) as $absence)
                            <div class="text-xs px-1.5 py-0.5 rounded {{ $absence->justifiee ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }} truncate">
                                {{ $absence->eleve->prenom ?? '?' }}
                            </div>
                            @endforeach
                            @if($absencesDuJour->count() > 2)
                            <div class="text-xs text-gray-500">+{{ $absencesDuJour->count() - 2 }} autres</div>
                            @endif
                        </div>
                    @endif
                </div>
                @endfor
            </div>
        </div>

        {{-- Liste détaillée --}}
        @if($absences->count() > 0)
        <div class="bg-white shadow-lg rounded-2xl overflow-hidden">
            <div class="p-6 bg-blue-900">
                <h3 class="text-lg font-bold text-white">Détail des absences du mois</h3>
            </div>
            <div class="p-6 space-y-4">
                @foreach($absences->sortKeysDesc() as $date => $absencesDuJour)
                <div>
                    <h4 class="text-sm font-semibold text-gray-500 uppercase mb-2">
                        {{ \Carbon\Carbon::parse($date)->translatedFormat('l d F') }}
                    </h4>
                    <div class="space-y-2">
                        @foreach($absencesDuJour as $absence)
                        <div class="flex items-center justify-between p-3 {{ $absence->justifiee ? 'bg-green-50' : 'bg-red-50' }} rounded-xl">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 {{ $absence->justifiee ? 'bg-green-500' : 'bg-red-500' }} rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">{{ $absence->eleve->prenom }} {{ $absence->eleve->nom }}</p>
                                    <p class="text-xs text-gray-500">{{ $absence->matiere->nom ?? 'N/A' }} · {{ $absence->heure_debut ?? '' }} - {{ $absence->heure_fin ?? '' }}</p>
                                </div>
                            </div>
                            <span class="px-3 py-1 text-xs font-semibold {{ $absence->justifiee ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }} rounded-full">
                                {{ $absence->justifiee ? 'Justifiée' : 'Non justifiée' }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @else
        <div class="bg-white shadow-lg rounded-2xl p-12 text-center">
            <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <p class="text-gray-500 text-lg">Aucune absence enregistrée ce mois-ci.</p>
        </div>
        @endif

    </div>
</div>
@endsection
