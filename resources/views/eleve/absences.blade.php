@extends('layouts.app')

@section('header')
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
        {{ __('Mes Absences') }}
    </h2>
@endsection

@section('content')
<div class="py-12">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        
        <!-- Header avec animation -->
        <div class="relative mb-8 overflow-hidden group rounded-2xl">
            <div class="absolute inset-0 bg-gradient-to-r from-red-600 via-orange-500 to-pink-600 animate-gradient-x"></div>
            <div class="absolute inset-0 opacity-20">
                <div class="absolute bg-white rounded-full w-96 h-96 -top-48 -right-48 blur-3xl animate-pulse-slow"></div>
                <div class="absolute bg-yellow-300 rounded-full w-96 h-96 -bottom-48 -left-48 blur-3xl animate-pulse-slow animation-delay-2000"></div>
            </div>
            
            <!-- Particules flottantes -->
            <div class="absolute inset-0">
                @for($i = 0; $i < 8; $i++)
                <div class="absolute w-2 h-2 bg-white rounded-full animate-float-random" 
                     style="left: {{ rand(0, 100) }}%; top: {{ rand(0, 100) }}%; animation-delay: {{ rand(0, 5) }}s; opacity: 0.6;"></div>
                @endfor
            </div>
            
            <div class="relative p-8">
                <div class="flex items-center justify-between">
                    <div class="transition-all duration-700 transform animate-slide-in-left">
                        <h3 class="text-3xl font-bold text-white drop-shadow-lg">Mes Absences</h3>
                        <p class="flex items-center mt-2 text-red-100">
                            <svg class="w-5 h-5 mr-2 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                            Historique de vos absences
                        </p>
                    </div>
                    <div class="hidden transition-all duration-700 transform md:block animate-slide-in-right hover:rotate-12 hover:scale-110">
                        <div class="p-5 border rounded-full bg-white/20 backdrop-blur-sm border-white/30">
                            <svg class="w-16 h-16 text-white animate-float" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards avec effets 3D -->
        <div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-3">
            <!-- Total absences -->
            <div class="group perspective" x-data="{ flipped: false }" @click="flipped = !flipped">
                <div class="relative transition-all duration-700 cursor-pointer preserve-3d" :class="{ 'rotate-y-180': flipped }">
                    <div class="backface-hidden">
                        <div class="p-6 transition-all duration-500 bg-white border border-gray-100 shadow-xl rounded-2xl hover:shadow-2xl hover:-translate-y-2">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="flex items-center text-sm font-medium text-gray-500">
                                        <span class="w-2 h-2 mr-2 bg-red-500 rounded-full animate-pulse"></span>
                                        Total absences
                                    </p>
                                    <p class="mt-2 text-4xl font-bold text-gray-900 animate-count">{{ $absences->count() }}</p>
                                </div>
                                <div class="p-4 shadow-lg bg-gradient-to-br from-red-500 to-red-600 rounded-xl animate-float">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="absolute inset-0 backface-hidden rotate-y-180">
                        <div class="flex flex-col items-center justify-center h-full p-6 shadow-xl bg-gradient-to-br from-red-500 to-red-600 rounded-2xl">
                            <svg class="w-12 h-12 mb-3 text-white animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                            <p class="text-lg font-bold text-center text-white">Total des absences<br>enregistrées</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Heures d'absence -->
            <div class="group perspective" x-data="{ flipped: false }" @click="flipped = !flipped">
                <div class="relative transition-all duration-700 cursor-pointer preserve-3d" :class="{ 'rotate-y-180': flipped }">
                    <div class="backface-hidden">
                        <div class="p-6 transition-all duration-500 bg-white border border-gray-100 shadow-xl rounded-2xl hover:shadow-2xl hover:-translate-y-2">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="flex items-center text-sm font-medium text-gray-500">
                                        <span class="w-2 h-2 mr-2 bg-orange-500 rounded-full animate-pulse animation-delay-200"></span>
                                        Heures d'absence
                                    </p>
                                    <p class="mt-2 text-4xl font-bold text-gray-900">
                                        <span class="animate-count">{{ $absences->sum('nombre_heures') ?? 0 }}</span>
                                        <span class="ml-1 text-lg text-gray-400">h</span>
                                    </p>
                                </div>
                                <div class="p-4 shadow-lg bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl animate-float animation-delay-200">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="absolute inset-0 backface-hidden rotate-y-180">
                        <div class="flex flex-col items-center justify-center h-full p-6 shadow-xl bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl">
                            <svg class="w-12 h-12 mb-3 text-white animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-lg font-bold text-center text-white">Total d'heures<br>d'absence</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Absences justifiées -->
            <div class="group perspective" x-data="{ flipped: false }" @click="flipped = !flipped">
                <div class="relative transition-all duration-700 cursor-pointer preserve-3d" :class="{ 'rotate-y-180': flipped }">
                    <div class="backface-hidden">
                        <div class="p-6 transition-all duration-500 bg-white border border-gray-100 shadow-xl rounded-2xl hover:shadow-2xl hover:-translate-y-2">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="flex items-center text-sm font-medium text-gray-500">
                                        <span class="w-2 h-2 mr-2 bg-green-500 rounded-full animate-pulse animation-delay-400"></span>
                                        Absences justifiées
                                    </p>
                                    <p class="mt-2 text-4xl font-bold text-gray-900">
                                        <span class="animate-count">{{ $absences->where('justifiee', true)->count() }}</span>
                                        <span class="ml-1 text-lg text-gray-400">/ {{ $absences->count() }}</span>
                                    </p>
                                </div>
                                <div class="p-4 shadow-lg bg-gradient-to-br from-green-500 to-green-600 rounded-xl animate-float animation-delay-400">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="absolute inset-0 backface-hidden rotate-y-180">
                        <div class="flex flex-col items-center justify-center h-full p-6 shadow-xl bg-gradient-to-br from-green-500 to-green-600 rounded-2xl">
                            <svg class="w-12 h-12 mb-3 text-white animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-lg font-bold text-center text-white">Absences<br>justifiées</p>
                        </div>
                    </div>
                </div>
            </div>
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
                <form method="GET" action="{{ route('eleve.absences') }}" class="grid grid-cols-1 gap-4 md:grid-cols-4">
                    <div class="transition-all duration-300 transform hover:scale-105">
                        <label class="flex items-center mb-2 text-sm font-medium text-gray-700">
                            <svg class="w-4 h-4 mr-1 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Date début
                        </label>
                        <input type="date" name="date_debut" value="{{ request('date_debut') }}" 
                               class="w-full transition-all duration-300 border-gray-300 rounded-xl focus:border-red-500 focus:ring-red-500 hover:border-red-400 hover:shadow-lg">
                    </div>
                    <div class="transition-all duration-300 transform hover:scale-105">
                        <label class="flex items-center mb-2 text-sm font-medium text-gray-700">
                            <svg class="w-4 h-4 mr-1 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Date fin
                        </label>
                        <input type="date" name="date_fin" value="{{ request('date_fin') }}" 
                               class="w-full transition-all duration-300 border-gray-300 rounded-xl focus:border-red-500 focus:ring-red-500 hover:border-red-400 hover:shadow-lg">
                    </div>
                    <div class="transition-all duration-300 transform hover:scale-105">
                        <label class="flex items-center mb-2 text-sm font-medium text-gray-700">
                            <svg class="w-4 h-4 mr-1 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                            Matière
                        </label>
                        <select name="matiere_id" class="w-full transition-all duration-300 border-gray-300 rounded-xl focus:border-red-500 focus:ring-red-500 hover:border-red-400 hover:shadow-lg">
                            <option value="">Toutes les matières</option>
                            @foreach($matieres as $matiere)
                                <option value="{{ $matiere->id }}" {{ request('matiere_id') == $matiere->id ? 'selected' : '' }}>
                                    {{ $matiere->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="transition-all duration-300 transform hover:scale-105">
                        <label class="flex items-center mb-2 text-sm font-medium text-gray-700">
                            <svg class="w-4 h-4 mr-1 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Statut
                        </label>
                        <select name="justifie" class="w-full transition-all duration-300 border-gray-300 rounded-xl focus:border-red-500 focus:ring-red-500 hover:border-red-400 hover:shadow-lg">
                            <option value="">Tous</option>
                            <option value="1" {{ request('justifie') == '1' ? 'selected' : '' }}>Justifiées</option>
                            <option value="0" {{ request('justifie') == '0' ? 'selected' : '' }}>Non justifiées</option>
                        </select>
                    </div>
                    <div class="flex justify-end space-x-3 md:col-span-4">
                        <a href="{{ route('eleve.absences') }}" 
                           class="flex items-center px-6 py-3 font-semibold text-gray-700 transition-all duration-300 transform bg-gray-100 rounded-xl hover:bg-gray-200 hover:scale-105 hover:shadow-lg group">
                            <svg class="w-5 h-5 mr-2 transition-transform duration-500 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Réinitialiser
                        </a>
                        <button type="submit" class="flex items-center px-6 py-3 font-semibold text-white transition-all duration-300 transform bg-gradient-to-r from-red-500 to-red-600 rounded-xl hover:from-red-600 hover:to-red-700 hover:scale-105 hover:shadow-lg group">
                            <svg class="w-5 h-5 mr-2 transition-all duration-500 group-hover:animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Filtrer
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tableau des absences -->
        <div class="overflow-hidden transition-all duration-500 transform bg-white border border-gray-100 shadow-xl rounded-2xl hover:shadow-2xl animate-fade-in-up animation-delay-200">
            <div class="p-6 bg-gradient-to-r from-red-600 to-pink-600">
                <div class="flex items-center justify-between">
                    <h3 class="flex items-center text-lg font-semibold text-white">
                        <svg class="w-5 h-5 mr-2 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        Historique des absences
                    </h3>
                    <span class="px-4 py-2 text-sm text-white rounded-full bg-white/20 backdrop-blur-sm animate-pulse">
                        {{ $absences->count() }} absence(s)
                    </span>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Date</th>
                            <th class="px-6 py-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Matière</th>
                            <th class="px-6 py-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Horaire</th>
                            <th class="px-6 py-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Durée</th>
                            <th class="px-6 py-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Motif</th>
                            <th class="px-6 py-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Statut</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($absences as $index => $absence)
                            @php
                                $rowClass = $index % 2 == 0 ? 'bg-white' : 'bg-gray-50/50';
                                $statutClass = $absence->justifiee ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800';
                                $statutIcon = $absence->justifiee ? 'M5 13l4 4L19 7' : 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z';
                            @endphp
                            <tr class="{{ $rowClass }} hover:bg-red-50/50 transition-all duration-300 transform hover:scale-102 hover:shadow-md animate-slide-up" style="animation-delay: {{ $index * 50 }}ms">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-3 py-1 text-sm font-medium text-red-700 bg-red-100 rounded-full">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        {{ \Carbon\Carbon::parse($absence->date_absence)->format('d/m/Y') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex items-center justify-center w-8 h-8 mr-3 rounded-lg shadow-md bg-gradient-to-br from-blue-500 to-indigo-600">
                                            <span class="text-xs font-bold text-white">{{ substr($absence->matiere->nom ?? 'M', 0, 2) }}</span>
                                        </div>
                                        <span class="font-medium text-gray-900">{{ $absence->matiere->nom ?? '-' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm text-gray-600">
                                        {{ substr($absence->heure_debut, 0, 5) ?? '--:--' }} - {{ substr($absence->heure_fin, 0, 5) ?? '--:--' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-3 py-1 text-sm font-medium text-purple-700 bg-purple-100 rounded-full">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $absence->nombre_heures ?? 1 }}h
                                    </span>
                                </td>
                                <td class="max-w-xs px-6 py-4 text-sm text-gray-600 truncate">
                                    {{ $absence->motif ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full {{ $statutClass }}">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $statutIcon }}"></path>
                                        </svg>
                                        {{ $absence->justifiee ? 'Justifiée' : 'Non justifiée' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="relative inline-block animate-float">
                                        <div class="absolute inset-0 bg-red-300 rounded-full opacity-50 blur-xl"></div>
                                        <svg class="relative w-20 h-20 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <p class="mt-4 text-lg text-gray-500">Aucune absence trouvée</p>
                                    <p class="text-sm text-gray-400">Vous n'avez aucune absence enregistrée</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if(method_exists($absences, 'links'))
                <div class="p-6 border-t border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                    <div class="flex items-center justify-between">
                        <p class="text-sm text-gray-600">
                            Affichage de <span class="font-medium">{{ $absences->firstItem() }}</span> à 
                            <span class="font-medium">{{ $absences->lastItem() }}</span> sur 
                            <span class="font-medium">{{ $absences->total() }}</span> absences
                        </p>
                        <div class="flex space-x-2">
                            {{ $absences->links() }}
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Graphique de répartition (optionnel) -->
        @if($absences->count() > 0)
        <div class="mt-8 overflow-hidden transition-all duration-500 transform bg-white border border-gray-100 shadow-xl rounded-2xl hover:shadow-2xl animate-fade-in-up animation-delay-400">
            <div class="p-6 bg-gradient-to-r from-purple-600 to-pink-600">
                <div class="flex items-center justify-between">
                    <h3 class="flex items-center text-lg font-semibold text-white">
                        <svg class="w-5 h-5 mr-2 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        Répartition des absences
                    </h3>
                </div>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-2 gap-6">
                    <div class="p-4 text-center bg-red-50 rounded-xl">
                        <span class="text-2xl font-bold text-red-600">{{ $absences->where('justifiee', false)->count() }}</span>
                        <p class="text-sm text-gray-600">Non justifiées</p>
                    </div>
                    <div class="p-4 text-center bg-green-50 rounded-xl">
                        <span class="text-2xl font-bold text-green-600">{{ $absences->where('justifiee', true)->count() }}</span>
                        <p class="text-sm text-gray-600">Justifiées</p>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<style>
/* Animations personnalisées */
@keyframes gradient-x {
    0%, 100% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}

@keyframes float-random {
    0%, 100% { transform: translate(0, 0); }
    25% { transform: translate(10px, -10px); }
    50% { transform: translate(-10px, 5px); }
    75% { transform: translate(5px, 10px); }
}

@keyframes slide-up {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes slide-in-left {
    from {
        opacity: 0;
        transform: translateX(-50px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes slide-in-right {
    from {
        opacity: 0;
        transform: translateX(50px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes fade-in-up {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes count {
    from {
        opacity: 0;
        transform: scale(0.5);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

@keyframes spin-slow {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

@keyframes pulse-slow {
    0%, 100% { opacity: 0.6; }
    50% { opacity: 1; }
}

.animate-gradient-x {
    background-size: 200% 200%;
    animation: gradient-x 15s ease infinite;
}

.animate-float {
    animation: float 3s ease-in-out infinite;
}

.animate-float-random {
    animation: float-random 10s ease-in-out infinite;
}

.animate-slide-up {
    animation: slide-up 0.6s ease-out forwards;
}

.animate-slide-in-left {
    animation: slide-in-left 0.7s ease-out forwards;
}

.animate-slide-in-right {
    animation: slide-in-right 0.7s ease-out forwards;
}

.animate-fade-in-up {
    animation: fade-in-up 0.8s ease-out forwards;
}

.animate-count {
    animation: count 0.5s ease-out;
}

.animate-spin-slow {
    animation: spin-slow 3s linear infinite;
}

.animate-pulse-slow {
    animation: pulse-slow 3s ease-in-out infinite;
}

.animation-delay-200 {
    animation-delay: 200ms;
}

.animation-delay-400 {
    animation-delay: 400ms;
}

.animation-delay-2000 {
    animation-delay: 2000ms;
}

/* Perspectives 3D */
.perspective {
    perspective: 1000px;
}

.preserve-3d {
    transform-style: preserve-3d;
}

.backface-hidden {
    backface-visibility: hidden;
}

.rotate-y-180 {
    transform: rotateY(180deg);
}

.hover\:rotate-y-180:hover {
    transform: rotateY(180deg);
}

/* Échelle personnalisée */
.hover\:scale-102:hover {
    transform: scale(1.02);
}

/* Transitions */
.transition-all {
    transition-property: all;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 300ms;
}

.duration-300 {
    transition-duration: 300ms;
}

.duration-500 {
    transition-duration: 500ms;
}

.duration-700 {
    transition-duration: 700ms;
}

/* Ombre personnalisée */
.hover\:shadow-2xl:hover {
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
}
</style>

<!-- Alpine.js pour les animations interactives -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endsection