@extends('layouts.app')

@section('header')
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
        {{ __('Absences de ') . $eleve->prenom . ' ' . $eleve->nom }}
    </h2>
@endsection

@section('content')
    @php
        // Valeurs par défaut pour éviter les erreurs
        $stats = $stats ?? [
            'total' => 0,
            'justifiees' => 0,
            'non_justifiees' => 0,
            'mois_courant' => 0
        ];
        $absences = $absences ?? collect([]);
        $matieres = $matieres ?? collect([]);
        $mois = $mois ?? [
            1 => 'Janvier', 2 => 'Février', 3 => 'Mars', 4 => 'Avril', 5 => 'Mai', 6 => 'Juin',
            7 => 'Juillet', 8 => 'Août', 9 => 'Septembre', 10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre'
        ];
    @endphp

<div class="py-12">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="relative mb-8 overflow-hidden group rounded-2xl">
            <div class="absolute inset-0 bg-gradient-to-r from-red-600 via-orange-500 to-red-600 animate-gradient-x"></div>
            <div class="absolute inset-0 opacity-20">
                <div class="absolute bg-white rounded-full w-96 h-96 -top-48 -right-48 blur-3xl animate-pulse-slow"></div>
                <div class="absolute bg-yellow-300 rounded-full w-96 h-96 -bottom-48 -left-48 blur-3xl animate-pulse-slow animation-delay-2000"></div>
            </div>
            
            <!-- Particules -->
            <div class="absolute inset-0">
                @for($i = 0; $i < 12; $i++)
                <div class="absolute w-2 h-2 bg-white rounded-full animate-float-random" 
                     style="left: {{ rand(0, 100) }}%; top: {{ rand(0, 100) }}%; animation-delay: {{ rand(0, 5) }}s; opacity: 0.6;"></div>
                @endfor
            </div>
            
            <div class="relative p-8">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div class="flex items-center space-x-6">
                        <!-- Avatar élève -->
                        <div class="relative group">
                            <div class="flex items-center justify-center w-20 h-20 transition-all duration-300 transform border-2 shadow-2xl bg-white/20 backdrop-blur-sm rounded-2xl border-white/30 group-hover:scale-110">
                                <span class="text-3xl font-bold text-white">
                                    {{ substr($eleve->prenom, 0, 1) }}{{ substr($eleve->nom, 0, 1) }}
                                </span>
                            </div>
                            <div class="absolute w-4 h-4 bg-green-400 border-2 border-red-600 rounded-full -bottom-1 -right-1 animate-pulse"></div>
                            @if(($stats['non_justifiees'] ?? 0) > 0)
                            <div class="absolute px-2 py-1 text-xs text-white bg-red-500 rounded-full -top-2 -right-2 animate-bounce">
                                {{ $stats['non_justifiees'] }} non just.
                            </div>
                            @endif
                        </div>
                        
                        <div class="transition-all duration-700 transform animate-slide-in-left">
                            <h3 class="text-3xl font-bold text-white drop-shadow-lg">Absences de {{ $eleve->prenom }} {{ $eleve->nom }}</h3>
                            <div class="flex flex-wrap items-center gap-3 mt-2">
                                <span class="inline-flex items-center px-3 py-1 text-sm text-white rounded-full bg-white/20">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                    {{ $eleve->classe->nom ?? 'Classe non assignée' }}
                                </span>
                                @if(isset($lienParental))
                                <span class="inline-flex items-center px-3 py-1 text-sm text-white rounded-full bg-white/20">
                                    {{ $lienParental }}
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="hidden transition-all duration-700 transform md:block animate-slide-in-right hover:rotate-12 hover:scale-110">
                        <div class="p-4 border rounded-full bg-white/20 backdrop-blur-sm border-white/30">
                            <svg class="w-16 h-16 text-white animate-float" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('parent.enfants') }}" class="inline-flex items-center px-4 py-2 text-gray-700 transition-all duration-300 bg-gray-100 hover:bg-gray-200 rounded-xl hover:scale-105 hover:shadow-md group">
                <svg class="w-5 h-5 mr-2 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Retour à mes enfants
            </a>
        </div>

        <!-- Filtres -->
        <div class="mb-8 overflow-hidden transition-all duration-500 transform bg-white border border-gray-100 shadow-xl rounded-2xl hover:shadow-2xl animate-fade-in-up">
            <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                <h3 class="flex items-center text-lg font-semibold text-gray-900">
                    <svg class="w-5 h-5 mr-2 text-red-600 animate-spin-slow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                    </svg>
                    Filtrer les absences
                </h3>
            </div>
            <div class="p-6">
                <form method="GET" action="{{ route('parent.enfant.absences', $eleve->id) }}" class="grid grid-cols-1 gap-4 md:grid-cols-6">
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">Date début</label>
                        <input type="date" name="date_debut" value="{{ request('date_debut') }}" 
                               class="w-full border-gray-300 rounded-xl focus:border-red-500 focus:ring-red-500">
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">Date fin</label>
                        <input type="date" name="date_fin" value="{{ request('date_fin') }}" 
                               class="w-full border-gray-300 rounded-xl focus:border-red-500 focus:ring-red-500">
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">Matière</label>
                        <select name="matiere_id" class="w-full border-gray-300 rounded-xl focus:border-red-500 focus:ring-red-500">
                            <option value="">Toutes</option>
                            @foreach($matieres as $matiere)
                                <option value="{{ $matiere->id }}" {{ request('matiere_id') == $matiere->id ? 'selected' : '' }}>
                                    {{ $matiere->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">Statut</label>
                        <select name="justifiee" class="w-full border-gray-300 rounded-xl focus:border-red-500 focus:ring-red-500">
                            <option value="">Tous</option>
                            <option value="1" {{ request('justifiee') == '1' ? 'selected' : '' }}>Justifiées</option>
                            <option value="0" {{ request('justifiee') == '0' ? 'selected' : '' }}>Non justifiées</option>
                        </select>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">Mois</label>
                        <select name="mois" class="w-full border-gray-300 rounded-xl focus:border-red-500 focus:ring-red-500">
                            <option value="">Tous</option>
                            @foreach($mois as $num => $nomMois)
                                <option value="{{ $num }}" {{ request('mois') == $num ? 'selected' : '' }}>
                                    {{ $nomMois }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">Année</label>
                        <select name="annee" class="w-full border-gray-300 rounded-xl focus:border-red-500 focus:ring-red-500">
                            <option value="">Toutes</option>
                            @for($i = now()->year; $i >= now()->year - 3; $i--)
                                <option value="{{ $i }}" {{ request('annee') == $i ? 'selected' : '' }}>
                                    {{ $i }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    <div class="flex items-end justify-end space-x-3 md:col-span-6">
                        <a href="{{ route('parent.enfant.absences', $eleve->id) }}" 
                           class="px-6 py-3 font-semibold text-gray-700 bg-gray-100 rounded-xl hover:bg-gray-200">
                            Réinitialiser
                        </a>
                        <button type="submit" class="px-6 py-3 font-semibold text-white bg-gradient-to-r from-red-500 to-red-600 rounded-xl hover:from-red-600 hover:to-red-700">
                            Filtrer
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-4">
            <div class="p-6 bg-white border border-gray-100 shadow-xl rounded-2xl">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Total absences</p>
                        <p class="mt-2 text-4xl font-bold text-gray-900">{{ $stats['total'] }}</p>
                    </div>
                    <div class="p-4 bg-red-100 rounded-xl">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="p-6 bg-white border border-gray-100 shadow-xl rounded-2xl">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Justifiées</p>
                        <p class="mt-2 text-4xl font-bold text-green-600">{{ $stats['justifiees'] }}</p>
                    </div>
                    <div class="p-4 bg-green-100 rounded-xl">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="p-6 bg-white border border-gray-100 shadow-xl rounded-2xl">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Non justifiées</p>
                        <p class="mt-2 text-4xl font-bold text-red-600">{{ $stats['non_justifiees'] }}</p>
                    </div>
                    <div class="p-4 bg-orange-100 rounded-xl">
                        <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="p-6 bg-white border border-gray-100 shadow-xl rounded-2xl">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Ce mois</p>
                        <p class="mt-2 text-4xl font-bold text-blue-600">{{ $stats['mois_courant'] }}</p>
                    </div>
                    <div class="p-4 bg-blue-100 rounded-xl">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Message de notification pour les justifications -->
        @if(session('success'))
        <div class="p-4 mb-6 text-green-700 bg-green-100 border-l-4 border-green-500 rounded-r-lg">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                {{ session('success') }}
            </div>
        </div>
        @endif

        @if(session('error'))
        <div class="p-4 mb-6 text-red-700 bg-red-100 border-l-4 border-red-500 rounded-r-lg">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2 text-red-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                {{ session('error') }}
            </div>
        </div>
        @endif

        <!-- Tableau des absences -->
        <div class="overflow-hidden bg-white border border-gray-100 shadow-xl rounded-2xl">
            <div class="p-6 bg-gradient-to-r from-red-600 to-orange-600">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-white">Historique des absences</h3>
                    <span class="px-4 py-2 text-sm text-white rounded-full bg-white/20">
                        {{ $stats['total'] }} absence(s)
                    </span>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-xs font-medium text-left text-gray-500 uppercase">Date</th>
                            <th class="px-6 py-4 text-xs font-medium text-left text-gray-500 uppercase">Matière</th>
                            <th class="px-6 py-4 text-xs font-medium text-left text-gray-500 uppercase">Durée</th>
                            <th class="px-6 py-4 text-xs font-medium text-left text-gray-500 uppercase">Statut</th>
                            <th class="px-6 py-4 text-xs font-medium text-left text-gray-500 uppercase">Motif</th>
                            <th class="px-6 py-4 text-xs font-medium text-left text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($absences as $absence)
                            @php
                                $statutClass = $absence->justifiee ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800';
                            @endphp
                            <tr class="hover:bg-red-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 text-sm font-medium text-red-700 bg-red-100 rounded-full">
                                        {{ \Carbon\Carbon::parse($absence->date_absence)->format('d/m/Y') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="flex items-center justify-center w-8 h-8 mr-3 rounded-lg bg-gradient-to-br from-blue-500 to-indigo-600">
                                            <span class="text-xs font-bold text-white">{{ $absence->matiere ? substr($absence->matiere->nom, 0, 2) : 'M' }}</span>
                                        </div>
                                        <span>{{ $absence->matiere->nom ?? '-' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 text-sm font-medium text-purple-700 bg-purple-100 rounded-full">
                                        {{ $absence->nombre_heures ?? 1 }}h
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $statutClass }}">
                                        {{ $absence->justifiee ? 'Justifiée' : 'Non justifiée' }}
                                    </span>
                                </td>
                                <td class="max-w-xs px-6 py-4">
                                    <span class="block truncate" title="{{ $absence->motif ?? 'Aucun motif' }}">
                                        {{ $absence->motif ?? '-' }}
                                    </span>
                                    @if($absence->document_path)
                                    <a href="{{ route('parent.telecharger-justificatif', $absence->id) }}" 
                                       class="inline-flex items-center mt-1 text-xs text-blue-600 hover:text-blue-800">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                        </svg>
                                        Voir justificatif
                                    </a>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if(!$absence->justifiee)
                                        <button onclick="showJustificationModal({{ $absence->id }})" 
                                                class="px-3 py-2 text-xs font-medium text-white rounded-lg bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700">
                                            Justifier
                                        </button>
                                    @else
                                        <span class="px-3 py-2 text-xs font-medium text-green-700 bg-green-100 rounded-lg">
                                            Justifiée
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <svg class="w-20 h-20 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <p class="mt-4 text-gray-500">Aucune absence trouvée</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(method_exists($absences, 'links'))
            <div class="p-6 border-t">
                {{ $absences->links() }}
            </div>
            @endif
        </div>

        <!-- Graphique de répartition -->
        @if($stats['total'] > 0)
        <div class="mt-8 overflow-hidden bg-white border border-gray-100 shadow-xl rounded-2xl">
            <div class="p-6 bg-gradient-to-r from-purple-600 to-pink-600">
                <h3 class="text-lg font-semibold text-white">Répartition des absences</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-2 gap-6">
                    <div class="p-6 text-center bg-red-50 rounded-xl">
                        <span class="text-4xl font-bold text-red-600">{{ $stats['non_justifiees'] }}</span>
                        <p class="mt-2 text-sm text-gray-600">Non justifiées</p>
                        <div class="w-full h-2 mt-3 bg-red-200 rounded-full">
                            <div class="h-2 bg-red-600 rounded-full" style="width: {{ $stats['total'] > 0 ? ($stats['non_justifiees'] / $stats['total']) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                    <div class="p-6 text-center bg-green-50 rounded-xl">
                        <span class="text-4xl font-bold text-green-600">{{ $stats['justifiees'] }}</span>
                        <p class="mt-2 text-sm text-gray-600">Justifiées</p>
                        <div class="w-full h-2 mt-3 bg-green-200 rounded-full">
                            <div class="h-2 bg-green-600 rounded-full" style="width: {{ $stats['total'] > 0 ? ($stats['justifiees'] / $stats['total']) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Modal de justification -->
<div id="justificationModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" onclick="hideJustificationModal()"></div>

        <!-- Modal panel -->
        <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form id="justificationForm" method="POST" action="" enctype="multipart/form-data">
                @csrf
                
                <div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="flex items-center justify-center w-12 h-12 mx-auto bg-green-100 rounded-full sm:mx-0">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">Justifier une absence</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">Veuillez fournir un motif et éventuellement un document justificatif.</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700">Motif <span class="text-red-500">*</span></label>
                        <textarea name="motif" rows="3" required
                                  class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-red-500 focus:ring-red-500"
                                  placeholder="Expliquez la raison de l'absence..."></textarea>
                        @error('motif')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700">Document justificatif</label>
                        <div class="flex justify-center px-6 pt-5 pb-6 mt-1 border-2 border-gray-300 border-dashed rounded-md">
                            <div class="space-y-1 text-center">
                                <svg class="w-12 h-12 mx-auto text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label class="relative font-medium text-red-600 bg-white rounded-md cursor-pointer hover:text-red-500">
                                        <span>Télécharger un fichier</span>
                                        <input type="file" name="document" class="sr-only" accept=".pdf,.jpg,.jpeg,.png">
                                    </label>
                                </div>
                                <p class="text-xs text-gray-500">PDF, PNG, JPG jusqu'à 2MB</p>
                            </div>
                        </div>
                        @error('document')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="px-4 py-3 bg-gray-50 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full px-4 py-2 text-base font-medium text-white bg-green-600 border border-transparent rounded-md shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Justifier
                    </button>
                    <button type="button" onclick="hideJustificationModal()" class="w-full px-4 py-2 mt-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:mt-0 sm:w-auto sm:text-sm">
                        Annuler
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function showJustificationModal(absenceId) {
    const modal = document.getElementById('justificationModal');
    const form = document.getElementById('justificationForm');
    form.action = "{{ route('parent.justifier-absence', '') }}/" + absenceId;
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function hideJustificationModal() {
    const modal = document.getElementById('justificationModal');
    modal.classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Fermer le modal avec la touche Echap
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        hideJustificationModal();
    }
});

// Aperçu du nom de fichier sélectionné
document.querySelector('input[name="document"]')?.addEventListener('change', function(e) {
    const fileName = e.target.files[0]?.name;
    if (fileName) {
        const label = e.target.closest('label').querySelector('span');
        if (label) {
            label.textContent = fileName;
        }
    }
});
</script>

<style>
@keyframes gradient-x { 0%,100% { background-position: 0% 50%; } 50% { background-position: 100% 50%; } }
.animate-gradient-x { background-size: 200% 200%; animation: gradient-x 15s ease infinite; }
@keyframes float { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
.animate-float { animation: float 3s ease-in-out infinite; }
@keyframes float-random { 0%,100% { transform: translate(0,0); } 25% { transform: translate(10px,-10px); } 50% { transform: translate(-10px,5px); } 75% { transform: translate(5px,10px); } }
.animate-float-random { animation: float-random 10s ease-in-out infinite; }
.animate-slide-in-left { animation: slide-in-left 0.7s ease-out forwards; }
.animate-slide-in-right { animation: slide-in-right 0.7s ease-out forwards; }
.animate-fade-in-up { animation: fade-in-up 0.8s ease-out forwards; }
@keyframes slide-in-left { from { opacity:0; transform:translateX(-50px); } to { opacity:1; transform:translateX(0); } }
@keyframes slide-in-right { from { opacity:0; transform:translateX(50px); } to { opacity:1; transform:translateX(0); } }
@keyframes fade-in-up { from { opacity:0; transform:translateY(30px); } to { opacity:1; transform:translateY(0); } }
.animate-pulse-slow { animation: pulse-slow 3s ease-in-out infinite; }
@keyframes pulse-slow { 0%,100% { opacity:0.6; } 50% { opacity:1; } }
.animate-spin-slow { animation: spin-slow 3s linear infinite; }
@keyframes spin-slow { from { transform:rotate(0deg); } to { transform:rotate(360deg); } }
.animation-delay-200 { animation-delay: 200ms; }
.animation-delay-2000 { animation-delay: 2000ms; }
#justificationModal.hidden { display: none; }
</style>

<!-- Alpine.js -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endsection