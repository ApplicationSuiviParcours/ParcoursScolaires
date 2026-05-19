@extends('layouts.app')
@section('header')
    <h2 class="text-sm font-semibold leading-tight text-gray-800">Saisie rapide — {{ $evaluation->nom }}</h2>
@endsection
@section('content')
<div class="py-6 sm:py-12">
    <div class="px-4 mx-auto max-w-4xl sm:px-6 lg:px-8">

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-xl">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-xl">
                <ul class="list-disc list-inside">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif

        {{-- Info évaluation --}}
        <div class="bg-blue-900 rounded-2xl p-6 mb-6 shadow-lg">
            <h1 class="text-2xl font-bold text-white">⚡ Saisie rapide des notes</h1>
            <p class="text-purple-200 mt-1">{{ $evaluation->nom }} — {{ $evaluation->classe->nom_complet ?? $evaluation->classe->nom }}</p>
            <div class="flex flex-wrap gap-4 mt-3 text-sm">
                <span class="bg-white/20 text-white px-3 py-1 rounded-full">{{ $evaluation->matiere->nom }}</span>
                <span class="bg-white/20 text-white px-3 py-1 rounded-full">Barème : {{ $evaluation->bareme ?? 20 }}</span>
                <span class="bg-white/20 text-white px-3 py-1 rounded-full">Coeff. {{ $evaluation->coefficient }}</span>
                <span class="bg-white/20 text-white px-3 py-1 rounded-full">{{ $evaluation->periode }}</span>
            </div>
        </div>

        <div class="bg-white shadow-lg rounded-2xl overflow-hidden">
            <div class="p-6 bg-blue-900 flex items-center justify-between">
                <h3 class="text-lg font-bold text-white">{{ $eleves->count() }} élève(s)</h3>
                <a href="{{ route('enseignant.evaluations.show', $evaluation->id) }}" class="text-white/80 hover:text-white text-sm">← Retour</a>
            </div>

            <form method="POST" action="{{ route('enseignant.notes.quick.store', $evaluation->id) }}">
                @csrf
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Élève</th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Note (/ {{ $evaluation->bareme ?? 20 }})</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Observation</th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Statut</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($eleves as $eleve)
                            @php $noteExistante = $notesExistantes[$eleve->id] ?? null; @endphp
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 bg-blue-900 rounded-lg flex items-center justify-center text-white text-xs font-bold">
                                            {{ strtoupper(substr($eleve->prenom, 0, 1)) }}{{ strtoupper(substr($eleve->nom, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900">{{ $eleve->prenom }} {{ $eleve->nom }}</p>
                                            <p class="text-xs text-gray-500">{{ $eleve->matricule }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <input type="number"
                                        name="notes[{{ $eleve->id }}]"
                                        value="{{ $noteExistante ? $noteExistante->note : '' }}"
                                        step="0.25" min="0" max="{{ $evaluation->bareme ?? 20 }}"
                                        class="w-24 px-3 py-2 text-center border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                        placeholder="—">
                                </td>
                                <td class="px-4 py-3">
                                    <input type="text"
                                        name="observations[{{ $eleve->id }}]"
                                        value="{{ $noteExistante ? $noteExistante->observation : '' }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent text-sm"
                                        placeholder="Observation...">
                                </td>
                                <td class="px-4 py-3 text-center">
                                    @if($noteExistante)
                                        <span class="inline-flex items-center px-2 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded-full">
                                            ✓ {{ number_format($noteExistante->note, 2) }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-1 text-xs font-semibold bg-gray-100 text-gray-600 rounded-full">
                                            En attente
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-4 py-12 text-center text-gray-500">
                                    Aucun élève trouvé dans cette classe.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($eleves->count() > 0)
                <div class="p-6 bg-gray-50 border-t flex gap-4">
                    <button type="submit" class="flex-1 px-6 py-3 bg-green-600 text-white font-semibold rounded-xl hover:bg-green-700 transition-colors">
                        💾 Enregistrer toutes les notes
                    </button>
                    <a href="{{ route('enseignant.notes.index') }}" class="px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition-colors">
                        Annuler
                    </a>
                </div>
                @endif
            </form>
        </div>

    </div>
</div>
@endsection
