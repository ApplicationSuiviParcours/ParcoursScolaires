@extends('layouts.app')

@section('title', 'Mes Notifications')

@section('header')
<div class="relative overflow-hidden bg-gradient-to-br from-indigo-600 via-purple-700 to-indigo-800 py-8 md:py-12">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-white rounded-full mix-blend-overlay filter blur-3xl animate-pulse"></div>
        <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-purple-300 rounded-full mix-blend-overlay filter blur-3xl animate-pulse delay-1000"></div>
    </div>
    <div class="container mx-auto px-4 relative z-10">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div class="text-center md:text-left mb-4 md:mb-0">
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-white mb-2 flex items-center gap-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    Mes Notifications
                </h1>
                <p class="text-indigo-200 text-sm md:text-base">
                    @if($unreadCount > 0)
                        <span class="font-semibold text-yellow-300">{{ $unreadCount }} non lue(s)</span> sur {{ $notifications->total() }} au total
                    @else
                        Toutes vos notifications ({{ $notifications->total() }})
                    @endif
                </p>
            </div>
            <div class="flex flex-col sm:flex-row gap-2 justify-center md:justify-end">
                @if($unreadCount > 0)
                <form action="{{ route('notifications.read-all') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white/20 hover:bg-white/30 text-white font-semibold rounded-xl transition-all duration-300 border border-white/30 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Tout marquer lu
                    </button>
                </form>
                @endif
                <form action="{{ route('notifications.destroy-read') }}" method="POST" class="inline">
                    @csrf @method('DELETE')
                    <button type="submit" onclick="return confirm('Supprimer toutes les notifications lues ?')" class="inline-flex items-center gap-2 px-4 py-2.5 bg-red-500/30 hover:bg-red-500/50 text-white font-semibold rounded-xl transition-all duration-300 border border-red-300/30 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        Vider les lues
                    </button>
                </form>
            </div>
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
<div class="container mx-auto px-4 py-6 md:py-10 bg-gray-50 min-h-screen">

    {{-- Messages --}}
    @if(session('success'))
        <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg shadow-md" role="alert">
            <p class="font-medium text-sm">{{ session('success') }}</p>
        </div>
    @endif

    {{-- Filtres --}}
    <div class="bg-white rounded-2xl shadow-lg p-4 md:p-6 mb-6">
        <form method="GET" action="{{ route('notifications.index') }}" class="flex flex-wrap gap-3 items-end">
            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1">Statut</label>
                <select name="statut" class="rounded-xl border-2 border-gray-200 focus:border-indigo-500 px-4 py-2 text-sm">
                    <option value="">Tous</option>
                    <option value="non_lu" {{ request('statut') === 'non_lu' ? 'selected' : '' }}>Non lus</option>
                    <option value="lu" {{ request('statut') === 'lu' ? 'selected' : '' }}>Lus</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1">Type</label>
                <select name="type" class="rounded-xl border-2 border-gray-200 focus:border-indigo-500 px-4 py-2 text-sm">
                    <option value="">Tous</option>
                    <option value="info" {{ request('type') === 'info' ? 'selected' : '' }}>Info</option>
                    <option value="success" {{ request('type') === 'success' ? 'selected' : '' }}>Succès</option>
                    <option value="warning" {{ request('type') === 'warning' ? 'selected' : '' }}>Avertissement</option>
                    <option value="error" {{ request('type') === 'error' ? 'selected' : '' }}>Erreur</option>
                </select>
            </div>
            <button type="submit" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-sm font-semibold transition-all duration-200">
                Filtrer
            </button>
            <a href="{{ route('notifications.index') }}" class="px-4 py-2 bg-gray-100 text-gray-600 rounded-xl text-sm hover:bg-gray-200 transition-all">
                Réinitialiser
            </a>
        </form>
    </div>

    {{-- Liste des notifications --}}
    <div class="space-y-3">
        @forelse($notifications as $notification)
            @php
                $typeConfig = [
                    'success' => ['bg' => 'bg-green-50 border-green-200', 'icon_bg' => 'bg-green-100', 'icon_color' => 'text-green-600', 'badge' => 'bg-green-100 text-green-700'],
                    'warning' => ['bg' => 'bg-amber-50 border-amber-200', 'icon_bg' => 'bg-amber-100', 'icon_color' => 'text-amber-600', 'badge' => 'bg-amber-100 text-amber-700'],
                    'error'   => ['bg' => 'bg-red-50 border-red-200',    'icon_bg' => 'bg-red-100',   'icon_color' => 'text-red-600',   'badge' => 'bg-red-100 text-red-700'],
                    'info'    => ['bg' => 'bg-blue-50 border-blue-200',  'icon_bg' => 'bg-blue-100',  'icon_color' => 'text-blue-600',  'badge' => 'bg-blue-100 text-blue-700'],
                ];
                $cfg = $typeConfig[$notification->type] ?? $typeConfig['info'];
            @endphp
            <div class="bg-white rounded-2xl shadow-sm border {{ $notification->read ? 'border-gray-100 opacity-75' : 'border-indigo-200 shadow-md' }} overflow-hidden transition-all duration-300 hover:shadow-lg notification-card" data-id="{{ $notification->id }}">
                <div class="flex items-start gap-4 p-4 md:p-5">
                    {{-- Indicateur non lu --}}
                    @if(!$notification->read)
                        <div class="mt-1 w-2.5 h-2.5 rounded-full bg-indigo-500 flex-shrink-0 animate-pulse"></div>
                    @else
                        <div class="mt-1 w-2.5 h-2.5 flex-shrink-0"></div>
                    @endif

                    {{-- Icône type --}}
                    <div class="flex-shrink-0 w-10 h-10 rounded-xl {{ $cfg['icon_bg'] }} flex items-center justify-center">
                        @if($notification->type === 'success')
                            <svg class="w-5 h-5 {{ $cfg['icon_color'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        @elseif($notification->type === 'warning')
                            <svg class="w-5 h-5 {{ $cfg['icon_color'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        @elseif($notification->type === 'error')
                            <svg class="w-5 h-5 {{ $cfg['icon_color'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        @else
                            <svg class="w-5 h-5 {{ $cfg['icon_color'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        @endif
                    </div>

                    {{-- Contenu --}}
                    <div class="flex-1 min-w-0">
                        <div class="flex flex-wrap items-start justify-between gap-2 mb-1">
                            <h3 class="text-sm md:text-base font-semibold text-gray-900 {{ !$notification->read ? 'text-indigo-900' : '' }}">
                                {{ $notification->title }}
                            </h3>
                            <div class="flex items-center gap-2">
                                <span class="text-xs {{ $cfg['badge'] }} px-2 py-0.5 rounded-full font-medium">
                                    {{ ucfirst($notification->type) }}
                                </span>
                                @if(!$notification->read)
                                    <span class="text-xs bg-indigo-100 text-indigo-700 px-2 py-0.5 rounded-full font-medium">Nouveau</span>
                                @endif
                            </div>
                        </div>
                        <p class="text-sm text-gray-600 leading-relaxed mb-2">{{ $notification->message }}</p>
                        <div class="flex flex-wrap items-center gap-3 text-xs text-gray-400">
                            <span class="flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                {{ $notification->created_at->diffForHumans() }}
                            </span>
                            @if($notification->read_at)
                                <span class="flex items-center gap-1 text-green-500">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    Lu {{ $notification->read_at->diffForHumans() }}
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center gap-1 flex-shrink-0">
                        @if($notification->link)
                            <a href="{{ $notification->link }}" class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors" title="Voir">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            </a>
                        @endif
                        @if(!$notification->read)
                            <form action="{{ route('notifications.read', $notification) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition-colors" title="Marquer lu">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </button>
                            </form>
                        @endif
                        <form action="{{ route('notifications.destroy', $notification) }}" method="POST" class="inline" id="del-notif-{{ $notification->id }}">
                            @csrf @method('DELETE')
                            <button type="button" onclick="confirmDeleteNotif({{ $notification->id }})" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors" title="Supprimer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
                <div class="w-20 h-20 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Aucune notification</h3>
                <p class="text-gray-500 text-sm">Vous n'avez pas encore de notifications.</p>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($notifications->hasPages())
        <div class="mt-6 flex justify-center">
            {{ $notifications->links() }}
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
function confirmDeleteNotif(id) {
    if (confirm('Supprimer cette notification ?')) {
        document.getElementById('del-notif-' + id).submit();
    }
}

// Marquer comme lu via AJAX au clic sur le lien
document.querySelectorAll('.notification-card').forEach(card => {
    const link = card.querySelector('a[href]:not([title])');
    const id = card.dataset.id;
    if (link && id) {
        link.addEventListener('click', function() {
            fetch(`/notifications/${id}/read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
            }).catch(() => {});
        });
    }
});
</script>
@endpush
