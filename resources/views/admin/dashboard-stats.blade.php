{{-- resources/views/dashboard.blade.php --}}
@extends('layouts.app')

@section('header')
    <h2 class="font-semibold  text-xl sm:text-sm md:text-sm text-gray-800 leading-tight">
        {{ __('Tableau de bord') }}
    </h2>
@endsection

@section('content')
    @php
// Données simulées pour les graphiques
$inscriptionsByMonth = [
    'labels' => ['Sept', 'Oct', 'Nov', 'Déc', 'Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin'],
    'data' => [45, 52, 38, 24, 33, 42, 55, 48, 51, 39]
];

$studentsByClass = [
    'labels' => ['6ème A', '5ème B', '4ème C', '3ème D', '2nde A', '1ère B', 'Tle C'],
    'data' => [32, 28, 35, 31, 29, 33, 27]
];

$gradesByTrimester = [
    'labels' => ['Trimestre 1', 'Trimestre 2', 'Trimestre 3'],
    'data' => [13.5, 14.2, 15.8]
];

$absencesByMonth = [
    'labels' => ['Sept', 'Oct', 'Nov', 'Déc', 'Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin'],
    'data' => [12, 18, 15, 8, 10, 14, 22, 16, 19, 13]
];
    @endphp

    {{-- Main Container: Added horizontal padding for mobile --}}
    <div class="py-6 overflow-x-hidden md:py-12">
        <div class="px-3 mx-auto max-w-7xl sm:px-4 lg:px-6">

            <!-- Welcome Banner -->
            <div class="bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-700 rounded-xl shadow-2xl mb-6 md:mb-8 p-4 sm:p-6 md:p-8 relative overflow-hidden group">
                <div class="absolute inset-0 bg-gradient-to-r from-blue-400/20 to-purple-400/20 animate-pulse"></div>
                <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-20"></div>

                <div class="relative flex flex-col md:flex-row items-center justify-between gap-4 md:gap-6">
                    <div class="flex-1 text-center md:text-left">
                        <div class="inline-flex items-center px-2 py-1 md:px-3 md:py-1.5 bg-white/20 backdrop-blur-sm rounded-full text-white text-[10px] md:text-xs font-semibold mb-2 md:mb-3">
                            <span class="w-1.5 h-1.5 bg-green-400 rounded-full mr-1.5 animate-pulse"></span>
                            {{ now()->format('l d F Y') }}
                        </div>
                        <h3 class="text-xl sm:text-2xl md:text-3xl lg:text-4xl font-bold text-white mb-2">Bienvenue, Administrateur</h3>
                        <p class="text-blue-50 text-xs sm:text-sm md:text-base lg:text-lg max-w-2xl leading-relaxed">
                            Gérez et analysez les performances de votre établissement scolaire en temps réel
                        </p>

                        <!-- Quick stats -->
                        <div class="flex flex-wrap justify-center md:justify-start gap-2 mt-3 md:mt-4">
                            <div class="bg-white/10 backdrop-blur-sm rounded-lg px-2 py-1 md:px-3 md:py-1.5 flex items-center">
                                <span class="w-1.5 h-1.5 bg-green-400 rounded-full mr-1"></span>
                                <span class="text-white/90 text-[10px] md:text-xs">Taux de réussite: 92%</span>
                            </div>
                            <div class="bg-white/10 backdrop-blur-sm rounded-lg px-2 py-1 md:px-3 md:py-1.5 flex items-center">
                                <span class="w-1.5 h-1.5 bg-yellow-400 rounded-full mr-1"></span>
                                <span class="text-white/90 text-[10px] md:text-xs">Présence: 87%</span>
                            </div>
                            <div class="bg-white/10 backdrop-blur-sm rounded-lg px-2 py-1 md:px-3 md:py-1.5 flex items-center">
                                <span class="w-1.5 h-1.5 bg-blue-400 rounded-full mr-1"></span>
                                <span class="text-white/90 text-[10px] md:text-xs">{{ \App\Models\Eleve::count() }} élèves</span>
                            </div>
                        </div>
                    </div>

                    <div class="hidden lg:block group-hover:scale-110 transition-transform duration-500">
                        <div class="bg-white/20 backdrop-blur-xl rounded-2xl p-4 border border-white/30">
                            <svg class="w-16 h-16 md:w-20 md:h-20 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 md:gap-4 lg:gap-6 mb-6 md:mb-8">
                <!-- Total Élèves -->
                <div class="group bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden transform hover:-translate-y-2">
                    <div class="h-1.5 bg-gradient-to-r from-blue-400 to-blue-600"></div>
                    <div class="p-3 sm:p-4 md:p-5 lg:p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex-1 min-w-0">
                                <p class="text-[10px] sm:text-xs md:text-sm font-semibold text-gray-500 uppercase tracking-wide mb-1">Total Élèves</p>
                                <p class="text-xl sm:text-2xl md:text-3xl lg:text-4xl font-bold bg-gradient-to-r from-blue-600 to-blue-400 bg-clip-text text-transparent truncate">
                                    {{ \App\Models\Eleve::count() }}
                                </p>
                                <div class="flex items-center mt-1">
                                    <span class="inline-flex items-center px-1.5 py-0.5 bg-green-100 text-green-600 text-[8px] sm:text-[10px] md:text-xs font-semibold rounded-full">
                                        <svg class="w-2 h-2 mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                                        </svg>
                                        +12% ce mois
                                    </span>
                                </div>
                            </div>
                            <div class="flex-shrink-0 ml-2 bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl p-2 sm:p-3 md:p-4 shadow-lg group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 md:w-6 md:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="mt-2 md:mt-3 h-1 w-full bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full w-3/4 bg-gradient-to-r from-blue-400 to-blue-600 rounded-full progress-bar"></div>
                        </div>
                    </div>
                </div>

                <!-- Total Enseignants -->
                <div class="group bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden transform hover:-translate-y-2">
                    <div class="h-1.5 bg-gradient-to-r from-green-400 to-emerald-600"></div>
                    <div class="p-3 sm:p-4 md:p-5 lg:p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex-1 min-w-0">
                                <p class="text-[10px] sm:text-xs md:text-sm font-semibold text-gray-500 uppercase tracking-wide mb-1">Enseignants</p>
                                <p class="text-xl sm:text-2xl md:text-3xl lg:text-4xl font-bold bg-gradient-to-r from-green-600 to-emerald-400 bg-clip-text text-transparent truncate">
                                    {{ \App\Models\Enseignant::count() }}
                                </p>
                                <div class="flex items-center mt-1">
                                    <span class="inline-flex items-center px-1.5 py-0.5 bg-green-100 text-green-600 text-[8px] sm:text-[10px] md:text-xs font-semibold rounded-full">
                                        <svg class="w-2 h-2 mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                                        </svg>
                                        +5% ce mois
                                    </span>
                                </div>
                            </div>
                            <div class="flex-shrink-0 ml-2 bg-gradient-to-br from-green-400 to-emerald-600 rounded-xl p-2 sm:p-3 md:p-4 shadow-lg group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 md:w-6 md:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="mt-2 md:mt-3 h-1 w-full bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full w-4/5 bg-gradient-to-r from-green-400 to-emerald-600 rounded-full progress-bar"></div>
                        </div>
                    </div>
                </div>

                <!-- Total Classes -->
                <div class="group bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden transform hover:-translate-y-2">
                    <div class="h-1.5 bg-gradient-to-r from-purple-400 to-purple-600"></div>
                    <div class="p-3 sm:p-4 md:p-5 lg:p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex-1 min-w-0">
                                <p class="text-[10px] sm:text-xs md:text-sm font-semibold text-gray-500 uppercase tracking-wide mb-1">Classes</p>
                                <p class="text-xl sm:text-2xl md:text-3xl lg:text-4xl font-bold bg-gradient-to-r from-purple-600 to-purple-400 bg-clip-text text-transparent truncate">
                                    {{ \App\Models\Classe::count() }}
                                </p>
                                <div class="flex items-center mt-1">
                                    <span class="inline-flex items-center px-1.5 py-0.5 bg-purple-100 text-purple-600 text-[8px] sm:text-[10px] md:text-xs font-semibold rounded-full">
                                        <svg class="w-2 h-2 mr-0.5" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M13 10h5l-6 6-6-6h5V3h2v7z"></path>
                                        </svg>
                                        Stable
                                    </span>
                                </div>
                            </div>
                            <div class="flex-shrink-0 ml-2 bg-gradient-to-br from-purple-400 to-purple-600 rounded-xl p-2 sm:p-3 md:p-4 shadow-lg group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 md:w-6 md:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="mt-2 md:mt-3 h-1 w-full bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full w-full bg-gradient-to-r from-purple-400 to-purple-600 rounded-full progress-bar"></div>
                        </div>
                    </div>
                </div>

                <!-- Total Matières -->
                <div class="group bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden transform hover:-translate-y-2">
                    <div class="h-1.5 bg-gradient-to-r from-amber-400 to-orange-600"></div>
                    <div class="p-3 sm:p-4 md:p-5 lg:p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex-1 min-w-0">
                                <p class="text-[10px] sm:text-xs md:text-sm font-semibold text-gray-500 uppercase tracking-wide mb-1">Matières</p>
                                <p class="text-xl sm:text-2xl md:text-3xl lg:text-4xl font-bold bg-gradient-to-r from-amber-600 to-orange-400 bg-clip-text text-transparent truncate">
                                    {{ \App\Models\Matiere::count() }}
                                </p>
                                <div class="flex items-center mt-1">
                                    <span class="inline-flex items-center px-1.5 py-0.5 bg-green-100 text-green-600 text-[8px] sm:text-[10px] md:text-xs font-semibold rounded-full">
                                        <svg class="w-2 h-2 mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                                        </svg>
                                        +3 nouvelles
                                    </span>
                                </div>
                            </div>
                            <div class="flex-shrink-0 ml-2 bg-gradient-to-br from-amber-400 to-orange-600 rounded-xl p-2 sm:p-3 md:p-4 shadow-lg group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 md:w-6 md:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="mt-2 md:mt-3 h-1 w-full bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full w-4/5 bg-gradient-to-r from-amber-400 to-orange-600 rounded-full progress-bar"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Row 1 -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-6 mb-6 md:mb-8">
                <!-- Inscriptions by Month Chart -->
                <div class="bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 p-3 sm:p-4 md:p-5 lg:p-6 backdrop-blur-sm border border-gray-100">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-3 md:mb-4 gap-2">
                        <h3 class="text-sm sm:text-base md:text-lg font-bold text-gray-900 flex items-center">
                            <div class="bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg p-1 mr-2 shadow-md">
                                <svg class="w-3 h-3 sm:w-4 sm:h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                            <span class="text-xs sm:text-sm md:text-base">Inscriptions par mois</span>
                        </h3>
                        <div class="flex items-center space-x-1 sm:space-x-2">
                            <span class="px-1.5 py-0.5 md:px-2 md:py-1 bg-blue-50 text-blue-600 text-[8px] sm:text-[10px] md:text-xs font-semibold rounded-full">2025</span>
                            <span class="px-1.5 py-0.5 md:px-2 md:py-1 bg-gray-50 text-gray-600 text-[8px] sm:text-[10px] md:text-xs font-semibold rounded-full">Total: {{ array_sum($inscriptionsByMonth['data']) }}</span>
                        </div>
                    </div>
                    <div class="relative h-48 sm:h-56 md:h-64">
                        <canvas id="inscriptionsChart"></canvas>
                    </div>
                </div>

                <!-- Students by Class Chart -->
                <div class="bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 p-3 sm:p-4 md:p-5 lg:p-6 backdrop-blur-sm border border-gray-100">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-3 md:mb-4 gap-2">
                        <h3 class="text-sm sm:text-base md:text-lg font-bold text-gray-900 flex items-center">
                            <div class="bg-gradient-to-br from-purple-400 to-purple-600 rounded-lg p-1 mr-2 shadow-md">
                                <svg class="w-3 h-3 sm:w-4 sm:h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                                </svg>
                            </div>
                            <span class="text-xs sm:text-sm md:text-base">Répartition par classe</span>
                        </h3>
                        <div class="flex items-center space-x-1 sm:space-x-2">
                            <span class="px-1.5 py-0.5 md:px-2 md:py-1 bg-purple-50 text-purple-600 text-[8px] sm:text-[10px] md:text-xs font-semibold rounded-full">Total: {{ array_sum($studentsByClass['data']) }}</span>
                        </div>
                    </div>
                    <div class="relative h-48 sm:h-56 md:h-64">
                        <canvas id="studentsByClassChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Charts Row 2 -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-6 mb-6 md:mb-8">
                <!-- Average Grades by Trimester Chart -->
                <div class="bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 p-3 sm:p-4 md:p-5 lg:p-6 backdrop-blur-sm border border-gray-100">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-3 md:mb-4 gap-2">
                        <h3 class="text-sm sm:text-base md:text-lg font-bold text-gray-900 flex items-center">
                            <div class="bg-gradient-to-br from-green-400 to-emerald-600 rounded-lg p-1 mr-2 shadow-md">
                                <svg class="w-3 h-3 sm:w-4 sm:h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                            <span class="text-xs sm:text-sm md:text-base">Moyennes par trimestre</span>
                        </h3>
                        <div class="flex items-center space-x-1 sm:space-x-2">
                            <span class="px-1.5 py-0.5 md:px-2 md:py-1 bg-green-50 text-green-600 text-[8px] sm:text-[10px] md:text-xs font-semibold rounded-full">/20</span>
                        </div>
                    </div>
                    <div class="relative h-48 sm:h-56 md:h-64">
                        <canvas id="gradesByTrimesterChart"></canvas>
                    </div>
                </div>

                <!-- Absences by Month Chart -->
                <div class="bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 p-3 sm:p-4 md:p-5 lg:p-6 backdrop-blur-sm border border-gray-100">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-3 md:mb-4 gap-2">
                        <h3 class="text-sm sm:text-base md:text-lg font-bold text-gray-900 flex items-center">
                            <div class="bg-gradient-to-br from-red-400 to-red-600 rounded-lg p-1 mr-2 shadow-md">
                                <svg class="w-3 h-3 sm:w-4 sm:h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                            </div>
                            <span class="text-xs sm:text-sm md:text-base">Absences par mois</span>
                        </h3>
                        <div class="flex items-center space-x-1 sm:space-x-2">
                            <span class="px-1.5 py-0.5 md:px-2 md:py-1 bg-red-50 text-red-600 text-[8px] sm:text-[10px] md:text-xs font-semibold rounded-full">Total: {{ array_sum($absencesByMonth['data']) }}</span>
                        </div>
                    </div>
                    <div class="relative h-48 sm:h-56 md:h-64">
                        <canvas id="absencesChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 mb-6 md:mb-8 border border-gray-100">
                <div class="p-3 sm:p-4 md:p-5 lg:p-6 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                    <div class="flex items-center">
                        <div class="bg-gradient-to-br from-blue-400 to-indigo-600 rounded-lg p-1 mr-2 shadow-md">
                            <svg class="w-3 h-3 sm:w-4 sm:h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <h3 class="text-sm sm:text-base md:text-lg font-bold text-gray-900">Actions rapides</h3>
                    </div>
                </div>
                <div class="p-3 sm:p-4 md:p-5 lg:p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-2 md:gap-3">
                        <a href="{{ route('admin.classes.index') }}"
                           class="group relative bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-lg p-3 md:p-4 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-xl overflow-hidden">
                            <div class="absolute top-0 right-0 w-16 h-16 bg-white/10 rounded-full -translate-y-8 translate-x-8 group-hover:translate-y-0 group-hover:translate-x-0 transition-transform duration-500"></div>
                            <div class="relative flex items-center">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6 mr-2 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                                <div>
                                    <span class="block font-bold text-xs sm:text-sm md:text-base">Classes</span>
                                    <span class="text-[8px] sm:text-[10px] md:text-xs text-blue-100">{{ \App\Models\Classe::count() }} classes</span>
                                </div>
                            </div>
                        </a>

                        <a href="{{ route('admin.matieres.index') }}"
                           class="group relative bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white rounded-lg p-3 md:p-4 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-xl overflow-hidden">
                            <div class="absolute top-0 right-0 w-16 h-16 bg-white/10 rounded-full -translate-y-8 translate-x-8 group-hover:translate-y-0 group-hover:translate-x-0 transition-transform duration-500"></div>
                            <div class="relative flex items-center">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6 mr-2 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                                <div>
                                    <span class="block font-bold text-xs sm:text-sm md:text-base">Matières</span>
                                    <span class="text-[8px] sm:text-[10px] md:text-xs text-green-100">{{ \App\Models\Matiere::count() }} matières</span>
                                </div>
                            </div>
                        </a>

                        <a href="{{ route('admin.inscriptions.index') }}"
                           class="group relative bg-gradient-to-r from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white rounded-lg p-3 md:p-4 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-xl overflow-hidden">
                            <div class="absolute top-0 right-0 w-16 h-16 bg-white/10 rounded-full -translate-y-8 translate-x-8 group-hover:translate-y-0 group-hover:translate-x-0 transition-transform duration-500"></div>
                            <div class="relative flex items-center">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6 mr-2 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                </svg>
                                <div>
                                    <span class="block font-bold text-xs sm:text-sm md:text-base">Inscriptions</span>
                                    <span class="text-[8px] sm:text-[10px] md:text-xs text-purple-100">{{ \App\Models\Inscription::count() }}</span>
                                </div>
                            </div>
                        </a>

                        <a href="{{ route('admin.eleves.index') }}"
                           class="group relative bg-gradient-to-r from-cyan-500 to-cyan-600 hover:from-cyan-600 hover:to-cyan-700 text-white rounded-lg p-3 md:p-4 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-xl overflow-hidden">
                            <div class="absolute top-0 right-0 w-16 h-16 bg-white/10 rounded-full -translate-y-8 translate-x-8 group-hover:translate-y-0 group-hover:translate-x-0 transition-transform duration-500"></div>
                            <div class="relative flex items-center">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6 mr-2 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                                <div>
                                    <span class="block font-bold text-xs sm:text-sm md:text-base">Élèves</span>
                                    <span class="text-[8px] sm:text-[10px] md:text-xs text-cyan-100">{{ \App\Models\Eleve::count() }} élèves</span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Recent Inscriptions -->
            <div class="bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100">
                <div class="p-3 sm:p-4 md:p-5 lg:p-6 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2">
                        <div class="flex items-center">
                            <div class="bg-gradient-to-br from-blue-400 to-indigo-600 rounded-lg p-1 mr-2 shadow-md">
                                <svg class="w-3 h-3 sm:w-4 sm:h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-sm sm:text-base md:text-lg font-bold text-gray-900">Inscriptions récentes</h3>
                        </div>
                        <a href="{{ route('admin.inscriptions.index') }}" class="text-[10px] sm:text-xs md:text-sm text-indigo-600 hover:text-indigo-800 font-semibold flex items-center group">
                            Voir tout
                            <svg class="w-3 h-3 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                            <tr>
                                <th class="px-3 sm:px-4 md:px-6 py-2 md:py-3 text-left text-[8px] sm:text-[10px] md:text-xs font-bold text-gray-600 uppercase tracking-wider">Élève</th>
                                <th class="px-3 sm:px-4 md:px-6 py-2 md:py-3 text-left text-[8px] sm:text-[10px] md:text-xs font-bold text-gray-600 uppercase tracking-wider">Classe</th>
                                <th class="hidden sm:table-cell px-3 sm:px-4 md:px-6 py-2 md:py-3 text-left text-[8px] sm:text-[10px] md:text-xs font-bold text-gray-600 uppercase tracking-wider">Date</th>
                                <th class="px-3 sm:px-4 md:px-6 py-2 md:py-3 text-left text-[8px] sm:text-[10px] md:text-xs font-bold text-gray-600 uppercase tracking-wider">Statut</th>
                                <th class="px-3 sm:px-4 md:px-6 py-2 md:py-3 text-left text-[8px] sm:text-[10px] md:text-xs font-bold text-gray-600 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse(\App\Models\Inscription::with(['eleve', 'classe'])->latest()->take(5)->get() as $inscription)
                                <tr class="hover:bg-gradient-to-r hover:from-blue-50 hover:to-transparent transition-all duration-200 group">
                                    <td class="px-3 sm:px-4 md:px-6 py-2 md:py-3 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-6 h-6 sm:w-7 sm:h-7 md:w-8 md:h-8 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-bold text-[10px] sm:text-xs mr-2 shadow-md flex-shrink-0">
                                                {{ strtoupper(substr($inscription->eleve->prenom ?? '', 0, 1)) }}{{ strtoupper(substr($inscription->eleve->nom ?? '', 0, 1)) }}
                                            </div>
                                            <div class="min-w-0">
                                                <div class="text-[10px] sm:text-xs md:text-sm font-bold text-gray-900 truncate max-w-[80px] sm:max-w-none">
                                                    {{ $inscription->eleve->nom ?? '' }} {{ $inscription->eleve->prenom ?? '' }}
                                                </div>
                                                <div class="text-[8px] sm:text-[9px] md:text-xs text-gray-500">ID: #{{ $inscription->eleve->id ?? 'N/A' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-3 sm:px-4 md:px-6 py-2 md:py-3 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-5 h-5 sm:w-6 sm:h-6 bg-purple-100 rounded-lg flex items-center justify-center mr-1 flex-shrink-0">
                                                <svg class="w-2.5 h-2.5 sm:w-3 sm:h-3 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                                </svg>
                                            </div>
                                            <span class="text-[10px] sm:text-xs md:text-sm font-medium text-gray-700 truncate max-w-[60px] sm:max-w-none">{{ $inscription->classe->nom ?? 'N/A' }}</span>
                                        </div>
                                    </td>
                                    <td class="hidden sm:table-cell px-3 sm:px-4 md:px-6 py-2 md:py-3 whitespace-nowrap">
                                        <div class="flex items-center text-[10px] sm:text-xs text-gray-500">
                                            <svg class="w-2.5 h-2.5 sm:w-3 sm:h-3 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            {{ $inscription->date_inscription->format('d/m/Y') }}
                                        </div>
                                    </td>
                                    <td class="px-3 sm:px-4 md:px-6 py-2 md:py-3 whitespace-nowrap">
                                        @if($inscription->statut)
                                            <span class="px-1.5 py-0.5 md:px-2 md:py-1 inline-flex items-center text-[8px] sm:text-[10px] md:text-xs font-bold rounded-full bg-gradient-to-r from-green-400 to-emerald-500 text-white shadow-sm">
                                                <span class="w-1 h-1 bg-white rounded-full mr-1 animate-pulse"></span>
                                                Actif
                                            </span>
                                        @else
                                            <span class="px-1.5 py-0.5 md:px-2 md:py-1 inline-flex items-center text-[8px] sm:text-[10px] md:text-xs font-bold rounded-full bg-gradient-to-r from-red-400 to-red-500 text-white shadow-sm">
                                                <span class="w-1 h-1 bg-white rounded-full mr-1"></span>
                                                Inactif
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-3 sm:px-4 md:px-6 py-2 md:py-3 whitespace-nowrap">
                                        <div class="flex items-center space-x-1">
                                            <a href="#" class="p-1 md:p-1.5 bg-blue-100 text-blue-600 rounded-lg hover:bg-blue-200 transition-colors">
                                                <svg class="w-2.5 h-2.5 sm:w-3 sm:h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-3 sm:px-4 md:px-6 py-6 md:py-8 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="w-12 h-12 sm:w-14 sm:h-14 md:w-16 md:h-16 bg-gray-100 rounded-2xl flex items-center justify-center mb-2 md:mb-3">
                                                <svg class="w-6 h-6 sm:w-7 sm:h-7 md:w-8 md:h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                                </svg>
                                            </div>
                                            <h4 class="text-xs sm:text-sm md:text-base font-bold text-gray-700 mb-1">Aucune inscription récente</h4>
                                            <p class="text-[10px] sm:text-xs text-gray-500 mb-2 md:mb-3">Les nouvelles inscriptions apparaîtront ici</p>
                                            <a href="{{ route('admin.inscriptions.create') }}" class="px-2 py-1 sm:px-3 sm:py-1.5 md:px-4 md:py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white text-[9px] sm:text-[10px] md:text-xs font-bold rounded-lg hover:shadow-lg transition-all">
                                                <svg class="w-2.5 h-2.5 sm:w-3 sm:h-3 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                </svg>
                                                Nouvelle inscription
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Styles pour éviter le débordement horizontal */
        * {
            max-width: 100%;
            box-sizing: border-box;
        }

        body, html {
            overflow-x: hidden;
            width: 100%;
            position: relative;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }

        .animate-pulse-slow {
            animation: pulse 2s ease-in-out infinite;
        }

        .progress-bar {
            transition: width 1s ease-out;
            width: 0%;
        }

        .group:hover .progress-bar {
            animation: shine 1s ease-out;
        }

        @keyframes shine {
            0% {
                background-position: -100px;
            }
            100% {
                background-position: 200px;
            }
        }

        /* Empêcher le débordement horizontal */
        .overflow-x-hidden {
            overflow-x: hidden !important;
        }
    </style>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Animation des barres de progression
                const progressBars = document.querySelectorAll('.progress-bar');
                progressBars.forEach(bar => {
                    const width = bar.style.width;
                    bar.style.width = '0%';
                    setTimeout(() => {
                        bar.style.width = width;
                    }, 200);
                });

                // Configuration globale des graphiques
                Chart.defaults.font.family = "'Inter', 'system-ui', 'sans-serif'";
                Chart.defaults.color = '#6B7280';
                Chart.defaults.borderColor = '#E5E7EB';

                // Inscriptions par mois
                const inscriptionsCtx = document.getElementById('inscriptionsChart').getContext('2d');
                const inscriptionsData = @json($inscriptionsByMonth);

                const gradientBlue = inscriptionsCtx.createLinearGradient(0, 0, 0, 400);
                gradientBlue.addColorStop(0, 'rgba(59, 130, 246, 0.4)');
                gradientBlue.addColorStop(0.5, 'rgba(59, 130, 246, 0.2)');
                gradientBlue.addColorStop(1, 'rgba(59, 130, 246, 0.0)');

                new Chart(inscriptionsCtx, {
                    type: 'line',
                    data: {
                        labels: inscriptionsData.labels,
                        datasets: [{
                            label: 'Inscriptions',
                            data: inscriptionsData.data,
                            borderColor: 'rgb(59, 130, 246)',
                            backgroundColor: gradientBlue,
                            borderWidth: 3,
                            tension: 0.4,
                            fill: true,
                            pointBackgroundColor: 'rgb(59, 130, 246)',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 3,
                            pointRadius: window.innerWidth < 640 ? 4 : 6,
                            pointHoverRadius: 8,
                            pointHoverBackgroundColor: 'rgb(37, 99, 235)',
                            pointHoverBorderColor: '#fff',
                            pointHoverBorderWidth: 3
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                padding: 12,
                                titleColor: '#fff',
                                bodyColor: '#fff',
                                borderColor: 'rgb(59, 130, 246)',
                                borderWidth: 2,
                                displayColors: false,
                                callbacks: {
                                    label: function(context) {
                                        return 'Inscriptions: ' + context.parsed.y;
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: { stepSize: 1, font: { size: window.innerWidth < 640 ? 10 : 12, weight: '500' } },
                                grid: { color: 'rgba(229, 231, 235, 0.5)', drawBorder: false }
                            },
                            x: {
                                ticks: { font: { size: window.innerWidth < 640 ? 10 : 12, weight: '500' } },
                                grid: { display: false, drawBorder: false }
                            }
                        },
                        interaction: {
                            intersect: false,
                            mode: 'index'
                        },
                        animation: {
                            duration: 2000,
                            easing: 'easeInOutQuart'
                        }
                    }
                });

                // Répartition des élèves par classe
                const studentsByClassCtx = document.getElementById('studentsByClassChart').getContext('2d');
                const studentsByClassData = @json($studentsByClass);

                new Chart(studentsByClassCtx, {
                    type: 'doughnut',
                    data: {
                        labels: studentsByClassData.labels,
                        datasets: [{
                            data: studentsByClassData.data,
                            backgroundColor: [
                                'rgba(59, 130, 246, 0.8)',
                                'rgba(34, 197, 94, 0.8)',
                                'rgba(168, 85, 247, 0.8)',
                                'rgba(251, 191, 36, 0.8)',
                                'rgba(249, 115, 22, 0.8)',
                                'rgba(236, 72, 153, 0.8)',
                                'rgba(20, 184, 166, 0.8)',
                                'rgba(99, 102, 241, 0.8)'
                            ],
                            borderWidth: 4,
                            borderColor: '#fff',
                            hoverOffset: 15,
                            hoverBorderWidth: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: window.innerWidth < 640 ? 'bottom' : 'right',
                                labels: {
                                    padding: window.innerWidth < 640 ? 8 : 15,
                                    font: { size: window.innerWidth < 640 ? 10 : 12, weight: '600' },
                                    usePointStyle: true,
                                    pointStyle: 'circle'
                                }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                padding: 12,
                                titleColor: '#fff',
                                bodyColor: '#fff',
                                borderWidth: 2,
                                displayColors: true,
                                callbacks: {
                                    label: function(context) {
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const percentage = ((context.parsed / total) * 100).toFixed(1);
                                        return context.label + ': ' + context.parsed + ' élèves (' + percentage + '%)';
                                    }
                                }
                            }
                        },
                        cutout: window.innerWidth < 640 ? '60%' : '65%',
                        animation: {
                            animateRotate: true,
                            animateScale: true,
                            duration: 2000,
                            easing: 'easeInOutQuart'
                        }
                    }
                });

                // Moyennes par trimestre
                const gradesCtx = document.getElementById('gradesByTrimesterChart').getContext('2d');
                const gradesData = @json($gradesByTrimester);

                const gradientGreen = gradesCtx.createLinearGradient(0, 0, 0, 400);
                gradientGreen.addColorStop(0, 'rgba(34, 197, 94, 0.8)');
                gradientGreen.addColorStop(1, 'rgba(34, 197, 94, 0.2)');

                new Chart(gradesCtx, {
                    type: 'bar',
                    data: {
                        labels: gradesData.labels,
                        datasets: [{
                            label: 'Moyenne générale',
                            data: gradesData.data,
                            backgroundColor: gradientGreen,
                            borderColor: 'rgb(34, 197, 94)',
                            borderWidth: 2,
                            borderRadius: 8,
                            borderSkipped: false,
                            barThickness: window.innerWidth < 640 ? 40 : 50,
                            hoverBackgroundColor: 'rgba(34, 197, 94, 1)',
                            hoverBorderColor: 'rgb(21, 128, 61)',
                            hoverBorderWidth: 3
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                padding: 12,
                                titleColor: '#fff',
                                bodyColor: '#fff',
                                borderColor: 'rgb(34, 197, 94)',
                                borderWidth: 2,
                                displayColors: false,
                                callbacks: {
                                    label: function(context) {
                                        return 'Moyenne: ' + context.parsed.y.toFixed(2) + '/20';
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                max: 20,
                                ticks: {
                                    font: { size: window.innerWidth < 640 ? 10 : 12, weight: '500' },
                                    callback: function(value) {
                                        return value + '/20';
                                    }
                                },
                                grid: { color: 'rgba(229, 231, 235, 0.5)', drawBorder: false }
                            },
                            x: {
                                ticks: { font: { size: window.innerWidth < 640 ? 10 : 12, weight: '600' } },
                                grid: { display: false, drawBorder: false }
                            }
                        },
                        animation: {
                            duration: 2000,
                            easing: 'easeInOutQuart'
                        }
                    }
                });

                // Absences par mois
                const absencesCtx = document.getElementById('absencesChart').getContext('2d');
                const absencesData = @json($absencesByMonth);

                const gradientRed = absencesCtx.createLinearGradient(0, 0, 0, 400);
                gradientRed.addColorStop(0, 'rgba(239, 68, 68, 0.4)');
                gradientRed.addColorStop(0.5, 'rgba(239, 68, 68, 0.2)');
                gradientRed.addColorStop(1, 'rgba(239, 68, 68, 0.0)');

                new Chart(absencesCtx, {
                    type: 'line',
                    data: {
                        labels: absencesData.labels,
                        datasets: [{
                            label: 'Absences',
                            data: absencesData.data,
                            borderColor: 'rgb(239, 68, 68)',
                            backgroundColor: gradientRed,
                            borderWidth: 3,
                            tension: 0.4,
                            fill: true,
                            pointBackgroundColor: 'rgb(239, 68, 68)',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 3,
                            pointRadius: window.innerWidth < 640 ? 4 : 6,
                            pointHoverRadius: 8,
                            pointHoverBackgroundColor: 'rgb(220, 38, 38)',
                            pointHoverBorderColor: '#fff',
                            pointHoverBorderWidth: 3
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                padding: 12,
                                titleColor: '#fff',
                                bodyColor: '#fff',
                                borderColor: 'rgb(239, 68, 68)',
                                borderWidth: 2,
                                displayColors: false,
                                callbacks: {
                                    label: function(context) {
                                        return 'Absences: ' + context.parsed.y;
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: { stepSize: 1, font: { size: window.innerWidth < 640 ? 10 : 12, weight: '500' } },
                                grid: { color: 'rgba(229, 231, 235, 0.5)', drawBorder: false }
                            },
                            x: {
                                ticks: { font: { size: window.innerWidth < 640 ? 10 : 12, weight: '500' } },
                                grid: { display: false, drawBorder: false }
                            }
                        },
                        interaction: {
                            intersect: false,
                            mode: 'index'
                        },
                        animation: {
                            duration: 2000,
                            easing: 'easeInOutQuart'
                        }
                    }
                });
            });
        </script>
    @endpush
@endsection