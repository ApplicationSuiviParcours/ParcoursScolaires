@extends('layouts.app')

@section('title', 'Matières par classe')

@section('header')
<div class="relative overflow-hidden bg-gradient-to-br from-indigo-600 via-indigo-700 to-purple-800 py-8 md:py-12">
    <!-- Éléments décoratifs animés -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-white rounded-full mix-blend-overlay filter blur-3xl animate-pulse"></div>
        <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-purple-300 rounded-full mix-blend-overlay filter blur-3xl animate-pulse delay-1000"></div>
    </div>
    
    <!-- Particules flottantes (masquées sur petits écrans) -->
    <div class="absolute inset-0 overflow-hidden hidden sm:block">
        @for($i = 1; $i <= 4; $i++)
            <div class="absolute w-1 h-1 bg-white rounded-full opacity-30 animate-float-{{ $i }}"
                 style="left: {{ rand(0, 100) }}%; top: {{ rand(0, 100) }}%; animation-delay: {{ rand(0, 5) }}s;"></div>
        @endfor
    </div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div class="text-center md:text-left">
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-white mb-2 animate-fade-in-up">
                    Matières par classe
                </h1>
                <p class="text-indigo-200 text-sm sm:text-base md:text-lg animate-fade-in-up animation-delay-200">
                    Gérez les matières assignées à chaque classe
                </p>
            </div>
            <div class="mt-6 md:mt-0 flex justify-center md:justify-end animate-fade-in-right">
                <a href="{{ route('admin.classe_matieres.manage') }}" 
                   class="group relative inline-flex items-center px-5 sm:px-6 py-2.5 sm:py-3 bg-green-500 hover:bg-green-600 text-white text-sm sm:text-base font-semibold rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-xl overflow-hidden">
                    <span class="absolute inset-0 bg-white opacity-0 group-hover:opacity-20 transition-opacity duration-300"></span>
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Gérer les assignations
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
<div class="container mx-auto px-4 py-6 sm:py-10 bg-gray-50">

    <!-- Messages de notification -->
    @if(session('success'))
        <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-3 sm:p-4 rounded-lg shadow-md animate-fade-in-down text-sm" role="alert">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <svg class="h-5 w-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="font-medium">{{ session('success') }}</p>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="text-green-500 hover:text-green-700 p-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-3 sm:p-4 rounded-lg shadow-md animate-fade-in-down text-sm" role="alert">
             <!-- Structure similaire au success -->
             <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <svg class="h-5 w-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="font-medium">{{ session('error') }}</p>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="text-red-500 hover:text-red-700 p-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    @endif

    <!-- Statistiques rapides -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-6 mb-6 sm:mb-8">
        <div class="bg-white rounded-xl sm:rounded-2xl shadow-lg p-4 sm:p-6 border-l-4 border-indigo-500 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs sm:text-sm text-gray-500 font-medium uppercase">Total</p>
                    <p class="text-xl sm:text-3xl font-bold text-gray-800 group-hover:text-indigo-600 transition-colors duration-300">{{ $stats['total_assignations'] }}</p>
                </div>
                <div class="bg-indigo-100 rounded-lg sm:rounded-xl p-2 sm:p-3 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-5 h-5 sm:w-8 sm:h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l5 5a2 2 0 01.586 1.414V19a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-3 sm:mt-4 flex items-center text-xs sm:text-sm text-gray-600">
                <span class="text-green-600 font-medium">{{ $stats['total_assignations'] }}</span>
                <span class="ml-1 sm:mx-2">assignations</span>
            </div>
        </div>

        <div class="bg-white rounded-xl sm:rounded-2xl shadow-lg p-4 sm:p-6 border-l-4 border-green-500 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs sm:text-sm text-gray-500 font-medium uppercase">Classes</p>
                    <p class="text-xl sm:text-3xl font-bold text-gray-800 group-hover:text-green-600 transition-colors duration-300">{{ $stats['classes_avec_matieres'] }}/{{ $stats['total_classes'] }}</p>
                </div>
                <div class="bg-green-100 rounded-lg sm:rounded-xl p-2 sm:p-3 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-5 h-5 sm:w-8 sm:h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-2 w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                @php $pourcentage = $stats['total_classes'] > 0 ? round(($stats['classes_avec_matieres'] / $stats['total_classes']) * 100) : 0; @endphp
                <div class="bg-green-500 h-2 rounded-full" style="width: {{ $pourcentage }}%"></div>
            </div>
        </div>

        <div class="bg-white rounded-xl sm:rounded-2xl shadow-lg p-4 sm:p-6 border-l-4 border-blue-500 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs sm:text-sm text-gray-500 font-medium uppercase">Coeff. Moyen</p>
                    <p class="text-xl sm:text-3xl font-bold text-gray-800 group-hover:text-blue-600 transition-colors duration-300">{{ $stats['moyenne_coefficient'] }}</p>
                </div>
                <div class="bg-blue-100 rounded-lg sm:rounded-xl p-2 sm:p-3 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-5 h-5 sm:w-8 sm:h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-3 sm:mt-4 flex items-center justify-between text-xs sm:text-sm">
                <span class="text-purple-600">Min: {{ $stats['coefficient_min'] ?? 0 }}</span>
                <span class="text-orange-600">Max: {{ $stats['coefficient_max'] ?? 0 }}</span>
            </div>
        </div>

        <div class="bg-white rounded-xl sm:rounded-2xl shadow-lg p-4 sm:p-6 border-l-4 border-orange-500 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs sm:text-sm text-gray-500 font-medium uppercase">Total Classes</p>
                    <p class="text-xl sm:text-3xl font-bold text-gray-800 group-hover:text-orange-600 transition-colors duration-300">{{ $stats['total_classes'] }}</p>
                </div>
                <div class="bg-orange-100 rounded-lg sm:rounded-xl p-2 sm:p-3 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-5 h-5 sm:w-8 sm:h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtres et recherche -->
    <div class="bg-white rounded-xl sm:rounded-2xl shadow-lg p-4 sm:p-6 mb-6 sm:mb-8" x-data="{ filters: {{ request()->anyFilled(['search', 'classe_id']) ? 'true' : 'false' }} }">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-base sm:text-lg font-semibold text-gray-800 flex items-center">
                <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                </svg>
                Filtres
            </h2>
            <button @click="filters = !filters" class="text-indigo-600 hover:text-indigo-800 p-1">
                <svg class="w-5 h-5 transition-transform duration-500" :class="{ 'rotate-180': filters }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
        </div>

        <form method="GET" action="{{ route('admin.classe_matieres.index') }}" class="space-y-4">
            <!-- Recherche principale -->
            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
                <div class="flex-1 relative group">
                    <div class="absolute inset-y-0 left-0 pl-3 sm:pl-4 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 sm:h-5 sm:w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" 
                           name="search" 
                           value="{{ $search ?? '' }}"
                           placeholder="Rechercher une classe..."
                           class="w-full pl-10 sm:pl-12 pr-4 py-2.5 sm:py-3 rounded-lg sm:rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all duration-300 text-sm">
                </div>
                <button type="submit" 
                        class="w-full sm:w-auto px-6 py-2.5 sm:py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold rounded-lg sm:rounded-xl transition-all duration-300 transform hover:scale-105 text-sm">
                    Rechercher
                </button>
            </div>

            <!-- Filtres avancés -->
            <div x-show="filters" x-transition class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-4">
                <div class="group">
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">Classe</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 sm:pl-4 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 sm:h-5 sm:w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"></path>
                            </svg>
                        </div>
                        <select name="classe_id" class="w-full pl-10 sm:pl-12 pr-4 py-2 sm:py-2.5 rounded-lg sm:rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 appearance-none bg-white text-sm">
                            <option value="">Toutes les classes</option>
                            @foreach($classes as $classe)
                                <option value="{{ $classe->id }}" {{ $classeId == $classe->id ? 'selected' : '' }}>
                                    {{ $classe->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="flex items-end">
                    <a href="{{ route('admin.classe_matieres.index') }}" 
                       class="w-full sm:w-auto text-center px-4 py-2 sm:py-2.5 bg-gray-100 text-gray-700 rounded-lg sm:rounded-xl hover:bg-gray-200 transition-all duration-300 text-sm">
                        Réinitialiser
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Liste des classes -->
    <div class="space-y-6 sm:space-y-8">
        @forelse($classes as $index => $classe)
            <div class="bg-white rounded-2xl sm:rounded-3xl shadow-xl overflow-hidden transition-all duration-500 hover:shadow-2xl transform hover:-translate-y-1">
                <!-- En-tête de classe -->
                <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-4 sm:px-8 py-4 sm:py-5 relative overflow-hidden">
                    <!-- Décorations -->
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white opacity-10 rounded-full transform translate-x-16 -translate-y-16"></div>
                    
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 relative z-10">
                        <div class="flex items-center">
                            <div class="w-12 h-12 sm:w-14 sm:h-14 bg-white/20 backdrop-blur-lg rounded-xl flex items-center justify-center mr-3 sm:mr-4">
                                <span class="text-white font-bold text-xl sm:text-2xl">{{ substr($classe->nom, 0, 2) }}</span>
                            </div>
                            <div>
                                <h2 class="text-xl sm:text-2xl font-bold text-white">
                                    {{ $classe->nom }}
                                </h2>
                                <div class="flex flex-wrap items-center mt-1 text-indigo-100 text-xs sm:text-sm">
                                    <span class="mr-2 px-2 py-0.5 bg-white/20 rounded-full">
                                        {{ $classe->matieres->count() }} matière(s)
                                    </span>
                                    <span class="hidden sm:inline">
                                        • {{ $classe->matieres->sum('coefficient') }} coeff. total
                                    </span>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('admin.classe_matieres.manage', ['classe_id' => $classe->id]) }}" 
                           class="px-4 py-2 sm:px-5 sm:py-2.5 bg-white/20 hover:bg-white/30 text-white text-sm rounded-lg sm:rounded-xl transition-all duration-300 text-center">
                            Gérer les matières
                        </a>
                    </div>
                </div>

                <!-- Tableau des matières -->
                <div class="p-4 sm:p-8">
                    @if($classe->matieres->isNotEmpty())
                        <div class="overflow-x-auto -mx-4 sm:mx-0">
                            <table class="min-w-full w-full">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Matière</th>
                                        <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase hidden sm:table-cell">Code</th>
                                        <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Coeff.</th>
                                        <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach($classe->matieres as $assignation)
                                        <tr class="hover:bg-indigo-50/50 transition-colors duration-200">
                                            <td class="px-4 sm:px-6 py-3 sm:py-4">
                                                <div class="flex items-center">
                                                    <div class="w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-lg flex items-center justify-center mr-2 sm:mr-3 text-white font-bold text-xs sm:text-sm shadow">
                                                        {{ substr($assignation->matiere->nom, 0, 2) }}
                                                    </div>
                                                    <span class="text-xs sm:text-sm font-medium text-gray-900">
                                                        {{ $assignation->matiere->nom }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 hidden sm:table-cell">
                                                <span class="px-3 py-1 bg-gradient-to-r from-blue-50 to-indigo-50 text-blue-700 text-xs font-medium rounded-full border border-blue-200">
                                                    {{ $assignation->matiere->code }}
                                                </span>
                                            </td>
                                            <td class="px-4 sm:px-6 py-3 sm:py-4">
                                                <span class="text-lg sm:text-2xl font-bold text-indigo-600">{{ $assignation->coefficient }}</span>
                                            </td>
                                            <td class="px-4 sm:px-6 py-3 sm:py-4">
                                                <div class="flex items-center justify-end gap-1 md:gap-2 whitespace-nowrap">
                                                    <a href="{{ route('admin.classe_matieres.show', $assignation) }}" class="p-1.5 md:p-2 text-blue-600 bg-transparent hover:bg-blue-50 rounded-lg transition-colors border-none" title="Voir">
                                                        <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                    </a>
                                                    <a href="{{ route('admin.classe_matieres.edit', $assignation) }}" class="p-1.5 md:p-2 text-amber-600 bg-transparent hover:bg-amber-50 rounded-lg transition-colors border-none" title="Modifier">
                                                        <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                    </a>
                                                    <form action="{{ route('admin.classe_matieres.destroy', $assignation) }}" method="POST" class="inline m-0 p-0 delete-form" onsubmit="return confirm('Confirmer la suppression ?');">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="p-1.5 md:p-2 text-red-600 bg-transparent hover:bg-red-50 rounded-lg transition-colors border-none flex items-center justify-center cursor-pointer" title="Retirer">
                                                            <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-8 sm:py-12">
                            <div class="w-16 h-16 sm:w-24 sm:h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 sm:w-12 sm:h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l5 5a2 2 0 01.586 1.414V19a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z"></path>
                                </svg>
                            </div>
                            <p class="text-gray-500 mb-4 text-sm sm:text-base">Aucune matière assignée</p>
                            <a href="{{ route('admin.classe_matieres.manage', ['classe_id' => $classe->id]) }}" 
                               class="inline-flex items-center px-4 sm:px-6 py-2 sm:py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white text-sm font-semibold rounded-lg sm:rounded-xl">
                                Ajouter des matières
                            </a>
                        </div>
                    @endif

                    <!-- Résumé -->
                    @if($classe->matieres->isNotEmpty())
                        @php
                            $totalCoeff = $classe->matieres->sum('coefficient');
                            $moyenneCoeff = round($classe->matieres->avg('coefficient'), 2);
                            $maxCoeff = $classe->matieres->max('coefficient');
                            $minCoeff = $classe->matieres->min('coefficient');
                        @endphp
                        <div class="mt-4 sm:mt-6 pt-4 sm:pt-6 border-t border-gray-200">
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-2 sm:gap-4">
                                <div class="bg-indigo-50 rounded-lg p-3 sm:p-4 text-center">
                                    <p class="text-xs text-indigo-600">Total</p>
                                    <p class="text-lg sm:text-2xl font-bold text-indigo-700">{{ $totalCoeff }}</p>
                                </div>
                                <div class="bg-green-50 rounded-lg p-3 sm:p-4 text-center">
                                    <p class="text-xs text-green-600">Moyenne</p>
                                    <p class="text-lg sm:text-2xl font-bold text-green-700">{{ $moyenneCoeff }}</p>
                                </div>
                                <div class="bg-blue-50 rounded-lg p-3 sm:p-4 text-center">
                                    <p class="text-xs text-blue-600">Max</p>
                                    <p class="text-lg sm:text-2xl font-bold text-blue-700">{{ $maxCoeff }}</p>
                                </div>
                                <div class="bg-orange-50 rounded-lg p-3 sm:p-4 text-center">
                                    <p class="text-xs text-orange-600">Min</p>
                                    <p class="text-lg sm:text-2xl font-bold text-orange-700">{{ $minCoeff }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="bg-white rounded-2xl sm:rounded-3xl shadow-xl p-8 sm:p-16 text-center">
                <div class="w-20 h-20 sm:w-32 sm:h-32 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 sm:w-16 sm:h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"></path>
                    </svg>
                </div>
                <h3 class="text-xl sm:text-2xl font-bold text-gray-800 mb-3">Aucune classe trouvée</h3>
                <p class="text-gray-500 text-sm sm:text-base mb-6 sm:mb-8">Commencez par créer des classes.</p>
                <a href="{{ route('admin.classes.create') }}" 
                   class="inline-flex items-center px-6 sm:px-8 py-3 sm:py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold rounded-lg sm:rounded-xl text-sm sm:text-base">
                    Créer une classe
                </a>
            </div>
        @endforelse
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Responsive Animations */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes fadeInDown {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .animate-fade-in-up { animation: fadeInUp 0.6s ease-out forwards; }
    .animate-fade-in-down { animation: fadeInDown 0.5s ease-out forwards; }
    
    /* Float animations */
    @keyframes float-1 { 0%, 100% { transform: translate(0, 0); } 50% { transform: translate(10px, -10px); } }
    @keyframes float-2 { 0%, 100% { transform: translate(0, 0); } 50% { transform: translate(-15px, 5px); } }
    @keyframes float-3 { 0%, 100% { transform: translate(0, 0); } 50% { transform: translate(8px, 8px); } }
    @keyframes float-4 { 0%, 100% { transform: translate(0, 0); } 50% { transform: translate(-12px, -8px); } }
    
    .animate-float-1 { animation: float-1 8s ease-in-out infinite; }
    .animate-float-2 { animation: float-2 10s ease-in-out infinite; }
    .animate-float-3 { animation: float-3 12s ease-in-out infinite; }
    .animate-float-4 { animation: float-4 9s ease-in-out infinite; }
</style>
@endpush

@push('scripts')
<script>
    // Auto-fermeture des notifications
    document.addEventListener('DOMContentLoaded', function() {
        const alerts = document.querySelectorAll('[role="alert"]');
        if (alerts.length) {
            setTimeout(() => {
                alerts.forEach(alert => {
                    alert.style.transition = 'opacity 0.5s ease';
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500);
                });
            }, 5000);
        }
    });
</script>
@endpush