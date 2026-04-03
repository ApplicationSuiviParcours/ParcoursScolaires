@extends('layouts.app')

@section('title', 'Gérer les matières de la classe')

@section('header')
<div class="relative overflow-hidden bg-gradient-to-br from-teal-600 via-teal-700 to-cyan-800 py-8 md:py-12">
    <!-- Éléments décoratifs animés -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-white rounded-full mix-blend-overlay filter blur-3xl animate-pulse"></div>
        <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-cyan-300 rounded-full mix-blend-overlay filter blur-3xl animate-pulse delay-1000"></div>
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
                <nav class="flex mb-4 justify-center md:justify-start" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ route('admin.classe_matieres.index') }}" class="inline-flex items-center text-xs sm:text-sm font-medium text-teal-200 hover:text-white transition-colors duration-300">
                                <svg class="w-4 h-4 mr-1 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                                <span class="hidden sm:inline">Matières par classe</span>
                                <span class="sm:hidden">Liste</span>
                            </a>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 sm:w-6 sm:h-6 text-teal-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="ml-1 text-xs sm:text-sm font-medium text-white md:ml-2">Gérer</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-white mb-2 animate-fade-in-up">
                    Gérer les matières
                </h1>
                <p class="text-teal-200 text-sm sm:text-base md:text-lg animate-fade-in-up animation-delay-200">
                    Assignez des matières aux classes
                </p>
            </div>
            <div class="mt-6 md:mt-0 flex justify-center md:justify-end space-x-3 animate-fade-in-right">
                <a href="{{ route('admin.classe_matieres.index') }}" 
                   class="group relative inline-flex items-center px-3 sm:px-5 py-2 sm:py-2.5 bg-white/10 backdrop-blur-lg hover:bg-white/20 text-white text-sm font-medium rounded-xl transition-all duration-300 transform hover:scale-105 border border-white/20">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-1 sm:mr-2 transform group-hover:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Retour
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
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-3 sm:p-4 rounded-lg shadow-md animate-fade-in-down text-sm" role="alert">
             <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <svg class="h-5 w-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="font-medium">{{ session('error') }}</p>
                </div>
                 <button onclick="this.parentElement.parentElement.remove()" class="text-red-500 hover:text-red-700 p-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </div>
    @endif

    <!-- Sélection de la classe -->
    <div class="bg-white rounded-2xl sm:rounded-3xl shadow-xl overflow-hidden mb-6 sm:mb-8">
        <div class="bg-gradient-to-r from-teal-500 to-cyan-600 px-4 sm:px-8 py-4 sm:py-6">
            <div class="flex flex-col sm:flex-row items-center sm:items-center">
                <div class="w-12 h-12 sm:w-14 sm:h-14 bg-white/20 backdrop-blur-lg rounded-xl sm:rounded-2xl flex items-center justify-center mb-3 sm:mb-0 sm:mr-5">
                    <svg class="w-6 h-6 sm:w-7 sm:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"></path>
                    </svg>
                </div>
                <div class="text-center sm:text-left">
                    <h2 class="text-xl sm:text-2xl font-bold text-white mb-1">Sélectionner une classe</h2>
                    <p class="text-teal-100 text-xs sm:text-sm">Choisissez la classe pour gérer ses matières</p>
                </div>
            </div>
        </div>

        <div class="p-4 sm:p-8">
            <form method="GET" action="{{ route('admin.classe_matieres.manage') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-6">
                <div class="group md:col-span-2">
                    <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">Classe</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 sm:pl-4 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 sm:h-5 sm:w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"></path>
                            </svg>
                        </div>
                        <select name="classe_id" class="w-full pl-10 sm:pl-12 pr-4 py-2.5 sm:py-3 rounded-lg sm:rounded-xl border-2 border-gray-200 focus:border-teal-500 focus:ring-2 focus:ring-teal-200 appearance-none bg-white text-sm">
                            <option value="">-- Sélectionner une classe --</option>
                            @foreach($classes as $classe)
                                <option value="{{ $classe->id }}" {{ $classeId == $classe->id ? 'selected' : '' }}>
                                    {{ $classe->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row items-stretch sm:items-end gap-3 sm:gap-0 sm:space-x-3">
                    <a href="{{ route('admin.classe_matieres.manage') }}" class="w-full sm:w-auto text-center px-4 sm:px-6 py-2.5 sm:py-3 bg-gray-100 text-gray-700 rounded-lg sm:rounded-xl hover:bg-gray-200 transition-all duration-300 text-sm">
                        Réinitialiser
                    </a>
                    <button type="submit" class="w-full sm:w-auto px-4 sm:px-6 py-2.5 sm:py-3 bg-gradient-to-r from-teal-500 to-cyan-600 hover:from-teal-600 hover:to-cyan-700 text-white font-semibold rounded-lg sm:rounded-xl transition-all duration-300 text-sm">
                        Afficher
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if($classeId && isset($classe))
        <!-- Informations de la classe -->
        <div class="bg-white rounded-2xl sm:rounded-3xl shadow-xl overflow-hidden mb-6 sm:mb-8">
            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-4 sm:px-8 py-4 sm:py-5">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="flex items-center">
                        <div class="w-12 h-12 sm:w-14 sm:h-14 bg-white/20 backdrop-blur-lg rounded-xl sm:rounded-2xl flex items-center justify-center mr-3 sm:mr-5">
                            <span class="text-white font-bold text-xl sm:text-2xl">{{ substr($classe->nom, 0, 2) }}</span>
                        </div>
                        <div class="text-center sm:text-left">
                            <h2 class="text-xl sm:text-2xl font-bold text-white">{{ $classe->nom }}</h2>
                            <p class="text-indigo-100 text-xs sm:text-sm">Gestion des matières assignées</p>
                        </div>
                    </div>
                    <div class="bg-white/20 backdrop-blur-lg rounded-lg sm:rounded-xl px-4 sm:px-6 py-2 sm:py-3 text-white text-center">
                        <span class="text-xs sm:text-sm block">Coefficient total</span>
                        <span class="text-xl sm:text-2xl font-bold">{{ $stats['coefficient_total'] ?? 0 }}</span>
                    </div>
                </div>
            </div>

            <div class="p-4 sm:p-8">
                <!-- Formulaire d'ajout -->
                <div class="mb-6 sm:mb-8 p-4 sm:p-6 bg-teal-50 rounded-xl sm:rounded-2xl border border-teal-200">
                    <h3 class="text-base sm:text-lg font-semibold text-teal-800 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Ajouter une matière
                    </h3>

                    <form action="{{ route('admin.classe_matieres.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @csrf
                        <input type="hidden" name="classe_id" value="{{ $classeId }}">

                        <div>
                            <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">Matière</label>
                            <select name="matiere_id" required class="w-full rounded-lg sm:rounded-xl border-2 border-gray-200 focus:border-teal-500 focus:ring-2 focus:ring-teal-200 px-3 sm:px-4 py-2 sm:py-2.5 text-sm">
                                <option value="">Sélectionner</option>
                                @foreach($matieres as $matiere)
                                    @if(!$classeMatieres->contains('matiere_id', $matiere->id))
                                        <option value="{{ $matiere->id }}" {{ old('matiere_id') == $matiere->id ? 'selected' : '' }}>
                                            {{ $matiere->nom }} ({{ $matiere->code }})
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">Coefficient</label>
                            <input type="number" 
                                   name="coefficient" 
                                   step="0.5" 
                                   min="0.5" 
                                   max="10" 
                                   value="{{ old('coefficient', 1) }}"
                                   required
                                   class="w-full rounded-lg sm:rounded-xl border-2 border-gray-200 focus:border-teal-500 focus:ring-2 focus:ring-teal-200 px-3 sm:px-4 py-2 sm:py-2.5 text-sm">
                        </div>

                        <div class="flex items-end">
                            <button type="submit" class="w-full px-4 sm:px-6 py-2 sm:py-2.5 bg-teal-600 hover:bg-teal-700 text-white font-semibold rounded-lg sm:rounded-xl transition-all duration-300 text-sm">
                                Ajouter
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Liste des matières assignées -->
                <h3 class="text-base sm:text-lg font-semibold text-gray-800 mb-4">Matières assignées</h3>

                @if($classeMatieres->isNotEmpty())
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
                                @foreach($classeMatieres as $assignation)
                                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                                        <td class="px-4 sm:px-6 py-3 sm:py-4">
                                            <div class="flex items-center">
                                                <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-2 sm:mr-3 flex-shrink-0">
                                                    <span class="text-purple-700 font-bold text-xs">{{ substr($assignation->matiere->nom, 0, 2) }}</span>
                                                </div>
                                                <div class="min-w-0">
                                                    <span class="text-xs sm:text-sm font-medium text-gray-900 block truncate">{{ $assignation->matiere->nom }}</span>
                                                    <span class="sm:hidden text-xs text-gray-500">{{ $assignation->matiere->code }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 hidden sm:table-cell">
                                            <span class="px-3 py-1 bg-blue-100 text-blue-700 text-xs font-medium rounded-full">
                                                {{ $assignation->matiere->code }}
                                            </span>
                                        </td>
                                        <td class="px-4 sm:px-6 py-3 sm:py-4">
                                            <span class="text-base sm:text-lg font-bold text-gray-800">{{ $assignation->coefficient }}</span>
                                        </td>
                                        <td class="px-4 sm:px-6 py-3 sm:py-4">
                                            <div class="flex items-center space-x-1 sm:space-x-2">
                                                <a href="{{ route('admin.classe_matieres.edit', $assignation) }}" 
                                                   class="p-1.5 sm:p-2 bg-yellow-100 text-yellow-600 rounded-lg hover:bg-yellow-600 hover:text-white transition-colors duration-200"
                                                   title="Modifier">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                </a>
                                                <form action="{{ route('admin.classe_matieres.destroy', $assignation) }}" method="POST" class="inline" onsubmit="return confirm('Confirmer la suppression ?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="p-1.5 sm:p-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-600 hover:text-white transition-colors duration-200" title="Retirer">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Résumé des coefficients -->
                    <div class="mt-4 sm:mt-6 pt-4 sm:pt-6 border-t border-gray-200">
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-4">
                            <div class="bg-gray-50 rounded-lg sm:rounded-xl p-3 sm:p-4">
                                <p class="text-xs text-gray-500 mb-1">Total coefficients</p>
                                <p class="text-xl sm:text-2xl font-bold text-indigo-600">{{ $stats['coefficient_total'] }}</p>
                            </div>
                            <div class="bg-gray-50 rounded-lg sm:rounded-xl p-3 sm:p-4">
                                <p class="text-xs text-gray-500 mb-1">Moyenne</p>
                                <p class="text-xl sm:text-2xl font-bold text-purple-600">{{ $stats['coefficient_moyen'] }}</p>
                            </div>
                            <div class="bg-gray-50 rounded-lg sm:rounded-xl p-3 sm:p-4">
                                <p class="text-xs text-gray-500 mb-1">Nombre de matières</p>
                                <p class="text-xl sm:text-2xl font-bold text-teal-600">{{ $stats['total_matieres'] }}</p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-10 sm:py-12 bg-gray-50 rounded-xl sm:rounded-2xl">
                        <svg class="w-12 h-12 sm:w-16 sm:h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l5 5a2 2 0 01.586 1.414V19a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z"></path>
                        </svg>
                        <p class="text-gray-500 text-sm sm:text-base">Aucune matière assignée à cette classe</p>
                        <p class="text-gray-400 text-xs sm:text-sm mt-2">Utilisez le formulaire ci-dessus pour en ajouter.</p>
                    </div>
                @endif
            </div>
        </div>
    @elseif($classeId && !isset($classe))
        <div class="bg-red-50 rounded-2xl sm:rounded-3xl p-8 sm:p-12 text-center">
            <svg class="w-12 h-12 sm:w-16 sm:h-16 text-red-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
            <h3 class="text-lg sm:text-xl font-bold text-red-800 mb-2">Classe non trouvée</h3>
            <p class="text-red-600 text-sm sm:text-base">La classe sélectionnée n'existe pas.</p>
        </div>
    @endif
</div>
@endsection