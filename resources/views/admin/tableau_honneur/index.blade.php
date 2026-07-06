@extends('layouts.app')

@section('title', 'Tableau d’honneur par niveau')

@section('header')
    <div class="relative overflow-hidden bg-blue-900 py-8 md:py-12">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-white rounded-full mix-blend-overlay filter blur-3xl animate-pulse"></div>
            <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-indigo-300 rounded-full mix-blend-overlay filter blur-3xl animate-pulse delay-1000"></div>
        </div>

        <div class="container mx-auto px-4 relative z-10">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div class="text-center md:text-left mb-6 md:mb-0">
                    <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-white mb-2 animate-fade-in-up">
                        Tableau d’honneur par niveau
                    </h1>
                    <p class="text-indigo-200 text-sm md:text-base animate-fade-in-up animation-delay-200">
                        Classement des élèves par rang (période)
                    </p>
                </div>
                <div class="flex justify-center md:justify-end">
                    <a href="{{ route('admin.bulletins.index') }}" class="group relative inline-flex items-center justify-center px-4 py-2.5 md:px-5 bg-white/10 backdrop-blur-lg hover:bg-white/20 text-white font-medium rounded-xl transition-all duration-300 text-sm">
                        <svg class="w-5 h-5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Retour
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container mx-auto px-4 py-6 md:py-10 bg-gray-50">

        <div class="bg-white rounded-2xl md:rounded-3xl shadow-xl overflow-hidden mb-6 md:mb-8">
            <div class="bg-blue-900 px-4 md:px-8 py-4 md:py-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 md:w-14 md:h-14 bg-white/20 backdrop-blur-lg rounded-xl md:rounded-2xl flex items-center justify-center mr-4 md:mr-5 flex-shrink-0">
                        <svg class="w-6 h-6 md:w-7 md:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v12m6-6H6"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl md:text-2xl font-bold text-white mb-1">Sélection</h2>
                        <p class="text-indigo-100 text-xs md:text-sm">Choisissez classe, année scolaire et période</p>
                    </div>
                </div>
            </div>

            <div class="p-4 md:p-8">
                <form method="GET" action="{{ route('admin.tableau_honneur.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6">
                    <div>
                        <label class="block text-xs md:text-sm font-semibold text-gray-700 mb-1 md:mb-2">Classe *</label>
                        <select name="classe_id" class="w-full rounded-xl border-2 border-gray-200 focus:border-blue-900 focus:ring-2 focus:ring-indigo-200 px-4 py-2.5 md:py-3 text-sm" required>
                            <option value="">Sélectionner</option>
                            @foreach($classes as $classe)
                                <option value="{{ $classe->id }}" {{ $classeId == $classe->id ? 'selected' : '' }}>
                                    {{ $classe->nom_complet }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs md:text-sm font-semibold text-gray-700 mb-1 md:mb-2">Année scolaire *</label>
                        <select name="annee_scolaire_id" class="w-full rounded-xl border-2 border-gray-200 focus:border-blue-900 focus:ring-2 focus:ring-indigo-200 px-4 py-2.5 md:py-3 text-sm" required>
                            <option value="">Sélectionner</option>
                            @foreach($anneeScolaires as $annee)
                                <option value="{{ $annee->id }}" {{ $anneeScolaireId == $annee->id ? 'selected' : '' }}>
                                    {{ $annee->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs md:text-sm font-semibold text-gray-700 mb-1 md:mb-2">Période</label>
                        <select name="periode" class="w-full rounded-xl border-2 border-gray-200 focus:border-blue-900 focus:ring-2 focus:ring-indigo-200 px-4 py-2.5 md:py-3 text-sm">
                            @foreach(['Trimestre 1','Trimestre 2','Trimestre 3'] as $p)
                                <option value="{{ $p }}" {{ $periode === $p ? 'selected' : '' }}>{{ $p }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="md:col-span-3">
                        <label class="block text-xs md:text-sm font-semibold text-gray-700 mb-1 md:mb-2">Afficher</label>
                        <div class="flex flex-col md:flex-row md:items-end gap-3">
                            <div class="flex-1">
                                <label class="inline-flex items-center text-sm text-gray-700">
                                    <input type="radio" name="mode" value="all" {{ $top === null || $top === '' ? 'checked' : '' }} class="mr-2" onclick="document.getElementById('top').value=''"/>
                                    L’ensemble du tableau
                                </label>
                                <label class="inline-flex items-center text-sm text-gray-700 mt-2">
                                    <input type="radio" name="mode" value="top" {{ $top !== null && $top !== '' ? 'checked' : '' }} class="mr-2" onclick="document.getElementById('top').value='{{ $top !== null && $top !== '' ? $top : 5 }}'"/>
                                    Top
                                </label>
                            </div>

                            <div class="w-full md:w-48">
                                <input id="top" type="number" min="1" name="top" value="{{ $top !== null && $top !== '' ? $top : '' }}" class="w-full rounded-xl border-2 border-gray-200 focus:border-blue-900 focus:ring-2 focus:ring-indigo-200 px-4 py-2.5 md:py-3 text-sm" placeholder="Ex: 5" {{ $top === null || $top === '' ? 'disabled' : '' }} />
                            </div>

                            <div class="w-full md:w-auto">
                                <button type="submit" class="w-full md:w-auto px-6 py-2.5 md:py-3 bg-blue-900 hover:from-indigo-700 hover:to-violet-700 text-white font-semibold rounded-xl transition-all duration-300 transform hover:scale-105 text-sm">
                                    Afficher
                                </button>
                            </div>

                            <div class="w-full md:w-auto">
                                <a href="{{ route('admin.tableau_honneur.print', request()->query()) }}" target="_blank" class="w-full md:w-auto inline-flex justify-center px-6 py-2.5 md:py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-xl transition-all duration-300 text-sm">
                                    Imprimer
                                </a>
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 mt-2">Le bouton Imprimer génère le document pour la sélection affichée.</p>
                    </div>
                </form>

                <script>
                    document.addEventListener('DOMContentLoaded', () => {
                        const topInput = document.getElementById('top');
                        const radios = document.querySelectorAll('input[name="mode"]');

                        function sync() {
                            const mode = document.querySelector('input[name="mode"]:checked')?.value;
                            if (mode === 'all') {
                                topInput.disabled = true;
                            } else {
                                topInput.disabled = false;
                                if (!topInput.value) topInput.value = 5;
                            }
                        }

                        radios.forEach(r => r.addEventListener('change', sync));
                        sync();
                    });
                </script>
            </div>
        </div>

        @if($classeId && $anneeScolaireId)
            <div class="bg-white rounded-2xl md:rounded-3xl shadow-xl overflow-hidden">
                <div class="px-4 md:px-8 py-4 md:py-5 bg-blue-900">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg md:text-xl font-bold text-white">Résultats</h3>
                            <p class="text-indigo-100 text-xs md:text-sm">Classement par rang - {{ $periode }}</p>
                        </div>
                        <span class="px-3 py-1 bg-white/10 text-white rounded-lg text-xs font-medium">
                            {{ $tableau->count() }} élève(s)
                        </span>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-3 md:px-6 py-3 md:py-4 text-left text-[10px] md:text-xs font-medium text-gray-500 uppercase tracking-wider">Rang</th>
                                <th class="px-3 md:px-6 py-3 md:py-4 text-left text-[10px] md:text-xs font-medium text-gray-500 uppercase tracking-wider">Élève</th>
                                <th class="px-3 md:px-6 py-3 md:py-4 text-left text-[10px] md:text-xs font-medium text-gray-500 uppercase tracking-wider">Moyenne</th>
                                <th class="hidden sm:table-cell px-3 md:px-6 py-3 md:py-4 text-left text-[10px] md:text-xs font-medium text-gray-500 uppercase tracking-wider">Mention</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($tableau as $b)
                                <tr class="hover:bg-indigo-50/50 transition-colors duration-200">
                                    <td class="px-3 md:px-6 py-3 md:py-4 whitespace-nowrap font-semibold text-gray-900">{{ $b->rang ?? '-' }}</td>
                                    <td class="px-3 md:px-6 py-3 md:py-4">
                                        {{ $b->eleve->nom }} {{ $b->eleve->prenom }}
                                        <div class="text-[10px] md:text-xs text-gray-500">{{ $b->eleve->matricule ?? 'N/A' }}</div>
                                    </td>
                                    <td class="px-3 md:px-6 py-3 md:py-4 whitespace-nowrap">
                                        <span class="font-semibold {{ ($b->moyenne_generale ?? 0) >= 10 ? 'text-green-700' : 'text-red-700' }}">{{ number_format($b->moyenne_generale, 2) }}/20</span>
                                    </td>
                                    <td class="hidden sm:table-cell px-3 md:px-6 py-3 md:py-4">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">{{ $b->mention ?? '-' }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-sm text-gray-500">Aucun résultat pour cette sélection.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
@endsection

