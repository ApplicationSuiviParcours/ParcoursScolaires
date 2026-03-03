{{-- resources/views/admin/users/create.blade.php --}}
@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Créer un utilisateur') }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <!-- En-tête avec animation -->
                <div class="px-6 py-5 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-blue-100 rounded-lg">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-lg font-semibold text-gray-900">Nouvel utilisateur</h4>
                            <p class="text-sm text-gray-500">Créez un nouveau compte utilisateur avec tous ses détails</p>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <form method="POST" action="{{ route('admin.users.store') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <!-- Photo de profil avec aperçu -->
                        <div class="mb-6 p-4 bg-gray-50 rounded-xl border border-gray-200">
                            <label class="block text-sm font-medium text-gray-700 mb-3">
                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    Photo de profil
                                </span>
                            </label>
                            
                            <div class="flex items-center space-x-6">
                                <!-- Aperçu de la photo -->
                                <div class="shrink-0">
                                    <div id="preview" class="h-24 w-24 rounded-full bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center border-4 border-white shadow-lg overflow-hidden">
                                        <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                </div>
                                
                                <!-- Bouton d'upload -->
                                <div class="flex-1">
                                    <label class="cursor-pointer group">
                                        <span class="inline-flex items-center px-4 py-2.5 bg-white border-2 border-gray-300 border-dashed rounded-xl font-medium text-sm text-gray-700 hover:border-blue-500 hover:bg-blue-50 transition-all duration-300 group-hover:scale-105 transform">
                                            <svg class="w-5 h-5 mr-2 text-gray-500 group-hover:text-blue-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                            </svg>
                                            Choisir une photo
                                        </span>
                                        <input type="file" name="photo" id="photo" class="hidden" accept="image/*" onchange="previewImage(this)">
                                    </label>
                                    <p class="text-xs text-gray-500 mt-2">Formats acceptés : JPG, PNG, GIF (max. 2MB)</p>
                                </div>
                            </div>
                            @error('photo')
                                <p class="text-red-500 text-xs mt-2 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Informations personnelles -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Nom complet -->
                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    <span class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        Nom complet <span class="text-red-500">*</span>
                                    </span>
                                </label>
                                <input type="text" 
                                       name="name" 
                                       id="name" 
                                       value="{{ old('name') }}" 
                                       required
                                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl bg-gray-50 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-300 @error('name') border-red-500 @enderror"
                                       placeholder="Jean Dupont">
                                @error('name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    <span class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                        Email <span class="text-red-500">*</span>
                                    </span>
                                </label>
                                <input type="email" 
                                       name="email" 
                                       id="email" 
                                       value="{{ old('email') }}" 
                                       required
                                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl bg-gray-50 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-300 @error('email') border-red-500 @enderror"
                                       placeholder="jean.dupont@exemple.com">
                                @error('email')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Mot de passe -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    <span class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                        </svg>
                                        Mot de passe <span class="text-red-500">*</span>
                                    </span>
                                </label>
                                <input type="password" 
                                       name="password" 
                                       id="password" 
                                       required
                                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl bg-gray-50 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-300 @error('password') border-red-500 @enderror"
                                       placeholder="••••••••">
                                @error('password')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Confirmation mot de passe -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    <span class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                        </svg>
                                        Confirmer le mot de passe <span class="text-red-500">*</span>
                                    </span>
                                </label>
                                <input type="password" 
                                       name="password_confirmation" 
                                       id="password_confirmation" 
                                       required
                                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl bg-gray-50 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-300"
                                       placeholder="••••••••">
                            </div>
                        </div>

                        <!-- Rôles (multiples) -->
                        <div class="p-4 bg-gray-50 rounded-xl border border-gray-200">
                            <label class="block text-sm font-medium text-gray-700 mb-3">
                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                                    </svg>
                                    Rôles <span class="text-red-500">*</span>
                                </span>
                                <span class="text-xs text-gray-500 ml-6">Sélectionnez un ou plusieurs rôles</span>
                            </label>
                            
                            <div class="grid grid-cols-2 gap-3">
                                @foreach($roles as $role)
                                    <label class="flex items-center p-3 border-2 border-gray-200 rounded-xl cursor-pointer hover:bg-white hover:border-blue-500 transition-all duration-300 group @error('roles') border-red-200 @enderror">
                                        <input type="checkbox" 
                                               name="roles[]" 
                                               value="{{ $role->id }}" 
                                               class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                               {{ in_array($role->id, old('roles', [])) ? 'checked' : '' }}>
                                        <span class="ml-2 text-sm font-medium text-gray-700 group-hover:text-blue-600 transition-colors duration-300">
                                            {{ ucfirst($role->name) }}
                                        </span>
                                        <span class="ml-auto text-xs text-gray-400">
                                            @if($role->name == 'administrateur')
                                                <span class="px-2 py-0.5 bg-purple-100 text-purple-800 rounded-full">Accès total</span>
                                            @elseif($role->name == 'enseignant')
                                                <span class="px-2 py-0.5 bg-blue-100 text-blue-800 rounded-full">Gestion cours</span>
                                            @elseif($role->name == 'eleve')
                                                <span class="px-2 py-0.5 bg-green-100 text-green-800 rounded-full">Accès limité</span>
                                            @elseif($role->name == 'parent')
                                                <span class="px-2 py-0.5 bg-yellow-100 text-yellow-800 rounded-full">Suivi</span>
                                            @endif
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                            @error('roles')
                                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                            @error('roles.*')
                                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Options supplémentaires -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Statut actif -->
                            <div class="flex items-center p-3 border-2 border-gray-200 rounded-xl hover:border-green-500 transition-all duration-300">
                                <input type="checkbox" 
                                       name="is_active" 
                                       id="is_active" 
                                       value="1" 
                                       checked
                                       class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                                <label for="is_active" class="ml-2 text-sm text-gray-700 cursor-pointer">
                                    <span class="font-medium">Activer le compte</span>
                                    <p class="text-xs text-gray-500">L'utilisateur pourra se connecter immédiatement</p>
                                </label>
                            </div>

                            <!-- Email vérifié -->
                            <div class="flex items-center p-3 border-2 border-gray-200 rounded-xl hover:ring-2 hover:ring-blue-100 transition-all duration-300">
                                <input type="checkbox" 
                                       name="email_verified" 
                                       id="email_verified" 
                                       value="1"
                                       class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                <label for="email_verified" class="ml-2 text-sm text-gray-700 cursor-pointer">
                                    <span class="font-medium">Email vérifié</span>
                                    <p class="text-xs text-gray-500">Marquer l'email comme vérifié</p>
                                </label>
                            </div>
                        </div>

                        <!-- Informations supplémentaires (optionnelles) -->
                        <div class="p-4 bg-blue-50 rounded-xl border border-blue-200">
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-blue-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div>
                                    <p class="text-sm font-medium text-blue-800">Informations importantes</p>
                                    <ul class="text-xs text-blue-600 mt-1 space-y-1 list-disc list-inside">
                                        <li>Le mot de passe doit contenir au moins 8 caractères</li>
                                        <li>L'email doit être unique dans le système</li>
                                        <li>Vous pourrez ajouter des informations supplémentaires (téléphone, adresse, etc.) après la création</li>
                                        <li>Un email de bienvenue sera envoyé à l'utilisateur (optionnel)</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Boutons d'action -->
                        <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                            <a href="{{ route('admin.users.index') }}" 
                               class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl transition-all duration-300 transform hover:scale-105 flex items-center gap-2 group">
                                <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                Annuler
                            </a>
                            <button type="submit" 
                                    class="px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-medium rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 flex items-center gap-2 group">
                                <svg class="w-5 h-5 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                </svg>
                                Créer l'utilisateur
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Fonction pour prévisualiser l'image avant upload
    function previewImage(input) {
        const preview = document.getElementById('preview');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.innerHTML = `<img src="${e.target.result}" class="h-full w-full object-cover" alt="Aperçu">`;
                preview.classList.remove('bg-gradient-to-br', 'from-gray-200', 'to-gray-300');
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Animation supplémentaire
    document.addEventListener('DOMContentLoaded', function() {
        // Ajouter une classe d'animation aux éléments
        const formElements = document.querySelectorAll('input, select, textarea, button, a');
        formElements.forEach(element => {
            element.addEventListener('focus', function() {
                this.classList.add('ring-4', 'ring-blue-100');
            });
            element.addEventListener('blur', function() {
                this.classList.remove('ring-4', 'ring-blue-100');
            });
        });

        // Validation en temps réel du mot de passe
        const password = document.getElementById('password');
        const passwordConfirm = document.getElementById('password_confirmation');
        
        if (password && passwordConfirm) {
            function checkPasswordMatch() {
                if (password.value && passwordConfirm.value) {
                    if (password.value === passwordConfirm.value) {
                        passwordConfirm.classList.remove('border-red-500');
                        passwordConfirm.classList.add('border-green-500');
                    } else {
                        passwordConfirm.classList.remove('border-green-500');
                        passwordConfirm.classList.add('border-red-500');
                    }
                } else {
                    passwordConfirm.classList.remove('border-red-500', 'border-green-500');
                }
            }
            
            password.addEventListener('keyup', checkPasswordMatch);
            passwordConfirm.addEventListener('keyup', checkPasswordMatch);
        }
    });
</script>
@endpush

@push('styles')
<style>
    /* Animation pour les champs de formulaire */
    input, select, textarea, button, a {
        transition: all 0.3s ease;
    }

    /* Style pour l'aperçu de l'image */
    #preview {
        transition: all 0.3s ease;
    }

    #preview img {
        transition: transform 0.3s ease;
    }

    #preview:hover img {
        transform: scale(1.05);
    }

    /* Animation pour les checkboxes */
    input[type="checkbox"] {
        cursor: pointer;
        transition: all 0.2s ease;
    }

    input[type="checkbox"]:checked {
        transform: scale(1.1);
    }

    /* Animation pour les labels des rôles */
    .grid label {
        transition: all 0.3s ease;
    }

    .grid label:hover {
        transform: translateY(-2px);
    }
</style>
@endpush