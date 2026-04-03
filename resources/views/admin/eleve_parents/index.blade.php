{{-- resources/views/admin/eleve_parents/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Gestion des relations Élèves-Parents')

@section('header')
    {{-- Header Responsive --}}
    <div class="relative bg-gradient-to-r from-indigo-600 to-indigo-800 py-3 sm:py-4 md:py-6 overflow-x-hidden">
        <div class="absolute inset-0 bg-black opacity-10"></div>
        <div class="container mx-auto px-3 sm:px-4 md:px-6 relative">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-1.5 sm:gap-2">
                <div class="flex items-center space-x-2 sm:space-x-3 md:space-x-4">
                    <div class="p-1.5 sm:p-2 md:p-3 bg-white bg-opacity-20 rounded-lg sm:rounded-xl md:rounded-2xl backdrop-filter backdrop-blur-lg">
                        <i class="fas fa-handshake text-sm sm:text-base md:text-lg lg:text-2xl text-white"></i>
                    </div>
                    <div>
                        <h1 class="text-base sm:text-lg md:text-xl lg:text-2xl font-bold text-white">Relations Élèves-Parents</h1>
                        <p class="text-indigo-100 text-[9px] sm:text-[10px] md:text-xs lg:text-sm mt-0.5">Gérez les liens entre élèves et parents</p>
                    </div>
                </div>
                <nav class="mt-1 md:mt-0">
                    <ol class="flex items-center space-x-1 sm:space-x-2 text-[8px] sm:text-[9px] md:text-xs lg:text-sm">
                        <li>
                            <a href="{{ route('dashboard') }}" class="text-indigo-200 hover:text-white transition-colors duration-200">
                                <i class="fas fa-home mr-0.5 sm:mr-1"></i>Dashboard
                            </a>
                        </li>
                        <li class="text-indigo-300">/</li>
                        <li class="text-white font-medium">Relations</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container mx-auto px-3 sm:px-4 md:px-6 py-3 sm:py-4 md:py-6 lg:py-8 overflow-x-hidden">
        
        <!-- Statistiques rapides - Responsive Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4 md:gap-5 lg:gap-6 mb-4 sm:mb-6 md:mb-8">
            <!-- Total relations -->
            <div class="bg-white rounded-lg sm:rounded-xl md:rounded-2xl shadow p-3 sm:p-4 md:p-5 lg:p-6 border-l-4 border-indigo-500 hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between">
                    <div class="min-w-0">
                        <p class="text-[8px] sm:text-[9px] md:text-xs lg:text-sm font-medium text-gray-500 uppercase">Total relations</p>
                        <p class="text-base sm:text-lg md:text-xl lg:text-3xl font-bold text-gray-800 mt-0.5 sm:mt-1">{{ $relations->total() }}</p>
                        <p class="text-[7px] sm:text-[8px] md:text-[9px] lg:text-xs text-gray-400 mt-0.5 hidden sm:block">+2.5% ce mois</p>
                    </div>
                    <div class="p-1.5 sm:p-2 md:p-3 lg:p-4 bg-indigo-600 rounded-lg md:rounded-xl lg:rounded-2xl shadow-inner flex-shrink-0 ml-2">
                        <i class="fas fa-users text-sm sm:text-base md:text-lg lg:text-2xl text-white"></i>
                    </div>
                </div>
            </div>

            <!-- Élèves concernés -->
            <div class="bg-white rounded-lg sm:rounded-xl md:rounded-2xl shadow p-3 sm:p-4 md:p-5 lg:p-6 border-l-4 border-green-500 hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between">
                    <div class="min-w-0">
                        <p class="text-[8px] sm:text-[9px] md:text-xs lg:text-sm font-medium text-gray-500 uppercase">Élèves concernés</p>
                        <p class="text-base sm:text-lg md:text-xl lg:text-3xl font-bold text-gray-800 mt-0.5 sm:mt-1">{{ \App\Models\Eleve::has('parents')->count() }}</p>
                        <p class="text-[7px] sm:text-[8px] md:text-[9px] lg:text-xs text-gray-400 mt-0.5 hidden sm:block">{{ \App\Models\Eleve::count() }} inscrits</p>
                    </div>
                    <div class="p-1.5 sm:p-2 md:p-3 lg:p-4 bg-green-600 rounded-lg md:rounded-xl lg:rounded-2xl shadow-inner flex-shrink-0 ml-2">
                        <i class="fas fa-child text-sm sm:text-base md:text-lg lg:text-2xl text-white"></i>
                    </div>
                </div>
            </div>

            <!-- Parents actifs -->
            <div class="bg-white rounded-lg sm:rounded-xl md:rounded-2xl shadow p-3 sm:p-4 md:p-5 lg:p-6 border-l-4 border-blue-500 hover:shadow-lg transition-shadow sm:col-span-2 lg:col-span-1">
                <div class="flex items-center justify-between">
                    <div class="min-w-0">
                        <p class="text-[8px] sm:text-[9px] md:text-xs lg:text-sm font-medium text-gray-500 uppercase">Parents actifs</p>
                        <p class="text-base sm:text-lg md:text-xl lg:text-3xl font-bold text-gray-800 mt-0.5 sm:mt-1">{{ \App\Models\ParentEleve::has('eleves')->count() }}</p>
                        <p class="text-[7px] sm:text-[8px] md:text-[9px] lg:text-xs text-gray-400 mt-0.5 hidden sm:block">{{ \App\Models\ParentEleve::count() }} inscrits</p>
                    </div>
                    <div class="p-1.5 sm:p-2 md:p-3 lg:p-4 bg-blue-600 rounded-lg md:rounded-xl lg:rounded-2xl shadow-inner flex-shrink-0 ml-2">
                        <i class="fas fa-user-tie text-sm sm:text-base md:text-lg lg:text-2xl text-white"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filtres avancés - Responsive -->
        <div class="bg-white rounded-lg sm:rounded-xl md:rounded-2xl shadow mb-4 sm:mb-6 md:mb-8 overflow-hidden">
            <div class="p-3 sm:p-4 md:p-5 lg:p-6 border-b border-gray-100">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2 sm:gap-3 mb-2 sm:mb-3 md:mb-4">
                    <h2 class="text-xs sm:text-sm md:text-base lg:text-lg font-semibold text-gray-800">
                        <i class="fas fa-filter text-indigo-600 mr-1 text-[10px] sm:text-xs"></i>
                        Filtres
                    </h2>
                    <button id="resetFilters" class="text-[8px] sm:text-[9px] md:text-xs lg:text-sm text-gray-500 hover:text-indigo-600">
                        <i class="fas fa-undo mr-0.5"></i>Réinitialiser
                    </button>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-2 sm:gap-3 md:gap-4">
                    <!-- Recherche -->
                    <div class="sm:col-span-2 lg:col-span-2">
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-2 sm:pl-3 md:pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400 text-[10px] sm:text-xs"></i>
                            </span>
                            <input type="text" 
                                   class="w-full pl-7 sm:pl-8 md:pl-10 lg:pl-11 pr-2 sm:pr-3 md:pr-4 py-1.5 sm:py-2 md:py-2.5 lg:py-3 border border-gray-200 rounded-lg md:rounded-xl text-[10px] sm:text-xs focus:ring-1 focus:ring-indigo-200"
                                   placeholder="Rechercher..." 
                                   id="searchInput">
                        </div>
                    </div>

                    <!-- Filtre lien -->
                    <div>
                        <select class="w-full px-2 sm:px-3 md:px-4 py-1.5 sm:py-2 md:py-2.5 lg:py-3 border border-gray-200 rounded-lg md:rounded-xl text-[10px] sm:text-xs appearance-none" id="lienFilter">
                            <option value="">Tous les liens</option>
                            <option value="Père">Père</option>
                            <option value="Mère">Mère</option>
                            <option value="Tuteur">Tuteur</option>
                        </select>
                    </div>

                    <!-- Filtre date -->
                    <div>
                        <input type="date" class="w-full px-2 sm:px-3 md:px-4 py-1.5 sm:py-2 md:py-2.5 lg:py-3 border border-gray-200 rounded-lg md:rounded-xl text-[10px] sm:text-xs" id="dateFilter">
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="px-3 sm:px-4 md:px-5 lg:px-6 py-2 sm:py-3 md:py-4 bg-gray-50 border-t">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2 sm:gap-3">
                    <div class="text-[8px] sm:text-[9px] md:text-xs lg:text-sm text-gray-600">
                        <span id="selectedCount" class="font-semibold text-indigo-600">0</span> sélectionné(s)
                    </div>
                    
                    <div class="flex flex-wrap items-center gap-1.5 sm:gap-2 w-full sm:w-auto justify-start sm:justify-end">
                        <a href="{{ route('admin.eleve-parents.export.pdf') }}" 
                           class="flex-1 sm:flex-none inline-flex items-center justify-center px-2 sm:px-3 md:px-4 py-1 sm:py-1.5 md:py-2 border rounded-lg md:rounded-xl text-[8px] sm:text-[9px] md:text-xs lg:text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 shadow-sm">
                            <i class="fas fa-file-pdf mr-0.5 sm:mr-1 text-red-500 text-[8px] sm:text-[9px]"></i>
                            <span class="hidden sm:inline">PDF</span>
                        </a>
                        <a href="{{ route('admin.eleve-parents.export.excel') }}" 
                           class="flex-1 sm:flex-none inline-flex items-center justify-center px-2 sm:px-3 md:px-4 py-1 sm:py-1.5 md:py-2 border rounded-lg md:rounded-xl text-[8px] sm:text-[9px] md:text-xs lg:text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 shadow-sm">
                            <i class="fas fa-file-excel mr-0.5 sm:mr-1 text-green-500 text-[8px] sm:text-[9px]"></i>
                            <span class="hidden sm:inline">Excel</span>
                        </a>
                        <a href="{{ route('admin.eleve-parents.create') }}" 
                           class="flex-1 sm:flex-none inline-flex items-center justify-center px-3 sm:px-4 md:px-5 lg:px-6 py-1.5 sm:py-2 md:py-2.5 lg:py-3 bg-indigo-600 text-white text-[9px] sm:text-[10px] md:text-xs lg:text-sm font-medium rounded-lg md:rounded-xl shadow hover:bg-indigo-700">
                            <i class="fas fa-plus-circle mr-0.5 sm:mr-1 text-[8px] sm:text-[9px]"></i>
                            Nouvelle relation
                        </a>
                    </div>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-3 sm:mb-4 md:mb-5 lg:mb-6 bg-green-50 border-l-4 border-green-500 rounded-r-lg p-2 sm:p-3 md:p-4 shadow animate-slideDown text-[9px] sm:text-[10px] md:text-xs lg:text-sm">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-500 mr-1.5 sm:mr-2 text-[10px] sm:text-xs"></i>
                    <p class="font-medium text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <!-- Tableau des relations - Responsive avec défilement horizontal si nécessaire -->
        <div class="bg-white rounded-lg sm:rounded-xl md:rounded-2xl shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-[650px] sm:min-w-full w-full" id="relationsTable">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-2 sm:px-3 md:px-4 lg:px-6 py-2 sm:py-2.5 md:py-3 lg:py-4 text-left w-8 md:w-auto">
                                <input type="checkbox" class="w-2.5 h-2.5 sm:w-3 sm:h-3 md:w-4 md:h-4 rounded border-gray-300 text-indigo-600" id="selectAll">
                            </th>
                            <th class="px-2 sm:px-3 md:px-4 lg:px-6 py-2 sm:py-2.5 md:py-3 lg:py-4 text-left text-[8px] sm:text-[9px] md:text-xs lg:text-sm font-semibold text-gray-600 uppercase">Élève</th>
                            <th class="px-2 sm:px-3 md:px-4 lg:px-6 py-2 sm:py-2.5 md:py-3 lg:py-4 text-left text-[8px] sm:text-[9px] md:text-xs lg:text-sm font-semibold text-gray-600 uppercase">Parent</th>
                            <th class="px-2 sm:px-3 md:px-4 lg:px-6 py-2 sm:py-2.5 md:py-3 lg:py-4 text-left text-[8px] sm:text-[9px] md:text-xs lg:text-sm font-semibold text-gray-600 uppercase hidden sm:table-cell">Lien</th>
                            <th class="px-2 sm:px-3 md:px-4 lg:px-6 py-2 sm:py-2.5 md:py-3 lg:py-4 text-left text-[8px] sm:text-[9px] md:text-xs lg:text-sm font-semibold text-gray-600 uppercase hidden md:table-cell">Contact</th>
                            <th class="px-2 sm:px-3 md:px-4 lg:px-6 py-2 sm:py-2.5 md:py-3 lg:py-4 text-left text-[8px] sm:text-[9px] md:text-xs lg:text-sm font-semibold text-gray-600 uppercase hidden md:table-cell">Date</th>
                            <th class="px-2 sm:px-3 md:px-4 lg:px-6 py-2 sm:py-2.5 md:py-3 lg:py-4 text-right text-[8px] sm:text-[9px] md:text-xs lg:text-sm font-semibold text-gray-600 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($relations as $relation)
                            <tr class="group hover:bg-indigo-50/50 transition-colors">
                                <td class="px-2 sm:px-3 md:px-4 lg:px-6 py-2 sm:py-2.5 md:py-3 lg:py-4 whitespace-nowrap">
                                    <input type="checkbox" class="row-checkbox w-2.5 h-2.5 sm:w-3 sm:h-3 md:w-4 md:h-4 rounded border-gray-300 text-indigo-600" value="{{ $relation->id }}">
                                </td>
                                <td class="px-2 sm:px-3 md:px-4 lg:px-6 py-2 sm:py-2.5 md:py-3 lg:py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-6 w-6 sm:h-7 sm:w-7 md:h-8 md:w-8 lg:h-10 lg:w-10 rounded-lg md:rounded-xl bg-indigo-100 flex items-center justify-center flex-shrink-0">
                                            <span class="text-indigo-700 font-bold text-[8px] sm:text-[9px] md:text-xs lg:text-sm">
                                                {{ strtoupper(substr($relation->eleve->prenom, 0, 1)) }}{{ strtoupper(substr($relation->eleve->nom, 0, 1)) }}
                                            </span>
                                        </div>
                                        <div class="ml-1.5 sm:ml-2 md:ml-3 lg:ml-4 overflow-hidden">
                                            <div class="text-[9px] sm:text-[10px] md:text-xs lg:text-sm font-semibold text-gray-900 truncate max-w-[80px] sm:max-w-[120px] md:max-w-[150px] lg:max-w-[200px]">{{ $relation->eleve->prenom }} {{ $relation->eleve->nom }}</div>
                                            <div class="text-[7px] sm:text-[8px] md:text-[9px] lg:text-xs text-gray-500 hidden sm:block truncate">{{ $relation->eleve->classe->nom ?? '-' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-2 sm:px-3 md:px-4 lg:px-6 py-2 sm:py-2.5 md:py-3 lg:py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-6 w-6 sm:h-7 sm:w-7 md:h-8 md:w-8 lg:h-10 lg:w-10 rounded-lg md:rounded-xl bg-green-100 flex items-center justify-center flex-shrink-0">
                                            <span class="text-green-700 font-bold text-[8px] sm:text-[9px] md:text-xs lg:text-sm">
                                                {{ strtoupper(substr($relation->parentEleve->prenom, 0, 1)) }}{{ strtoupper(substr($relation->parentEleve->nom, 0, 1)) }}
                                            </span>
                                        </div>
                                        <div class="ml-1.5 sm:ml-2 md:ml-3 lg:ml-4 overflow-hidden">
                                            <div class="text-[9px] sm:text-[10px] md:text-xs lg:text-sm font-semibold text-gray-900 truncate max-w-[80px] sm:max-w-[120px] md:max-w-[150px] lg:max-w-[200px]">{{ $relation->parentEleve->prenom }} {{ $relation->parentEleve->nom }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-2 sm:px-3 md:px-4 lg:px-6 py-2 sm:py-2.5 md:py-3 lg:py-4 whitespace-nowrap hidden sm:table-cell">
                                    @php
                                        $badgeConfig = [
                                            'Père' => ['bg-blue-600', 'fa-mars'],
                                            'Mère' => ['bg-pink-600', 'fa-venus'],
                                            'Tuteur' => ['bg-purple-600', 'fa-user-tie'],
                                            'Grand-parent' => ['bg-amber-600', 'fa-users'],
                                            'Autre' => ['bg-gray-600', 'fa-heart']
                                        ];
                                        $config = $badgeConfig[$relation->lien_parental] ?? $badgeConfig['Autre'];
                                    @endphp
                                    <span class="inline-flex items-center px-1.5 py-0.5 sm:px-2 sm:py-1 md:px-3 md:py-1.5 lg:px-4 lg:py-2 rounded-lg md:rounded-xl text-[7px] sm:text-[8px] md:text-[9px] lg:text-xs font-medium {{ $config[0] }} text-white shadow-sm">
                                        <i class="fas {{ $config[1] }} mr-0.5 text-[6px] sm:text-[7px]"></i>
                                        {{ $relation->lien_parental }}
                                    </span>
                                </td>
                                <td class="px-2 sm:px-3 md:px-4 lg:px-6 py-2 sm:py-2.5 md:py-3 lg:py-4 hidden md:table-cell">
                                    <div class="text-[8px] sm:text-[9px] md:text-xs lg:text-sm text-gray-600 truncate max-w-[100px] sm:max-w-[120px] md:max-w-[150px]">{{ $relation->parentEleve->email ?? '-' }}</div>
                                </td>
                                <td class="px-2 sm:px-3 md:px-4 lg:px-6 py-2 sm:py-2.5 md:py-3 lg:py-4 whitespace-nowrap hidden md:table-cell">
                                    <div class="text-[8px] sm:text-[9px] md:text-xs lg:text-sm text-gray-600">{{ $relation->created_at->format('d/m/Y') }}</div>
                                </td>
                                <td class="px-2 sm:px-3 md:px-4 lg:px-6 py-2 sm:py-2.5 md:py-3 lg:py-4 whitespace-nowrap text-right">
                                    <div class="flex items-center justify-end gap-1 md:gap-2 whitespace-nowrap">
                                        <!-- Voir -->
                                        <a href="{{ route('admin.eleve-parents.show', $relation) }}" class="p-1.5 md:p-2 text-blue-600 bg-transparent hover:bg-blue-50 rounded-lg transition-colors border-none" title="Voir">
                                            <i class="fas fa-eye w-4 h-4 md:w-5 md:h-5 flex items-center justify-center"></i>
                                        </a>
                                        
                                        <!-- Modifier -->
                                        <a href="{{ route('admin.eleve-parents.edit', $relation) }}" class="p-1.5 md:p-2 text-amber-600 bg-transparent hover:bg-amber-50 rounded-lg transition-colors border-none" title="Modifier">
                                            <i class="fas fa-edit w-4 h-4 md:w-5 md:h-5 flex items-center justify-center"></i>
                                        </a>
                                        
                                        <!-- PDF -->
                                        <button type="button" onclick="window.location.href='{{ route('admin.eleve-parents.pdf', $relation) }}'" class="p-1.5 md:p-2 text-purple-600 bg-transparent hover:bg-purple-50 rounded-lg transition-colors border-none cursor-pointer" title="PDF">
                                            <i class="fas fa-file-pdf w-4 h-4 md:w-5 md:h-5 flex items-center justify-center"></i>
                                        </button>
                                        
                                        <!-- Message -->
                                        <button type="button" onclick="openMessageModal({{ $relation->parentEleve->id }}, '{{ addslashes($relation->parentEleve->prenom) }}')" class="p-1.5 md:p-2 text-emerald-600 bg-transparent hover:bg-emerald-50 rounded-lg transition-colors border-none cursor-pointer" title="Message">
                                            <i class="fas fa-envelope w-4 h-4 md:w-5 md:h-5 flex items-center justify-center"></i>
                                        </button>
                                        
                                        <!-- Supprimer -->
                                        <form action="{{ route('admin.eleve-parents.destroy', $relation) }}" method="POST" class="inline m-0 p-0 delete-form">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-1.5 md:p-2 text-red-600 bg-transparent hover:bg-red-50 rounded-lg transition-colors border-none flex items-center justify-center cursor-pointer" title="Supprimer">
                                                <i class="fas fa-trash w-4 h-4 md:w-5 md:h-5 flex items-center justify-center"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-3 sm:px-4 md:px-5 lg:px-6 py-8 sm:py-10 md:py-12 text-center">
                                    <i class="fas fa-handshake text-2xl sm:text-3xl text-gray-300 mb-1 sm:mb-2"></i>
                                    <p class="text-[9px] sm:text-xs text-gray-500">Aucune relation</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination - Responsive -->
            @if($relations->hasPages())
                <div class="px-3 sm:px-4 md:px-5 lg:px-6 py-2 sm:py-2.5 md:py-3 border-t">
                    <div class="flex flex-col sm:flex-row justify-between items-center gap-1.5 sm:gap-2 text-[8px] sm:text-[9px] md:text-xs lg:text-sm">
                        <span class="text-gray-600">{{ $relations->firstItem() }} - {{ $relations->lastItem() }} / {{ $relations->total() }}</span>
                        <div class="flex gap-0.5 sm:gap-1">
                            {{ $relations->onEachSide(1)->links() }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal - Responsive -->
    <div class="fixed inset-0 z-50 overflow-y-auto hidden" id="messageModal">
        <div class="flex min-h-screen items-center justify-center px-2 sm:px-3 md:px-4">
            <div class="fixed inset-0 bg-black opacity-50" id="modalBackdrop"></div>
            
            <div class="relative bg-white rounded-lg sm:rounded-xl md:rounded-2xl shadow-xl w-full max-w-md sm:max-w-lg mx-auto z-10 overflow-hidden">
                <div class="bg-indigo-600 px-3 sm:px-4 py-2 sm:py-2.5 md:py-3 flex justify-between items-center">
                    <h3 class="text-xs sm:text-sm md:text-base font-semibold text-white">Nouveau message</h3>
                    <button type="button" class="text-white hover:text-indigo-200 close-modal">
                        <i class="fas fa-times text-[10px] sm:text-xs"></i>
                    </button>
                </div>

                <form id="messageForm" method="POST" class="p-3 sm:p-4 md:p-5 lg:p-6">
                    @csrf
                    <div class="space-y-2 sm:space-y-2.5 md:space-y-3">
                        <div>
                            <label class="text-[8px] sm:text-[9px] md:text-xs lg:text-sm text-gray-700">Destinataire</label>
                            <input type="text" id="destinataire" readonly class="mt-0.5 sm:mt-1 w-full px-2 sm:px-3 py-1.5 sm:py-2 border rounded-lg text-[9px] sm:text-xs bg-gray-50">
                        </div>
                        <div>
                            <label class="text-[8px] sm:text-[9px] md:text-xs lg:text-sm text-gray-700">Sujet</label>
                            <input type="text" name="sujet" required class="mt-0.5 sm:mt-1 w-full px-2 sm:px-3 py-1.5 sm:py-2 border rounded-lg text-[9px] sm:text-xs">
                        </div>
                        <div>
                            <label class="text-[8px] sm:text-[9px] md:text-xs lg:text-sm text-gray-700">Message</label>
                            <textarea name="message" rows="3" required class="mt-0.5 sm:mt-1 w-full px-2 sm:px-3 py-1.5 sm:py-2 border rounded-lg text-[9px] sm:text-xs"></textarea>
                        </div>
                    </div>
                </form>
                <div class="px-3 sm:px-4 py-2 sm:py-2.5 md:py-3 bg-gray-50 flex justify-end gap-1.5 sm:gap-2">
                    <button type="button" class="px-2 sm:px-2.5 md:px-3 py-1 sm:py-1.5 text-[8px] sm:text-[9px] md:text-xs border rounded-lg close-modal">Annuler</button>
                    <button type="submit" form="messageForm" class="px-2 sm:px-2.5 md:px-3 py-1 sm:py-1.5 text-[8px] sm:text-[9px] md:text-xs bg-indigo-600 text-white rounded-lg">Envoyer</button>
                </div>
            </div>
        </div>
    </div>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endsection

@push('styles')
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
    
    .overflow-x-hidden {
        overflow-x: hidden !important;
    }
    
    @keyframes slideDown { 
        from { opacity: 0; transform: translateY(-5px); } 
        to { opacity: 1; transform: translateY(0); } 
    }
    .animate-slideDown { animation: slideDown 0.3s ease-out; }
    
    /* Ajustement pour les très petits écrans */
    @media (max-width: 480px) {
        .container {
            padding-left: 0.75rem !important;
            padding-right: 0.75rem !important;
        }
        
        .py-8 {
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
        }
        
        .text-sm {
            font-size: 0.65rem;
        }
        
        .text-xs {
            font-size: 0.55rem;
        }
    }
    
    /* Tableau responsive */
    @media (max-width: 640px) {
        .overflow-x-auto {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        
        table {
            min-width: 600px;
        }
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Select All
    const selectAll = document.getElementById('selectAll');
    const rowCheckboxes = document.querySelectorAll('.row-checkbox');
    const selectedCount = document.getElementById('selectedCount');

    if (selectAll) {
        selectAll.addEventListener('change', (e) => {
            rowCheckboxes.forEach(cb => cb.checked = e.target.checked);
            updateCount();
        });
    }
    rowCheckboxes.forEach(cb => cb.addEventListener('change', updateCount));

    function updateCount() {
        if (selectedCount) selectedCount.textContent = document.querySelectorAll('.row-checkbox:checked').length;
    }

    // Filters
    const searchInput = document.getElementById('searchInput');
    const lienFilter = document.getElementById('lienFilter');
    const dateFilter = document.getElementById('dateFilter');

    function applyFilters() {
        const search = searchInput.value.toLowerCase();
        const lien = lienFilter.value;
        const date = dateFilter.value;
        
        document.querySelectorAll('#relationsTable tbody tr').forEach(row => {
            const text = row.textContent.toLowerCase();
            const lienText = row.querySelector('td:nth-child(4)')?.textContent.trim() || '';
            const dateText = row.querySelector('td:nth-child(6)')?.textContent.trim().split(' ')[0] || '';
            
            const matchSearch = text.includes(search);
            const matchLien = !lien || lienText.includes(lien);
            const matchDate = !date || dateText === date.split('-').reverse().join('/');
            
            row.style.display = (matchSearch && matchLien && matchDate) ? '' : 'none';
        });
    }

    searchInput?.addEventListener('keyup', applyFilters);
    lienFilter?.addEventListener('change', applyFilters);
    dateFilter?.addEventListener('change', applyFilters);

    document.getElementById('resetFilters')?.addEventListener('click', () => {
        searchInput.value = '';
        lienFilter.value = '';
        dateFilter.value = '';
        applyFilters();
    });

    // Delete
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({ title: 'Supprimer ?', text: "Action irréversible", icon: 'warning', showCancelButton: true, confirmButtonColor: '#ef4444' })
            .then((result) => { if (result.isConfirmed) this.submit(); });
        });
    });

    // Modal
    const modal = document.getElementById('messageModal');
    const backdrop = document.getElementById('modalBackdrop');
    
    window.openMessageModal = function(id, name) {
        document.getElementById('destinataire').value = name;
        modal.classList.remove('hidden');
    }
    
    function closeModal() { modal.classList.add('hidden'); }

    document.querySelectorAll('.close-modal').forEach(btn => btn.addEventListener('click', closeModal));
    backdrop?.addEventListener('click', closeModal);
});
</script>
@endpush