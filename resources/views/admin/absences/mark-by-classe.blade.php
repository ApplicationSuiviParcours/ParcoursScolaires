@extends('layouts.app')

@section('title', 'Présences - saisie rapide')

@section('header')
    <div class="relative overflow-hidden bg-blue-900 py-8 md:py-12">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-white rounded-full mix-blend-overlay filter blur-3xl animate-pulse"></div>
            <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-red-300 rounded-full mix-blend-overlay filter blur-3xl animate-pulse delay-1000"></div>
        </div>

        <div class="container mx-auto px-4 relative z-10">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div class="text-center md:text-left mb-6 md:mb-0">
                    <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-white mb-2 animate-fade-in-up">
                        Saisie rapide des présences
                    </h1>
                    <p class="text-red-100 text-sm md:text-base animate-fade-in-up animation-delay-200">
                        Cochez les élèves absents, puis enregistrez
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
<div class="container mx-auto px-4 py-6 md:py-10 bg-gray-50">

    @if(session('success'))
        <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-3 md:p-4 rounded-lg shadow-md" role="alert">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-3 md:p-4 rounded-lg shadow-md" role="alert">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl md:rounded-3xl shadow-xl overflow-hidden mb-6 md:mb-8">
        <div class="bg-blue-900 px-4 md:px-8 py-4 md:py-6">
            <h2 class="text-xl md:text-2xl font-bold text-white">Paramètres</h2>
        </div>

        <div class="p-4 md:p-8">
            <form method="GET" action="{{ route('admin.presences_rapides.create') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4 md:gap-6">
                <div>
                    <label class="block text-xs md:text-sm font-semibold text-gray-700 mb-1 md:mb-2">Classe *</label>
                    <select name="classe_id" class="w-full rounded-xl border-2 border-gray-200 px-4 py-2.5 md:py-3 text-sm" required>
                        <option value="">Sélectionner</option>
                        @foreach($classes as $c)
                            <option value="{{ $c->id }}" {{ $classeId == $c->id ? 'selected' : '' }}>{{ $c->nom_complet }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs md:text-sm font-semibold text-gray-700 mb-1 md:mb-2">Année scolaire *</label>
                    <select name="annee_scolaire_id" class="w-full rounded-xl border-2 border-gray-200 px-4 py-2.5 md:py-3 text-sm" required>
                        <option value="">Sélectionner</option>
                        @foreach($anneeScolaires as $a)
                            <option value="{{ $a->id }}" {{ $anneeScolaireId == $a->id ? 'selected' : '' }}>{{ $a->nom }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs md:text-sm font-semibold text-gray-700 mb-1 md:mb-2">Date *</label>
                    <input type="date" name="date" value="{{ $date }}" class="w-full rounded-xl border-2 border-gray-200 px-4 py-2.5 md:py-3 text-sm" required/>
                </div>

                <div>
                    <label class="block text-xs md:text-sm font-semibold text-gray-700 mb-1 md:mb-2">Matière *</label>
                    <select name="matiere_id" class="w-full rounded-xl border-2 border-gray-200 px-4 py-2.5 md:py-3 text-sm" required>
                        <option value="">Sélectionner</option>
                        @foreach($matieres as $m)
                            <option value="{{ $m->id }}" {{ $matiereId == $m->id ? 'selected' : '' }}>{{ $m->nom }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-4">
                    <label class="block text-xs md:text-sm font-semibold text-gray-700 mb-2">Enseignant (optionnel)</label>
                    <select name="enseignant_id" class="w-full rounded-xl border-2 border-gray-200 px-4 py-2.5 md:py-3 text-sm">
                        <option value="">Non précisé</option>
                        @foreach($enseignants as $e)
                            <option value="{{ $e->id }}" {{ $enseignantId == $e->id ? 'selected' : '' }}>{{ $e->nom_complet ?? ($e->nom.' '.$e->prenom) }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-4 flex flex-col md:flex-row gap-3 items-end">
                    <button type="submit" class="flex-1 px-6 py-2.5 md:py-3 bg-blue-900 hover:from-indigo-700 hover:to-violet-700 text-white font-semibold rounded-xl transition-all duration-300 text-sm">
                        Charger la liste
                    </button>
                    @if($classeId && $anneeScolaireId && $matiereId)
                        <a href="{{ route('admin.presences_rapides.print', request()->query()) }}" target="_blank" class="flex-1 px-6 py-2.5 md:py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-xl transition-all duration-300 text-sm text-center">
                            Imprimer la liste des présences
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    @if($classeId && $anneeScolaireId && $matiereId)
        <div class="bg-white rounded-2xl md:rounded-3xl shadow-xl overflow-hidden">
            <div class="px-4 md:px-8 py-4 md:py-5 bg-blue-900">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg md:text-xl font-bold text-white">Liste des élèves</h3>
                        <p class="text-indigo-100 text-xs md:text-sm">Cochez les absents</p>
                    </div>
                    <span class="px-3 py-1 bg-white/10 text-white rounded-lg text-xs font-medium">{{ $eleves->count() }} élève(s)</span>
                </div>
            </div>

            <div class="p-4 md:p-8">
                <form method="POST" action="{{ route('admin.presences_rapides.store') }}">
                    @csrf

                    <input type="hidden" name="classe_id" value="{{ $classeId }}" />
                    <input type="hidden" name="annee_scolaire_id" value="{{ $anneeScolaireId }}" />
                    <input type="hidden" name="date" value="{{ $date }}" />
                    <input type="hidden" name="matiere_id" value="{{ $matiereId }}" />
                    @if($enseignantId)
                        <input type="hidden" name="enseignant_id" value="{{ $enseignantId }}" />
                    @endif

                    <div class="mb-4 flex flex-col md:flex-row gap-4 md:items-center md:justify-between">
                        <label class="inline-flex items-center text-sm text-gray-700">
                            <input type="checkbox" name="justifiee" value="1" {{ request('justifiee') ? 'checked' : '' }} class="mr-2" />
                            Marquer les absences comme justifiées
                        </label>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-3 md:px-6 py-3 md:py-4 text-left text-xs font-semibold text-gray-600">Élève</th>
                                    <th class="px-3 md:px-6 py-3 md:py-4 text-center text-xs font-semibold text-gray-600">Absent</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($eleves as $eleve)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-3 md:px-6 py-3 md:py-4">
                                            {{ $eleve->nom }} {{ $eleve->prenom }}
                                            <div class="text-[10px] md:text-xs text-gray-500">{{ $eleve->matricule ?? 'N/A' }}</div>
                                        </td>
                                        <td class="px-3 md:px-6 py-3 md:py-4 text-center">
                                            @php $checked = $absentsExistants->contains($eleve->id); @endphp
                                            <input type="checkbox" name="eleve_ids_absents[]" value="{{ $eleve->id }}" {{ $checked ? 'checked' : '' }} class="w-5 h-5" />
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="px-6 py-12 text-center text-sm text-gray-500">Aucun élève trouvé.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6 flex flex-col md:flex-row gap-3 md:items-center md:justify-between">
                        <div class="text-xs text-gray-500">
                            Remarque : cette saisie enregistre uniquement les élèves cochés (absents). Les élèves non cochés sont considérés présents.
                        </div>
                        <div class="flex gap-3">
                            @if($classeId && $anneeScolaireId && $matiereId)
                                <a href="{{ route('admin.presences_rapides.print', request()->query()) }}" target="_blank" class="px-6 py-2.5 md:py-3 bg-white border-2 border-gray-300 text-gray-700 font-semibold rounded-xl transition-all duration-300 text-sm text-center">
                                    Imprimer
                                </a>
                            @endif
                            <button type="submit" class="px-6 py-2.5 md:py-3 bg-blue-900 hover:from-indigo-700 hover:to-violet-700 text-white font-semibold rounded-xl transition-all duration-300 text-sm">
                                Enregistrer
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
@endsection

