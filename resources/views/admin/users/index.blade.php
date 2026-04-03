{{-- resources/views/admin/users/index.blade.php --}}
@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Gestion des utilisateurs') }}
    </h2>
@endsection

@section('content')
    <div class="py-6 sm:py-8 md:py-12 overflow-x-hidden">
        <div class="max-w-7xl mx-auto px-3 sm:px-4 lg:px-6">
            <!-- Messages flash pour les notifications -->
            @if(session('success'))
                <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 px-3 sm:px-4 py-2 sm:py-3 rounded-lg shadow-md animate-fade-in-down" role="alert">
                    <div class="flex items-center">
                        <div class="py-1">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 mr-3 sm:mr-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-bold text-sm sm:text-base">Succès !</p>
                            <p class="text-xs sm:text-sm">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 px-3 sm:px-4 py-2 sm:py-3 rounded-lg shadow-md animate-fade-in-down" role="alert">
                    <div class="flex items-center">
                        <div class="py-1">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 mr-3 sm:mr-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-bold text-sm sm:text-base">Erreur !</p>
                            <p class="text-xs sm:text-sm">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if(session('warning'))
                <div class="mb-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 px-3 sm:px-4 py-2 sm:py-3 rounded-lg shadow-md animate-fade-in-down" role="alert">
                    <div class="flex items-center">
                        <div class="py-1">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 mr-3 sm:mr-4 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-bold text-sm sm:text-base">Attention !</p>
                            <p class="text-xs sm:text-sm">{{ session('warning') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Header avec animation -->
            <div class="mb-6 sm:mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-4 animate-fade-in-down">
                <div>
                    <h3 class="text-xl sm:text-2xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent">
                        Liste des utilisateurs
                    </h3>
                    <p class="text-xs sm:text-sm text-gray-500 mt-1 flex items-center gap-1 flex-wrap">
                        <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Gérez tous les utilisateurs du système
                    </p>
                </div>
                <a href="{{ route('admin.users.create') }}"
                    class="group inline-flex items-center justify-center px-4 sm:px-5 md:px-6 py-2 sm:py-2.5 md:py-3 bg-gradient-to-r from-emerald-500 to-green-600 hover:from-emerald-600 hover:to-green-700 text-white text-xs sm:text-sm font-medium rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-1.5 sm:mr-2 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Nouvel utilisateur
                </a>
            </div>

            <!-- Statistiques avec animations -->
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-7 gap-3 sm:gap-4 md:gap-5 mb-6 sm:mb-8">
                <!-- Total Users Card -->
                <div class="group bg-white rounded-xl sm:rounded-2xl border border-gray-100 p-2.5 sm:p-3 md:p-4 shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 animate-fade-in-up" style="animation-delay: 0.1s">
                    <div class="flex flex-col items-center text-center">
                        <div class="bg-blue-50 rounded-full p-1.5 sm:p-2 md:p-3 group-hover:bg-blue-100 transition-colors duration-300 mb-1 sm:mb-2">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 md:w-6 md:h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <p class="text-base sm:text-lg md:text-2xl font-bold text-gray-900">{{ $totalUsers }}</p>
                        <p class="text-[10px] sm:text-xs text-gray-500">Total</p>
                        <p class="text-[8px] sm:text-[9px] md:text-xs text-gray-400 mt-0.5">100%</p>
                    </div>
                </div>

                <!-- Active Users Card -->
                <div class="group bg-white rounded-xl sm:rounded-2xl border border-gray-100 p-2.5 sm:p-3 md:p-4 shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 animate-fade-in-up" style="animation-delay: 0.2s">
                    <div class="flex flex-col items-center text-center">
                        <div class="bg-green-50 rounded-full p-1.5 sm:p-2 md:p-3 group-hover:bg-green-100 transition-colors duration-300 mb-1 sm:mb-2">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 md:w-6 md:h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <p class="text-base sm:text-lg md:text-2xl font-bold text-gray-900">{{ $activeUsers }}</p>
                        <p class="text-[10px] sm:text-xs text-gray-500">Actifs</p>
                        <p class="text-[8px] sm:text-[9px] md:text-xs text-green-500 mt-0.5">{{ round(($activeUsers / max($totalUsers, 1)) * 100) }}%</p>
                    </div>
                </div>

                <!-- Inactive Users Card -->
                <div class="group bg-white rounded-xl sm:rounded-2xl border border-gray-100 p-2.5 sm:p-3 md:p-4 shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 animate-fade-in-up" style="animation-delay: 0.25s">
                    <div class="flex flex-col items-center text-center">
                        <div class="bg-red-50 rounded-full p-1.5 sm:p-2 md:p-3 group-hover:bg-red-100 transition-colors duration-300 mb-1 sm:mb-2">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 md:w-6 md:h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <p class="text-base sm:text-lg md:text-2xl font-bold text-gray-900">{{ $inactiveUsers }}</p>
                        <p class="text-[10px] sm:text-xs text-gray-500">Inactifs</p>
                        <p class="text-[8px] sm:text-[9px] md:text-xs text-red-500 mt-0.5">{{ round(($inactiveUsers / max($totalUsers, 1)) * 100) }}%</p>
                    </div>
                </div>

                <!-- Admins Card -->
                <div class="group bg-white rounded-xl sm:rounded-2xl border border-gray-100 p-2.5 sm:p-3 md:p-4 shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 animate-fade-in-up" style="animation-delay: 0.3s">
                    <div class="flex flex-col items-center text-center">
                        <div class="bg-purple-50 rounded-full p-1.5 sm:p-2 md:p-3 group-hover:bg-purple-100 transition-colors duration-300 mb-1 sm:mb-2">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 md:w-6 md:h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <p class="text-base sm:text-lg md:text-2xl font-bold text-gray-900">{{ $adminUsers }}</p>
                        <p class="text-[10px] sm:text-xs text-gray-500">Admins</p>
                        <p class="text-[8px] sm:text-[9px] md:text-xs text-purple-500 mt-0.5">{{ round(($adminUsers / max($totalUsers, 1)) * 100) }}%</p>
                    </div>
                </div>

                <!-- Teachers Card -->
                <div class="group bg-white rounded-xl sm:rounded-2xl border border-gray-100 p-2.5 sm:p-3 md:p-4 shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 animate-fade-in-up" style="animation-delay: 0.4s">
                    <div class="flex flex-col items-center text-center">
                        <div class="bg-blue-50 rounded-full p-1.5 sm:p-2 md:p-3 group-hover:bg-blue-100 transition-colors duration-300 mb-1 sm:mb-2">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 md:w-6 md:h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <p class="text-base sm:text-lg md:text-2xl font-bold text-gray-900">{{ $enseignantUsers }}</p>
                        <p class="text-[10px] sm:text-xs text-gray-500">Enseignants</p>
                        <p class="text-[8px] sm:text-[9px] md:text-xs text-blue-500 mt-0.5">{{ round(($enseignantUsers / max($totalUsers, 1)) * 100) }}%</p>
                    </div>
                </div>

                <!-- Students Card -->
                <div class="group bg-white rounded-xl sm:rounded-2xl border border-gray-100 p-2.5 sm:p-3 md:p-4 shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 animate-fade-in-up" style="animation-delay: 0.5s">
                    <div class="flex flex-col items-center text-center">
                        <div class="bg-green-50 rounded-full p-1.5 sm:p-2 md:p-3 group-hover:bg-green-100 transition-colors duration-300 mb-1 sm:mb-2">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 md:w-6 md:h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <p class="text-base sm:text-lg md:text-2xl font-bold text-gray-900">{{ $eleveUsers }}</p>
                        <p class="text-[10px] sm:text-xs text-gray-500">Élèves</p>
                        <p class="text-[8px] sm:text-[9px] md:text-xs text-green-500 mt-0.5">{{ round(($eleveUsers / max($totalUsers, 1)) * 100) }}%</p>
                    </div>
                </div>

                <!-- Parents Card -->
                <div class="group bg-white rounded-xl sm:rounded-2xl border border-gray-100 p-2.5 sm:p-3 md:p-4 shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 animate-fade-in-up" style="animation-delay: 0.6s">
                    <div class="flex flex-col items-center text-center">
                        <div class="bg-yellow-50 rounded-full p-1.5 sm:p-2 md:p-3 group-hover:bg-yellow-100 transition-colors duration-300 mb-1 sm:mb-2">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 md:w-6 md:h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <p class="text-base sm:text-lg md:text-2xl font-bold text-gray-900">{{ $parentUsers }}</p>
                        <p class="text-[10px] sm:text-xs text-gray-500">Parents</p>
                        <p class="text-[8px] sm:text-[9px] md:text-xs text-yellow-500 mt-0.5">{{ round(($parentUsers / max($totalUsers, 1)) * 100) }}%</p>
                    </div>
                </div>
            </div>

            <!-- Filtres avec design amélioré -->
            <div class="bg-white rounded-xl sm:rounded-2xl shadow-lg border border-gray-100 mb-6 sm:mb-8 overflow-hidden hover:shadow-xl transition-shadow duration-300 animate-fade-in-up" style="animation-delay: 0.7s">
                <div class="p-3 sm:p-4 md:p-5 lg:p-6 bg-gradient-to-r from-gray-50 to-white border-b border-gray-100">
                    <h4 class="text-xs sm:text-sm font-semibold text-gray-700 uppercase tracking-wider flex items-center gap-1.5 sm:gap-2">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                        </svg>
                        Filtres avancés
                    </h4>
                </div>
                <div class="p-3 sm:p-4 md:p-5 lg:p-6">
                    <form method="GET" action="{{ route('admin.users.index') }}" class="space-y-3 sm:space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3 sm:gap-4">
                            <div class="sm:col-span-2 lg:col-span-5">
                                <div class="relative group">
                                    <input type="text" name="search" value="{{ request('search') }}"
                                        placeholder="Rechercher par nom ou email..."
                                        class="w-full pl-9 sm:pl-10 md:pl-12 pr-3 sm:pr-4 py-2 sm:py-2.5 md:py-3 border-2 border-gray-200 rounded-lg sm:rounded-xl bg-gray-50 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-300 group-hover:border-gray-300 text-xs sm:text-sm">
                                    <div class="absolute inset-y-0 left-0 pl-2.5 sm:pl-3 md:pl-4 flex items-center pointer-events-none">
                                        <svg class="h-3.5 w-3.5 sm:h-4 sm:w-4 md:h-5 md:w-5 text-gray-400 group-hover:text-blue-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <div class="sm:col-span-1 lg:col-span-3">
                                <div class="relative group">
                                    <select name="role"
                                        class="w-full px-3 sm:px-4 py-2 sm:py-2.5 md:py-3 border-2 border-gray-200 rounded-lg sm:rounded-xl bg-gray-50 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-300 appearance-none cursor-pointer group-hover:border-gray-300 text-xs sm:text-sm">
                                        <option value="">Tous les rôles</option>
                                        @foreach($roles as $role)
                                            <option value="{{ $role->name }}" {{ request('role') == $role->name ? 'selected' : '' }}>
                                                {{ ucfirst($role->name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-2.5 sm:pr-3 md:pr-4 flex items-center pointer-events-none">
                                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 md:w-5 md:h-5 text-gray-400 group-hover:text-blue-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <div class="sm:col-span-1 lg:col-span-2">
                                <div class="relative group">
                                    <select name="status"
                                        class="w-full px-3 sm:px-4 py-2 sm:py-2.5 md:py-3 border-2 border-gray-200 rounded-lg sm:rounded-xl bg-gray-50 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-300 appearance-none cursor-pointer group-hover:border-gray-300 text-xs sm:text-sm">
                                        <option value="">Tous les statuts</option>
                                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Actifs</option>
                                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactifs</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-2.5 sm:pr-3 md:pr-4 flex items-center pointer-events-none">
                                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 md:w-5 md:h-5 text-gray-400 group-hover:text-blue-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <div class="sm:col-span-2 lg:col-span-2 flex gap-2 sm:gap-3">
                                <button type="submit"
                                    class="flex-1 px-3 sm:px-4 md:px-5 lg:px-6 py-2 sm:py-2.5 md:py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-medium rounded-lg sm:rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 flex items-center justify-center gap-1.5 sm:gap-2 group text-xs sm:text-sm">
                                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 md:w-5 md:h-5 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                                    </svg>
                                    Filtrer
                                </button>
                                
                                @if(request('search') || request('role') || request('status'))
                                    <a href="{{ route('admin.users.index') }}"
                                        class="px-3 sm:px-4 py-2 sm:py-2.5 md:py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg sm:rounded-xl transition-all duration-300 hover:shadow-md transform hover:scale-105 flex items-center justify-center group"
                                        title="Réinitialiser les filtres">
                                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 md:w-5 md:h-5 group-hover:rotate-180 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tableau des utilisateurs -->
            <div class="bg-white rounded-xl sm:rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-shadow duration-300 animate-fade-in-up" style="animation-delay: 0.8s">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                            <tr>
                                <th class="px-2 sm:px-3 md:px-4 lg:px-6 py-2 sm:py-3 md:py-4 text-left text-[10px] sm:text-xs font-semibold text-gray-600 uppercase tracking-wider">Utilisateur</th>
                                <th class="px-2 sm:px-3 md:px-4 lg:px-6 py-2 sm:py-3 md:py-4 text-left text-[10px] sm:text-xs font-semibold text-gray-600 uppercase tracking-wider">Rôle(s)</th>
                                <th class="px-2 sm:px-3 md:px-4 lg:px-6 py-2 sm:py-3 md:py-4 text-left text-[10px] sm:text-xs font-semibold text-gray-600 uppercase tracking-wider">Statut</th>
                                <th class="hidden md:table-cell px-2 sm:px-3 md:px-4 lg:px-6 py-2 sm:py-3 md:py-4 text-left text-[10px] sm:text-xs font-semibold text-gray-600 uppercase tracking-wider">Email vérifié</th>
                                <th class="hidden lg:table-cell px-2 sm:px-3 md:px-4 lg:px-6 py-2 sm:py-3 md:py-4 text-left text-[10px] sm:text-xs font-semibold text-gray-600 uppercase tracking-wider">Inscription</th>
                                <th class="hidden xl:table-cell px-2 sm:px-3 md:px-4 lg:px-6 py-2 sm:py-3 md:py-4 text-left text-[10px] sm:text-xs font-semibold text-gray-600 uppercase tracking-wider">Dernière connexion</th>
                                <th class="px-2 sm:px-3 md:px-4 lg:px-6 py-2 sm:py-3 md:py-4 text-left text-[10px] sm:text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($users as $user)
                                <tr class="group hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 transition-all duration-300">
                                    <td class="px-2 sm:px-3 md:px-4 lg:px-6 py-2 sm:py-3 md:py-4">
                                        <div class="flex items-center gap-2 sm:gap-3">
                                            <div class="relative flex-shrink-0">
                                                @if($user->photo)
                                                    <div class="h-8 w-8 sm:h-9 sm:w-9 md:h-10 md:w-10 lg:h-12 lg:w-12 rounded-full overflow-hidden ring-2 ring-white shadow-lg">
                                                        <img src="{{ $user->photo_url }}" 
                                                             alt="{{ $user->name }}" 
                                                             class="h-full w-full object-cover"
                                                             loading="lazy">
                                                    </div>
                                                @else
                                                    <div class="h-8 w-8 sm:h-9 sm:w-9 md:h-10 md:w-10 lg:h-12 lg:w-12 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white font-bold text-sm sm:text-base md:text-lg shadow-lg">
                                                        {{ $user->initials }}
                                                    </div>
                                                @endif
                                                <div class="absolute -bottom-0.5 -right-0.5 h-2.5 w-2.5 sm:h-3 sm:w-3 rounded-full border-2 border-white 
                                                    {{ $user->is_active ? 'bg-green-400' : 'bg-red-400' }}">
                                                </div>
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <div class="flex items-center gap-1 flex-wrap">
                                                    <div class="text-xs sm:text-sm font-semibold text-gray-900 truncate">
                                                        {{ $user->name }}
                                                    </div>
                                                    @if($user->roles->count() > 1)
                                                        <span class="px-1 py-0.5 text-[8px] sm:text-[9px] bg-purple-100 text-purple-800 rounded-full">
                                                            {{ $user->roles->count() }} rôles
                                                        </span>
                                                    @endif
                                                    @if($user->created_at->isToday())
                                                        <span class="px-1 py-0.5 text-[8px] sm:text-[9px] bg-green-100 text-green-800 rounded-full animate-pulse">
                                                            Nouveau
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="text-[10px] sm:text-xs text-gray-500 flex items-center gap-0.5 mt-0.5 truncate">
                                                    <svg class="w-2.5 h-2.5 sm:w-3 sm:h-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                                    </svg>
                                                    <span class="truncate">{{ $user->email }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        </td>
                                    <td class="px-2 sm:px-3 md:px-4 lg:px-6 py-2 sm:py-3 md:py-4">
                                        <div class="flex flex-wrap gap-1">
                                            @if($user->roles->count() > 0)
                                                @foreach($user->roles as $role)
                                                    @php
                                                        $roleClass = match($role->name) {
                                                            'administrateur' => 'bg-purple-100 text-purple-800 border-purple-200',
                                                            'enseignant' => 'bg-blue-100 text-blue-800 border-blue-200',
                                                            'eleve' => 'bg-green-100 text-green-800 border-green-200',
                                                            'parent' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                                            default => 'bg-gray-100 text-gray-800 border-gray-200'
                                                        };
                                                    @endphp
                                                    <span class="inline-flex items-center gap-0.5 px-1.5 py-0.5 sm:px-2 sm:py-1 rounded-lg text-[9px] sm:text-xs font-medium border {{ $roleClass }}">
                                                        {{ ucfirst($role->name) }}
                                                    </span>
                                                @endforeach
                                            @elseif($user->role)
                                                @php
                                                    $dbRoleClass = match(strtolower($user->role)) {
                                                        'administrateur', 'admin' => 'bg-purple-100 text-purple-800 border-purple-200',
                                                        'enseignant' => 'bg-blue-100 text-blue-800 border-blue-200',
                                                        'eleve', 'etudiant' => 'bg-green-100 text-green-800 border-green-200',
                                                        'parent' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                                        default => 'bg-gray-100 text-gray-800 border-gray-200'
                                                    };
                                                @endphp
                                                <span class="inline-flex items-center gap-0.5 px-1.5 py-0.5 sm:px-2 sm:py-1 rounded-lg text-[9px] sm:text-xs font-medium border {{ $dbRoleClass }}">
                                                    {{ ucfirst($user->role) }}
                                                </span>
                                            @else
                                                <span class="text-gray-400 text-[9px] sm:text-xs">Aucun rôle</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-2 sm:px-3 md:px-4 lg:px-6 py-2 sm:py-3 md:py-4">
                                        @if($user->is_active)
                                            <span class="inline-flex items-center gap-1 px-1.5 py-0.5 sm:px-2 sm:py-1 md:px-3 md:py-1.5 rounded-lg text-[9px] sm:text-xs font-medium whitespace-nowrap bg-green-100 text-green-800 border border-green-200">
                                                <span class="relative flex h-1.5 w-1.5 sm:h-2 sm:w-2">
                                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full opacity-75 bg-green-400"></span>
                                                    <span class="relative inline-flex rounded-full h-1.5 w-1.5 sm:h-2 sm:w-2 bg-green-500"></span>
                                                </span>
                                                Actif
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-1.5 py-0.5 sm:px-2 sm:py-1 md:px-3 md:py-1.5 rounded-lg text-[9px] sm:text-xs font-medium whitespace-nowrap bg-red-100 text-red-800 border border-red-200">
                                                <span class="relative flex h-1.5 w-1.5 sm:h-2 sm:w-2">
                                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full opacity-75 bg-red-400"></span>
                                                    <span class="relative inline-flex rounded-full h-1.5 w-1.5 sm:h-2 sm:w-2 bg-red-500"></span>
                                                </span>
                                                Inactif
                                            </span>
                                        @endif
                                    </td>
                                    <td class="hidden md:table-cell px-2 sm:px-3 md:px-4 lg:px-6 py-2 sm:py-3 md:py-4">
                                        @if($user->email_verified_at)
                                            <span class="inline-flex items-center gap-0.5 px-1.5 py-0.5 sm:px-2 sm:py-1 rounded-lg text-[9px] sm:text-xs font-medium bg-green-100 text-green-800">
                                                <svg class="w-2.5 h-2.5 sm:w-3 sm:h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                Vérifié
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-0.5 px-1.5 py-0.5 sm:px-2 sm:py-1 rounded-lg text-[9px] sm:text-xs font-medium bg-yellow-100 text-yellow-800">
                                                <svg class="w-2.5 h-2.5 sm:w-3 sm:h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                Non vérifié
                                            </span>
                                        @endif
                                    </td>
                                    <td class="hidden lg:table-cell px-2 sm:px-3 md:px-4 lg:px-6 py-2 sm:py-3 md:py-4">
                                        <span class="text-[10px] sm:text-xs text-gray-600 whitespace-nowrap">
                                            {{ $user->created_at->format('d/m/Y') }}
                                            <span class="text-[8px] sm:text-[9px] text-gray-400 block">{{ $user->created_at->diffForHumans() }}</span>
                                        </span>
                                    </td>
                                    <td class="hidden xl:table-cell px-2 sm:px-3 md:px-4 lg:px-6 py-2 sm:py-3 md:py-4">
                                        <span class="text-[10px] sm:text-xs text-gray-600">
                                            @if($user->last_login_at)
                                                {{ $user->last_login_at->diffForHumans() }}
                                                <span class="text-[8px] sm:text-[9px] text-gray-400 block">{{ $user->last_login_at->format('d/m/Y H:i') }}</span>
                                            @else
                                                <span class="text-gray-400">Jamais connecté</span>
                                            @endif
                                        </span>
                                    </td>
                                    <!-- Colonne ACTIONS - icônes uniquement sans libellé -->
                                    <td class="px-2 sm:px-3 md:px-4 lg:px-6 py-2 sm:py-3 md:py-4">
                                        <div class="flex items-center justify-end gap-1 md:gap-2 whitespace-nowrap">
                                            <!-- Voir -->
                                            <a href="{{ route('admin.users.show', $user) }}"
                                                class="p-1.5 md:p-2 text-blue-600 bg-transparent hover:bg-blue-50 rounded-lg transition-colors border-none flex-shrink-0"
                                                title="Voir">
                                                <svg class="w-4 h-4 md:w-5 md:h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            </a>
                                            <!-- Modifier -->
                                            <a href="{{ route('admin.users.edit', $user) }}"
                                                class="p-1.5 md:p-2 text-amber-600 bg-transparent hover:bg-amber-50 rounded-lg transition-colors border-none flex-shrink-0"
                                                title="Modifier">
                                                <svg class="w-4 h-4 md:w-5 md:h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </a>
                                            <!-- Photo -->
                                            @if($user->photo)
                                                <a href="{{ $user->photo_url }}" target="_blank"
                                                   class="p-1.5 md:p-2 text-emerald-600 bg-transparent hover:bg-emerald-50 rounded-lg transition-colors border-none flex-shrink-0"
                                                   title="Voir la photo">
                                                    <svg class="w-4 h-4 md:w-5 md:h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                </a>
                                            @endif
                                            <!-- Activer/Désactiver -->
                                            @if(auth()->user()->isAdmin() && auth()->id() != $user->id)
                                                <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST" class="inline toggle-status-form m-0 p-0 flex-shrink-0">
                                                    @csrf @method('PATCH')
                                                    <button type="button"
                                                        class="p-1.5 md:p-2 {{ $user->is_active ? 'text-red-600 hover:bg-red-50' : 'text-green-600 hover:bg-green-50' }} bg-transparent rounded-lg transition-colors border-none cursor-pointer flex items-center justify-center toggle-status-btn"
                                                        title="{{ $user->is_active ? 'Désactiver' : 'Activer' }}">
                                                        <svg class="w-4 h-4 md:w-5 md:h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            @if($user->is_active)
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                                                            @else
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                            @endif
                                                        </svg>
                                                    </button>
                                                </form>
                                                <!-- Supprimer -->
                                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline m-0 p-0 delete-form flex-shrink-0">
                                                    @csrf @method('DELETE')
                                                    <button type="button" class="p-1.5 md:p-2 text-red-600 bg-transparent hover:bg-red-50 rounded-lg transition-colors border-none cursor-pointer flex items-center justify-center delete-btn" title="Supprimer" data-user-id="{{ $user->id }}" data-user-name="{{ $user->name }}">
                                                        <svg class="w-4 h-4 md:w-5 md:h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-3 sm:px-4 md:px-6 py-8 sm:py-12 md:py-16 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-12 h-12 sm:w-14 sm:h-14 md:w-16 md:h-16 text-gray-300 mb-3 sm:mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                            </svg>
                                            <p class="text-sm sm:text-base text-gray-500 font-medium">Aucun utilisateur trouvé</p>
                                            <p class="text-xs sm:text-sm text-gray-400 mt-1">Essayez de modifier vos filtres ou créez un nouvel utilisateur</p>
                                            <a href="{{ route('admin.users.create') }}" class="mt-3 sm:mt-4 px-3 sm:px-4 md:px-5 lg:px-6 py-1.5 sm:py-2 md:py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white text-xs sm:text-sm rounded-lg sm:rounded-xl shadow-lg hover:shadow-xl transition-all duration-200">
                                                Créer un utilisateur
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($users->count() > 0)
                    <div class="px-3 sm:px-4 md:px-5 lg:px-6 py-2 sm:py-2.5 md:py-3 bg-gray-50 border-t border-gray-200 text-[10px] sm:text-xs text-gray-600">
                        <div class="flex flex-col sm:flex-row justify-between items-center gap-2">
                            <span>Affichage de {{ $users->firstItem() }} à {{ $users->lastItem() }} sur {{ $users->total() }} utilisateurs</span>
                            <span class="font-medium">Page {{ $users->currentPage() }} / {{ $users->lastPage() }}</span>
                        </div>
                    </div>
                @endif

                @if($users->hasPages())
                    <div class="px-3 sm:px-4 md:px-5 lg:px-6 py-3 sm:py-4 border-t border-gray-200 bg-gradient-to-r from-gray-50 to-white">
                        {{ $users->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modals -->
    <div id="deleteModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-end justify-center min-h-screen pt-4 px-3 sm:px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" id="modal-backdrop"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Confirmer la suppression</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Êtes-vous sûr de vouloir supprimer l'utilisateur <span id="userName" class="font-semibold"></span> ?
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" id="confirmDelete" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                        Supprimer
                    </button>
                    <button type="button" id="cancelDelete" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Annuler
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div id="toggleStatusModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-end justify-center min-h-screen pt-4 px-3 sm:px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" id="toggle-modal-backdrop"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10" id="toggle-icon-container">
                            <svg class="h-6 w-6 text-blue-600" id="toggle-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Confirmer l'action</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Êtes-vous sûr de vouloir <span id="toggle-action" class="font-semibold"></span> l'utilisateur <span id="toggle-user-name" class="font-semibold"></span> ?
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" id="confirmToggle" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                        Confirmer
                    </button>
                    <button type="button" id="cancelToggle" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Annuler
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    * {
        max-width: 100%;
        box-sizing: border-box;
    }
    
    body, html {
        overflow-x: hidden;
        width: 100%;
        position: relative;
    }
    
    .overflow-x-hidden {
        overflow-x: hidden !important;
    }

    @keyframes fade-in-down {
        0% {
            opacity: 0;
            transform: translateY(-20px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fade-in-up {
        0% {
            opacity: 0;
            transform: translateY(20px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in-down {
        animation: fade-in-down 0.6s ease-out;
    }

    .animate-fade-in-up {
        animation: fade-in-up 0.6s ease-out;
        animation-fill-mode: both;
    }

    /* Tableau responsive - permet de scroller horizontalement si nécessaire */
    @media (max-width: 768px) {
        .overflow-x-auto {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        
        table {
            min-width: 700px;
        }
    }
    
    /* Pour les très petits écrans */
    @media (max-width: 640px) {
        table {
            min-width: 650px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Modal de suppression
        const deleteModal = document.getElementById('deleteModal');
        const confirmDeleteBtn = document.getElementById('confirmDelete');
        const cancelDeleteBtn = document.getElementById('cancelDelete');
        const userNameSpan = document.getElementById('userName');
        let currentDeleteForm = null;

        // Modal d'activation/désactivation
        const toggleModal = document.getElementById('toggleStatusModal');
        const confirmToggleBtn = document.getElementById('confirmToggle');
        const cancelToggleBtn = document.getElementById('cancelToggle');
        const toggleActionSpan = document.getElementById('toggle-action');
        const toggleUserNameSpan = document.getElementById('toggle-user-name');
        const toggleIcon = document.getElementById('toggle-icon');
        const toggleIconContainer = document.getElementById('toggle-icon-container');
        let currentToggleForm = null;

        // Boutons de suppression
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('.delete-form');
                const userName = this.dataset.userName;
                if (form && userName) {
                    currentDeleteForm = form;
                    userNameSpan.textContent = userName;
                    deleteModal.classList.remove('hidden');
                }
            });
        });

        // Boutons d'activation/désactivation
        document.querySelectorAll('.toggle-status-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('.toggle-status-form');
                const row = form.closest('tr');
                const userNameElement = row.querySelector('.font-semibold.text-gray-900');
                const userName = userNameElement ? userNameElement.textContent : 'inconnu';
                const isActive = this.classList.contains('text-red-600');
                
                if (form && userName) {
                    currentToggleForm = form;
                    const actionText = isActive ? 'désactiver' : 'activer';
                    toggleActionSpan.textContent = actionText;
                    toggleUserNameSpan.textContent = userName;
                    
                    if (isActive) {
                        toggleIconContainer.className = 'mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10';
                        toggleIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>';
                        confirmToggleBtn.className = 'w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm';
                    } else {
                        toggleIconContainer.className = 'mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10';
                        toggleIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>';
                        confirmToggleBtn.className = 'w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm';
                    }
                    toggleModal.classList.remove('hidden');
                }
            });
        });

        function closeDeleteModal() {
            deleteModal.classList.add('hidden');
            currentDeleteForm = null;
        }

        function closeToggleModal() {
            toggleModal.classList.add('hidden');
            currentToggleForm = null;
        }

        confirmDeleteBtn.addEventListener('click', function() {
            if (currentDeleteForm) currentDeleteForm.submit();
            closeDeleteModal();
        });

        confirmToggleBtn.addEventListener('click', function() {
            if (currentToggleForm) currentToggleForm.submit();
            closeToggleModal();
        });

        cancelDeleteBtn.addEventListener('click', closeDeleteModal);
        cancelToggleBtn.addEventListener('click', closeToggleModal);

        document.getElementById('modal-backdrop')?.addEventListener('click', closeDeleteModal);
        document.getElementById('toggle-modal-backdrop')?.addEventListener('click', closeToggleModal);

        // Auto-hide des messages flash
        setTimeout(function() {
            document.querySelectorAll('.bg-green-100, .bg-red-100, .bg-yellow-100').forEach(msg => {
                msg.style.transition = 'opacity 0.5s';
                msg.style.opacity = '0';
                setTimeout(() => msg.remove(), 500);
            });
        }, 5000);
    });
</script>
@endpush