@extends('layouts.app')

@section('title', 'Mon Profil')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- En-tête avec titre -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Mon Profil</h1>
            <p class="text-gray-600">Gérez vos informations personnelles</p>
        </div>
        
        <!-- Messages de notification -->
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded mb-4 shadow-sm" role="alert">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded mb-4 shadow-sm" role="alert">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <!-- En-tête du profil avec avatar -->
            <div class="bg-gradient-to-r from-purple-600 to-blue-500 px-6 py-8">
                <div class="flex items-center">
                    <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center text-3xl font-bold text-purple-600 shadow-lg">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                    <div class="ml-6 text-white">
                        <h2 class="text-2xl font-bold">{{ $user->name }}</h2>
                        <p class="text-purple-100">{{ $user->email }}</p>
                        <p class="text-sm text-purple-200 mt-1">
                            Membre depuis {{ $user->created_at->format('d F Y') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Informations du profil -->
            <div class="p-6">
                <!-- Statistiques rapides -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                    <div class="bg-gray-50 rounded-lg p-4 text-center">
                        <div class="text-2xl font-bold text-purple-600">{{ $user->created_at->format('d/m/Y') }}</div>
                        <div class="text-sm text-gray-600">Date d'inscription</div>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4 text-center">
                        <div class="text-2xl font-bold text-purple-600">
                            @if($user->email_verified_at)
                                <span class="text-green-600">✓</span>
                            @else
                                <span class="text-yellow-600">!</span>
                            @endif
                        </div>
                        <div class="text-sm text-gray-600">
                            @if($user->email_verified_at)
                                Email vérifié
                            @else
                                Email non vérifié
                            @endif
                        </div>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4 text-center">
                        <div class="text-2xl font-bold text-purple-600">{{ $user->updated_at->format('d/m/Y') }}</div>
                        <div class="text-sm text-gray-600">Dernière mise à jour</div>
                    </div>
                </div>

                <!-- Informations détaillées -->
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Informations personnelles</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="border rounded-lg p-4">
                        <label class="block text-sm font-medium text-gray-500 mb-1">Nom complet</label>
                        <p class="text-gray-900">{{ $user->name }}</p>
                    </div>
                    
                    <div class="border rounded-lg p-4">
                        <label class="block text-sm font-medium text-gray-500 mb-1">Adresse email</label>
                        <p class="text-gray-900">{{ $user->email }}</p>
                        @if(!$user->email_verified_at)
                            <a href="{{ route('verification.notice') }}" class="text-sm text-yellow-600 hover:text-yellow-700 mt-1 inline-block">
                                Vérifier mon email
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Rôles (si vous utilisez Spatie Permission) -->
                @if(method_exists($user, 'roles') && $user->roles->isNotEmpty())
                <div class="mt-8">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Rôles et permissions</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($user->roles as $role)
                            <span class="px-4 py-2 bg-purple-100 text-purple-800 text-sm font-medium rounded-lg">
                                {{ ucfirst($role->name) }}
                            </span>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Actions du profil -->
                <div class="mt-8 flex flex-wrap gap-4">
                    <a href="{{ route('profile.edit') }}" 
                       class="inline-flex items-center px-6 py-3 bg-purple-600 text-white font-medium rounded-lg hover:bg-purple-700 transition duration-200 shadow-md hover:shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Modifier le profil
                    </a>

                    <a href="{{ route('profile.password') }}" 
                       class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition duration-200 shadow-md hover:shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        Changer le mot de passe
                    </a>

                    <a href="{{ route('dashboard') }}" 
                       class="inline-flex items-center px-6 py-3 bg-gray-600 text-white font-medium rounded-lg hover:bg-gray-700 transition duration-200 shadow-md hover:shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Tableau de bord
                    </a>
                </div>

                <!-- Zone de danger (suppression de compte) -->
                <div class="mt-12 pt-6 border-t border-gray-200">
                    <h3 class="text-lg font-semibold text-red-600 mb-4">Zone de danger</h3>
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-medium text-red-800">Supprimer mon compte</p>
                                <p class="text-sm text-red-600">Une fois supprimé, toutes vos données seront définitivement effacées.</p>
                            </div>
                            <button onclick="openDeleteModal()" 
                                    class="px-4 py-2 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 transition duration-200">
                                Supprimer
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmation de suppression -->
<div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Confirmer la suppression</h3>
            <p class="text-sm text-gray-500 mb-4">
                Êtes-vous sûr de vouloir supprimer votre compte ? Cette action est irréversible.
            </p>
            <form method="POST" action="{{ route('profile.destroy') }}">
                @csrf
                @method('DELETE')
                <div class="mb-4">
                    <input type="password" name="password" placeholder="Votre mot de passe" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500"
                           required>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeDeleteModal()"
                            class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition">
                        Annuler
                    </button>
                    <button type="submit"
                            class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition">
                        Confirmer la suppression
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function openDeleteModal() {
        document.getElementById('deleteModal').classList.remove('hidden');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }

    // Fermer le modal si on clique en dehors
    window.onclick = function(event) {
        const modal = document.getElementById('deleteModal');
        if (event.target == modal) {
            modal.classList.add('hidden');
        }
    }
</script>
@endpush
@endsection