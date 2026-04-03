{{-- resources/views/dashboard.blade.php --}}
@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl sm:text-sm md:text-sm text-gray-800 leading-tight">
        {{ __('Tableau de bord') }}
    </h2>
@endsection

@section('content')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

        * {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
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

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-8px);
            }
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        @keyframes shimmer {
            0% {
                background-position: -1000px 0;
            }

            100% {
                background-position: 1000px 0;
            }
        }

        .animate-in {
            animation: fadeInUp 0.5s ease-out forwards;
            opacity: 0;
        }

        .animate-slide {
            animation: slideIn 0.4s ease-out forwards;
            opacity: 0;
        }

        .delay-100 {
            animation-delay: 0.1s;
        }

        .delay-200 {
            animation-delay: 0.2s;
        }

        .delay-300 {
            animation-delay: 0.3s;
        }

        .delay-400 {
            animation-delay: 0.4s;
        }

        .delay-500 {
            animation-delay: 0.5s;
        }

        .delay-600 {
            animation-delay: 0.6s;
        }

        .delay-700 {
            animation-delay: 0.7s;
        }

        .delay-800 {
            animation-delay: 0.8s;
        }

        .stat-card {
            position: relative;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .stat-card:hover::before {
            left: 100%;
        }

        .action-btn {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 20px -5px rgba(0, 0, 0, 0.2);
        }

        .icon-float {
            animation: float 4s ease-in-out infinite;
        }

        .table-row {
            transition: all 0.2s ease;
        }

        .table-row:hover {
            background: linear-gradient(90deg, rgba(99, 102, 241, 0.03), transparent);
            transform: translateX(2px);
        }

        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .progress-bar {
            transition: width 1s ease-out;
        }

        .shimmer {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 1000px 100%;
            animation: shimmer 2s infinite;
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .hover-scale {
            transition: transform 0.3s ease;
        }

        .hover-scale:hover {
            transform: scale(1.02);
        }

        .pulse-animation {
            animation: pulse 2s infinite;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
            transition: all 0.2s;
        }

        .badge-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
        }

        .badge-warning {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
        }

        .badge-danger {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
        }

        .badge-info {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
        }

        /* Styles pour éviter le débordement horizontal */
        * {
            max-width: 100%;
            box-sizing: border-box;
        }

        body,
        html {
            overflow-x: hidden;
            width: 100%;
            position: relative;
        }

        .overflow-x-hidden {
            overflow-x: hidden !important;
        }
    </style>

    {{-- Adjusted padding for responsiveness inside the layout --}}
    <div
        class="py-4 overflow-x-hidden px-2 sm:px-4 md:py-8 md:px-4 lg:px-6 bg-gradient-to-br from-gray-50 via-indigo-50/30 to-purple-50/30 sm:py-12">
        <div class="max-w-7xl mx-auto">
            <!-- Hero Section -->
            <div class="relative rounded-xl sm:rounded-2xl md:rounded-3xl overflow-hidden mb-4 md:mb-6 lg:mb-10 animate-in shadow-2xl group"
                style="min-height: auto;">
                <!-- Fond -->
                <div
                    class="absolute inset-0 bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-600 animate-gradient bg-[length:200%_200%]">
                </div>

                <!-- Motif -->
                <div class="absolute inset-0 opacity-10"
                    style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');">
                </div>

                <!-- Cercles -->
                <div
                    class="absolute top-0 right-0 w-32 h-32 sm:w-48 sm:h-48 md:w-64 md:h-64 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2 blur-3xl">
                </div>
                <div
                    class="absolute bottom-0 left-0 w-24 h-24 sm:w-36 sm:h-36 md:w-48 md:h-48 bg-white/10 rounded-full translate-y-1/2 -translate-x-1/2 blur-3xl">
                </div>

                <div class="relative p-3 sm:p-4 md:p-6 lg:p-8 xl:p-10">
                    <div
                        class="flex flex-col md:flex-row items-start md:items-center justify-between gap-3 md:gap-4 lg:gap-6">
                        <div class="flex-1 w-full">
                            <div
                                class="inline-flex items-center px-2 py-1 sm:px-3 sm:py-1.5 md:px-4 md:py-2 rounded-full bg-white/20 backdrop-blur-sm border border-white/30 text-white text-[9px] sm:text-xs md:text-sm font-semibold mb-2 md:mb-3 tracking-wider">
                                <i class="fas fa-crown mr-1 text-[8px] sm:text-xs"></i>
                                ADMINISTRATEUR
                            </div>
                            <h1
                                class="text-xl sm:text-2xl md:text-3xl lg:text-4xl xl:text-5xl font-bold text-white mb-1 md:mb-2 tracking-tight">
                                Tableau de bord
                            </h1>
                            <p
                                class="text-xs sm:text-sm md:text-base lg:text-lg text-white/90 font-light max-w-2xl leading-relaxed">
                                Gérez efficacement votre établissement scolaire avec une vue d'ensemble complète
                            </p>

                            <!-- Stats rapides -->
                            <div class="flex flex-wrap gap-1.5 sm:gap-2 md:gap-3 lg:gap-4 mt-2 md:mt-3 lg:mt-4">
                                <div
                                    class="flex items-center gap-1 sm:gap-1.5 md:gap-2 bg-white/10 backdrop-blur-sm rounded-lg px-2 py-0.5 sm:px-2.5 sm:py-1 md:px-3 md:py-1.5">
                                    <i class="fas fa-users text-white/70 text-[8px] sm:text-xs md:text-sm"></i>
                                    <span
                                        class="text-white/90 text-[8px] sm:text-xs md:text-sm">{{ \App\Models\User::count() }}
                                        utilisateurs</span>
                                </div>
                                <div
                                    class="flex items-center gap-1 sm:gap-1.5 md:gap-2 bg-white/10 backdrop-blur-sm rounded-lg px-2 py-0.5 sm:px-2.5 sm:py-1 md:px-3 md:py-1.5">
                                    <i class="fas fa-calendar text-white/70 text-[8px] sm:text-xs md:text-sm"></i>
                                    <span class="text-white/90 text-[8px] sm:text-xs md:text-sm">{{ date('Y') }}</span>
                                </div>
                                <div
                                    class="hidden sm:flex items-center gap-1.5 md:gap-2 bg-white/10 backdrop-blur-sm rounded-lg px-2.5 py-0.5 sm:px-3 sm:py-1 md:px-3 md:py-1.5">
                                    <i class="fas fa-clock text-white/70 text-[10px] sm:text-xs md:text-sm"></i>
                                    <span
                                        class="text-white/90 text-[10px] sm:text-xs md:text-sm">{{ now()->format('d/m/Y H:i') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Icône -->
                        <div class="hidden lg:block">
                            <div class="relative icon-float">
                                <div
                                    class="glass-effect rounded-2xl sm:rounded-3xl p-3 sm:p-4 md:p-5 lg:p-6 group-hover:scale-110 transition-transform duration-500">
                                    <i class="fas fa-chart-pie text-3xl sm:text-4xl md:text-5xl text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-2 sm:gap-3 md:gap-4 lg:gap-6 mb-4 md:mb-6 lg:mb-10">
                <!-- Total Élèves -->
                <div
                    class="stat-card bg-gradient-to-br from-blue-600 to-blue-700 rounded-lg sm:rounded-xl md:rounded-2xl shadow-lg animate-in delay-100">
                    <div class="p-2 sm:p-3 md:p-4 lg:p-5 xl:p-6">
                        <div class="flex items-start justify-between mb-2 md:mb-3">
                            <div class="flex-1 min-w-0">
                                <p
                                    class="text-[8px] sm:text-[9px] md:text-xs font-semibold text-blue-100 uppercase tracking-wider mb-0.5 md:mb-1">
                                    Total Élèves</p>
                                <p class="text-base sm:text-lg md:text-2xl lg:text-3xl font-bold text-white truncate">
                                    {{ \App\Models\Eleve::count() }}</p>
                                <p class="text-[7px] sm:text-[8px] md:text-xs text-blue-200 mt-0.5 flex items-center">
                                    <i class="fas fa-arrow-up mr-0.5 text-[6px] sm:text-[8px]"></i>
                                    <span>+12%</span>
                                </p>
                            </div>
                            <div
                                class="bg-white/20 rounded-lg p-1.5 sm:p-2 md:p-2.5 lg:p-3 backdrop-blur-sm flex-shrink-0 ml-1">
                                <i class="fas fa-users text-xs sm:text-sm md:text-base lg:text-xl text-white"></i>
                            </div>
                        </div>
                        <div class="flex items-center gap-1">
                            <div class="h-0.5 sm:h-1 flex-1 bg-white/20 rounded-full overflow-hidden">
                                <div class="progress-bar h-full bg-white rounded-full" style="width: 75%"></div>
                            </div>
                            <span class="text-[7px] sm:text-[8px] md:text-xs font-semibold text-white">75%</span>
                        </div>
                    </div>
                </div>

                <!-- Enseignants -->
                <div
                    class="stat-card bg-gradient-to-br from-emerald-600 to-emerald-700 rounded-lg sm:rounded-xl md:rounded-2xl shadow-lg animate-in delay-200">
                    <div class="p-2 sm:p-3 md:p-4 lg:p-5 xl:p-6">
                        <div class="flex items-start justify-between mb-2 md:mb-3">
                            <div class="flex-1 min-w-0">
                                <p
                                    class="text-[8px] sm:text-[9px] md:text-xs font-semibold text-emerald-100 uppercase tracking-wider mb-0.5 md:mb-1">
                                    Enseignants</p>
                                <p class="text-base sm:text-lg md:text-2xl lg:text-3xl font-bold text-white truncate">
                                    {{ \App\Models\Enseignant::count() }}</p>
                                <p class="text-[7px] sm:text-[8px] md:text-xs text-emerald-200 mt-0.5 flex items-center">
                                    <i class="fas fa-arrow-up mr-0.5 text-[6px] sm:text-[8px]"></i>
                                    <span>+8%</span>
                                </p>
                            </div>
                            <div
                                class="bg-white/20 rounded-lg p-1.5 sm:p-2 md:p-2.5 lg:p-3 backdrop-blur-sm flex-shrink-0 ml-1">
                                <i
                                    class="fas fa-chalkboard-teacher text-xs sm:text-sm md:text-base lg:text-xl text-white"></i>
                            </div>
                        </div>
                        <div class="flex items-center gap-1">
                            <div class="h-0.5 sm:h-1 flex-1 bg-white/20 rounded-full overflow-hidden">
                                <div class="progress-bar h-full bg-white rounded-full" style="width: 60%"></div>
                            </div>
                            <span class="text-[7px] sm:text-[8px] md:text-xs font-semibold text-white">60%</span>
                        </div>
                    </div>
                </div>

                <!-- Classes -->
                <div
                    class="stat-card bg-gradient-to-br from-purple-600 to-purple-700 rounded-lg sm:rounded-xl md:rounded-2xl shadow-lg animate-in delay-300">
                    <div class="p-2 sm:p-3 md:p-4 lg:p-5 xl:p-6">
                        <div class="flex items-start justify-between mb-2 md:mb-3">
                            <div class="flex-1 min-w-0">
                                <p
                                    class="text-[8px] sm:text-[9px] md:text-xs font-semibold text-purple-100 uppercase tracking-wider mb-0.5 md:mb-1">
                                    Classes</p>
                                <p class="text-base sm:text-lg md:text-2xl lg:text-3xl font-bold text-white truncate">
                                    {{ \App\Models\Classe::count() }}</p>
                                <p class="text-[7px] sm:text-[8px] md:text-xs text-purple-200 mt-0.5 flex items-center">
                                    <i class="fas fa-arrow-up mr-0.5 text-[6px] sm:text-[8px]"></i>
                                    <span>+5%</span>
                                </p>
                            </div>
                            <div
                                class="bg-white/20 rounded-lg p-1.5 sm:p-2 md:p-2.5 lg:p-3 backdrop-blur-sm flex-shrink-0 ml-1">
                                <i class="fas fa-school text-xs sm:text-sm md:text-base lg:text-xl text-white"></i>
                            </div>
                        </div>
                        <div class="flex items-center gap-1">
                            <div class="h-0.5 sm:h-1 flex-1 bg-white/20 rounded-full overflow-hidden">
                                <div class="progress-bar h-full bg-white rounded-full" style="width: 85%"></div>
                            </div>
                            <span class="text-[7px] sm:text-[8px] md:text-xs font-semibold text-white">85%</span>
                        </div>
                    </div>
                </div>

                <!-- Matières -->
                <div
                    class="stat-card bg-gradient-to-br from-amber-600 to-amber-700 rounded-lg sm:rounded-xl md:rounded-2xl shadow-lg animate-in delay-400">
                    <div class="p-2 sm:p-3 md:p-4 lg:p-5 xl:p-6">
                        <div class="flex items-start justify-between mb-2 md:mb-3">
                            <div class="flex-1 min-w-0">
                                <p
                                    class="text-[8px] sm:text-[9px] md:text-xs font-semibold text-amber-100 uppercase tracking-wider mb-0.5 md:mb-1">
                                    Matières</p>
                                <p class="text-base sm:text-lg md:text-2xl lg:text-3xl font-bold text-white truncate">
                                    {{ \App\Models\Matiere::count() }}</p>
                                <p class="text-[7px] sm:text-[8px] md:text-xs text-amber-200 mt-0.5 flex items-center">
                                    <i class="fas fa-arrow-up mr-0.5 text-[6px] sm:text-[8px]"></i>
                                    <span>+3%</span>
                                </p>
                            </div>
                            <div
                                class="bg-white/20 rounded-lg p-1.5 sm:p-2 md:p-2.5 lg:p-3 backdrop-blur-sm flex-shrink-0 ml-1">
                                <i class="fas fa-book-open text-xs sm:text-sm md:text-base lg:text-xl text-white"></i>
                            </div>
                        </div>
                        <div class="flex items-center gap-1">
                            <div class="h-0.5 sm:h-1 flex-1 bg-white/20 rounded-full overflow-hidden">
                                <div class="progress-bar h-full bg-white rounded-full" style="width: 90%"></div>
                            </div>
                            <span class="text-[7px] sm:text-[8px] md:text-xs font-semibold text-white">90%</span>
                        </div>
                    </div>
                </div>

                <!-- Inscriptions -->
                <div
                    class="stat-card bg-gradient-to-br from-rose-600 to-rose-700 rounded-lg sm:rounded-xl md:rounded-2xl shadow-lg animate-in delay-500">
                    <div class="p-2 sm:p-3 md:p-4 lg:p-5 xl:p-6">
                        <div class="flex items-start justify-between mb-2 md:mb-3">
                            <div class="flex-1 min-w-0">
                                <p
                                    class="text-[8px] sm:text-[9px] md:text-xs font-semibold text-rose-100 uppercase tracking-wider mb-0.5 md:mb-1">
                                    Inscriptions</p>
                                <p class="text-base sm:text-lg md:text-2xl lg:text-3xl font-bold text-white truncate">
                                    {{ \App\Models\Inscription::count() }}</p>
                                <p class="text-[7px] sm:text-[8px] md:text-xs text-rose-200 mt-0.5 flex items-center">
                                    <i class="fas fa-arrow-up mr-0.5 text-[6px] sm:text-[8px]"></i>
                                    <span>+15%</span>
                                </p>
                            </div>
                            <div
                                class="bg-white/20 rounded-lg p-1.5 sm:p-2 md:p-2.5 lg:p-3 backdrop-blur-sm flex-shrink-0 ml-1">
                                <i class="fas fa-user-plus text-xs sm:text-sm md:text-base lg:text-xl text-white"></i>
                            </div>
                        </div>
                        <div class="flex items-center gap-1">
                            <div class="h-0.5 sm:h-1 flex-1 bg-white/20 rounded-full overflow-hidden">
                                <div class="progress-bar h-full bg-white rounded-full" style="width: 70%"></div>
                            </div>
                            <span class="text-[7px] sm:text-[8px] md:text-xs font-semibold text-white">70%</span>
                        </div>
                    </div>
                </div>

                <!-- Parents -->
                <div
                    class="stat-card bg-gradient-to-br from-cyan-600 to-cyan-700 rounded-lg sm:rounded-xl md:rounded-2xl shadow-lg animate-in delay-600">
                    <div class="p-2 sm:p-3 md:p-4 lg:p-5 xl:p-6">
                        <div class="flex items-start justify-between mb-2 md:mb-3">
                            <div class="flex-1 min-w-0">
                                <p
                                    class="text-[8px] sm:text-[9px] md:text-xs font-semibold text-cyan-100 uppercase tracking-wider mb-0.5 md:mb-1">
                                    Parents</p>
                                <p class="text-base sm:text-lg md:text-2xl lg:text-3xl font-bold text-white truncate">
                                    {{ \App\Models\ParentEleve::count() }}</p>
                                <p class="text-[7px] sm:text-[8px] md:text-xs text-cyan-200 mt-0.5 flex items-center">
                                    <i class="fas fa-arrow-up mr-0.5 text-[6px] sm:text-[8px]"></i>
                                    <span>+10%</span>
                                </p>
                            </div>
                            <div
                                class="bg-white/20 rounded-lg p-1.5 sm:p-2 md:p-2.5 lg:p-3 backdrop-blur-sm flex-shrink-0 ml-1">
                                <i class="fas fa-user-friends text-xs sm:text-sm md:text-base lg:text-xl text-white"></i>
                            </div>
                        </div>
                        <div class="flex items-center gap-1">
                            <div class="h-0.5 sm:h-1 flex-1 bg-white/20 rounded-full overflow-hidden">
                                <div class="progress-bar h-full bg-white rounded-full" style="width: 65%"></div>
                            </div>
                            <span class="text-[7px] sm:text-[8px] md:text-xs font-semibold text-white">65%</span>
                        </div>
                    </div>
                </div>

                <!-- Réinscriptions -->
                <div
                    class="stat-card bg-gradient-to-br from-teal-600 to-teal-700 rounded-lg sm:rounded-xl md:rounded-2xl shadow-lg animate-in delay-700">
                    <div class="p-2 sm:p-3 md:p-4 lg:p-5 xl:p-6">
                        <div class="flex items-start justify-between mb-2 md:mb-3">
                            <div class="flex-1 min-w-0">
                                <p
                                    class="text-[8px] sm:text-[9px] md:text-xs font-semibold text-teal-100 uppercase tracking-wider mb-0.5 md:mb-1">
                                    Réinscriptions</p>
                                <p class="text-base sm:text-lg md:text-2xl lg:text-3xl font-bold text-white truncate">
                                    {{ \App\Models\Reinscription::count() }}</p>
                                <p class="text-[7px] sm:text-[8px] md:text-xs text-teal-200 mt-0.5 flex items-center">
                                    <i class="fas fa-arrow-up mr-0.5 text-[6px] sm:text-[8px]"></i>
                                    <span>+7%</span>
                                </p>
                            </div>
                            <div
                                class="bg-white/20 rounded-lg p-1.5 sm:p-2 md:p-2.5 lg:p-3 backdrop-blur-sm flex-shrink-0 ml-1">
                                <i class="fas fa-redo-alt text-xs sm:text-sm md:text-base lg:text-xl text-white"></i>
                            </div>
                        </div>
                        <div class="flex items-center gap-1">
                            <div class="h-0.5 sm:h-1 flex-1 bg-white/20 rounded-full overflow-hidden">
                                <div class="progress-bar h-full bg-white rounded-full" style="width: 55%"></div>
                            </div>
                            <span class="text-[7px] sm:text-[8px] md:text-xs font-semibold text-white">55%</span>
                        </div>
                    </div>
                </div>

                <!-- Année Scolaire -->
                <div
                    class="stat-card bg-gradient-to-br from-indigo-600 to-indigo-700 rounded-lg sm:rounded-xl md:rounded-2xl shadow-lg animate-in delay-800">
                    <div class="p-2 sm:p-3 md:p-4 lg:p-5 xl:p-6">
                        @php
                            $anneeActive = \App\Models\AnneeScolaire::where('statut', true)->first();
                        @endphp
                        <div class="flex items-start justify-between mb-2 md:mb-3">
                            <div class="flex-1 min-w-0">
                                <p
                                    class="text-[8px] sm:text-[9px] md:text-xs font-semibold text-indigo-100 uppercase tracking-wider mb-0.5 md:mb-1">
                                    Année Scolaire</p>
                                <p class="text-xs sm:text-sm md:text-base lg:text-xl font-bold text-white truncate">
                                    {{ $anneeActive ? $anneeActive->annee : 'N/A' }}</p>
                                <p class="text-[7px] sm:text-[8px] md:text-xs text-indigo-200 mt-0.5 flex items-center">
                                    <i class="fas fa-circle text-green-300 mr-0.5 text-[5px] sm:text-[6px]"></i>
                                    <span>Active</span>
                                </p>
                            </div>
                            <div
                                class="bg-white/20 rounded-lg p-1.5 sm:p-2 md:p-2.5 lg:p-3 backdrop-blur-sm flex-shrink-0 ml-1">
                                <i class="fas fa-calendar-alt text-xs sm:text-sm md:text-base lg:text-xl text-white"></i>
                            </div>
                        </div>
                        <div class="flex items-center gap-1">
                            <div class="h-0.5 sm:h-1 flex-1 bg-white/20 rounded-full overflow-hidden">
                                <div class="progress-bar h-full bg-white rounded-full" style="width: 100%"></div>
                            </div>
                            <span class="text-[7px] sm:text-[8px] md:text-xs font-semibold text-white">100%</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div
                class="bg-white/80 backdrop-blur-sm rounded-xl sm:rounded-2xl md:rounded-3xl shadow-xl mb-4 md:mb-6 lg:mb-10 overflow-hidden animate-in delay-500 border border-white/50">
                <div
                    class="bg-gradient-to-r from-indigo-600 to-purple-600 px-3 sm:px-4 md:px-5 lg:px-6 py-2.5 sm:py-3 md:py-4 lg:py-5">
                    <div class="flex items-center gap-1.5 sm:gap-2 md:gap-3">
                        <div class="bg-white/20 rounded-lg p-1.5 sm:p-2 md:p-2.5">
                            <i class="fas fa-bolt text-white text-xs sm:text-sm md:text-base lg:text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-sm sm:text-base md:text-lg font-bold text-white">Actions rapides</h3>
                            <p class="text-indigo-100 text-[10px] sm:text-xs hidden sm:block">Accédez rapidement aux
                                fonctionnalités principales</p>
                        </div>
                    </div>
                </div>
                <div class="p-2 sm:p-3 md:p-4 lg:p-6">
                    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-2 sm:gap-3 md:gap-4">

                        <!-- Classes -->
                        <a href="{{ route('admin.classes.index') }}"
                            class="group relative bg-gradient-to-br from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-lg sm:rounded-xl md:rounded-2xl p-2 sm:p-3 md:p-4 transition-all duration-300 hover:scale-105 hover:shadow-2xl">
                            <div
                                class="absolute top-1 right-1 sm:top-2 sm:right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <i class="fas fa-arrow-right text-[8px] sm:text-xs"></i>
                            </div>
                            <div class="flex items-center gap-1.5 sm:gap-2 md:gap-3">
                                <div class="bg-white/20 rounded-lg p-1.5 sm:p-2">
                                    <i class="fas fa-school text-xs sm:text-sm md:text-base"></i>
                                </div>
                                <div>
                                    <span class="font-bold text-xs sm:text-sm md:text-base">Classes</span>
                                    <p class="text-blue-100 text-[8px] sm:text-[9px] md:text-xs mt-0.5">
                                        {{ \App\Models\Classe::count() }} classes</p>
                                </div>
                            </div>
                        </a>

                        <!-- Matières -->
                        <a href="{{ route('admin.matieres.index') }}"
                            class="group relative bg-gradient-to-br from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white rounded-lg sm:rounded-xl md:rounded-2xl p-2 sm:p-3 md:p-4 transition-all duration-300 hover:scale-105 hover:shadow-2xl">
                            <div
                                class="absolute top-1 right-1 sm:top-2 sm:right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <i class="fas fa-arrow-right text-[8px] sm:text-xs"></i>
                            </div>
                            <div class="flex items-center gap-1.5 sm:gap-2 md:gap-3">
                                <div class="bg-white/20 rounded-lg p-1.5 sm:p-2">
                                    <i class="fas fa-book-open text-xs sm:text-sm md:text-base"></i>
                                </div>
                                <div>
                                    <span class="font-bold text-xs sm:text-sm md:text-base">Matières</span>
                                    <p class="text-emerald-100 text-[8px] sm:text-[9px] md:text-xs mt-0.5">
                                        {{ \App\Models\Matiere::count() }} matières</p>
                                </div>
                            </div>
                        </a>

                        <!-- Inscriptions -->
                        <a href="{{ route('admin.inscriptions.index') }}"
                            class="group relative bg-gradient-to-br from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white rounded-lg sm:rounded-xl md:rounded-2xl p-2 sm:p-3 md:p-4 transition-all duration-300 hover:scale-105 hover:shadow-2xl">
                            <div
                                class="absolute top-1 right-1 sm:top-2 sm:right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <i class="fas fa-arrow-right text-[8px] sm:text-xs"></i>
                            </div>
                            <div class="flex items-center gap-1.5 sm:gap-2 md:gap-3">
                                <div class="bg-white/20 rounded-lg p-1.5 sm:p-2">
                                    <i class="fas fa-user-plus text-xs sm:text-sm md:text-base"></i>
                                </div>
                                <div>
                                    <span class="font-bold text-xs sm:text-sm md:text-base">Inscriptions</span>
                                    <p class="text-purple-100 text-[8px] sm:text-[9px] md:text-xs mt-0.5">
                                        {{ \App\Models\Inscription::count() }}</p>
                                </div>
                            </div>
                        </a>

                        <!-- Élèves -->
                        <a href="{{ route('admin.eleves.index') }}"
                            class="group relative bg-gradient-to-br from-cyan-500 to-cyan-600 hover:from-cyan-600 hover:to-cyan-700 text-white rounded-lg sm:rounded-xl md:rounded-2xl p-2 sm:p-3 md:p-4 transition-all duration-300 hover:scale-105 hover:shadow-2xl">
                            <div
                                class="absolute top-1 right-1 sm:top-2 sm:right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <i class="fas fa-arrow-right text-[8px] sm:text-xs"></i>
                            </div>
                            <div class="flex items-center gap-1.5 sm:gap-2 md:gap-3">
                                <div class="bg-white/20 rounded-lg p-1.5 sm:p-2">
                                    <i class="fas fa-child text-xs sm:text-sm md:text-base"></i>
                                </div>
                                <div>
                                    <span class="font-bold text-xs sm:text-sm md:text-base">Élèves</span>
                                    <p class="text-cyan-100 text-[8px] sm:text-[9px] md:text-xs mt-0.5">
                                        {{ \App\Models\Eleve::count() }}</p>
                                </div>
                            </div>
                        </a>

                        <!-- Enseignants -->
                        <a href="{{ route('admin.enseignants.index') }}"
                            class="group relative bg-gradient-to-br from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 text-white rounded-lg sm:rounded-xl md:rounded-2xl p-2 sm:p-3 md:p-4 transition-all duration-300 hover:scale-105 hover:shadow-2xl">
                            <div
                                class="absolute top-1 right-1 sm:top-2 sm:right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <i class="fas fa-arrow-right text-[8px] sm:text-xs"></i>
                            </div>
                            <div class="flex items-center gap-1.5 sm:gap-2 md:gap-3">
                                <div class="bg-white/20 rounded-lg p-1.5 sm:p-2">
                                    <i class="fas fa-chalkboard-teacher text-xs sm:text-sm md:text-base"></i>
                                </div>
                                <div>
                                    <span class="font-bold text-xs sm:text-sm md:text-base">Enseignants</span>
                                    <p class="text-indigo-100 text-[8px] sm:text-[9px] md:text-xs mt-0.5">
                                        {{ \App\Models\Enseignant::count() }}</p>
                                </div>
                            </div>
                        </a>

                        <!-- Parents -->
                        <a href="{{ route('admin.parents.index') }}"
                            class="group relative bg-gradient-to-br from-pink-500 to-pink-600 hover:from-pink-600 hover:to-pink-700 text-white rounded-lg sm:rounded-xl md:rounded-2xl p-2 sm:p-3 md:p-4 transition-all duration-300 hover:scale-105 hover:shadow-2xl">
                            <div
                                class="absolute top-1 right-1 sm:top-2 sm:right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <i class="fas fa-arrow-right text-[8px] sm:text-xs"></i>
                            </div>
                            <div class="flex items-center gap-1.5 sm:gap-2 md:gap-3">
                                <div class="bg-white/20 rounded-lg p-1.5 sm:p-2">
                                    <i class="fas fa-user-friends text-xs sm:text-sm md:text-base"></i>
                                </div>
                                <div>
                                    <span class="font-bold text-xs sm:text-sm md:text-base">Parents</span>
                                    <p class="text-pink-100 text-[8px] sm:text-[9px] md:text-xs mt-0.5">
                                        {{ \App\Models\ParentEleve::count() }}</p>
                                </div>
                            </div>
                        </a>

                        <!-- Années scolaires -->
                        <a href="{{ route('admin.annee_scolaires.index') }}"
                            class="group relative bg-gradient-to-br from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-white rounded-lg sm:rounded-xl md:rounded-2xl p-2 sm:p-3 md:p-4 transition-all duration-300 hover:scale-105 hover:shadow-2xl">
                            <div
                                class="absolute top-1 right-1 sm:top-2 sm:right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <i class="fas fa-arrow-right text-[8px] sm:text-xs"></i>
                            </div>
                            <div class="flex items-center gap-1.5 sm:gap-2 md:gap-3">
                                <div class="bg-white/20 rounded-lg p-1.5 sm:p-2">
                                    <i class="fas fa-calendar-alt text-xs sm:text-sm md:text-base"></i>
                                </div>
                                <div>
                                    <span class="font-bold text-xs sm:text-sm md:text-base">Années</span>
                                    <p class="text-amber-100 text-[8px] sm:text-[9px] md:text-xs mt-0.5">Scolaires</p>
                                </div>
                            </div>
                        </a>

                        <!-- Bulletins -->
                        <a href="{{ route('admin.bulletins.index') }}"
                            class="group relative bg-gradient-to-br from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white rounded-lg sm:rounded-xl md:rounded-2xl p-2 sm:p-3 md:p-4 transition-all duration-300 hover:scale-105 hover:shadow-2xl">
                            <div
                                class="absolute top-1 right-1 sm:top-2 sm:right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <i class="fas fa-arrow-right text-[8px] sm:text-xs"></i>
                            </div>
                            <div class="flex items-center gap-1.5 sm:gap-2 md:gap-3">
                                <div class="bg-white/20 rounded-lg p-1.5 sm:p-2">
                                    <i class="fas fa-file-alt text-xs sm:text-sm md:text-base"></i>
                                </div>
                                <div>
                                    <span class="font-bold text-xs sm:text-sm md:text-base">Bulletins</span>
                                    <p class="text-red-100 text-[8px] sm:text-[9px] md:text-xs mt-0.5">Gérer</p>
                                </div>
                            </div>
                        </a>

                        <!-- Notes -->
                        <a href="{{ route('admin.notes.index') }}"
                            class="group relative bg-gradient-to-br from-teal-500 to-teal-600 hover:from-teal-600 hover:to-teal-700 text-white rounded-lg sm:rounded-xl md:rounded-2xl p-2 sm:p-3 md:p-4 transition-all duration-300 hover:scale-105 hover:shadow-2xl">
                            <div
                                class="absolute top-1 right-1 sm:top-2 sm:right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <i class="fas fa-arrow-right text-[8px] sm:text-xs"></i>
                            </div>
                            <div class="flex items-center gap-1.5 sm:gap-2 md:gap-3">
                                <div class="bg-white/20 rounded-lg p-1.5 sm:p-2">
                                    <i class="fas fa-pen text-xs sm:text-sm md:text-base"></i>
                                </div>
                                <div>
                                    <span class="font-bold text-xs sm:text-sm md:text-base">Notes</span>
                                    <p class="text-teal-100 text-[8px] sm:text-[9px] md:text-xs mt-0.5">Gérer</p>
                                </div>
                            </div>
                        </a>

                        <!-- Absences -->
                        <a href="{{ route('admin.absences.index') }}"
                            class="group relative bg-gradient-to-br from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white rounded-lg sm:rounded-xl md:rounded-2xl p-2 sm:p-3 md:p-4 transition-all duration-300 hover:scale-105 hover:shadow-2xl">
                            <div
                                class="absolute top-1 right-1 sm:top-2 sm:right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <i class="fas fa-arrow-right text-[8px] sm:text-xs"></i>
                            </div>
                            <div class="flex items-center gap-1.5 sm:gap-2 md:gap-3">
                                <div class="bg-white/20 rounded-lg p-1.5 sm:p-2">
                                    <i class="fas fa-calendar-times text-xs sm:text-sm md:text-base"></i>
                                </div>
                                <div>
                                    <span class="font-bold text-xs sm:text-sm md:text-base">Absences</span>
                                    <p class="text-orange-100 text-[8px] sm:text-[9px] md:text-xs mt-0.5">Gérer</p>
                                </div>
                            </div>
                        </a>

                        <!-- Emploi du temps -->
                        <a href="{{ route('admin.emploi_du_tempe.index') }}"
                            class="group relative bg-gradient-to-br from-rose-500 to-rose-600 hover:from-rose-600 hover:to-rose-700 text-white rounded-lg sm:rounded-xl md:rounded-2xl p-2 sm:p-3 md:p-4 transition-all duration-300 hover:scale-105 hover:shadow-2xl">
                            <div
                                class="absolute top-1 right-1 sm:top-2 sm:right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <i class="fas fa-arrow-right text-[8px] sm:text-xs"></i>
                            </div>
                            <div class="flex items-center gap-1.5 sm:gap-2 md:gap-3">
                                <div class="bg-white/20 rounded-lg p-1.5 sm:p-2">
                                    <i class="fas fa-clock text-xs sm:text-sm md:text-base"></i>
                                </div>
                                <div>
                                    <span class="font-bold text-xs sm:text-sm md:text-base">Emplois</span>
                                    <p class="text-rose-100 text-[8px] sm:text-[9px] md:text-xs mt-0.5">Du temps</p>
                                </div>
                            </div>
                        </a>

                        <!-- Classes-Matières -->
                        <a href="{{ route('admin.classe_matieres.index') }}"
                            class="group relative bg-gradient-to-br from-violet-500 to-violet-600 hover:from-violet-600 hover:to-violet-700 text-white rounded-lg sm:rounded-xl md:rounded-2xl p-2 sm:p-3 md:p-4 transition-all duration-300 hover:scale-105 hover:shadow-2xl">
                            <div
                                class="absolute top-1 right-1 sm:top-2 sm:right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <i class="fas fa-arrow-right text-[8px] sm:text-xs"></i>
                            </div>
                            <div class="flex items-center gap-1.5 sm:gap-2 md:gap-3">
                                <div class="bg-white/20 rounded-lg p-1.5 sm:p-2">
                                    <i class="fas fa-layer-group text-xs sm:text-sm md:text-base"></i>
                                </div>
                                <div>
                                    <span class="font-bold text-xs sm:text-sm md:text-base">Classes-Mat.</span>
                                    <p class="text-violet-100 text-[8px] sm:text-[9px] md:text-xs mt-0.5">Lier</p>
                                </div>
                            </div>
                        </a>

                        <!-- Utilisateurs -->
                        <a href="{{ route('admin.users.index') }}"
                            class="group relative bg-gradient-to-br from-slate-500 to-slate-600 hover:from-slate-600 hover:to-slate-700 text-white rounded-lg sm:rounded-xl md:rounded-2xl p-2 sm:p-3 md:p-4 transition-all duration-300 hover:scale-105 hover:shadow-2xl">
                            <div
                                class="absolute top-1 right-1 sm:top-2 sm:right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <i class="fas fa-arrow-right text-[8px] sm:text-xs"></i>
                            </div>
                            <div class="flex items-center gap-1.5 sm:gap-2 md:gap-3">
                                <div class="bg-white/20 rounded-lg p-1.5 sm:p-2">
                                    <i class="fas fa-users-cog text-xs sm:text-sm md:text-base"></i>
                                </div>
                                <div>
                                    <span class="font-bold text-xs sm:text-sm md:text-base">Utilisateurs</span>
                                    <p class="text-slate-100 text-[8px] sm:text-[9px] md:text-xs mt-0.5">
                                        {{ \App\Models\User::count() }}</p>
                                </div>
                            </div>
                        </a>

                        <!-- Élève-Parents -->
                        <a href="{{ route('admin.eleve-parents.index') }}"
                            class="group relative bg-gradient-to-br from-fuchsia-500 to-fuchsia-600 hover:from-fuchsia-600 hover:to-fuchsia-700 text-white rounded-lg sm:rounded-xl md:rounded-2xl p-2 sm:p-3 md:p-4 transition-all duration-300 hover:scale-105 hover:shadow-2xl">
                            <div
                                class="absolute top-1 right-1 sm:top-2 sm:right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <i class="fas fa-arrow-right text-[8px] sm:text-xs"></i>
                            </div>
                            <div class="flex items-center gap-1.5 sm:gap-2 md:gap-3">
                                <div class="bg-white/20 rounded-lg p-1.5 sm:p-2">
                                    <i class="fas fa-handshake text-xs sm:text-sm md:text-base"></i>
                                </div>
                                <div>
                                    <span class="font-bold text-xs sm:text-sm md:text-base">Élève-Par.</span>
                                    <p class="text-fuchsia-100 text-[8px] sm:text-[9px] md:text-xs mt-0.5">Lier</p>
                                </div>
                            </div>
                        </a>

                        <!-- Évaluations -->
                        <a href="{{ route('admin.evaluations.index') }}"
                            class="group relative bg-gradient-to-br from-lime-500 to-lime-600 hover:from-lime-600 hover:to-lime-700 text-white rounded-lg sm:rounded-xl md:rounded-2xl p-2 sm:p-3 md:p-4 transition-all duration-300 hover:scale-105 hover:shadow-2xl">
                            <div
                                class="absolute top-1 right-1 sm:top-2 sm:right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <i class="fas fa-arrow-right text-[8px] sm:text-xs"></i>
                            </div>
                            <div class="flex items-center gap-1.5 sm:gap-2 md:gap-3">
                                <div class="bg-white/20 rounded-lg p-1.5 sm:p-2">
                                    <i class="fas fa-star text-xs sm:text-sm md:text-base"></i>
                                </div>
                                <div>
                                    <span class="font-bold text-xs sm:text-sm md:text-base">Évaluations</span>
                                    <p class="text-lime-100 text-[8px] sm:text-[9px] md:text-xs mt-0.5">Gérer</p>
                                </div>
                            </div>
                        </a>

                        <!-- Enseignant-Matières -->
                        <a href="{{ route('admin.enseignant_matiere_classes.index') }}"
                            class="group relative bg-gradient-to-br from-cyan-500 to-cyan-600 hover:from-cyan-600 hover:to-cyan-700 text-white rounded-lg sm:rounded-xl md:rounded-2xl p-2 sm:p-3 md:p-4 transition-all duration-300 hover:scale-105 hover:shadow-2xl">
                            <div
                                class="absolute top-1 right-1 sm:top-2 sm:right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <i class="fas fa-arrow-right text-[8px] sm:text-xs"></i>
                            </div>
                            <div class="flex items-center gap-1.5 sm:gap-2 md:gap-3">
                                <div class="bg-white/20 rounded-lg p-1.5 sm:p-2">
                                    <i class="fas fa-chalkboard text-xs sm:text-sm md:text-base"></i>
                                </div>
                                <div>
                                    <span class="font-bold text-xs sm:text-sm md:text-base">Ens.-Mat.</span>
                                    <p class="text-cyan-100 text-[8px] sm:text-[9px] md:text-xs mt-0.5">Lier</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Recent Inscriptions Table -->
            <div
                class="bg-white/80 backdrop-blur-sm rounded-xl sm:rounded-2xl md:rounded-3xl shadow-xl overflow-hidden animate-in delay-600 border border-white/50">
                <div
                    class="bg-gradient-to-r from-indigo-600 to-purple-600 px-3 sm:px-4 md:px-5 lg:px-6 py-2.5 sm:py-3 md:py-4 lg:py-5">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2">
                        <div class="flex items-center gap-1.5 sm:gap-2 md:gap-3">
                            <div class="bg-white/20 rounded-lg p-1.5 sm:p-2 md:p-2.5">
                                <i class="fas fa-history text-white text-xs sm:text-sm md:text-base"></i>
                            </div>
                            <div>
                                <h3 class="text-sm sm:text-base md:text-lg font-bold text-white">Inscriptions récentes</h3>
                                <p class="text-indigo-100 text-[10px] hidden sm:block">Les 5 dernières inscriptions</p>
                            </div>
                        </div>
                        <a href="{{ route('admin.inscriptions.index') }}"
                            class="px-2 py-1 sm:px-3 sm:py-1.5 md:px-4 md:py-2 bg-white/20 hover:bg-white/30 rounded-lg text-white text-[10px] sm:text-xs md:text-sm font-medium transition-all duration-200 flex items-center gap-1">
                            <span class="hidden sm:inline">Voir tout</span>
                            <i class="fas fa-arrow-right text-[8px] sm:text-xs"></i>
                        </a>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="bg-gradient-to-r from-gray-50 to-gray-100">
                                <th
                                    class="px-2 sm:px-3 md:px-4 lg:px-6 py-2 sm:py-2.5 md:py-3 text-left text-[9px] sm:text-[10px] md:text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    <div class="flex items-center gap-1">
                                        <i class="fas fa-user text-indigo-500 text-[8px] sm:text-[9px] md:text-xs"></i>
                                        Élève
                                    </div>
                                </th>
                                <th
                                    class="px-2 sm:px-3 md:px-4 lg:px-6 py-2 sm:py-2.5 md:py-3 text-left text-[9px] sm:text-[10px] md:text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    <div class="flex items-center gap-1">
                                        <i class="fas fa-school text-indigo-500 text-[8px] sm:text-[9px] md:text-xs"></i>
                                        Classe
                                    </div>
                                </th>
                                <th
                                    class="px-2 sm:px-3 md:px-4 lg:px-6 py-2 sm:py-2.5 md:py-3 text-left text-[9px] sm:text-[10px] md:text-xs font-semibold text-gray-600 uppercase tracking-wider hidden sm:table-cell">
                                    <div class="flex items-center gap-1">
                                        <i class="fas fa-calendar text-indigo-500 text-[8px] sm:text-[9px] md:text-xs"></i>
                                        Date
                                    </div>
                                </th>
                                <th
                                    class="px-2 sm:px-3 md:px-4 lg:px-6 py-2 sm:py-2.5 md:py-3 text-left text-[9px] sm:text-[10px] md:text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    <div class="flex items-center gap-1">
                                        <i class="fas fa-circle text-indigo-500 text-[8px] sm:text-[9px] md:text-xs"></i>
                                        Statut
                                    </div>
                                </th>
                                <th
                                    class="px-2 sm:px-3 md:px-4 lg:px-6 py-2 sm:py-2.5 md:py-3 text-right text-[9px] sm:text-[10px] md:text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse(\App\Models\Inscription::with(['eleve', 'classe'])->latest()->take(5)->get() as $inscription)
                                <tr class="table-row hover:bg-indigo-50/50 transition-all duration-200">
                                    <td class="px-2 sm:px-3 md:px-4 lg:px-6 py-2 sm:py-2.5 md:py-3 whitespace-nowrap">
                                        <div class="flex items-center gap-1.5 sm:gap-2 md:gap-3">
                                            <div
                                                class="w-6 h-6 sm:w-7 sm:h-7 md:w-8 md:h-8 lg:w-10 lg:h-10 rounded-full bg-gradient-to-br from-indigo-100 to-indigo-200 flex items-center justify-center flex-shrink-0">
                                                <span
                                                    class="text-indigo-700 font-semibold text-[8px] sm:text-[9px] md:text-xs lg:text-sm">
                                                    {{ strtoupper(substr($inscription->eleve->prenom ?? '', 0, 1)) }}{{ strtoupper(substr($inscription->eleve->nom ?? '', 0, 1)) }}
                                                </span>
                                            </div>
                                            <div class="min-w-0">
                                                <div
                                                    class="text-[10px] sm:text-xs md:text-sm font-semibold text-gray-900 truncate max-w-[80px] sm:max-w-none">
                                                    {{ $inscription->eleve->nom ?? '' }} {{ $inscription->eleve->prenom ?? '' }}
                                                </div>
                                                <div class="text-[8px] sm:text-[9px] md:text-xs text-gray-500">
                                                    ID: {{ $inscription->eleve->id ?? 'N/A' }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-2 sm:px-3 md:px-4 lg:px-6 py-2 sm:py-2.5 md:py-3 whitespace-nowrap">
                                        <div class="flex items-center gap-1">
                                            <div
                                                class="w-4 h-4 sm:w-5 sm:h-5 rounded-lg bg-indigo-100 flex items-center justify-center flex-shrink-0">
                                                <i
                                                    class="fas fa-school text-[6px] sm:text-[7px] md:text-xs text-indigo-600"></i>
                                            </div>
                                            <span
                                                class="text-[10px] sm:text-xs md:text-sm text-gray-700 truncate max-w-[60px] sm:max-w-none">{{ $inscription->classe->nom ?? 'N/A' }}</span>
                                        </div>
                                    </td>
                                    <td
                                        class="px-2 sm:px-3 md:px-4 lg:px-6 py-2 sm:py-2.5 md:py-3 whitespace-nowrap hidden sm:table-cell">
                                        <div class="flex items-center gap-1">
                                            <i
                                                class="far fa-calendar-alt text-gray-400 text-[8px] sm:text-[9px] md:text-xs"></i>
                                            <span
                                                class="text-[10px] sm:text-xs md:text-sm text-gray-600">{{ $inscription->date_inscription->format('d/m/Y') }}</span>
                                        </div>
                                    </td>
                                    <td class="px-2 sm:px-3 md:px-4 lg:px-6 py-2 sm:py-2.5 md:py-3 whitespace-nowrap">
                                        @if($inscription->statut)
                                            <span
                                                class="badge badge-success text-[8px] sm:text-[9px] md:text-xs py-0.5 px-1.5 sm:py-1 sm:px-2">
                                                <i class="fas fa-check-circle mr-0.5 text-[6px] sm:text-[7px] md:text-xs"></i>
                                                Actif
                                            </span>
                                        @else
                                            <span
                                                class="badge badge-danger text-[8px] sm:text-[9px] md:text-xs py-0.5 px-1.5 sm:py-1 sm:px-2">
                                                <i class="fas fa-times-circle mr-0.5 text-[6px] sm:text-[7px] md:text-xs"></i>
                                                Inactif
                                            </span>
                                        @endif
                                    </td>
                                    <td
                                        class="px-2 sm:px-3 md:px-4 lg:px-6 py-2 sm:py-2.5 md:py-3 whitespace-nowrap text-right">
                                        <a href="#"
                                            class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200 p-0.5 sm:p-1">
                                            <i class="fas fa-eye text-[10px] sm:text-xs md:text-sm"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-3 sm:px-4 md:px-6 py-6 sm:py-8 md:py-12">
                                        <div class="flex flex-col items-center justify-center gap-2 sm:gap-3">
                                            <div
                                                class="w-10 h-10 sm:w-12 sm:h-12 md:w-16 md:h-16 bg-gradient-to-br from-gray-100 to-gray-200 rounded-xl sm:rounded-2xl flex items-center justify-center">
                                                <i class="fas fa-inbox text-sm sm:text-base md:text-xl text-gray-400"></i>
                                            </div>
                                            <h4 class="text-xs sm:text-sm md:text-base font-semibold text-gray-700">Aucune
                                                inscription</h4>
                                            <p class="text-[10px] sm:text-xs text-gray-500 text-center">Les inscriptions
                                                récentes apparaîtront ici</p>
                                            <a href="{{ route('admin.inscriptions.create') }}"
                                                class="mt-1 sm:mt-2 px-2 py-1 sm:px-3 sm:py-1.5 md:px-4 md:py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white text-[9px] sm:text-xs md:text-sm font-medium rounded-lg sm:rounded-xl hover:shadow-lg transition-all duration-200">
                                                <i class="fas fa-plus-circle mr-1 text-[8px] sm:text-[9px]"></i>
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

            <!-- Footer Stats -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 sm:gap-3 md:gap-4 mt-4 sm:mt-5 md:mt-6 lg:mt-8">
                <div class="bg-white/80 backdrop-blur-sm rounded-lg sm:rounded-xl p-2 sm:p-3 md:p-4 border border-white/50">
                    <div class="flex items-center gap-2 sm:gap-3">
                        <div
                            class="w-6 h-6 sm:w-7 sm:h-7 md:w-8 md:h-8 lg:w-10 lg:h-10 bg-gradient-to-br from-indigo-100 to-indigo-200 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-chart-line text-indigo-600 text-[10px] sm:text-xs md:text-sm"></i>
                        </div>
                        <div>
                            <p class="text-[8px] sm:text-[9px] md:text-xs text-gray-500">Taux d'occupation</p>
                            <p class="text-xs sm:text-sm md:text-base lg:text-lg font-bold text-gray-800">78%</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white/80 backdrop-blur-sm rounded-lg sm:rounded-xl p-2 sm:p-3 md:p-4 border border-white/50">
                    <div class="flex items-center gap-2 sm:gap-3">
                        <div
                            class="w-6 h-6 sm:w-7 sm:h-7 md:w-8 md:h-8 lg:w-10 lg:h-10 bg-gradient-to-br from-green-100 to-green-200 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-check-circle text-green-600 text-[10px] sm:text-xs md:text-sm"></i>
                        </div>
                        <div>
                            <p class="text-[8px] sm:text-[9px] md:text-xs text-gray-500">Présence moyenne</p>
                            <p class="text-xs sm:text-sm md:text-base lg:text-lg font-bold text-gray-800">92%</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white/80 backdrop-blur-sm rounded-lg sm:rounded-xl p-2 sm:p-3 md:p-4 border border-white/50">
                    <div class="flex items-center gap-2 sm:gap-3">
                        <div
                            class="w-6 h-6 sm:w-7 sm:h-7 md:w-8 md:h-8 lg:w-10 lg:h-10 bg-gradient-to-br from-purple-100 to-purple-200 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-star text-purple-600 text-[10px] sm:text-xs md:text-sm"></i>
                        </div>
                        <div>
                            <p class="text-[8px] sm:text-[9px] md:text-xs text-gray-500">Moyenne générale</p>
                            <p class="text-xs sm:text-sm md:text-base lg:text-lg font-bold text-gray-800">14.5/20</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Font Awesome & Scripts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Animation des barres de progression
            const progressBars = document.querySelectorAll('.progress-bar');
            progressBars.forEach(bar => {
                const width = bar.style.width;
                bar.style.width = '0%';
                setTimeout(() => {
                    bar.style.width = width;
                }, 100);
            });

            // Animation au scroll
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate-in');
                    }
                });
            }, { threshold: 0.1 });

            document.querySelectorAll('.stat-card, .action-btn').forEach(el => {
                observer.observe(el);
            });
        });
    </script>
@endsection