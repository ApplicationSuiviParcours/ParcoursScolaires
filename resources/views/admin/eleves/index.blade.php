{{-- resources/views/admin/eleves/index.blade.php --}}
@extends('layouts.app')

@section('header')
    {{-- Titre Header Responsive --}}
    <h2 class="font-semibold text-base md:text-xl text-gray-800 leading-tight">
        {{ __('Gestion des élèves') }}
    </h2>
@endsection

@section('content')
    {{-- Padding réduit sur mobile --}}
    <div class="py-4 md:py-8 lg:py-12">
        <div class="max-w-7xl mx-auto px-2 sm:px-4 lg:px-8">

            <!-- Messages flash -->
            @if(session('success'))
                <div class="mb-3 md:mb-4 p-3 md:p-4 bg-green-50 border-l-4 border-green-400 text-green-700 rounded-r-lg shadow-sm text-xs md:text-sm" role="alert">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 md:w-5 md:h-5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-3 md:mb-4 p-3 md:p-4 bg-red-50 border-l-4 border-red-400 text-red-700 rounded-r-lg shadow-sm text-xs md:text-sm" role="alert">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 md:w-5 md:h-5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            <!-- Stats Cards -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 md:gap-6 mb-6 md:mb-8">
                <!-- Total élèves -->
                <div class="group bg-white rounded-xl md:rounded-2xl shadow p-4 md:p-6 border-l-4 border-blue-500 hover:shadow-lg transition-all">
                    <div class="flex items-center justify-between">
                        <div>
                            {{-- Titre Carte Responsive --}}
                            <p class="text-[10px] md:text-xs font-medium text-gray-500 uppercase tracking-wider">Total élèves</p>
                            {{-- Valeur Responsive --}}
                            <p class="text-xl md:text-3xl font-bold text-gray-800 mt-1">{{ $stats['total'] }}</p>
                            <p class="text-[10px] md:text-xs text-gray-400 mt-1 hidden sm:block">Inscrits</p>
                        </div>
                        <div class="bg-blue-100 p-2 md:p-3 rounded-lg md:rounded-xl group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5 md:w-6 md:h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Actifs -->
                <div class="group bg-white rounded-xl md:rounded-2xl shadow p-4 md:p-6 border-l-4 border-green-500 hover:shadow-lg transition-all">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[10px] md:text-xs font-medium text-gray-500 uppercase tracking-wider">Actifs</p>
                            <p class="text-xl md:text-3xl font-bold text-green-600 mt-1">{{ $stats['actifs'] }}</p>
                            <p class="text-[10px] md:text-xs text-gray-400 mt-1 hidden sm:block">Inactifs: {{ $stats['inactifs'] }}</p>
                        </div>
                        <div class="bg-green-100 p-2 md:p-3 rounded-lg md:rounded-xl group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5 md:w-6 md:h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Garçons -->
                <div class="group bg-white rounded-xl md:rounded-2xl shadow p-4 md:p-6 border-l-4 border-blue-600 hover:shadow-lg transition-all">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[10px] md:text-xs font-medium text-gray-500 uppercase tracking-wider">Garçons</p>
                            <p class="text-xl md:text-3xl font-bold text-blue-600 mt-1">{{ $stats['garcons'] }}</p>
                            <p class="text-[10px] md:text-xs text-gray-400 mt-1 hidden sm:block">{{ $stats['total'] > 0 ? round(($stats['garcons'] / $stats['total']) * 100, 1) : 0 }}%</p>
                        </div>
                        <div class="bg-blue-100 p-2 md:p-3 rounded-lg md:rounded-xl group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5 md:w-6 md:h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Filles -->
                <div class="group bg-white rounded-xl md:rounded-2xl shadow p-4 md:p-6 border-l-4 border-pink-500 hover:shadow-lg transition-all">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[10px] md:text-xs font-medium text-gray-500 uppercase tracking-wider">Filles</p>
                            <p class="text-xl md:text-3xl font-bold text-pink-500 mt-1">{{ $stats['filles'] }}</p>
                            <p class="text-[10px] md:text-xs text-gray-400 mt-1 hidden sm:block">{{ $stats['total'] > 0 ? round(($stats['filles'] / $stats['total']) * 100, 1) : 0 }}%</p>
                        </div>
                        <div class="bg-pink-100 p-2 md:p-3 rounded-lg md:rounded-xl group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5 md:w-6 md:h-6 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section Filtres -->
            <div class="bg-white rounded-xl md:rounded-2xl shadow mb-6 md:mb-8 overflow-hidden border border-gray-100">
                <div class="p-4 md:p-5 bg-gradient-to-r from-gray-50 to-white border-b border-gray-100">
                    {{-- Titre Section Responsive --}}
                    <h4 class="text-base md:text-lg font-bold text-gray-800">Recherche et filtres</h4>
                </div>
                <div class="p-4 md:p-6">
                    <form method="GET" action="{{ route('admin.eleves.index') }}" class="space-y-4">

                        <!-- Groupe Rechercher -->
                        <div class="flex flex-col sm:flex-row gap-3">
                            <div class="relative flex-1">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 md:w-5 md:h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </div>
                                <input type="text" name="search" placeholder="Nom, prénom, matricule..." value="{{ request('search') }}"
                                       class="block w-full pl-10 pr-3 py-2.5 md:py-3 border border-gray-200 rounded-lg md:rounded-xl text-xs md:text-sm focus:border-blue-400 focus:ring-1">
                            </div>
                            <div class="flex gap-2">
                                <button type="submit" class="flex-1 sm:flex-none px-4 md:px-6 py-2.5 md:py-3 bg-blue-600 text-white rounded-lg md:rounded-xl text-xs md:text-sm font-medium shadow-sm">
                                    Rechercher
                                </button>
                                @if(request('search') || request('statut'))
                                    <a href="{{ route('admin.eleves.index') }}" class="px-4 py-2.5 md:py-3 border border-gray-200 rounded-lg md:rounded-xl text-xs md:text-sm font-medium text-gray-600 hover:bg-gray-50">
                                        Reset
                                    </a>
                                @endif
                            </div>
                        </div>

                        <!-- Grille Filtres -->
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <select name="classe_id" class="w-full px-3 py-2.5 border border-gray-200 rounded-lg md:rounded-xl text-xs md:text-sm">
                                <option value="">Toutes les classes</option>
                                @foreach($classes as $classe)
                                    <option value="{{ $classe->id }}" {{ request('classe_id') == $classe->id ? 'selected' : '' }}>{{ $classe->nom }}</option>
                                @endforeach
                            </select>
                            <select name="annee_scolaire_id" class="w-full px-3 py-2.5 border border-gray-200 rounded-lg md:rounded-xl text-xs md:text-sm">
                                <option value="">Toutes les années</option>
                                @foreach($anneesScolaires as $annee)
                                    <option value="{{ $annee->id }}" {{ request('annee_scolaire_id') == $annee->id ? 'selected' : '' }}>{{ $annee->nom }}</option>
                                @endforeach
                            </select>
                            <select name="statut" class="w-full px-3 py-2.5 border border-gray-200 rounded-lg md:rounded-xl text-xs md:text-sm">
                                <option value="">Tous les statuts</option>
                                <option value="1" {{ request('statut') === '1' ? 'selected' : '' }}>Actifs</option>
                                <option value="0" {{ request('statut') === '0' ? 'selected' : '' }}>Inactifs</option>
                            </select>
                        </div>
                    </form>

                    <!-- Actions Export & Add -->
                    <div class="mt-4 pt-4 border-t flex flex-col sm:flex-row items-stretch sm:items-center gap-2">
                        <a href="{{ route('admin.eleves.exports.pdf', request()->query()) }}"
                           class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 bg-red-500 text-white rounded-lg text-xs font-medium shadow-sm">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path></svg>
                            Export PDF
                        </a>
                        <a href="{{ route('admin.eleves.export.excel', request()->query()) }}"
                           class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 bg-green-600 text-white rounded-lg text-xs font-medium shadow-sm">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path></svg>
                            Export Excel
                        </a>
                        <a href="{{ route('admin.eleves.create') }}"
                           class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white rounded-lg text-xs font-medium shadow-sm sm:ml-auto">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Ajouter un élève
                        </a>
                    </div>
                </div>
            </div>

            <!-- Tableau -->
            <div class="bg-white rounded-xl md:rounded-2xl shadow overflow-hidden border border-gray-100">
                <div class="overflow-x-auto">
                    <table class="min-w-full w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                {{-- Photo cachée sur très petit écran --}}
                                <th class="px-2 py-2 md:px-4 md:py-3 text-left text-[10px] md:text-xs font-semibold text-gray-500 uppercase hidden sm:table-cell">Photo</th>
                                <th class="px-2 py-2 md:px-4 md:py-3 text-left text-[10px] md:text-xs font-semibold text-gray-500 uppercase">Identité</th>
                                <th class="px-2 py-2 md:px-4 md:py-3 text-left text-[10px] md:text-xs font-semibold text-gray-500 uppercase hidden md:table-cell">Matricule</th>
                                <th class="px-2 py-2 md:px-4 md:py-3 text-left text-[10px] md:text-xs font-semibold text-gray-500 uppercase">Classe</th>
                                <th class="px-2 py-2 md:px-4 md:py-3 text-left text-[10px] md:text-xs font-semibold text-gray-500 uppercase hidden lg:table-cell">Genre</th>
                                <th class="px-2 py-2 md:px-4 md:py-3 text-left text-[10px] md:text-xs font-semibold text-gray-500 uppercase hidden md:table-cell">Statut</th>
                                <th class="px-2 py-2 md:px-4 md:py-3 text-right text-[10px] md:text-xs font-semibold text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($eleves as $eleve)
                                @php
                                    $derniereInscription = $eleve->inscriptions->first();
                                    $classeActuelle = $derniereInscription ? $derniereInscription->classe : null;
                                @endphp
                                <tr class="hover:bg-gray-50">
                                    <!-- Photo -->
                                    <td class="px-2 py-2 md:px-4 md:py-3 hidden sm:table-cell">
                                        @if($eleve->photo)
                                            <img class="h-8 w-8 md:h-10 md:w-10 rounded-lg object-cover border" src="{{ Storage::url($eleve->photo) }}" alt="{{ $eleve->prenom }}">
                                        @else
                                            <div class="h-8 w-8 md:h-10 md:w-10 rounded-lg bg-gray-100 flex items-center justify-center">
                                                <span class="text-[10px] md:text-xs font-bold text-gray-500">{{ strtoupper(substr($eleve->prenom, 0, 1)) }}{{ strtoupper(substr($eleve->nom, 0, 1)) }}</span>
                                            </div>
                                        @endif
                                    </td>

                                    <!-- Identité -->
                                    <td class="px-2 py-2 md:px-4 md:py-3">
                                        <div class="text-xs md:text-sm font-semibold text-gray-900">{{ $eleve->nom }} {{ $eleve->prenom }}</div>
                                        <div class="text-[10px] text-gray-400 md:hidden"> {{-- Visible seulement mobile --}}
                                            {{ $eleve->matricule }} • {{ $classeActuelle ? $classeActuelle->nom : 'N/A' }}
                                        </div>
                                        <div class="text-[10px] text-gray-400 hidden md:block">{{ $eleve->email }}</div>
                                    </td>

                                    <!-- Matricule -->
                                    <td class="px-2 py-2 md:px-4 md:py-3 hidden md:table-cell">
                                        <span class="px-2 py-0.5 bg-gray-100 text-gray-700 rounded text-[10px] md:text-xs font-mono">{{ $eleve->matricule }}</span>
                                    </td>

                                    <!-- Classe -->
                                    <td class="px-2 py-2 md:px-4 md:py-3">
                                        <span class="text-xs md:text-sm text-gray-700">{{ $classeActuelle ? $classeActuelle->nom : '-' }}</span>
                                    </td>

                                    <!-- Genre -->
                                    <td class="px-2 py-2 md:px-4 md:py-3 hidden lg:table-cell">
                                        <span class="px-2 py-0.5 text-[10px] font-medium rounded-full {{ $eleve->genre === 'm' ? 'bg-blue-100 text-blue-700' : 'bg-pink-100 text-pink-700' }}">
                                            {{ $eleve->genre === 'm' ? 'M' : 'F' }}
                                        </span>
                                    </td>

                                    <!-- Statut -->
                                    <td class="px-2 py-2 md:px-4 md:py-3 hidden md:table-cell">
                                        @if($eleve->statut)
                                            <span class="px-2 py-0.5 text-[10px] font-medium rounded-full bg-green-100 text-green-700">Actif</span>
                                        @else
                                            <span class="px-2 py-0.5 text-[10px] font-medium rounded-full bg-red-100 text-red-700">Inactif</span>
                                        @endif
                                    </td>

                                    <!-- Actions -->
                                    <td class="px-2 py-2 md:px-4 md:py-3 text-right">
                                        <div class="flex items-center justify-end gap-1 md:gap-2 whitespace-nowrap">
                                            <a href="{{ route('admin.eleves.show', $eleve) }}" class="p-1.5 md:p-2 text-blue-600 bg-transparent hover:bg-blue-50 rounded-lg transition-colors border-none" title="Voir">
                                                <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            </a>
                                            <a href="{{ route('admin.eleves.edit', $eleve) }}" class="p-1.5 md:p-2 text-amber-600 bg-transparent hover:bg-amber-50 rounded-lg transition-colors border-none" title="Modifier">
                                                <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </a>
                                            <form action="{{ route('admin.eleves.destroy', $eleve) }}" method="POST" class="inline m-0 p-0 delete-form">
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
                                    <td colspan="7" class="text-center py-10 text-gray-500 text-sm">
                                        Aucun élève trouvé.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($eleves->hasPages())
                <div class="p-3 md:p-4 border-t bg-gray-50">
                    <div class="flex flex-col sm:flex-row justify-between items-center gap-2 text-xs text-gray-600">
                        <span>Aff. {{ $eleves->firstItem() }} à {{ $eleves->lastItem() }} / {{ $eleves->total() }}</span>
                        <div class="flex gap-1 flex-wrap justify-center">
                            {{ $eleves->appends(request()->query())->links('pagination::tailwind') }}
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
    /* Pagination compacte */
    .pagination { display: flex; gap: 0.25rem; flex-wrap: wrap; justify-content: center; }
    .page-item { list-style: none; }
    .page-link {
        display: flex; align-items: center; justify-content: center;
        min-width: 28px; height: 28px;
        padding: 0 8px; font-size: 0.75rem;
        border-radius: 0.375rem;
        background: white; border: 1px solid #e5e7eb; color: #374151;
    }
    .page-link:hover { background: #f3f4f6; }
    .active .page-link { background: #2563eb; color: white; border-color: #2563eb; }
    .disabled .page-link { opacity: 0.5; pointer-events: none; }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Supprimer ?',
                    text: "Cette action est irréversible.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Oui',
                    cancelButtonText: 'Annuler'
                }).then((result) => {
                    if (result.isConfirmed) this.submit();
                });
            });
        });
    });
</script>
@endpush
