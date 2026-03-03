@extends('layouts.app')

@section('header')
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
        {{ __('Notes de ') . $eleve->prenom . ' ' . $eleve->nom }}
    </h2>
@endsection

@section('content')
<div class="py-12">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        
        <!-- Header avec design moderne -->
        <div class="relative mb-8 overflow-hidden group rounded-3xl">
            <!-- Fond animé avec dégradé -->
            <div class="absolute inset-0 bg-gradient-to-r from-emerald-600 via-teal-500 to-cyan-600 animate-gradient-xy"></div>
            <div class="absolute inset-0 opacity-20">
                <div class="absolute rounded-full bg-white/30 w-96 h-96 -top-48 -right-48 blur-3xl animate-pulse-slow"></div>
                <div class="absolute rounded-full bg-emerald-300/30 w-96 h-96 -bottom-48 -left-48 blur-3xl animate-pulse-slow animation-delay-2000"></div>
            </div>
            
            <!-- Particules animées -->
            <div class="absolute inset-0">
                @for($i = 0; $i < 15; $i++)
                <div class="absolute w-1 h-1 rounded-full bg-white/60 animate-float-random" 
                     style="left: {{ rand(0, 100) }}%; top: {{ rand(0, 100) }}%; animation-delay: {{ rand(0, 5) }}s;"></div>
                @endfor
            </div>
            
            <div class="relative p-8">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div class="flex items-center space-x-6">
                        <!-- Avatar élève avec effet 3D -->
                        <div class="relative group perspective">
                            <div class="relative transition-all duration-500 transform group-hover:rotate-y-180 preserve-3d">
                                <div class="flex items-center justify-center w-24 h-24 transition-all duration-300 border-4 shadow-2xl bg-white/20 backdrop-blur-xl rounded-2xl border-white/50 group-hover:scale-110 group-hover:shadow-emerald-500/50">
                                    <span class="text-4xl font-bold text-white drop-shadow-lg">
                                        {{ substr($eleve->prenom, 0, 1) }}{{ substr($eleve->nom, 0, 1) }}
                                    </span>
                                </div>
                            </div>
                            <!-- Badge de statut -->
                            <div class="absolute w-5 h-5 bg-green-400 border-4 border-white rounded-full -bottom-1 -right-1 animate-pulse ring-2 ring-emerald-500/50"></div>
                            <!-- Badge moyenne -->
                            @if(isset($stats['moyenne_generale']))
                            <div class="absolute -top-2 -right-2 px-3 py-1.5 text-xs font-bold text-white bg-gradient-to-r from-emerald-500 to-teal-500 rounded-full shadow-lg animate-bounce-subtle">
                                {{ number_format($stats['moyenne_generale'], 1) }}/20
                            </div>
                            @endif
                        </div>
                        
                        <div class="transition-all duration-700 transform animate-slide-in-left">
                            <h3 class="text-4xl font-black tracking-tight text-white drop-shadow-xl">Notes de {{ $eleve->prenom }} {{ $eleve->nom }}</h3>
                            <div class="flex flex-wrap items-center gap-3 mt-3">
                                <!-- Badge classe -->
                                <span class="inline-flex items-center px-4 py-2 text-sm font-medium text-white transition-all border rounded-full bg-white/20 backdrop-blur-sm border-white/30 hover:bg-white/30">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                    {{ $eleve->classe->nom ?? 'Classe non assignée' }}
                                </span>
                                
                                <!-- Badge niveau -->
                                @if($eleve->classe && $eleve->classe->niveau)
                                <span class="inline-flex items-center px-4 py-2 text-sm font-medium text-white transition-all border rounded-full bg-white/20 backdrop-blur-sm border-white/30 hover:bg-white/30">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                    {{ $eleve->classe->niveau }}
                                </span>
                                @endif
                                
                                <!-- Badge nombre de notes -->
                                <span class="inline-flex items-center px-4 py-2 text-sm font-bold text-white border rounded-full bg-emerald-500/80 backdrop-blur-sm border-white/30">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                    {{ $stats['total_notes'] }} note(s)
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Icône flottante -->
                    <div class="hidden transition-all duration-700 transform md:block animate-float-rotate hover:rotate-12 hover:scale-110">
                        <div class="p-5 border-2 shadow-2xl rounded-2xl bg-white/20 backdrop-blur-xl border-white/40">
                            <svg class="w-20 h-20 text-white drop-shadow-xl" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Back Button avec effet moderne -->
        <div class="mb-6">
            <a href="{{ route('parent.enfants') }}" class="group inline-flex items-center px-5 py-2.5 text-gray-700 bg-white/80 backdrop-blur-sm hover:bg-white rounded-xl transition-all duration-300 shadow-md hover:shadow-xl border border-gray-200/50">
                <svg class="w-5 h-5 mr-2 transition-transform group-hover:-translate-x-1 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                <span class="font-medium">Retour à mes enfants</span>
                <span class="ml-2 px-2 py-0.5 text-xs bg-emerald-100 text-emerald-700 rounded-full opacity-0 group-hover:opacity-100 transition-opacity">Tableau de bord</span>
            </a>
        </div>

        <!-- Filtres modernes avec glassmorphism -->
        <div class="mb-8 overflow-hidden transition-all duration-500 border shadow-xl bg-white/90 backdrop-blur-xl border-white/50 rounded-2xl hover:shadow-2xl animate-fade-in-up">
            <div class="p-6 border-b border-gray-100/50 bg-gradient-to-r from-emerald-50/50 to-teal-50/50">
                <div class="flex items-center justify-between">
                    <h3 class="flex items-center text-lg font-semibold text-gray-900">
                        <svg class="w-5 h-5 mr-2 text-emerald-600 animate-spin-slow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                        </svg>
                        Filtrer les notes
                    </h3>
                    <span class="px-3 py-1 text-xs text-gray-500 rounded-full bg-white/50">Recherche avancée</span>
                </div>
            </div>
            <div class="p-6">
                <form method="GET" action="{{ route('parent.enfant.notes', $eleve->id) }}" class="grid grid-cols-1 gap-4 md:grid-cols-5" id="filterForm">
                    <div class="space-y-2">
                        <label class="flex items-center text-sm font-medium text-gray-700">
                            <svg class="w-4 h-4 mr-1 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                            </svg>
                            Matière
                        </label>
                        <select name="matiere_id" class="w-full transition-all border-gray-200 rounded-xl focus:border-emerald-500 focus:ring-emerald-500 hover:border-emerald-300">
                            <option value="">Toutes les matières</option>
                            @foreach($matieres as $matiere)
                                <option value="{{ $matiere->id }}" {{ request('matiere_id') == $matiere->id ? 'selected' : '' }}>
                                    {{ $matiere->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="space-y-2">
                        <label class="flex items-center text-sm font-medium text-gray-700">
                            <svg class="w-4 h-4 mr-1 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Période
                        </label>
                        <select name="periode" class="w-full transition-all border-gray-200 rounded-xl focus:border-emerald-500 focus:ring-emerald-500 hover:border-emerald-300">
                            <option value="">Toutes les périodes</option>
                            @foreach($periodes as $periode)
                                <option value="{{ $periode }}" {{ request('periode') == $periode ? 'selected' : '' }}>
                                    {{ $periode }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="space-y-2">
                        <label class="flex items-center text-sm font-medium text-gray-700">
                            <svg class="w-4 h-4 mr-1 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 8v13H3V8m18 0l-9-5-9 5m18 0H3"></path>
                            </svg>
                            Date début
                        </label>
                        <input type="date" name="date_debut" value="{{ request('date_debut') }}" 
                               class="w-full transition-all border-gray-200 rounded-xl focus:border-emerald-500 focus:ring-emerald-500 hover:border-emerald-300">
                    </div>
                    
                    <div class="space-y-2">
                        <label class="flex items-center text-sm font-medium text-gray-700">
                            <svg class="w-4 h-4 mr-1 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 8v13H3V8m18 0l-9-5-9 5m18 0H3"></path>
                            </svg>
                            Date fin
                        </label>
                        <input type="date" name="date_fin" value="{{ request('date_fin') }}" 
                               class="w-full transition-all border-gray-200 rounded-xl focus:border-emerald-500 focus:ring-emerald-500 hover:border-emerald-300">
                    </div>
                    
                    <div class="flex items-end space-x-2">
                        <a href="{{ route('parent.enfant.notes', $eleve->id) }}" 
                           class="flex-1 px-4 py-3 font-medium text-center text-gray-600 transition-all border bg-gray-100/80 backdrop-blur-sm rounded-xl hover:bg-gray-200 hover:shadow-md border-gray-200/50">
                            <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                        </a>
                        <button type="submit" class="flex-1 px-4 py-3 font-semibold text-white transition-all bg-gradient-to-r from-emerald-500 to-teal-500 rounded-xl hover:from-emerald-600 hover:to-teal-600 hover:shadow-lg hover:scale-105 active:scale-95">
                            <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Stats Cards avec design moderne et animations -->
        <div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-4">
            <!-- Total notes -->
            <div class="relative p-6 overflow-hidden transition-all duration-500 border shadow-xl group bg-white/90 backdrop-blur-xl border-white/50 rounded-2xl hover:shadow-2xl hover:-translate-y-1">
                <div class="absolute inset-0 transition-opacity opacity-0 bg-gradient-to-r from-blue-500/10 to-purple-500/10 group-hover:opacity-100"></div>
                <div class="relative flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total notes</p>
                        <p class="mt-2 text-4xl font-black text-gray-900 transition-colors group-hover:text-blue-600">{{ $stats['total_notes'] }}</p>
                        <p class="mt-1 text-xs text-gray-400">depuis la rentrée</p>
                    </div>
                    <div class="p-4 transition-transform shadow-lg bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl group-hover:scale-110">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                </div>
                <div class="absolute bottom-0 left-0 w-full h-1 transition-transform origin-left transform scale-x-0 bg-gradient-to-r from-blue-500 to-purple-500 group-hover:scale-x-100"></div>
            </div>

            <!-- Moyenne générale -->
            <div class="relative p-6 overflow-hidden transition-all duration-500 border shadow-xl group bg-white/90 backdrop-blur-xl border-white/50 rounded-2xl hover:shadow-2xl hover:-translate-y-1">
                <div class="absolute inset-0 transition-opacity opacity-0 bg-gradient-to-r from-emerald-500/10 to-teal-500/10 group-hover:opacity-100"></div>
                <div class="relative flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Moyenne générale</p>
                        <p class="mt-2 text-4xl font-black {{ $stats['moyenne_generale'] >= 10 ? 'text-emerald-600' : 'text-red-500' }} group-hover:scale-110 transition-transform origin-left">
                            {{ number_format($stats['moyenne_generale'], 2) }}
                        </p>
                        <p class="mt-1 text-xs text-gray-400">sur 20</p>
                    </div>
                    <div class="p-4 transition-transform shadow-lg bg-gradient-to-br from-emerald-500 to-teal-500 rounded-2xl group-hover:scale-110">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Meilleure note -->
            <div class="relative p-6 overflow-hidden transition-all duration-500 border shadow-xl group bg-white/90 backdrop-blur-xl border-white/50 rounded-2xl hover:shadow-2xl hover:-translate-y-1">
                <div class="absolute inset-0 transition-opacity opacity-0 bg-gradient-to-r from-purple-500/10 to-pink-500/10 group-hover:opacity-100"></div>
                <div class="relative flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Meilleure note</p>
                        <p class="mt-2 text-4xl font-black text-purple-600 transition-transform group-hover:scale-110">{{ number_format($stats['note_max'], 2) }}</p>
                        <p class="mt-1 text-xs text-gray-400">/20</p>
                    </div>
                    <div class="p-4 transition-transform shadow-lg bg-gradient-to-br from-purple-500 to-pink-500 rounded-2xl group-hover:scale-110">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Note minimale -->
            <div class="relative p-6 overflow-hidden transition-all duration-500 border shadow-xl group bg-white/90 backdrop-blur-xl border-white/50 rounded-2xl hover:shadow-2xl hover:-translate-y-1">
                <div class="absolute inset-0 transition-opacity opacity-0 bg-gradient-to-r from-red-500/10 to-orange-500/10 group-hover:opacity-100"></div>
                <div class="relative flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Note minimale</p>
                        <p class="mt-2 text-4xl font-black text-red-500 transition-transform group-hover:scale-110">{{ number_format($stats['note_min'], 2) }}</p>
                        <p class="mt-1 text-xs text-gray-400">/20</p>
                    </div>
                    <div class="p-4 transition-transform shadow-lg bg-gradient-to-br from-red-500 to-orange-500 rounded-2xl group-hover:scale-110">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table des notes avec design moderne -->
        <div class="overflow-hidden border shadow-xl bg-white/90 backdrop-blur-xl border-white/50 rounded-2xl">
            <div class="p-6 bg-gradient-to-r from-emerald-600 via-teal-500 to-cyan-600">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-bold text-white drop-shadow-md">📋 Liste des notes</h3>
                    <div class="flex items-center space-x-3">
                        <span class="px-4 py-2 text-sm font-bold text-white border rounded-full bg-white/20 backdrop-blur-sm border-white/30">
                            {{ $stats['total_notes'] }} note(s)
                        </span>
                        <button onclick="window.print()" class="p-2 text-white transition-all rounded-lg bg-white/20 backdrop-blur-sm hover:bg-white/30">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100/80">
                        <tr>
                            <th class="px-6 py-5 text-xs font-bold tracking-wider text-left text-gray-600 uppercase">Date</th>
                            <th class="px-6 py-5 text-xs font-bold tracking-wider text-left text-gray-600 uppercase">Matière</th>
                            <th class="px-6 py-5 text-xs font-bold tracking-wider text-left text-gray-600 uppercase">Type</th>
                            <th class="px-6 py-5 text-xs font-bold tracking-wider text-left text-gray-600 uppercase">Note</th>
                            <th class="px-6 py-5 text-xs font-bold tracking-wider text-left text-gray-600 uppercase">Coeff.</th>
                            <th class="px-6 py-5 text-xs font-bold tracking-wider text-left text-gray-600 uppercase">Appréciation</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($notes as $note)
                            @php
                                $noteValue = $note->note;
                                $noteClass = $noteValue >= 16 ? 'from-green-500 to-emerald-500' : 
                                            ($noteValue >= 14 ? 'from-blue-500 to-cyan-500' : 
                                            ($noteValue >= 10 ? 'from-yellow-500 to-orange-500' : 
                                            'from-red-500 to-rose-500'));
                                
                                $noteBgClass = $noteValue >= 16 ? 'bg-green-100 text-green-800 border-green-200' : 
                                              ($noteValue >= 14 ? 'bg-blue-100 text-blue-800 border-blue-200' : 
                                              ($noteValue >= 10 ? 'bg-yellow-100 text-yellow-800 border-yellow-200' : 
                                              'bg-red-100 text-red-800 border-red-200'));
                                
                                // Récupération de l'appréciation
                                $appreciation = '-';
                                if (!empty($note->appreciation)) {
                                    $appreciation = $note->appreciation;
                                } elseif (!empty($note->evaluation) && !empty($note->evaluation->appreciation)) {
                                    $appreciation = $note->evaluation->appreciation;
                                } elseif (!empty($note->evaluation) && !empty($note->evaluation->commentaire)) {
                                    $appreciation = $note->evaluation->commentaire;
                                }
                            @endphp
                            <tr class="transition-all duration-300 cursor-pointer group hover:bg-gradient-to-r hover:from-emerald-50/50 hover:to-teal-50/50">
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-2 h-2 mr-3 rounded-full bg-emerald-500 group-hover:animate-pulse"></div>
                                        <span class="font-medium text-gray-700">
                                            {{ $note->evaluation->date_evaluation ? \Carbon\Carbon::parse($note->evaluation->date_evaluation)->format('d M Y') : '-' }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex items-center">
                                        <div class="flex items-center justify-center w-10 h-10 mr-3 transition-transform shadow-lg bg-gradient-to-br from-emerald-500 to-teal-500 rounded-xl group-hover:scale-110">
                                            <span class="text-sm font-bold text-white">{{ $note->evaluation && $note->evaluation->matiere ? substr($note->evaluation->matiere->nom, 0, 3) : 'MAT' }}</span>
                                        </div>
                                        <span class="font-semibold text-gray-800">{{ $note->evaluation && $note->evaluation->matiere ? $note->evaluation->matiere->nom : '-' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <span class="px-3 py-1.5 text-xs font-semibold text-purple-700 bg-purple-100 rounded-full border border-purple-200">
                                        {{ $note->evaluation->type ?? 'Évaluation' }}
                                    </span>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="relative inline-block">
                                        <span class="px-5 py-2.5 text-sm font-black rounded-xl bg-gradient-to-r {{ $noteClass }} text-white shadow-lg group-hover:shadow-xl transition-all">
                                            {{ number_format($noteValue, 2) }}/20
                                        </span>
                                        <span class="absolute w-3 h-3 bg-green-400 border-2 border-white rounded-full -top-2 -right-2 animate-pulse"></span>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <span class="px-4 py-2 text-sm font-bold text-orange-700 bg-orange-100 border border-orange-200 rounded-full">
                                        x{{ $note->evaluation->coefficient ?? 1 }}
                                    </span>
                                </td>
                                <td class="max-w-xs px-6 py-5">
                                    @if($appreciation != '-')
                                        <div class="relative group/tooltip">
                                            <div class="flex items-center space-x-2">
                                                <svg class="flex-shrink-0 w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                                                </svg>
                                                <span class="italic font-medium text-gray-700 truncate transition-colors group-hover:text-emerald-600">
                                                    "{{ Str::limit($appreciation, 40) }}"
                                                </span>
                                            </div>
                                            <div class="absolute left-0 z-10 hidden w-64 p-3 mb-2 text-sm text-white bg-gray-900 rounded-lg shadow-xl bottom-full group-hover/tooltip:block">
                                                {{ $appreciation }}
                                            </div>
                                        </div>
                                    @else
                                        <span class="flex items-center text-gray-400">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                                            </svg>
                                            Pas d'appréciation
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-24 h-24 mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                        </svg>
                                        <p class="mb-2 text-xl font-medium text-gray-500">Aucune note trouvée</p>
                                        <p class="text-gray-400">Essayez de modifier vos filtres ou de revenir plus tard</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(method_exists($notes, 'links'))
            <div class="p-6 border-t border-gray-100 bg-gradient-to-r from-gray-50 to-gray-100/50">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-gray-600">
                        Affichage de <span class="font-semibold">{{ $notes->firstItem() ?? 0 }}</span> 
                        à <span class="font-semibold">{{ $notes->lastItem() ?? 0 }}</span> 
                        sur <span class="font-semibold">{{ $notes->total() }}</span> notes
                    </p>
                    <div class="flex space-x-2">
                        {{ $notes->links() }}
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Graphique de progression (optionnel) -->
        @if($stats['total_notes'] > 5)
        <div class="mt-8 overflow-hidden border shadow-xl bg-white/90 backdrop-blur-xl border-white/50 rounded-2xl">
            <div class="p-6 bg-gradient-to-r from-indigo-600 to-purple-600">
                <h3 class="text-lg font-semibold text-white">📈 Progression des notes</h3>
            </div>
            <div class="p-6">
                <div class="flex items-end h-64 space-x-2">
                    @php
                        $recentNotes = $notes->take(10)->reverse();
                        $maxNote = $recentNotes->max('note') ?: 20;
                    @endphp
                    @foreach($recentNotes as $index => $note)
                        @php
                            $height = ($note->note / 20) * 100;
                            $color = $note->note >= 16 ? 'bg-gradient-to-t from-green-400 to-green-500' :
                                    ($note->note >= 14 ? 'bg-gradient-to-t from-blue-400 to-blue-500' :
                                    ($note->note >= 10 ? 'bg-gradient-to-t from-yellow-400 to-yellow-500' :
                                    'bg-gradient-to-t from-red-400 to-red-500'));
                        @endphp
                        <div class="flex flex-col items-center flex-1 group">
                            <div class="relative w-full">
                                <div class="w-full h-64 overflow-hidden bg-gray-100 rounded-t-lg">
                                    <div class="{{ $color }} transition-all duration-500 group-hover:opacity-80" 
                                         style="height: {{ $height }}%; width: 100%;"></div>
                                </div>
                                <div class="absolute px-2 py-1 text-xs text-white transition-opacity transform -translate-x-1/2 bg-gray-900 rounded opacity-0 -top-8 left-1/2 group-hover:opacity-100 whitespace-nowrap">
                                    {{ number_format($note->note, 2) }}/20
                                </div>
                            </div>
                            <span class="mt-2 text-xs text-gray-600">{{ $index + 1 }}</span>
                        </div>
                    @endforeach
                </div>
                <p class="mt-4 text-sm text-center text-gray-500">Dernières 10 notes (ordre chronologique inverse)</p>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Styles CSS supplémentaires -->
<style>
@keyframes gradient-xy {
    0%, 100% { background-position: 0% 50%; }
    25% { background-position: 50% 100%; }
    50% { background-position: 100% 50%; }
    75% { background-position: 50% 0%; }
}

@keyframes bounce-subtle {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-3px); }
}

@keyframes float-rotate {
    0%, 100% { transform: translateY(0) rotate(0deg); }
    50% { transform: translateY(-10px) rotate(5deg); }
}

.animate-gradient-xy {
    background-size: 300% 300%;
    animation: gradient-xy 15s ease infinite;
}

.animate-bounce-subtle {
    animation: bounce-subtle 2s ease-in-out infinite;
}

.animate-float-rotate {
    animation: float-rotate 6s ease-in-out infinite;
}

.preserve-3d {
    transform-style: preserve-3d;
}

.hover\:rotate-y-180:hover {
    transform: rotateY(180deg);
}

.perspective {
    perspective: 1000px;
}

@keyframes float-random {
    0%, 100% { transform: translate(0, 0); }
    25% { transform: translate(15px, -15px); }
    50% { transform: translate(-15px, 10px); }
    75% { transform: translate(10px, 15px); }
}

.animate-float-random {
    animation: float-random 12s ease-in-out infinite;
}

/* Personnalisation de la pagination */
.pagination {
    display: flex;
    gap: 0.5rem;
}

.pagination .page-link {
    padding: 0.5rem 1rem;
    border-radius: 0.75rem;
    background: white;
    color: #374151;
    font-weight: 500;
    transition: all 0.3s;
    border: 1px solid #e5e7eb;
}

.pagination .page-link:hover {
    background: #10b981;
    color: white;
    border-color: #10b981;
    transform: scale(1.05);
}

.pagination .active .page-link {
    background: #10b981;
    color: white;
    border-color: #10b981;
}

/* Styles pour l'impression */
@media print {
    .no-print {
        display: none !important;
    }
    body {
        background: white;
    }
    .bg-gradient-to-r {
        background: #f3f4f6 !important;
        color: black !important;
    }
    .text-white {
        color: black !important;
    }
}
</style>

<!-- Alpine.js pour l'interactivité -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<!-- Script pour les animations supplémentaires -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animation des cartes au scroll
    const cards = document.querySelectorAll('.group');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-fade-in-up');
            }
        });
    }, { threshold: 0.1 });

    cards.forEach(card => observer.observe(card));

    // Tooltips dynamiques pour les appréciations longues
    const appreciations = document.querySelectorAll('.max-w-xs .group');
    appreciations.forEach(app => {
        app.addEventListener('mouseenter', function() {
            const tooltip = this.querySelector('.hidden');
            if (tooltip) {
                tooltip.classList.remove('hidden');
            }
        });
        app.addEventListener('mouseleave', function() {
            const tooltip = this.querySelector('.hidden');
            if (tooltip) {
                tooltip.classList.add('hidden');
            }
        });
    });
});
</script>
@endsection