{{-- resources/views/admin/eleve_parents/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Gestion des relations Élèves-Parents')

@section('header')
    <div class="relative bg-gradient-to-r from-indigo-600 to-indigo-800 py-6">
        <div class="absolute inset-0 bg-black opacity-10"></div>
        <div class="container mx-auto px-6 relative">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div class="flex items-center space-x-4">
                    <div class="p-3 bg-white bg-opacity-20 rounded-2xl backdrop-filter backdrop-blur-lg">
                        <i class="fas fa-handshake fa-2x text-white"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-white">Relations Élèves-Parents</h1>
                        <p class="text-indigo-100 text-sm mt-1">Gérez les liens entre élèves et parents</p>
                    </div>
                </div>
                <nav class="mt-4 md:mt-0">
                    <ol class="flex items-center space-x-2 text-sm">
                        <li>
                            <a href="{{ route('dashboard') }}" class="text-indigo-200 hover:text-white transition-colors duration-200">
                                <i class="fas fa-home mr-1"></i>Dashboard
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
    <div class="container mx-auto px-6 py-8">
        <!-- Statistiques rapides avec icônes VISIBLES -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Total relations -->
            <div class="bg-white rounded-2xl shadow-lg p-6 transform hover:scale-105 transition-transform duration-300 border-l-4 border-indigo-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total relations</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">{{ $relations->total() }}</p>
                        <p class="text-xs text-gray-400 mt-1 flex items-center">
                            <i class="fas fa-arrow-up text-green-500 mr-1"></i>
                            <span>+2.5% ce mois</span>
                        </p>
                    </div>
                    <div class="p-4 bg-indigo-600 rounded-2xl shadow-lg">
                        <i class="fas fa-users fa-2x text-white"></i>
                    </div>
                </div>
                <div class="mt-4 h-2 w-full bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full w-3/4 bg-indigo-600 rounded-full"></div>
                </div>
            </div>

            <!-- Élèves concernés -->
            <div class="bg-white rounded-2xl shadow-lg p-6 transform hover:scale-105 transition-transform duration-300 border-l-4 border-green-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Élèves concernés</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">{{ \App\Models\Eleve::has('parents')->count() }}</p>
                        <p class="text-xs text-gray-400 mt-1 flex items-center">
                            <i class="fas fa-user-graduate text-green-500 mr-1"></i>
                            {{ \App\Models\Eleve::count() }} inscrits
                        </p>
                    </div>
                    <div class="p-4 bg-green-600 rounded-2xl shadow-lg">
                        <i class="fas fa-child fa-2x text-white"></i>
                    </div>
                </div>
                <div class="mt-4 h-2 w-full bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full w-2/3 bg-green-600 rounded-full"></div>
                </div>
            </div>

            <!-- Parents actifs -->
            <div class="bg-white rounded-2xl shadow-lg p-6 transform hover:scale-105 transition-transform duration-300 border-l-4 border-blue-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Parents actifs</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">{{ \App\Models\ParentEleve::has('eleves')->count() }}</p>
                        <p class="text-xs text-gray-400 mt-1 flex items-center">
                            <i class="fas fa-user-plus text-blue-500 mr-1"></i>
                            {{ \App\Models\ParentEleve::count() }} inscrits
                        </p>
                    </div>
                    <div class="p-4 bg-blue-600 rounded-2xl shadow-lg">
                        <i class="fas fa-user-tie fa-2x text-white"></i>
                    </div>
                </div>
                <div class="mt-4 h-2 w-full bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full w-4/5 bg-blue-600 rounded-full"></div>
                </div>
            </div>
        </div>

        <!-- Filtres avancés -->
        <div class="bg-white rounded-2xl shadow-lg mb-8">
            <div class="p-6 border-b border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-800">
                        <i class="fas fa-filter text-indigo-600 mr-2"></i>
                        Filtres avancés
                    </h2>
                    <button id="resetFilters" class="text-sm text-gray-500 hover:text-indigo-600 transition-colors duration-200">
                        <i class="fas fa-undo mr-1"></i>Réinitialiser
                    </button>
                </div>
                
                <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
                    <!-- Recherche -->
                    <div class="lg:col-span-2">
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </span>
                            <input type="text" 
                                   class="w-full pl-11 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 transition-all duration-200"
                                   placeholder="Rechercher par élève, parent, email..." 
                                   id="searchInput">
                            <span class="absolute inset-y-0 right-0 pr-4 flex items-center">
                                <kbd class="px-2 py-1 bg-gray-100 text-gray-600 text-xs rounded-md">⌘K</kbd>
                            </span>
                        </div>
                    </div>

                    <!-- Filtre lien parental -->
                    <div>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-link text-gray-400"></i>
                            </span>
                            <select class="w-full pl-11 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 appearance-none bg-white transition-all duration-200" 
                                    id="lienFilter">
                                <option value="">Tous les liens</option>
                                <option value="Père">👨 Père</option>
                                <option value="Mère">👩 Mère</option>
                                <option value="Tuteur">👤 Tuteur</option>
                                <option value="Grand-parent">👴 Grand-parent</option>
                                <option value="Autre">🤝 Autre</option>
                            </select>
                            <span class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <i class="fas fa-chevron-down text-gray-400 text-sm"></i>
                            </span>
                        </div>
                    </div>

                    <!-- Filtre date -->
                    <div>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-calendar text-gray-400"></i>
                            </span>
                            <input type="date" 
                                   class="w-full pl-11 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 transition-all duration-200"
                                   id="dateFilter">
                        </div>
                    </div>
                </div>

                <!-- Filtres actifs -->
                <div class="flex flex-wrap gap-2 mt-4" id="activeFilters"></div>
            </div>

            <!-- Actions -->
            <div class="px-6 py-4 bg-gray-50 rounded-b-2xl">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-check-circle text-indigo-500 mr-1"></i>
                        <span class="text-sm text-gray-600">
                            <span id="selectedCount" class="font-semibold text-indigo-600">0</span> élément(s) sélectionné(s)
                        </span>
                        <div class="h-4 w-px bg-gray-300"></div>
                        <button class="text-sm text-gray-600 hover:text-indigo-600 transition-colors duration-200">
                            <i class="fas fa-download mr-1"></i>Exporter la sélection
                        </button>
                    </div>
                    
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('admin.eleve-parents.export.pdf') }}" 
                           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-xl text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 hover:border-red-400 hover:text-red-600 transition-all duration-200 group">
                            <i class="fas fa-file-pdf mr-2 text-red-500 group-hover:text-red-600"></i>
                            PDF
                        </a>
                        <a href="{{ route('admin.eleve-parents.export.excel') }}" 
                           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-xl text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 hover:border-green-400 hover:text-green-600 transition-all duration-200 group">
                            <i class="fas fa-file-excel mr-2 text-green-500 group-hover:text-green-600"></i>
                            Excel
                        </a>
                        <a href="{{ route('admin.eleve-parents.create') }}" 
                           class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white text-sm font-medium rounded-xl hover:from-indigo-700 hover:to-indigo-800 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 shadow-lg shadow-indigo-200">
                            <i class="fas fa-plus-circle mr-2"></i>
                            Nouvelle relation
                        </a>
                    </div>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 rounded-r-xl p-4 shadow-md animate-slideDown">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="h-10 w-10 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-check-circle text-green-500 text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                    </div>
                    <button type="button" class="ml-auto text-green-600 hover:text-green-800" onclick="this.parentElement.parentElement.remove()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        @endif

        <!-- Tableau des relations -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200" id="relationsTable">
                    <thead>
                        <tr class="bg-gradient-to-r from-gray-50 to-gray-100">
                            <th class="px-6 py-5 text-left">
                                <div class="flex items-center">
                                    <input type="checkbox" 
                                           class="w-4 h-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 transition-all duration-200"
                                           id="selectAll">
                                </div>
                            </th>
                            <th class="px-6 py-5 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                <div class="flex items-center space-x-1 cursor-pointer hover:text-indigo-600" onclick="sortTable(1)">
                                    <span>Élève</span>
                                    <i class="fas fa-sort text-gray-400 text-xs"></i>
                                </div>
                            </th>
                            <th class="px-6 py-5 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                <div class="flex items-center space-x-1 cursor-pointer hover:text-indigo-600" onclick="sortTable(2)">
                                    <span>Parent</span>
                                    <i class="fas fa-sort text-gray-400 text-xs"></i>
                                </div>
                            </th>
                            <th class="px-6 py-5 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Lien</th>
                            <th class="px-6 py-5 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Contact</th>
                            <th class="px-6 py-5 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                <div class="flex items-center space-x-1 cursor-pointer hover:text-indigo-600" onclick="sortTable(5)">
                                    <span>Date</span>
                                    <i class="fas fa-sort text-gray-400 text-xs"></i>
                                </div>
                            </th>
                            <th class="px-6 py-5 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($relations as $relation)
                            <tr class="group hover:bg-indigo-50/50 transition-all duration-200">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input type="checkbox" 
                                           class="row-checkbox w-4 h-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 transition-all duration-200"
                                           value="{{ $relation->id }}">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-11 w-11">
                                            <div class="h-11 w-11 rounded-xl bg-gradient-to-br from-indigo-100 to-indigo-200 flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                                                <span class="text-indigo-700 font-semibold text-sm">
                                                    {{ strtoupper(substr($relation->eleve->prenom, 0, 1)) }}{{ strtoupper(substr($relation->eleve->nom, 0, 1)) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-semibold text-gray-900">{{ $relation->eleve->prenom }} {{ $relation->eleve->nom }}</div>
                                            <div class="flex items-center text-xs text-gray-500 mt-1">
                                                <i class="fas fa-graduation-cap text-indigo-400 mr-1"></i>
                                                {{ $relation->eleve->classe->nom ?? 'Non assigné' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-11 w-11">
                                            <div class="h-11 w-11 rounded-xl bg-gradient-to-br from-green-100 to-green-200 flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                                                <span class="text-green-700 font-semibold text-sm">
                                                    {{ strtoupper(substr($relation->parentEleve->prenom, 0, 1)) }}{{ strtoupper(substr($relation->parentEleve->nom, 0, 1)) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-semibold text-gray-900">{{ $relation->parentEleve->prenom }} {{ $relation->parentEleve->nom }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $badgeConfig = [
                                            'Père' => ['bg-blue-600', 'text-white', 'fa-mars'],
                                            'Mère' => ['bg-pink-600', 'text-white', 'fa-venus'],
                                            'Tuteur' => ['bg-purple-600', 'text-white', 'fa-user-tie'],
                                            'Grand-parent' => ['bg-amber-600', 'text-white', 'fa-users'],
                                            'Autre' => ['bg-gray-600', 'text-white', 'fa-heart']
                                        ];
                                        $config = $badgeConfig[$relation->lien_parental] ?? $badgeConfig['Autre'];
                                    @endphp
                                    <span class="inline-flex items-center px-4 py-2 rounded-xl text-xs font-medium {{ $config[0] }} {{ $config[1] }} shadow-md">
                                        <i class="fas {{ $config[2] }} mr-2 text-white"></i>
                                        {{ $relation->lien_parental }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="space-y-1">
                                        <div class="flex items-center text-sm">
                                            <i class="fas fa-envelope text-indigo-500 w-4 mr-2"></i>
                                            <span class="text-gray-600 text-sm">{{ Str::limit($relation->parentEleve->email, 20) }}</span>
                                        </div>
                                        @if($relation->parentEleve->telephone)
                                            <div class="flex items-center text-sm">
                                                <i class="fas fa-phone-alt text-green-500 w-4 mr-2"></i>
                                                <span class="text-gray-600 text-sm">{{ $relation->parentEleve->telephone }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center space-x-3">
                                        <div class="text-sm text-gray-600">
                                            <div class="flex items-center">
                                                <i class="far fa-calendar-alt text-indigo-500 mr-1"></i>
                                                {{ $relation->created_at->format('d/m/Y') }}
                                            </div>
                                            <div class="flex items-center mt-1 text-xs text-gray-500">
                                                <i class="far fa-clock text-indigo-400 mr-1"></i>
                                                {{ $relation->created_at->format('H:i') }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <!-- Voir les détails -->
                                        <a href="{{ route('admin.eleve-parents.show', $relation) }}" 
                                           class="relative group p-3 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 hover:scale-110 hover:shadow-lg transition-all duration-200"
                                           title="Voir les détails">
                                            <i class="fas fa-eye text-lg"></i>
                                            <span class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-900 text-white text-xs py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap z-50">
                                                Voir détails
                                            </span>
                                        </a>
                                        
                                        <!-- Modifier -->
                                        <a href="{{ route('admin.eleve-parents.edit', $relation) }}" 
                                           class="relative group p-3 bg-amber-600 text-white rounded-xl hover:bg-amber-700 hover:scale-110 hover:shadow-lg transition-all duration-200"
                                           title="Modifier">
                                            <i class="fas fa-edit text-lg"></i>
                                            <span class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-900 text-white text-xs py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap z-50">
                                                Modifier
                                            </span>
                                        </a>
                                        
                                        <!-- Télécharger PDF -->
                                        <button type="button" 
                                                onclick="window.location.href='{{ route('admin.eleve-parents.pdf', $relation) }}'"
                                                class="relative group p-3 bg-red-600 text-white rounded-xl hover:bg-red-700 hover:scale-110 hover:shadow-lg transition-all duration-200"
                                                title="Télécharger PDF">
                                            <i class="fas fa-file-pdf text-lg"></i>
                                            <span class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-900 text-white text-xs py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap z-50">
                                                Télécharger PDF
                                            </span>
                                        </button>
                                        
                                        <!-- Envoyer un message -->
                                        <button type="button" 
                                                onclick="openMessageModal({{ $relation->parentEleve->id }}, '{{ $relation->parentEleve->prenom }} {{ $relation->parentEleve->nom }}')"
                                                class="relative group p-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 hover:scale-110 hover:shadow-lg transition-all duration-200"
                                                title="Envoyer un message">
                                            <i class="fas fa-envelope text-lg"></i>
                                            <span class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-900 text-white text-xs py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap z-50">
                                                Envoyer message
                                            </span>
                                        </button>
                                        
                                        <!-- Supprimer -->
                                        <form action="{{ route('admin.eleve-parents.destroy', $relation) }}" method="POST" class="inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="relative group p-3 bg-red-600 text-white rounded-xl hover:bg-red-700 hover:scale-110 hover:shadow-lg transition-all duration-200"
                                                    title="Supprimer">
                                                <i class="fas fa-trash text-lg"></i>
                                                <span class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-900 text-white text-xs py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap z-50">
                                                    Supprimer
                                                </span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-16">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-20 h-20 bg-gray-200 rounded-2xl flex items-center justify-center mb-4">
                                            <i class="fas fa-handshake fa-3x text-gray-500"></i>
                                        </div>
                                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Aucune relation trouvée</h3>
                                        <p class="text-gray-500 text-center mb-6">Commencez par créer une nouvelle relation entre un élève et un parent</p>
                                        <a href="{{ route('admin.eleve-parents.create') }}" 
                                           class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white text-sm font-medium rounded-xl hover:bg-indigo-700 transition-all duration-200 shadow-lg shadow-indigo-200">
                                            <i class="fas fa-plus-circle mr-2"></i>
                                            Créer une relation
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination élégante -->
            @if($relations->hasPages())
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-100">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div class="text-sm text-gray-600 flex items-center">
                            <i class="fas fa-list-ul text-indigo-500 mr-2"></i>
                            <span class="font-medium text-indigo-600">{{ $relations->firstItem() }}</span>
                            à
                            <span class="font-medium text-indigo-600">{{ $relations->lastItem() }}</span>
                            sur
                            <span class="font-medium text-indigo-600">{{ $relations->total() }}</span>
                            relations
                        </div>
                        <div class="flex items-center space-x-2">
                            {{ $relations->onEachSide(1)->links() }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal moderne pour l'envoi de message -->
    <div class="fixed inset-0 z-50 overflow-y-auto hidden" id="messageModal">
        <div class="flex min-h-screen items-end justify-center px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-900 bg-opacity-50 backdrop-blur-sm transition-opacity" id="modalBackdrop"></div>
            
            <span class="hidden sm:inline-block sm:h-screen sm:align-middle">&#8203;</span>
            
            <div class="relative inline-block transform overflow-hidden rounded-2xl bg-white text-left align-bottom shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:align-middle">
                <!-- En-tête du modal -->
                <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 px-6 py-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="h-10 w-10 rounded-xl bg-white bg-opacity-20 flex items-center justify-center">
                                <i class="fas fa-envelope text-white text-xl"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-white">Nouveau message</h3>
                            <p class="text-indigo-100 text-sm">Envoyez un message au parent</p>
                        </div>
                        <button type="button" class="ml-auto text-white hover:text-indigo-200 close-modal">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>

                <!-- Corps du modal -->
                <form id="messageForm" method="POST" class="p-6">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-user text-indigo-600 mr-2"></i>Destinataire
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-user-circle text-gray-400"></i>
                                </span>
                                <input type="text" 
                                       class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl bg-gray-50 text-gray-700"
                                       id="destinataire" 
                                       readonly>
                            </div>
                        </div>

                        <div>
                            <label for="sujet" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-heading text-indigo-600 mr-2"></i>Sujet
                            </label>
                            <input type="text" 
                                   class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 transition-all duration-200"
                                   id="sujet" 
                                   name="sujet" 
                                   placeholder="Objet du message..."
                                   required>
                        </div>

                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-comment text-indigo-600 mr-2"></i>Message
                            </label>
                            <textarea class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 transition-all duration-200" 
                                      id="message" 
                                      name="message" 
                                      rows="5" 
                                      placeholder="Écrivez votre message..."
                                      required></textarea>
                        </div>
                    </div>
                </form>

                <!-- Pied du modal -->
                <div class="bg-gray-50 px-6 py-4 flex justify-end space-x-3">
                    <button type="button" 
                            class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-100 transition-all duration-200 close-modal">
                        Annuler
                    </button>
                    <button type="submit" 
                            form="messageForm"
                            class="px-6 py-2 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white text-sm font-medium rounded-lg hover:from-indigo-700 hover:to-indigo-800 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 shadow-lg shadow-indigo-200">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Envoyer
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Ajout de Font Awesome si pas déjà présent -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endsection

@push('styles')
<style>
    /* Animations personnalisées */
    @keyframes slideDown {
        from {
            transform: translateY(-100%);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .animate-slideDown {
        animation: slideDown 0.3s ease-out;
    }

    /* Personnalisation des scrollbars */
    .overflow-x-auto::-webkit-scrollbar {
        height: 8px;
    }

    .overflow-x-auto::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .overflow-x-auto::-webkit-scrollbar-thumb {
        background: #cbd5e0;
        border-radius: 10px;
    }

    .overflow-x-auto::-webkit-scrollbar-thumb:hover {
        background: #a0aec0;
    }

    /* Style pour les tooltips */
    .group .absolute {
        pointer-events: none;
        z-index: 50;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    /* Icônes toujours visibles */
    .fas, .far {
        display: inline-block;
        font-style: normal;
        font-variant: normal;
        text-rendering: auto;
        line-height: 1;
    }

    /* Assurer que les icônes sont bien blanches sur fond coloré */
    .bg-indigo-600 .fas,
    .bg-indigo-600 .far,
    .bg-green-600 .fas,
    .bg-green-600 .far,
    .bg-blue-600 .fas,
    .bg-blue-600 .far,
    .bg-amber-600 .fas,
    .bg-amber-600 .far,
    .bg-red-600 .fas,
    .bg-red-600 .far,
    .bg-purple-600 .fas,
    .bg-purple-600 .far {
        color: white !important;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Vérifier si Font Awesome est chargé
    if (typeof window.FontAwesome === 'undefined') {
        console.warn('Font Awesome n\'est pas chargé, ajout du CDN...');
        const link = document.createElement('link');
        link.rel = 'stylesheet';
        link.href = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css';
        document.head.appendChild(link);
    }

    // Gestionnaire pour le raccourci clavier (⌘K)
    document.addEventListener('keydown', function(e) {
        if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
            e.preventDefault();
            const searchInput = document.getElementById('searchInput');
            if (searchInput) searchInput.focus();
        }
    });

    // Checkbox "Tout sélectionner"
    const selectAll = document.getElementById('selectAll');
    const rowCheckboxes = document.querySelectorAll('.row-checkbox');
    const selectedCount = document.getElementById('selectedCount');

    function updateSelectedCount() {
        const checked = document.querySelectorAll('.row-checkbox:checked').length;
        if (selectedCount) {
            selectedCount.textContent = checked;
        }
    }

    if (selectAll) {
        selectAll.addEventListener('change', function(e) {
            rowCheckboxes.forEach(checkbox => {
                checkbox.checked = e.target.checked;
            });
            updateSelectedCount();
        });
    }

    rowCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateSelectedCount);
    });

    // Filtre de recherche avec debounce
    let searchTimeout;
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('keyup', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                let searchText = this.value.toLowerCase();
                let tableRows = document.querySelectorAll('#relationsTable tbody tr');

                tableRows.forEach(row => {
                    if (row.querySelector('.empty-state')) return;
                    let text = row.textContent.toLowerCase();
                    row.style.display = text.includes(searchText) ? '' : 'none';
                });
            }, 300);
        });
    }

    // Filtre par lien parental
    const lienFilter = document.getElementById('lienFilter');
    if (lienFilter) {
        lienFilter.addEventListener('change', function() {
            let filterValue = this.value;
            let tableRows = document.querySelectorAll('#relationsTable tbody tr');

            tableRows.forEach(row => {
                if (row.querySelector('.empty-state')) return;
                let lienCell = row.querySelector('td:nth-child(4) span');
                if (lienCell) {
                    let lienText = lienCell.textContent.trim();
                    row.style.display = !filterValue || lienText.includes(filterValue) ? '' : 'none';
                }
            });
        });
    }

    // Filtre par date
    const dateFilter = document.getElementById('dateFilter');
    if (dateFilter) {
        dateFilter.addEventListener('change', function() {
            let filterDate = this.value;
            let tableRows = document.querySelectorAll('#relationsTable tbody tr');

            tableRows.forEach(row => {
                if (row.querySelector('.empty-state')) return;
                let dateCell = row.querySelector('td:nth-child(6)');
                if (dateCell) {
                    let rowDate = dateCell.textContent.trim().split(' ')[0];
                    row.style.display = !filterDate || rowDate === filterDate.split('-').reverse().join('/') ? '' : 'none';
                }
            });
        });
    }

    // Réinitialiser les filtres
    const resetFilters = document.getElementById('resetFilters');
    if (resetFilters) {
        resetFilters.addEventListener('click', function() {
            if (searchInput) searchInput.value = '';
            if (lienFilter) lienFilter.value = '';
            if (dateFilter) dateFilter.value = '';
            
            document.querySelectorAll('#relationsTable tbody tr').forEach(row => {
                row.style.display = '';
            });
        });
    }

    // Confirmation de suppression avec SweetAlert2
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Êtes-vous sûr ?',
                text: "Cette action est irréversible !",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Oui, supprimer',
                cancelButtonText: 'Annuler',
                background: '#ffffff'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
    });

    // Fermeture du modal
    const closeButtons = document.querySelectorAll('.close-modal');
    closeButtons.forEach(btn => {
        btn.addEventListener('click', closeMessageModal);
    });

    // Fermeture en cliquant sur le backdrop
    const modalBackdrop = document.getElementById('modalBackdrop');
    if (modalBackdrop) {
        modalBackdrop.addEventListener('click', closeMessageModal);
    }
});

// Fonction pour trier le tableau
function sortTable(columnIndex) {
    const table = document.getElementById('relationsTable');
    if (!table) return;
    
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr:not([style*="display: none"])'));
    
    const sortedRows = rows.sort((a, b) => {
        const aValue = a.querySelector(`td:nth-child(${columnIndex})`)?.textContent.trim() || '';
        const bValue = b.querySelector(`td:nth-child(${columnIndex})`)?.textContent.trim() || '';
        
        return aValue.localeCompare(bValue);
    });
    
    tbody.append(...sortedRows);
}

// Fonction pour ouvrir le modal de message
function openMessageModal(parentId, parentName) {
    const destinataire = document.getElementById('destinataire');
    if (destinataire) {
        destinataire.value = parentName;
    }
    
    const modal = document.getElementById('messageModal');
    const backdrop = document.getElementById('modalBackdrop');
    
    if (modal) modal.classList.remove('hidden');
    if (backdrop) backdrop.classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
}

// Fonction pour fermer le modal
function closeMessageModal() {
    const modal = document.getElementById('messageModal');
    const backdrop = document.getElementById('modalBackdrop');
    
    if (modal) modal.classList.add('hidden');
    if (backdrop) backdrop.classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
    
    const form = document.getElementById('messageForm');
    if (form) form.reset();
}

// Gestion des touches clavier pour fermer le modal
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const modal = document.getElementById('messageModal');
        if (modal && !modal.classList.contains('hidden')) {
            closeMessageModal();
        }
    }
});
</script>
@endpush