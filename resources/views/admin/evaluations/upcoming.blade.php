@extends('layouts.app')
@section('header')
    <h2 class="text-sm font-semibold leading-tight text-gray-800">Évaluations à venir</h2>
@endsection
@section('content')
<div class="py-6 sm:py-12">
    <div class="px-4 mx-auto max-w-5xl sm:px-6 lg:px-8">

        <div class="bg-blue-900 rounded-3xl p-6 mb-8 shadow-2xl">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-white">📅 Évaluations à venir</h1>
                    <p class="text-green-200 mt-1">{{ $evaluations->total() }} évaluation(s) planifiée(s)</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('admin.evaluations.past') }}" class="px-4 py-2 bg-white/20 text-white rounded-xl hover:bg-white/30 transition-colors">
                        Évaluations passées →
                    </a>
                    <a href="{{ route('admin.evaluations.index') }}" class="px-4 py-2 bg-white text-green-700 font-semibold rounded-xl hover:bg-green-50 transition-colors">
                        Toutes les évaluations
                    </a>
                </div>
            </div>
        </div>

        <div class="bg-white shadow-lg rounded-2xl overflow-hidden">
            <div class="p-6 overflow-x-auto">
                @if($evaluations->count() > 0)
                <div class="space-y-4">
                    @foreach($evaluations as $evaluation)
                    @php
                        $jours = \Carbon\Carbon::parse($evaluation->date_evaluation)->diffInDays(now());
                        $label = $jours == 0 ? "Aujourd'hui" : ($jours == 1 ? "Demain" : "Dans {$jours} jours");
                        $color = $jours <= 3 ? 'red' : ($jours <= 7 ? 'yellow' : 'green');
                    @endphp
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors gap-4">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 bg-gradient-to-br from-{{ $color }}-500 to-{{ $color }}-600 rounded-xl flex flex-col items-center justify-center text-white text-center shrink-0">
                                <span class="text-xl font-bold leading-none">{{ \Carbon\Carbon::parse($evaluation->date_evaluation)->format('d') }}</span>
                                <span class="text-xs">{{ \Carbon\Carbon::parse($evaluation->date_evaluation)->translatedFormat('M') }}</span>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">{{ $evaluation->nom }}</p>
                                <p class="text-sm text-gray-500">
                                    {{ $evaluation->classe->nom_complet ?? $evaluation->classe->nom ?? 'N/A' }} ·
                                    {{ $evaluation->matiere->nom ?? 'N/A' }} ·
                                    Coeff. {{ $evaluation->coefficient }}
                                </p>
                                <span class="inline-flex items-center px-2 py-0.5 text-xs font-semibold bg-{{ $color }}-100 text-{{ $color }}-800 rounded-full mt-1">
                                    {{ $label }}
                                </span>
                            </div>
                        </div>
                        <a href="{{ route('admin.evaluations.show', $evaluation) }}"
                            class="px-4 py-2 bg-green-600 text-white rounded-xl hover:bg-green-700 transition-colors text-sm shrink-0">
                            Voir →
                        </a>
                    </div>
                    @endforeach
                </div>
                <div class="mt-4">{{ $evaluations->links() }}</div>
                @else
                <div class="text-center py-12 text-gray-500">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    <p class="text-lg">Aucune évaluation planifiée.</p>
                    <a href="{{ route('admin.evaluations.create') }}" class="mt-4 inline-block px-4 py-2 bg-green-600 text-white rounded-xl hover:bg-green-700">
                        Créer une évaluation
                    </a>
                </div>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection
