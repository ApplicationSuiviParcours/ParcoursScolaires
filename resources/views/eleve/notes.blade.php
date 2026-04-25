@extends('layouts.app')

@section('header')
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
        {{ __('Mes Notes') }}
    </h2>
@endsection

@section('content')
<div class="py-6 sm:py-12 overflow-x-hidden">
    <div class="px-3 mx-auto max-w-7xl sm:px-6 lg:px-8">
        
        <!-- Header avec animation améliorée -->
        <div class="relative mb-6 overflow-hidden group sm:mb-8 rounded-xl sm:rounded-2xl">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 animate-gradient-x"></div>
            <div class="absolute inset-0 opacity-20">
                <div class="absolute bg-white rounded-full w-64 h-64 sm:w-96 sm:h-96 -top-48 -right-48 blur-3xl animate-pulse-slow"></div>
                <div class="absolute bg-yellow-300 rounded-full w-64 h-64 sm:w-96 sm:h-96 -bottom-48 -left-48 blur-3xl animate-pulse-slow animation-delay-2000"></div>
            </div>
            
            <!-- Particules flottantes améliorées -->
            <div class="absolute inset-0">
                @for($i = 0; $i < 8; $i++)
                <div class="absolute w-1.5 h-1.5 sm:w-2 sm:h-2 bg-white rounded-full animate-float-random" 
                     style="left: {{ rand(0, 100) }}%; top: {{ rand(0, 100) }}%; animation-delay: {{ rand(0, 5) }}s; opacity: 0.6;"></div>
                @endfor
            </div>
            
            <div class="relative p-4 sm:p-6 md:p-8">
                <div class="flex flex-col items-start justify-between sm:flex-row sm:items-center">
                    <div class="mb-3 transition-all duration-700 transform sm:mb-0 animate-slide-in-left">
                        <h3 class="text-2xl font-bold text-white sm:text-3xl drop-shadow-lg">Mes Notes</h3>
                        <p class="flex items-center mt-1 text-xs text-blue-100 sm:text-sm">
                            <svg class="w-4 h-4 mr-1 sm:w-5 sm:h-5 sm:mr-2 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Consulter toutes vos notes
                        </p>
                    </div>
                    <div class="hidden transition-all duration-700 transform sm:block animate-slide-in-right hover:rotate-12 hover:scale-110">
                        <div class="p-3 border rounded-full sm:p-5 bg-white/20 backdrop-blur-sm border-white/30">
                            <svg class="w-10 h-10 text-white sm:w-16 sm:h-16 animate-float" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards avec animations 3D -->
        <div class="grid grid-cols-1 gap-4 mb-6 sm:grid-cols-2 sm:gap-6 md:grid-cols-3 lg:mb-8">
            <!-- Nombre de notes -->
            <div class="group perspective" x-data="{ flipped: false }" @click="flipped = !flipped">
                <div class="relative transition-all duration-700 cursor-pointer preserve-3d" :class="{ 'rotate-y-180': flipped }">
                    <!-- Face avant -->
                    <div class="backface-hidden">
                        <div class="p-4 transition-all duration-500 bg-white border border-gray-100 shadow-xl sm:p-6 rounded-xl sm:rounded-2xl hover:shadow-2xl hover:-translate-y-2">
                            <div class="flex items-center justify-between">
                                <div class="flex-1 min-w-0">
                                    <p class="flex items-center text-xs font-medium text-gray-500 sm:text-sm">
                                        <span class="w-1.5 h-1.5 mr-1 bg-blue-500 rounded-full animate-pulse sm:w-2 sm:h-2 sm:mr-2"></span>
                                        Nombre de notes
                                    </p>
                                    <p class="mt-1 text-2xl font-bold text-gray-900 sm:text-3xl md:text-4xl animate-count truncate">{{ $stats['total_notes'] }}</p>
                                </div>
                                <div class="flex-shrink-0 ml-3 p-2 shadow-lg sm:p-3 md:p-4 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl animate-float">
                                    <svg class="w-5 h-5 text-white sm:w-6 sm:h-6 md:w-8 md:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Face arrière -->
                    <div class="absolute inset-0 backface-hidden rotate-y-180">
                        <div class="flex flex-col items-center justify-center h-full p-4 shadow-xl sm:p-6 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl sm:rounded-2xl">
                            <svg class="w-8 h-8 mb-2 text-white sm:w-10 sm:h-10 md:w-12 md:h-12 sm:mb-3 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            <p class="text-sm font-bold text-center text-white sm:text-base md:text-lg">Total des notes<br>enregistrées</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Moyenne générale -->
            <div class="group perspective" x-data="{ flipped: false }" @click="flipped = !flipped">
                <div class="relative transition-all duration-700 cursor-pointer preserve-3d" :class="{ 'rotate-y-180': flipped }">
                    <div class="backface-hidden">
                        <div class="p-4 transition-all duration-500 bg-white border border-gray-100 shadow-xl sm:p-6 rounded-xl sm:rounded-2xl hover:shadow-2xl hover:-translate-y-2">
                            <div class="flex items-center justify-between">
                                <div class="flex-1 min-w-0">
                                    <p class="flex items-center text-xs font-medium text-gray-500 sm:text-sm">
                                        <span class="w-1.5 h-1.5 mr-1 bg-green-500 rounded-full animate-pulse animation-delay-200 sm:w-2 sm:h-2 sm:mr-2"></span>
                                        Moyenne générale
                                    </p>
                                    <p class="mt-1 text-2xl font-bold text-gray-900 sm:text-3xl md:text-4xl truncate">
                                        <span class="animate-count">{{ $stats['moyenne_generale'] }}</span>
                                        <span class="ml-1 text-sm text-gray-400 sm:text-base md:text-lg">/20</span>
                                    </p>
                                </div>
                                <div class="flex-shrink-0 ml-3 p-2 shadow-lg sm:p-3 md:p-4 bg-gradient-to-br from-green-500 to-green-600 rounded-xl animate-float animation-delay-200">
                                    <svg class="w-5 h-5 text-white sm:w-6 sm:h-6 md:w-8 md:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="absolute inset-0 backface-hidden rotate-y-180">
                        <div class="flex flex-col items-center justify-center h-full p-4 shadow-xl sm:p-6 bg-gradient-to-br from-green-500 to-green-600 rounded-xl sm:rounded-2xl">
                            <svg class="w-8 h-8 mb-2 text-white sm:w-10 sm:h-10 md:w-12 md:h-12 sm:mb-3 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            <p class="text-sm font-bold text-center text-white sm:text-base md:text-lg">Performance<br>globale</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Meilleure note -->
            <div class="group perspective sm:col-span-2 md:col-span-1" x-data="{ flipped: false }" @click="flipped = !flipped">
                <div class="relative transition-all duration-700 cursor-pointer preserve-3d" :class="{ 'rotate-y-180': flipped }">
                    <div class="backface-hidden">
                        <div class="p-4 transition-all duration-500 bg-white border border-gray-100 shadow-xl sm:p-6 rounded-xl sm:rounded-2xl hover:shadow-2xl hover:-translate-y-2">
                            <div class="flex items-center justify-between">
                                <div class="flex-1 min-w-0">
                                    <p class="flex items-center text-xs font-medium text-gray-500 sm:text-sm">
                                        <span class="w-1.5 h-1.5 mr-1 bg-purple-500 rounded-full animate-pulse animation-delay-400 sm:w-2 sm:h-2 sm:mr-2"></span>
                                        Meilleure note
                                    </p>
                                    <p class="mt-1 text-2xl font-bold text-gray-900 sm:text-3xl md:text-4xl truncate">
                                        <span class="animate-count">{{ $stats['note_max'] }}</span>
                                        <span class="ml-1 text-sm text-gray-400 sm:text-base md:text-lg">/20</span>
                                    </p>
                                </div>
                                <div class="flex-shrink-0 ml-3 p-2 shadow-lg sm:p-3 md:p-4 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl animate-float animation-delay-400">
                                    <svg class="w-5 h-5 text-white sm:w-6 sm:h-6 md:w-8 md:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="absolute inset-0 backface-hidden rotate-y-180">
                        <div class="flex flex-col items-center justify-center h-full p-4 shadow-xl sm:p-6 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl sm:rounded-2xl">
                            <svg class="w-8 h-8 mb-2 text-white sm:w-10 sm:h-10 md:w-12 md:h-12 sm:mb-3 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                            </svg>
                            <p class="text-sm font-bold text-center text-white sm:text-base md:text-lg">Ta meilleure<br>performance</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filtres améliorés -->
        <div class="mb-6 overflow-hidden transition-all duration-500 transform bg-white border border-gray-100 shadow-xl sm:mb-8 rounded-xl sm:rounded-2xl hover:shadow-2xl animate-fade-in-up">
            <div class="p-4 border-b border-gray-100 sm:p-6 bg-gradient-to-r from-gray-50 to-white">
                <h3 class="flex items-center text-base font-semibold text-gray-900 sm:text-lg">
                    <svg class="w-4 h-4 mr-1 text-blue-600 sm:w-5 sm:h-5 sm:mr-2 animate-spin-slow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                    </svg>
                    Filtrer les notes
                </h3>
            </div>
            <div class="p-4 sm:p-6">
                <form method="GET" action="{{ route('eleve.notes') }}" class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    <div class="transition-all duration-300 transform hover:scale-105">
                        <label class="flex items-center mb-1 text-xs font-medium text-gray-700 sm:text-sm sm:mb-2">
                            <svg class="w-3 h-3 mr-1 text-blue-500 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                            Matière
                        </label>
                        <select name="matiere_id" class="w-full text-sm p-2 transition-all duration-300 border-gray-300 rounded-lg sm:rounded-xl focus:border-blue-500 focus:ring-blue-500 hover:border-blue-400 hover:shadow-lg">
                            <option value="">Toutes les matières</option>
                            @foreach($matieres as $matiere)
                                <option value="{{ $matiere->id }}" {{ request('matiere_id') == $matiere->id ? 'selected' : '' }}>
                                    {{ $matiere->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="transition-all duration-300 transform hover:scale-105">
                        <label class="flex items-center mb-1 text-xs font-medium text-gray-700 sm:text-sm sm:mb-2">
                            <svg class="w-3 h-3 mr-1 text-green-500 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Période
                        </label>
                        <select name="periode" class="w-full text-sm p-2 transition-all duration-300 border-gray-300 rounded-lg sm:rounded-xl focus:border-blue-500 focus:ring-blue-500 hover:border-blue-400 hover:shadow-lg">
                            <option value="">Toutes les périodes</option>
                            @foreach($periodes as $key => $periode)
                                <option value="{{ $key }}" {{ request('periode') == $key ? 'selected' : '' }}>
                                    {{ $periode }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="transition-all duration-300 transform hover:scale-105">
                        <label class="flex items-center mb-1 text-xs font-medium text-gray-700 sm:text-sm sm:mb-2">
                            <svg class="w-3 h-3 mr-1 text-purple-500 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Date début
                        </label>
                        <input type="date" name="date_debut" value="{{ request('date_debut') }}" 
                               class="w-full text-sm transition-all p-2 duration-300 border-gray-300 rounded-lg sm:rounded-xl focus:border-blue-500 focus:ring-blue-500 hover:border-blue-400 hover:shadow-lg">
                    </div>
                    <div class="transition-all duration-300 transform hover:scale-105">
                        <label class="flex items-center mb-1 text-xs font-medium text-gray-700 sm:text-sm sm:mb-2">
                            <svg class="w-3 h-3 mr-1 text-orange-500 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Date fin
                        </label>
                        <input type="date" name="date_fin" value="{{ request('date_fin') }}" 
                               class="w-full text-sm transition-all p-2 duration-300 border-gray-300 rounded-lg sm:rounded-xl focus:border-blue-500 focus:ring-blue-500 hover:border-blue-400 hover:shadow-lg">
                    </div>
                    <div class="flex flex-col justify-end space-y-2 sm:flex-row sm:space-y-0 sm:space-x-3 sm:col-span-2 lg:col-span-4">
                        <a href="{{ route('eleve.notes') }}" 
                           class="flex items-center justify-center px-4 py-2 text-sm font-semibold text-gray-700 transition-all duration-300 transform bg-gray-100 rounded-lg sm:px-6 sm:py-3 sm:text-base hover:bg-gray-200 hover:scale-105 hover:shadow-lg group">
                            <svg class="w-4 h-4 mr-1 transition-transform duration-500 sm:w-5 sm:h-5 sm:mr-2 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Réinitialiser
                        </a>
                        <button type="submit" class="flex items-center justify-center px-4 py-2 text-sm font-semibold text-white transition-all duration-300 transform bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg sm:px-6 sm:py-3 sm:text-base hover:from-blue-600 hover:to-blue-700 hover:scale-105 hover:shadow-lg group">
                            <svg class="w-4 h-4 mr-1 transition-all duration-500 sm:w-5 sm:h-5 sm:mr-2 group-hover:animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Filtrer
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tableau des notes -->
        <div class="overflow-hidden transition-all duration-500 transform bg-white border border-gray-100 shadow-xl rounded-xl sm:rounded-2xl hover:shadow-2xl animate-fade-in-up animation-delay-200">
            <div class="p-4 bg-gradient-to-r from-indigo-600 to-blue-600 sm:p-6">
                <div class="flex flex-col items-start justify-between space-y-2 sm:flex-row sm:items-center sm:space-y-0">
                    <h3 class="flex items-center text-base font-semibold text-white sm:text-lg">
                        <svg class="w-4 h-4 mr-1 sm:w-5 sm:h-5 sm:mr-2 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        Liste des notes
                    </h3>
                    <span class="px-3 py-1 text-xs text-white rounded-full sm:text-sm sm:px-4 sm:py-2 bg-white/20 backdrop-blur-sm animate-pulse">
                        {{ $stats['total_notes'] }} note(s) trouvée(s)
                    </span>
                </div>
            </div>
            
            <div class="overflow-x-auto overflow-y-hidden">
                <div class="inline-block min-w-full align-middle">
                    <table class="min-w-full table-auto">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-2 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase whitespace-nowrap sm:px-3 sm:py-3 md:px-4 md:py-4">Date</th>
                                <th class="px-2 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase whitespace-nowrap sm:px-3 sm:py-3 md:px-4 md:py-4">Matière</th>
                                <th class="px-2 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase whitespace-nowrap sm:px-3 sm:py-3 md:px-4 md:py-4">Type</th>
                                <th class="px-2 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase whitespace-nowrap sm:px-3 sm:py-3 md:px-4 md:py-4">Note</th>
                                <th class="px-2 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase whitespace-nowrap sm:px-3 sm:py-3 md:px-4 md:py-4">Sur</th>
                                <th class="px-2 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase whitespace-nowrap sm:px-3 sm:py-3 md:px-4 md:py-4">Coef.</th>
                                <th class="px-2 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase whitespace-nowrap sm:px-3 sm:py-3 md:px-4 md:py-4">Appréciation</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($notes as $index => $note)
                                @php
                                    $noteValue = $note->note;
                                    $bgColor = $index % 2 == 0 ? 'bg-white' : 'bg-gray-50/50';
                                    $noteClass = $noteValue >= 16 ? 'from-green-500 to-green-600 text-green-800 bg-green-100' : 
                                                ($noteValue >= 14 ? 'from-blue-500 to-blue-600 text-blue-800 bg-blue-100' : 
                                                ($noteValue >= 10 ? 'from-yellow-500 to-yellow-600 text-yellow-800 bg-yellow-100' : 
                                                'from-red-500 to-red-600 text-red-800 bg-red-100'));
                                    
                                    $appreciation = '-';
                                    if (!empty($note->observation)) {
                                        $appreciation = $note->observation;
                                    } elseif (!empty($note->evaluation) && !empty($note->evaluation->description)) {
                                        $appreciation = $note->evaluation->description;
                                    }
                                @endphp
                                <tr class="{{ $bgColor }} hover:bg-blue-50/50 transition-all duration-300 transform hover:scale-102 hover:shadow-md animate-slide-up" style="animation-delay: {{ $index * 50 }}ms">
                                    <td class="px-2 py-2 whitespace-nowrap sm:px-3 sm:py-3 md:px-4 md:py-4">
                                        <span class="inline-flex items-center px-1.5 py-0.5 text-xs font-medium text-indigo-700 bg-indigo-100 rounded-full sm:px-2 sm:py-1 md:px-3 md:py-1">
                                            <svg class="w-2 h-2 mr-0.5 sm:w-2.5 sm:h-2.5 sm:mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            {{ $note->evaluation->date_evaluation ? \Carbon\Carbon::parse($note->evaluation->date_evaluation)->format('d/m/Y') : '-' }}
                                        </span>
                                    </td>
                                    <td class="px-2 py-2 whitespace-nowrap sm:px-3 sm:py-3 md:px-4 md:py-4">
                                        <div class="flex items-center">
                                            <div class="flex items-center justify-center w-5 h-5 mr-1 rounded-lg shadow-md sm:w-6 sm:h-6 sm:mr-2 md:w-8 md:h-8 md:mr-3 bg-gradient-to-br from-blue-500 to-indigo-600">
                                                <span class="text-[10px] font-bold text-white sm:text-xs md:text-sm">{{ substr($note->evaluation->matiere->nom ?? 'M', 0, 2) }}</span>
                                            </div>
                                            <span class="text-xs font-medium text-gray-900 sm:text-sm truncate max-w-[80px] sm:max-w-none">{{ optional($note->evaluation->matiere)->nom ?? '-' }}</span>
                                        </div>
                                    </td>
                                    <td class="px-2 py-2 whitespace-nowrap sm:px-3 sm:py-3 md:px-4 md:py-4">
                                        <span class="px-1.5 py-0.5 text-xs font-medium text-purple-600 bg-purple-100 rounded-full sm:px-2 sm:py-1 md:px-3">
                                            {{ $note->evaluation->type ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="px-2 py-2 whitespace-nowrap sm:px-3 sm:py-3 md:px-4 md:py-4">
                                        <div class="relative group">
                                            <span class="px-1.5 py-0.5 inline-flex text-xs leading-5 font-bold rounded-lg sm:px-2 sm:py-1 md:px-3 md:py-1.5 bg-gradient-to-r {{ explode(' ', $noteClass)[0] }} {{ explode(' ', $noteClass)[1] }} text-white shadow-lg transform transition-all group-hover:scale-110">
                                                {{ number_format($noteValue, 2) }}
                                            </span>
                                            <div class="absolute px-2 py-1 text-xs text-white transition-opacity duration-300 transform -translate-x-1/2 bg-gray-900 rounded opacity-0 -top-8 left-1/2 group-hover:opacity-100 whitespace-nowrap">
                                                {{ $noteValue >= 10 ? 'Réussite' : 'Insuffisant' }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-2 py-2 text-xs text-gray-600 whitespace-nowrap sm:px-3 sm:py-3 md:px-4 md:py-4">
                                        {{ $note->evaluation->note_max ?? 20 }}
                                    </td>
                                    <td class="px-2 py-2 whitespace-nowrap sm:px-3 sm:py-3 md:px-4 md:py-4">
                                        <span class="inline-flex items-center px-1.5 py-0.5 text-xs font-medium text-gray-700 bg-gray-100 rounded-full sm:px-2 sm:py-1 md:px-3">
                                            <svg class="w-2 h-2 mr-0.5 text-gray-500 sm:w-2.5 sm:h-2.5 sm:mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                                            </svg>
                                            {{ optional($note->evaluation->matiere)->coefficient ?? 1 }}
                                        </span>
                                    </td>
                                    <td class="px-2 py-2 text-xs sm:text-sm text-gray-700 max-w-[150px] sm:max-w-xs md:max-w-sm truncate">
                                        @if($appreciation != '-')
                                            <div class="relative group/appreciation inline-block w-full">
                                                <span class="truncate block italic text-gray-600 cursor-help" title="{{ $appreciation }}">
                                                    "{{ Str::limit($appreciation, 25) }}"
                                                </span>
                                            </div>
                                        @else
                                            <span class="text-gray-400 italic">Pas d'appréciation</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-2 py-6 text-center sm:px-3 sm:py-8 md:px-4 md:py-12">
                                        <div class="relative inline-block animate-float">
                                            <div class="absolute inset-0 bg-blue-300 rounded-full opacity-50 blur-xl"></div>
                                            <svg class="relative w-12 h-12 text-blue-400 sm:w-16 sm:h-16 md:w-20 md:h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                            </svg>
                                        </div>
                                        <p class="mt-2 text-sm text-gray-500 sm:text-base md:text-lg">Aucune note trouvée</p>
                                        <p class="text-xs text-gray-400 sm:text-sm">Commencez par saisir des notes</p>
                                    </td>
                                @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            @if(method_exists($notes, 'links'))
                <div class="p-4 border-t border-gray-100 sm:p-6 bg-gradient-to-r from-gray-50 to-white">
                    {{ $notes->links() }}
                </div>
            @endif
        </div>

        <!-- Graphique d'évolution -->
        @if($notes->count() > 0)
        @php
            $notesData = $notes->sortBy('evaluation.date_evaluation')->take(10);
            $dates = [];
            $values = [];
            $matieres = [];
            
            foreach ($notesData as $note) {
                $dates[] = $note->evaluation->date_evaluation ? \Carbon\Carbon::parse($note->evaluation->date_evaluation)->format('d/m') : 'N/A';
                $values[] = $note->note;
                $matieres[] = $note->evaluation->matiere->nom ?? 'Matière';
            }
        @endphp

        <div class="mt-6 overflow-hidden transition-all duration-500 transform bg-white border border-gray-100 shadow-xl sm:mt-8 rounded-xl sm:rounded-2xl hover:shadow-2xl animate-fade-in-up animation-delay-400">
            <div class="p-4 bg-gradient-to-r from-purple-600 to-pink-600 sm:p-6">
                <div class="flex items-center justify-between">
                    <h3 class="flex items-center text-base font-semibold text-white sm:text-lg">
                        <svg class="w-4 h-4 mr-1 sm:w-5 sm:h-5 sm:mr-2 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        Évolution de vos notes
                    </h3>
                </div>
            </div>
            <div class="p-4 sm:p-6">
                <div class="relative w-full h-64 sm:h-80">
                    <canvas id="notesChart"></canvas>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('notesChart').getContext('2d');
            
            // Créer un dégradé pour le graphique
            const gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, 'rgba(139, 92, 246, 0.8)');
            gradient.addColorStop(1, 'rgba(236, 72, 153, 0.1)');
            
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($dates) !!},
                    datasets: [{
                        label: 'Évolution des notes',
                        data: {!! json_encode($values) !!},
                        borderColor: '#8b5cf6',
                        backgroundColor: gradient,
                        borderWidth: 3,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#8b5cf6',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 8,
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1f2937',
                            titleColor: '#f3f4f6',
                            bodyColor: '#d1d5db',
                            padding: 12,
                            cornerRadius: 8,
                            callbacks: {
                                label: function(context) {
                                    const matieres = {!! json_encode($matieres) !!};
                                    return [
                                        `Note: ${context.raw}/20`,
                                        `Matière: ${matieres[context.dataIndex]}`
                                    ];
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 20,
                            grid: { color: '#e5e7eb' },
                            ticks: { stepSize: 5 }
                        },
                        x: { 
                            grid: { display: false },
                            ticks: {
                                maxRotation: 45,
                                minRotation: 45,
                                font: {
                                    size: window.innerWidth < 640 ? 10 : 12
                                }
                            }
                        }
                    },
                    animation: {
                        duration: 2000,
                        easing: 'easeInOutQuart'
                    }
                }
            });
        });
        </script>
        @endif
    </div>
</div>

<style>
/* Styles pour éviter le débordement horizontal */
* {
    max-width: 100%;
    box-sizing: border-box;
}

body, html {
    overflow-x: hidden;
    width: 100%;
    position: relative;
}

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

/* Dégradés personnalisés */
.bg-gradient-to-r {
    background-image: linear-gradient(to right, var(--tw-gradient-stops));
}

.from-blue-500 { --tw-gradient-from: #3b82f6; }
.to-blue-600 { --tw-gradient-to: #2563eb; }
.from-green-500 { --tw-gradient-from: #10b981; }
.to-green-600 { --tw-gradient-to: #059669; }
.from-purple-500 { --tw-gradient-from: #a855f7; }
.to-purple-600 { --tw-gradient-to: #9333ea; }
.from-indigo-600 { --tw-gradient-from: #4f46e5; }
.to-blue-600 { --tw-gradient-to: #2563eb; }
.from-purple-600 { --tw-gradient-from: #9333ea; }
.to-pink-600 { --tw-gradient-to: #db2777; }

/* Empêcher le débordement horizontal */
.overflow-x-hidden {
    overflow-x: hidden !important;
}

/* Ajustement pour les très petits écrans */
@media (max-width: 480px) {
    .container, .max-w-7xl {
        padding-left: 0.75rem !important;
        padding-right: 0.75rem !important;
    }
    
    /* Forcer le tableau à ne pas déborder */
    .overflow-x-auto {
        overflow-x: auto !important;
        -webkit-overflow-scrolling: touch;
    }
    
    table {
        min-width: 100%;
        width: 100%;
    }
    
    /* Ajuster les tailles de police sur mobile */
    .text-xs {
        font-size: 0.7rem;
    }
    
    /* Réduire les paddings */
    .px-2 {
        padding-left: 0.5rem;
        padding-right: 0.5rem;
    }
    
    .py-2 {
        padding-top: 0.5rem;
        padding-bottom: 0.5rem;
    }
}
</style>

<!-- Alpine.js pour les animations interactives -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endsection