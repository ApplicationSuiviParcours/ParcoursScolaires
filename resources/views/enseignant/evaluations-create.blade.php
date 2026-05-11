@extends('layouts.app')
@section('header')
    <h2 class="text-sm font-semibold leading-tight text-gray-800">Créer une évaluation</h2>
@endsection
@section('content')
<div class="py-6 sm:py-12">
    <div class="px-4 mx-auto max-w-3xl sm:px-6 lg:px-8">

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-xl">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-xl">
                <ul class="list-disc list-inside">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif

        <div class="bg-white shadow-lg rounded-2xl overflow-hidden">
            <div class="p-6 bg-gradient-to-r from-green-600 to-emerald-600">
                <h1 class="text-xl font-bold text-white flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Nouvelle évaluation
                </h1>
            </div>
            <div class="p-6">
                <form method="POST" action="{{ route('enseignant.evaluations.store') }}">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nom de l'évaluation *</label>
                            <input type="text" name="nom" value="{{ old('nom') }}" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                placeholder="Ex: Devoir de mathématiques N°1">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Classe *</label>
                            <select name="classe_id" required class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500">
                                <option value="">-- Choisir une classe --</option>
                                @foreach($classes as $classe)
                                    <option value="{{ $classe->id }}" {{ old('classe_id') == $classe->id ? 'selected' : '' }}>
                                        {{ $classe->nom_complet ?? $classe->nom }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Matière *</label>
                            <select name="matiere_id" required class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500">
                                <option value="">-- Choisir une matière --</option>
                                @foreach($matieres as $matiere)
                                    <option value="{{ $matiere->id }}" {{ old('matiere_id') == $matiere->id ? 'selected' : '' }}>
                                        {{ $matiere->nom }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Type *</label>
                            <select name="type" required class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500">
                                <option value="">-- Choisir un type --</option>
                                <option value="devoir" {{ old('type') == 'devoir' ? 'selected' : '' }}>Devoir</option>
                                <option value="examen" {{ old('type') == 'examen' ? 'selected' : '' }}>Examen</option>
                                <option value="interrogation" {{ old('type') == 'interrogation' ? 'selected' : '' }}>Interrogation</option>
                                <option value="projet" {{ old('type') == 'projet' ? 'selected' : '' }}>Projet</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Période *</label>
                            <select name="periode" required class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500">
                                <option value="">-- Choisir une période --</option>
                                <option value="Trimestre 1" {{ old('periode') == 'Trimestre 1' ? 'selected' : '' }}>Trimestre 1</option>
                                <option value="Trimestre 2" {{ old('periode') == 'Trimestre 2' ? 'selected' : '' }}>Trimestre 2</option>
                                <option value="Trimestre 3" {{ old('periode') == 'Trimestre 3' ? 'selected' : '' }}>Trimestre 3</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Année scolaire *</label>
                            <select name="annee_scolaire_id" required class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500">
                                @foreach($anneesScolaires as $annee)
                                    <option value="{{ $annee->id }}" {{ (old('annee_scolaire_id') == $annee->id || ($anneeScolaireActive && $annee->id == $anneeScolaireActive->id)) ? 'selected' : '' }}>
                                        {{ $annee->nom }} {{ $annee->active ? '(Active)' : '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Date d'évaluation *</label>
                            <input type="date" name="date_evaluation" value="{{ old('date_evaluation') }}" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Coefficient *</label>
                            <input type="number" name="coefficient" value="{{ old('coefficient', 1) }}" step="0.5" min="0.5" max="10" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Barème *</label>
                            <input type="number" name="bareme" value="{{ old('bareme', 20) }}" step="0.5" min="0" max="40" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500">
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                            <textarea name="description" rows="3"
                                class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500"
                                placeholder="Description optionnelle de l'évaluation...">{{ old('description') }}</textarea>
                        </div>
                    </div>
                    <div class="flex gap-4 mt-6">
                        <button type="submit" class="flex-1 px-6 py-3 bg-green-600 text-white font-semibold rounded-xl hover:bg-green-700 transition-colors">
                            Créer l'évaluation
                        </button>
                        <a href="{{ route('enseignant.evaluations.index') }}" class="px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition-colors">
                            Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
