@extends('layouts.app')
@section('header')
    <h2 class="text-sm font-semibold leading-tight text-gray-800">
        Notes — {{ $eleve->prenom }} {{ $eleve->nom }}
    </h2>
@endsection
@section('content')
<div class="py-6 sm:py-12">
    <div class="px-4 mx-auto max-w-5xl sm:px-6 lg:px-8">

        {{-- En-tête élève --}}
        <div class="bg-blue-900 rounded-3xl p-6 mb-8 shadow-2xl">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center text-3xl font-bold text-white">
                        {{ strtoupper(substr($eleve->prenom, 0, 1)) }}{{ strtoupper(substr($eleve->nom, 0, 1)) }}
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-white">📝 Notes de {{ $eleve->prenom }} {{ $eleve->nom }}</h1>
                        <p class="text-blue-200 mt-1">{{ $eleve->matricule ?? 'N/A' }}</p>
                    </div>
                </div>
                <a href="{{ route('admin.eleves.show', $eleve) }}"
                    class="px-4 py-2 bg-white/20 text-white rounded-xl hover:bg-white/30 transition-colors self-start sm:self-center">
                    ← Retour à la fiche
                </a>
            </div>
        </div>

        {{-- Filtres --}}
        <form method="GET" class="bg-white shadow-lg rounded-2xl p-6 mb-6">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Année scolaire</label>
                    <select name="annee_scolaire_id" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500">
                        <option value="">Toutes les années</option>
                        @foreach($anneeScolaires as $annee)
                        <option value="{{ $annee->id }}" {{ $anneeScolaireId == $annee->id ? 'selected' : '' }}>
                            {{ $annee->nom }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Période</label>
                    <select name="periode" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500">
                        <option value="">Toutes les périodes</option>
                        @foreach($periodes as $p)
                        <option value="{{ $p }}" {{ $periode == $p ? 'selected' : '' }}>{{ $p }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Matière</label>
                    <select name="matiere_id" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500">
                        <option value="">Toutes les matières</option>
                        @foreach($matieres as $matiere)
                        <option value="{{ $matiere->id }}" {{ $matiereId == $matiere->id ? 'selected' : '' }}>{{ $matiere->nom }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mt-4 flex gap-3">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-colors">
                    Filtrer
                </button>
                <a href="{{ route('admin.notes.by-eleve', $eleve) }}" class="px-6 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-colors">
                    Réinitialiser
                </a>
            </div>
        </form>

        {{-- Statistiques --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4 mb-6">
            <div class="bg-white shadow-lg rounded-2xl p-4 text-center">
                <p class="text-xs text-gray-500 uppercase font-semibold">Notes</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">{{ $stats['total_notes'] }}</p>
            </div>
            <div class="bg-white shadow-lg rounded-2xl p-4 text-center">
                <p class="text-xs text-gray-500 uppercase font-semibold">Moyenne</p>
                <p class="text-2xl font-bold {{ $stats['moyenne_generale'] >= 10 ? 'text-green-600' : 'text-red-600' }} mt-1">
                    {{ number_format($stats['moyenne_generale'], 2) }}
                </p>
            </div>
            <div class="bg-white shadow-lg rounded-2xl p-4 text-center">
                <p class="text-xs text-gray-500 uppercase font-semibold">Max</p>
                <p class="text-2xl font-bold text-green-600 mt-1">{{ number_format($stats['note_max'], 1) }}</p>
            </div>
            <div class="bg-white shadow-lg rounded-2xl p-4 text-center">
                <p class="text-xs text-gray-500 uppercase font-semibold">Min</p>
                <p class="text-2xl font-bold text-red-600 mt-1">{{ number_format($stats['note_min'], 1) }}</p>
            </div>
            <div class="bg-white shadow-lg rounded-2xl p-4 text-center">
                <p class="text-xs text-gray-500 uppercase font-semibold">Réussites</p>
                <p class="text-2xl font-bold text-green-600 mt-1">{{ $stats['reussites'] }}</p>
            </div>
            <div class="bg-white shadow-lg rounded-2xl p-4 text-center">
                <p class="text-xs text-gray-500 uppercase font-semibold">Échecs</p>
                <p class="text-2xl font-bold text-red-600 mt-1">{{ $stats['echecs'] }}</p>
            </div>
        </div>

        {{-- Notes par matière --}}
        @if($notes->count() > 0)
            @foreach($notes as $matiere => $notesMatiere)
            <div class="bg-white shadow-lg rounded-2xl overflow-hidden mb-6">
                <div class="p-4 bg-blue-900">
                    <h3 class="font-bold text-white">{{ $matiere }}</h3>
                    <p class="text-blue-200 text-sm">
                        Moyenne : {{ number_format($notesMatiere->avg('note'), 2) }}/20 ·
                        {{ $notesMatiere->count() }} note(s)
                    </p>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Évaluation</th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Note</th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Coeff.</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Observation</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($notesMatiere->sortByDesc('evaluation.date_evaluation') as $note)
                            @php $n = $note->note; $c = $n >= 16 ? 'green' : ($n >= 10 ? 'blue' : 'red'); @endphp
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3">
                                    <p class="font-medium text-gray-900">{{ $note->evaluation->nom ?? 'N/A' }}</p>
                                    <p class="text-xs text-gray-500">
                                        {{ $note->evaluation->date_evaluation ? \Carbon\Carbon::parse($note->evaluation->date_evaluation)->format('d/m/Y') : 'N/A' }}
                                        · {{ $note->evaluation->type ?? '' }} · {{ $note->evaluation->periode ?? '' }}
                                    </p>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span class="inline-flex items-center px-3 py-1 text-sm font-bold bg-{{ $c }}-100 text-{{ $c }}-800 rounded-full">
                                        {{ number_format($n, 2) }}/20
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-center text-gray-600">{{ $note->evaluation->coefficient ?? 1 }}</td>
                                <td class="px-4 py-3 text-sm text-gray-500">{{ $note->observation ?? '—' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endforeach
        @else
        <div class="bg-white shadow-lg rounded-2xl p-12 text-center">
            <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            <p class="text-gray-500 text-lg">Aucune note trouvée pour les filtres sélectionnés.</p>
        </div>
        @endif

    </div>
</div>
@endsection
