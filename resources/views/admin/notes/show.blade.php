@extends('layouts.app')

@section('title', 'Détails de la note')

@section('header')
<div class="relative overflow-hidden bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 py-8 md:py-12">
    <!-- Éléments décoratifs animés -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-white rounded-full mix-blend-overlay filter blur-3xl animate-pulse"></div>
        <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-indigo-300 rounded-full mix-blend-overlay filter blur-3xl animate-pulse delay-1000"></div>
    </div>
    
    <!-- Particules flottantes (masquées sur mobile) -->
    <div class="absolute inset-0 overflow-hidden hidden sm:block">
        @for($i = 1; $i <= 4; $i++)
            <div class="absolute w-1 h-1 bg-white rounded-full opacity-30 animate-float-{{ $i }}"
                 style="left: {{ rand(0, 100) }}%; top: {{ rand(0, 100) }}%; animation-delay: {{ rand(0, 5) }}s;"></div>
        @endfor
    </div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div class="text-center md:text-left mb-6 md:mb-0">
                <nav class="flex mb-4 justify-center md:justify-start" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ route('admin.notes.index') }}" class="inline-flex items-center text-sm font-medium text-blue-200 hover:text-white transition-colors duration-300">
                                <svg class="w-4 h-4 mr-1 md:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                                <span class="hidden sm:inline">Notes</span>
                                <span class="sm:hidden">Liste</span>
                            </a>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 md:w-6 md:h-6 text-blue-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="ml-1 text-sm font-medium text-white md:ml-2">Détails</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-white mb-2 animate-fade-in-up">
                    Détails de la note
                </h1>
                <p class="text-blue-200 text-sm md:text-base animate-fade-in-up animation-delay-200 truncate px-4 md:px-0">
                    {{ $note->eleve->nom }} {{ $note->eleve->prenom }} - {{ $note->evaluation->matiere->nom ?? 'N/A' }}
                </p>
            </div>
            <div class="flex flex-col sm:flex-row justify-center md:justify-end space-y-3 sm:space-y-0 sm:space-x-3 animate-fade-in-right">
                <a href="{{ route('admin.notes.edit', $note) }}" 
                   class="group relative inline-flex items-center justify-center px-4 py-2.5 md:px-5 bg-yellow-500 hover:bg-yellow-600 text-white font-medium rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-xl overflow-hidden text-sm">
                    <span class="absolute inset-0 bg-white opacity-0 group-hover:opacity-20 transition-opacity duration-300"></span>
                    <svg class="w-5 h-5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    <span class="hidden sm:inline">Modifier</span>
                </a>
                <a href="{{ route('admin.notes.index') }}" 
                   class="group relative inline-flex items-center justify-center px-4 py-2.5 md:px-5 bg-white/10 backdrop-blur-lg hover:bg-white/20 text-white font-medium rounded-xl transition-all duration-300 transform hover:scale-105 border border-white/20 text-sm">
                    <svg class="w-5 h-5 sm:mr-2 transform group-hover:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    <span class="hidden sm:inline">Retour</span>
                    <span class="sm:hidden">Liste</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Vague décorative -->
    <div class="absolute bottom-0 left-0 right-0">
        <svg class="fill-current text-gray-50" viewBox="0 0 1440 120" preserveAspectRatio="none">
            <path d="M0,64L80,69.3C160,75,320,85,480,80C640,75,800,53,960,48C1120,43,1280,53,1360,58.7L1440,64L1440,120L1360,120C1280,120,1120,120,960,120C800,120,640,120,480,120C320,120,160,120,80,120L0,120Z"></path>
        </svg>
    </div>
</div>
@endsection

@section('content')
<div class="container mx-auto px-4 py-6 md:py-10 bg-gray-50">
    <div class="max-w-4xl mx-auto">
        <!-- Carte principale -->
        <div class="bg-white rounded-2xl md:rounded-3xl shadow-xl overflow-hidden mb-6 md:mb-8">
            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 px-4 md:px-8 py-4 md:py-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 md:w-16 md:h-16 bg-white/20 backdrop-blur-lg rounded-xl md:rounded-2xl flex items-center justify-center mr-4 md:mr-5 flex-shrink-0">
                        <svg class="w-6 h-6 md:w-8 md:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <h2 class="text-xl md:text-2xl font-bold text-white mb-1 truncate">Information détaillée</h2>
                        <p class="text-blue-100 text-xs md:text-sm">Note #{{ $note->id }}</p>
                    </div>
                </div>
            </div>

            <div class="p-4 md:p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8">
                    <!-- Colonne gauche -->
                    <div class="space-y-4 md:space-y-6">
                        <!-- Élève -->
                        <div class="bg-gray-50 rounded-xl md:rounded-2xl p-4 md:p-5">
                            <h3 class="text-xs md:text-sm font-medium text-gray-500 mb-3 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Élève
                            </h3>
                            <div class="flex flex-col sm:flex-row items-center text-center sm:text-left">
                                <div class="flex-shrink-0 h-12 w-12 md:h-14 md:w-14 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center text-white font-bold text-lg md:text-xl shadow-lg mb-3 sm:mb-0 sm:mr-4">
                                    {{ strtoupper(substr($note->eleve->prenom, 0, 1)) }}{{ strtoupper(substr($note->eleve->nom, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="text-base md:text-lg font-bold text-gray-800">{{ $note->eleve->nom }} {{ $note->eleve->prenom }}</p>
                                    <p class="text-xs md:text-sm text-gray-600">Matricule: {{ $note->eleve->matricule ?? 'N/A' }}</p>
                                    <p class="text-xs md:text-sm text-gray-600 hidden sm:block">Né(e) le: {{ $note->eleve->date_naissance?->format('d/m/Y') ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Évaluation -->
                        <div class="bg-gray-50 rounded-xl md:rounded-2xl p-4 md:p-5">
                            <h3 class="text-xs md:text-sm font-medium text-gray-500 mb-3 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Évaluation
                            </h3>
                            <div class="space-y-1 text-xs md:text-sm">
                                <p><span class="font-medium">Nom:</span> {{ $note->evaluation->nom }}</p>
                                <p><span class="font-medium">Type:</span> {{ ucfirst($note->evaluation->type) }}</p>
                                <p><span class="font-medium">Date:</span> {{ $note->evaluation->date_evaluation->format('d/m/Y') }}</p>
                                <p><span class="font-medium">Coef.:</span> {{ $note->evaluation->coefficient ?? 1 }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Colonne droite -->
                    <div class="space-y-4 md:space-y-6">
                        <!-- Matière -->
                        <div class="bg-gray-50 rounded-xl md:rounded-2xl p-4 md:p-5">
                            <h3 class="text-xs md:text-sm font-medium text-gray-500 mb-3 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                                Matière
                            </h3>
                            <div class="flex items-center">
                                <div class="w-10 h-10 md:w-12 md:h-12 bg-purple-100 rounded-lg md:rounded-xl flex items-center justify-center mr-3 flex-shrink-0">
                                    <span class="text-purple-700 font-bold text-sm md:text-base">{{ substr($note->evaluation->matiere->code ?? 'MT', 0, 3) }}</span>
                                </div>
                                <div class="min-w-0">
                                    <p class="font-bold text-gray-800 truncate">{{ $note->evaluation->matiere->nom ?? 'N/A' }}</p>
                                    <p class="text-xs md:text-sm text-gray-600 truncate">Code: {{ $note->evaluation->matiere->code ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Note et résultat -->
                        <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl md:rounded-2xl p-4 md:p-6 text-center">
                            <span class="text-xs md:text-sm text-gray-500">Note obtenue</span>
                            <div class="text-5xl md:text-7xl font-bold my-2 md:my-4 {{ $note->note >= 10 ? 'text-green-600' : 'text-red-600' }}">
                                {{ number_format($note->note, 2) }}
                                <span class="text-xl md:text-3xl text-gray-400">/20</span>
                            </div>
                            
                            @php
                                $appreciation = $note->observation ?? $note->appreciation_auto;
                            @endphp
                            <div class="inline-block px-4 md:px-6 py-2 md:py-3 rounded-full text-sm md:text-lg font-medium {{ $note->note >= 16 ? 'bg-green-100 text-green-700' : ($note->note >= 14 ? 'bg-blue-100 text-blue-700' : ($note->note >= 10 ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700')) }}">
                                {{ $appreciation }}
                            </div>
                        </div>

                        <!-- Observation -->
                        @if($note->observation)
                        <div class="bg-amber-50 rounded-xl md:rounded-2xl p-4 md:p-5 border border-amber-200">
                            <h3 class="text-xs md:text-sm font-medium text-amber-800 mb-2 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                                </svg>
                                Observation
                            </h3>
                            <p class="text-amber-700 text-sm">{{ $note->observation }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Informations système -->
                <div class="mt-6 md:mt-8 pt-4 md:pt-6 border-t border-gray-200">
                    <h4 class="text-xs md:text-sm font-medium text-gray-700 mb-4 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Informations système
                    </h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs md:text-sm">
                        <div>
                            <span class="text-gray-500">Créé le</span>
                            <p class="font-medium text-gray-800">{{ $note->created_at->format('d/m/Y à H:i:s') }}</p>
                        </div>
                        <div>
                            <span class="text-gray-500">Dernière mise à jour</span>
                            <p class="font-medium text-gray-800">{{ $note->updated_at->format('d/m/Y à H:i:s') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Zone de danger (suppression) -->
        <div class="bg-white rounded-2xl md:rounded-3xl shadow-xl overflow-hidden border-l-4 md:border-l-8 border-red-500">
            <div class="bg-gradient-to-r from-red-50 to-red-100 px-4 md:px-8 py-4 md:py-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 md:w-14 md:h-14 bg-red-500 rounded-xl md:rounded-2xl flex items-center justify-center mr-4 md:mr-5 flex-shrink-0">
                        <svg class="w-6 h-6 md:w-7 md:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg md:text-xl font-bold text-red-800 mb-1">Zone de danger</h3>
                        <p class="text-red-600 text-xs md:text-sm">Actions irréversibles</p>
                    </div>
                </div>
            </div>
            
            <div class="p-4 md:p-8">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                    <div class="flex-1">
                        <h4 class="text-base md:text-lg font-semibold text-gray-800 mb-2">Supprimer cette note</h4>
                        <p class="text-gray-600 text-xs md:text-sm leading-relaxed">
                            Une fois supprimée, cette note sera définitivement effacée. 
                            Cette action est irréversible.
                        </p>
                        <div class="mt-3 flex items-center text-xs text-gray-500">
                            <svg class="w-4 h-4 mr-1 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                            ID : <span class="font-mono ml-1">#{{ $note->id }}</span>
                        </div>
                    </div>
                    
                    <div class="w-full md:w-auto">
                        <form action="{{ route('admin.notes.destroy', $note) }}" 
                              method="POST" 
                              onsubmit="return confirm('Êtes-vous absolument sûr de vouloir supprimer cette note ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="w-full md:w-auto px-6 py-2.5 md:py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-xl text-sm md:text-base">
                                <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Supprimer
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Animations */
    @keyframes float-1 { 0%, 100% { transform: translate(0, 0); } 50% { transform: translate(10px, -10px); } }
    @keyframes float-2 { 0%, 100% { transform: translate(0, 0); } 50% { transform: translate(-15px, 5px); } }
    @keyframes float-3 { 0%, 100% { transform: translate(0, 0) scale(1); } 50% { transform: translate(8px, 8px) scale(1.1); } }
    @keyframes float-4 { 0%, 100% { transform: translate(0, 0); } 50% { transform: translate(-12px, -8px); } }
    
    .animate-float-1 { animation: float-1 8s ease-in-out infinite; }
    .animate-float-2 { animation: float-2 10s ease-in-out infinite; }
    .animate-float-3 { animation: float-3 12s ease-in-out infinite; }
    .animate-float-4 { animation: float-4 9s ease-in-out infinite; }
    
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes fadeInRight { from { opacity: 0; transform: translateX(-20px); } to { opacity: 1; transform: translateX(0); } }
    
    .animate-fade-in-up { animation: fadeInUp 0.8s ease-out forwards; }
    .animate-fade-in-right { animation: fadeInRight 0.8s ease-out forwards; }
    .animation-delay-200 { animation-delay: 200ms; opacity: 0; }
</style>
@endpush