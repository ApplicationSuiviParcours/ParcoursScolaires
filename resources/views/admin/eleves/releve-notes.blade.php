@extends('layouts.app')

@section('header')
    <div class="flex items-center justify-between">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Relevé de notes - ') }} {{ $eleve->nom_complet }}
        </h2>
        <a href="{{ route('admin.eleves.show', $eleve) }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition ease-in-out duration-150">
            Retour
        </a>
    </div>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                
                <!-- Filtre de période -->
                <div class="mb-6">
                    <form method="GET" action="{{ route('admin.eleves.releve-notes', $eleve) }}" class="flex items-center gap-4">
                        <label for="periode" class="text-sm font-medium text-gray-700">Sélectionner la période :</label>
                        <select name="periode" id="periode" onchange="this.form.submit()" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="Trimestre 1" {{ $periode == 'Trimestre 1' ? 'selected' : '' }}>Trimestre 1</option>
                            <option value="Trimestre 2" {{ $periode == 'Trimestre 2' ? 'selected' : '' }}>Trimestre 2</option>
                            <option value="Trimestre 3" {{ $periode == 'Trimestre 3' ? 'selected' : '' }}>Trimestre 3</option>
                        </select>
                    </form>
                </div>

                <div class="mb-6 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">{{ $periode }}</h3>
                        <p class="text-sm text-gray-500">Moyenne de la période : <span class="font-bold text-indigo-600">{{ $moyenne ? number_format($moyenne, 2) : '--' }}/20</span></p>
                    </div>
                    <a href="{{ route('admin.eleves.releve-notes-pdf', ['eleve' => $eleve->id, 'periode' => $periode]) }}" class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-md text-xs font-bold uppercase tracking-widest hover:bg-red-700 transition-colors">
                        Télécharger PDF
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Matière</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Évaluation</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Note</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Coeff.</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Appréciation</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($notes as $note)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ \Carbon\Carbon::parse($note->evaluation->date_evaluation)->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $note->evaluation->matiere->nom }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500">{{ $note->evaluation->nom }}</div>
                                        <div class="text-[10px] text-gray-400 uppercase tracking-widest">{{ $note->evaluation->type }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-sm font-bold rounded {{ $note->note >= 10 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ number_format($note->note, 2) }}/20
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $note->evaluation->coefficient }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $note->appreciation ?? '-' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                                        Aucune note trouvée pour cette période.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
