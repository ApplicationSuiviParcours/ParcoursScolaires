@extends('layouts.app')
@section('header')
    <h2 class="text-sm font-semibold leading-tight text-gray-800">Statistiques — {{ $evaluation->nom }}</h2>
@endsection
@section('content')
<div class="py-6 sm:py-12">
    <div class="px-4 mx-auto max-w-5xl sm:px-6 lg:px-8">

        {{-- En-tête --}}
        <div class="relative overflow-hidden mb-8 bg-gradient-to-r from-purple-600 to-indigo-600 rounded-3xl shadow-2xl">
            <div class="p-8">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h1 class="text-2xl font-bold text-white">{{ $evaluation->nom }}</h1>
                        <p class="text-purple-200 mt-1">{{ $evaluation->classe->nom_complet ?? $evaluation->classe->nom }} — {{ $evaluation->matiere->nom }}</p>
                        <p class="text-purple-200 text-sm">{{ $evaluation->date_evaluation ? \Carbon\Carbon::parse($evaluation->date_evaluation)->format('d/m/Y') : 'N/A' }} · Coeff. {{ $evaluation->coefficient }}</p>
                    </div>
                    <a href="{{ route('enseignant.evaluations.show', $evaluation->id) }}" class="inline-flex items-center px-4 py-2 bg-white/20 text-white rounded-xl hover:bg-white/30 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Retour
                    </a>
                </div>
            </div>
        </div>

        {{-- Cards statistiques --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 mb-8">
            <div class="bg-white shadow-lg rounded-2xl p-5 text-center">
                <p class="text-xs text-gray-500 uppercase tracking-wide font-semibold">Élèves</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['total_eleves'] }}</p>
            </div>
            <div class="bg-white shadow-lg rounded-2xl p-5 text-center">
                <p class="text-xs text-gray-500 uppercase tracking-wide font-semibold">Notes saisies</p>
                <p class="text-3xl font-bold text-blue-600 mt-1">{{ $stats['notes_saisies'] }}</p>
            </div>
            <div class="bg-white shadow-lg rounded-2xl p-5 text-center">
                <p class="text-xs text-gray-500 uppercase tracking-wide font-semibold">Moyenne</p>
                <p class="text-3xl font-bold {{ ($stats['moyenne'] ?? 0) >= 10 ? 'text-green-600' : 'text-red-600' }} mt-1">
                    {{ number_format($stats['moyenne'] ?? 0, 2) }}/20
                </p>
            </div>
            <div class="bg-white shadow-lg rounded-2xl p-5 text-center">
                <p class="text-xs text-gray-500 uppercase tracking-wide font-semibold">Min / Max</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($stats['note_min'] ?? 0, 1) }} / {{ number_format($stats['note_max'] ?? 0, 1) }}</p>
            </div>
            <div class="bg-white shadow-lg rounded-2xl p-5 text-center">
                <p class="text-xs text-gray-500 uppercase tracking-wide font-semibold">Taux réussite</p>
                <p class="text-3xl font-bold {{ ($stats['taux_reussite'] ?? 0) >= 50 ? 'text-green-600' : 'text-red-600' }} mt-1">
                    {{ number_format($stats['taux_reussite'] ?? 0, 1) }}%
                </p>
            </div>
        </div>

        {{-- Distribution des notes --}}
        <div class="bg-white shadow-lg rounded-2xl overflow-hidden mb-6">
            <div class="p-6 bg-gradient-to-r from-indigo-600 to-purple-600">
                <h3 class="text-lg font-bold text-white">Distribution des notes</h3>
            </div>
            <div class="p-6">
                @php
                    $distribution = $stats['distribution'];
                    $total = max(array_sum($distribution), 1);
                    $tranches = [
                        ['label' => 'Très bien (≥16)', 'count' => $distribution['tres_bien'], 'color' => 'green'],
                        ['label' => 'Bien (14-15)', 'count' => $distribution['bien'], 'color' => 'blue'],
                        ['label' => 'Assez bien (12-13)', 'count' => $distribution['assez_bien'], 'color' => 'cyan'],
                        ['label' => 'Passable (10-11)', 'count' => $distribution['passable'], 'color' => 'yellow'],
                        ['label' => 'Insuffisant (<10)', 'count' => $distribution['insuffisant'], 'color' => 'red'],
                    ];
                @endphp
                <div class="space-y-4">
                    @foreach($tranches as $tranche)
                    @php $pct = round(($tranche['count'] / $total) * 100); @endphp
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="font-medium text-gray-700">{{ $tranche['label'] }}</span>
                            <span class="text-gray-500">{{ $tranche['count'] }} élève(s) ({{ $pct }}%)</span>
                        </div>
                        <div class="w-full h-4 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full bg-{{ $tranche['color'] }}-500 rounded-full transition-all duration-500" style="width: {{ $pct }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Notes des élèves --}}
        <div class="bg-white shadow-lg rounded-2xl overflow-hidden">
            <div class="p-6 bg-gradient-to-r from-green-600 to-emerald-600">
                <h3 class="text-lg font-bold text-white">Notes par élève</h3>
            </div>
            <div class="p-6 overflow-x-auto">
                @if($evaluation->notes->count() > 0)
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Élève</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Note</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Appréciation</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($evaluation->notes->sortByDesc('note') as $note)
                        @php
                            $n = $note->note;
                            $color = $n >= 16 ? 'green' : ($n >= 14 ? 'blue' : ($n >= 10 ? 'yellow' : 'red'));
                            $mention = $n >= 16 ? 'Très bien' : ($n >= 14 ? 'Bien' : ($n >= 12 ? 'Assez bien' : ($n >= 10 ? 'Passable' : 'Insuffisant')));
                        @endphp
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 font-medium text-gray-900">{{ $note->eleve->nom_complet ?? ($note->eleve->prenom . ' ' . $note->eleve->nom) }}</td>
                            <td class="px-4 py-3 text-center">
                                <span class="inline-flex items-center px-3 py-1 text-sm font-bold bg-{{ $color }}-100 text-{{ $color }}-800 rounded-full">
                                    {{ number_format($n, 2) }}/20
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center text-sm text-gray-600">{{ $mention }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="text-center py-12 text-gray-500">
                    <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    <p>Aucune note saisie pour cette évaluation.</p>
                    <a href="{{ route('enseignant.notes.create') }}" class="mt-4 inline-block px-4 py-2 bg-green-600 text-white rounded-xl hover:bg-green-700">
                        Saisir les notes
                    </a>
                </div>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection
