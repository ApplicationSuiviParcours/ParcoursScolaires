<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    {{-- Connexion Utilisateur (Matricule uniquement) --}}
    <div class="mb-5 text-center">
        <div class="relative inline-flex items-center justify-center mb-3">
            <div class="absolute inset-0 bg-green-100 rounded-full animate-ping opacity-20"></div>
            <div class="relative inline-flex items-center justify-center rounded-full shadow-lg w-14 h-14 bg-blue-900">
                <svg class="text-yellow-500 w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
        </div>
        <h2 class="text-2xl font-extrabold text-gray-900">Connexion </h2>
        <p class="mt-1 text-sm text-gray-500">Saisissez seulement votre numéro matricule</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf
        <input type="hidden" name="role" value="user">

        <div>
            <label for="credential" class="block mb-1 text-sm font-semibold text-gray-700">
                Numéro Matricule :
            </label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400 transition-colors group-focus-within:text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2 2z"></path>
                    </svg>
                </div>
                <input
                    id="credential"
                    type="text"
                    name="credential"
                    value="{{ old('credential') }}"
                    required
                    autofocus
                    autocomplete="username"
                    class="pl-11 pr-4 w-full py-3 border-2 border-gray-200 rounded-xl text-gray-800 focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all outline-none bg-gray-50 hover:bg-white text-base font-semibold tracking-wide"
                    placeholder="Ex: PAR-2024-001"
                >
            </div>
            <x-input-error :messages="$errors->get('credential')" class="mt-1" />
            <p class="mt-1 text-xs text-gray-500 italic">Pas de mot de passe requis pour les matricules</p>
        </div>

        <!-- Se souvenir de moi -->
        <div class="flex items-center">
            <input id="remember_me_user" type="checkbox" name="remember" class="h-4 w-4 text-green-600 border-gray-300 rounded focus:ring-green-500 cursor-pointer">
            <label for="remember_me_user" class="ml-2.5 block text-sm font-medium text-gray-600 cursor-pointer select-none">
                Se souvenir de moi
            </label>
        </div>

        <button type="submit" class="group relative w-full flex justify-center py-2.5 px-4 border border-transparent rounded-xl text-sm font-semibold text-white bg-blue-900 hover:from-green-700 hover:to-emerald-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-150 shadow-md hover:shadow-lg">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                <svg class="w-5 h-5 text-green-300 transition-colors group-hover:text-green-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14"></path>
                </svg>
            </span>
            Accéder au portail
        </button>
    </form>
</x-guest-layout>