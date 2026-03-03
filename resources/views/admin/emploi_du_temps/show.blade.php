@extends('layouts.app')

@section('title', 'Détails du cours')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 space-y-4 sm:space-y-0 animate__animated animate__fadeInDown">
            <div class="flex items-center space-x-3">
                <div class="p-3 bg-gradient-to-r from-blue-600 to-purple-600 rounded-xl shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-800">Détails du cours</h1>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.emploi_du_temps.edit', $emploiDuTemps) }}" 
                   class="inline-flex items-center px-4 py-3 bg-yellow-100 text-yellow-700 font-medium rounded-xl hover:bg-yellow-200 hover:shadow-md transform hover:-translate-y-1 transition-all duration-300">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Modifier
                </a>
                <a href="{{ route('admin.emploi_du_temps.index') }}" 
                   class="inline-flex items-center px-6 py-3 bg-gray-100 text-gray-700 font-medium rounded-xl hover:bg-gray-200 hover:shadow-md transform hover:-translate-y-1 transition-all duration-300">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Retour à la liste
                </a>
            </div>
        </div>

        <!-- Message de succès -->
        @if(session('success'))
            <div class="mb-6 animate__animated animate__fadeInDown">
                <div class="flex items-center p-4 bg-green-100 border-l-4 border-green-500 rounded-lg shadow-md">
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-700">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Carte principale -->
        <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl overflow-hidden border border-white/20 animate__animated animate__fadeInUp">
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-4">
                <h2 class="text-xl font-semibold text-white flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Informations du cours #{{ $emploiDuTemps->id }}
                </h2>
            </div>
            
            <div class="p-6">
                <!-- En-tête avec badge de statut -->
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <p class="text-sm text-gray-500">Cours de</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $emploiDuTemps->matiere->nom ?? 'Matière non définie' }}</p>
                    </div>
                    @php
                        $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
                        $jourIndex = is_numeric($emploiDuTemps->jour) ? (int)$emploiDuTemps->jour : 1;
                        $jourFr = $jours[$jourIndex - 1] ?? 'Jour ' . $emploiDuTemps->jour;
                    @endphp
                    <span class="px-4 py-2 bg-green-100 text-green-700 rounded-full text-sm font-semibold">
                        {{ $jourFr }}
                    </span>
                </div>

                <!-- Grille d'informations -->
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Classe -->
                    <div class="bg-gray-50 rounded-xl p-4">
                        <dt class="text-sm font-medium text-gray-500 mb-1 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            Classe
                        </dt>
                        <dd class="text-lg font-semibold text-gray-900">{{ $emploiDuTemps->classe->nom ?? 'Non définie' }}</dd>
                    </div>

                    <!-- Matière -->
                    <div class="bg-gray-50 rounded-xl p-4">
                        <dt class="text-sm font-medium text-gray-500 mb-1 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            Matière
                        </dt>
                        <dd class="text-lg font-semibold text-gray-900">{{ $emploiDuTemps->matiere->nom ?? 'Non définie' }}</dd>
                        @if($emploiDuTemps->matiere && $emploiDuTemps->matiere->code)
                            <dd class="text-sm text-gray-500">Code: {{ $emploiDuTemps->matiere->code }}</dd>
                        @endif
                    </div>

                    <!-- Enseignant -->
                    <div class="bg-gray-50 rounded-xl p-4">
                        <dt class="text-sm font-medium text-gray-500 mb-1 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Enseignant
                        </dt>
                        @if($emploiDuTemps->enseignant)
                            <dd class="text-lg font-semibold text-gray-900">
                                {{ $emploiDuTemps->enseignant->nom }} {{ $emploiDuTemps->enseignant->prenom }}
                            </dd>
                            <dd class="text-sm text-gray-500">{{ $emploiDuTemps->enseignant->email ?? '' }}</dd>
                        @else
                            <dd class="text-lg font-semibold text-gray-900">Non assigné</dd>
                        @endif
                    </div>

                    <!-- Année scolaire -->
                    <div class="bg-gray-50 rounded-xl p-4">
                        <dt class="text-sm font-medium text-gray-500 mb-1 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Année scolaire
                        </dt>
                        <dd class="text-lg font-semibold text-gray-900">{{ $emploiDuTemps->anneeScolaire->nom ?? 'Non définie' }}</dd>
                        @if($emploiDuTemps->anneeScolaire && $emploiDuTemps->anneeScolaire->active)
                            <dd class="text-sm text-green-600">Année en cours</dd>
                        @endif
                    </div>

                    <!-- Horaires -->
                    <div class="bg-gray-50 rounded-xl p-4 md:col-span-2">
                        <dt class="text-sm font-medium text-gray-500 mb-2 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Horaires
                        </dt>
                        <dd class="flex items-center space-x-4">
                            <div class="flex items-center">
                                <span class="text-2xl font-bold text-gray-900">
                                    {{ \Carbon\Carbon::parse($emploiDuTemps->heure_debut)->format('H:i') }}
                                </span>
                                <span class="mx-2 text-gray-400">-</span>
                                <span class="text-2xl font-bold text-gray-900">
                                    {{ \Carbon\Carbon::parse($emploiDuTemps->heure_fin)->format('H:i') }}
                                </span>
                            </div>
                            @php
                                $debut = \Carbon\Carbon::parse($emploiDuTemps->heure_debut);
                                $fin = \Carbon\Carbon::parse($emploiDuTemps->heure_fin);
                                $duree = $debut->diffInHours($fin) . 'h' . ($debut->diffInMinutes($fin) % 60);
                            @endphp
                            <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-sm">
                                Durée: {{ $duree }}
                            </span>
                        </dd>
                    </div>

                    <!-- Salle -->
                    <div class="bg-gray-50 rounded-xl p-4 md:col-span-2">
                        <dt class="text-sm font-medium text-gray-500 mb-1 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            Salle
                        </dt>
                        <dd class="text-lg font-semibold text-gray-900">{{ $emploiDuTemps->salle ?? 'Non spécifiée' }}</dd>
                    </div>
                </dl>

                <!-- Dates de création et modification -->
                <div class="mt-8 pt-6 border-t border-gray-200 grid grid-cols-2 gap-4 text-sm text-gray-500">
                    <div>
                        <span class="font-medium">Créé le:</span>
                        {{ $emploiDuTemps->created_at ? $emploiDuTemps->created_at->format('d/m/Y à H:i') : 'N/A' }}
                    </div>
                    <div>
                        <span class="font-medium">Modifié le:</span>
                        {{ $emploiDuTemps->updated_at ? $emploiDuTemps->updated_at->format('d/m/Y à H:i') : 'N/A' }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions supplémentaires -->
        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
            <form action="{{ route('admin.emploi_du_temps.destroy', $emploiDuTemps) }}" method="POST" class="w-full">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="w-full inline-flex items-center justify-center px-6 py-3 bg-red-100 text-red-700 font-medium rounded-xl hover:bg-red-200 hover:shadow-md transform hover:-translate-y-1 transition-all duration-300"
                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce cours ? Cette action est irréversible.')">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Supprimer le cours
                </button>
            </form>
            
            <a href="{{ route('admin.emploi_du_temps.create') }}" 
               class="inline-flex items-center justify-center px-6 py-3 bg-green-100 text-green-700 font-medium rounded-xl hover:bg-green-200 hover:shadow-md transform hover:-translate-y-1 transition-all duration-300">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Ajouter un nouveau cours
            </a>
        </div>
    </div>
</div>

<!-- Styles pour les animations -->
@push('styles')
<style>
    @keyframes fadeInDown {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate__animated {
        animation-duration: 0.6s;
        animation-fill-mode: both;
    }
    .animate__fadeInDown { animation-name: fadeInDown; }
    .animate__fadeInUp { animation-name: fadeInUp; }
</style>
@endpush
@endsection