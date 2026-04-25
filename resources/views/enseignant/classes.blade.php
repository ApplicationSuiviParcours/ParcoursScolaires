@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-sm text-gray-800 leading-tight">
        {{ __('Mes Classes') }}
    </h2>
@endsection

@section('content')
<div class="py-6 sm:py-12">
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-700 to-blue-500 rounded-lg sm:rounded-xl shadow-lg mb-6 sm:mb-8 p-4 sm:p-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h3 class="text-xl sm:text-2xl font-bold text-white">Mes Classes</h3>
                    <p class="text-blue-100 text-sm sm:text-base mt-0.5 sm:mt-1">Gérer mes classes et matières</p>
                </div>
                <div class="hidden md:block">
                    <div class="bg-white/20 rounded-full p-3 sm:p-4">
                        <svg class="w-8 h-8 sm:w-10 sm:h-10 md:w-12 md:h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mb-6 sm:mb-8">
            <div class="bg-white rounded-lg sm:rounded-xl shadow-md p-4 sm:p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs sm:text-sm font-medium text-gray-500">Nombre de classes</p>
                        <p class="text-2xl sm:text-3xl font-bold text-gray-900 mt-1">
                            {{ $classes->pluck('classe.id')->unique()->count() }}
                        </p>
                    </div>
                    <div class="bg-blue-100 rounded-full p-2 sm:p-3">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 md:w-8 md:h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg sm:rounded-xl shadow-md p-4 sm:p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs sm:text-sm font-medium text-gray-500">Matières enseignées</p>
                        <p class="text-2xl sm:text-3xl font-bold text-gray-900 mt-1">
                            {{ $classes->pluck('matiere.id')->unique()->count() }}
                        </p>
                    </div>
                    <div class="bg-green-100 rounded-full p-2 sm:p-3">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 md:w-8 md:h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg sm:rounded-xl shadow-md p-4 sm:p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs sm:text-sm font-medium text-gray-500">Année scolaire</p>
                        <p class="text-2xl sm:text-3xl font-bold text-gray-900 mt-1">
                            {{ $classes->first()->anneeScolaire->nom ?? '-' }}
                        </p>
                    </div>
                    <div class="bg-purple-100 rounded-full p-2 sm:p-3">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 md:w-8 md:h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Classes Table -->
        <div class="bg-white rounded-lg sm:rounded-xl shadow-md overflow-hidden">
            <div class="p-4 sm:p-6 border-b border-gray-100">
                <h3 class="text-base sm:text-lg font-semibold text-gray-900">Liste des classes</h3>
            </div>
            <div class="overflow-x-auto">
                <div class="min-w-full inline-block align-middle">
                    <div class="overflow-hidden">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-3 sm:px-6 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Classe</th>
                                    <th class="px-3 sm:px-6 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Matière</th>
                                    <th class="px-3 sm:px-6 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Année scolaire</th>
                                    <th class="px-3 sm:px-6 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($classes as $classeMatiere)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-3 sm:px-6 py-3 sm:py-4">
                                        <div class="flex items-center">
                                            <div class="bg-blue-100 rounded-full p-1.5 sm:p-2 mr-2 sm:mr-3 flex-shrink-0">
                                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                                </svg>
                                            </div>
                                            <span class="text-xs sm:text-sm font-medium text-gray-900 break-words">
                                                {{ $classeMatiere->classe->nom ?? '-' }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-3 sm:px-6 py-3 sm:py-4 text-xs sm:text-sm text-gray-900 break-words">
                                        {{ $classeMatiere->matiere->nom ?? '-' }}
                                    </td>
                                    <td class="px-3 sm:px-6 py-3 sm:py-4 text-xs sm:text-sm text-gray-900 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                            {{ $classeMatiere->anneeScolaire->nom ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="px-3 sm:px-6 py-3 sm:py-4">
                                        <div class="flex flex-wrap items-center gap-2">
                                            <!-- Saisir notes -->
                                            <a href="{{ route('enseignant.notes.create', ['classe_id' => $classeMatiere->classe->id, 'matiere_id' => $classeMatiere->matiere->id]) }}" 
                                               class="inline-flex items-center px-3 py-1.5 bg-green-50 text-green-700 border border-green-200 hover:bg-green-600 hover:text-white rounded-lg transition-all duration-300 font-medium text-xs shadow-sm hover:shadow-md group">
                                                <svg class="w-4 h-4 mr-1.5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                                </svg>
                                                Saisir notes
                                            </a>
                                            
                                            <!-- Absences (Remplace Voir élèves pour une utilité immédiate ou similaire) -->
                                            <a href="{{ route('enseignant.absences.create', ['classe_id' => $classeMatiere->classe->id, 'matiere_id' => $classeMatiere->matiere->id]) }}" 
                                               class="inline-flex items-center px-3 py-1.5 bg-red-50 text-red-700 border border-red-200 hover:bg-red-600 hover:text-white rounded-lg transition-all duration-300 font-medium text-xs shadow-sm hover:shadow-md group">
                                                <svg class="w-4 h-4 mr-1.5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                                </svg>
                                                Gérer Absences
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-3 sm:px-6 py-6 sm:py-8 text-center text-gray-500 text-sm sm:text-base">
                                        Aucune classe trouvée.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Prévention du défilement horizontal */
* {
    max-width: 100%;
    box-sizing: border-box;
}

/* Break words for very long text */
.break-words {
    word-break: break-word;
    overflow-wrap: break-word;
    hyphens: auto;
}

/* Smooth transitions */
.transition-all {
    transition-property: all;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 150ms;
}

/* Mobile optimizations */
@media (max-width: 640px) {
    .container-padding {
        padding-left: 1rem;
        padding-right: 1rem;
    }
    
    /* Better touch targets for mobile */
    a, button {
        min-height: 44px;
        display: inline-flex;
        align-items: center;
    }
}

/* Tablet optimizations */
@media (min-width: 641px) and (max-width: 1024px) {
    .tablet-padding {
        padding-left: 1.5rem;
        padding-right: 1.5rem;
    }
}

/* Ensure table doesn't overflow */
.overflow-x-auto {
    -webkit-overflow-scrolling: touch;
    scrollbar-width: thin;
}

/* Custom scrollbar for better UX */
.overflow-x-auto::-webkit-scrollbar {
    height: 6px;
}

.overflow-x-auto::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.overflow-x-auto::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 10px;
}

.overflow-x-auto::-webkit-scrollbar-thumb:hover {
    background: #555;
}

/* Responsive table cells */
@media (max-width: 640px) {
    table tbody tr td {
        padding-top: 0.75rem;
        padding-bottom: 0.75rem;
    }
    
    /* Better spacing for action buttons on mobile */
    .flex-col.sm\:flex-row {
        gap: 0.5rem;
    }
}
</style>
@endsection