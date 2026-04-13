<!DOCTYPE html>
<html lang="fr" style="scroll-behavior: smooth;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>

    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('image_icon/favicon-32x32.png') }}">

    <!-- Font Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            font-family: 'Inter', sans-serif;
            transition-property: background-color, color, border-color, box-shadow, transform, opacity;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 0.3s;
        }

        :root {
            --bg-primary: #0a1929;
            --bg-secondary: #132f4c;
            --bg-tertiary: #0f1a2b;
            --bg-card: #1a2b3e;
            --bg-footer: #050f1a;
            --text-primary: #ffffff;
            --text-secondary: #b0c4de;
            --accent: #1e4a7a;
            --border-color: #2d4b6e;
            --gradient-start: #1e4a7a;
            --gradient-end: #0a1929;
        }

        [data-theme="light"] {
            --bg-primary: #f0f7ff;
            --bg-secondary: #ffffff;
            --bg-tertiary: #e6f0fa;
            --bg-card: #ffffff;
            --bg-footer: #e0eaf5;
            --text-primary: #0a1929;
            --text-secondary: #334155;
            --accent: #1e4a7a;
            --border-color: #cbd5e1;
            --gradient-start: #3b82f6;
            --gradient-end: #1e4a7a;
        }

        body { background-color: var(--bg-primary); color: var(--text-primary); overflow-x: hidden; }
        .bg-primary { background-color: var(--bg-primary); }
        .bg-secondary { background-color: var(--bg-secondary); }
        .bg-tertiary { background-color: var(--bg-tertiary); }
        .bg-card { background-color: var(--bg-card); }
        .bg-footer { background-color: var(--bg-footer); }
        .text-primary { color: var(--text-primary); }
        .text-secondary { color: var(--text-secondary); }
        .border-custom { border-color: var(--border-color); }

        .gradient-bg { background: linear-gradient(135deg, var(--gradient-start) 0%, var(--gradient-end) 100%); }
        .gradient-text {
            background: linear-gradient(135deg, #60a5fa 0%, #3b82f6 100%);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
        }

        .hover-scale { transition: transform 0.4s cubic-bezier(0.2, 0.8, 0.2, 1), box-shadow 0.4s ease; }
        .hover-scale:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        .animate-float { animation: float 6s ease-in-out infinite; }
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(1deg); }
        }

        .blob {
            animation: blob-move 20s infinite alternate;
            mix-blend-mode: screen;
        }
        @keyframes blob-move {
            0% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0, 0) scale(1); }
        }
        .blob:nth-child(2) { animation-delay: -5s; animation-duration: 25s; }

        .reveal {
            opacity: 0;
            transform: translateY(50px);
            transition: all 1s cubic-bezier(0.2, 0.8, 0.2, 1);
        }
        .reveal.active { opacity: 1; transform: translateY(0); }

        .nav-link {
            position: relative;
            padding-bottom: 4px;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 50%;
            background: linear-gradient(90deg, #3b82f6, #60a5fa);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }
        .nav-link:hover::after { width: 100%; }

        .btn-press:active { transform: scale(0.95) !important; }

        #progress-bar {
            position: fixed; top: 0; left: 0; height: 4px;
            background: linear-gradient(90deg, #3b82f6, #60a5fa); z-index: 9999; width: 0%; transition: width 0.1s linear;
        }

        .glass-effect {
            background: rgba(30, 74, 122, 0.3); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        [data-theme="light"] .glass-effect { background: rgba(255, 255, 255, 0.7); border: 1px solid rgba(0, 0, 0, 0.1); }

        .nav-blur { background: rgba(10, 25, 41, 0.85); backdrop-filter: blur(10px); }
        [data-theme="light"] .nav-blur { background: rgba(255, 255, 255, 0.85); }

        .theme-toggle { cursor: pointer; padding: 8px; border-radius: 50%; background: var(--bg-card); border: 1px solid var(--border-color); color: var(--text-primary); }

        .mobile-menu { transform: translateX(100%); transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1); }
        .mobile-menu.open { transform: translateX(0); }

        .video-modal {
            display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.0); z-index: 10000; justify-content: center; align-items: center;
            opacity: 0; transition: all 0.4s ease;
            backdrop-filter: blur(10px);
        }
        .video-modal.active { display: flex; opacity: 1; background: rgba(0,0,0,0.9); }
        .video-container {
            position: relative; width: 90%; max-width: 1000px;
            aspect-ratio: 16/9;
            transform: scale(0.8) translateY(50px);
            transition: transform 0.5s cubic-bezier(0.2, 0.8, 0.2, 1);
        }
        .video-modal.active .video-container { transform: scale(1) translateY(0); }
        .video-container.vertical {
            width: auto; max-width: 380px; height: 90%; max-height: 680px;
            aspect-ratio: 9/16;
        }
        .video-container iframe { width: 100%; height: 100%; border-radius: 16px; }
        .close-modal {
            position: absolute; top: -50px; right: 0; color: white; font-size: 35px; cursor: pointer; z-index: 10;
            opacity: 0.5; transition: opacity 0.2s, transform 0.2s;
        }
        .close-modal:hover { opacity: 1; transform: rotate(90deg); }

        .play-btn-wrapper {
            position: absolute; inset: 0;
            display: flex; align-items: center; justify-content: center;
            background: rgba(0, 0, 0, 0.3);
            transition: background 0.3s ease;
        }
        .play-btn-circle {
            width: 80px; height: 80px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(12px);
            border: 2px solid rgba(255, 255, 255, 0.4);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
            transition: all 0.4s cubic-bezier(0.2, 0.8, 0.2, 1);
            cursor: pointer;
            transform: scale(0.9);
        }
        .video-card:hover .play-btn-circle {
            transform: scale(1);
            background: rgba(255, 255, 255, 0.95);
            border-color: transparent;
            box-shadow: 0 15px 40px rgba(59, 130, 246, 0.5);
        }
        .video-card:hover .play-btn-circle svg {
            color: #3b82f6;
            filter: drop-shadow(0 0 10px rgba(59, 130, 246, 0.5));
        }
        .play-btn-circle svg {
            width: 35px; height: 35px;
            color: white;
            margin-left: 5px;
            transition: color 0.3s ease;
        }
    </style>
</head>
<body class="bg-primary text-primary">

    <!-- Progress Bar -->
    <div id="progress-bar"></div>

    <!-- Video Modal -->
    <div id="video-modal" class="video-modal" onclick="closeVideoModal(event)">
        <div id="video-container" class="video-container" onclick="event.stopPropagation()">
            <span class="close-modal" onclick="closeVideoModal(event)">&times;</span>
            <iframe id="video-frame" src="" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="fixed z-50 w-full border-b border-transparent nav-blur" id="navbar">
        <div class="container px-6 py-4 mx-auto">
            <div class="flex items-center justify-between">
                <a href="/" class="flex items-center space-x-3 group">
                    <div class="flex items-center justify-center w-10 h-10 text-xl font-bold text-white transition-transform duration-300 rounded-lg gradient-bg group-hover:scale-110">GP</div>
                    <span class="text-2xl font-bold gradient-text">GEST'PARC</span>
                </a>

                <div class="items-center hidden space-x-8 md:flex">
                    <a href="#features" class="font-medium transition-colors text-secondary hover:text-blue-400 nav-link">Fonctionnalités</a>
                    <a href="#gallery" class="font-medium transition-colors text-secondary hover:text-blue-400 nav-link">Galerie</a>
                    <a href="#events" class="font-medium transition-colors text-secondary hover:text-blue-400 nav-link">Vie Scolaire</a>

                    <button onclick="toggleTheme()" class="theme-toggle" aria-label="Changer le thème">
                        <svg class="hidden w-5 h-5 theme-icon-light" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"/></svg>
                        <svg class="w-5 h-5 theme-icon-dark" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"/></svg>
                    </button>

                    <!-- ✅ Bouton Inscription supprimé -->
                    <a href="/login" class="font-semibold text-blue-500 transition-colors hover:text-blue-400 btn-press">Connexion</a>
                </div>

                <button id="mobile-menu-btn" class="md:hidden text-secondary focus:outline-none" aria-label="Menu">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
            </div>
        </div>

        <!-- Overlay sombre du menu mobile -->
        <div id="mobile-menu-overlay" class="fixed inset-0 z-40 hidden bg-black/50 backdrop-blur-sm transition-opacity opacity-0 md:hidden"></div>

        <div id="mobile-menu" class="fixed top-0 right-0 z-50 w-64 h-full shadow-2xl mobile-menu bg-card md:hidden">
            <div class="p-6 h-full flex flex-col">
                <div class="flex items-center justify-between mb-8">
                    <button onclick="toggleTheme()" class="theme-toggle" aria-label="Changer le thème">
                        <svg class="hidden w-5 h-5 theme-icon-light" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"/></svg>
                        <svg class="w-5 h-5 theme-icon-dark" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"/></svg>
                    </button>
                    <button id="mobile-menu-close" class="text-secondary p-2 -mr-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <div class="flex flex-col space-y-6 flex-1">
                    <a href="#features" class="text-lg font-medium text-primary hover:text-blue-400 mobile-nav-link">Fonctionnalités</a>
                    <a href="#gallery" class="text-lg font-medium text-primary hover:text-blue-400 mobile-nav-link">Galerie</a>
                    <a href="#events" class="text-lg font-medium text-primary hover:text-blue-400 mobile-nav-link">Vie Scolaire</a>
                    <hr class="border-custom">
                    <a href="/login" class="text-lg font-semibold text-blue-500 text-center border-2 border-blue-500 py-2 rounded-full">Connexion</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="hero-section" class="relative flex items-center min-h-screen pt-24 pb-16 overflow-hidden bg-primary">
        <div class="absolute top-0 left-0 w-full h-full pointer-events-none opacity-30">
            <div class="absolute bg-blue-500 rounded-full top-1/4 left-1/4 w-96 h-96 filter blur-3xl blob"></div>
            <div class="absolute bg-purple-500 rounded-full bottom-1/4 right-1/4 w-96 h-96 filter blur-3xl blob"></div>
        </div>

        <div class="container relative z-10 px-6 mx-auto">
            <div class="grid items-center gap-12 md:grid-cols-2">
                <div class="text-center md:text-left">
                    <span class="inline-block px-4 py-2 mb-6 text-sm font-semibold text-blue-400 border border-blue-800 rounded-full reveal bg-blue-900/20 bg-card">La nouvelle génération de GEST'PARC</span>
                    <h1 class="mb-6 text-4xl font-extrabold leading-tight reveal text-primary md:text-5xl lg:text-6xl">
                        Simplifiez la gestion de votre
                        <span class="block gradient-text">établissement scolaire</span>
                    </h1>
                    <p class="max-w-2xl mb-8 text-xl reveal text-secondary">Une plateforme tout-en-un pour gérer élèves, enseignants, notes, absences et communications. Gagnez en efficacité et en sérénité.</p>

                    <div class="flex flex-col justify-center gap-4 reveal sm:flex-row md:justify-start">
                        <a href="/login" class="px-8 py-4 text-lg font-semibold text-blue-400 border-2 border-blue-700 rounded-full bg-card hover:bg-secondary hover-scale btn-press">Se connecter</a>
                    </div>

                    <div class="grid grid-cols-2 gap-6 mt-12 reveal sm:grid-cols-4">
                        <div class="p-4 text-center bg-opacity-50 rounded-xl bg-card hover-scale"><div class="text-3xl font-extrabold gradient-text counter" data-target="500">0</div><div class="text-secondary">Établissements</div></div>
                        <div class="p-4 text-center bg-opacity-50 rounded-xl bg-card hover-scale"><div class="text-3xl font-extrabold gradient-text counter" data-target="50000">0</div><div class="text-secondary">Élèves</div></div>
                        <div class="p-4 text-center bg-opacity-50 rounded-xl bg-card hover-scale"><div class="text-3xl font-extrabold gradient-text counter" data-target="5000">0</div><div class="text-secondary">Enseignants</div></div>
                        <div class="p-4 text-center bg-opacity-50 rounded-xl bg-card hover-scale"><div class="text-3xl font-extrabold gradient-text"><span class="counter" data-target="98">0</span>%</div><div class="text-secondary">Satisfaction</div></div>
                    </div>
                </div>

                <div class="relative hidden animate-float md:block">
                    <img src="https://z-cdn-media.chatglm.cn/files/e3aa25f2-e8b5-4f2b-b0eb-91de46d0356d.png?auth_key=1872452342-565ef1ac57c64c5b89f655037e44b1f4-0-015fbe66ba00a7e5c676685f36201a7c" alt="Dashboard Administrateur" class="w-full border shadow-2xl border-custom rounded-2xl">
                    <div class="absolute p-4 border shadow-xl -bottom-6 -left-6 rounded-xl glass-effect border-custom animate-pulse-slow">
                        <div class="flex items-center space-x-3">
                            <div class="flex items-center justify-center w-10 h-10 bg-green-500 rounded-full bg-opacity-20"><svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
                            <div><p class="text-sm text-secondary">Taux de réussite</p><p class="text-xl font-bold text-primary">92%</p></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-tertiary">
        <div class="container px-6 mx-auto">
            <div class="max-w-3xl mx-auto mb-16 text-center">
                <span class="inline-block px-4 py-2 mb-4 text-sm font-semibold text-blue-400 border border-blue-800 rounded-full reveal bg-card">Fonctionnalités</span>
                <h2 class="mb-4 text-4xl font-bold reveal text-primary">Tout ce dont vous avez besoin</h2>
                <p class="text-xl reveal text-secondary">Une solution complète et intuitive pour une gestion scolaire sans stress</p>
            </div>
            <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-4">
                <div class="p-8 border shadow-xl reveal bg-card rounded-2xl hover-scale border-custom">
                    <div class="flex items-center justify-center w-16 h-16 mb-6 text-white gradient-bg rounded-xl"><svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg></div>
                    <h3 class="mb-3 text-xl font-bold text-primary">Gestion multi-utilisateurs</h3>
                    <p class="text-secondary">Administrateurs, enseignants, élèves et parents avec rôles personnalisés.</p>
                </div>
                <div class="p-8 border shadow-xl reveal bg-card rounded-2xl hover-scale border-custom" style="transition-delay: 100ms;">
                    <div class="flex items-center justify-center w-16 h-16 mb-6 text-white gradient-bg rounded-xl"><svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg></div>
                    <h3 class="mb-3 text-xl font-bold text-primary">Notes & évaluations</h3>
                    <p class="text-secondary">Saisie simplifiée des notes et génération automatique de bulletins.</p>
                </div>
                <div class="p-8 border shadow-xl reveal bg-card rounded-2xl hover-scale border-custom" style="transition-delay: 200ms;">
                    <div class="flex items-center justify-center w-16 h-16 mb-6 text-white gradient-bg rounded-xl"><svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
                    <h3 class="mb-3 text-xl font-bold text-primary">Absences & retards</h3>
                    <p class="text-secondary">Suivi en temps réel et notifications automatiques aux parents.</p>
                </div>
                <div class="p-8 border shadow-xl reveal bg-card rounded-2xl hover-scale border-custom" style="transition-delay: 300ms;">
                    <div class="flex items-center justify-center w-16 h-16 mb-6 text-white gradient-bg rounded-xl"><svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg></div>
                    <h3 class="mb-3 text-xl font-bold text-primary">Emploi du temps</h3>
                    <p class="text-secondary">Planification intuitive et visualisation interactive.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section id="gallery" class="py-20 bg-primary">
        <div class="container px-6 mx-auto">
            <div class="max-w-3xl mx-auto mb-16 text-center">
                <span class="inline-block px-4 py-2 mb-4 text-sm font-semibold text-blue-400 border border-blue-800 rounded-full reveal bg-card">Galerie Média</span>
                <h2 class="mb-4 text-4xl font-bold reveal text-primary">Découvrez l'interface</h2>
                <p class="text-xl reveal text-secondary">Une immersion visuelle dans notre solution</p>
            </div>

            <div class="mb-16">
                <h3 class="mb-8 text-2xl font-bold text-center reveal text-primary">🎥 Nos vidéos Shorts</h3>
                <div class="grid gap-8 md:grid-cols-3">
                    <div class="overflow-hidden border shadow-xl cursor-pointer reveal bg-card rounded-2xl border-custom video-card group" onclick="openVideoModal('https://www.youtube.com/embed/cbLNO5F_qEA', true)">
                        <div class="relative h-48 overflow-hidden">
                            <img src="https://z-cdn-media.chatglm.cn/files/0dbd00d1-3c61-4d77-af4a-2f6e55747034.png?auth_key=1872452342-3e05c2e559124b7188c0b8db591bd925-0-cc2c251edfd9b7816544d0321160baa9" alt="Espace Élève" class="object-cover w-full h-full transition-transform duration-700 group-hover:scale-110">
                            <div class="play-btn-wrapper">
                                <div class="play-btn-circle">
                                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
                                </div>
                            </div>
                        </div>
                        <div class="p-5">
                            <h4 class="font-bold text-primary">Espace Élève</h4>
                            <p class="mt-1 text-sm text-secondary">Suivi des notes et performance.</p>
                        </div>
                    </div>

                    <div class="overflow-hidden border shadow-xl cursor-pointer reveal bg-card rounded-2xl border-custom video-card group" style="transition-delay: 100ms;" onclick="openVideoModal('https://www.youtube.com/embed/vSec9iueOZw', true)">
                        <div class="relative h-48 overflow-hidden">
                            <img src="https://z-cdn-media.chatglm.cn/files/ed746af5-b175-491c-85ad-47388256bd16.png?auth_key=1872452342-5d66e8c660bc4ebdb51a5fdb4751a074-0-414238cb599d65d540b8a65aa59b4c51" alt="Emploi du temps" class="object-cover w-full h-full transition-transform duration-700 group-hover:scale-110">
                            <div class="play-btn-wrapper">
                                <div class="play-btn-circle">
                                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
                                </div>
                            </div>
                        </div>
                        <div class="p-5">
                            <h4 class="font-bold text-primary">Emploi du temps</h4>
                            <p class="mt-1 text-sm text-secondary">Planning hebdomadaire clair.</p>
                        </div>
                    </div>

                    <div class="overflow-hidden border shadow-xl cursor-pointer reveal bg-card rounded-2xl border-custom video-card group" style="transition-delay: 200ms;" onclick="openVideoModal('https://www.youtube.com/embed/yOzMExB8omo', true)">
                        <div class="relative h-48 overflow-hidden">
                            <img src="https://z-cdn-media.chatglm.cn/files/8a6eb535-304e-47f7-b4ba-4308e2293df2.png?auth_key=1872452342-89a8cef1b00943098d12fe4462ee72f2-0-b20b5a178af899a913c363dc315f9479" alt="Gestion Classe" class="object-cover w-full h-full transition-transform duration-700 group-hover:scale-110">
                            <div class="play-btn-wrapper">
                                <div class="play-btn-circle">
                                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
                                </div>
                            </div>
                        </div>
                        <div class="p-5">
                            <h4 class="font-bold text-primary">Gestion des Classes</h4>
                            <p class="mt-1 text-sm text-secondary">Liste élèves et détails.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Image Gallery Grid -->
            <div class="grid grid-cols-2 gap-4 md:grid-cols-3">
                <div class="overflow-hidden border reveal bg-card rounded-xl border-custom hover-scale">
                    <img src="https://z-cdn-media.chatglm.cn/files/8c3f2055-82b8-4092-84ce-3dafe403389e.png?auth_key=1872452342-5bb2414987f242c7a2abdb0536c8f6b7-0-23994bfed0ce52445e4b4a2db22e15fe" alt="Espace Enseignant" class="object-cover w-full h-48">
                    <div class="p-4"><h4 class="font-bold text-primary">Espace Enseignant</h4><p class="text-sm text-secondary">Vue rapide et outils</p></div>
                </div>
                <div class="overflow-hidden border reveal bg-card rounded-xl border-custom hover-scale" style="transition-delay: 100ms;">
                    <img src="https://z-cdn-media.chatglm.cn/files/91eb2432-ef46-498c-9148-ce4e5e505b0c.png?auth_key=1872452342-1d4268395696414299cfdfef68a05723-0-fccce8e0a6734c9666e96f77f463fe68" alt="Statistiques" class="object-cover w-full h-48">
                    <div class="p-4"><h4 class="font-bold text-primary">Statistiques</h4><p class="text-sm text-secondary">Graphiques et analyses</p></div>
                </div>
                <div class="overflow-hidden border reveal bg-card rounded-xl border-custom hover-scale" style="transition-delay: 200ms;">
                    <img src="https://z-cdn-media.chatglm.cn/files/2e610a11-80f8-4e4f-8224-52ea4afc3ca5.png?auth_key=1872452342-26b7f559ab154109b5b64cbfe9401504-0-06b805b21f29e54e71ba9870e389997c" alt="Dashboard Enseignant" class="object-cover w-full h-48">
                    <div class="p-4"><h4 class="font-bold text-primary">Tableau de bord</h4><p class="text-sm text-secondary">Dernières notes saisies</p></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Events Section -->
    <section id="events" class="py-20 bg-tertiary">
        <div class="container px-6 mx-auto">
            <div class="max-w-3xl mx-auto mb-16 text-center">
                <span class="inline-block px-4 py-2 mb-4 text-sm font-semibold text-blue-400 border border-blue-800 rounded-full reveal bg-card">Vie Scolaire</span>
                <h2 class="mb-4 text-4xl font-bold reveal text-primary">Actualités & Événements</h2>
                <p class="text-xl reveal text-secondary">Suivez en temps réel la vie de votre établissement</p>
            </div>
            <div class="grid gap-8 lg:grid-cols-3">
                <div class="lg:col-span-2">
                    <h3 class="mb-6 text-2xl font-bold text-primary reveal">Prochains Événements</h3>
                    <div class="space-y-4">
                        <div class="flex items-center p-4 space-x-4 border cursor-pointer reveal bg-card rounded-xl border-custom hover-scale group">
                            <div class="text-center bg-blue-600 rounded-lg p-3 text-white min-w-[70px] transition-transform duration-300 group-hover:scale-110"><span class="block text-2xl font-bold">15</span><span class="block text-xs uppercase">Mai</span></div>
                            <div><h4 class="font-bold text-primary">Réunion Parents-Professeurs</h4><p class="text-sm text-secondary">De 14h00 à 18h00 - Salle polyvalente</p></div>
                            <span class="px-2 py-1 ml-auto text-xs font-semibold text-black bg-yellow-500 rounded-full">Important</span>
                        </div>
                        <div class="flex items-center p-4 space-x-4 border cursor-pointer reveal bg-card rounded-xl border-custom hover-scale group" style="transition-delay: 100ms;">
                            <div class="text-center bg-secondary rounded-lg p-3 text-white min-w-[70px] transition-transform duration-300 group-hover:scale-110"><span class="block text-2xl font-bold">22</span><span class="block text-xs uppercase">Mai</span></div>
                            <div><h4 class="font-bold text-primary">Conseil de Classe</h4><p class="text-sm text-secondary">De 10h00 à 12h00 - Administration</p></div>
                        </div>
                        <div class="flex items-center p-4 space-x-4 border cursor-pointer reveal bg-card rounded-xl border-custom hover-scale group" style="transition-delay: 200ms;">
                            <div class="text-center bg-green-600 rounded-lg p-3 text-white min-w-[70px] transition-transform duration-300 group-hover:scale-110"><span class="block text-2xl font-bold">05</span><span class="block text-xs uppercase">Juin</span></div>
                            <div><h4 class="font-bold text-primary">Journée Sportive</h4><p class="text-sm text-secondary">Toute la journée - Stade Municipal</p></div>
                            <span class="px-2 py-1 ml-auto text-xs font-semibold text-black bg-green-500 rounded-full">Sport</span>
                        </div>
                    </div>
                </div>
                <div>
                    <h3 class="mb-6 text-2xl font-bold text-primary reveal">Dernières Infos</h3>
                    <div class="space-y-4">
                        <div class="overflow-hidden border reveal bg-card rounded-xl border-custom hover-scale">
                            <img src="https://z-cdn-media.chatglm.cn/files/8a6eb535-304e-47f7-b4ba-4308e2293df2.png?auth_key=1872452342-89a8cef1b00943098d12fe4462ee72f2-0-b20b5a178af899a913c363dc315f9479" alt="Infos Classe" class="object-cover w-full h-32">
                            <div class="p-4"><span class="text-xs font-semibold text-blue-400">Administration</span><h4 class="mt-1 font-bold text-primary">Inscriptions 2025-2026 ouvertes</h4><p class="mt-2 text-sm text-secondary">Les dossiers sont à retirer au secrétariat...</p></div>
                        </div>
                        <div class="p-4 border reveal bg-card rounded-xl border-custom hover-scale" style="transition-delay: 100ms;">
                            <span class="text-xs font-semibold text-green-400">Résultats</span><h4 class="mt-1 font-bold text-primary">Résultats du 2ème Trimestre</h4><p class="mt-1 text-sm text-secondary">Consultables sur l'espace parent.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="relative py-20 overflow-hidden gradient-bg">
        <div class="absolute top-0 left-0 w-full h-full pointer-events-none opacity-10">
            <div class="absolute w-64 h-64 bg-white rounded-full -top-20 -left-20 animate-pulse"></div>
            <div class="absolute bg-white rounded-full -bottom-20 -right-20 w-96 h-96 animate-pulse" style="animation-delay: 1s;"></div>
        </div>
        <div class="container relative z-10 px-6 mx-auto text-center">
            <h2 class="mb-6 text-4xl font-bold text-white reveal">Accédez à votre espace en toute sécurité</h2>
            <p class="mb-10 text-xl text-blue-100 reveal">Connectez-vous pour gérer élèves, enseignants et parents en un seul endroit</p>
            <!-- ✅ "Commencer gratuitement" remplacé par "Se connecter" -->
            <a href="/login" class="inline-flex items-center px-8 py-4 text-lg font-semibold text-blue-900 transition-all bg-white rounded-full shadow-xl reveal hover:opacity-90 hover-scale btn-press">
                Se connecter
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="pt-12 pb-8 border-t bg-footer text-primary border-custom">
        <div class="container px-6 mx-auto">
            <div class="flex flex-col items-center justify-between gap-8 md:flex-row">
                <div class="flex flex-col items-center md:items-start">
                    <a href="/" class="flex items-center mb-2 space-x-3 group">
                        <div class="flex items-center justify-center w-10 h-10 text-xl font-bold text-white transition-transform duration-300 rounded-lg gradient-bg group-hover:scale-110">GP</div>
                        <span class="text-2xl font-bold gradient-text">GEST'PARC</span>
                    </a>
                    <p class="max-w-xs text-sm text-center text-secondary md:text-left">
                        La plateforme de gestion scolaire qui simplifie le quotidien des établissements.
                    </p>
                </div>

                <div class="flex space-x-6">
                    <a href="#" class="transition-all duration-300 text-secondary hover:text-blue-500 hover:scale-125">
                        <span class="sr-only">Facebook</span>
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd"/>
                        </svg>
                    </a>
                    <a href="#" class="transition-all duration-300 text-secondary hover:text-blue-400 hover:scale-125">
                        <span class="sr-only">LinkedIn</span>
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                        </svg>
                    </a>
                    <a href="#" class="transition-all duration-300 text-secondary hover:text-white hover:scale-125">
                        <span class="sr-only">TikTok</span>
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/>
                        </svg>
                    </a>
                </div>
            </div>

            <div class="pt-8 mt-8 text-center border-t border-custom">
                <p class="text-sm text-secondary">
                    &copy; <span id="current-year"></span> GEST'PARC. Tous droits réservés.
                </p>
            </div>
        </div>
    </footer>

<script>
    document.getElementById('current-year').textContent = new Date().getFullYear();

    function setTheme(theme) {
        document.documentElement.setAttribute('data-theme', theme);
        localStorage.setItem('theme', theme);
        const lightIcons = document.querySelectorAll('.theme-icon-light');
        const darkIcons = document.querySelectorAll('.theme-icon-dark');
        if (theme === 'light') {
            lightIcons.forEach(icon => icon.classList.remove('hidden'));
            darkIcons.forEach(icon => icon.classList.add('hidden'));
        } else {
            lightIcons.forEach(icon => icon.classList.add('hidden'));
            darkIcons.forEach(icon => icon.classList.remove('hidden'));
        }
    }
    function toggleTheme() {
        const currentTheme = document.documentElement.getAttribute('data-theme');
        setTheme(currentTheme === 'light' ? 'dark' : 'light');
    }
    const savedTheme = localStorage.getItem('theme') || 'dark';
    setTheme(savedTheme);

    const mobileBtn = document.getElementById('mobile-menu-btn');
    const mobileClose = document.getElementById('mobile-menu-close');
    const mobileMenu = document.getElementById('mobile-menu');
    const mobileOverlay = document.getElementById('mobile-menu-overlay');

    function openMobileMenu() {
        mobileMenu.classList.add('open');
        mobileOverlay.classList.remove('hidden');
        setTimeout(() => mobileOverlay.classList.remove('opacity-0'), 10);
        document.body.style.overflow = 'hidden';
    }
    function closeMobileMenu() {
        mobileMenu.classList.remove('open');
        mobileOverlay.classList.add('opacity-0');
        setTimeout(() => mobileOverlay.classList.add('hidden'), 300);
        document.body.style.overflow = '';
    }

    mobileBtn.addEventListener('click', openMobileMenu);
    mobileClose.addEventListener('click', closeMobileMenu);
    mobileOverlay.addEventListener('click', closeMobileMenu);
    document.querySelectorAll('.mobile-nav-link').forEach(link => {
        link.addEventListener('click', closeMobileMenu);
    });

    window.addEventListener('scroll', () => {
        const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
        const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        document.getElementById("progress-bar").style.width = (winScroll / height) * 100 + "%";
        const navbar = document.getElementById('navbar');
        if (window.scrollY > 50) navbar.classList.add('shadow-xl', 'border-custom');
        else navbar.classList.remove('shadow-xl', 'border-custom');
        const blobs = document.querySelectorAll('.blob');
        blobs.forEach((blob, index) => {
            const speed = (index + 1) * 0.1;
            blob.style.transform = `translateY(${winScroll * speed}px)`;
        });
    });

    function reveal() {
        document.querySelectorAll('.reveal').forEach(element => {
            const windowHeight = window.innerHeight;
            const elementTop = element.getBoundingClientRect().top;
            const elementVisible = 150;
            if (elementTop < windowHeight - elementVisible) {
                element.classList.add('active');
            }
        });
    }
    window.addEventListener('scroll', reveal);
    reveal();

    const counters = document.querySelectorAll('.counter');
    const observerOptions = { threshold: 0.5 };
    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const counter = entry.target;
                const target = +counter.getAttribute('data-target');
                const duration = 2000;
                let startTime = null;
                const animateCount = (currentTime) => {
                    if (!startTime) startTime = currentTime;
                    const progress = Math.min((currentTime - startTime) / duration, 1);
                    const easeOutQuad = progress * (2 - progress);
                    const currentCount = Math.floor(easeOutQuad * target);
                    counter.innerText = currentCount.toLocaleString('fr-FR');
                    if (progress < 1) requestAnimationFrame(animateCount);
                    else counter.innerText = target.toLocaleString('fr-FR');
                };
                requestAnimationFrame(animateCount);
                observer.unobserve(counter);
            }
        });
    }, observerOptions);
    counters.forEach(counter => observer.observe(counter));

    function openVideoModal(videoUrl, isShort = false) {
        const modal = document.getElementById('video-modal');
        const container = document.getElementById('video-container');
        const iframe = document.getElementById('video-frame');
        if(isShort) container.classList.add('vertical');
        else container.classList.remove('vertical');
        setTimeout(() => { iframe.src = videoUrl + "?autoplay=1"; }, 100);
        modal.classList.add('active');
    }

    function closeVideoModal(event) {
        if(event.target.id !== 'video-modal' && event.target.tagName !== 'SPAN' && event.target.tagName !== 'svg' && event.target.tagName !== 'path') return;
        const modal = document.getElementById('video-modal');
        const iframe = document.getElementById('video-frame');
        const container = document.getElementById('video-container');
        iframe.src = "";
        modal.classList.remove('active');
        container.classList.remove('vertical');
    }

    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            const target = document.querySelector(targetId);
            if (target) {
                const headerOffset = 80;
                const elementPosition = target.getBoundingClientRect().top;
                const offsetPosition = elementPosition + window.pageYOffset - headerOffset;
                window.scrollTo({ top: offsetPosition, behavior: "smooth" });
            }
        });
    });
</script>
</body>
</html>