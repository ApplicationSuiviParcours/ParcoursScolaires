<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block mb-1 text-sm font-semibold text-gray-700">Email</label>
            <div class="relative">
                <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="username" 
                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all text-sm bg-gray-50 hover:bg-white"
                       placeholder="votre@email.com">
                <x-input-error :messages="$errors->get('email')" class="mt-1" />
            </div>
        </div>

        <div class="flex items-center justify-end mt-4">
            <a href="{{ route('login') }}" class="text-sm font-medium text-blue-600 hover:text-blue-500">
                ← Retour à la connexion
            </a>

            <button type="submit" class="ml-4 px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white font-semibold rounded-xl shadow-md hover:shadow-lg transform hover:scale-[1.02] transition-all">
                Envoyer le lien de réinitialisation
            </button>
        </div>
    </form>
</x-guest-layout>
