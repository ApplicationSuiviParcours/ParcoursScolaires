@extends('layouts.app')

@section('title', 'Emploi du temps par classe')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- En-tête -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 space-y-4 sm:space-y-0 animate__animated animate__fadeInDown">
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.emploi_du_temps.index') }}" class="p-2 bg-white rounded-xl shadow hover:bg-gray-50 transition-colors">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <div class="p-3 bg-gradient-to-r from-green-500 to-emerald-600 rounded-xl shadow-lg flex-shrink-0">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Emploi du temps par classe</h1>
            </div>
            <div class="flex flex-wrap gap-2 w-full sm:w-auto">
                <a href="{{ route('admin.emploi_du_temps.byEnseignant') }}"
                   class="inline-flex items-center px-3 py-2 sm:px-4 sm:py-3 bg-purple-100 text-purple-700 font-medium rounded-xl hover:bg-purple-200 hover:shadow-md transform hover:-translate-y-1 transition-all duration-300 text-sm">
                    Voir par prof
                </a>
            </div>
        </div>

        <!-- Filtres avancés -->
        <div class="mb-8 animate__animated animate__fadeInUp">
            <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl p-4 sm:p-6 border border-white/20">
                <form method="GET" class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        
                        <!-- Classe -->
                        <div class="space-y-2">
                            <label for="classe_id" class="block text-sm font-medium text-gray-700">
                                <span>Sélectionner une classe</span>
                            </label>
                            <select name="classe_id" id="classe_id" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-300" required>
                                <option value="">Choisir une classe</option>
                                @foreach($classes as $classe)
                                    <option value="{{ $classe->id }}" {{ ($classeId ?? '') == $classe->id ? 'selected' : '' }}>
                                        {{ $classe->nom }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Année scolaire -->
                        <div class="space-y-2">
                            <label for="annee_scolaire_id" class="block text-sm font-medium text-gray-700">
                                <span>Année scolaire</span>
                            </label>
                            <select name="annee_scolaire_id" id="annee_scolaire_id" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-300">
                                @foreach($anneeScolaires as $annee)
                                    <option value="{{ $annee->id }}" {{ ($anneeScolaireId ?? '') == $annee->id ? 'selected' : '' }}>
                                        {{ $annee->nom }} {{ $annee->active ? '(En cours)' : '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Boutons filtre -->
                        <div class="flex items-end">
                            <button type="submit"
                                    class="w-full inline-flex items-center justify-center px-5 py-2.5 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-medium rounded-xl hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-300 text-sm">
                                Afficher l'emploi du temps
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Section Grille Emploi du Temps -->
        @if($classeId)
            @if($emplois && $emplois->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 animate__animated animate__fadeInUp">
                    @foreach(range(1, 7) as $jourIndex)
                        @php
                            $joursStr = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
                            $jourFr = $joursStr[$jourIndex - 1];
                            $coursDuJour = $emplois[$jourIndex] ?? collect();
                        @endphp
                        
                        <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl overflow-hidden border border-white/20 transform hover:scale-[1.02] transition-transform duration-300 flex flex-col h-full">
                            <div class="bg-gradient-to-r from-green-500 to-emerald-600 px-4 py-3 flex-shrink-0">
                                <h3 class="text-white font-bold text-center text-lg">{{ $jourFr }}</h3>
                            </div>
                            
                            <div class="p-4 flex-1 space-y-4">
                                @forelse($coursDuJour as $emploi)
                                    <div class="relative pl-4 border-l-2 border-emerald-400 pb-2">
                                        <div class="absolute w-3 h-3 bg-emerald-500 rounded-full -left-[7px] top-1 shadow-sm"></div>
                                        <div class="text-sm font-bold text-gray-800">
                                            {{ \Carbon\Carbon::parse($emploi->heure_debut)->format('H:i') }} - 
                                            {{ \Carbon\Carbon::parse($emploi->heure_fin)->format('H:i') }}
                                        </div>
                                        <div class="mt-1 text-emerald-600 font-semibold">{{ $emploi->matiere->nom ?? '-' }}</div>
                                        <div class="mt-1 text-sm text-gray-600 flex items-center gap-1">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                            <span class="truncate">{{ $emploi->enseignant->nom ?? '-' }} {{ $emploi->enseignant->prenom ?? '' }}</span>
                                        </div>
                                        @if($emploi->salle)
                                            <div class="mt-1 text-sm text-gray-500 flex items-center gap-1">
                                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                                <span>Salle {{ $emploi->salle }}</span>
                                            </div>
                                        @endif
                                        <div class="mt-2 flex gap-2">
                                            <a href="{{ route('admin.emploi_du_temps.edit', $emploi) }}" class="text-xs text-amber-600 hover:text-amber-800">Modifier</a>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-6 text-gray-400 h-full flex flex-col items-center justify-center">
                                        <svg class="w-10 h-10 mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                                        <p class="text-sm">Libre</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl p-12 text-center border border-white/20 animate__animated animate__fadeInUp">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Aucun emploi du temps</h3>
                    <p class="text-gray-500">Aucun cours n'a été programmé pour cette classe dans l'année sélectionnée.</p>
                </div>
            @endif
        @else
            <div class="bg-blue-50/50 rounded-2xl shadow-inner p-12 text-center border border-dashed border-blue-200 animate__animated animate__fadeInUp">
                <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
                <h3 class="text-xl font-medium text-blue-900 mb-2">Sélectionnez une classe</h3>
                <p class="text-blue-600 max-w-md mx-auto">Veuillez choisir une classe dans les filtres ci-dessus pour visualiser son emploi du temps complet.</p>
            </div>
        @endif

    </div>
</div>

@push('styles')
<style>
    @keyframes fadeInDown {
        from { opacity: 0; transform: translateY(-20px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .animate__animated   { animation-duration: 0.6s; animation-fill-mode: both; }
    .animate__fadeInDown { animation-name: fadeInDown; }
    .animate__fadeInUp   { animation-name: fadeInUp; }
</style>
@endpush
@endsection
