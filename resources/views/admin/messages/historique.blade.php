@extends('layouts.app')

@section('title', 'Historique des Notifications')

@section('content')
<div class="container mx-auto px-4 py-6 md:py-10 bg-gray-50 min-h-screen">

    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                Historique des notifications
            </h1>
            <p class="text-sm text-gray-500 mt-1">{{ $notifications->total() }} notification(s) au total</p>
        </div>
        <a href="{{ route('admin.messages.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-xl text-sm font-semibold transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
            Envoyer
        </a>
    </div>

    {{-- Filtres --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 mb-6">
        <form method="GET" action="{{ route('admin.messages.historique') }}" class="flex flex-wrap gap-3 items-end">
            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1">Type</label>
                <select name="type" class="rounded-xl border-2 border-gray-200 focus:border-purple-500 px-3 py-2 text-sm">
                    <option value="">Tous</option>
                    <option value="info" {{ request('type') === 'info' ? 'selected' : '' }}>Info</option>
                    <option value="success" {{ request('type') === 'success' ? 'selected' : '' }}>Succès</option>
                    <option value="warning" {{ request('type') === 'warning' ? 'selected' : '' }}>Avertissement</option>
                    <option value="error" {{ request('type') === 'error' ? 'selected' : '' }}>Erreur</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1">Statut</label>
                <select name="statut" class="rounded-xl border-2 border-gray-200 focus:border-purple-500 px-3 py-2 text-sm">
                    <option value="">Tous</option>
                    <option value="non_lu" {{ request('statut') === 'non_lu' ? 'selected' : '' }}>Non lus</option>
                    <option value="lu" {{ request('statut') === 'lu' ? 'selected' : '' }}>Lus</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1">Recherche</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Titre ou message..."
                       class="rounded-xl border-2 border-gray-200 focus:border-purple-500 px-3 py-2 text-sm w-48">
            </div>
            <button type="submit" class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-xl text-sm font-semibold transition-all">Filtrer</button>
            <a href="{{ route('admin.messages.historique') }}" class="px-4 py-2 bg-gray-100 text-gray-600 rounded-xl text-sm hover:bg-gray-200 transition-all">Reset</a>
        </form>
    </div>

    {{-- Tableau --}}
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-purple-50 to-indigo-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-purple-700 uppercase">Destinataire</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-purple-700 uppercase">Type</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-purple-700 uppercase">Titre</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-purple-700 uppercase hidden md:table-cell">Message</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-purple-700 uppercase">Statut</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-purple-700 uppercase">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($notifications as $notif)
                        @php
                            $typeColors = [
                                'success' => 'bg-green-100 text-green-700',
                                'warning' => 'bg-amber-100 text-amber-700',
                                'error'   => 'bg-red-100 text-red-700',
                                'info'    => 'bg-blue-100 text-blue-700',
                            ];
                            $color = $typeColors[$notif->type] ?? $typeColors['info'];
                        @endphp
                        <tr class="hover:bg-purple-50/30 transition-colors">
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-purple-500 to-indigo-600 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                                        {{ strtoupper(substr($notif->user?->name ?? '?', 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $notif->user?->name ?? 'Inconnu' }}</p>
                                        <p class="text-xs text-gray-400">{{ $notif->user?->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $color }}">
                                    {{ ucfirst($notif->type) }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <p class="text-sm font-medium text-gray-900 max-w-[160px] truncate">{{ $notif->title }}</p>
                            </td>
                            <td class="px-4 py-3 hidden md:table-cell">
                                <p class="text-xs text-gray-500 max-w-xs truncate">{{ $notif->message }}</p>
                            </td>
                            <td class="px-4 py-3">
                                @if($notif->read)
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        Lu
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-700">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        Non lu
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <p class="text-xs text-gray-500">{{ $notif->created_at->format('d/m/Y H:i') }}</p>
                                <p class="text-xs text-gray-400">{{ $notif->created_at->diffForHumans() }}</p>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center">
                                        <svg class="w-8 h-8 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                                    </div>
                                    <p class="text-gray-500 font-medium">Aucune notification trouvée</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($notifications->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                {{ $notifications->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
