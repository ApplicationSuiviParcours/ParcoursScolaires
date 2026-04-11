@extends('layouts.app')

@section('title', 'Centre de Messages')

@section('header')
<div class="relative overflow-hidden bg-gradient-to-br from-violet-600 via-purple-700 to-indigo-800 py-8 md:py-12">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-white rounded-full mix-blend-overlay filter blur-3xl animate-pulse"></div>
        <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-purple-300 rounded-full mix-blend-overlay filter blur-3xl animate-pulse delay-700"></div>
    </div>
    <div class="container mx-auto px-4 relative z-10">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-white mb-2 flex items-center gap-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                    </svg>
                    Centre de Messages
                </h1>
                <p class="text-purple-200 text-sm md:text-base">Envoyez des notifications aux parents, enseignants et utilisateurs</p>
            </div>
            <a href="{{ route('admin.messages.historique') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white/20 hover:bg-white/30 text-white font-semibold rounded-xl transition-all duration-300 border border-white/30 text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                Historique
            </a>
        </div>
    </div>
    <div class="absolute bottom-0 left-0 right-0">
        <svg class="fill-current text-gray-50" viewBox="0 0 1440 60" preserveAspectRatio="none">
            <path d="M0,32L80,34.7C160,37,320,43,480,40C640,37,800,27,960,24C1120,21,1280,27,1360,29.3L1440,32L1440,60L0,60Z"/>
        </svg>
    </div>
</div>
@endsection

@section('content')
<div class="container mx-auto px-4 py-6 md:py-10 bg-gray-50">

    {{-- Alerts --}}
    @if(session('success'))
        <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg shadow-md flex items-center gap-3" role="alert">
            <svg class="h-5 w-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <p class="font-medium text-sm">{{ session('success') }}</p>
        </div>
    @endif
    @if(session('error'))
        <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg shadow-md flex items-center gap-3" role="alert">
            <svg class="h-5 w-5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <p class="font-medium text-sm">{{ session('error') }}</p>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Formulaire d'envoi --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="bg-gradient-to-r from-violet-600 to-purple-700 px-6 py-4 flex items-center gap-3">
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                    </div>
                    <h2 class="text-lg font-bold text-white">Envoyer une notification</h2>
                </div>

                <form action="{{ route('admin.messages.send') }}" method="POST" class="p-6 space-y-5">
                    @csrf

                    {{-- Destinataire --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            Destinataire(s) *
                        </label>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                            @php
                                $destinataires = [
                                    'tous_parents'     => ['label' => 'Tous les parents',     'icon' => '👨‍👩‍👧‍👦', 'count' => $stats['parents'],     'color' => 'border-green-300 bg-green-50 text-green-700'],
                                    'tous_enseignants' => ['label' => 'Tous enseignants',      'icon' => '🎓',      'count' => $stats['enseignants'], 'color' => 'border-blue-300 bg-blue-50 text-blue-700'],
                                    'classe'           => ['label' => 'Parents d\'une classe', 'icon' => '🏫',      'count' => null,                 'color' => 'border-amber-300 bg-amber-50 text-amber-700'],
                                    'utilisateur'      => ['label' => 'Utilisateur précis',   'icon' => '👤',      'count' => null,                 'color' => 'border-purple-300 bg-purple-50 text-purple-700'],
                                ];
                            @endphp
                            @foreach($destinataires as $value => $dest)
                                <label class="relative flex flex-col items-center p-3 rounded-xl border-2 cursor-pointer transition-all duration-200 hover:shadow-md dest-option {{ $value === 'tous_parents' ? 'border-green-400 bg-green-50 ring-2 ring-green-300' : 'border-gray-200 bg-white' }}"
                                       data-dest="{{ $value }}">
                                    <input type="radio" name="destinataire" value="{{ $value }}" class="sr-only" {{ $value === 'tous_parents' ? 'checked' : '' }}>
                                    <span class="text-2xl mb-1">{{ $dest['icon'] }}</span>
                                    <span class="text-xs font-semibold text-gray-700 text-center leading-tight">{{ $dest['label'] }}</span>
                                    @if($dest['count'] !== null)
                                        <span class="mt-1 text-xs px-2 py-0.5 rounded-full {{ $dest['color'] }} font-medium">{{ $dest['count'] }}</span>
                                    @endif
                                </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Sélecteur conditionnel classe --}}
                    <div id="classe-selector" class="hidden">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Classe *</label>
                        <select name="classe_id" class="w-full rounded-xl border-2 border-gray-200 focus:border-purple-500 focus:ring-2 focus:ring-purple-200 px-4 py-2.5 text-sm">
                            <option value="">— Choisir une classe —</option>
                            @foreach($classes as $classe)
                                <option value="{{ $classe->id }}">{{ $classe->nom }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Sélecteur conditionnel utilisateur --}}
                    <div id="user-selector" class="hidden">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Utilisateur *</label>
                        <select name="user_id" class="w-full rounded-xl border-2 border-gray-200 focus:border-purple-500 focus:ring-2 focus:ring-purple-200 px-4 py-2.5 text-sm">
                            <option value="">— Choisir un utilisateur —</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->getRoleNamesAttribute() }})</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Type --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Type de notification *</label>
                        <div class="flex flex-wrap gap-2">
                            @foreach(['info' => ['🔵', 'Info', 'border-blue-300 text-blue-700'], 'success' => ['🟢', 'Succès', 'border-green-300 text-green-700'], 'warning' => ['🟡', 'Avertissement', 'border-amber-300 text-amber-700'], 'error' => ['🔴', 'Alerte', 'border-red-300 text-red-700']] as $val => [$emoji, $label, $style])
                                <label class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl border-2 cursor-pointer transition-all type-option {{ $val === 'info' ? $style . ' ring-2' : 'border-gray-200' }}" data-type="{{ $val }}">
                                    <input type="radio" name="type" value="{{ $val }}" class="sr-only" {{ $val === 'info' ? 'checked' : '' }}>
                                    <span>{{ $emoji }}</span>
                                    <span class="text-sm font-medium">{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Titre --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Titre *</label>
                        <input type="text" name="titre" value="{{ old('titre') }}" required maxlength="255"
                               placeholder="Ex: Réunion parents le 15 janvier..."
                               class="w-full rounded-xl border-2 border-gray-200 focus:border-purple-500 focus:ring-2 focus:ring-purple-200 px-4 py-2.5 text-sm transition-all duration-200">
                        @error('titre') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Message --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Message *</label>
                        <textarea name="message" rows="4" required maxlength="1000"
                                  placeholder="Rédigez votre message ici..."
                                  class="w-full rounded-xl border-2 border-gray-200 focus:border-purple-500 focus:ring-2 focus:ring-purple-200 px-4 py-2.5 text-sm transition-all duration-200 resize-none">{{ old('message') }}</textarea>
                        @error('message') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        <p class="text-xs text-gray-400 mt-1">Maximum 1000 caractères</p>
                    </div>

                    {{-- Lien optionnel --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Lien (optionnel)</label>
                        <input type="url" name="lien" value="{{ old('lien') }}"
                               placeholder="https://... (lien vers une page de l'application)"
                               class="w-full rounded-xl border-2 border-gray-200 focus:border-purple-500 focus:ring-2 focus:ring-purple-200 px-4 py-2.5 text-sm transition-all duration-200">
                    </div>

                    {{-- Bouton --}}
                    <div class="pt-2">
                        <button type="submit"
                                class="w-full inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-violet-600 to-purple-700 hover:from-violet-700 hover:to-purple-800 text-white font-bold rounded-xl transition-all duration-300 transform hover:scale-[1.02] shadow-lg hover:shadow-purple-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                            Envoyer la notification
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Panneau d'informations --}}
        <div class="space-y-5">

            {{-- Stats --}}
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="bg-gradient-to-r from-violet-500 to-purple-600 px-5 py-3">
                    <h3 class="text-sm font-bold text-white flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        Statistiques
                    </h3>
                </div>
                <div class="p-5 grid grid-cols-2 gap-3">
                    <div class="text-center p-3 bg-green-50 rounded-xl">
                        <p class="text-2xl font-bold text-green-700">{{ $stats['parents'] }}</p>
                        <p class="text-xs text-green-600 font-medium">Parents actifs</p>
                    </div>
                    <div class="text-center p-3 bg-blue-50 rounded-xl">
                        <p class="text-2xl font-bold text-blue-700">{{ $stats['enseignants'] }}</p>
                        <p class="text-xs text-blue-600 font-medium">Enseignants</p>
                    </div>
                    <div class="text-center p-3 bg-purple-50 rounded-xl">
                        <p class="text-2xl font-bold text-purple-700">{{ $stats['total_notifs'] }}</p>
                        <p class="text-xs text-purple-600 font-medium">Notifs envoyées</p>
                    </div>
                    <div class="text-center p-3 bg-amber-50 rounded-xl">
                        <p class="text-2xl font-bold text-amber-700">{{ $stats['non_lues'] }}</p>
                        <p class="text-xs text-amber-600 font-medium">Non lues</p>
                    </div>
                </div>
            </div>

            {{-- Guide --}}
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-500 to-blue-600 px-5 py-3">
                    <h3 class="text-sm font-bold text-white flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Guide d'utilisation
                    </h3>
                </div>
                <div class="p-5 space-y-3 text-sm text-gray-600">
                    <div class="flex items-start gap-2">
                        <span class="text-base flex-shrink-0">📋</span>
                        <p>Les <strong>bulletins générés</strong> notifient automatiquement les parents concernés.</p>
                    </div>
                    <div class="flex items-start gap-2">
                        <span class="text-base flex-shrink-0">⚠️</span>
                        <p>Les <strong>absences enregistrées</strong> sont automatiquement communiquées aux parents.</p>
                    </div>
                    <div class="flex items-start gap-2">
                        <span class="text-base flex-shrink-0">📢</span>
                        <p>Utilisez ce formulaire pour envoyer des <strong>annonces générales</strong> (réunions, événements, etc.).</p>
                    </div>
                    <div class="flex items-start gap-2">
                        <span class="text-base flex-shrink-0">🔔</span>
                        <p>Les destinataires voient les notifications dans leur <strong>clochette</strong> en haut de page.</p>
                    </div>
                </div>
            </div>

            {{-- Notifications automatiques --}}
            <div class="bg-gradient-to-br from-emerald-50 to-green-50 rounded-2xl border border-emerald-200 p-5">
                <h3 class="text-sm font-bold text-emerald-800 mb-3 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Notifications automatiques actives
                </h3>
                <div class="space-y-2 text-xs text-emerald-700">
                    <div class="flex items-center gap-2">
                        <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
                        <span>Génération de bulletin → Parents notifiés</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
                        <span>Enregistrement d'absence → Parents notifiés</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Gestion des onglets destinataires
document.querySelectorAll('.dest-option').forEach(opt => {
    opt.addEventListener('click', function() {
        // Reset all
        document.querySelectorAll('.dest-option').forEach(o => {
            o.classList.remove('ring-2', 'ring-purple-300', 'border-green-400', 'bg-green-50',
                               'border-blue-400', 'bg-blue-50', 'border-amber-400', 'bg-amber-50',
                               'border-purple-400', 'bg-purple-50');
            o.classList.add('border-gray-200', 'bg-white');
        });
        // Active
        this.classList.remove('border-gray-200', 'bg-white');
        this.classList.add('ring-2', 'ring-purple-300', 'border-purple-400', 'bg-purple-50');
        this.querySelector('input').checked = true;

        // Conditionals
        const dest = this.dataset.dest;
        document.getElementById('classe-selector').classList.toggle('hidden', dest !== 'classe');
        document.getElementById('user-selector').classList.toggle('hidden', dest !== 'utilisateur');
    });
});

// Gestion des types
document.querySelectorAll('.type-option').forEach(opt => {
    opt.addEventListener('click', function() {
        document.querySelectorAll('.type-option').forEach(o => {
            o.classList.remove('ring-2', 'border-blue-300', 'text-blue-700', 'border-green-300',
                               'text-green-700', 'border-amber-300', 'text-amber-700', 'border-red-300', 'text-red-700');
            o.classList.add('border-gray-200');
        });
        this.classList.remove('border-gray-200');
        this.classList.add('ring-2');
        this.querySelector('input').checked = true;
    });
});
</script>
@endpush
