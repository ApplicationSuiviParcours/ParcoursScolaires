@extends('layouts.app')

@section('title', 'Détails de l\'assignation')

@section('header')
<div class="relative overflow-hidden bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 py-12">
    <!-- Éléments décoratifs animés -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-white rounded-full mix-blend-overlay filter blur-3xl animate-pulse"></div>
        <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-indigo-300 rounded-full mix-blend-overlay filter blur-3xl animate-pulse delay-1000"></div>
    </div>
    
    <!-- Particules flottantes -->
    <div class="absolute inset-0 overflow-hidden">
        @for($i = 1; $i <= 4; $i++)
            <div class="absolute w-1 h-1 bg-white rounded-full opacity-30 animate-float-{{ $i }}"
                 style="left: {{ rand(0, 100) }}%; top: {{ rand(0, 100) }}%; animation-delay: {{ rand(0, 5) }}s;"></div>
        @endfor
    </div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div class="text-center md:text-left">
                <nav class="flex mb-4" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ route('admin.classe_matieres.index') }}" class="inline-flex items-center text-sm font-medium text-blue-200 hover:text-white transition-colors duration-300">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                                Matières par classe
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-blue-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                @if($classeMatiere->classe)
                                    <a href="{{ route('admin.classe_matieres.manage', ['classe_id' => $classeMatiere->classe_id]) }}" class="ml-1 text-sm font-medium text-blue-200 hover:text-white md:ml-2 transition-colors duration-300">
                                        {{ $classeMatiere->classe->nom }}
                                    </a>
                                @else
                                    <span class="ml-1 text-sm font-medium text-blue-200 md:ml-2">Classe inconnue</span>
                                @endif
                            </div>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-blue-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="ml-1 text-sm font-medium text-white md:ml-2">
                                    @if($classeMatiere->matiere)
                                        {{ $classeMatiere->matiere->nom }}
                                    @else
                                        Matière inconnue
                                    @endif
                                </span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-3xl md:text-4xl font-bold text-white mb-2 animate-fade-in-up">
                    Détails de l'assignation
                </h1>
                <p class="text-blue-200 text-base md:text-lg animate-fade-in-up animation-delay-200">
                    @if($classeMatiere->classe && $classeMatiere->matiere)
                        {{ $classeMatiere->classe->nom }} - {{ $classeMatiere->matiere->nom }}
                    @elseif($classeMatiere->classe)
                        {{ $classeMatiere->classe->nom }} - Matière non définie
                    @elseif($classeMatiere->matiere)
                        Classe non définie - {{ $classeMatiere->matiere->nom }}
                    @else
                        Informations incomplètes
                    @endif
                </p>
            </div>
            <div class="mt-6 md:mt-0 flex justify-center md:justify-end space-x-3 animate-fade-in-right">
                <a href="{{ route('admin.classe_matieres.edit', $classeMatiere) }}" 
                   class="group relative inline-flex items-center px-5 py-2.5 bg-yellow-500 hover:bg-yellow-600 text-white font-medium rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-xl overflow-hidden">
                    <span class="absolute inset-0 bg-white opacity-0 group-hover:opacity-20 transition-opacity duration-300"></span>
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Modifier
                </a>
                <a href="{{ route('admin.classe_matieres.manage', ['classe_id' => $classeMatiere->classe_id]) }}" 
                   class="group relative inline-flex items-center px-5 py-2.5 bg-white/10 backdrop-blur-lg hover:bg-white/20 text-white font-medium rounded-xl transition-all duration-300 transform hover:scale-105 border border-white/20">
                    <svg class="w-5 h-5 mr-2 transform group-hover:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Retour
                </a>
            </div>
        </div>
    </div>

    <!-- Vague décorative -->
    <div class="absolute bottom-0 left-0 right-0">
        <svg class="fill-current text-gray-50" viewBox="0 0 1440 120">
            <path d="M0,64L80,69.3C160,75,320,85,480,80C640,75,800,53,960,48C1120,43,1280,53,1360,58.7L1440,64L1440,120L1360,120C1280,120,1120,120,960,120C800,120,640,120,480,120C320,120,160,120,80,120L0,120Z"></path>
        </svg>
    </div>
</div>
@endsection

@section('content')
<div class="container mx-auto px-4 py-10 bg-gray-50">
    <div class="max-w-4xl mx-auto">
        <!-- Carte principale -->
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 px-8 py-6">
                <div class="flex items-center">
                    <div class="w-16 h-16 bg-white/20 backdrop-blur-lg rounded-2xl flex items-center justify-center mr-5">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l5 5a2 2 0 01.586 1.414V19a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-white mb-1">Information détaillée</h2>
                        <p class="text-blue-100 text-sm">Assignation #{{ $classeMatiere->id }}</p>
                    </div>
                </div>
            </div>

            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Colonne gauche -->
                    <div class="space-y-6">
                        <!-- Classe -->
                        <div class="bg-gray-50 rounded-2xl p-5">
                            <h3 class="text-sm font-medium text-gray-500 mb-3 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"></path>
                                </svg>
                                Classe
                            </h3>
                            @if($classeMatiere->classe)
                                <div class="flex items-center">
                                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mr-3">
                                        <span class="text-blue-700 font-bold text-lg">{{ substr($classeMatiere->classe->nom, 0, 2) }}</span>
                                    </div>
                                    <div>
                                        <p class="text-lg font-bold text-gray-800">{{ $classeMatiere->classe->nom }}</p>
                                    </div>
                                </div>
                            @else
                                <p class="text-red-500">Classe non trouvée (ID: {{ $classeMatiere->classe_id }})</p>
                            @endif
                        </div>

                        <!-- Matière -->
                        <div class="bg-gray-50 rounded-2xl p-5">
                            <h3 class="text-sm font-medium text-gray-500 mb-3 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                                Matière
                            </h3>
                            @if($classeMatiere->matiere)
                                <div class="flex items-center">
                                    <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center mr-3">
                                        <span class="text-purple-700 font-bold">{{ substr($classeMatiere->matiere->code ?? 'MT', 0, 3) }}</span>
                                    </div>
                                    <div>
                                        <p class="text-lg font-bold text-gray-800">{{ $classeMatiere->matiere->nom }}</p>
                                        <p class="text-sm text-gray-600">Code: {{ $classeMatiere->matiere->code ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            @else
                                <p class="text-red-500">Matière non trouvée (ID: {{ $classeMatiere->matiere_id }})</p>
                            @endif
                        </div>
                    </div>

                    <!-- Colonne droite -->
                    <div class="space-y-6">
                        <!-- Coefficient -->
                        <div class="bg-gray-50 rounded-2xl p-5">
                            <h3 class="text-sm font-medium text-gray-500 mb-3 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                                Coefficient
                            </h3>
                            <div class="text-center">
                                <span class="text-7xl font-bold text-green-600">{{ $classeMatiere->coefficient }}</span>
                                <p class="text-sm text-gray-500 mt-2">Coefficient attribué</p>
                            </div>
                        </div>

                        <!-- Informations système -->
                        <div class="bg-gray-50 rounded-2xl p-5">
                            <h3 class="text-sm font-medium text-gray-500 mb-3 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Informations
                            </h3>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Créé le</span>
                                    <span class="font-medium text-gray-800">{{ $classeMatiere->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Dernière mise à jour</span>
                                    <span class="font-medium text-gray-800">{{ $classeMatiere->updated_at->format('d/m/Y H:i') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">ID</span>
                                    <span class="font-mono text-gray-800">#{{ $classeMatiere->id }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    @keyframes float-1 {
        0%, 100% { transform: translate(0, 0); }
        50% { transform: translate(10px, -10px); }
    }
    
    @keyframes float-2 {
        0%, 100% { transform: translate(0, 0); }
        50% { transform: translate(-15px, 5px); }
    }
    
    @keyframes float-3 {
        0%, 100% { transform: translate(0, 0) scale(1); }
        50% { transform: translate(8px, 8px) scale(1.1); }
    }
    
    @keyframes float-4 {
        0%, 100% { transform: translate(0, 0); }
        50% { transform: translate(-12px, -8px); }
    }
    
    .animate-float-1 { animation: float-1 8s ease-in-out infinite; }
    .animate-float-2 { animation: float-2 10s ease-in-out infinite; }
    .animate-float-3 { animation: float-3 12s ease-in-out infinite; }
    .animate-float-4 { animation: float-4 9s ease-in-out infinite; }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes fadeInRight {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
    
    .animate-fade-in-up {
        animation: fadeInUp 0.8s ease-out forwards;
    }
    
    .animate-fade-in-right {
        animation: fadeInRight 0.8s ease-out forwards;
    }
    
    .animation-delay-200 {
        animation-delay: 200ms;
        opacity: 0;
    }
</style>
@endpush