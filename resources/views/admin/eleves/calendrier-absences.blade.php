@extends('layouts.app')
@section('header')
    <h2 class="text-sm font-semibold leading-tight text-gray-800">Calendrier des absences — {{ $eleve->prenom }} {{ $eleve->nom }}</h2>
@endsection
@section('content')
<div class="py-6 sm:py-12">
    <div class="px-4 mx-auto max-w-5xl sm:px-6 lg:px-8">

        {{-- Navigation --}}
        <div class="bg-gradient-to-r from-red-600 to-pink-600 rounded-3xl p-6 mb-8 shadow-2xl">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-white">📅 Calendrier des absences</h1>
                    <p class="text-red-200 mt-1">{{ $eleve->prenom }} {{ $eleve->nom }} — {{ \Carbon\Carbon::createFromDate($annee, $mois, 1)->translatedFormat('F Y') }}</p>
                </div>
                <div class="flex gap-3">
                    @php
                        $prevDate = \Carbon\Carbon::createFromDate($annee, $mois, 1)->subMonth();
                        $nextDate = \Carbon\Carbon::createFromDate($annee, $mois, 1)->addMonth();
                    @endphp
                    <a href="{{ route('admin.eleves.calendrier-absences', ['eleve' => $eleve->id, 'mois' => $prevDate->month, 'annee' => $prevDate->year]) }}"
                        class="px-4 py-2 bg-white/20 text-white rounded-xl hover:bg-white/30">← Précédent</a>
                    <a href="{{ route('admin.eleves.calendrier-absences', ['eleve' => $eleve->id, 'mois' => now()->month, 'annee' => now()->year]) }}"
                        class="px-4 py-2 bg-white text-red-700 font-semibold rounded-xl hover:bg-red-50">Ce mois</a>
                    <a href="{{ route('admin.eleves.calendrier-absences', ['eleve' => $eleve->id, 'mois' => $nextDate->month, 'annee' => $nextDate->year]) }}"
                        class="px-4 py-2 bg-white/20 text-white rounded-xl hover:bg-white/30">Suivant →</a>
                </div>
            </div>
        </div>

        {{-- Bouton retour --}}
        <div class="mb-6">
            <a href="{{ route('admin.eleves.show', $eleve) }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-900">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Retour à la fiche de l'élève
            </a>
        </div>

        {{-- Calendrier --}}
        @php
            $debutMois = \Carbon\Carbon::createFromDate($annee, $mois, 1);
            $finMois = $debutMois->copy()->endOfMonth();
            $premierJour = $debutMois->dayOfWeek === 0 ? 7 : $debutMois->dayOfWeek;
            $joursOuvrables = ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'];
            // Grouper les absences par date
            $absencesParDate = $absences->groupBy(function($a) { return \Carbon\Carbon::parse($a->date_absence)->format('Y-m-d'); });
        @endphp

        <div class="bg-white shadow-lg rounded-2xl overflow-hidden mb-6">
            <div class="grid grid-cols-7 bg-gray-50">
                @foreach($joursOuvrables as $jour)
                <div class="p-3 text-center text-xs font-semibold text-gray-500 uppercase border-b border-gray-200">{{ $jour }}</div>
                @endforeach
            </div>
            <div class="grid grid-cols-7">
                @for($i = 1; $i < $premierJour; $i++)
                <div class="p-2 h-20 bg-gray-50 border-b border-r border-gray-100"></div>
                @endfor

                @for($jour = 1; $jour <= $finMois->day; $jour++)
                @php
                    $date = \Carbon\Carbon::createFromDate($annee, $mois, $jour)->format('Y-m-d');
                    $abs = $absencesParDate[$date] ?? collect();
                    $isToday = $date === now()->format('Y-m-d');
                @endphp
                <div class="p-2 h-20 border-b border-r border-gray-100 {{ $isToday ? 'bg-blue-50' : '' }} {{ $abs->count() > 0 ? 'bg-red-50' : '' }}">
                    <span class="text-sm font-semibold {{ $isToday ? 'bg-blue-600 text-white w-6 h-6 flex items-center justify-center rounded-full' : 'text-gray-700' }}">
                        {{ $jour }}
                    </span>
                    @if($abs->count() > 0)
                        @foreach($abs->take(2) as $a)
                        <div class="text-xs mt-1 px-1.5 py-0.5 rounded {{ $a->justifiee ? 'bg-green-100 text-green-700' : 'bg-red-200 text-red-700' }} truncate">
                            {{ $a->matiere->nom ?? 'Absence' }}
                        </div>
                        @endforeach
                    @endif
                </div>
                @endfor
            </div>
        </div>

        {{-- Liste des absences du mois --}}
        <div class="bg-white shadow-lg rounded-2xl overflow-hidden">
            <div class="p-6 bg-gradient-to-r from-red-600 to-pink-600">
                <h3 class="text-lg font-bold text-white">{{ $absences->count() }} absence(s) ce mois</h3>
            </div>
            <div class="p-6">
                @if($absences->count() > 0)
                <div class="space-y-3">
                    @foreach($absences->sortByDesc('date_absence') as $absence)
                    <div class="flex items-center justify-between p-4 {{ $absence->justifiee ? 'bg-green-50' : 'bg-red-50' }} rounded-xl">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 {{ $absence->justifiee ? 'bg-green-500' : 'bg-red-500' }} rounded-xl flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">{{ $absence->matiere->nom ?? 'Matière non précisée' }}</p>
                                <p class="text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($absence->date_absence)->translatedFormat('d F Y') }}
                                    @if($absence->heure_debut) · {{ $absence->heure_debut }} - {{ $absence->heure_fin }} @endif
                                </p>
                                @if($absence->motif)
                                <p class="text-xs text-gray-400 mt-1">Motif : {{ $absence->motif }}</p>
                                @endif
                            </div>
                        </div>
                        <span class="px-3 py-1 text-xs font-semibold {{ $absence->justifiee ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }} rounded-full">
                            {{ $absence->justifiee ? 'Justifiée' : 'Non justifiée' }}
                        </span>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-8 text-gray-500">
                    <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p>Aucune absence enregistrée ce mois-ci.</p>
                </div>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection
