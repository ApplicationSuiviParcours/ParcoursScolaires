@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-sm text-gray-800 leading-tight">
        <a href="{{ route('enseignant.notes.index') }}" class="text-gray-500 hover:text-indigo-600 transition-colors mr-2">Notes</a> 
        <span class="text-gray-300">/</span> 
        <span class="text-indigo-600 ml-2">{{ __('Détails de la Note') }}</span>
    </h2>
@endsection

@section('content')
<div class="py-12 bg-gradient-to-br from-indigo-50 via-white to-purple-50 min-h-screen">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        
        <div class="bg-white/80 backdrop-blur-xl overflow-hidden shadow-2xl sm:rounded-3xl border border-white/50">
            
            <!-- Header avec actions -->
            <div class="px-8 py-6 border-b border-gray-100 flex flex-col md:flex-row md:justify-between md:items-center gap-4 bg-gradient-to-r from-gray-50/80 to-white">
                <h3 class="text-xl font-extrabold text-gray-900 flex items-center">
                    <div class="bg-indigo-100 p-2.5 rounded-xl mr-3 text-indigo-600 shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    Informations sur la Note
                </h3>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('enseignant.notes.edit', $note->id) }}" class="inline-flex items-center px-4 py-2.5 bg-white text-indigo-700 hover:bg-indigo-50 border border-indigo-200 rounded-xl text-sm font-bold shadow-sm transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Éditer
                    </a>
                    <form action="{{ route('enseignant.notes.destroy', $note->id) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette note de manière définitive ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center px-4 py-2.5 bg-red-50 text-red-700 hover:bg-red-600 hover:text-white border border-red-200 hover:border-red-600 rounded-xl text-sm font-bold shadow-sm transition-all duration-300">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Supprimer
                        </button>
                    </form>
                </div>
            </div>

            <!-- Content Area -->
            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    
                    <!-- Colonne 1 : Détails Élève & Note -->
                    <div class="space-y-6">
                        <div>
                            <h4 class="text-xs uppercase tracking-widest text-indigo-500 font-extrabold mb-5 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                Profil de l'Élève & Évaluation
                            </h4>
                            <div class="bg-gray-50 border border-gray-100 rounded-2xl p-6 shadow-inner space-y-5">
                                
                                <div class="flex items-start">
                                    <div class="bg-white p-2 rounded-lg shadow-sm mr-4 text-gray-400">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    </div>
                                    <div>
                                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-0.5">Élève & Matricule</p>
                                        <p class="text-lg text-gray-900 font-bold leading-tight">{{ $note->eleve->prenom }} {{ $note->eleve->nom }}</p>
                                        <p class="text-sm text-indigo-600 font-semibold mt-0.5">{{ $note->eleve->matricule }}</p>
                                    </div>
                                </div>
                                
                                <div class="border-t border-gray-200/60 my-2"></div>
                                
                                <div class="flex items-start">
                                    <div class="bg-white p-2 rounded-lg shadow-sm mr-4 text-gray-400">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                    </div>
                                    <div>
                                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-0.5">Classe</p>
                                        <p class="text-base text-gray-900 font-bold">{{ $note->eleve->classe->nom ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                
                                <div class="border-t border-gray-200/60 my-2"></div>
                                
                                <div class="flex items-start">
                                    <div class="bg-white p-2 rounded-lg shadow-sm mr-4 text-gray-400">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    </div>
                                    <div>
                                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-0.5">Évaluation</p>
                                        <div class="flex items-center gap-2 mt-0.5">
                                            <p class="text-base text-gray-900 font-bold">{{ $note->evaluation->nom }}</p>
                                            <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-indigo-100 text-indigo-800 border border-indigo-200 shadow-sm">
                                                {{ ucfirst($note->evaluation->type) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="border-t border-gray-200/60 my-2"></div>
                                
                                <div class="flex items-start">
                                    <div class="bg-white p-2 rounded-lg shadow-sm mr-4 text-gray-400">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                    </div>
                                    <div>
                                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-0.5">Matière</p>
                                        <p class="text-base text-gray-900 font-bold">{{ $note->evaluation->matiere->nom }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Colonne 2 : Résultat -->
                    <div class="space-y-6">
                        <h4 class="text-xs uppercase tracking-widest text-indigo-500 font-extrabold mb-5 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                            Bilan et Résultat
                        </h4>
                        
                        <div class="relative overflow-hidden group">
                            <!-- Background glow effect behind card -->
                            <div class="absolute -inset-1 bg-gradient-to-r {{ $note->note >= 10 ? 'from-green-400 to-emerald-500' : 'from-red-400 to-rose-500' }} rounded-3xl blur opacity-30 group-hover:opacity-60 transition duration-500"></div>
                            
                            <div class="relative bg-white rounded-2xl p-8 text-center border-2 {{ $note->note >= 10 ? 'border-green-100' : 'border-red-100' }} shadow-xl">
                                
                                <div class="inline-flex items-center justify-center p-3 mb-4 rounded-full {{ $note->note >= 10 ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                                    @if($note->note >= 10)
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                                    @else
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    @endif
                                </div>
                                
                                <span class="block text-sm font-bold text-gray-500 uppercase tracking-wider mb-2">Note Finale de l'élève</span>
                                
                                <div class="flex items-baseline justify-center">
                                    <span class="text-7xl font-black tracking-tight {{ $note->note >= 10 ? 'text-transparent bg-clip-text bg-gradient-to-r from-green-500 to-emerald-700' : 'text-transparent bg-clip-text bg-gradient-to-r from-red-500 to-rose-700' }}">
                                        {{ $note->note }}
                                    </span>
                                    <span class="text-3xl text-gray-400 font-bold ml-1">/{{ $note->evaluation->bareme ?? 20 }}</span>
                                </div>
                                
                                <div class="mt-6">
                                    <span class="inline-block px-4 py-1.5 rounded-full text-sm font-bold {{ $note->note >= 10 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $note->note >= 10 ? 'Note Satisfaisante' : 'À Améliorer' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div>
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2.5">Observation / Appréciation Rédigée</p>
                            <div class="relative group">
                                <div class="absolute -inset-0.5 bg-gradient-to-r from-gray-200 to-gray-300 rounded-2xl opacity-50 group-hover:opacity-100 transition duration-300 blur-sm"></div>
                                <div class="relative bg-white p-6 rounded-2xl shadow-sm min-h-[140px]">
                                    @if($note->observation)
                                        <p class="text-base text-gray-800 leading-relaxed italic border-l-4 border-indigo-200 pl-4 py-1">"{{ $note->observation }}"</p>
                                    @else
                                        <div class="flex flex-col items-center justify-center h-full text-gray-400 space-y-3">
                                            <svg class="w-8 h-8 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                            <span class="text-sm">Aucune observation n'a été rattachée à cette note.</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-12 pt-6 flex justify-center">
                    <a href="{{ route('enseignant.notes.index') }}" class="group relative inline-flex items-center px-8 py-3 bg-gray-900 border border-transparent rounded-xl text-base font-bold text-white hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900 shadow-xl shadow-gray-900/20 transform hover:-translate-y-0.5 transition-all duration-300">
                        <svg class="w-5 h-5 mr-3 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Retour 
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
