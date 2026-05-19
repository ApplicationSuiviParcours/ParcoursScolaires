<x-guest-layout>
    <x-auth-session-status class="mb-3" :status="session('status')" />

    <div class="mb-3 text-center">
        <div class="relative inline-flex items-center justify-center mb-2">
            <div class="absolute inset-0 bg-blue-100 rounded-full animate-ping opacity-20"></div>
            <div class="relative inline-flex items-center justify-center rounded-full shadow-lg w-11 h-11 bg-blue-900">
                <svg class="text-yellow-500 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
            </div>
        </div>
        <h2 class="text-xl font-extrabold text-gray-900">Espace Réservé</h2>
        <p class="mt-0.5 text-xs text-gray-500">Accès sécurisé — personnel autorisé uniquement</p>
    </div>

    {{-- Avertissement de sécurité --}}
    <div class="mb-3 px-3 py-2 bg-amber-50 border border-amber-200 rounded-lg">
        <div class="flex items-center gap-2">
            <svg class="w-4 h-4 text-amber-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.962-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/>
            </svg>
            <p class="text-[10px] text-amber-700 leading-tight">Tentatives limitées et enregistrées. <span class="font-semibold">3 échecs = verrouillage 5 min.</span></p>
        </div>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-3" x-data="{ showPassword: false }">
        @csrf
        <input type="hidden" name="role" value="administrateur" />

        <!-- Email -->
        <div>
            <label for="credential" class="block mb-0.5 text-xs font-semibold text-gray-700">
                Adresse Email :
            </label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400 transition-colors group-focus-within:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                    </svg>
                </div>
                <input
                    id="credential"
                    type="email"
                    name="credential"
                    value="{{ old('credential') }}"
                    required
                    autofocus
                    autocomplete="email"
                    class="pl-10 pr-4 w-full py-2.5 border-2 border-gray-200 rounded-lg text-gray-800 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all outline-none bg-gray-50 hover:bg-white text-sm"
                    placeholder="Entrez votre email"
                >
            </div>
            <x-input-error :messages="$errors->get('credential')" class="mt-0.5" />
        </div>

        <!-- Mot de passe -->
        <div>
            <label for="password" class="block mb-0.5 text-xs font-semibold text-gray-700">
                Mot de Passe :
            </label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400 transition-colors group-focus-within:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <input
                    id="password"
                    :type="showPassword ? 'text' : 'password'"
                    name="password"
                    required
                    autocomplete="current-password"
                    class="pl-10 pr-11 w-full py-2.5 border-2 border-gray-200 rounded-lg text-gray-800 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all outline-none bg-gray-50 hover:bg-white text-sm"
                    placeholder="Entrez votre mot de passe"
                >
                <button type="button" @click="showPassword = !showPassword"
                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-blue-900 focus:outline-none">
                    <svg x-show="!showPassword" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <svg x-show="showPassword" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-0.5" />
        </div>

        <!-- Se souvenir de moi -->
        <div class="flex items-center">
            <input id="remember_me" type="checkbox" name="remember" class="h-3.5 w-3.5 text-blue-900 border-gray-300 rounded focus:ring-blue-500 cursor-pointer">
            <label for="remember_me" class="ml-2 block text-xs font-medium text-gray-600 cursor-pointer select-none">
                Se souvenir de moi
            </label>
        </div>

        <!-- Bouton Se Connecter -->
        <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-lg text-sm font-semibold text-white bg-blue-900 hover:from-blue-900 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-150 shadow-md hover:shadow-lg">
            Se Connecter
        </button>

        <!-- Liens bas de formulaire -->
        <div class="flex items-center justify-between pt-1.5 border-t border-gray-100">
            @if (Route::has('password.request'))
                <a class="text-xs font-medium text-blue-900 hover:text-blue-800 hover:underline" href="{{ route('password.request') }}">
                    Mot de passe oublié ?
                </a>
            @endif
            <a href="{{ route('login') }}" class="text-xs font-medium text-gray-500 hover:text-blue-900 hover:underline">
                Retour &rsaquo;
            </a>
        </div>
    </form>

    @push('scripts')
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @endpush
</x-guest-layout>