{{-- resources/views/admin/classes/index.blade.php --}}
@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Gestion des Classes') }}
    </h2>
@endsection

@section('content')
    {{-- Container avec padding horizontal responsive --}}
    <div class="py-6 md:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- En-tête moderne -->
            <div class="bg-gradient-to-r from-indigo-600 via-indigo-700 to-purple-700 rounded-xl md:rounded-2xl shadow-2xl mb-6 md:mb-8 overflow-hidden relative group">
                <div class="absolute inset-0 bg-gradient-to-r from-white/10 to-transparent"></div>

                <div class="relative px-4 sm:px-6 md:px-8 py-4 md:py-6">
                    <div class="flex flex-col gap-4">
                        <!-- Ligne 1: Titre et Info -->
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div class="flex items-center space-x-3 md:space-x-4">
                                <div class="bg-white/20 p-2 md:p-3 rounded-lg md:rounded-xl backdrop-blur-sm flex-shrink-0">
                                    <svg class="w-6 h-6 md:w-8 md:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                </div>
                                <div class="min-w-0"> {{-- min-w-0 permet au texte de wrap correctement --}}
                                    <h3 class="text-xl sm:text-2xl font-bold text-white truncate">Liste des Classes</h3>
                                    @if(isset($anneeScolaire) && $anneeScolaire)
                                        <p class="text-indigo-100 flex items-center text-xs sm:text-sm mt-1">
                                            <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            <span class="truncate">{{ $anneeScolaire->nom }}</span>
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Ligne 2: Boutons d'action -->
                        <div class="flex flex-col sm:flex-row gap-2 sm:gap-3 sm:justify-end">
                            <a href="{{ route('admin.classes.exports.pdf', request()->query()) }}"
                               class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2.5 bg-red-500 rounded-lg text-xs font-semibold text-white hover:bg-red-600 transition shadow-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path>
                                </svg>
                                PDF
                            </a>

                            <a href="{{ route('admin.classes.exports.excel', request()->query()) }}"
                               class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2.5 bg-emerald-500 rounded-lg text-xs font-semibold text-white hover:bg-emerald-600 transition shadow-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Excel
                            </a>

                            <a href="{{ route('admin.classes.create') }}"
                               class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2.5 bg-white rounded-lg text-xs font-semibold text-indigo-600 hover:bg-indigo-50 transition shadow-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Nouvelle Classe
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cartes statistiques -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 md:gap-6 mb-6 md:mb-8">
                <!-- Total Classes -->
                <div class="bg-white rounded-xl md:rounded-2xl shadow p-4 md:p-5 border-l-4 border-indigo-500 hover:shadow-lg transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[10px] md:text-xs text-gray-500 font-medium uppercase">Total Classes</p>
                            <p class="text-xl md:text-2xl font-bold text-gray-900 mt-1">{{ $classes->total() }}</p>
                        </div>
                        <div class="p-2 md:p-3 bg-indigo-100 rounded-lg md:rounded-xl">
                            <svg class="w-5 h-5 md:w-6 md:h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Capacité totale -->
                <div class="bg-white rounded-xl md:rounded-2xl shadow p-4 md:p-5 border-l-4 border-emerald-500 hover:shadow-lg transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[10px] md:text-xs text-gray-500 font-medium uppercase">Capacité totale</p>
                            <p class="text-xl md:text-2xl font-bold text-gray-900 mt-1">{{ $classes->sum('capacite') }}</p>
                        </div>
                        <div class="p-2 md:p-3 bg-emerald-100 rounded-lg md:rounded-xl">
                            <svg class="w-5 h-5 md:w-6 md:h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Élèves inscrits -->
                <div class="bg-white rounded-xl md:rounded-2xl shadow p-4 md:p-5 border-l-4 border-blue-500 hover:shadow-lg transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[10px] md:text-xs text-gray-500 font-medium uppercase">Élèves inscrits</p>
                            <p class="text-xl md:text-2xl font-bold text-gray-900 mt-1">{{ $classes->sum('eleves_count') }}</p>
                        </div>
                        <div class="p-2 md:p-3 bg-blue-100 rounded-lg md:rounded-xl">
                            <svg class="w-5 h-5 md:w-6 md:h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Taux d'occupation -->
                <div class="bg-white rounded-xl md:rounded-2xl shadow p-4 md:p-5 border-l-4 border-amber-500 hover:shadow-lg transition">
                    @php
                        $totalCapacite = $classes->sum('capacite');
                        $totalEleves = $classes->sum('eleves_count');
                        $tauxOccupation = $totalCapacite > 0 ? round(($totalEleves / $totalCapacite) * 100) : 0;
                    @endphp
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[10px] md:text-xs text-gray-500 font-medium uppercase">Taux Occupation</p>
                            <p class="text-xl md:text-2xl font-bold text-gray-900 mt-1">{{ $tauxOccupation }}%</p>
                        </div>
                        <div class="p-2 md:p-3 bg-amber-100 rounded-lg md:rounded-xl">
                            <svg class="w-5 h-5 md:w-6 md:h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filtres -->
            <div class="bg-white rounded-xl shadow mb-6 overflow-hidden">
                <div class="p-4 border-b bg-gray-50">
                    <h4 class="font-semibold text-gray-800 text-sm">Filtres et recherche</h4>
                </div>
                <div class="p-4">
                    <form method="GET" action="{{ route('admin.classes.index') }}">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                            <div class="sm:col-span-2 lg:col-span-1">
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher..." class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-indigo-500">
                            </div>
                            <div>
                                <select name="niveau" class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-indigo-500">
                                    <option value="">Tous niveaux</option>
                                    <option value="Préscolaire" {{ request('niveau') == 'Préscolaire' ? 'selected' : '' }}>Préscolaire</option>
                                    <option value="Primaire" {{ request('niveau') == 'Primaire' ? 'selected' : '' }}>Primaire</option>
                                    <option value="Collège" {{ request('niveau') == 'Collège' ? 'selected' : '' }}>Collège</option>
                                    <option value="Lycée" {{ request('niveau') == 'Lycée' ? 'selected' : '' }}>Lycée</option>
                                </select>
                            </div>
                            <div>
                                <select name="annee_scolaire_id" class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-indigo-500">
                                    <option value="">Toutes années</option>
                                    @if(isset($anneesScolaires))
                                        @foreach($anneesScolaires as $annee)
                                            <option value="{{ $annee->id }}" {{ request('annee_scolaire_id') == $annee->id ? 'selected' : '' }}>{{ $annee->nom }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="mt-4 flex flex-col sm:flex-row gap-2 sm:justify-end">
                            <a href="{{ route('admin.classes.index') }}" class="w-full sm:w-auto px-4 py-2 bg-gray-100 text-gray-600 rounded-lg text-sm text-center hover:bg-gray-200">Réinitialiser</a>
                            <button type="submit" class="w-full sm:w-auto px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm hover:bg-indigo-700 shadow">Filtrer</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Alertes -->
            @if(session('success'))
                <div class="mb-4 p-3 bg-green-50 border-l-4 border-green-500 text-green-700 rounded text-sm">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="mb-4 p-3 bg-red-50 border-l-4 border-red-500 text-red-700 rounded text-sm">{{ session('error') }}</div>
            @endif

            <!-- Tableau -->
            <div class="bg-white rounded-xl shadow overflow-hidden">
                {{-- overflow-x-auto permet le scroll horizontal SEULEMENT si nécessaire sur très petit écran --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                {{-- Checkbox caché sur très petit mobile pour gagner de la place --}}
                                <th class="px-2 py-3 text-left hidden sm:table-cell">
                                    <input type="checkbox" id="selectAll" class="rounded">
                                </th>
                                <th class="px-3 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Niveau</th>
                                <th class="px-3 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Classe</th>
                                {{-- Caché sur mobile --}}
                                <th class="px-3 py-3 text-left text-xs font-semibold text-gray-500 uppercase hidden md:table-cell">Série</th>
                                <th class="px-3 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Capacité</th>
                                {{-- Caché sur mobile --}}
                                <th class="px-3 py-3 text-left text-xs font-semibold text-gray-500 uppercase hidden lg:table-cell">Année</th>
                                <th class="px-3 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($classes as $classe)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-2 py-3 hidden sm:table-cell">
                                        <input type="checkbox" class="row-checkbox rounded" value="{{ $classe->id }}">
                                    </td>
                                    <td class="px-3 py-3 whitespace-nowrap">
                                        <div class="flex items-center gap-2">
                                            <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                                <span class="text-indigo-700 font-bold text-xs">{{ strtoupper(substr($classe->niveau, 0, 2)) }}</span>
                                            </div>
                                            <span class="text-xs sm:text-sm font-medium text-gray-900">{{ $classe->niveau }}</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3 whitespace-nowrap">
                                        <div class="text-xs sm:text-sm text-gray-900 font-bold">{{ $classe->nom }}</div>
                                    </td>
                                    <td class="px-3 py-3 whitespace-nowrap hidden md:table-cell">
                                        @if($classe->serie)
                                            <span class="px-2 py-1 text-xs rounded-full bg-violet-100 text-violet-700">{{ $classe->serie }}</span>
                                        @else
                                            <span class="text-gray-300">-</span>
                                        @endif
                                    </td>
                                    <td class="px-3 py-3 whitespace-nowrap">
                                        <div class="text-xs sm:text-sm text-gray-600">{{ $classe->eleves_count }}/{{ $classe->capacite }}</div>
                                    </td>
                                    <td class="px-3 py-3 whitespace-nowrap hidden lg:table-cell">
                                        <span class="text-xs sm:text-sm text-gray-500">{{ $classe->anneeScolaire->nom ?? '-' }}</span>
                                    </td>
                                    <td class="px-3 py-3 whitespace-nowrap text-right">
                                        <div class="flex items-center justify-end gap-1 md:gap-2 whitespace-nowrap">
                                            <a href="{{ route('admin.classes.show', $classe) }}" class="p-1.5 md:p-2 text-blue-600 bg-transparent hover:bg-blue-50 rounded-lg transition-colors border-none" title="Voir">
                                                <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            </a>
                                            <a href="{{ route('admin.classes.edit', $classe) }}" class="p-1.5 md:p-2 text-amber-600 bg-transparent hover:bg-amber-50 rounded-lg transition-colors border-none" title="Modifier">
                                                <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </a>

                                            {{-- Boutons secondaires cachés sur très petit écran --}}
                                            <a href="{{ route('admin.classes.pdf', $classe) }}" class="p-1.5 md:p-2 text-green-600 bg-transparent hover:bg-green-50 rounded-lg transition-colors border-none hidden sm:block" title="PDF">
                                                <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path></svg>
                                            </a>

                                            <form action="{{ route('admin.classes.destroy', $classe) }}" method="POST" class="inline m-0 p-0 delete-form">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="p-1.5 md:p-2 text-red-600 bg-transparent hover:bg-red-50 rounded-lg transition-colors border-none flex items-center justify-center cursor-pointer" title="Supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet élément ?')">
                                                    <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-10">
                                        <p class="text-gray-500 mb-4">Aucune classe trouvée</p>
                                        <a href="{{ route('admin.classes.create') }}" class="px-4 py-2 bg-indigo-600 text-white text-sm rounded-lg">Créer une classe</a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($classes->hasPages())
                <div class="p-4 border-t bg-gray-50">
                    <div class="flex flex-col sm:flex-row justify-between items-center gap-2">
                        <p class="text-xs text-gray-500">{{ $classes->total() }} résultats</p>
                        <div class="w-full sm:w-auto overflow-x-auto">
                            {{ $classes->links() }}
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    /* Pagination compacte sur mobile */
    .pagination { display: flex; gap: 0.25rem; justify-content: center; flex-wrap: wrap; }
    .pagination .page-item { list-style: none; }
    .pagination .page-link {
        display: flex; align-items: center; justify-content: center;
        min-width: 32px; height: 32px; padding: 0 8px;
        border-radius: 6px; background: white; border: 1px solid #e5e7eb;
        font-size: 0.75rem; color: #374151;
    }
    .pagination .active .page-link { background: #4f46e5; color: white; border-color: #4f46e5; }

    /* Empêche le débordement du texte */
    .truncate { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Checkbox select all
        const selectAll = document.getElementById('selectAll');
        const checkboxes = document.querySelectorAll('.row-checkbox');
        if(selectAll) {
            selectAll.addEventListener('change', (e) => {
                checkboxes.forEach(cb => cb.checked = e.target.checked);
            });
        }

        // Delete confirmation
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Confirmer ?',
                    text: "Voulez-vous vraiment supprimer cette classe ?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Oui, supprimer',
                    cancelButtonText: 'Annuler'
                }).then((result) => {
                    if (result.isConfirmed) this.submit();
                });
            });
        });
    });
</script>
@endpush
