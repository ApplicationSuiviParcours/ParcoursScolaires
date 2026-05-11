@extends('layouts.app')
@section('header')
    <h2 class="text-sm font-semibold leading-tight text-gray-800">Export PDF — Relevé de notes</h2>
@endsection
@section('content')
<div class="py-6 sm:py-12">
    <div class="px-4 mx-auto max-w-4xl sm:px-6 lg:px-8">
        <div class="bg-white shadow-lg rounded-2xl overflow-hidden">
            <div class="p-6 bg-gradient-to-r from-blue-600 to-indigo-600 flex items-center justify-between">
                <div>
                    <h1 class="text-xl font-bold text-white">Relevé de notes — {{ $eleve->prenom }} {{ $eleve->nom }}</h1>
                    <p class="text-blue-200 mt-1">{{ $stats['periode'] ?? 'Toutes périodes' }}</p>
                </div>
                <a href="{{ route('admin.eleves.show', $eleve) }}" class="text-white/80 hover:text-white text-sm">← Retour</a>
            </div>
            <div class="p-6">
                @if($notes->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Matière</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Évaluation</th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Note</th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Coeff.</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Observation</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($notes as $note)
                            @php $n = $note->note; $color = $n >= 16 ? 'green' : ($n >= 14 ? 'blue' : ($n >= 10 ? 'yellow' : 'red')); @endphp
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 font-medium text-gray-900">{{ $note->evaluation->matiere->nom ?? 'N/A' }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ $note->evaluation->nom ?? 'N/A' }}</td>
                                <td class="px-4 py-3 text-center">
                                    <span class="inline-flex items-center px-3 py-1 text-sm font-bold bg-{{ $color }}-100 text-{{ $color }}-800 rounded-full">
                                        {{ number_format($n, 2) }}/20
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-center text-gray-600">{{ $note->evaluation->coefficient ?? 1 }}</td>
                                <td class="px-4 py-3 text-sm text-gray-500">{{ $note->observation ?? '—' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-50">
                            <tr>
                                <td colspan="2" class="px-4 py-3 font-bold text-gray-900">Moyenne générale</td>
                                <td class="px-4 py-3 text-center font-bold text-lg {{ ($stats['moyenne'] ?? 0) >= 10 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ number_format($stats['moyenne'] ?? 0, 2) }}/20
                                </td>
                                <td colspan="2" class="px-4 py-3 text-sm text-gray-500">{{ $stats['total_notes'] ?? 0 }} note(s)</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="mt-6 flex gap-4">
                    <a href="{{ route('admin.eleves.releve-notes-pdf', ['eleve' => $eleve->id, 'periode' => $stats['periode'] ?? '']) }}"
                        class="px-6 py-3 bg-red-600 text-white font-semibold rounded-xl hover:bg-red-700 transition-colors flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        Télécharger PDF
                    </a>
                </div>
                @else
                <div class="text-center py-12 text-gray-500">
                    <p>Aucune note disponible pour cette période.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
